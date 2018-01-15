<?php


	include_once 'baglan.php';
	include 'relsrc.php';
	include_once 'fonksiyonlar.php';
	include_once 'oturumkontrolu.php';
	$alan_id=oturumkontrolu();

	if(!$alan_id){
	echo '<meta http-equiv="refresh" content="0;url=index.php"> ';
	exit;
	}

	$mesajID=$_GET['mesaj'];

	$title="Mesaj yaz";

$stmt=$db->prepare("SELECT * FROM uye WHERE uyeID='$alan_id'");
$stmt->execute();
$result_uye_bilgi=$stmt->get_result();
$uye_bilgi=$result_uye_bilgi->fetch_array();


	$mesaj_pre=$db->prepare("SELECT * FROM mesajlar WHERE mesajID=?");

	$mesaj_pre->bind_param("i",$mesajID);

	$mesaj_pre->execute();

	$mesaj_result=$mesaj_pre->get_result();

	$mesaj=$mesaj_result->fetch_assoc();

	$aliciID=$mesaj['aliciID'];
	$gonderenID=$mesaj['gonderenID'];



	//kişiler arasındaki geçmiş mesajları çekiyoruz

	$goster_mesaj_pre=$db->prepare("SELECT * FROM mesajlar WHERE aliciID=? AND gonderenID=? OR gonderenID=? AND aliciID=? ORDER BY mesajTarihi ASC");

	$goster_mesaj_pre->bind_param("iiii",$aliciID,$gonderenID,$aliciID,$gonderenID);

	$goster_mesaj_pre->execute();

	$goster_mesaj_result=$goster_mesaj_pre->get_result();
?>


<?php include_once'header.php';?>


<!-- banner -->

<div class="inside-banner">

  <div class="container"> 

    <span class="pull-right"><a href="index.php">Anasayfa</a> / cevap</span>

    <h2>cevap</h2>

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

                  <h3 class="panel-title">cevapla</h3>

                </div>

                <div class="panel-body" style="max-height: 500px; overflow-y: scroll; overflow-x: hidden;">

                <script>
                //mesajlar çoksa, scroll u en aşağıya indiriyoruz (daha doğrusu 5000 px indiriyoruz)
				$(window).load(function(){
				    $('.panel-body').animate({
				        scrollTop: '5000px'
				    },1000);
				});
				</script>

                  <ul class="list-group">






<div class="container" >

	<div class="col-sm-6">
<?php
	while($mesaj_goster=$goster_mesaj_result->fetch_assoc()){

	if($mesaj_goster['aliciID'] != $alan_id){
		

		$alanID=$mesaj_goster['aliciID'];
		//mesaj gönderenin bilgilerine ulaşıyoruz
		$alan_pre=$db->prepare("SELECT * FROM uye WHERE uyeID=$alanID");
		$alan_pre->execute();
		$alan_result=$alan_pre->get_result();
		$alan_bilgi=$alan_result->fetch_assoc();


		$alanAdi=$uye_bilgi['ad'];
		$mesaj=$mesaj_goster['mesaj'];
		$mesajTarihi=$mesaj_goster['mesajTarihi'];
		$mesajİlanUrl=$mesaj_goster['ilanUrl'];
		$mesajBaslik=$mesaj_goster['ilanBaslik'];
		$mesajID=$mesaj_goster['mesajID'];

		 ?>
		 
            <div class="col-xs-12 well well-lg pull-left" style="margin-bottom: 5px; border: 1px solid #ccc; border-radius: 5px; background-color: lightgreen;">
            <div>Ben: </div>
            <div><?php echo $mesaj; ?></div>
            <span style="" class=" badge pull-right">Tarih: <?php echo $mesajTarihi; ?></span><br/> 
            </div>            
	<?php }else{
		$alanID=$alan_id;
		$gonderenID=$mesaj_goster['gonderenID'];
		//mesaj gönderenin bilgilerine ulaşıyoruz
		$gonderen_pre=$db->prepare("SELECT * FROM uye WHERE uyeID='$gonderenID'");
		$gonderen_pre->execute();
		$gonderen_result=$gonderen_pre->get_result();
		$gonderen_bilgi=$gonderen_result->fetch_array();

		$alanAdi=$uye_bilgi['ad'];
		$mesaj=$mesaj_goster['mesaj'];
		$mesajTarihi2=$mesaj_goster['mesajTarihi'];
		$mesajİlanUrl=$mesaj_goster['ilanUrl'];
		$mesajBaslik=$mesaj_goster['ilanBaslik'];
		$mesajID=$mesaj_goster['mesajID'];
?>
		<div class="col-xs-12 well well-lg pull-right" style="margin-bottom: 5px; border: 1px solid #ccc; border-radius: 5px; background-color: skyblue;">
		<div><b><?php echo $gonderen_bilgi['ad']; ?></b></div>
		<div><?php echo $mesaj; ?></div>
		<span style="" class="badge pull-right">Tarih: <?php echo $mesajTarihi2; ?></span><br/>
</div>
	<?php

		$mesajgoruldu_sorgu=$db->prepare("UPDATE mesajlar SET okundumu =1  WHERE aliciID=$alan_id AND gonderenID=$gonderenID ");
        $mesajgoruldu_sorgu->execute();

		}


	}
		

?>
<!-- Üyelerin mesajlaşma için kullandıkları form -->

<form class='form-horizontal' method='POST' action='mesajgonder.php'>

<input type="hidden" name="ilan_url" value="<?php echo $mesajİlanUrl; ?>"/>
<input type="hidden" name="ilan_baslik" value="<?php echo $mesajBaslik; ?>"/>
<input type="hidden" name="sahip_id" value="<?php echo $gonderenID; ?>"/>

  <textarea name='mesaj' rows='6' class='form-control' placeholder='Mesaj...' required="mesaj yazmadın.."></textarea>

  <button type='submit' class='btn btn-primary' name='Submit'>Mesaj Gönder</button>

</form>

</div>
</div>



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