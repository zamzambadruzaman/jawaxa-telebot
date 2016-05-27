<?php
/**
 * This file is part of the TelegramBot package.
 *
 * (c) Avtandil Kikabidze aka LONGMAN <akalongman@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Longman\TelegramBot\Commands\UserCommands;

use Longman\TelegramBot\Request;
use Longman\TelegramBot\Conversation;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\ForceReply;
use Longman\TelegramBot\Entities\ReplyKeyboardHide;
use Longman\TelegramBot\Entities\ReplyKeyboardMarkup;

/**
 * User "/survery" command
 */
class DaftarCommand extends UserCommand
{
    /**#@+
     * {@inheritdoc}
     */
    protected $name = 'daftar';
    protected $description = 'Daftar anggota Persis';
    protected $usage = '/daftar';
    protected $version = '0.2.0';
    protected $need_mysql = true;
    /**#@-*/

    /**
     * Conversation Object
     *
     * @var Longman\TelegramBot\Conversation
     */
    protected $conversation;

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $message = $this->getMessage();

        $chat = $message->getChat();
        $user = $message->getFrom();
        $text = $message->getText(true);

        $chat_id = $chat->getId();
        $user_id = $user->getId();

        //Preparing Respose
        $data = [];
        if ($chat->isGroupChat() || $chat->isSuperGroup()) {
            $data['chat_id'] = $chat_id;
            //reply to message id is applied by default
            //$data['reply_to_message_id'] = $message_id;
            //Force reply is applied by default to so can work with privacy on
            //$data['reply_markup'] = new ForceReply([ 'selective' => true]);
            $data['text'] = 'Perintah ini hanya untuk Private chat, silahkan daftar langsung secara personal ke @persisrobot';
            $result = Request::sendMessage($data) ;
            
        } else {
        $data['chat_id'] = $chat_id;

        //Conversation start
        $this->conversation = new Conversation($user_id, $chat_id, $this->getName());

        //cache data from the tracking session if any
        if (!isset($this->conversation->notes['state'])) {
            $state = '0';
        } else {
            $state = $this->conversation->notes['state'];
        }

        //state machine
        //entrypoint of the machine state if given by the track
        //Every time the step is achived the track is updated
        switch ($state) {
            case 0:
                if (empty($text)) {
                    $this->conversation->notes['state'] = 0;
                    $this->conversation->update();
    
                    $data['text'] = 'Nama Anggota :';
                    $data['reply_markup'] = new ReplyKeyBoardHide(['selective' => true]);
                    $result = Request::sendMessage($data);
                    break;
                }
                $this->conversation->notes['nama'] = $text;
                $text = '';
                // no break
            case 1:
                if (empty($text)) {
                    $this->conversation->notes['state'] = 1;
                    $this->conversation->update();
    
                    $data['text'] = 'NPA :';
                    $result = Request::sendMessage($data);
                    break;
                }
                $this->conversation->notes['NPA'] = $text;
                ++$state;
                $text = '';

                // no break
            case 2:
                if (empty($text) || !is_numeric($text)) {
                    $this->conversation->notes['state'] = 2;
                    $this->conversation->update();

                    $data['text'] = 'Umur :';
                    if (!empty($text) && !is_numeric($text)) {
                        $data['text'] = 'Umur harus berupa angka';
                    }
                    $result = Request::sendMessage($data);
                    break;
                }
                $this->conversation->notes['TTL'] = $text;
                $text = '';

                // no break
            case 3:
                if (empty($text) || !($text == 'L' || $text == 'P')) {
                    $this->conversation->notes['state'] = 3;
                    $this->conversation->update();

                    $keyboard = [['L','P']];
                    $reply_keyboard_markup = new ReplyKeyboardMarkup(
                        [
                            'keyboard' => $keyboard ,
                            'resize_keyboard' => true,
                            'one_time_keyboard' => true,
                            'selective' => true
                        ]
                    );
                    $data['reply_markup'] = $reply_keyboard_markup;
                    $data['text'] = 'Jenis kelamin:';
                    if (!empty($text) && !($text == 'L' || $text == 'P')) {
                        $data['text'] = 'Tentukan jenis kelamin anda, silahkan tekan tombol sesuai pilihan:';
                    }
                    $result = Request::sendMessage($data);
                    break;
                }
                $this->conversation->notes['gender'] = $text;
                $text = '';
           
                // no break
            case 4:
                if (empty($text)) {
                    $this->conversation->notes['state'] = 4;
                    $this->conversation->update();
    
                    $data['text'] = 'Alamat :';
                    $result = Request::sendMessage($data);
                    break;
                }
                $this->conversation->notes['alamat'] = $text;
                ++$state;
                $text = '';
                
                // no break
            case 5:
                if (is_null($message->getContact())) {
                    $this->conversation->notes['state'] = 5;
                    $this->conversation->update();

                    $data['text'] = 'Bagikan kontak anda :';
                    $data['reply_markup'] = new ReplyKeyboardMarkup([
                        'keyboard' => [[
                            [ 'text' => 'Bagikan kontak', 'request_contact' => true ],
                        ]],
                        'resize_keyboard'   => true,
                        'one_time_keyboard' => true,
                        'selective'         => true,
                    ]);
                    $result = Request::sendMessage($data);
                    break;
                }
                $this->conversation->notes['No.Telepon'] = $message->getContact()->getPhoneNumber();

                // no break
            case 6:
                if (is_null($message->getPhoto())) {
                    $this->conversation->notes['state'] = 6;
                    $this->conversation->update();

                    $data['text'] = 'Masukan Photo anda:';
                    $data['reply_markup'] = new ReplyKeyBoardHide(['selective' => true]);
                    $result = Request::sendMessage($data);
                    break;
                }
                $this->conversation->notes['photo_id'] = $message->getPhoto()[0]->getFileId();

                // no break
            
            case 7:
                $this->conversation->update();
                $out_text = 'Pendaftaran selesai :' . "\n";
                unset($this->conversation->notes['state']);
                foreach ($this->conversation->notes as $k => $v) {
                    $out_text .= "\n" . ucfirst($k).': ' . $v;
                }

                $data['photo'] = $this->conversation->notes['photo_id'];
                $data['reply_markup'] = new ReplyKeyBoardHide(['selective' => true]);
                $data['caption'] = $out_text;
                $this->conversation->stop();
                $result = Request::sendPhoto($data);
                break;
        }
        }
        return $result;
    }
   
}
