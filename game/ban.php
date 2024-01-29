<?php //mboss
if(!check_user()){ header("Location: login.php"); }
if($user['bana']=="1"){ header("Location: maszbana.php");}
?>
