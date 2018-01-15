<?php
include_once 'baglan.php';

 //ilan resimleri için sql sorgusu
    $resim_id_stmt=$db->prepare("SELECT fotoID FROM ilanresimler ");
    $resim_id_stmt->execute();
    $result_resim_id=$resim_id_stmt->get_result();

    $resim_url=$db->prepare("SELECT * from ilanresimler as i inner join resimler as r on i.fotoID=r.id ");
    $resim_url->execute();
    $result_resim_url=$resim_url->get_result();


@$kutu=guvenlik_fonksiyonu($_GET['kutu']);

$ilanara=guvenlik_fonksiyonu($_GET['ilanara']);
?>



<?php

if($ilanara == "kiralikev"){
  $benzerilan=$db->prepare("SELECT * FROM kiralikevilani WHERE ilanBasligi LIKE '%$kutu%' OR ilanAciklama LIKE '%$kutu%' LIMIT 4");

  if ($benzerilan === false)
    die('Sorgu hatası:' . $db->error);
/* execute ile sorguyu çalıştıralım */
$benzerilan->execute();
//SQL sorgusundan dönen sonuçları alalım
$sonucbenzer = $benzerilan->get_result();

if ($sonucbenzer->num_rows < 1){
    echo 'Benzer ilan yok.';
} 
 

while($ilansonuc=$sonucbenzer->fetch_assoc()){

$ilID=$ilansonuc['ilID'];

    //il isim çekme
    $il_stmt=$db->prepare("SELECT * from muh_iller where id=$ilID");
    $il_stmt->execute();
    $result_il=$il_stmt->get_result();
    $row_il=$result_il->fetch_array();
    $iladi=$row_il['baslik'];

    //ilçe isim çekme
    $ilceID=$ilansonuc['ilceID'];
    $ilce_stmt=$db->prepare("SELECT baslik from muh_ilceler where id='$ilceID'");
    $ilce_stmt->execute();
    $result_ilce=$ilce_stmt->get_result();
    $row_ilce=$result_ilce->fetch_array();
    $ilceadi=$row_ilce['baslik'];

    $ilan_id=$ilansonuc['kilanID']; 
    $ilan_resim_id="ki"."$ilan_id";

    $resim_id_stmt=$db->prepare("SELECT fotoID FROM ilanresimler where ilanResimID='$ilan_resim_id'");
    $resim_id_stmt->execute();
    $result_resim_id=$resim_id_stmt->get_result();

    $resim_url=$db->prepare("SELECT * from ilanresimler as i inner join resimler as r on i.fotoID=r.id where i.ilanResimID ='$ilan_resim_id'");
    $resim_url->execute();
    $result_resim_url=$resim_url->get_result();

    $ilan_resim_url=$result_resim_url->fetch_assoc();

  if($ilan_resim_url['resim_url']){
  $resim = $ilan_resim_url['resim_url'];
  }else{
  $resim="image/kiralikevariyorum_defaulticon.jpg";
  }

?>


  <div style="border:1px solid #ccc; border-radius: 9px;margin-bottom:5px; background-color: #f3f3f3" class="row">
      <div class="col-lg-4 col-sm-5"><img src="<?php echo $resim; ?>" class="img-responsive img-circle" alt="ev bul kur">
      </div>
      <div class="col-lg-8 col-sm-7">
        <h5><a href="kiralikevbuldum.php?git=<?php echo $ilansonuc['url']; ?>"><?php echo $ilansonuc['ilanBasligi']; ?></a></h5>
        <p class="price"><?php echo $iladi ." / ". $ilceadi; ?></p>
      </div>
  </div>

<?php }
}elseif($ilanara == "evarkadasi"){

  $benzerilan=$db->prepare("SELECT * FROM evarkadasiilani WHERE ilanBasligi LIKE '%$kutu%' OR ilanAciklama LIKE '%$kutu%' LIMIT 4");

  if ($benzerilan === false)
    die('Sorgu hatası:' . $db->error);
/* execute ile sorguyu çalıştıralım */
$benzerilan->execute();
//SQL sorgusundan dönen sonuçları alalım
$sonucbenzer = $benzerilan->get_result();

if ($sonucbenzer->num_rows < 1){
    echo 'Benzer ilan yok.';
} 
 




while($ilansonuc=$sonucbenzer->fetch_assoc()){

$ilID=$ilansonuc['ilID'];

    //il isim çekme
    $il_stmt=$db->prepare("SELECT * from muh_iller where id=$ilID");
    $il_stmt->execute();
    $result_il=$il_stmt->get_result();
    $row_il=$result_il->fetch_array();
    $iladi=$row_il['baslik'];

    //ilçe isim çekme
    $ilceID=$ilansonuc['ilceID'];
    $ilce_stmt=$db->prepare("SELECT baslik from muh_ilceler where id='$ilceID'");
    $ilce_stmt->execute();
    $result_ilce=$ilce_stmt->get_result();
    $row_ilce=$result_ilce->fetch_array();
    $ilceadi=$row_ilce['baslik'];

    $ilan_id=$ilansonuc['ailanID'];
    $ilan_resim_id="e"."$ilan_id";

    $resim_id_stmt=$db->prepare("SELECT fotoID FROM ilanresimler where ilanResimID='$ilan_resim_id'");
    $resim_id_stmt->execute();
    $result_resim_id=$resim_id_stmt->get_result();

    $resim_url=$db->prepare("SELECT * from ilanresimler as i inner join resimler as r on i.fotoID=r.id where i.ilanResimID ='$ilan_resim_id'");
    $resim_url->execute();
    $result_resim_url=$resim_url->get_result();

    $ilan_resim_url=$result_resim_url->fetch_assoc();

  if($ilan_resim_url['resim_url']){
  $resim = $ilan_resim_url['resim_url'];
  }else{
  $resim="image/default_ev_arkadasi_icon.jpg";
  }

?>


  <div style="border:1px solid #ccc; border-radius: 9px;margin-bottom:5px; background-color: #f3f3f3" class="row">
      <div class="col-lg-4 col-sm-5"><img src="<?php echo $resim; ?>" class="img-responsive img-circle"  alt="ev bul kur">
      </div>
      <div class="col-lg-8 col-sm-7">
        <h5><a href="evarkadasibuldum.php?git=<?php echo $ilansonuc['url']; ?>"><?php echo $ilansonuc['ilanBasligi']; ?></a></h5>
        <p class="price"><?php echo $iladi ." / ". $ilceadi; ?></p>
      </div>
  </div>

 <?php }

 }elseif($ilanara == "kalacakyer"){

    $benzerilan=$db->prepare("SELECT * FROM kalacakyerilani WHERE ilanBasligi LIKE '%$kutu%' OR ilanAciklama LIKE '%$kutu%' LIMIT 4");

  if ($benzerilan === false)
    die('Sorgu hatası:' . $db->error);
/* execute ile sorguyu çalıştıralım */
$benzerilan->execute();
//SQL sorgusundan dönen sonuçları alalım
$sonucbenzer = $benzerilan->get_result();

if ($sonucbenzer->num_rows < 1){
    echo 'Benzer ilan yok.';
} 
 




while($ilansonuc=$sonucbenzer->fetch_assoc()){

$ilID=$ilansonuc['ilID'];

    //il isim çekme
    $il_stmt=$db->prepare("SELECT * from muh_iller where id=$ilID");
    $il_stmt->execute();
    $result_il=$il_stmt->get_result();
    $row_il=$result_il->fetch_array();
    $iladi=$row_il['baslik'];

    //ilçe isim çekme
    $ilceID=$ilansonuc['ilceID'];
    $ilce_stmt=$db->prepare("SELECT baslik from muh_ilceler where id='$ilceID'");
    $ilce_stmt->execute();
    $result_ilce=$ilce_stmt->get_result();
    $row_ilce=$result_ilce->fetch_array();
    $ilceadi=$row_ilce['baslik'];

    $ilan_id=$ilansonuc['eilanID'];


       $ilan_giren_id=$ilansonuc['girenID'];
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


  <div style="border:1px solid #ccc; border-radius: 9px;margin-bottom:5px; background-color: #f3f3f3" class="row">
      <div class="col-lg-4 col-sm-5"><img src="<?php echo $profilresmi; ?>" class="img-responsive img-circle" alt="properties">
      </div>
      <div class="col-lg-8 col-sm-7">
        <h5><a href="kalacakyerbuldum.php?git=<?php echo $ilansonuc['url']; ?>"><?php echo $ilansonuc['ilanBasligi']; ?></a></h5>
        <p class="price"><?php echo $iladi ." / ". $ilceadi; ?></p>
      </div>
  </div>

 <?php }

  } ?>



