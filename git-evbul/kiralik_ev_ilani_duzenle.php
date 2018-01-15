<?php 

include_once('relsrc.php'); //stil dosyaları yollları 

include_once 'oturumkontrolu.php'; //dönen değer  

    $giren_id_aldik=oturumkontrolu();?>

<?php if($giren_id_aldik==false){

  /*Daha sonra üye girişi yapmamış üyeyi, üyelik bilgilerini ilan üzerinde isteyerek de ilan girmesini kolaylaştırmış oluruz. Üye değilse mail adresini ve şifresini kaydederek "mail adresinize gönderilen linke tıkladığınızda ilanınız yayınlanbacaktır" diyebiliriz.*/



echo '<meta http-equiv="refresh" content=";url=index.php"> ';

exit;

}



$title="Kiralık ev ilanı düzenle";



require_once('baglan.php');



$stmt=$db->prepare("SELECT * FROM uye WHERE uyeID='$giren_id_aldik'");

$stmt->execute();

$result_uye_bilgi=$stmt->get_result();

$uye_bilgi=$result_uye_bilgi->fetch_array();



$sayfa_url=$_GET['url'];



$stmt=$db->prepare("SELECT * FROM kiralikevilani where url='$sayfa_url' AND girenID=$giren_id_aldik");



  $stmt->execute();



  $result=$stmt->get_result();



  //ilan linki doğru girilmemişse veritabanında lik bulunamaz ve bizde burada hata verdirtiyoruz. Fakat tasarımı düzenlenmeli 

  $varmi=$result->num_rows;

  if($varmi < 1){
echo '<meta http-equiv="refresh" content="0;url=http://www.evbulkur.com">'; exit;}



  $row=$result->fetch_array();



  $ilan_id=$row['kilanID'];

  $ilan_resim_id="ki"."$ilan_id";



  $stmt->close();



  //il isim çekme

  $il_stmt=$db->prepare("SELECT ilID,ilceID,baslik from kiralikevilani as k inner join muh_iller as il on k.ilID=il.ID where k.kilanID ='$ilan_id'");

  $il_stmt->execute();

  $result_il=$il_stmt->get_result();

  $row_il=$result_il->fetch_array();



  $ilceID=$row['ilceID'];



  //ilçe isim çekme

  $ilce_stmt=$db->prepare("SELECT baslik from muh_ilceler where id='$ilceID'");

  $ilce_stmt->execute();

  $result_ilce=$ilce_stmt->get_result();

  $row_ilce=$result_ilce->fetch_array();





  //ısınma şekli çekme

  $isitma=$row['isinmaSekliID'];

  $isinma_stmt=$db->prepare("SELECT isinmaSekli from isitmasekli where isinmaID=$isitma");

  $isinma_stmt->execute();

  $result_isinma=$isinma_stmt->get_result();

  $row_isinma=$result_isinma->fetch_array();



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

  

      //ısınma şekillleri çekiliyor

      $isitma_sekli=$db->prepare("SELECT * FROM isitmasekli ");

      $isitma_sekli->execute();

      $result_isitma=$isitma_sekli->get_result();

      $db->close();

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



    <form action="kiralikevilaniupdate.php" method="POST" enctype="multipart/form-data" >



    <input type="hidden" name="kilanid" value="<?php echo $row['kilanID'];?>" class="form-control" >



      <input type="text" name="ilanbasligi" value="<?php echo $row['ilanBasligi'];?>" class="form-control" >

     

      <div class="form-inline">



            <div class="form-inline">        

              <input type="text" name="odasayisi" placeholder="oda sayısı(salon dahil)" value="<?php echo $row['odaSayisi'];?>" class="form-control" pattern="\d*" title="Lütfen rakamla girin" >

              <input type="text" name="kacmetrekare" placeholder="kaç metrekare" value="<?php echo $row['metrekare'];?>" class="form-control" pattern="\d*" title="Lütfen rakamla girin" > <span>m2</span>

            </div>

            <div class="form-inline">

              <input type="text" name="kacincikat" placeholder="kaçıncı kat" value="<?php echo $row['kacinciKat'];?>" class="form-control" pattern="\d*" title="Lütfen rakamla girin (bodrum=0, -2)" >

              <input type="text" name="evinkirasi" placeholder="evin kirası" value="<?php echo $row['evinKirasi'];?>" class="form-control" pattern="\d*" title="Lütfen rakamla girin" > <span>tl</span>

            </div>

           

           <?php

           $isinmaID=$row['isinmaSekliID'];

           $isinma_sorgu=$db->prepare("SELECT isinmaSekli FROM isitmasekli WHERE isinmaID=$isinmaID");

           $isinma_sorgu->execute();

           $isinma_result=$isinma_sorgu->get_result();

           $isinma_fetch=$isinma_result->fetch_array();

           $isinma=$isinma_fetch[0];



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

          <div class="form-inline">

              <select class="form-control" name="isinmasekli" >

                <option value="<?=$isinmaID;?>"><?=$isinma;?></option>

                <?php



                while ($isitma_listele=$result_isitma->fetch_assoc()){

                echo '<option value='.$isitma_listele['isinmaID'].'>'.$isitma_listele['isinmaSekli'].'</option>';

                  }

                ?>

              </select>

          </div>



          <div class="form-group ">

          <?php 

          if($row['esyaliMi'] == 1){

            $esya="checked=true";

          }else{ $esya="";}

          ?>

            <label class="font-size18 divdiv">Ev Eşyalı Mı? <input type="checkbox" name="esyalimi" value="1" <?php echo $esya; ?> /></label>

          </div>



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



        <textarea class="form-control" rows="8" placeholder="ilan açıklaması" name="ilanaciklama" ><?php echo $row['ilanAciklama'];?></textarea>

        <textarea class="form-control" rows="3" placeholder="adres..." name="adres" ><?php echo $row['adres'];?></textarea>





          <div class="form-group divdiv">

            <button type="submit" class="btn btn-primary btn-lg btn-block btn-success">İlanı Kaydet</button>

          </div>

                       



    </form>

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

        

        <form action="kiralikevilanisil.php" method="post">

        <button type="button" class="btn btn-primaty" data-dismiss="modal">Hayır</button>

        <input type="hidden" name="ilanisil" value="<?php echo $row['kilanID'];?>" class="form-control" >

        <button type="submit" class="btn btn-warning">Evet, sil.</button>

        </form>

      </div>

    </div>

  </div>

</div>



    </div> 

    <!--formkiralikev end-->





    



    </div>



</div>



</div>

</div>



</div> 

    <!--profilim end-->





    



    





   

</div>

</div>



<!--  </div> -->

<?php include_once'footer.php';?>

