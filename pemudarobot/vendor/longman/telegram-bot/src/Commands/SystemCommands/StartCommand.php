<?php
/**
 * This file is part of the TelegramBot package.
 *
 * (c) Avtandil Kikabidze aka LONGMAN <akalongman@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Longman\TelegramBot\Commands\SystemCommands;

use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Request;

/**
 * Start command
 */
class StartCommand extends SystemCommand
{
    /**#@+
     * {@inheritdoc}
     */
    protected $name = 'start';
    protected $description = 'Start command';
    protected $usage = '/start';
    protected $version = '1.0.1';
    /**#@-*/

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $message = $this->getMessage();

        $chat_id = $message->getChat()->getId();
        $text = 'Ahlan wa sahlan !' . "\n" . 
        'UNTUK MELAKUKAN PENDAFTARAN ATAU HER-REGISTRASI SECARA ONLINE FOKUS pada yang memiliki nomor NPA, baik kartunya masih berlaku, kadaluarsa ataupun hilang

Sebelum melakukan input, persiapkan data :
1⃣KTP (Alamat)
2⃣KTA (NMR NPA)
3⃣Alamat email aktif
4⃣Nomor HP 
5⃣File Foto

Ketik /bantuan untuk melihat semua perintah.';

        $data = [
            'chat_id' => $chat_id,
            'text'    => $text,
        ];

        return Request::sendMessage($data);
    }
}
