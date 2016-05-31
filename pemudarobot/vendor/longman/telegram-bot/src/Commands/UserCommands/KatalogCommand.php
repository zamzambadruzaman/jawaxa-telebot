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
class KatalogCommand extends UserCommand
{
    /**#@+
     * {@inheritdoc}
     */
    protected $name = 'katalog';
    protected $description = 'Menampilkan katalog KUPP';
    protected $usage = '/katalog';
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

01. Suplier @Fariz_Cell 
Lapak : https://telegram.me/FarizCell
#kuotainternet 
Menyediakan injek kuota Three dan ALL OPERATOR
#Acclainnya
Gembok dilengkapi Alarm
#Xiaomi
Paket Xiaomi Camera

02. Suplier @Harocafe 
#jual
Lentera tenaga surya plus charger HP
TIMER Charger
#mobil

03. Suplier : @Wawan_Parisvanjava
Spesialis Biro Jasa Parisvanjava untuk wilayah Jabotabek dan Bandung
LAPAK : 
https://telegram.me/Jktbdg
#birojasa 
Biro Jasa Pengurusan NPWP, TDUP (BPW), TDP, Travel dan Umroh 
#TDUP
Jasa Pengurusan TDUP Bekasi


04. Suplier : @akang_daenk 
#Lenovo
HP Bekas akhwat, Lenovo A360
#KONSTRUKSI
Toko Material
Kaca, Kusen, Aluminium, Baja Ringan, dll

05. Suplier @zhendy19
#Cokelat
Aneka jenis coklat DELFI dan Lagie, KILOAN

06. Suplier @tetinuryati
#herbal
Obat Herbal dannMinyak ZAITUN

07. Suplier : @abu_sabda
Lapak : 
https://telegram.me/joinchat/B5PzED9Wb6IKQaWyqDUQGw

#TBASabda
Menyediakan kitab arabic dan buku2 karya ulama PERSIS, Fiqh, Falaq, dll 

08. Suplier : @azmGEAR 
Lapak : https://telegram.me/azmgear
#travelingequipment
Alat Olah Raga dan Keperluan Perjalanan, Buff, Sepatu, alat kemping, dll

09. Suplier : @maktubah
#BapiaPathok
Makanan khas Jogja, Asli dari Jogja dan dikirim langsung dari Jogja

10. Suplier : @ZaidNasrullah 
Lapak : http://telegram.me/rbiruni
#educationalclothing

11. Suplier : @mama_arkaan
Lapak : https://telegram.me/AFYShop 
#Gamis
Menyediakan busana Syar`i
#Penggemukan
Program penggemukan Ternak

12. Suplier : @tokobelanja
Lapak : 
#Sprei
Sprei Batik, berbagai motif

13. Suplier : @dansazie 
#jualhpsecond
MS LUMIA 532 Win 10 
';
        
        $data = [
            'chat_id' => $chat_id,
            'text'    => $text,
        ];

        return Request::sendMessage($data);
    }
}
