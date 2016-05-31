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
    protected $description = 'Menampilkan tata tertib group KUPP';
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

9 Syaban 1437H/ 16-05-2016

📢📢📢TATA TERTIB📢📢📢

1⃣Gambar DP Group
Harus ada logo Pemuda PERSIS dan disetujui oleh Bidgar terkait dan disahkan Ketum PP
Yg akan menjadi pokok dari Gambar DP Group kedepan, apapun ruang, forum, ataupun kelas

Perubahan akan disesuaikan setelah disepakati dan disetujui Ketum PP. Pemuda PERSIS
⚪️⚪️⚪️⚪️⚪️⚪️⚪️⚪️⚪️⚪️⚪️

2⃣Barang dagangan✅
Batasan barang yg diperjual belikan
Barang halal, tidak mengandung hal subhat, tidak bertentangan dengan Al Quran dan Sunnah, sebagai acuan adalah keputusan Dewan Hisbah

🏧🏧🏧🏧🏧🏧🏧🏧🏧🏧🏧
3⃣Infaq dan zakat ♻️
Anggota diharapkan memberikan infaq dan zakat atas keuntungan yang diperolehnya
Besaran infaq, seikhlasnyq
Besaran Zakat, disesuaikan

Pengelola akan membantu mempromosikan barang dagangan anggota yang berinfaq dan berzakat di komunitas ini

💳Rek. Bank Muamalat 
Cab. Bandung 
No. REK : 0116556046 
a.n. Isamail Fajar Romdhon QQ PP Pemuda Persis

Pengelola : Ismail Fajar
Tasykil PP : BENDAHARA

🌐🌐🌐🌐🌐🌐🌐🌐🌐🌐🌐
4⃣Member Komunitas ✅
PERSIS, Otonom, dan Simpatisan

Ketentuan bagi anggota yang bergabung :

1. Anggota PERSIS & OTONOM

Menuliskan nama
Nomor hp
Nomor Keanggotaan atau 
Menyampaikan dari PC/PD/PW mana, jika Kartu Keanggotaannya dalam proses

Simpatisan :
Menuliskan nama
Nomor hp

Tambahan :
Menyebutkan nama ketua PC atau 
Salah satu Tasykil PC atau 
Ketua jamaah didaerahnya atau 
Nama asatidz PERSIS yg dikenalnya atau 
Keterangan lain sebagai referensi dirinya adalah simpatisan

Perubahan akan diedit sesuai usulan yang disetujui Pengelola';
        
        $data = [
            'chat_id' => $chat_id,
            'text'    => $text,
        ];

        return Request::sendMessage($data);
    }
}
