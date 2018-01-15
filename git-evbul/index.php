<?php $title= "EvBulKur.com : anasayfa"; ?>

<?php include_once'header.php';?>

<!-- <div class="yenidenboyut"> -->
   <span class="hidden-xs"> <?php include_once'topslider.php';?> </span>
<!--</div>  yeniden boyut kapnış divi-->

<div class="banner-search">
  <div class="container"> 
    <!-- banner -->
    <h3>Ev arkadaşı, Kalacak yer&Kiralık ev</h3>
    <div class="searchbar">
      <div class="row">
        <div class="col-lg-6 col-sm-6">
        <form method="get" action="aramasonuclari.php" role="search">
          <input type="text" name="kutu" class="form-control" maxlength="5" placeholder=" Arama kutusu ...">
          <div class="row">
            <div class="col-lg-4 col-sm-4 ">
            <select class="form-control" name="ilanara" required="Bir ilan türü seçin">
            <option value="kalacakyer">Kalacak Yer</option>
            <option value="evarkadasi">Ev Arkadaşı</option>
            <option value="kiralikev">Kiralık Ev</option>
          </select>
            </div>


            <div class="col-lg-4 col-sm-4">
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
              <div class="col-lg-4 col-sm-4">
              <button type="submit" class="btn btn-success" >Bul</button>
        </form>
        </div>
      </div>
    </div>
        <div style="margin-top:-40px;" class="col-lg-5 col-lg-offset-1 col-sm-6 ">

        <?php
        include_once'oturumkontrolu.php'; //dönen değer  
          $giren_id_aldik=oturumkontrolu();

         if($giren_id_aldik != false){

          echo 'Giriş yaptığın için sağolasın kanka, şimdi bu site beta aşamasında, yani kırılan bozulan bi yanları olabilir onları düzelteceğiz daha, senden bu aşamada yardım istiyoruz. Sitede gezerken elinde kalan bi yer olursa bize en alttaki kutuya yazarak bildirebilirsin.';

         }else{?>
        <p>Giriş yap ve siteyi tüm özellikleriyle kullan.</p>
          <button class="btn btn-info"   data-toggle="modal" data-target="#loginpop">Giriş Yap</button>
          <button type="submit" class="btn btn-info"  onclick="window.location.href='register.php'">Üye Ol</button>
       <?php }?>
        

        </div>
      </div>
    </div>
  </div>
</div>
<!-- banner -->

<div class="container">

<?php 
//Ev arkadaşı ilanlarının en yeniden listelendiği banner
include 'evarkadasibanner.php'; ?>

<?php
//Kiralık ev ilanlarının en yeniden listelendiği banner
include 'kiralikevbanner.php'; ?>
  



  <div class="spacer">
    <div class="row">
      <div class="col-lg-6 col-sm-9 recent-view" style="margin-top:30px;">
        <h3>EvBulKur Nedir?</h3>
        <p>Öğrencilerin ve yeni bir şehirde yaşamaya başlayanların ilk sorunu kalacak bir yer bulmadır. Sokak sokak kiralık ve ya satılık daire, ev aramak başvurulan ilk yöntemdir ve çok yorucudur. <br><a href="hakkimizda.php">EvBulKur Hakkında</a></p>
      
      </div>

      <div >
      <?php
      //Kalacak yer ilanlarının en yeniden listelendiği banner
       include 'kalacakyerbanner.php';
      ?>
      </div>
      
  </div>
</div>
</div></div></div></div></div></div>
<?php include'footer.php';?>