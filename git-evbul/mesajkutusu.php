<!-- Üyelerin mesajlaşma için kullandıkları form -->
<form class='form-horizontal' method='POST' action='mesajgonder.php'>

<input type="hidden" name="ilan_url" value="<?php echo $ilan_url; ?>"/>
<input type="hidden" name="ilan_baslik" value="<?php echo $ilan_baslik; ?>"/>
<input type="hidden" name="sahip_id" value="<?php echo $ilansahibiid; ?>"/>



  <textarea name='mesaj' rows='6' class='form-control' placeholder='İlan Sahibine mesajın'></textarea>

  <button type='submit' class='btn btn-primary' name='Submit'>Mesaj Gönder</button>

</form>