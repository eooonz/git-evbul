<?php
@session_start();

if($_POST['captcha'] != $_SESSION['captcha']){
	echo "Doğru cevap: ".$_SESSION['captcha']. "<br/>";
	echo "Güvenlik doğrulamasını geçemediniz. Lütfen üzerinbizdeki metal eşyaları çıkararak yeniden deneyin!";
	$gelinen_url = htmlspecialchars($_SERVER['HTTP_REFERER']);  // hangi sayfadan gelindigi degerini verir.
	echo '<meta http-equiv="refresh" content="5;url='.$gelinen_url.'"> ';
	exit;
}

include_once 'fonksiyonlar.php';

//kayıt

require_once('baglan.php');


//Alan boş mu girilmiş kontrolleri

if(empty($_POST['name'])){

	$mesaj6="isim alanını boş geçemezsiniz!";
            $tur4=0;
            sessioncreate($mesaj6,$tur4);
            

}else{

	$isim = guvenlik_fonksiyonu(htmlspecialchars($_POST['name'], ENT_QUOTES));

}



if(empty($_POST['email'])) {

	$mesaj7="E-posta alanını boş geçemezsiniz!";
            $tur4=0;
            sessioncreate($mesaj7,$tur4);

}else{

	$email = guvenlik_fonksiyonu(htmlspecialchars($_POST['email'], ENT_QUOTES));

}

  

  if(empty($_POST['password'])){

	$mesaj84="Şifre alanını boş geçemezsiniz!";
            $tur4=0;
            sessioncreate($mesaj8,$tur4);

} else {

	$sifre = MD5(guvenlik_fonksiyonu($_POST['password']));

}


if($_POST['cinsiyet'] == "1"){

		$cinsiyet="1";

		$profilresmi="image/p".rand(1,4).".jpg";

	}else{

		$cinsiyet="0";

		$profilresmi="image/p".rand(5,8).".jpg";

	}

	

//alan boş mu girilmiş kontrolleri end

//girilen mail sisteme daha önceden kaydedilmiş mi kontrol ediyoruz. Varsa hata veriyoruz. Yoksa çerez oluştur



$mail_tekar=$db->query("SELECT * FROM uye WHERE email='$email'");

$num_rows = mysqli_num_rows($mail_tekar);



if($num_rows > 0){

	$mesaj9="Bu mail ile daha önce kayıt yapılmış. Farklı email ile tekrar deneyin!";
	$tur4=0;
	sessioncreate($mesaj9,$tur4);
	header("Refresh: 0; url=register.php");

	exit;

}


$s=$db->prepare("INSERT INTO uye(ad, email,sifre,cinsiyet,profilResmi) VALUES(?,?,?,?,?)");

$s->bind_param("sssis", $isim, $email, $sifre,$cinsiyet,$profilresmi);

$s->execute();


//kayıt başarılıysa

if($s->affected_rows >0){

$mesaj10="Tebrikler,kayıt başarılı. Siteye giriş yapabilirsiniz. ";
	$tur5=1;
	sessioncreate($mesaj10,$tur5);
 //Burada mailine onay kodu gönderilip, hesabını onaylaması istenebilir.

echo '<meta http-equiv="refresh" content="0;url=register.php"> ';

}else{

	$mesaj11="Kayıt yapılamadı, istenilen bilgileri eksiksiz doldurup tekrar deneyin...";
	$tur4=0;
	sessioncreate($mesaj11,$tur4);
echo '<meta http-equiv="refresh" content="0;url=register.php"> ';

	exit;

	

}

$db->close();



?>
