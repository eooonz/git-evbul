<?php
@session_start();

include_once('relsrc.php'); //stil dosyaları yollları 
include_once('fonksiyonlar.php'); //fonksiyonlar
include_once 'oturumkontrolu.php'; //dönen değer  

    $giren_id_aldik=oturumkontrolu();?>

<?php if(!$giren_id_aldik){

  /*Daha sonra üye girişi yapmamış üyeyi, üyelik bilgilerini ilan üzerinde isteyerek de ilan girmesini kolaylaştırmış oluruz. Üye değilse mail adresini ve şifresini kaydederek "mail adresinize gönderilen linke tıkladığınızda ilanınız yayınlanbacaktır" diyebiliriz.*/

echo '<meta http-equiv="refresh" content="0;url=index.php"> ';
exit;
}

  if(isset($_POST)){
    require_once('baglan.php');

//Üye bilgilerini alıyoruz

    $giren_bilgileri=$db->prepare("SELECT * FROM uye WHERE uyeID=?");

    $giren_bilgileri->bind_param('i',$giren_id_aldik);

    $giren_bilgileri->execute();

    $result=$giren_bilgileri->get_result();

    $bilgiler=$result->fetch_array();



//Güvenlik için girilen şifre doğru mu kontrolü

    $kullanici_sifresi=$bilgiler['sifre'];

    $girilen_sifre=md5($_POST['guvenlik_password']);



    if($kullanici_sifresi != $girilen_sifre){

    	$mesaj1="Yanlış Şifre Girdiniz!!!";
		$tur1=0;
		sessioncreate($mesaj1,$tur1);

    	//Gelinen sayfaya geri dön
		$gelinen_url = htmlspecialchars($_SERVER['HTTP_REFERER']);  // hangi sayfadan gelindigi degerini verir.
		echo '<meta http-equiv="refresh" content="0;url='.$gelinen_url.'"> ';

    	exit;

    }

	if(!empty($_POST['email'])){

	//girilen mail sisteme daha önceden kaydedilmiş mi kontrol ediyoruz. Varsa hata veriyoruz. Yoksa çerez oluştur

	$email=guvenlik_fonksiyonu($_POST['email']);

	$mail_tekar=$db->query("SELECT * FROM uye WHERE email='$email'");

	$num_rows = mysqli_num_rows($mail_tekar);



		if($num_rows > 0){

		$mesaj2="Bu mail sistemde zaten kayıtlı. Aynı mail iki kere kullanılamaz.";
		$tur1=0;
		sessioncreate($mesaj2,$tur1);

    	//Gelinen sayfaya geri dön
		$gelinen_url = htmlspecialchars($_SERVER['HTTP_REFERER']);  // hangi sayfadan gelindigi degerini verir.
		echo '<meta http-equiv="refresh" content="0;url='.$gelinen_url.'"> ';
			

			exit;

		}

	}



//ad güncellemesi 

	if(!empty($_POST['ad'])){

	    $ad=guvenlik_fonksiyonu($_POST['ad']);

		$isim_guncelle=$db->prepare("UPDATE uye SET ad=? WHERE uyeID=?");

		$isim_guncelle->bind_param('si',$ad,$giren_id_aldik);

		$isim_guncelle->execute();

	}

	if(!empty($_POST['soyad'])){

		$soyad=guvenlik_fonksiyonu($_POST['soyad']);

		$soyad_gucelle=$db->prepare("UPDATE uye SET soyad=? WHERE uyeID=?");

		$soyad_gucelle->bind_param('si',$soyad,$giren_id_aldik);

		$soyad_gucelle->execute();

	}

	if(!empty($_POST['email'])){

		$email=guvenlik_fonksiyonu($_POST['email']);

		$email_guncelle=$db->prepare("UPDATE uye SET email=? WHERE uyeID=?");

		$email_guncelle->bind_param('si',$email,$giren_id_aldik);

		$email_guncelle->execute();

	}

	if(!empty($_POST['phone'])){



		$telefon=guvenlik_fonksiyonu($_POST['phone']);

		$telefon_guncelle=$db->prepare("UPDATE uye SET telefonNo=? WHERE uyeID=?");

		$telefon_guncelle->bind_param('si',$telefon,$giren_id_aldik);

		$telefon_guncelle->execute();

	}

	if(!empty($_POST['cinsiyet'])){

		$cinsiyet=guvenlik_fonksiyonu($_POST['cinsiyet']);

		$cinsiyet_guncelle=$db->prepare("UPDATE uye SET cinsiyet=? WHERE uyeID=?");

		$cinsiyet_guncelle->bind_param('ii',$cinsiyet,$giren_id_aldik);

		$cinsiyet_guncelle->execute();

	}

	if(!empty($_POST['il'])){

		$il=guvenlik_fonksiyonu($_POST['il']);

		$il_guncelle=$db->prepare("UPDATE uye SET sehirID=? WHERE uyeID=?");

		$il_guncelle->bind_param('ii',$il,$giren_id_aldik);

		$il_guncelle->execute();

	}

	if(!empty($_POST['ilce'])){

		$ilce=guvenlik_fonksiyonu($_POST['ilce']);

		$ilce_guncelle=$db->prepare("UPDATE uye SET ilceID=? WHERE uyeID=?");

		$ilce_guncelle->bind_param('ii',$ilce,$giren_id_aldik);

		$ilce_guncelle->execute();

	}

	if(!empty($_POST['password'])){

		$password=md5(guvenlik_fonksiyonu($_POST['password']));

		$password_guncelle=$db->prepare("UPDATE uye SET sifre=? WHERE uyeID=?");

		$password_guncelle->bind_param('si',$password,$giren_id_aldik);

		$password_guncelle->execute();

	}



		$mesaj2="Değişiklikler kaydedildi patron.";
		$tur1=1;
		sessioncreate($mesaj2,$tur1);

		echo '<meta http-equiv="refresh" content="0;url=profilim.php">';


}else{

  echo "Hata! Formdan bigliler gelmedi.";
  		$mesaj2="Hata! Formdan bigliler gelmedi. Yeniden deneyin, problem devam ederse bize yazın.";
		$tur1=0;
		sessioncreate($mesaj2,$tur1);

		echo '<meta http-equiv="refresh" content="0;url=profilim.php">';

}





//Mail adresini değiştirince ad ve mail placeholder da gözükmüyor

    ?>