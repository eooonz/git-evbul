<?php 
include_once('relsrc.php'); //stil dosyaları yollları 
include_once 'oturumkontrolu.php'; //dönen değer  
    $giren_id_aldik=oturumkontrolu();?>
<?php if(!$giren_id_aldik){
  /*Daha sonra üye girişi yapmamış üyeyi, üyelik bilgilerini ilan üzerinde isteyerek de ilan girmesini kolaylaştırmış oluruz. Üye değilse mail adresini ve şifresini kaydederek "mail adresinize gönderilen linke tıkladığınızda ilanınız yayınlanbacaktır" diyebiliriz.*/
  
$mesaj1="Burayı görebilmek için giriş yapmalısınız";
    $tur1=0;
    sessioncreate($mesaj1,$tur1);
echo '<meta http-equiv="refresh" content="0;url=index.php"> ';
exit;
}

$title="İlanlarım: EvBulKur";

require_once('baglan.php');

$stmt=$db->prepare("SELECT * FROM uye WHERE uyeID='$giren_id_aldik'");
$stmt->execute();
$result_uye_bilgi=$stmt->get_result();
$uye_bilgi=$result_uye_bilgi->fetch_array();


?>


<?php include_once'header.php';?>
<?php include_once'fonksiyonlar.php';?>
<!-- banner -->
<div class="inside-banner">
  <div class="container"> 
    <span class="pull-right"><a href="index.php">Anasayfa</a> / İlanlarım</span>
    <h2>İlanlarım</h2>
</div>
</div>
<!-- banner -->
<!-- <div class="container">  -->
<div class="properties-listing spacer">


<!-- İlanlarim-->
  <div class="cerceve cerceve-renk">
   <div class="row">
   <div class="container-fluid">      

      <div class="col-md-3">

        <?php
        //profil biglilerinin navigasyon kutusunu include ettik
         include_once 'profil_navigation.php';
        ?>

      </div>

      <div class="col-md-9">

          <div class="row"><!-- ilan açıklama satırı-->

          <?php 
          $a=@$_GET['kategori'];
        switch($a){

          case '':
          include ("kalacak_yer_ilanlarim_profil.php");
          break;

          case 'kalacakyerilanlarim':
          include ("kalacak_yer_ilanlarim_profil.php");
          break;

          case 'evarkadasiilanlarim':
          include ("ev_arkadasi_ilanlarim_profil.php"); //tumilanlar.php
          break;

          case 'kiralikevilanlarim':
          include("kiralik_ev_ilanlarim_profil.php");
          break;

          case 'kiralikevilaniduzenle':
          include("kiralik_ev_ilani_duzenle.php");
          break;

          case 'evarkadasiilaniduzenle':
          include("ev_arkadasi_ilani_duzenle.php");
          break;

          case 'kalacakyerilaniduzenle':
          include("kalacak_yer_ilani_duzenle.php");
          break;

          default:
          echo "<h3 style='color:red'>böyle bir sayfa yok!</h3>";
          break;
            }  
              
              //include 'ilanlartab.php';include 'kalacak_yer_ilanlarim_profil.php';
              ?>

          </div>

      </div>

   </div>
   </div>



    </div> 
    <!--ilanlarim end-->

   
</div>
</div>

</div></div></div>
<?php include_once'footer.php';?>