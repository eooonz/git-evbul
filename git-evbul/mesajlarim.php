<?php 

include_once('relsrc.php'); //stil dosyaları yollları 

include_once 'oturumkontrolu.php'; //dönen değer  

include_once 'fonksiyonlar.php';

$giren_id_aldik=oturumkontrolu();?>

<?php if(!$giren_id_aldik){

  /*Daha sonra üye girişi yapmamış üyeyi, üyelik bilgilerini ilan üzerinde isteyerek de ilan girmesini kolaylaştırmış oluruz. Üye değilse mail adresini ve şifresini kaydederek "mail adresinize gönderilen linke tıkladığınızda ilanınız yayınlanbacaktır" diyebiliriz.*/

echo '<meta http-equiv="refresh" content="0;url=index.php"> ';

exit;

}

$title="Mesajlarım: EvBulKur";

require_once('baglan.php');


//kişinin bilgilerine ulaşıyoruz
$stmt=$db->prepare("SELECT * FROM uye WHERE uyeID='$giren_id_aldik'");
$stmt->execute();
$result_uye_bilgi=$stmt->get_result();
$uye_bilgi=$result_uye_bilgi->fetch_array();


//Gönderdiği ve aldığı mesajlara ulaşıyoruz. Gropu By ile gönderene göre grupladığımızda son mesajı alabilirsek güzel olur. aksi halde hep eski mesajı gösterecek.
$mesaj_pre=$db->prepare("SELECT * FROM mesajlar WHERE aliciID=$giren_id_aldik GROUP BY gonderenID ORDER BY mesajTarihi DESC");
$mesaj_pre->execute();
$mesaj_get=$mesaj_pre->get_result();

$say=$mesaj_get->num_rows;


?>


<?php include_once'header.php';?>


<!-- banner -->

<div class="inside-banner">

  <div class="container"> 

    <span class="pull-right"><a href="index.php">Anasayfa</a> / Mesajlarım</span>

    <h2>Mesajlarım</h2>

</div>

</div>

<!-- banner -->

<!-- <div class="container">  -->

<div class="properties-listing spacer">


<!-- mesajlarim-->

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

              <div class="col-md-9">

              <div class="panel panel-default">

                <div class="panel-heading">

                  <h3 class="panel-title">Mesajlarım</h3>

                </div>

                <div class="panel-body">



                  <ul class="list-group">

<?php

if($say < 1){ echo "Hiç Mesajınız Yok."; exit;}

while($mesaj_fetch=$mesaj_get->fetch_assoc()){

$gonderenID=$mesaj_fetch['gonderenID'];

$son_mesaji_pre=$db->prepare("SELECT * FROM mesajlar WHERE gonderenID=$gonderenID AND aliciID=$giren_id_aldik ORDER BY mesajTarihi DESC LIMIT 1");
$son_mesaji_pre->execute();
$son_mesaji_result=$son_mesaji_pre->get_result();
$son_mesaji_fetch=$son_mesaji_result->fetch_assoc();
$son_mesaji=$son_mesaji_fetch['mesaj'];

//mesaj gönderenin bilgilerine ulaşıyoruz
$gonderen_pre=$db->prepare("SELECT * FROM uye WHERE uyeID='$gonderenID'");
$gonderen_pre->execute();
$gonderen_result=$gonderen_pre->get_result();
$gonderen_bilgi=$gonderen_result->fetch_array();

$gonderenAdi=$gonderen_bilgi['ad'];
$mesaj=$mesaj_fetch['mesaj'];
$mesajTarihi=$mesaj_fetch['mesajTarihi'];
$mesajİlanUrl=$mesaj_fetch['ilanUrl'];
$mesajBaslik=$mesaj_fetch['ilanBaslik'];
$mesajID=$mesaj_fetch['mesajID'];

$mesajlarim_sorgu=$db->prepare("SELECT okundumu FROM mesajlar WHERE aliciID=$giren_id_aldik ORDER BY mesajID DESC");
$mesajlarim_sorgu->execute();
$mesajlarim_result=$mesajlarim_sorgu->get_result();
$okundumu=$mesajlarim_result->fetch_array();

if($okundumu[0] == 2){
$oku='<span style="background-color:red;" class="badge pull-left">Okunmadı</span>';
}

?>

                    <li class="list-group-item">

                      <div class="media">

                        <div class="media-left media-top">

                        </div>

                        <div class="media-body">

                          <h4 class="media-heading"><b><?php echo $gonderenAdi; ?> </b>sana mesaj gönderdi <?=@$oku;?></h4>

                          <p>
                            <?php echo $son_mesaji; ?>
                          </p>
                          <a href="<?php echo "cevapla.php?mesaj=".$mesajID; ?> ">
                          <span style="background-color:green;" class="badge pull-left">Cevapla</span>
                          </a>
                          <span style="background-color:skyblue;" class="badge pull-left">Tarih: <?php echo $mesajTarihi; ?></span>
                          <!-- mesajın gönderildiği ilan mesaj altında gösterimi kapatıldı.
                          <span class="badge pull-left"><a href="<?php echo $mesajİlanUrl; ?>" target=_blank style="color: white; text-decoration: none;"> <?php echo "İlan: ".$mesajBaslik; ?> </a></span>
                          //mesaj sil butonu kapatıldı
                          <span style="background-color:#543145;" class="badge pull-right"> Mesajı Sil </span>
                          -->

                        </div>

                      </div>

                    </li>

<?php } ?>

                
                  </ul>

                </div>

              </div>

              </div>

            </div>

      </div>

   </div>

   </div>

    </div> 

<!--mesajlarim end-->

 

</div>

</div>



<!--  </div> -->

<?php include'footer.php';?>