<?php session_start(); 
include_once 'fonksiyonlar.php';


$gizli_anahtar = 'gizli anahtar';
$hata          = '';

@$email=guvenlik_fonksiyonu($_POST['email']);
@$password=guvenlik_fonksiyonu($_POST['password']);

if (isset($email) && isset($password)) {
    
    include 'baglan.php';
    
    //SQL Sorgusunu hazırlayalım
    $stmt = $db->prepare("SELECT * FROM uye WHERE email=? AND sifre=MD5(?)");
    if ($stmt === false)
        die('Sorgu hatası:' . $db->error);
    
    /*SQL deki ?,? için  veri tipini ve değişkeni tanımlayalım */
    $stmt->bind_param("ss", $email, $password);
    
    //SQL Sorgusunu çalıştıralım
    $stmt->execute();
    
    //Sonucu elde edelim
    $sonuc = $stmt->get_result();
    $bilgi=$sonuc->fetch_array();
    //num_rows 1 dönerse bilgiler doğrudur.Çerez ataması yapalım
    if ($sonuc->num_rows) {


        $_SESSION['girisbasarili'] = array($bilgi['uyeID'], "/",1);
        $_SESSION['anahtar'] = md5($_SERVER['HTTP_USER_AGENT']);
       
        
        $gelinen_url = htmlspecialchars($_SERVER['HTTP_REFERER']);  // hangi sayfadan gelindigi degerini verir.



        // Her şey yolunda olduğu için anasayfaya yönlendirelim
        
        $mesaj="Evine hoş geldin :)";
        $tur=1;
        sessioncreate($mesaj,$tur);

        echo '<meta http-equiv="refresh" content="0;url='.$gelinen_url.'"> ';
    } else {

        $mesaj="Giriş yapılamadı ...";
        $tur=0;
        sessioncreate($mesaj,$tur);

        $mesaj1='<b>Eposta veya şifre hatalı</b>';
        $tur1=0;
        sessioncreate($mesaj1,$tur1);
        echo '<meta http-equiv="refresh" content="0;url=index.php">';
    }
}
?>
