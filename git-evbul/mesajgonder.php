
<?php
include_once 'baglan.php'; 
include_once 'oturumkontrolu.php';
include_once 'fonksiyonlar.php';
include 'relsrc.php';


$gonderen_id=oturumkontrolu();

$alici_id=$_POST['sahip_id'];

$ilan_url=$_POST['ilan_url'];

$ilan_baslik=guvenlik_fonksiyonu($_POST['ilan_baslik']);

$mesaj= guvenlik_fonksiyonu($_POST['mesaj']);


//mesajı vt ye kaydetme


$mesaj_pre=$db->prepare("INSERT INTO mesajlar (ilanUrl, ilanBaslik, gonderenID, aliciID, mesaj) VALUES ('$ilan_url', '$ilan_baslik', $gonderen_id, $alici_id, '$mesaj')");


if($mesaj_pre===false) die("Sorgu hatası:".$db->error);


$mesaj_pre->execute();


$gelinen_url = htmlspecialchars($_SERVER['HTTP_REFERER']);  // hangi sayfadan gelindigi degerini verir.

echo '<meta http-equiv="refresh" content="1;url='.$gelinen_url.'">';


	$mesaj1="Mesaj Gönderildi";
    $tur1=1;
    sessioncreate($mesaj1,$tur1);

?>
