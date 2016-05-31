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
class TatibCommand extends UserCommand
{
    /**#@+
     * {@inheritdoc}
     */
    protected $name = 'tatib';
    protected $description = 'Menampilkan tata tertib Registrasi Anggota Pemuda Persis';
    protected $usage = '/tatib';
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
        
        $text = 'Assalamualaikum '.$sender . ', 

UNTUK MELAKUKAN PENDAFTARAN ATAU HER-REGISTRASI SECARA ONLINE FOKUS pada yang memiliki nomor NPA, baik kartunya masih berlaku, kadaluarsa ataupun hilang

Sebelum melakukan input, persiapkan data :
1⃣KTP (Alamat)
2⃣KTA (NMR NPA)
3⃣Alamat email aktif
4⃣Nomor HP 
5⃣File Foto';
        
        $data = [
            'chat_id' => $chat_id,
            'text'    => $text,
        ];

        return Request::sendMessage($data);
    }
}
