<?php


include 'baglan.php';
include_once 'fonksiyonlar.php';

//ilan resimleri için sql sorgusu
    
    $resim_id_stmt=$db->prepare("SELECT fotoID FROM ilanresimler ");
    $resim_id_stmt->execute();
    $result_resim_id=$resim_id_stmt->get_result();

    $resim_url=$db->prepare("SELECT * from ilanresimler as i inner join resimler as r on i.fotoID=r.id ");
    $resim_url->execute();
    $result_resim_url=$resim_url->get_result();


//evarkadaşı yer ilanı bilgilerini çekiyoruz
    $evarkadasi_ilan_stmt=$db->prepare("SELECT * FROM evarkadasiilani ORDER BY ilanTarihi DESC LIMIT 11");
    $evarkadasi_ilan_stmt->execute();
    $evarkadasi_ilan_result=$evarkadasi_ilan_stmt->get_result();
    $varmi=$evarkadasi_ilan_result->num_rows;

/*echo '
<div class="properties-listing spacer"> <a href="aramasonuclari.php?kutu=&ilanara=evarkadasi" class="pull-right viewall">Tüm Ev Arkadaşı Arayan İlanları</a>';*/
echo '<div class="properties-listing spacer"><h3>Evine Arkadaş Arayanlar</h3>
<div id="owl-example" class="owl-carousel">
    ';

    if($varmi > 0){
    while($evarkadasi_ilan_fetch=$evarkadasi_ilan_result->fetch_assoc()){


      $ilan_id=$evarkadasi_ilan_fetch['ailanID'];
      $ilan_resim_id="e"."$ilan_id";

      $resim_id_stmt=$db->prepare("SELECT fotoID FROM ilanresimler where ilanResimID='$ilan_resim_id'");
      $resim_id_stmt->execute();
      $result_resim_id=$resim_id_stmt->get_result();

      $resim_url=$db->prepare("SELECT * from ilanresimler as i inner join resimler as r on i.fotoID=r.id where i.ilanResimID ='$ilan_resim_id'");
      $resim_url->execute();
      $result_resim_url=$resim_url->get_result();

      $row_resim_url=$result_resim_url->fetch_assoc();

      $ilID=$evarkadasi_ilan_fetch['ilID'];

      //il isim çekme
      $il_stmt=$db->prepare("SELECT * from muh_iller where id=$ilID");
      $il_stmt->execute();
      $result_il=$il_stmt->get_result();
      $row_il=$result_il->fetch_array();
      $iladi=$row_il['baslik'];

      //ilçe isim çekme
      $ilceID=$evarkadasi_ilan_fetch['ilceID'];
      $ilce_stmt=$db->prepare("SELECT baslik from muh_ilceler where id='$ilceID'");
      $ilce_stmt->execute();
      $result_ilce=$ilce_stmt->get_result();
      $row_ilce=$result_ilce->fetch_array();
      $ilceadi=$row_ilce['baslik'];
?>

      <!-- ***************** -->
      <?php 
        if($row_resim_url['resim_url']){
        $resim = $row_resim_url['resim_url'];
        }else{
        $resim="image/default_ev_arkadasi_icon.jpg";
        }
      ?>
      <!-- properties -->
      <form action="evarkadasibuldum.php" method="get">
      <div class="col-lg-12 col-sm-12">
      <div class="properties">

        <div class="image-holder"><div style="height:125px;margin:auto;"><img style="max-height:125px; margin:auto;" src="<?php echo $resim; ?>" class="img-responsive" alt="properties"></div>
        <?php
        if($evarkadasi_ilan_fetch['odasiOlacak'] == 1)
          {$a="Odan Olacak"; $b="sold";
          }else{$a="Oda Yok"; $b="new";}
        ?>
          <div class="status <?php echo $b; ?>"><?php echo $a; ?></div>
        </div>
        <h5 style="overflow:hidden;height:30px; font-size: 13px; text-transform: capitalize;"><a href="evarkadasibuldum.php?git=<?php echo $evarkadasi_ilan_fetch['url']; ?>">
          <?php echo stripslashes(baslikKisalt($evarkadasi_ilan_fetch['ilanBasligi']))." ..."; ?>
        </a></h5>
        <p class="price"><?php echo "Bütçe: " . $evarkadasi_ilan_fetch['kisiBasiButce'] . " tl"; ?></p>
        <div style="height:30px;" class="listing-detail">
          <label><?php echo $iladi." /".$ilceadi; ?></label>
        </div>
        <a class="btn btn-primary" href="evarkadasibuldum.php?git=<?php echo $evarkadasi_ilan_fetch['url']; ?>">Detaylar</a>
      </div>
      </div>
      </form>
      <!-- properties --> 
<?php

     }}
   ?>   
    </div>
  </div>