

  <div class="panel panel-default">

    <div class="panel-heading">

      <ul class="nav nav-tabs nav-pills nav-justified">

        <li role="presentation" ><a href="?git=ilanlarim&kategori=kalacakyerilanlarim">Kalacak Yer İlanlarım</a></li>

        <li role="presentation" class="active"><a href="?git=ilanlarim&kategori=evarkadasiilanlarim">Ev Arkadaşı İlanlarım</a></li>

        <li role="presentation"><a href="?git=ilanlarim&kategori=kiralikevilanlarim">Kiralık Ev İlanlarım</a></li>

      </ul>

    </div>

    <div class="panel-body">



      <ul class="list-group">



        <?php



        //****** sayfalama ********



$sayfalama = $db->prepare("SELECT count(*) FROM evarkadasiilani WHERE girenID='$giren_id_aldik'");

if ($sayfalama === false)

    die('Sorgu hatası:' . $db->error);

/* execute ile sorguyu çalıştıralım */

$sayfalama->execute();

//SQL sorgusundan dönen sonuçları alalım

$sonuc = $sayfalama->get_result();

if ($sonuc->num_rows < 1)

    die('Kayıt bulunmadı');



$sayfa_sayisi = $sonuc->fetch_array();

$limit        = 4; //gösterilecek kayıt sayısı



//index.php?id=1 istek varmı? kontrol edelim

@$sayfa=$_GET['i'];

$ofset = isset($sayfa) ? $sayfa : 0;

// limit ve ve ofset durumuna göre kayıtları elde et

//**************** sayfalama*****


        //ilanları çekiyoruz

        $ev_arkadasi=$db->prepare("SELECT * FROM evarkadasiilani WHERE girenID='$giren_id_aldik' ORDER BY ilanTarihi DESC LIMIT ? OFFSET ?");

        $ev_arkadasi->bind_param("ii", $limit, $ofset);

        $ev_arkadasi->execute();

        $result_ev_arkadasi=$ev_arkadasi->get_result();

        $kac_ilan=$result_ev_arkadasi->num_rows;


                      ?>

                      <div class="tab-content">

        <?php
        $syc=0;
        if($kac_ilan > 0){

          while($fetch_ev_arkadasi=$result_ev_arkadasi->fetch_assoc()){



            $ilan_il=$fetch_ev_arkadasi['ilID'];

            $ilan_ilce=$fetch_ev_arkadasi['ilceID'];



            $ilan_nerede_il=$db->prepare("SELECT * FROM muh_iller WHERE id='$ilan_il'");

                      $ilan_nerede_il->execute();

                      $result_ilan_il=$ilan_nerede_il->get_result();

                      $ilan_il_aldik=$result_ilan_il->fetch_array();



                      $ilan_nerede_ilce=$db->prepare("SELECT * FROM muh_ilceler WHERE id='$ilan_ilce'");

                      $ilan_nerede_ilce->execute();

                      $result_ilan_ilce=$ilan_nerede_ilce->get_result();

                      $ilan_ilce_aldik=$result_ilan_ilce->fetch_array();

            ?>

          <div id="home" class="tab-pane fade in active">

            <li class="list-group-item">

            <div class="row">

              <div class="col-md-9">



              <div class="media">

              <div style="float: left;"" class="media-left hidden-xs">



                  <?php 



                    $ailanID=$db->prepare("SELECT * FROM evarkadasiilani where girenID=?");

                    $ailanID->bind_param("i",$giren_id_aldik);

                    $ailanID->execute();

                    $result_ailanID=$ailanID->get_result();

                    $aldik_ailnaID=$result_ailanID->fetch_assoc();

                    $ilan="e".$fetch_ev_arkadasi['ailanID'];



                    $sorgu1=$db->prepare("SELECT * from ilanresimler where ilanResimID='$ilan'");

                    $sorgu1->execute();

                    $result_sorgu1=$sorgu1->get_result();

                    $aldik_sorgu1=$result_sorgu1->fetch_assoc();

                    $aldik_fotoID=$aldik_sorgu1['fotoID'];



                    $resim_id_stmt=$db->prepare("SELECT * FROM resimler where id='$aldik_fotoID'");

                    $resim_id_stmt->execute();

                    $result_resim_id=$resim_id_stmt->get_result();

                    $num_rows_resim=$result_resim_id->num_rows;

                    $aldik_bilgi=$result_resim_id->fetch_assoc();


                  ?>

                  <?php 

                  $ilan_url="evarkadasibuldum.php?git=".$fetch_ev_arkadasi['url'];

                  ?>

                  <a href="<?php echo $ilan_url; ?>">

                  <?php 

                  if($num_rows_resim < 1){

                    $aldik_resim_url="image/default_ev_arkadasi_icon.jpg";

                  }else{

                    $aldik_resim_url=$aldik_bilgi['resim_url'];

                  }

                  ?>

                  <img class="media-object" style="max-width:120px;" src="<?php echo $aldik_resim_url; ?>" alt="...">

                  </a>

                </div>

                <div class="media-body">

                  <h4 class="media-heading"><a href="<?php echo $ilan_url; ?>"><?php echo wordwrap(baslikKisalt2($fetch_ev_arkadasi['ilanBasligi']))."..."; ?></a>

                    <span class="label label-success pull-top">

                    <?php

                       echo $ilan_il_aldik['baslik'].'/'.$ilan_ilce_aldik['baslik'];

                    ?>

                    </span>

                    <span title="tahmini kişi başı bütce" class="label label-info pull-top"><?php echo $fetch_ev_arkadasi['kisiBasiButce'].'tl'; ?></span>

                  </h4>

                  <p>

                  <?php echo wordwrap(aciklamaKisalt2($fetch_ev_arkadasi['ilanAciklama']))."..."; ?></p>

                </div>

              </div>

              </div>

              <div class="col-md-3 badge" style="border-left:1px solid #ccc; background-color: #f3f89f; padding:10px;">

              <div class="media-right">

                <a target="_blank" href="<?php echo "ev_arkadasi_ilani_duzenle.php?url=".$fetch_ev_arkadasi['url']; ?>"><span style="background-color: orange; margin-right: 10px; font-size: 14px; min-width:18px; float:right; margin:5px;" class="glyphicon glyphicon-pencil badge" aria-hidden="false"> ilanı Düzenle</span></a><br/>
                <?php
                	$syc++;
                	$sy="#urldiv".$syc;
                	$sycop="#urlcopy".$syc;

                ?>
                <script>
				$(document).ready(function(){
		      		$("<?=$sy;?>").hide();
		      		$("<?=$sycop;?>").click(function(){
		       		 $("<?=$sy;?>").slideDown();
		    		});
				});
				</script>
                <span id="urlcopy<?=$syc;?>" style="background-color: skyblue; margin-right: 10px; font-size: 14px; min-width:18px; float:right; margin:5px;" class="glyphicon glyphicon-send badge" aria-hidden="false"> ilanı Paylaş</span><br/>

				<div style="margin-top:50px; padding:5px; background-color: #fff; color:#222; max-width: 200px; " id="urldiv<?=$syc;?>">
					<h6>kopyala (CTRL+C):</h6>
					<div style="font-size: 9px;"><?php echo wordwrap("evbulkur.com/".$ilan_url,37,"<br />\n",true); //uzun linklerde taşmalar önlenmeli?></div>
				</div>

                <span style="background-color: #7f6db6; margin-right: 10px; font-size: 14px; min-width:18px; float:right;margin:5px;" class="glyphicon glyphicon-floppy-save badge" aria-hidden="false"> ilanı Yazdır</span>

              </div>

              </div>



            </li>



            <?php

          }

        }else{ echo "Bu Sayfada Gösterilecek Bir Şey Bulamadık.";}

        ?>



        </div>



      </ul>

    </div>









    <div class="center">

  <ul class="pagination">

    



<?php

    if ($sayfa_sayisi[0] > $limit) {

    $x = 0;



if($sayfa > 0){

  $sayfa0=$sayfa-$limit < 0 ? 0 : $sayfa-$limit ;

    echo "<li><a href='ilanlarim.php?git=ilanlarim&kategori=evarkadasiilanlarim&i=".($sayfa0)."'> « </a></li>";

}

    for ($i = 0; $i < $sayfa_sayisi[0]; $i += $limit) {

        $x++;

       

        echo "<li><a href='ilanlarim.php?git=ilanlarim&kategori=evarkadasiilanlarim&i=$i'>" . $x . "</a></li>";

        

    }



if($sayfa < $sayfa_sayisi[0] - $limit){

  $sayfa1=$sayfa < $sayfa_sayisi[0] ? $sayfa : $$sayfa_sayisi[0] ;

    echo "<li><a href='ilanlarim.php?git=ilanlarim&kategori=evarkadasiilanlarim&i=".($sayfa1+$limit)."'> » </a></li>";

}

}

?>

  </ul>

</div>

  </div>

</div>

<script>

$(document).ready(function(){

    $(".nav-tabs a").click(function(){

        $(this).tab('show');

    });

    $('.nav-tabs a').on('shown.bs.tab', function(event){

        var x = $(event.target).text();         // active tab

        var y = $(event.relatedTarget).text();  // previous tab

        $(".act span").text(x);

        $(".prev span").text(y);

    });

});

</script>