
<?php
//veri tabanı bağlantı işlemleri
/*
$host      = "localhost";
$kullanici = "root";
$sifre     = "";
$veritabani="evbulkur";

$db=@new mysqli($host,$kullanici,$sifre,$veritabani);
      if($db->connect_errno) die ('Bağlantı hatası: '.$db->connect_eror);

    $db->set_charset("utf8");
   */
    $db=@new mysqli("localhost","evbulku1_user","Otoriter.81","evbulku1_db");
      if($db->connect_errno) die ('Bağlantı hatası: '.$db->connect_eror);

      $db->set_charset("utf8");
      
?>