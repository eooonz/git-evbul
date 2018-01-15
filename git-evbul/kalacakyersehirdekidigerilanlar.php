<?php
include 'baglan.php';



  $benzerilan=$db->prepare("SELECT * FROM kalacakyerilani WHERE ilID=$ilID OR ilceID=$ilceID LIMIT 4");

  if ($benzerilan === false)
    die('Sorgu hatası:' . $db->error);
/* execute ile sorguyu çalıştıralım */
$benzerilan->execute();
//SQL sorgusundan dönen sonuçları alalım
$sonucbenzer = $benzerilan->get_result();

$simdikiilan=$ilan_id; //okunan ilanın id si

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

    $ilan_id=$ilansonuc['eilanID']; if($simdikiilan == $ilan_id){continue;}
    
    $benzerilansahibiid=$ilansonuc['girenID'];
  $benzersahip=$db->prepare("SELECT * FROM uye WHERE uyeID=$benzerilansahibiid");
  $benzersahip->execute();
  $benzersahipresult=$benzersahip->get_result();
  $benzersahipbilgi=$benzersahipresult->fetch_assoc();

  $benzercinsiyet=$benzersahipbilgi['cinsiyet'];
   
  $benzerprofilresmi=$benzersahipbilgi['profilResmi'];

   if(empty($benzerprofilresmi)){
        if($benzercinsiyet == 1){
        $benzerprofilresmi="image/default_erkek.png";
      }else{$benzerprofilresmi="image/default_kadin.png";}
    }

?>


  <div style="border:1px solid #ccc; border-radius: 9px;margin-bottom:5px; background-color: #f3f3f3" class="row">
      <div class="col-lg-4 col-sm-5"><img src="<?php echo $benzerprofilresmi; ?>" class="img-responsive img-circle" alt="properties">
      </div>
      <div class="col-lg-8 col-sm-7">
        <h5><a href="kalacakyerbuldum.php?git=<?php echo $ilansonuc['url']; ?>"><?php echo $ilansonuc['ilanBasligi']; ?></a></h5>
        <p class="price"><?php echo $iladi ." / ". $ilceadi; ?></p>
      </div>
  </div>

<?php } ?>
