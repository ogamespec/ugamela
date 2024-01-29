<?php // ---> by Justus 

define('INSIDE', true);
$ugamela_root_path = './../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);
$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
//checkeamos que el usuario este logueado y que tenga los permisos de admin
if(!check_user()){ header("Location: ./../login.php"); }
if($user['authlevel']!="5"){message("Czego tu szukasz ?"," Jestes adminem ?");}


$r = doquery("SELECT * FROM {{table}}","lunas");

$page .= "<center><br><br><br><br><br><table> \n";

$page .= "<tr> \n";
$page .=  "<td><th><b><font color=\"orange\">Nr</b></th></td> \n";
$page .=  "<td><th><b><font color=\"orange\">User id</b></th></td> \n";
$page .=  "<td><th><b><font color=\"orange\">Galaxy</b></th></td> \n";
$page .=  "<td><th><b><font color=\"orange\">Solar System</b></th></td> \n";
$page .=  "<td><th><b><font color=\"orange\">Moon position</b></th></td> \n";
$page .=  "<td><th><b><font color=\"orange\">Type</b></th></td> \n";
$page .=  "<td><th><b><font color=\"orange\">Destroyed</b></th></td> \n";

$page .=  "</tr> \n";
while ($row = mysql_fetch_array($r, MYSQL_BOTH)){
$page .=  "<tr> \n";
$page .=  "<td><th><font color=\"lime\">$row[id]</th></td> \n";
$page .=  "<td><th><font color=\"lime\">$row[id_owner]</th></td> \n";
$page .=  "<td><th><font color=\"lime\">$row[galaxy]</th></td> \n";
$page .=  "<td><th><font color=\"lime\">$row[system]</th></td> \n";
$page .=  "<td><th><font color=\"lime\">$row[lunapos]</th></td> \n";
$page .=  "<td><th><font color=\"lime\">$row[name]</th></td> \n";
$page .=  "<td><th><font color=\"lime\">$row[destruyed]</th></td> \n";



$page .=  "</tr> \n";
}
$page .=  "</table> \n";

$page .= "<table> \n";
$page .= "<form method=\"POST\" action=\"\">";
$page .= "<tr> \n";
$page .= "<td><th>User </th>\n";
$page .= "<td><th>Galaxy </th> \n";
$page .= "<td><th>System </th> \n";
$page .= "<td><th>Planet </th> \n";
$page .= "<td><th>Id </th> \n";
$page .= "</tr> \n";
$page .= "<tr> \n";
$page .= "<td><th><input type=\"text\" name=\"user\"> </th> \n";
$page .= "<td><th><input type=\"text\" name=\"gala\"> </th> \n";
$page .= "<td><th><input type=\"text\" name=\"system\"> </th> \n";
$page .= "<td><th><input type=\"text\" name=\"lunapos\"> </th> \n";
$page .= "<td><th><input type=\"text\" name=\"id\"> </th> \n";
$page .= "<td><th><input type=\"submit\" value=\"Dodaj\"> </th> \n";
echo($_POST['id']);
if ($_POST['id'] >> 0){
doquery("INSERT INTO {{table}} SET 
	        `galaxy`='{$_POST['gala']}',
		`system`='{$_POST['system']}',
		`lunapos`='{$_POST['lunapos']}',
		`id_owner`='{$_POST['user']}',
		`id_luna`='{$_POST['id']}'"
		,"lunas");

doquery("UPDATE {{table}} SET
		`id_luna`='{$_POST['id']}',
		`luna`='0' WHERE
		`galaxy`='{$_POST['gala']}' AND
		`system`='{$_POST['system']}' AND
		`planet`='{$_POST['lunapos']}'"
		,"galaxy");
}


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


<link rel="stylesheet" type="text/css" media="screen" href="http://80.237.203.201/download/use/epicblue/formate.css" />

</style> 




