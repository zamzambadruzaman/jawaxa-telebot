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
class InputprodukCommand extends UserCommand
{
    /**#@+
     * {@inheritdoc}
     */
    protected $name = 'inputproduk';
    protected $description = 'Input data produk / dagangan';
    protected $usage = '/inputproduk';
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
            $data['text'] = 'Perintah ini hanya untuk Private chat, silahkan daftar langsung secara personal ke Moderator @kuppbot';
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
    
                    $data['text'] = 'Nama Toko:';
                    $data['reply_markup'] = new ReplyKeyBoardHide(['selective' => true]);
                    $result = Request::sendMessage($data);
                    break;
                }
                $this->conversation->notes['Toko'] = $text;
                $text = '';
                // no break
            case 1:
                if (empty($text)) {
                    $this->conversation->notes['state'] = 1;
                    $this->conversation->update();
    
                    $data['text'] = 'Penjelasan Singkat :';
                    $result = Request::sendMessage($data);
                    break;
                }
                $this->conversation->notes['deskripsi'] = $text;
                ++$state;
                $text = '';

                // no break
            case 2:
                if (empty($text) ) {
                    $this->conversation->notes['state'] = 2;
                    $this->conversation->update();

                    $data['text'] = 'Username :';                    
                    $result = Request::sendMessage($data);
                    break;
                }
                $this->conversation->notes['username'] = $text;
                $state;
                $text = '';

                // no break
            case 3:
                if (empty($text) ) {
                    $this->conversation->notes['state'] = 3;
                    $this->conversation->update();

                    $data['text'] = 'Link channel (Lapak) :';                    
                    $result = Request::sendMessage($data);
                    break;
                }
                $this->conversation->notes['channel'] = $text;
                $text = '';
           
                // no break
            
            case 4:
                if (is_null($message->getContact())) {
                    $this->conversation->notes['state'] = 4;
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
                $this->conversation->notes['No.HP'] = $message->getContact()->getPhoneNumber();

                // no break
            
            
            case 5:
                $this->conversation->update();
                $out_text = 'Alhamdulillah, Input produk selesai :' . "\n";
                unset($this->conversation->notes['state']);
                foreach ($this->conversation->notes as $k => $v) {
                    $out_text .= "\n" . ucfirst($k).': ' . $v;
                }

                //$data['photo'] = $this->conversation->notes['photo_id'];
                $data['reply_markup'] = new ReplyKeyBoardHide(['selective' => true]);
                $data['text'] = $out_text."\n Syukron sudah melakukan input data. :)";
                $this->conversation->stop();
                $result = Request::sendMessage($data);
                break;
        }
        }
        return $result;
    }
   
}
