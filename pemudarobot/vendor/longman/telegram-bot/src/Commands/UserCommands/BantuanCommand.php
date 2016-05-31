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
 * User "/help" command
 */
class BantuanCommand extends UserCommand
{
    /**#@+
     * {@inheritdoc}
     */
    protected $name = 'bantuan';
    protected $description = 'Menampilkan halaman bantuan';
    protected $usage = '/bantuan atau /bantuan <perintah>';
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
        $command = trim($message->getText(true));

        //Only get enabled Admin and User commands
        $commands = array_filter($this->telegram->getCommandsList(), function ($command) {
            return (!$command->isSystemCommand() && $command->isEnabled());
        });

        //If no command parameter is passed, show the list
        if ($command === '') {
            $text = $this->telegram->getBotName() . ' v. ' . $this->telegram->getVersion() . "\n\n";
            $text .= 'Daftar Perintah:' . "\n";
            ksort($commands);
            foreach ($commands as $command) {
                $text .= '/' . $command->getName() . ' - ' . $command->getDescription() . "\n";
            }

            $text .= "\n" . 'Untuk lebih jelas silahkan ketik: /bantuan <perintah>';
        } else {
            $command = str_replace('/', '✅', $command);
            if (isset($commands[$command])) {
                $command = $commands[$command];
                $text = 'Perintah: ' . $command->getName() . ' v' . $command->getVersion() . "\n";
                $text .= 'Deskripsi: ' . $command->getDescription() . "\n";
                $text .= 'Penggunaan: ' . $command->getUsage();
            } else {
                $text = 'Tidak ada bantuan untuk perintah /' . $command . '.';
            }
        }

        $data = [
            'chat_id'             => $chat_id,
            'reply_to_message_id' => $message_id,
            'text'                => $text,
        ];

        return Request::sendMessage($data);
    }
}
