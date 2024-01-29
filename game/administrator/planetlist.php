<?php // ---> by Justus 

define('INSIDE', true);
$ugamela_root_path = './../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);
$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
//checkeamos que el usuario este logueado y que tenga los permisos de admin
if(!check_user()){ header("Location: ./../login.php"); }
if($user['authlevel']!="5"){message("Czego tu szukasz ?"," Jestes adminem ?");}


$r = doquery("SELECT * FROM {{table}}","planets");

$page .= "<center><br><br><br><br><br><table> \n";

$page .= "<tr> \n";
$page .=  "<td><th><b><font color=\"orange\">Nr</b></th></td> \n";
$page .=  "<td><th><b><font color=\"orange\">Planet name</b></th></td> \n";
$page .=  "<td><th><b><font color=\"orange\">Galaxy</b></th></td> \n";
$page .=  "<td><th><b><font color=\"orange\">System</b></th></td> \n";
$page .=  "<td><th><b><font color=\"orange\">Planet</b></th></td> \n";
$page .=  "<td><th><b><font color=\"orange\">Points</b></th></td> \n";

$page .=  "</tr> \n";
while ($row = mysql_fetch_row($r)){
$page .=  "<tr> \n";
$page .=  "<td><th><font color=\"lime\">$row[0]</th></td> \n";
$page .=  "<td><th><font color=\"lime\">$row[1]</th></td> \n";
$page .=  "<td><th><font color=\"lime\">$row[3]</th></td> \n";
$page .=  "<td><th><font color=\"lime\">$row[4]</th></td> \n";
$page .=  "<td><th><font color=\"lime\">$row[5]</th></td> \n";
$page .=  "<td><th><font color=\"lime\">$row[8]</th></td> \n";

$page .=  "</tr> \n";
}
$page .=  "</table> \n";

display($page,'Planetlist');



?>


<link rel="stylesheet" type="text/css" media="screen" href="http://80.237.203.201/download/use/epicblue/formate.css" />

</style> 




