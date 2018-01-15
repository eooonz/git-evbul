<?php

session_start();


include_once 'oturumkontrolu.php';

include_once 'fonksiyonlar.php';


$giren_id_aldik=oturumkontrolu();


  if(isset($_POST)){

    require_once('baglan.php');


    //düzenlenecek ilanın id sini alıyoruz

    $ilanID=guvenlik_fonksiyonu($_POST['eilanid']);



//Üye bilgilerini alıyoruz

    $ilan_bilgileri=$db->prepare("SELECT * FROM kalacakyerilani WHERE eilanID=? AND girenID=?");

    $ilan_bilgileri->bind_param('ii',$ilanID,$giren_id_aldik);

    $ilan_bilgileri->execute();

    $result=$ilan_bilgileri->get_result();

    $ilan_bilgiler=$result->fetch_array();



    $kriterID=$ilan_bilgiler['kriterID'];


//diğer şekilde update



		if(isset($_POST['kendiodasi'])){

			$oda=1;

		}else{$oda=0;}


			$ilanbasligi= guvenlik_fonksiyonu($_POST['ilanbasligi']);

			$ilanaciklamasi= guvenlik_fonksiyonu($_POST['ilanaciklamasi']);

			$il= guvenlik_fonksiyonu($_POST['il']);

			@$ilce= guvenlik_fonksiyonu($_POST['ilce']);

			$butcem= guvenlik_fonksiyonu($_POST['butcem']);

			$cinsiyet= guvenlik_fonksiyonu($_POST['cinsiyet']);


		if(!empty($il) OR !empty($ilce)){
			$il_guncelle=$db->prepare("UPDATE kalacakyerilani SET ilID=?,ilceID=? WHERE eilanID=? AND girenID=?");
		      if($il_guncelle===false) die("Sorgu hatası:".$db->error);
		      $il_guncelle->bind_param("iiii",$il,$ilce,$ilanID,$giren_id_aldik);
		      $il_guncelle->execute();
		}

		$ilan_guncelle=$db->prepare("UPDATE kalacakyerilani SET ilanBasligi=?,ilanAciklama=?,butcem=?,odamOlsun=?,cinsiyet=? WHERE eilanID=? AND girenID=?");


		$ilan_guncelle->bind_param("ssiiiii",

			$ilanbasligi,

			$ilanaciklamasi,

			$butcem,

			$oda,

			$cinsiyet,

			$ilanID,$giren_id_aldik);



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

      

      //execute ile sorguyu çalıştıralım

      $kriter_guncelle->execute(); 


$mesaj1="Değişiklikler kaydedildi.";
    $tur1=1;
    sessioncreate($mesaj1,$tur1);

echo '<meta http-equiv="refresh" content="0;url=kalacakyerbuldum.php?git='.$ilan_bilgiler['url'].'"> ';


}else{

  	$mesaj1="Hata! Formdan bigliler gelmedi.";
    $tur1=0;
    sessioncreate($mesaj1,$tur1);

    echo '<meta http-equiv="refresh" content="0;url=kalacakyerbuldum.php';

}

?>
