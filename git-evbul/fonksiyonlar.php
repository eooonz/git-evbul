<?php

@session_start();



//güvenlik için verileri temezlemek için oluşturuldu

function guvenlik_fonksiyonu($temizlenecek){

	
//bu bir değişiklik midir
$temizlendi=strip_tags(addslashes(trim($temizlenecek)));



  /*$temizle1=addslashes(htmlentities($temizlenecek,2,'UTF-8')); //Boşlukları temizledik

	//htmlentities("temizlenecek ifade",'END_QUOTES','UTF-8'); //tek tırnak ve çift tırnakları temizledik bu veri tabanına veri kaydederken önemli

	$temizle2=strip_tags($temizle1); //html taglarını temizledik

	$temizle3=htmlspecialchars($temizle2); //javascript, html komutlarını işlevsiz hale getirdik.

	$temizlendi=trim($temizle3); //Boşlukları temizledik



	//nl2br(); //fazladan atılan boşlukları gidermek için */

  return $temizlendi;

}



//ilanları gösterirken başlık ve açıklamaları kısalma fonksiyonları

function baslikKisalt($baslik){

  $baslik30=mb_substr($baslik,0,23);

  return wordwrap($baslik30,30,"<br />\n",true);

}

function aciklamaKisalt($aciklama){

  $aciklama100=substr($aciklama,0,100);

  return wordwrap($aciklama100,25,"<br />\n",true);

}



    function baslikKisalt2($baslik){

  $baslik30=substr($baslik,0,50);

  return $baslik30;

}



function aciklamaKisalt2($aciklama){

  $aciklama100=substr($aciklama,0,120);

  return $aciklama100;

}



/** SESSON YAZMA OKUMA **/

echo
'<style type="text/css">
  .ustte{
    margin-top:13%;
    position: absolute;
    z-index: 999;
    font-size: 28px;

  }
  .ortalamesaj{
    color:#000;
    border:2px solid #000;
    max-width: 350px;
    margin: auto;
    margin-top:10px;
    text-align: center;

  }
  .mesaji{
    border:1px solid #000;
  }
</style>
';

/** Varsa Sessiondaki mesajı ekrana basma **/



function mesajvar(){



  if(isset($_SESSION['onaymesaji']) && isset($_SESSION['hatamesaji'])){

    @$mesajne=$_SESSION['onaymesaji'];

    @$hatamesajne=$_SESSION['hatamesaji'];

    echo '<div class="ortalamesaj"><div class="ustte" ><center><img class="img-responsive" id="rocket" src="image/rocket.png" "></center>

    <div class="mesajid alert alert-info" role="alert">'.$_SESSION['onaymesaji'].'</div>

    <div class="mesajid alert alert-danger" role="alert"><h3><b>Dikkat!</b></h3>'.$_SESSION['hatamesaji'].'</div>

    </div></div>';



    unset($_SESSION['hatamesaji']);

    unset($_SESSION['onaymesaji']);



  }elseif(isset($_SESSION['onaymesaji'])){

    @$mesajne=$_SESSION['onaymesaji'];

    echo '<div class="ortalamesaj"><div class="ustte" ><center><img class="responsive" id="rocket" src="image/rocket.png" "></center>

    <div class="mesajid ortalamesaj alert alert-info" role="alert">'.$mesajne.'</div></div></div>';



    unset($_SESSION['onaymesaji']);



  }elseif(isset($_SESSION['hatamesaji'])){

    @$mesajne=$_SESSION['hatamesaji'] . "<br/>";

    echo '<div class="ortalamesaj"><div class="ustte" ><center><img class="responsive" id="rocket" src="image/rocket.png" "></center>

    <div class="mesajid ortalamesaj alert alert-danger" role="alert"><h3><b>Dikkat!</b></h3>'.$mesajne.'</div></div></div>';



    unset($_SESSION['hatamesaji']);

  }



  echo "

    <script>

    //bilgi mesajı

    setTimeout(

      function() 

      {

      $('.mesajid').slideUp(810);

    }, 4800);



    //roket resmi

    setTimeout(

      function() 

      {

      $('#rocket').slideUp(810);

    }, 4800);

    </script>

  ";



  //Gelinen sayfaya geri dön

  /*$gelinen_url = htmlspecialchars($_SERVER['HTTP_REFERER']);  // hangi sayfadan gelindigi degerini verir.

  echo '<meta http-equiv="refresh" content="5;url='.$gelinen_url.'"> ';*/

}



/** Session Oluşturma **/



function sessioncreate($mesaj,$tur){



  if($tur == 1){



    @$_SESSION['onaymesaji']=$_SESSION['onaymesaji']."<li style='text-align:left; margin:7px;'> $mesaj </li>";



  }elseif($tur == 0){



    @$_SESSION['hatamesaji']=$_SESSION['hatamesaji']."<li style='text-align:left; margin:7px;'> $mesaj </li>";



  }

/*

  $gelinen_url = htmlspecialchars($_SERVER['HTTP_REFERER']);  // hangi sayfadan gelindigi degerini verir.

  echo '<meta http-equiv="refresh" content="0;url='.$gelinen_url.'"> ';*/

}



