<?php

include_once 'oturumkontrolu.php'; //dönen değer $giren_id_aldik 

$sayfa_url=$_GET['git'];

require_once('baglan.php');

    $giris_id_aldik=oturumkontrolu();


$stmt=$db->prepare("SELECT * FROM kiralikevilani where url='$sayfa_url'");

  $stmt->execute();

  $result=$stmt->get_result();

  //ilan linki doğru girilmemişse veritabanında lik bulunamaz ve bizde burada hata verdirtiyoruz. Fakat tasarımı düzenlenmeli 

  $varmi=$result->num_rows;

  if($varmi < 1){echo "aradığınız ilan bulunamadı."; exit;}

  $row=$result->fetch_array();

  $ilan_id=$row['kilanID'];

  $ilan_resim_id="ki"."$ilan_id";

  $ilan_url="evbulkur.com/kiralikevbuldum.php?git=".$row['url'];
  $ilan_baslik=$row['ilanBasligi'];

  $stmt->close(); 

  //il isim çekme

  $il_stmt=$db->prepare("SELECT ilID,ilceID,baslik from kiralikevilani as k inner join muh_iller as il on k.ilID=il.ID where k.kilanID ='$ilan_id'");

  $il_stmt->execute();

  $result_il=$il_stmt->get_result();

  $row_il=$result_il->fetch_array();


  $ilceID=$row['ilceID'];

  $ilID=$row['ilID'];

  //ilçe isim çekme

  $ilce_stmt=$db->prepare("SELECT baslik from muh_ilceler where id='$ilceID'");

  $ilce_stmt->execute();

  $result_ilce=$ilce_stmt->get_result();

  $row_ilce=$result_ilce->fetch_array();


  //ısınma şekli çekme

  $isitma=$row['isinmaSekliID'];

  $isinma_stmt=$db->prepare("SELECT isinmaSekli from isitmasekli where isinmaID=$isitma");

  $isinma_stmt->execute();

  $result_isinma=$isinma_stmt->get_result();

  $row_isinma=$result_isinma->fetch_array();


  //ilana ait resim var mı kontrol ediyoruz yoksa slideri gizliyoruz
$resim_id_stmt=$db->prepare("SELECT fotoID FROM ilanresimler where ilanResimID='$ilan_resim_id'");

$resim_id_stmt->execute();

$result_resim_id=$resim_id_stmt->get_result();
 

$resim_url=$db->prepare("SELECT * from ilanresimler as i inner join resimler as r on i.fotoID=r.id where i.ilanResimID ='$ilan_resim_id'");

$resim_url->execute();

$result_resim_url=$resim_url->get_result();

 $resimvarmi=$result_resim_url->num_rows;




  $ilansahibiid=$row['girenID'];

  $sahip=$db->prepare("SELECT * FROM uye WHERE uyeID=$ilansahibiid");

  $sahip->execute();

  $sahipresult=$sahip->get_result();

  $sahipbilgi=$sahipresult->fetch_assoc();



  $cinsiyet=$sahipbilgi['cinsiyet'];

   

  $profilresmi=$sahipbilgi['profilResmi'];



   if(empty($profilresmi)){

        if($cinsiyet == 1){

        $profilresmi="image/default_erkek.png";

      }else{$profilresmi="image/default_kadin.png";}

    }



$db->close();

$title=$row['ilanBasligi'];
$keywords=$row['keywords'];
$description=$row['description']; 

include_once 'header.php'; ?>



<div class="col-lg-12 col-md-12">

  <div class="row">

    <div class="container-fluid">

<!-- banner -->

<div class="inside-banner">

  

</div>

<!-- banner -->



<div class="container">

<div class="properties-listing spacer">

<div class="row">

<div class="col-lg-3 col-sm-4 hidden-xs">

<div class="hot-properties hidden-xs">

<h4>Şehirdeki Benzer İlanlar</h4>

<?php

//şehirdeki diğer ilanlar

include 'kiralikevsehirdekidigerilanlar.php';

?>

</div>



<div class="advertisement">

  <h4>Reklam Alanı</h4>

  <img src="images/advertisements.jpg" class="img-responsive" alt="advertisement">

</div>

</div>

<div class="col-lg-9 col-sm-8 ">

<h3><?php echo $row['ilanBasligi']; ?></h3>

<div class="row">

  <div class="col-lg-8">

  <div class="property-images">

    <!-- Slider Starts -->

<?php 
if($resimvarmi < 1){

echo "<div>
  <img data-u='image' class='img-responsive' src='image/default_kiralik_ev.jpg' />
</div>";


        }else{include_once'ilan-slider.php';} ?>

<!-- #Slider Ends -->

  </div>

  <div class="spacer"><h4><span class="glyphicon glyphicon-th-list"></span> İlan açıklaması</h4>

  <p><?php echo $row['ilanAciklama']; ?></p>

  </div>

  <div class="spacer"><h4><span class="glyphicon glyphicon-th-list"></span> Adres</h4>

  <p><?php echo $row['adres']; ?></p>

  </div>

  <div class="col-lg-12 col-sm-6 ">

<div class="enquiry">

   <h4>Diğer İnsanlarla Paylaş</h4>
  <div class="social_area wow fadeInLeft">
  <div class="pw-widget pw-size-large">
  
    <a class="pw-button-facebook"></a>
    <a class="pw-button-twitter"></a>
     <a class="pw-button-googleplus"></a>
     <a class="pw-button-linkedin"></a>
     <a class="pw-button-pinterest"></a>
     <a class="pw-button-tumblr"></a>
  
  </div>
  <script src="http://i.po.st/static/v3/post-widget.js#publisherKey=ree2tvdnq33tbm2u2lfh" type="text/javascript"></script>
</div> <br/>

<?php

if(!$giris_id_aldik){ //üye giriş yapmamışsa bur formu göstererek üye olabilmesini sağlıyoruz üyeyse giriş yapsın
echo '<h6><span class="glyphicon glyphicon-envelope"></span>İlan Sahibine Mesaj Gönder</h6>';
  echo "Üyeyseniz <a href='#' style='font-size:15px; border:1px solid green; padding:2px;' data-toggle='modal' data-target='#loginpop'>giriş</a> yapın, değilseniz aşağıdaki formu doldurarak üye olabilirsiniz.";

?>

  <?php include'registerform.php';?>

  

<?php }else{

  
if($giris_id_aldik != $row['girenID']){
  echo '<h6><span class="glyphicon glyphicon-envelope"></span>İlan Sahibine Mesaj Gönder</h6>';
  include 'mesajkutusu.php';
}
  

  } ?>

 </div>         

</div>



  <!--

  <div><h4><span class="glyphicon glyphicon-map-marker"></span> Location</h4>

<div class="well"><iframe width="100%" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=Pulchowk,+Patan,+Central+Region,+Nepal&amp;aq=0&amp;oq=pulch&amp;sll=37.0625,-95.677068&amp;sspn=39.371738,86.572266&amp;ie=UTF8&amp;hq=&amp;hnear=Pulchowk,+Patan+Dhoka,+Patan,+Bagmati,+Central+Region,+Nepal&amp;ll=27.678236,85.316853&amp;spn=0.001347,0.002642&amp;t=m&amp;z=14&amp;output=embed"></iframe></div>

  </div>

-->

  </div>

  <div class="col-lg-4">

  <div class="col-lg-12  col-sm-6">

<div class="property-info">

<p class="price">Kira: <?php echo $row['evinKirasi']; ?> tl</p>

  <p class="area"><span class="glyphicon glyphicon-map-marker"></span><?php echo $row_il['baslik'].' /'.$row_ilce['baslik']; ?></p>

  

  <div class="profile">

  <span class="glyphicon glyphicon-user"></span> İlanı kim yükledi?

  <p><?php echo $sahipbilgi['ad'] . " " . $sahipbilgi['soyad']; ?><br>



  <div style="background-color: white; margin-bottom: 10px; max-width: 200px; border:1px solid #ccc">

    <img class="img-responsive" style="max-height: 200px; margin: auto; " src="<?php echo $profilresmi; ?>"/>

  </div>



  <?php if($giris_id_aldik){ ?>

  <span class="glyphicon glyphicon-envelope"></span><?php echo $sahipbilgi['email']; ?><br/>

  <span class="glyphicon glyphicon-earphone"></span><?php echo $sahipbilgi['telefonNo']; ?>

<?php }else{echo "<span class='glyphicon glyphicon-envelope'></span>

        <span class='glyphicon glyphicon-earphone'></span>

        Kanka, iletişim bilgilerini görmek için giriş yapmalısın.";}

?>

  </p>

  </div>

</div>



    <h6><span class="glyphicon glyphicon-home"></span> Detay </h6>



  <div class="listing-detail"><div><div style="margin-left:20px">



    <div data-toggle="tooltip" data-placement="bottom" data-original-title="İlan eklneme tarihi">İlanın eklenme tarihi: <?php echo $row['ilanTarihi']; ?></div>



    <?php if($row['esyaliMi'] == 1){

        $esya="Evet";

     }else{$esya="Hayır";} 

     ?>

    

    <div data-toggle="tooltip" data-placement="bottom" data-original-title="Kaçıncı kat">Eşyalı mı?: <?php echo $esya; ?></div>



    <div data-toggle="tooltip" data-placement="bottom" data-original-title="Kaçıncı kat">Isınma şekli: <?php echo $row_isinma['isinmaSekli']; ?></div>



    <div data-toggle="tooltip" data-placement="bottom" data-original-title="Odalı">Oda Sayısı: <?php echo $row['odaSayisi']; ?></div> 

    <div data-toggle="tooltip" data-placement="bottom" data-original-title="metre kare">Metrekare: <?php echo $row['metrekare']; ?> m²</div>

     <div data-toggle="tooltip" data-placement="bottom" data-original-title="Kaçıncı kat">Kaçıncı kat: <?php echo $row['kacinciKat']; ?></div> 

    <?php
     //gosterim güncelleme
      $gosterim=$row['gosterim'] + 1;
      $gosterim=$db->prepare("UPDATE kiralikevilani SET gosterim=$gosterim WHERE kilanID=$ilan_id");
      $gosterim->execute();
    ?>

     </div>

     </div>



</div>



  </div>

</div>

</div>

</div>

</div>

</div>

<hr/>
</div></div></div>
<?php include'footer.php';?>