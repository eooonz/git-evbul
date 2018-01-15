<?php 
include_once'fonksiyonlar.php';

$title="Ev arkadaşı BUL, Kalacak yer BUL, Kiralık ev BUL";
$keywords="istanbul ev arkadaşı, ankara ev arkadaşı,izmir ev arkadaşı,ev arkadaşı bul";

include_once'header.php';?>



<!-- banner -->

<div class="inside-banner">

  <div class="container"> 

    <span class="pull-right"><a href="index.php">Anasayfa</a> / Bulunan İlanlar</span>

    <h2>Bulunan İlanlar</h2>

</div>

</div>

<!-- banner -->


<div class="container">

<div class="properties-listing spacer">



<div class="row">

<div class="col-lg-3 col-sm-4 ">

<form method="get" action="aramasonuclari.php" role="search">

  <div class="search-form"><h4><span class="glyphicon glyphicon-search"></span> Ara </h4>

    <input type="text" class="form-control" name="kutu" placeholder="Arama kutusu ..." minlength="4">

      <div class="row">

      <div class="col-lg-12">

          <select class="form-control" name="ilanara" required="Bir ilan türü seçin">

            <option value="kalacakyer">Kalacak Yer</option>

            <option value="evarkadasi">Ev Arkadaşı</option>

            <option value="kiralikev">Kiralık Ev</option>

          </select>

      </div>

       <div class="col-lg-12">
            <select name="nerede" class="form-control">

          <?php
            include_once("baglan.php");

            $il_sorgu=$db->prepare("SELECT * FROM muh_iller");
            $il_sorgu->execute();
            $il_result=$il_sorgu->get_result();

            while ($iller=$il_result->fetch_array()) {
              echo "<option value=".$iller['id'].">".$iller['baslik']."</option>";
            }
            
          ?>

              </select>
            </div>

      </div>

      <button type="submit" class="btn btn-success" >Bul</button>

</form>
</div>

<div class="hot-properties hidden-xs">

<h4>Benzer İlanlar</h4>

<?php

//Benzer ilanlar

include 'benzerilanlar.php';

?>

</div>
</div>



<div class="col-lg-9 col-sm-8">



<!--

<div class="sortby clearfix">

<div class="pull-left result">Showing: 12 of 100 </div>

  <div class="pull-right">

  <select class="form-control">

  <option>Sırala</option>

  <option>Price: Low to High</option>

  <option>Price: High to Low</option>

</select></div>



</div>

-->

<div class="row">

<section class="col-md-12">

     <?php 

   require_once('baglan.php');


   include_once 'oturumkontrolu.php'; //dönen değer $giren_id_aldik 

    $giris_id_aldik=oturumkontrolu();



     //ev arkadaşı ilanı resimleri için sql sorgusu

    $resim_id_stmt=$db->prepare("SELECT fotoID FROM ilanresimler ");

    $resim_id_stmt->execute();

    $result_resim_id=$resim_id_stmt->get_result();



    $resim_url=$db->prepare("SELECT * from ilanresimler as i inner join resimler as r on i.fotoID=r.id ");

    $resim_url->execute();

    $result_resim_url=$resim_url->get_result();



@$kutu=guvenlik_fonksiyonu($_GET['kutu']);



$ilanara=guvenlik_fonksiyonu($_GET['ilanara']);

@$iller_id=$_GET['nerede'];



if(isset($ilanara)){


  //*****kiralık ev ilanı******************************************



     if($ilanara == "kiralikev"){

      //****** sayfalama ********

$sayfalama = $db->prepare("SELECT count(*) FROM kiralikevilani WHERE ilID = $iller_id AND (ilanBasligi LIKE '%$kutu%' OR ilanAciklama LIKE '%$kutu%')");

if ($sayfalama === false)

    die('Sorgu hatası:' . $db->error);

/* execute ile sorguyu çalıştıralım */

$sayfalama->execute();

//SQL sorgusundan dönen sonuçları alalım

$sonuc = $sayfalama->get_result();

if ($sonuc->num_rows < 1)

    die('Kayıt bulunmadı');



$sayfa_sayisi = $sonuc->fetch_array();

$limit        = 12; //gösterilecek kayıt sayısı



//index.php?id=1 istek varmı? kontrol edelim

@$sayfa=$_GET['i'];

$ofset = isset($sayfa) ? $sayfa : 0;

// limit ve ve ofset durumuna göre kayıtları elde et

@$adres="aramasonuclari.php?kutu=&ilanara=kiralikev&nerede=".$iller_id."&i=";

//**************** sayfalama*****


    //kiralık ev ilanı bilgilerini çekiyoruz

    $kiralikev_ilan_stmt=$db->prepare("SELECT * FROM kiralikevilani WHERE ilID = $iller_id AND (ilanBasligi LIKE '%$kutu%' OR ilanAciklama LIKE '%$kutu%') ORDER BY ilanTarihi DESC LIMIT ? OFFSET ?");

    $kiralikev_ilan_stmt->bind_param("ii", $limit, $ofset);

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

      <div class="col-lg-4 col-sm-6">

      <div class="properties">

        <div class="image-holder"><img src="<?php echo $resim; ?>" class="img-responsive img-aramasonuc" alt="Kiralık Ev">

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

<?php
  

     }

  }else echo '<b>Arama kriterlerine uygun ilan bulunamadı.</b> <br/>
   <a href="http://www.evbulkur.com/formkalacakyer.php"><b>
   Bu kriterlere uygun kiralık yer ilanı bulunamadı. Kalacak yer ilanı vererek onların seni bulmasını sağlayabilirsin..
   </b></a><br/>';

}


//*****ev arkadaşı ilanı *********************************************

if($ilanara == "evarkadasi"){

  //****** sayfalama ********


$sayfalama = $db->prepare("SELECT count(*) FROM evarkadasiilani WHERE ilID = $iller_id AND (ilanBasligi LIKE '%$kutu%' OR ilanAciklama LIKE '%$kutu%')");

if ($sayfalama === false)

    die('Sorgu hatası:' . $db->error);

/* execute ile sorguyu çalıştıralım */

$sayfalama->execute();

//SQL sorgusundan dönen sonuçları alalım

$sonuc = $sayfalama->get_result();

if ($sonuc->num_rows < 1)

    die('Kayıt bulunmadı');


$sayfa_sayisi = $sonuc->fetch_array();

$limit        = 12; //gösterilecek kayıt sayısı


//index.php?id=1 istek varmı? kontrol edelim

@$sayfa=$_GET['i'];

$ofset = isset($sayfa) ? $sayfa : 0;

// limit ve ve ofset durumuna göre kayıtları elde et

@$adres="aramasonuclari.php?kutu=&ilanara=evarkadasi&nerede=".$iller_id."&i=";

//**************** sayfalama*****

    //evarkadaşı yer ilanı bilgilerini çekiyoruz

    $evarkadasi_ilan_stmt=$db->prepare("SELECT * FROM evarkadasiilani where ilID = $iller_id AND (ilanBasligi LIKE '%$kutu%' OR ilanAciklama LIKE '%$kutu%') ORDER BY ilanTarihi DESC LIMIT ? OFFSET ?");

    $evarkadasi_ilan_stmt->bind_param("ii", $limit, $ofset);

    $evarkadasi_ilan_stmt->execute();

    $evarkadasi_ilan_result=$evarkadasi_ilan_stmt->get_result();

    $varmi=$evarkadasi_ilan_result->num_rows;


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

        $resim="image/arama_default_kiralik_ev.jpg";

        }

      ?>

      <!-- properties -->

      <form action="evarkadasibuldum.php" method="get">

      <div class="col-lg-4 col-sm-6">

      <div class="properties">

        <div class="image-holder"><img src="<?php echo $resim; ?>" class="img-responsive img-aramasonuc" alt="Ev Arkadaşı">

        <?php

        if($evarkadasi_ilan_fetch['odasiOlacak'] == 1)

          {$a="Odan Olacak"; $b="sold";

          }else{$a="Oda Yok"; $b="new";}

        ?>

          <div class="status <?php echo $b; ?>"><?php echo $a; ?></div>

        </div>

        <h5 style="height:30px;"><a href="evarkadasibuldum.php?git=<?php echo $evarkadasi_ilan_fetch['url']; ?>">

          <?php echo baslikKisalt($evarkadasi_ilan_fetch['ilanBasligi'])." ..."; ?>

        </a></h5>

        <p class="price"><?php echo "Bütçe: " . $evarkadasi_ilan_fetch['kisiBasiButce'] . " tl"; ?></p>

        <div class="listing-detail">

          <label><?php echo $iladi." /".$ilceadi; ?></label>

        </div>

        <a class="btn btn-primary" href="evarkadasibuldum.php?git=<?php echo $evarkadasi_ilan_fetch['url']; ?>">Detaylar</a>

      </div>

      </div>

      </form>

      <!-- properties --> 

<?php

     }

    }else echo '<b>Arama kriterlerine uygun ilan bulunamadı.</b> <br/>
   <a href="http://www.evbulkur.com/formkalacakyer.php"><b>
   Bu kriterlere uygun kalacak yer ilanı bulunamadı. Ev arkadaşı ilanı vererek onların seni bulmasını sağlayabilirsin..
   </b></a><br/>';

  }


//*****kalcak yer ilanı *****************************************

  if($ilanara == "kalacakyer"){

    //****** sayfalama ********

$sayfalama = $db->prepare("SELECT count(*) FROM kalacakyerilani WHERE ilID = $iller_id AND (ilanBasligi LIKE '%$kutu%' OR ilanAciklama LIKE '%$kutu%')");



if ($sayfalama === false)

    die('Sorgu hatası:' . $db->error);

$sayfalama->execute();


//SQL sorgusundan dönen sonuçları alalım

$sonuc = $sayfalama->get_result();

if ($sonuc->num_rows < 1)

    die('Kayıt bulunmadı');


$sayfa_sayisi = $sonuc->fetch_array();

$limit        = 5; //gösterilecek kayıt sayısı


//index.php?id=1 istek varmı? kontrol edelim

@$sayfa=$_GET['i'];

$ofset = isset($sayfa) ? $sayfa : 0;

// limit ve ve ofset durumuna göre kayıtları elde et

@$adres="aramasonuclari.php?kutu=&ilanara=kalacakyer&nerede=".$iller_id."&i=";

//**************** sayfalama*****


    //kalacak yer ilanı bilgilerini çekiyoruz

    $kalacakyer_ilan_stmt=$db->prepare("SELECT * FROM kalacakyerilani where ilID = $iller_id AND (ilanBasligi LIKE '%$kutu%' OR ilanAciklama LIKE '%$kutu%') ORDER BY ilanTarihi DESC LIMIT ? OFFSET ?");

    $kalacakyer_ilan_stmt->bind_param("ii", $limit, $ofset);

    $kalacakyer_ilan_stmt->execute();

    $kalacakyer_ilan_result=$kalacakyer_ilan_stmt->get_result();

    $varmi=$kalacakyer_ilan_result->num_rows;


if($varmi > 0){

    //echo "kalacak yer ilanı".$kalacakyer_ilan_result->num_rows;

    while($kalacakyer_ilan_fetch=$kalacakyer_ilan_result->fetch_assoc()){

    ?>  

       <!-- ***************** -->

       <?php

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

      <div class="row"  style="margin-bottom: 10px" >

        <div class="col-lg-2 col-sm-2 " style="background-color: white;"><a href="kalacakyerbuldum.php?git=<?php echo $kalacakyer_ilan_fetch['url']; ?>">
        	<img src="<?php echo $profilresmi; ?>" class="img-responsive img-aramasonuc-kal" alt="Kalacak Yer Arıyorum"></a></div>

        <div class="col-lg-7 col-sm-7 "><h4><?php echo ucwords($uyeadsoyad); ?></h4><a href="kalacakyerbuldum.php?git=<?php echo $kalacakyer_ilan_fetch['url']; ?>"><p><?php echo baslikKisalt($kalacakyer_ilan_fetch['ilanBasligi'])." ..."; ?></p></a></div>

        <div class="col-lg-3 col-sm-3 ">

        <?php 

        if($giris_id_aldik){

        ?>

        <span class="glyphicon glyphicon-envelope"></span> <a href="mailto:<?php echo $fetchuye['email']; ?>"><?php echo $fetchuye['email']; ?></a><br>

        <span class="glyphicon glyphicon-earphone"></span> <?php echo $fetchuye['telefonNo']; 

        }else{echo "<span class='glyphicon glyphicon-envelope'></span>

        <span class='glyphicon glyphicon-earphone'></span>

        Kanka, iletişim bilgilerini görmek için giriş yapmalısın.";}

        ?>

        </div>

      </div>

      <!-- agents -->

<?php

     }

   }else echo '<b>Arama kriterlerine uygun ilan bulunamadı.</b> <br/>
   <a href="http://www.evbulkur.com/formevarkadasi.php"><b>
   Bu kriterlere uygun kalacak yer ilan bulunamadı. Ev arkadaşı ilanı vererek onların seni bulmasını sağlayabilirsin..
   </b></a><br/>';

    }

}

?>

</section>  

<div class="center">
  <ul class="pagination">
<?php
if ($sayfa_sayisi[0] > $limit) {

	$x = 0;

	if($sayfa > 0){

		$sayfa0=$sayfa-$limit < 0 ? 0 : $sayfa-$limit ;
		echo "<li><a href='".$adres."".($sayfa0)."'> « </a></li>";
	}

	for ($i = 0; $i < $sayfa_sayisi[0]; $i += $limit) {
		$x++;
		echo "<li><a href='".$adres."$i'>" . $x . "</a></li>";
	}

	if($sayfa < $sayfa_sayisi[0] - $limit){
		$sayfa1=$sayfa < $sayfa_sayisi[0] ? $sayfa : $sayfa_sayisi[0] ;
		echo "<li><a href='".$adres.($sayfa1+$limit)."'> » </a></li>";
	}
}
?>
  </ul>
</div>


</div>

</div>

</div>

</div>

</div>



<?php include'footer.php';?>