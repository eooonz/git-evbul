<?php 

require_once('baglan.php');
include_once('relsrc.php'); //stil dosyaları yollları 
?>

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

      include_once 'oturumkontrolu.php'; //dönen değer $giren_id_aldik 
      $giren_id_aldik=oturumkontrolu();

      if(!$giren_id_aldik){
      $db->close();
      echo '<meta http-equiv="refresh" content="0;url=index.php">';
      exit;
      }

      $stmt=$db->prepare("SELECT * FROM uye WHERE uyeID='$giren_id_aldik'");
      $stmt->execute();
      $result_uye_bilgi=$stmt->get_result();
      $uye_bilgi=$result_uye_bilgi->fetch_array();
?>



<?php include_once'header.php';?>
<?php include_once'fonksiyonlar.php';?>
<!-- banner -->
<div class="inside-banner">
  <div class="container"> 
    <span class="pull-right"><a href="index.php">Anasayfa</a> / Bilgilerimi güncelle</span>
    <h2>Kiralık Ev İlanları</h2>
</div>
</div>
<!-- banner -->


<div class="container">
<div class="properties-listing spacer">

<div class="row">




<div class="cerceve cerceve-renk">
  <div class="col-md-3">
  
    <?php
    //profil biglilerinin navigasyon kutusunu include ettik
     include_once 'profil_navigation.php';
    ?>
  </div>


  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Üyelik Bilgilerini Güncelle</h3>
      </div>
      <div class="panel-body">
      
        <form action="bilgileriguncelle.php" method="POST" >
          <div class="form-group">
            <div class="form-inline">
              <input type="text" name="ad" placeholder="<?php echo $uye_bilgi['ad']; ?>" class="form-control" title="Değiştirmek istediğin ismin gir" minlength="2">
            </div>

            <div class="form-inline">
            <?php
                  if(empty($uye_bilgi['soyad'])){
                    $soyad='Soyad';
                  }else{
                    $soyad= $uye_bilgi['soyad'];
                  }
                  ?>
              <input type="text" name="soyad" placeholder="<?php echo $soyad; ?> " class="form-control" title="Değiştirmek istediğin Soyadı gir" minlength="2">
            </div>
            <div class="form-inline">
              <input type="email" name="email" placeholder="<?php echo $uye_bilgi['email']; ?>" class="form-control">
            </div>
            <div class="form-inline">
              <?php
                if(empty($uye_bilgi['telefonNo'])){
                  $telefon= "Telefon";
                }else{
                 $telefon=$uye_bilgi['telefonNo'];
                }
              ?>
              <input type="tel" name="phone" maxlength="10" placeholder="<?php echo $telefon; ?>" class="form-control" title='Başına "0" koymadan giriniz.'>
            </div>

            <div class="form-group divdiv">
            <?php
              if($uye_bilgi['cinsiyet'] == 1){
                $erkek="checked=true";
                $kadin="";
            }else{
              $kadin="checked=true";
              $erkek="";
            }
            ?>
              <span class="form-group font-size18">Cinsiyet:</span><br/>
              <label class="font-size16">Erkek <input type="radio" <?php echo $erkek; ?> name="cinsiyet" value="1"/></label>
              <label class="font-size16">Kadın <input type="radio" <?php echo $kadin; ?> name="cinsiyet" value="0"  /></label>
            </div>

            <div class="form-inline" style="font-weight: bolder;">
              <select class="form-control yeni-boyut-min141" name="il" >
                <option value="0">İl Seç</option>
                <?php
                while ($il_listele=$result_il->fetch_assoc()){
                echo '<option value='.$il_listele['id'].'>'.$il_listele['baslik'].'</option>';
                  }
                ?>
              </select>
            </div>      

          </div>
          <div class="form-inline ">
            <input type="password" name="password" placeholder="şifre" class="form-control font-size16" title="Yeni şifreni gir" >
          </div>
          <div class="form-inline ">
            <input type="password" name="guvenlik_password" placeholder="Güvenliğin için şifreni gir" class="form-control font-size16" style="border: 3px solid #888; margin-top: 30px; " title="Değişiklikleri kaydetmek için şifrenizi girin." required>
          <div style="font-family: arial;font-size: 10px;margin-bottom: 15px;" title="Değişiklikleri kaydetmek için şifrenizi girin.">(Değişiklikleri kaydetmek için şifrenizi girin.)</div>
          </div>

          <div class="form-group divdiv">
            <button type="submit" class="btn btn-primary btn-md btn-block btn-success">Değişiklikleri Kaydet</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div> 



    

    


    </div>
</div>
</div>

<?php include'footer.php';?>