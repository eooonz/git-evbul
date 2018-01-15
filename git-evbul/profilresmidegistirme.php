<?php
@session_start();


include_once 'oturumkontrolu.php';
$giren_id_aldik=oturumkontrolu();


if(isset($_POST)){ 
  include_once 'fonksiyonlar.php';
  include_once('baglan.php');

  if($_FILES["profilresmi"]["size"] < 1024*1024*5){

    if($_FILES["profilresmi"]["type"] == "image/jpeg" || $_FILES["profilresmi"]["type"] == "image/png"){

      //post metodundan gelen resmin ismini $dosya_adi değişkenine atadık

      $dosya_adi=$_FILES["profilresmi"]["name"];

      //aynı isimde dosya yüklenme ihtimaline karşı ratgele bir karakterler ekleyerek, resme yeniden isim vereceğiz

      $uret=array("as","rt","ty","yu","fg");

      /*dosyanın uzantısını alıyoruz, substr fonksiyonunda negatif verdiğimizde değeri sondan başa doğru kırmaya başlar; -5 karakter başa gel ve 5 karakter kırp. 5 yamamınzın nedeni jpeg gibiformatlarda noktayı da alabilmek

      $uzanti=substr($dosya_adi,-5,5); */

      //resmin uzantısını alıyoruz

      $uzanti=uzanti($dosya_adi);


      $sayi_tut=rand(1,100000);


      //resmin yeni adı

      $yeni_ad=time().$uret[rand(0,4)].$sayi_tut.".".$uzanti; 

      //uret dizisinden ratgele bir değer çekiyoruz rastgele oluşturulan sayı ile birleştiriyoruz ve sonuna da uzantıyı ekliyoruz. Aslında dosya uzantımızın başta sadece jpeg olacağını belirtmiştik, bu örnek için sonuna doğrudan jpeg de ekletebilirdik. Başına koyduğumuz upload_resimler/ ile de dosyanın tam yolunu belirtmiş oluyoruz,böylece dosyanın yeni ismini belirledik.

      //dosya yolu

      $dosya_url="upload_resimler/".$yeni_ad;



      //dosya boyutu

      $boyut=$_FILES["profilresmi"]["size"];


      //upload fonksiyonumuzu çağırdık. Bu fonksiyon iki parametre alıyor. birincisi değere bunu verdik; dosyalar servere upload edilirken farklı bir isim alır. ikinci değer olarak da bizim oluşturduğumuz şsmi vermesini istedik.

      if(move_uploaded_file($_FILES["profilresmi"]["tmp_name"], $dosya_url)){

        $mesaj1="Profil resmi değiştirildi..";
        $tur1=1;
        sessioncreate($mesaj1,$tur1);
        echo '<meta http-equiv="refresh" content="0;url=profilim.php"> ';

      }else{

        $mesaj1="Dosya yüklenemedi.";
        $tur1=0;
        sessioncreate($mesaj1,$tur1);
        echo '<meta http-equiv="refresh" content="3;url=profilim.php">';
        header("Refresh: 3; url=profilim.php");

      }


    }else{

      $mesaj2="Dosya formatı jpeg ve ya png olabilir!";
      $tur2=0;
      sessioncreate($mesaj2,$tur2);
      echo '<meta http-equiv="refresh" content="2;url=profilim.php">';
      header("Refresh: 2; url=profilim.php");

    }

  }else{

    $mesaj2="Dosya boyutu 5 Mg yi geçemez!";
    $tur2=0;
    sessioncreate($mesaj2,$tur2);
    echo '<meta http-equiv="refresh" content="1;url=profilim.php">';
    header("Refresh: 1; url=profilim.php");

  }

  //uye tasblosuna resmin urlsini kaydediyoruz

  $profilresmi_uye=$db->prepare("UPDATE uye SET profilResmi=? WHERE uyeID=?");
  $profilresmi_uye->bind_param('si',$dosya_url,$giren_id_aldik);
  $profilresmi_uye->execute();

}else{

  $mesaj4="Resim alınırken hata oluştu!";
  $tur4=0;
  sessioncreate($mesaj4,$tur4);
  echo '<meta http-equiv="refresh" content="1;url=profilim.php">';
  header("Refresh: 1; url=profilim.php");

}

 //resmin uzantısını veren fonksiyon
function uzanti($dosya){

  $uzanti = pathinfo($dosya);
  $uzanti = $uzanti["extension"];

  return $uzanti;

}

?>
