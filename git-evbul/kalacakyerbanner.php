<?php
include_once 'baglan.php';
//kalacak yer ilanı bilgilerini çekiyoruz
    $kalacakyer_ilan_stmt=$db->prepare("SELECT * FROM kalacakyerilani ORDER BY ilanTarihi DESC LIMIT 4");
    
    $kalacakyer_ilan_stmt->execute();
    $kalacakyer_ilan_result=$kalacakyer_ilan_stmt->get_result();
    $varmi=$kalacakyer_ilan_result->num_rows;

    
if($varmi > 0){

  echo '
  <div class="col-lg-5 col-lg-offset-1 col-sm-3 recommended">
      <div class="properties-listing spacer"> 
        <h4>Kalacak Yer Arayan  Arkadaşlar</h4>
        <div id="myCarousel" class="carousel slide">
          <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1" class=""></li>
            <li data-target="#myCarousel" data-slide-to="2" class=""></li>
            <li data-target="#myCarousel" data-slide-to="3" class=""></li>
          </ol>
          <!-- Carousel items -->
          <div class="carousel-inner">
';
$sayac=0;
    //echo "kalacak yer ilanı".$kalacakyer_ilan_result->num_rows;
    while($kalacakyer_ilan_fetch=$kalacakyer_ilan_result->fetch_assoc()){
$sayac++;
$aktif=$sayac == 1 ? "active" : "";
$ilan_id=$kalacakyer_ilan_fetch['eilanID'];
  $il_stmt=$db->prepare("SELECT ilID,ilceID,baslik from kalacakyerilani as k inner join muh_iller as il on k.ilID=il.ID where k.eilanID ='$ilan_id'");
  $il_stmt->execute();
  $result_il=$il_stmt->get_result();
  $row_il=$result_il->fetch_array();

  $ilceID=$kalacakyer_ilan_fetch['ilceID'];

  //ilçe isim çekme
  $ilce_stmt=$db->prepare("SELECT baslik from muh_ilceler where id='$ilceID'");
  $ilce_stmt->execute();
  $result_ilce=$ilce_stmt->get_result();
  $row_ilce=$result_ilce->fetch_array();

    
       //<!-- ***************** -->
       
       $ilan_giren_id=$kalacakyer_ilan_fetch['girenID'];
    $preuye=$db->prepare("SELECT * FROM uye WHERE uyeID=$ilan_giren_id");
    $preuye->execute();
    $resultuye=$preuye->get_result();
    $fetchuye=$resultuye->fetch_assoc();

    $cinsiyet=$fetchuye['cinsiyet'];
    $profilresmi=$fetchuye['profilResmi'];

    $uyeadsoyad=$fetchuye['ad'] . " " . $fetchuye['soyad'];
      if(empty($profilresmi)){
        if($cinsiyet == 1){
        $profilresmi="image/default_erkek.png";
      }else{$profilresmi="image/default_kadin.png";}
      }
    
    ?>
        <!-- agents -->
         <div class="item <?php echo $aktif; ?>">
              <div class="row">
                <div class="col-lg-4"><img src="<?php echo $profilresmi; ?>" class="img-responsive" style="max-height: 100px; background-color: white; margin: auto;" alt="properties"/></div>
                <div class="col-lg-8">
                  <h5><a href="kalacakyerbuldum.php?git=<?php echo $kalacakyer_ilan_fetch['url']; ?>"><?php echo baslikKisalt($kalacakyer_ilan_fetch['ilanBasligi'])." ..."; ?></a></h5>
                  <p class="price"><?php echo $row_il['baslik']."/".$row_ilce['baslik']; ?></p>
                  <a href="kalacakyerbuldum.php?git=<?php echo $kalacakyer_ilan_fetch['url']; ?>" class="more">Detaylar</a> </div>
              </div>
            </div>
      <!-- agents -->
<?php

     }}
?>



         
            
          </div>
        </div>
      </div>
    </div>