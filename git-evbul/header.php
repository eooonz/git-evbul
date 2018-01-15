<?php
@session_start(); ob_start();

include_once('fonksiyonlar.php');

$title=empty($title) ? "kalacak yer, ev arkadaşı, kralık ev bul" : $title;
$keywords=empty($keywords) ? "ev arkadaşı arayanlar,evarkadaşı arıyorum, istanbul ev arkadaşı, bayan ev arkadaşı" : $keywords;
$description=empty($description) ? "ev arkadaşı arayanlar ile kalacak yer arayanları bir araya getiren ev arkadaşı bulma sitesi" : $description;

?>

<!DOCTYPE html>

<html lang="tr">
<meta charset="UTF-8">
<head>

<title><?php echo @$title; ?> </title>

<link rel="icon" type="image/png" href="/image/favicon_evbulkur.png" />
<meta charset="UTF-8" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta name="robots" content="index"/>
<meta name="rating" content="General" /> <!--Sayfanın içeriğinin kimlere hitap ettiğini söylüyoruz, herkese dedik -->
<meta name="publisher" content="Ev Bul Kur" />
<meta name="keywords" content="<?php echo @$keywords; ?> "/>
<meta name="description" content="<?php echo @$description; ?> "/>


 	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.css" />
  <link rel="stylesheet" href="assets/style.css"/>
  <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	<script src="assets/bootstrap/js/bootstrap.js"></script>s
  <script src="assets/script.js"></script>


<!-- Owl stylesheet -->

<link rel="stylesheet" href="assets/owl-carousel/owl.carousel.css">
<link rel="stylesheet" href="assets/owl-carousel/owl.theme.css">
<script src="assets/owl-carousel/owl.carousel.js"></script>

<!-- Owl stylesheet -->

<!-- slitslider -->

    <link rel="stylesheet" type="text/css" href="assets/slitslider/css/style.css" />
    <link rel="stylesheet" type="text/css" href="assets/slitslider/css/custom.css" />
    <script type="text/javascript" src="assets/slitslider/js/modernizr.custom.79639.js"></script>
    <script type="text/javascript" src="assets/slitslider/js/jquery.ba-cond.min.js"></script>
    <script type="text/javascript" src="assets/slitslider/js/jquery.slitslider.js"></script>

<!-- slitslider -->


<link rel="stylesheet" type="text/css" href="assets/css/ev.css" /> 
<link rel="stylesheet" type="text/css" href="assets/css/giriskayit.css"> <!--kayıt ol stil-->
<link rel="stylesheet" type="text/css" href="assets/css/ilanlar.css" />
<link rel="stylesheet" type="text/css" href="assets/css/formevarkadasi.css" />

<!-- Global Site Tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-107295971-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments)};
  gtag('js', new Date());

  gtag('config', 'UA-107295971-1');
</script>

</head>


<body>

<?php
//kullanıcıya iletilecek mesaj varsa gösteriyoruz
mesajvar();
?>

<!-- Header Starts -->

<div class="navbar-wrapper navbar-fixed-top">

    <div class="navbar-inverse" role="navigation">

      <div class="container">

        <div class="navbar-header">

          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">

            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>

          </button>

        </div>


        <!-- Nav Starts -->

        <div class="navbar-collapse  collapse">

          <ul class="nav navbar-nav navbar-left">

           <li class="active"><a href="http://www.evbulkur.com" title="istanbul, izmir, ankara, Ev Bul Kur">Anasayfa</a></li>

            <li><a href="hakkimizda.php" title="Ev arkadaşı bulma sitesi">Hakkımızda</a></li>
            <li><a href="formkalacakyer.php" title="Kalacak Yer Arıyorum">Kalacak Yer</a></li>
            <li><a href="formevarkadasi.php" title="Ev Arkadaşı Arıyorum">Ev Arkadaşı</a></li> 
            <li><a href="formkiralikev.php" title="Ev Kiralıyorum">Kiralık Ev</a></li>

            <!--<li><a href="agents.php">üyeler (Acentelerimiz)</a></li>         

            <li><a href="blog.php">Blog</a></li>

            <li><a href="contact.php">İletişim</a></li>

            -->

          </ul>


          <ul class="nav navbar-nav navbar-right">
 

            <?php

            include_once 'oturumkontrolu.php'; //dönen değer  

          $giren_id_aldik=oturumkontrolu();

         if($giren_id_aldik != false){

          include 'baglan.php';
          $uye_pre=$db->prepare("SELECT * FROM uye WHERE uyeID=$giren_id_aldik");
          $uye_pre->execute();
          $uye_result=$uye_pre->get_result();
          $uye_fetch=$uye_result->fetch_assoc();
          $isim=$uye_fetch['ad'];

          $mesajlarim_sorgu=$db->prepare("SELECT okundumu FROM mesajlar WHERE aliciID=$giren_id_aldik ORDER BY mesajID DESC");
          $mesajlarim_sorgu->execute();
          $mesajlarim_result=$mesajlarim_sorgu->get_result();
          $mesajvarmi=$mesajlarim_result->num_rows;
         
          $okundumu=$mesajlarim_result->fetch_array();

          echo '
          <li><div style="margin-top:8px; color:green; font-weight: bold; font-family:Tangerine;">Merhaba, '.$isim.'</div></li>';

          
            if($okundumu[0] == 2){
               echo'<li><a style="color:green; font-weight:bold;" href="mesajlarim.php">Mesajın Var</a></li>';
            }else{
              echo'<li><a href="mesajlarim.php">Mesajlarım</a></li>'; 
            }

          echo'
          <li><a href="ilanlarim.php">İlanlarım</a></li>

          <li><a href="profilim.php">Profilim</a></li>

          <li><a href="cikisyap.php">Çıkış Yap</a></li>';

         }else{

        echo '<li><a href="#" data-toggle="modal" data-target="#loginpop">Giriş Yap</a></li>

        <li><a href="register.php">Üye Ol</a></li>' ;

        }

        ?>

          </ul>

        </div>

        <!-- #Nav Ends -->

      </div>

    </div>

</div>

<!--******************************* -->



<!-- #Header Starts -->

<div class="container" style="margin-top: 30px">

<!-- Header Starts -->

<div class="header">

<a href="http://www.evbulkur.com" title="istanbul,İzmir,Ankara,Bursa,Adana"><img src="images/evbulkurlogo.png" alt="EvBulKur.com"></a>
<?php if($giren_id_aldik != false){ ?>
<!--
<ul class="pull-right hidden-xs" style="text-align: left;">
    <li><a href="formkalacakyer.php" title="Kalacak Yer Arıyorum">Kalacak Yer İlanı Bırak</a></li><li style="font-size: 25px;">|</li>
    <li><a href="formevarkadasi.php" title="Ev Arkadaşı Arıyorum">Ev Arkadaşı İlanı Bırak</a></li><li style="font-size: 25px;">|</li>    
    <li><a href="formkiralikev.php" title="Ev Kiralıyorum">Kiralık Ev İlanı Bırak</a></li>
</ul>
-->
<?php }else{
  //Reklam alanı
  echo "<a href='register.php'><img style='border:1px dashed #555;' src='images/728-90.jpg' class='img-responsive pull-right hidden-xs'/></a>";
  }
  ?>
</div>

<!-- #Header Starts -->

</div>
