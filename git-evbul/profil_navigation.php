<div class="panel panel-default ">
    <div class="panel-heading">

      <h3 class="panel-title">Profilim</h3>

    </div>

    <div class="panel-body">

    <?php
    /*profil resminde bir resim yüklememişse cinsiyetine göre varsasyılan resim göstersin. Varsa eklanmiş resmi göstersin */

    if($uye_bilgi['cinsiyet'] == 0){

      if(empty($uye_bilgi['profilResmi'])){

      $profil_resmi="image/default_kadin.png";

      }else{

        $profil_resmi=$uye_bilgi['profilResmi'];

      }

    }elseif($uye_bilgi['cinsiyet'] == 1){

      if(empty($uye_bilgi['profilResmi'])){

      $profil_resmi="image/default_erkek.png";

      }else{

        $profil_resmi=$uye_bilgi['profilResmi'];

      }
    }
?>
      <img src="<?php echo $profil_resmi; ?>" class="img-responsive" alt="profil resmim"> <!--profil resmim-->

      <!-- Trigger the modal with a button -->

      <button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-xs btn-block btn-warning">Profil Resmini Değiştir</button>

      <!-- Modal -->

      <div id="myModal" class="modal fade" role="dialog">

        <div class="modal-dialog">

          <!-- Modal content-->

          <div class="modal-content">

            <div class="modal-header">

              <button type="button" class="close" data-dismiss="modal">&times;</button>

              <h4 class="modal-title">Profil Resmi Değiştirme</h4>

            </div>

          <div class="modal-body">



          <form action="profilresmidegistirme.php" method="POST" enctype="multipart/form-data">

              <div class="fotografyukle divdiv">
                <h3>Resim Seç</h3>
                <input type="file" name="profilresmi" class="form-control"  accept="image/x-png,image/jpeg,image/jpg" /> <!--accept="image/x-png,image/gif,image/jpeg" -->
              </div>

              <div class="form-group divdiv">
                <button type="submit" class="btn btn-primary btn-lg btn-block btn-success">Resmi Yükle</button>
              </div>

          </form>

            </div>

            <div class="modal-footer">

              <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>

            </div>

        </div>



        </div>

      </div>



      <div class="list-group">

        <a href="profilim.php" class="list-group-item list-group-item-warning">Profilim</a>

        <a href="ilanlarim.php" class="list-group-item list-group-item-warning">İlanlarım</a>

        <a href="mesajlarim.php" class="list-group-item list-group-item-warning">Mesajlarım</a>

      </div>



    </div>

  </div>