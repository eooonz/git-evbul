<?php
session_start();

include_once 'oturumkontrolu.php';
include 'fonksiyonlar.php';
$giren_id_aldik=oturumkontrolu();

require_once('baglan.php');

//ilanları çekiyoruz
	$ilanID=guvenlik_fonksiyonu($_POST['ilanisil']);


	$benzerilan_id = $ilanID;
    $benzerilan_resim_id="ki"."$benzerilan_id";

    $resim_id_stmt=$db->prepare("SELECT fotoID FROM ilanresimler where ilanResimID='$benzerilan_resim_id'");
    $resim_id_stmt->execute();
    $result_resim_id=$resim_id_stmt->get_result();

    $resim_url=$db->prepare("SELECT * from ilanresimler as i inner join resimler as r on i.fotoID=r.id where i.ilanResimID ='$benzerilan_resim_id'");
    $resim_url->execute();
    $result_resim_url=$resim_url->get_result();

    while ($ilan_resim_url=$result_resim_url->fetch_assoc()) {
    	
    	unlink($ilan_resim_url['resim_url']);
    	
    }
  $ilan_bilgi=$db->prepare("SELECT * FROM evarkadasiilani WHERE ailanID=$ilanID");
  $ilan_bilgi->execute();
  $ilan_result=$ilan_bilgi->get_result();
  $ilan_bilgi_f=$ilan_result->fetch_assoc();
  $kriterid=$ilan_bilgi_f['kriterID'];

  $kritersil=$db->prepare("DELETE FROM kriterler WHERE kriterID=?");
  $kritersil->bind_param("i",$kriterid);
  $kritersil->execute();



	$ilani_sil=$db->prepare("DELETE FROM evarkadasiilani WHERE ailanID=? AND girenID=?");
	$ilani_sil->bind_param("ii",$ilanID,$giren_id_aldik);
	$ilani_sil->execute();

	$silindimi=$db->prepare("SELECT * FROM evarkadasiilani WHERE ailanID=$ilanID");
	$silindimi->execute();
	$result_silindimi=$silindimi->get_result();
	$sonuc=$result_silindimi->num_rows;

	if($sonuc < 1){
		
    $mesaj1="ilan silindi...";
    $tur1=1;
    sessioncreate($mesaj1,$tur1);

		echo '<meta http-equiv="refresh" content="0;url=ilanlarim.php?git=ilanlarim&kategori=evarkadasiilanlarim">';
	}else{
    $mesaj1="ilan silinemedi";
    $tur1=0;
    sessioncreate($mesaj1,$tur1);

    echo '<meta http-equiv="refresh" content="0;url=ilanlarim.php?git=ilanlarim&kategori=evarkadasiilanlarim">';}

?>
