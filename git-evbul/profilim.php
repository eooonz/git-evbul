<?php 

include_once 'oturumkontrolu.php'; //dönen değer  

    $giris_id_aldik=oturumkontrolu();

    include 'relsrc.php'; 

    include_once'fonksiyonlar.php';?>

<?php if(!$giris_id_aldik){

  /*Daha sonra üye girişi yapmamış üyeyi, üyelik bilgilerini ilan üzerinde isteyerek de ilan girmesini kolaylaştırmış oluruz. Üye değilse mail adresini ve şifresini kaydederek "mail adresinize gönderilen linke tıkladığınızda ilanınız yayınlanbacaktır" diyebiliriz.*/


$mesaj1="Profil sayfanı giriş yaptığında görebilirsin.";

    $tur1=0;
    sessioncreate($mesaj1,$tur1);
    echo '<meta http-equiv="refresh" content="0;url=index.php">';

exit;

}

$title="Profilim: EvBulKur";

require_once('baglan.php');


$stmt=$db->prepare("SELECT * FROM uye WHERE uyeID='$giris_id_aldik'");
$stmt->execute();
$result_uye_bilgi=$stmt->get_result();
$uye_bilgi=$result_uye_bilgi->fetch_array();


include_once'header.php';?>


<!-- banner -->

<div class="inside-banner">

  <div class="container"> 

    <span class="pull-right"><a href="index.php">Anasayfa</a> / Profilim</span>

    <h2>Profilim</h2>

</div>

</div>

<!-- banner -->

<!-- <div class="container">  -->

<div class="properties-listing spacer">



<!-- profilim-->

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



<div class="panel panel-default">

<div class="panel-heading">

<h3 class="panel-title">Profilim</h3>

</div>

<div class="panel-body">

<h2>Profil Bilgileri</h2>

  <table class="table">

  <thead>

    <tbody>

      <tr>

        <td>Ad: </td>

        <td><?php echo $uye_bilgi['ad']; ?></td>

      </tr>

      <tr>

      <?php

        if(empty($uye_bilgi['soyad'])){

          $soyad= "<i>Belirtilmedi...</i>";

        }else{

         $soyad=$uye_bilgi['soyad'];

        }

      ?>

        <td>Soyad: </td>

        <td><?php echo $soyad; ?></td>

      </tr>

      <tr>

        <td>Email: </td>

        <td><?php echo $uye_bilgi['email']; ?></td>

      </tr>

      <tr>

       <?php

        if(empty($uye_bilgi['telefonNo'])){

          $telefon= "<i>Belirtilmedi...</i>";

        }else{

         $telefon=$uye_bilgi['telefonNo'];

        }

      ?>

        <td>Cep Telefonu: </td>

        <td><?php echo $telefon; ?></td>

      </tr>

      <tr>

      <?php

        if($uye_bilgi['cinsiyet'] == 0){

          $cinsiyet= "Kadın";

        }elseif($uye_bilgi['cinsiyet'] == 1){

          $cinsiyet= "Erkek";

        }

      ?>

        <td>Cinsiyet: </td>

        <td><?php echo $cinsiyet; ?></td>

      </tr>

      <tr>

      <?php

        //sehirID, ilceID ler çekilip il, ilçe taplolarından isimleri çekilecek

      $uye_sehir=$uye_bilgi['sehirID'];

      $uye_ilce=$uye_bilgi['ilceID'];



      $uye_nereli_sehir=$db->prepare("SELECT * FROM muh_iller WHERE id='$uye_sehir'");

      $uye_nereli_sehir->execute();

      $result_uye_sehir=$uye_nereli_sehir->get_result();

      $uye_sehir_aldik=$result_uye_sehir->fetch_array();



      $uye_nereli_ilce=$db->prepare("SELECT * FROM muh_ilceler WHERE id='$uye_ilce'");

      $uye_nereli_ilce->execute();

      $result_uye_ilce=$uye_nereli_ilce->get_result();

      $uye_ilce_aldik=$result_uye_ilce->fetch_array();



      if(empty($uye_sehir_aldik && $uye_ilce_aldik)){

        $uye_sehir_goster="<i>Belirtilmedi...</i>"; 

      }else{

        $uye_sehir_goster= $uye_sehir_aldik[1]. "/" .$uye_ilce_aldik['2'];

      }

      ?>

        <td>Şehir: </td>

        <td><?php echo $uye_sehir_goster; ?></td>

      </tr>

      <tr>

        <td></td>

        <td class="duzenlebuton"><a href="uye_bilgi_guncelle.php" class="duzenlebuton">Şifre ve Bilgileri Düzenle</a></td>

      </tr>

    </tbody>

  </table>

</div>

</div>



</div>



</div>



</div>

</div>



</div> 

    <!--profilim end-->



   

</div>

</div>



<!--  </div> -->

<?php include'footer.php';?>