





<div class="footer">

<div class="container">

<div class="row">

            <div class="col-lg-4 col-sm-4 hidden-xs">

                   <h4>Sayfalar</h4>

                   <ul class="row">

                <li class="col-lg-12 col-sm-12 col-xs-3"><a href="hakkimizda.php">Hakkımızda</a></li>

                <li class="col-lg-12 col-sm-12 col-xs-3"><a href="ilanlarim.php">İlanlarım</a></li>         

                <li class="col-lg-12 col-sm-12 col-xs-3"><a href="profilim.php">Profilim</a></li>

                <li class="col-lg-12 col-sm-12 col-xs-3"><a href="formkalacakyer.php">Kalacak Yer Arıyorsan</a></li>

                <li class="col-lg-12 col-sm-12 col-xs-3"><a href="formevarkadasi.php">Ev Arkadaşı Arıyorsan</a></li>

                <li class="col-lg-12 col-sm-12 col-xs-3"><a href="formkiralikev.php">Ev Kiralıyorsan</a></li>

              </ul>

            </div>

            

            <div class="col-lg-4 col-sm-4">

                    <h4>Bize Bildir</h4>

                    <b>İlanlarda, sitenin işleyişinde bir problem varsa ve ya şurası böyle olsa daha iyi olur dediğin bir yer; bize yaz.</b>

                    <form method="post" action="onerikutusu.php" class="form-inline " >

                      <textarea style="width: 100%;" name="mesaj" placeholder="Şikayet/Öneri Kutusu" class="form-control" required="Bir şeyler yazmayı unuttun"></textarea>

                      <button class="btn btn-success" type="submit">Gönder</button>

                    </form>

            </div>

            
<!--
            <div class="col-lg-3 col-sm-3">

                    <h4>Sosyal Medya Hesaplarımız</h4>

                    <a href="#"><img src="images/facebook.png" alt="facebook"></a>

                    <a href="#"><img src="images/twitter.png" alt="twitter"></a>

                    <a href="#"><img src="images/linkedin.png" alt="linkedin"></a>

                    <a href="#"><img src="images/instagram.png" alt="instagram"></a>

            </div>

-->

             <div class="col-lg-4 col-sm-4">

                    <h4>İletişim</h4>

                    <p><b>EvBulKur.com</b><br>

<span class="glyphicon glyphicon-map-marker"></span>Bursa/Nilüfer, Türkiye {EvBulKur de gösterirler :) }<br>

<span class="glyphicon glyphicon-envelope"></span> merhaba@evbulkur.com<br>

<span class="glyphicon glyphicon-earphone"></span> (123) 456-7890</p>

            </div>

        </div>

<p class="col-md-10 copyright">Tüm Haklarını sakladık bakalım bulabilecek misin :) SINCE 2017.  </p>
<p class="col-md-2 copyright" style="float: right;">Developed by <a href="" >eooonz</a></p>

<!--  Footer altına ilanları illere göre gruplama linkleri tablosu
<div class="container">
  <div class="row">
    <div class="col-lg-4 table-responsive">
      <p>Kalacak Yer İlanları</p>
      <?php //include "illerKalacakYer.html"; ?>
    </div>
    <div class="col-md-4 table-responsive">
      <p>Kalacak Yer İlanları</p>
      <?php //include "illerKalacakYer.html"; ?>
    </div>
    <div class="col-md-4 table-responsive">
      <p>Kalacak Yer İlanları</p>
      <?php //include "illerKalacakYer.html"; ?>
    </div>
  </div>
</div>

-->
</div>

</div>






<!-- Modal -->

<div id="loginpop" class="modal fade">

  <div class="modal-dialog">

    <div class="modal-content">

      <div class="row">

        <div class="col-sm-6 login">

        <h4>Giriş Yap</h4>

          <form class="form-group" role="form" method="POST" action="login.php">

        <div class="form-group">

          <label class="sr-only" for="exampleInputEmail2">E-Posta</label>

          <input type="email" class="form-control" name="email" id="email" placeholder="e-posta" required>

        </div>

        <div class="form-group">

          <label class="sr-only" for="exampleInputPassword2">şifre</label>

          <input type="password" class="form-control" name="password" id="password" placeholder="Şifre" required>

        </div>

       

        <button type="submit" class="btn btn-success">Giriş Yap</button>

      </form>          

        </div>

        <div class="col-sm-6">

          <h4>Üye değil misin?</h4>

          <p>Tüm özellikleri kullanmak için üye ol.</p>

          <button type="submit" class="btn btn-info"  onclick="window.location.href='register.php'">Üye Ol</button>

        </div>



      </div>

    </div>

  </div>

</div>

<!-- /.modal -->



</body>

</html>







