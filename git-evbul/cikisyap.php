<?php
@session_start(); 
ob_start();
include_once 'fonksiyonlar.php';
//session_start();
// oturumu oldurelim
unset($_SESSION['girisbasarili']);
unset($_SESSION['anahtar']);
// ansayfaya gidelim

$mesaj1="Çıkış başarılı. Kapıları kilitledik, pencereleri örttük :).";
$tur1=1;
sessioncreate($mesaj1,$tur1);
echo '<meta http-equiv="refresh" content="0;url=index.php">';
header("Refresh: 0; url=index.php");
exit;
?>
