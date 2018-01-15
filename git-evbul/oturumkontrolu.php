<?php

@session_start();

//oturum kontrolü: bu fonksiyonda giriş yapmış kişinin id sini alıyoruz. Güvenlik önlemi olarak da kullanıcının browser bilgisini md5 leyerek $kilit ismiyle kaydediyoruz. Login olurken $anahtar ismiyle session olarak kullanıcının browser bilgisi md5 olarak kaydetmiştik. $anahtar ve $kilit in uyuştuğunu kontol ediyoruuz

function oturumkontrolu(){

      $kilit = md5($_SERVER['HTTP_USER_AGENT']);

      if(isset($_SESSION['girisbasarili']) && $_SESSION['anahtar'] == $kilit){

            $session_id=$_SESSION['girisbasarili'][0];
      	/*$db=@new mysqli("localhost","root","","evbulkur");
            if($db->connect_errno) die ('Bağlantı hatası: '.$db->connect_eror);

            $db->set_charset("utf8");
       
      //giriş yapan kişinin mailini sorgulatarak üye ID sini alacağız

            $giren_id=$db->prepare("SELECT * FROM uye where email='$session_id'");
            $giren_id->execute();
            $result_id=$giren_id->get_result();
            $idaldik=$result_id->fetch_array();
       
            $giren_id_aldik=$idaldik['uyeID'];
            */

      	return $session_id;

 }else{
 	return false;
 }
 	
}

?>