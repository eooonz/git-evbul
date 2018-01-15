<?php

session_start();


include_once 'oturumkontrolu.php';

include_once 'fonksiyonlar.php';

$giren_id_aldik=oturumkontrolu();


  if(isset($_POST)){

    require_once('baglan.php');


    //düzenlenecek ilanın id sini alıyoruz

    $ilanID=$_POST['ailanid'];


//Üye bilgilerini alıyoruz

    $ilan_bilgileri=$db->prepare("SELECT * FROM evarkadasiilani WHERE ailanID=?");

    $ilan_bilgileri->bind_param('i',$ilanID);

    $ilan_bilgileri->execute();

    $result=$ilan_bilgileri->get_result();

    $ilan_bilgiler=$result->fetch_array();



    $kriterID=$ilan_bilgiler['kriterID'];



//diğer şekilde update



		if(isset($_POST['kendiodasi'])){

			$oda=1;

		}else{$oda=0;}



		if(isset($_POST['cinsiyet'])){

			@$cinsiyet = $_POST['cinsiyet'][0] + $_POST['cinsiyet'][1];

		}else{$cinsiyet=0;}

	

			$ilanbasligi= guvenlik_fonksiyonu($_POST['ilanbasligi']);

			$ilanaciklamasi= guvenlik_fonksiyonu($_POST['ilanaciklamasi']);

			$kisibasibutce= guvenlik_fonksiyonu($_POST['kisibasibutce']);

			$il= guvenlik_fonksiyonu($_POST['il']);

			@$ilce= guvenlik_fonksiyonu($_POST['ilce']);

			$isinmasekli= guvenlik_fonksiyonu($_POST['isinmasekli']);

			$evkackisi= guvenlik_fonksiyonu($_POST['evkackisi']);

			$toplamkackisi= guvenlik_fonksiyonu($_POST['toplamkackisi']);

			$evinkirasi= guvenlik_fonksiyonu($_POST['evinkirasi']);

		if(!empty($il) OR !empty($ilce)){
			$il_guncelle=$db->prepare("UPDATE evarkadasiilani SET ilID=?,ilceID=? WHERE ailanID=? AND girenID=?");
		      if($il_guncelle===false) die("Sorgu hatası:".$db->error);
		      $il_guncelle->bind_param("iiii",$il,$ilce,$ilanID,$giren_id_aldik);
		      $il_guncelle->execute();
		}

		$ilan_guncelle=$db->prepare("UPDATE evarkadasiilani SET ilanBasligi=?,ilanAciklama=?,kisiBasiButce=?,isitmaSekliID=?,evSimdiKacKisi=?,toplamKacKisi=?,evinKirasi=?,odasiOlacak=?,cinsiyet=? WHERE ailanID=? AND girenID=?");


		$ilan_guncelle->bind_param("ssiiiiiiiii",

			$ilanbasligi,

			$ilanaciklamasi,

			$kisibasibutce,

			$isinmasekli,

			$evkackisi,

			$toplamkackisi,

			$evinkirasi,

			$oda,$cinsiyet,$ilanID,$giren_id_aldik);


		$ilan_guncelle->execute();

		if($ilan_guncelle===false) die("Sorgu hatası:".$db->error);


		if(isset($_POST['kriter'][0])){

		$evcil=1;

		}else{$evcil=0;}

		if(isset($_POST['kriter'][1])){

		$sigara=1;

		}else{$sigara=0;}

		if(isset($_POST['kriter'][2])){

		$alkol=1;

		}else{$alkol=0;}


      $kriter_guncelle=$db->prepare("UPDATE kriterler SET evcilhayvan=?,sigara=?,alkol=? WHERE kriterID=?");
      if($kriter_guncelle===false) die("Sorgu hatası:".$db->error);
      $kriter_guncelle->bind_param("iiii",$evcil,$sigara,$alkol,$kriterID);
      $kriter_guncelle->execute();



 	$mesaj1="Değişiklikler kaydedildi.";
    $tur1=1;
    sessioncreate($mesaj1,$tur1);

echo '<meta http-equiv="refresh" content="0;url=evarkadasibuldum.php?git='.$ilan_bilgiler['url'].'"> ';

}else{

  	$mesaj1="Hata! Formdan bigliler gelmedi.";
    $tur1=0;
    sessioncreate($mesaj1,$tur1);

    echo '<meta http-equiv="refresh" content="0;url=evarkadasibuldum.php ';

}

      /*//başlık güncellemesi 

	

	    $baslik=$_POST['ilanbasligi'];

		$baslik_guncelle=$db->prepare("UPDATE evarkadasiilani SET ilanBasligi=? WHERE ailanID=? AND girenID=?");

		$baslik_guncelle->bind_param('sii',$baslik,$ilanID,$giren_id_aldik);

		$baslik_guncelle->execute();



		$evkackisi=$_POST['evkackisi'];

		$evkackisi_guncelle=$db->prepare("UPDATE evarkadasiilani SET evSimdiKacKisi=? WHERE ailanID=? AND girenID=?");

		$evkackisi_guncelle->bind_param('iii',$evkackisi,$ilanID,$giren_id_aldik);

		$evkackisi_guncelle->execute();



		$toplamkackisi=$_POST['toplamkackisi'];

		$toplamkackisi_guncelle=$db->prepare("UPDATE evarkadasiilani SET toplamKacKisi=? WHERE ailanID=? AND girenID=?");

		$toplamkackisi_guncelle->bind_param('iii',$toplamkackisi,$ilanID,$giren_id_aldik);

		$toplamkackisi_guncelle->execute();

  

		$evinkirasi=$_POST['evinkirasi'];

		$evinkirasi_guncelle=$db->prepare("UPDATE evarkadasiilani SET evinKirasi=? WHERE ailanID=? AND girenID=?");

		$evinkirasi_guncelle->bind_param('iii',$evinkirasi,$ilanID,$giren_id_aldik);

		$evinkirasi_guncelle->execute();



		$kisibasibutce=$_POST['kisibasibutce'];

		$kisibasibutce_guncelle=$db->prepare("UPDATE evarkadasiilani SET kisiBasiButce=? WHERE ailanID=? AND girenID=?");

		$kisibasibutce_guncelle->bind_param('iii',$kisibasibutce,$ilanID,$giren_id_aldik);

		$kisibasibutce_guncelle->execute();



		$isinmasekli=$_POST['isinmasekli'];

		$isinmasekli_guncelle=$db->prepare("UPDATE evarkadasiilani SET isitmaSekliID=? WHERE ailanID=? AND girenID=?");

		$isinmasekli_guncelle->bind_param('iii',$isinmasekli,$ilanID,$giren_id_aldik);

		$isinmasekli_guncelle->execute();



		$il=$_POST['il'];

		$il_guncelle=$db->prepare("UPDATE evarkadasiilani SET ilID=? WHERE ailanID=? AND girenID=?");

		$il_guncelle->bind_param('iii',$il,$ilanID,$giren_id_aldik);

		$il_guncelle->execute();



		$ilce=$_POST['ilce'];

		$ilce_guncelle=$db->prepare("UPDATE evarkadasiilani SET ilceID=? WHERE ailanID=? AND girenID=?");

		$ilce_guncelle->bind_param('iii',$ilce,$ilanID,$giren_id_aldik);

		$ilce_guncelle->execute();



		$ilanaciklama=$_POST['ilanaciklamasi'];

		$ilanaciklama_guncelle=$db->prepare("UPDATE evarkadasiilani SET ilanAciklama=? WHERE ailanID=? AND girenID=?");

		$ilanaciklama_guncelle->bind_param('sii',$ilanaciklama,$ilanID,$giren_id_aldik);

		$ilanaciklama_guncelle->execute();

		

		$kendiodasi=$_POST['kendiodasi'];

		$kendiodasi_guncelle=$db->prepare("UPDATE evarkadasiilani SET odasiOlacak=? WHERE ailanID=? AND girenID=?");

		$kendiodasi_guncelle->bind_param('iii',$kendiodasi,$ilanID,$giren_id_aldik);

		$kendiodasi_guncelle->execute();*/

    ?>
