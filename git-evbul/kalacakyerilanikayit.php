<?php

session_start();



include_once 'oturumkontrolu.php';

include_once 'fonksiyonlar.php';



  if(isset($_POST['ilanbasligi'])){

      require_once('baglan.php');



      //kriter tablosunu dolduralım



      if(isset($_POST['kriter'][0])){

        $evcil=1;

      }else{$evcil=0;}

      if(isset($_POST['kriter'][1])){

        $sigara=1;

      }else{$sigara=0;}

      if(isset($_POST['kriter'][2])){

        $alkol=1;

      }else{$alkol=0;}



 

      $giren_id_aldik=oturumkontrolu();





      $stmt=$db->prepare("INSERT INTO kriterler (evcilhayvan,sigara,alkol) VALUES(?,?,?)");

        if($stmt===false) die("Sorgu hatası:".$db->error);



      $stmt->bind_param("iii",$evcil,$sigara,$alkol);

      

      //execute ile sorguyu çalıştıralım

      $stmt->execute();

      //kriter tablosu end

      $kriterID=$stmt->insert_id;



      $stmt=$db->prepare("INSERT INTO kalacakyerilani (ilanBasligi,url,butcem,ilID,ilceID,ilanAciklama,odamOlsun,cinsiyet,kriterID,keywords,description,girenID) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");

      if($stmt===false) die("Sorgu hatası:".$db->error);



      if(isset($_POST['kendiodasi'])){

        $oda=1;

      }else{$oda=0;}



      //ilan urlsi için seflink oluşturuluyor

      include_once 'seflinkfonk.php';

      $rand=rand(0,20);

      $ilan_url=permalink($_POST['ilanbasligi']) ."-$rand";  





        $ilanbasligi= guvenlik_fonksiyonu($_POST['ilanbasligi']);

        $butce= guvenlik_fonksiyonu($_POST['butce']);

        $il= guvenlik_fonksiyonu($_POST['il']);

        $ilce= guvenlik_fonksiyonu($_POST['ilce']);

        $ilanaciklamasi= guvenlik_fonksiyonu($_POST['ilanaciklamasi']);

        $cinsiyet= guvenlik_fonksiyonu($_POST['cinsiyet']);


        //il isim çekme

      $il_sorgu=$db->prepare("SELECT baslik from muh_iller where id='$il'");
      $il_sorgu ->execute();
      $il_result=$il_sorgu->get_result();
      $il_fetch=$il_result->fetch_array();
      $ilad=$il_fetch['baslik'];

        //ilçe isim çekme

      $ilce_sorgu=$db->prepare("SELECT * from muh_ilceler where id='$ilce'");
      $ilce_sorgu ->execute();
      $ilce_result=$ilce_sorgu->get_result();
      $ilce_fetch=$ilce_result->fetch_array();
      $ilcead=$ilce_fetch['baslik'];


      $keywords="$ilad, kalacak yer arıyorum, kalacak ev arıyorum,$ilcead, $ilad kalacak yer";
      $description="$ilad da $ilanbasligi, $ilad $ilcead";



      $stmt->bind_param("ssiiisiiissi",

        $ilanbasligi,

        $ilan_url,

        $butce,

        $il,

        $ilce,

        $ilanaciklamasi,

        $oda,

        $cinsiyet,

        $kriterID,$keywords,$description,

        $giren_id_aldik);

      

      //execute ile sorguyu çalıştıralım

      $stmt->execute();



      //kaydedilen ilanın id sini çekiyoruz

      $ilanID="k".$stmt->insert_id;

      //k: kalacakyer





      //kayıt durumunu elde edelim

      

      $mesaj1="İlan Başarıyla Kaydedildi Patron.";

      $tur1=1;

      sessioncreate($mesaj1,$tur1);

      echo '<meta http-equiv="refresh" content="3;url=ilanlarim.php?git=ilanlarim&kategori=kalacakyerilanlarim">';

}else{



   $mesaj1="Kayıt başarısız.";

      $tur1=0;

      sessioncreate($mesaj1,$tur1);

  

  echo '<meta http-equiv="refresh" content="3;url=ilanlarim.php?git=ilanlarim&kategori=kalacakyerilanlarim">';

}



        /**********************



        ev arkadaşı ilanını evarkadasiilani  na kaydediyoruz. Resimleri klasöre kaydettikten sonra bilgilerini resimler veritabanına kaydediyoruz. Hangi resmin hangi ilana ait olduğunu belirtmek için de bu ilanID si ile birlikte ilanresimler tablosuna kaydediyoruz.



        ilan kaydedilirken jpeg haricinde dosya geldiğinde onu atlayıp ilanın kaydına devam ediyor, bu sorun oluşturabilir.



        ***********************/

    ?>

