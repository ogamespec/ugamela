<?php
define('INSIDE', true);
$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);
include('ban.php');

if(!check_user()){ header("Location: login.php"); die();}
$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
$raportrow = doquery("SELECT * FROM {{table}} WHERE `rid` = '{$_GET["raport"]}' ","rw",true);
if (($raportrow["id_owner1"] == $user["id"]) or ($raportrow["id_owner2"] == $user["id"])) {
echo "<html><head><link rel=\"stylesheet\" type=\"text/css\" href=\"".$dpath."/formate.css\"><meta http-equiv=\"content-type\" content=\"text/html; charset=iso-8859-2\" /> </head><body><center><table width=\"120%\"><tr><td>".$raportrow["raport"]."</td></tr></table></center></body></html>";
}
?>
