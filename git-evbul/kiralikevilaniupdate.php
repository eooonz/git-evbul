<?php

session_start();

include_once 'oturumkontrolu.php';

include_once 'fonksiyonlar.php';

$giren_id_aldik=oturumkontrolu();

  if(isset($_POST)){

    require_once('baglan.php');

    //düzenlenecek ilanın id sini alıyoruz

    $ilanID=$_POST['kilanid'];


//Üye bilgilerini alıyoruz

    $ilan_bilgileri=$db->prepare("SELECT * FROM kiralikevilani WHERE kilanID=?");

    $ilan_bilgileri->bind_param('i',$ilanID);

    $ilan_bilgileri->execute();

    $result=$ilan_bilgileri->get_result();

    $ilan_bilgiler=$result->fetch_array();



	$ilanbasligi= guvenlik_fonksiyonu($_POST['ilanbasligi']);

	$odasayisi= guvenlik_fonksiyonu($_POST['odasayisi']);

	$kacmetrekare= guvenlik_fonksiyonu($_POST['kacmetrekare']);

	$kacincikat= guvenlik_fonksiyonu($_POST['kacincikat']);

	$evinkirasi= guvenlik_fonksiyonu($_POST['evinkirasi']);

	$isinmasekli= guvenlik_fonksiyonu($_POST['isinmasekli']);

	@$esyalimi= guvenlik_fonksiyonu($_POST['esyalimi']);

	$il= guvenlik_fonksiyonu($_POST['il']);

	@$ilce= guvenlik_fonksiyonu($_POST['ilce']);

	$ilanaciklama= guvenlik_fonksiyonu($_POST['ilanaciklama']);

	$adres= guvenlik_fonksiyonu($_POST['adres']);

if(!empty($il) OR !empty($ilce)){
	$il_guncelle=$db->prepare("UPDATE kiralikevilani SET ilID=?,ilceID=? WHERE kilanID=? AND girenID=?");
      if($il_guncelle===false) die("Sorgu hatası:".$db->error);
      $il_guncelle->bind_param("iiii",$il,$ilce,$ilanID,$giren_id_aldik);
      $il_guncelle->execute();
}

$ilan_guncelle=$db->prepare("UPDATE kiralikevilani SET ilanBasligi=?,odaSayisi=?,metrekare=?,kacinciKat=?,evinKirasi=?,isinmaSekliID=?,esyaliMi=?,ilanAciklama=?,adres=?  WHERE kilanID=? AND girenID=?");


$ilan_guncelle->bind_param('siiiiiissii',

	$ilanbasligi,

	$odasayisi,

	$kacmetrekare,

	$kacincikat,

	$evinkirasi,

	$isinmasekli,

	$esyalimi,

	$ilanaciklama,

	$adres,

	$ilanID,$giren_id_aldik);

$ilan_guncelle->execute();


$mesaj1="Değişiklikler kaydedildi.";
    $tur1=1;
    sessioncreate($mesaj1,$tur1);
echo '<meta http-equiv="refresh" content="0;url=kiralikevbuldum.php?git='.$ilan_bilgiler['url'].'"> ';

}else{

$mesaj1="Hata! Formdan bigliler gelmedi.";
    $tur1=0;
    sessioncreate($mesaj1,$tur1);

    echo '<meta http-equiv="refresh" content="0;url=evarkadasibuldum.php ';


}





//Mail adresini değiştirince ad ve mail placeholder da gözükmüyor

/*//başlık güncellemesi 

	

	    $baslik=$_POST['ilanbasligi'];

		$baslik_guncelle=$db->prepare("UPDATE kiralikevilani SET ilanBasligi=? WHERE kilanID=? AND girenID=?");

		$baslik_guncelle->bind_param('sii',$baslik,$ilanID,$giren_id_aldik);

		$baslik_guncelle->execute();





		$odasayisi=$_POST['odasayisi'];

		$odasayisi_guncelle=$db->prepare("UPDATE kiralikevilani SET odaSayisi=? WHERE kilanID=? AND girenID=?");

		$odasayisi_guncelle->bind_param('iii',$odasayisi,$ilanID,$giren_id_aldik);

		$odasayisi_guncelle->execute();



		$kacmetrekare=$_POST['kacmetrekare'];

		$kacmetrekare_guncelle=$db->prepare("UPDATE kiralikevilani SET metrekare=? WHERE kilanID=? AND girenID=?");

		$kacmetrekare_guncelle->bind_param('iii',$kacmetrekare,$ilanID,$giren_id_aldik);

		$kacmetrekare_guncelle->execute();

  

		$kacincikat=$_POST['kacincikat'];

		$kacincikat_guncelle=$db->prepare("UPDATE kiralikevilani SET kacinciKat=? WHERE kilanID=? AND girenID=?");

		$kacincikat_guncelle->bind_param('iii',$kacincikat,$ilanID,$giren_id_aldik);

		$kacincikat_guncelle->execute();



		$evinkirasi=$_POST['evinkirasi'];

		$evinkirasi_guncelle=$db->prepare("UPDATE kiralikevilani SET evinKirasi=? WHERE kilanID=? AND girenID=?");

		$evinkirasi_guncelle->bind_param('iii',$evinkirasi,$ilanID,$giren_id_aldik);

		$evinkirasi_guncelle->execute();



		$isinmasekli=$_POST['isinmasekli'];

		$isinmasekli_guncelle=$db->prepare("UPDATE kiralikevilani SET isinmaSekliID=? WHERE kilanID=? AND girenID=?");

		$isinmasekli_guncelle->bind_param('iii',$isinmasekli,$ilanID,$giren_id_aldik);

		$isinmasekli_guncelle->execute();



		$esyalimi=$_POST['esyalimi'];

		$esyalimi_guncelle=$db->prepare("UPDATE kiralikevilani SET esyaliMi=? WHERE kilanID=? AND girenID=?");

		$esyalimi_guncelle->bind_param('iii',$esyalimi,$ilanID,$giren_id_aldik);

		$esyalimi_guncelle->execute();



		$il=$_POST['il'];

		$il_guncelle=$db->prepare("UPDATE kiralikevilani SET ilID=? WHERE kilanID=? AND girenID=?");

		$il_guncelle->bind_param('iii',$il,$ilanID,$giren_id_aldik);

		$il_guncelle->execute();



		$ilce=$_POST['ilce'];

		$ilce_guncelle=$db->prepare("UPDATE kiralikevilani SET ilceID=? WHERE kilanID=? AND girenID=?");

		$ilce_guncelle->bind_param('iii',$ilce,$ilanID,$giren_id_aldik);

		$ilce_guncelle->execute();



		$ilanaciklama=$_POST['ilanaciklama'];

		$ilanaciklama_guncelle=$db->prepare("UPDATE kiralikevilani SET ilanAciklama=? WHERE kilanID=? AND girenID=?");

		$ilanaciklama_guncelle->bind_param('sii',$ilanaciklama,$ilanID,$giren_id_aldik);

		$ilanaciklama_guncelle->execute();



		$adres=$_POST['adres'];

		$adres_guncelle=$db->prepare("UPDATE kiralikevilani SET adres=? WHERE kilanID=? AND girenID=?");

		$adres_guncelle->bind_param('sii',$adres,$ilanID,$giren_id_aldik);

		$adres_guncelle->execute();

*/

    ?>
