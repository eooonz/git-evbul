

<?php include_once('relsrc.php'); //stil dosyaları yollları 

include_once 'oturumkontrolu.php'; //dönen değer $giren_id_aldik 

include_once'fonksiyonlar.php';

    $giris_id_aldik=oturumkontrolu();?>

<?php if(!$giris_id_aldik){

  /*Daha sonra üye girişi yapmamış üyeyi, üyelik bilgilerini ilan üzerinde isteyerek de ilan girmesini kolaylaştırmış oluruz. Üye değilse mail adresini ve şifresini kaydederek "mail adresinize gönderilen linke tıkladığınızda ilanınız yayınlanbacaktır" diyebiliriz.*/



 $mesaj1="İlan Verebilmek için Üye olmalısınız.</br>Üyeyseniz giriş yapın.";

    $tur1=0;

    sessioncreate($mesaj1,$tur1);

echo '<meta http-equiv="refresh" content="0;url=register.php"> ';

exit;

}



$title="Ev arkadaşı ilanı ver";



require_once('baglan.php');

?>

<!-- formevarkadasi-->

<!-- sayfayı yenilemeden il seçildikten sonra sadece il bilgisini göndererek ilçeyi çekmek için yazdığım script-->



<script type="text/javascript">

  $(function(){

    $("select[name=il]").change(function(){

      $("select[name=ilce]").remove();

      var id=($(this).val());

      if (id!=0){

        $.post("ajaxil-ilce.php",{"id":id},function(sonuc){

          $("select[name=il]").after('<select class="form-control yeni-boyut-min141" name="ilce" required></select>');

          $("select[name=ilce]").html(sonuc);

        });

      }

    });

  });

  

</script>

<!-- il/ilçe scripti end-->





<?php 







       //iller çekiliyor

      $il_sorgu=$db->prepare("SELECT * FROM muh_iller ");

      $il_sorgu->execute();

      $result_il=$il_sorgu->get_result();

  

      //ısınma şekillleri çekiliyor

      $isitma_sekli=$db->prepare("SELECT * FROM isitmasekli ");

      $isitma_sekli->execute();

      $result_isitma=$isitma_sekli->get_result();

?>





<?php include_once'header.php';?>



<!-- banner -->

<div class="inside-banner">

  <div class="container"> 

    <span class="pull-right"><a href="index.php">Anasayfa</a> / Ev Arkadşı İlanı Formu</span>

    <h2>Ev Arkadşı İlanı</h2>

</div>

</div>

<!-- banner -->



<div class="container">

<div class="properties-listing spacer">



<div class="row">

<!--

<div class="col-lg-3 col-sm-4 ">



  <div class="search-form"><h4><span class="glyphicon glyphicon-search"></span> Ara </h4>



  <form method="get" action="aramasonuclari.php" role="search">

    <input type="text" name="kutu" class="form-control" placeholder="Arama kutusu ...">

    

      <div class="row">

      <div class="col-lg-12">

          <select class="form-control" name="ilanara" required="Bir ilan türü seçin">

            <option value="kalacakyer">Kalacak Yer</option>

            <option value="evarkadasi">Ev Arkadaşı</option>

            <option value="kiralikev">Kiralık Ev</option>

          </select>

          </div>

      </div>

      <button type="submit" class="btn btn-primary">Bul</button>

  </form>

  </div>



<div class="hot-properties hidden-xs">

<h4>Öne Çıkanlar</h4>

<div class="row">

                <div class="col-lg-4 col-sm-5"><img src="images/properties/1.jpg" class="img-responsive img-circle" alt="properties"></div>

                <div class="col-lg-8 col-sm-7">

                  <h5><a href="property-detail.php">Integer sed porta quam</a></h5>

                  <p class="price">$300,000</p> </div>

              </div>

<div class="row">

                <div class="col-lg-4 col-sm-5"><img src="images/properties/1.jpg" class="img-responsive img-circle" alt="properties"></div>

                <div class="col-lg-8 col-sm-7">

                  <h5><a href="property-detail.php">Integer sed porta quam</a></h5>

                  <p class="price">$300,000</p> </div>

              </div>



<div class="row">

                <div class="col-lg-4 col-sm-5"><img src="images/properties/1.jpg" class="img-responsive img-circle" alt="properties"></div>

                <div class="col-lg-8 col-sm-7">

                  <h5><a href="property-detail.php">Integer sed porta quam</a></h5>

                  <p class="price">$300,000</p> </div>

              </div>



<div class="row">

                <div class="col-lg-4 col-sm-5"><img src="images/properties/1.jpg" class="img-responsive img-circle" alt="properties"></div>

                <div class="col-lg-8 col-sm-7">

                  <h5><a href="property-detail.php">Integer sed porta quam</a></h5>

                  <p class="price">$300,000</p> </div>

              </div>



</div>





</div>

-->

<div class="col-lg-12 col-sm-12">

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



<div class="cerceve cerceve-renk">


    <form action="evarkadasiilanikayit.php" method="POST" enctype="multipart/form-data">



      <input type="text" name="ilanbasligi" placeholder="İlan Başlığı" class="form-control" minlength="10" required>

     

      <div class="form-inline">



            <div class="form-inline">        

              <input type="text" name="evkackisi" placeholder="Ev Şimdi kaç kişi" class="form-control" pattern="\d*" title="Lütfen rakamla girin" >

              <input type="text" name="toplamkackisi" placeholder="Toplam Kaç kişi kalacak" class="form-control" pattern="\d*" title="Lütfen rakamla girin" >

            </div>

            <div class="form-inline">

              <input type="text" name="evinkirasi" placeholder="Evin Kirası ne kadar" class="form-control" pattern="\d*" title="Lütfen rakamla girin" >

              <input type="text" name="kisibasibutce" placeholder="Kişi başı bütçe" class="form-control" pattern="\d*" title="Lütfen rakamla girin" >

            </div>

           

          <div class="form-inline">

              <select class="form-control" name="isinmasekli" >

                <option value="">Evin Isınma şekli</option>

                <?php



                while ($isitma_listele=$result_isitma->fetch_assoc()){

                echo '<option value='.$isitma_listele['isinmaID'].'>'.$isitma_listele['isinmaSekli'].'</option>';

                  }

                ?>

              </select>

          </div>

              <div class="form-inline ">

              <select class="form-control yeni-boyut-min141" name="il" required>

                <option value="0">İl Seç</option>

                <?php



                while ($il_listele=$result_il->fetch_assoc()){

                echo '<option value='.$il_listele['id'].'>'.$il_listele['baslik'].'</option>';

                  }

                ?>

              </select>

            </div>      



        </div>



        <textarea class="form-control" rows="8" name="ilanaciklamasi" placeholder="Buraya İlanının Açıklamasını gir" required></textarea>



        <div class="form-group divdiv">



            <label class="font-size18 divdiv">Kendi Odası Olacak <input type="checkbox" name="kendiodasi" value="1"/></label>

        </div>



            <div class="form-group divdiv"> 

            

              <span class="form-group font-size18">Kriterler</span><span> (Olabilir dediklerini işaretle)</span><br/>

              <label class="font-size16">Evcil Hayvan <input type="checkbox" name="kriter[0]" value="1" /></label>

              <label class="font-size16">Sigara <input type="checkbox" name="kriter[1]" value="1" /></label>

              <label class="font-size16">Alkol <input type="checkbox" name="kriter[2]" value="1" /></label>

             

            </div>





            <div class="form-group divdiv">

            

              <span class="form-group font-size18">Cinsiyet:</span><br/>

              <label class="font-size16">Erkek <input type="checkbox" name="cinsiyet[]" value="2"  /></label>

              <label class="font-size16">Kadın <input type="checkbox" name="cinsiyet[]" value="1"  /></label>

            

            </div>

            

           <!--Resim Upload -->

          <div class="fotografyukle divdiv">

            <h3>Fotoğraf Yükle</h3>

              <input type="file" multiple="multiple" name="resim[]" class="form-control"  accept="image/x-png,image/jpeg" multiple /> <!--accept="image/x-png,image/gif,image/jpeg" -->

          </div>



          <div class="form-group divdiv">

            <button type="submit" class="btn btn-primary btn-lg btn-block btn-success">İlanı Kaydet</button>

          </div>

                       



    </form>



    </div> 

    <!--formevarkadasi end-->



    </div>

</div>

</div>

</section>

</div>

</div></div></div></div>

<?php include'footer.php';?>