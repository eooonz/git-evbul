

<?php include 'relsrc.php'; ?>



<?php

session_start();



include_once 'oturumkontrolu.php';

include_once 'fonksiyonlar.php';



$giren_id_aldik=oturumkontrolu();



require_once('baglan.php');



  if(isset($_POST['ilanbasligi'])){

      



      $stmt=$db->prepare("INSERT INTO kiralikevilani (ilanBasligi,url,odaSayisi,metrekare,kacinciKat,evinKirasi,isinmaSekliID,esyaliMi,ilID,ilceID,ilanAciklama,adres,keywords,description,girenID) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

      if($stmt===false) die("Sorgu hatası:".$db->error);



      if(isset($_POST['esyalimi'])){

        $a=1;

      }else{$a=0;}



      //ilan urlsi için seflink oluşturuluyor

      include_once 'seflinkfonk.php';

      $rand=rand(0,20);

      $ilan_url=permalink($_POST['ilanbasligi']) ."-$rand";



      $ilanbasligi= guvenlik_fonksiyonu($_POST['ilanbasligi']);

      $odasayisi= guvenlik_fonksiyonu($_POST['odasayisi']);

      $kacmetrekare= guvenlik_fonksiyonu($_POST['kacmetrekare']);

      $kacincikat= guvenlik_fonksiyonu($_POST['kacincikat']);

      $evinkirasi= guvenlik_fonksiyonu($_POST['evinkirasi']);

      $isinmasekli= guvenlik_fonksiyonu($_POST['isinmasekli']);

      $il= guvenlik_fonksiyonu($_POST['il']);

      $ilce= guvenlik_fonksiyonu($_POST['ilce']);

      $ilanaciklama= guvenlik_fonksiyonu($_POST['ilanaciklama']);

      $adres= guvenlik_fonksiyonu($_POST['adres']);


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


      $keywords="$ilad, kiralık ev, kiralık daire ,$ilcead, $ilad kiralık ev ilanları";
      $description="$ilad da $ilanbasligi, $ilad $ilcead";


      $stmt->bind_param("ssiiiiiiiissssi",

      $ilanbasligi,

      $ilan_url,

      $odasayisi,

      $kacmetrekare,

      $kacincikat,

      $evinkirasi,

      $isinmasekli,

      $a,

      $il,

      $ilce,

      $ilanaciklama,

      $adres,
      $keywords,
      $description,

      $giren_id_aldik); //resim ekleme burada yapılmadı, onu ayrı olarak yapmak lazım gibi. 

      

      //execute ile sorguyu çalıştıralım

      $stmt->execute();





      //kaydedilen ilanın id sini çekiyoruz

      $ilanID="ki".$stmt->insert_id;

      //ki: kiralıkev



      //kayıt durumunu elde edelim

       //echo '<b> Tabloya '.$db->affected_rows.'Kayıt yapıldı : İlan Başarıyla Kaydedildi. </b><br/>';



   $mesaj1="İlan Başarıyla Kaydedildi Patron.";

      $tur1=1;

      sessioncreate($mesaj1,$tur1);

      echo '<meta http-equiv="refresh" content="3;url=ilanlarim.php?git=ilanlarim&kategori=kiralikevilanlarim">';

      

}else{

  

	$mesaj1="ilan silinemedi";

    $tur1=0;

    sessioncreate($mesaj1,$tur1);

    echo '<meta http-equiv="refresh" content="0;url=ilanlarim.php?git=ilanlarim&kategori=kiralikevilanlarim">';

	



}





//Resim kaydetme



$dosya_sayi=count($_FILES['resim']['name']); 

  for($i=0;$i<$dosya_sayi;$i++){ 

    if(!empty($_FILES['resim']['name'][$i])){ 



    if($_FILES["resim"]["size"][$i] < 1024*1024*5){



    //Dosya türünün neye eşit olması gerektiğini söylüyoruz, birden fazla dosya formatını or ve ya || ile belirtebiliriz-->

      if($_FILES["resim"]["type"][$i] == "image/jpg" || $_FILES["resim"]["type"][$i] == "image/jpeg" || $_FILES["resim"]["type"][$i] == "image/png"){



        //post metodundan gelen resmin ismini $dosya_adi değişkenine atadık

        $dosya_adi=$_FILES["resim"]["name"][$i];

       //aynı isimde dosya yüklenme ihtimaline karşı ratgele bir karakterler ekleyerek, resme yeniden isim vereceğiz

        $uret=array("as","rt","ty","yu","fg");

        /*dosyanın uzantısını alıyoruz, substr fonksiyonunda negatif verdiğimizde değeri sondan başa doğru kırmaya başlar; -5 karakter başa gel ve 5 karakter kırp. 5 yamamınzın nedeni jpeg gibiformatlarda noktayı da alabilmek

        $uzanti=substr($dosya_adi,-5,5); */



        //resmin uzantısını alıyoruz

        $uzanti=uzanti($dosya_adi);

        

        $sayi_tut=rand(1,100) . time();



        //resmin yeni adı

        $yeni_ad=$uret[rand(0,4)].$sayi_tut.".".$uzanti; 

        //uret dizisinden ratgele bir değer çekiyoruz rastgele oluşturulan sayı ile birleştiriyoruz ve sonuna da uzantıyı ekliyoruz. Aslında dosya uzantımızın başta sadece jpeg olacağını belirtmiştik, bu örnek için sonuna doğrudan jpeg de ekletebilirdik. Başına koyduğumuz upload_resimler/ ile de dosyanın tam yolunu belirtmiş oluyoruz,böylece dosyanın yeni ismini belirledik.

        //dosya yolu

        $dosya_url="upload_resimler/".$yeni_ad;



        //dosya boyutu

        $boyut=$_FILES["resim"]["size"][$i];



//upload fonksiyonumuzu çağırdık. Bu fonksiyon iki parametre alıyor. birincisi değere bunu verdik; dosyalar servere upload edilirken farklı bir isim alır. ikinci değer olarak da bizim oluşturduğumuz şsmi vermesini istedik.

        if(move_uploaded_file($_FILES["resim"]["tmp_name"][$i], $dosya_url)){



          //echo 'dosya başarıyla yüklendi';





        }else{

           $mesaj1="Dosya yüklenemedi.";

            $tur1=0;

            sessioncreate($mesaj1,$tur1);

            echo '<meta http-equiv="refresh" content="3;url=index.php">';

            header("Refresh: 3; url=index.php");

        }





      

      }else{

         $mesaj2="Dosya formatı jpeg ve ya png olabilir!";

            $tur2=0;

            sessioncreate($mesaj2,$tur2);

            echo '<meta http-equiv="refresh" content="2;url=index.php">';

            header("Refresh: 2; url=index.php");

      }



    }else{

      $mesaj2="Dosya boyutu 5 Mg yi geçemez!";

            $tur2=0;

            sessioncreate($mesaj2,$tur2);

            echo '<meta http-equiv="refresh" content="1;url=index.php">';

            header("Refresh: 1; url=index.php");

    }



  }









if($_POST){

        

            $stmt=$db->prepare("INSERT INTO resimler (resim_url,resim_boyutu,resim_turu) VALUES(?,?,?)"); 

            if($stmt===false) die("Sorgu hatası:".$db->error);



            $stmt->bind_param("sis",$dosya_url,$boyut,$uzanti); //resim bilgileri gönderiliyor. 

      

      //execute ile sorguyu çalıştıralım

      $stmt->execute();



//veri tabanına kaydedilen resmin id sini alıyoruz

$fotoID=$stmt->insert_id;





//alınan idleri veritabanında ilanresimler tablosuna kaydediz

$stmt=$db->prepare("INSERT INTO ilanresimler (fotoID,ilanResimID) VALUES(?,?)"); 

            if($stmt===false) die("Sorgu hatası:".$db->error);





            $stmt->bind_param("is",$fotoID,$ilanID); //resim bilgileri gönderiliyor. 

            $stmt->execute();



      //kayıt durumunu elde edelim

      //echo '<b> Tabloya '.$db->affected_rows.'Kayıt yapıldı : İlan Başarıyla Kaydedildi. </b>'.@$yeni_ad.'<br/>';

      echo '<meta http-equiv="refresh" content="3;url=ilanlarim.php?git=ilanlarim&kategori=kiralikevilanlarim">';



      

}}



//resmin uzantısını veren fonksiyon

  function uzanti($dosya) {

        $uzanti = pathinfo($dosya);

        $uzanti = $uzanti["extension"];

        return $uzanti;

        }

    ?>

