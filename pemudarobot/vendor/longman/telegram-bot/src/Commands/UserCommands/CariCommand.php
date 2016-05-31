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
class CariCommand extends UserCommand
{
    /**#@+
     * {@inheritdoc}
     */
    protected $name = 'cari';
    protected $description = 'Untuk mencari produk/dagangan di katalog KUPP';
    protected $usage = '/cari <keyword>';
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
            $data['chat_id'] = $chat_id;
            //reply to message id is applied by default
            //$data['reply_to_message_id'] = $message_id;
            //Force reply is applied by default to so can work with privacy on
            //$data['reply_markup'] = new ForceReply([ 'selective' => true]);
            $data['text'] = 'Perintah ini masih dalam perbaikan';
            $result = Request::sendMessage($data) ;
            
        
        return $result;
    }
   
}
