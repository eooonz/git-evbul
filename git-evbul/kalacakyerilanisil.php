<?php
session_start();

include_once 'oturumkontrolu.php';
include_once 'fonksiyonlar.php';
$giren_id_aldik=oturumkontrolu();

require_once('baglan.php');
//ilanları çekiyoruz
$ilanID=guvenlik_fonksiyonu($_POST['ilanisil']);

$ilan_bilgi=$db->prepare("SELECT * FROM kalacakyerilani WHERE eilanID=$ilanID");
  $ilan_bilgi->execute();
  $ilan_result=$ilan_bilgi->get_result();
  $ilan_bilgi_f=$ilan_result->fetch_assoc();
  $kriterid=$ilan_bilgi_f['kriterID'];

  $kritersil=$db->prepare("DELETE FROM kriterler WHERE kriterID=?");
  $kritersil->bind_param("i",$kriterid);
  $kritersil->execute();

	$evarkadasiilani_sil=$db->prepare("DELETE FROM kalacakyerilani WHERE eilanID=? AND girenID=?");
	$evarkadasiilani_sil->bind_param("ii",$ilanID,$giren_id_aldik);
	$evarkadasiilani_sil->execute();

	$silindimi=$db->prepare("SELECT * FROM kalacakyerilani WHERE eilanID=$ilanID");
	$silindimi->execute();
	$result_silindimi=$silindimi->get_result();
	$sonuc=$result_silindimi->num_rows;

	if($sonuc < 1){
		$mesaj1="ilan silindi...";
    $tur1=1;
    sessioncreate($mesaj1,$tur1);

		echo '<meta http-equiv="refresh" content="0;url=ilanlarim.php?git=ilanlarim&kategori=kalacakyerilanlarim">';
	}else{
	$mesaj1="ilan silinemedi";
    $tur1=0;
    sessioncreate($mesaj1,$tur1);
    echo '<meta http-equiv="refresh" content="0;url=ilanlarim.php?git=ilanlarim&kategori=kalacakyerilanlarim">';
}

?>
