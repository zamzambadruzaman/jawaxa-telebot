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

use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Request;

/**
 * User "/slap" command
 */
class TamparCommand extends UserCommand
{
    /**#@+
     * {@inheritdoc}
     */
    protected $name = 'tampar';
    protected $description = 'Slap someone with their username';
    protected $usage = '/tampar <@user>';
    protected $version = '1.0.1';
    /**#@-*/

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $message = $this->getMessage();

        $chat_id = $message->getChat()->getId();
        $message_id = $message->getMessageId();
        $text = $message->getText(true);

        $sender = '@' . $message->getFrom()->getUsername();

        //username validation
        $test = preg_match('/@[\w_]{5,}/', $text);
        if ($test === 0) {
            $text = $sender . ' gak ada yang bisa ditampar nih..';
        } else {
            $text = $sender . ' menampar ' . $text . ' dengan penuh amarah';
        }

        $data = [
            'chat_id' => $chat_id,
            'text'    => $text,
        ];

        return Request::sendMessage($data);
    }
}
