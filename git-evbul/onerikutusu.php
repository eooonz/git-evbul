<?php

include 'baglan.php';

include 'fonksiyonlar.php';

include 'oturumkontrolu.php';



$giren_id_aldik=oturumkontrolu();



if($giren_id_aldik != false){

	$kim = $giren_id_aldik;

}else{$kim = "0";}



$mesaj=guvenlik_fonksiyonu($_POST['mesaj']);

if($mesaj){

$onerikutusu=$db->prepare("INSERT INTO onerikutusu (mesaj,kim) VALUES(?,?)");

        if($onerikutusu===false) die("Sorgu hatası:".$db->error);



      $onerikutusu->bind_param("ss",$mesaj,$kim);

      

      //execute ile sorguyu çalıştıralım

      $onerikutusu->execute();

	$mesaj1="Mesaj Alındı, Teşekkürler.";
    $tur1=1;
    sessioncreate($mesaj1,$tur1);

      $gelinen_url = htmlspecialchars($_SERVER['HTTP_REFERER']);  // hangi sayfadan gelindigi degerini verir.

echo '<meta http-equiv="refresh" content="1;url='.$gelinen_url.'">';
}else
{
	$mesaj1="Mesajınız gönderilirken problem yaşandı. Bize iletişim sayfamızdan da ulaşabilirsiniz. Teşekkürler";
    $tur1=0;
    sessioncreate($mesaj1,$tur1);

      $gelinen_url = htmlspecialchars($_SERVER['HTTP_REFERER']);  // hangi sayfadan gelindigi degerini verir.

echo '<meta http-equiv="refresh" content="1;url='.$gelinen_url.'">';
}
?>