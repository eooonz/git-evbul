<?php
/*
*
*ev arkadaşı ve kiralık ev ilanları büyük slider de olsun
*altta evbulkur nedir yazısı ve sağda küçük slider
*küçük sliderde kalacak yer ilanları
*ilanlar ekleme tarihine göre son eklenenden itibaren gösterilsin
*
*/

include 'baglan.php';
include_once 'fonksiyonlar.php';
echo '
<div class="properties-listing spacer">
<h3>Kiralık Ev İlanlaları</h3>
<div class="properties-listing spacer">
<div class="row">
<section class="col-md-12">
';
//ilan resimleri için sql sorgusu
    
    $resim_id_stmt=$db->prepare("SELECT fotoID FROM ilanresimler ");
    $resim_id_stmt->execute();
    $result_resim_id=$resim_id_stmt->get_result();

    $resim_url=$db->prepare("SELECT * from ilanresimler as i inner join resimler as r on i.fotoID=r.id ");
    $resim_url->execute();
    $result_resim_url=$resim_url->get_result();


    //kiralık ev ilanı bilgilerini çekiyoruz
    $kiralikev_ilan_stmt=$db->prepare("SELECT * FROM kiralikevilani ORDER BY ilanTarihi DESC LIMIT 4");

    $kiralikev_ilan_stmt->execute();
    $kiralikev_ilan_result=$kiralikev_ilan_stmt->get_result();
    $varmi=$kiralikev_ilan_result->num_rows;

    if($varmi > 0){
    while($kiralikev_ilan_fetch=$kiralikev_ilan_result->fetch_assoc()){
      /*echo "<pre>";
      print_r($kiralikev_ilan_fetch);
      echo "</pre>";*/

    $ilID=$kiralikev_ilan_fetch['ilID'];

    //il isim çekme
    $il_stmt=$db->prepare("SELECT * from muh_iller where id=$ilID");
    $il_stmt->execute();
    $result_il=$il_stmt->get_result();
    $row_il=$result_il->fetch_array();
    $iladi=$row_il['baslik'];

    //ilçe isim çekme
    $ilceID=$kiralikev_ilan_fetch['ilceID'];
    $ilce_stmt=$db->prepare("SELECT baslik from muh_ilceler where id='$ilceID'");
    $ilce_stmt->execute();
    $result_ilce=$ilce_stmt->get_result();
    $row_ilce=$result_ilce->fetch_array();
    $ilceadi=$row_ilce['baslik'];

    $ilan_id=$kiralikev_ilan_fetch['kilanID'];
    $ilan_resim_id="ki"."$ilan_id";

    $resim_id_stmt=$db->prepare("SELECT fotoID FROM ilanresimler where ilanResimID='$ilan_resim_id'");
    $resim_id_stmt->execute();
    $result_resim_id=$resim_id_stmt->get_result();

    $resim_url=$db->prepare("SELECT * from ilanresimler as i inner join resimler as r on i.fotoID=r.id where i.ilanResimID ='$ilan_resim_id'");
    $resim_url->execute();
    $result_resim_url=$resim_url->get_result();

    $row_resim_url=$result_resim_url->fetch_assoc();
      //her ilanın ilk resmini alıyoruz
?>

      <?php 
        if($row_resim_url['resim_url']){
        $resim = $row_resim_url['resim_url'];
        }else{
        $resim="image/kiralikevariyorum_defaulticon.jpg";
        }
      ?>
      <!-- properties -->
      <form action="kiralikevbuldum.php" method="get">
      <div class="col-lg-3 col-sm-6">

      <div class="properties">
        <div class="image-holder"><div style="height:150px;margin:auto;"><img style="max-height:150px; margin:auto;" src="<?php echo $resim; ?>" class="img-responsive" alt="properties"></div>
        <?php
        if($kiralikev_ilan_fetch['esyaliMi'] == 1)
          {$a="Eşyalı"; $b="sold";
          }else{$a="Eşyasız"; $b="new";}
        ?>
          <div class="status <?php echo $b; ?>"><?php echo $a; ?></div>
        </div>
        <h5 style="height:30px;"><a href="kiralikevbuldum.php?git=<?php echo $kiralikev_ilan_fetch['url']; ?>">
          <?php echo baslikKisalt($kiralikev_ilan_fetch['ilanBasligi'])." ..."; ?>
        </a></h5>
        <p class="price"><?php echo "Kira: " . $kiralikev_ilan_fetch['evinKirasi'] . " tl"; ?></p>
        <div class="listing-detail">
          <label><?php echo $iladi." /".$ilceadi; ?></label>
        </div>
        <a class="btn btn-primary" href="kiralikevbuldum.php?git=<?php echo $kiralikev_ilan_fetch['url']; ?>">Detaylar</a>
      </div>
      </div>
      </form>
      <!-- properties -->  
    <?php } } ?>