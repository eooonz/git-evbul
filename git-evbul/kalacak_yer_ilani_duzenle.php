<?php 

include_once('relsrc.php'); //stil dosyaları yollları 

include_once 'oturumkontrolu.php'; //dönen değer  

    $giren_id_aldik=oturumkontrolu();?>

<?php if(!$giren_id_aldik){

  /*Daha sonra üye girişi yapmamış üyeyi, üyelik bilgilerini ilan üzerinde isteyerek de ilan girmesini kolaylaştırmış oluruz. Üye değilse mail adresini ve şifresini kaydederek "mail adresinize gönderilen linke tıkladığınızda ilanınız yayınlanbacaktır" diyebiliriz.*/



  /*Burayı OGM dersinde sonradan ekledim*/
  echo "bir çıktı";


echo '<meta http-equiv="refresh" content="0;url=index.php"> ';

exit;

}



$title="Kalacak yer ilanı düzenle";



require_once('baglan.php');



$stmt=$db->prepare("SELECT * FROM uye WHERE uyeID='$giren_id_aldik'");

$stmt->execute();

$result_uye_bilgi=$stmt->get_result();

$uye_bilgi=$result_uye_bilgi->fetch_array();



$sayfa_url=$_GET['url'];



$stmt=$db->prepare("SELECT * FROM kalacakyerilani where url='$sayfa_url' AND girenID=$giren_id_aldik");



  $stmt->execute();



  $result=$stmt->get_result();



  //ilan linki doğru girilmemişse veritabanında lik bulunamaz ve bizde burada hata verdirtiyoruz. Fakat tasarımı düzenlenmeli 

  $varmi=$result->num_rows;

  if($varmi < 1){echo "aradığınız ilan bulunamadı."; exit;}



  $row=$result->fetch_array();



  $ilan_id=$row['eilanID'];

  $ilan_resim_id="e"."$ilan_id";



  $stmt->close();



  //il isim çekme

  $il_stmt=$db->prepare("SELECT ilID,ilceID,baslik from kalacakyerilani as e inner join muh_iller as il on e.ilID=il.ID where e.eilanID ='$ilan_id'");

  $il_stmt->execute();

  $result_il=$il_stmt->get_result();

  $row_il=$result_il->fetch_array();



  $ilceID=$row['ilceID'];



  //ilçe isim çekme

  $ilce_stmt=$db->prepare("SELECT baslik from muh_ilceler where id='$ilceID'");

  $ilce_stmt->execute();

  $result_ilce=$ilce_stmt->get_result();

  $row_ilce=$result_ilce->fetch_array();







?>



<!-- formkiralikev-->



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

  

      /*//ısınma şekillleri çekiliyor

      $isitma_sekli=$db->prepare("SELECT * FROM isitmasekli ");

      $isitma_sekli->execute();

      $result_isitma=$isitma_sekli->get_result();*/

      

?>


<?php include_once'fonksiyonlar.php';?>
<?php include_once'header.php';?>



<!-- banner -->

<div class="inside-banner">

  <div class="container"> 

    <span class="pull-right"><a href="index.php">Anasayfa</a> / ilan Düzenle</span>

    <h2>ilan düzenle</h2>

</div>

</div>

<!-- banner -->

<!-- <div class="container">  -->

<div class="properties-listing spacer">











 <div class="cerceve cerceve-renk">

    

    <div class="row">

<div class="container-fluid">

<div class="col-md-3">



<?php

//profil biglilerinin navigasyon kutusunu include ettik

 include_once 'profil_navigation.php';

?>



</div>

<div class="col-md-6">



<div class="row"><!-- ilan açıklama satırı-->



<div class="panel panel-default ">

    <div class="panel-heading">

      <h3 class="panel-title">Düzenlediğiniz ilan: <?php echo $row['ilanBasligi'];?></h3>

    </div>

    <div class="panel-body">



    



    <form action="kalacakyerilaniupdate.php" method="POST" >



    <input type="hidden" name="eilanid" value="<?php echo $row['eilanID'];?>" class="form-control" >



      <input type="text" name="ilanbasligi" placeholder="İlan Başlığı" value="<?php echo $row['ilanBasligi'];?>" class="form-control" required>

     

      <div class="form-inline">



            <div class="form-inline">        

              <input type="text" name="butcem" placeholder="Bütçem" value="<?php echo $row['butcem'];?>" class="form-control" pattern="\d*" title="Lütfen rakamla girin" required>    

            </div>

           

           <?php

           



           $ilID=$row['ilID'];

           $il_sorgu=$db->prepare("SELECT baslik FROM muh_iller WHERE id=$ilID");

           $il_sorgu->execute();

           $il_result=$il_sorgu->get_result();

           $il_fetch=$il_result->fetch_array();

           $iladi=$il_fetch[0];



           $ilceID=$row['ilceID'];

           $ilce_sorgu=$db->prepare("SELECT baslik FROM muh_ilceler WHERE id=$ilceID");

           $ilce_sorgu->execute();

           $ilce_result=$ilce_sorgu->get_result();

           $ilce_fetch=$ilce_result->fetch_array();

           $ilceadi=$ilce_fetch[0];





           ?>

<!--

          <div class="form-inline">

              <select class="form-control" name="isinmasekli" required>

                <option value="<?=$isinmaID;?>"><?=$isinma;?></option>

                <?php

/*

                while ($isitma_listele=$result_isitma->fetch_assoc()){

                echo '<option value='.$isitma_listele['isinmaID'].'>'.$isitma_listele['isinmaSekli'].'</option>';

                  }*/

                ?>

              </select>

          </div>

          -->

              <div class="form-inline ">

              <select class="form-control yeni-boyut-min141" name="il" >

                <option value="">Değiştirmek için İl Seç</option>

                <?php



                while ($il_listele=$result_il->fetch_assoc()){

                echo '<option value='.$il_listele['id'].'>'.$il_listele['baslik'].'</option>';

                  }

                ?>

              </select><span> Şu anda <?="<b>$iladi</b> / $ilceadi";?></span>

            </div>      



        </div>



        <textarea class="form-control" rows="8" name="ilanaciklamasi" placeholder="Buraya İlanının Açıklamasını gir" required><?php echo $row['ilanAciklama'];?></textarea>





        <div class="form-group divdiv">

            <?php 

            $odasi=$row['odamOlsun'];

            if($row['odamOlsun'] == 1){

              $odasi="checked";

              }else{$odasi="";}

            ?>

            <label class="font-size18 divdiv">Ayrı Odam Olsun <input type="checkbox" name="kendiodasi" value="1" <?php echo $odasi; ?> /></label>

        </div>



            <div class="form-group divdiv"> 



            <?php

            $kriterID=$row['kriterID'];

            $kritersecilimi=$db->prepare("SELECT * FROM kriterler WHERE kriterID=$kriterID ");

            $kritersecilimi->execute();

            $result_kritersecilimi=$kritersecilimi->get_result();

            $fetch_kritersecilimi=$result_kritersecilimi->fetch_assoc();





            if($fetch_kritersecilimi['evcilhayvan'] =="1"){

              $evcil="checked";

            }else{$evcil="";}

            if($fetch_kritersecilimi['sigara'] =="1"){

              $sigara="checked";

            }else{$sigara="";}

            if($fetch_kritersecilimi['alkol'] =="1"){

              $alkol="checked";

            }else{$alkol="";}

            ?>

            

              <span class="form-group font-size18">Kriterler</span><span> (Olabilir dediklerini işaretle)</span><br/>

              <label class="font-size16">Evcil Hayvan <input type="checkbox" name="kriter[0]" value="1" <?php echo $evcil; ?> /></label>

              <label class="font-size16">Sigara <input type="checkbox" name="kriter[1]" value="1" <?php echo $sigara; ?>/></label>

              <label class="font-size16">Alkol <input type="checkbox" name="kriter[2]" value="1" <?php echo $alkol; ?>/></label>

             

            </div>



            <div class="form-group divdiv">



            <?php

              if($row['cinsiyet'] == 1){

                $erkeksec="checked";

              }else{$erkeksec="";}

              if($row['cinsiyet'] == 0){

                $kadinsec="checked";

              }else{$kadinsec="";}

            ?>

              <span class="form-group font-size18">Cinsiyet:</span><br/>

              <label class="font-size16">Erkek <input type="radio" name="cinsiyet" value="1"  <?php echo $erkeksec; ?> /></label>

              <label class="font-size16">Kadın <input type="radio" name="cinsiyet" value="0"  <?php echo $kadinsec; ?>/></label>

            

            </div>

         



          <div class="form-group divdiv">

            <button type="submit" class="btn btn-primary btn-lg btn-block btn-success">İlanı Kaydet</button>

          </div>

                       



    </form>



    <!--formevarkadasi end-->

          <div class="form-group divdiv">

            <button type="submit" title="Görünmesini istemediğin ilanın görülmesini engelleyebilirsin." class="btn btn-primary btn-sm btn-block btn-danger" data-toggle="modal" data-target="#ilansilinsinmi">İlanı Sil</button>

          </div>



          <!-- Modal -->

<div class="modal fade" id="ilansilinsinmi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        <h4 class="modal-title" id="myModalLabel">İlan Silinecek</h4>

      </div>

      <div class="modal-body">

        İlanınız silinecek! Bu işlemei onaylıyor musununuz?

      </div>

      <div class="modal-footer">

        

        <form action="kalacakyerilanisil.php" method="post">

        <button type="button" class="btn btn-primaty" data-dismiss="modal">Hayır</button>

        <input type="hidden" name="ilanisil" value="<?php echo $row['eilanID'];?>" class="form-control" >

        <button type="submit" class="btn btn-warning">Evet, sil.</button>

        </form>

      </div>

    </div>

  </div>

</div>



    </div> 

    <!--formkiralikev end-->





    