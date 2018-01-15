



<form class="form-horizontal" method="POST" action="sig.php">

    <input type="text" class="form-control" minlength="2" maxlength="20" placeholder="Adın..." name="name" id="name" title="isminizi girin" required="2-20 karakter arası isminizi girin.">

    <input type="text" class="form-control" placeholder="e-posta adresin..." name="email" id="email" required="Doldurulması zorunlu. E-postanızı girin">

    <input type="password" class="form-control" minlength="5" maxlength="20" placeholder="Şifren..." name="password" id="password" required="Doldurulması zorunlu. en az 5 karakter girmelisiniz. (en fazla 20)">

     

     <div class="form-inline">

      

        <span style="font-size: 16px">Cinsiyet : </span>

        <label class="control-label" >Erkek <input type="radio" name="cinsiyet" value="1" style="width: 25px; margin-left: 10px;" class="btn btn-default btn-circle btn-lg" checked /></label>



        <label class="control-label">Kadin <input type="radio" name="cinsiyet" value="0" style="width: 25px; margin-left: 10px;" class="btn btn-default btn-circle btn-lg" /></label>

        

    </div>

    <?php
    $rand1=rand(1,9);
    $rand2=rand(1,9);

    $topla=$rand1 + $rand2;

    $_SESSION["captcha"] = $topla;
    

echo '<span style="font-size:25px; font-family: arial;">'.$rand1.' + '. $rand2 .' = ? </span>';
    ?>
<input type="text" class="form-control" maxlength="2" placeholder="Kaç yapar?" name="captcha" id="name" title="Kaç yapar" required="">

      <button type="submit" class="btn btn-success" name="Submit">Kaydet</button>

  </form>    





                

        