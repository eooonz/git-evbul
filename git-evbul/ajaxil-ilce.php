<?php 

require('baglan.php');

    if($_POST){
      	$id=$_POST["id"];
      	$bul=$db->prepare("select * from muh_ilceler where il_id=?");
      	$bul->bind_param("i",$id);
      	$bul->execute();
      	$result_ilce=$bul->get_result();

      	while ($goster=$result_ilce->fetch_object()) {
      		echo '<option value="'.$goster->id.'">'.$goster->baslik.'</option>';
      	}
    }
?>  