<?php // ----> by Justus

define('INSIDE', true);
$ugamela_root_path = './../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);
$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
//checkeamos que el usuario este logueado y que tenga los permisos de admin
if(!check_user()){ header("Location: ./../login.php"); }
if($user['authlevel']!="5"){message("Puto de mierda","pero vo so loko?");}


$r = doquery("SELECT * FROM {{table}} ORDER BY user_lastip ASC","users");
$page .= "<center><br><br><br><br><br><table> \n";

$page .= "<tr> \n";
$page .=  "<td><th><b><font color=\"orange\">Nr</b></th></td> \n";
$page .=  "<td><th><b><font color=\"orange\">Name</b></th></td> \n";
$page .=  "<td><th><b><font color=\"orange\">E-Mail</b></th></td> \n";
$page .=  "<td><th><b><font color=\"orange\">IP</b></th></td> \n";
$page .=  "<td><th><b><font color=\"orange\">Register Time</b></th></td> \n";
$page .=  "<td><th><b><font color=\"orange\">Online Time</b></th></td> \n";
$page .=  "<td><th><b><font color=\"orange\">Ban</b></th></td> \n";
$page .=  "<td><th><b><font color=\"orange\">Na ile dni?</b></th></td> \n";



$page .=  "</tr> \n";
while ($row = mysql_fetch_row($r)){
$page .=  "<tr> \n";
$page .=  "<td><th><font color=\"lime\">$row[0]</th></td> \n";
$page .=  "<td><th><font color=\"lime\">$row[1]</th></td> \n";
$page .=  "<td><th><font color=\"lime\">$row[3]</th></td> \n";
$page .=  "<td><th><font color=\"lime\">$row[15]</th></td> \n";
$page .=  "<td><th><font color=\"lime\">$row[16]</th></td> \n";
$page .=  "<td><th><font color=\"lime\">$row[17]</th></td> \n";
$page .=  "<td><th><b><font color=\"red\">$row[67]</b></th></td> \n";
$page .=  "<td><th><b><font color=\"red\">$row[68]</b></th></td> \n";

$page .=  "</tr> \n";
}
$page .=  "</table> \n";

display($page,'Userlist');



?>


<link rel="stylesheet" type="text/css" media="screen" href="http://80.237.203.201/download/use/epicblue/formate.css" />

</style> 

