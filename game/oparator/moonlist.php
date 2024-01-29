<?php // ---> by Justus 

define('INSIDE', true);
$ugamela_root_path = './../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);
$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
//checkeamos que el usuario este logueado y que tenga los permisos de admin
if(!check_user()){ header("Location: ./../login.php"); }
if($user['authlevel']!="4"){message("Your Level Too Low");}


$r = doquery("SELECT * FROM {{table}}","lunas");

$page .= "<center><br><br><br><br><br><table> \n";

$page .= "<tr> \n";
$page .=  "<td><th><b><font color=\"orange\">Num</b></th></td> \n";
$page .=  "<td><th><b><font color=\"orange\">User</b></th></td> \n";
$page .=  "<td><th><b><font color=\"orange\">Galaxy</b></th></td> \n";
$page .=  "<td><th><b><font color=\"orange\">System</b></th></td> \n";
$page .=  "<td><th><b><font color=\"orange\">Ksiê¿yc</b></th></td> \n";
$page .=  "<td><th><b><font color=\"orange\">Nazwa</b></th></td> \n";
$page .=  "<td><th><b><font color=\"orange\">Zniszczony</b></th></td> \n";

$page .=  "</tr> \n";
while ($row = mysql_fetch_array($r, MYSQL_BOTH)){
$page .=  "<tr> \n";
$page .=  "<td><th><font color=\"lime\">$row[id]</th></td> \n";
$page .=  "<td><th><font color=\"lime\">$row[id_luna]</th></td> \n";
$page .=  "<td><th><font color=\"lime\">$row[galaxy]</th></td> \n";
$page .=  "<td><th><font color=\"lime\">$row[system]</th></td> \n";
$page .=  "<td><th><font color=\"lime\">$row[lunapos]</th></td> \n";
$page .=  "<td><th><font color=\"lime\">$row[name]</th></td> \n";
$page .=  "<td><th><font color=\"lime\">$row[destruyed]</th></td> \n";

$page .=  "</tr> \n";
}
$page .=  "</table> \n";

display($page,'Lunalist');

/*
 ALTER TABLE `ugml_lunas` ADD `galaxy` INT( 11 ) NULL ,
 ADD `system` INT( 11 ) NULL 

INSERT INTO `ugml_lunas` ( `id` , `id_luna` , `name` , `image` , `destruyed` , `id_owner` )
VALUES (
NULL , '2', 'Moon', 'mond', '0', '2'
);
UPDATE `ugml_galaxy` SET `id_luna` = '2' WHERE `ugml_galaxy`.`galaxy` =1 AND `ugml_galaxy`.`system` =2 AND `ugml_galaxy`.`planet` =10 AND `ugml_galaxy`.`id_planet` =2 AND `ugml_galaxy`.`metal` =0 AND `ugml_galaxy`.`crystal` =0 AND `ugml_galaxy`.`id_luna` =0 AND `ugml_galaxy`.`luna` =0 LIMIT 1 ;
*/


?>


<link rel="stylesheet" type="text/css" media="screen" href="/formate.css" />

</style> 




