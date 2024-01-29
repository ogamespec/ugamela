<?php // ----> by DxPpLmOs

define('INSIDE', true);
$ugamela_root_path = './../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);
$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
//checkeamos que el usuario este logueado y que tenga los permisos de admin
if(!check_user()){ header("Location: ./../login.php"); }
if($user['authlevel']!="5"){message("Puto de mierda","pero vo so loko?");}
includeLang('fleet');
includeLang('tech');

{//info

	$typ = array(
	0 => 'Online',
	1 => '<font color="red">Offline</font>',	
	2 => '<font color="yellow">Sojusz</font>',
 );
		}
$r = doquery("SELECT * FROM {{table}} ORDER BY message_time DESC","messages");
$page .= "<center><br><br><br><br><br><table> \n";

$page .= "<tr> \n";
$page .=  "<td><th><b><font color=\"orange\">Nr</b></th></td> \n";
$page .=  "<td><th><b><font color=\"orange\">Online/Offline</b></th></td> \n";
$page .=  "<td><th><b><font color=\"orange\">User</b></th></td> \n";
$page .=  "<td><th><b><font color=\"orange\">Topic</b></th></td> \n";
$page .=  "<td><th><b><font color=\"orange\">Text</b></th></td> \n";

$page .=  "</tr> \n";
while ($row = mysql_fetch_row($r)){
$page .=  "<tr> \n";
$page .=  "<td><th><font color=\"lime\">$row[0]</th></td> \n";
$page .=  "<td><th><font color=\"lime\">{$typ[$row['4']]}</th></td> \n";
$page .=  "<td><th><font color=\"lime\">$row[5]</th></td> \n";
$page .=  "<td><th><font color=\"lime\">$row[6]</th></td> \n";
$page .=  "<td><th><font color=\"lime\">$row[7]</th></td> \n";

$page .=  "</tr> \n";
}
$page .=  "</table> \n";

display($page,'Messageist');



if($count == 0){echo "<tr height=20><th colspan=\"5\">Nie ma tu zadnych informacji.</th></tr>";}


$ia=$i-50;
$i+=50;
echo "<tr>";
echo '<th colspan="5">';
if($i >50){echo "<a href=\"?from=$ia\">&lt;&lt; Poprzednie 50</a>&nbsp;&nbsp;&nbsp;&nbsp;";}
echo "<a href=\"?from=$i\">Nastepne 50 >></a>";
echo "</th>";
echo "</tr>";

echo "</table></center></body></html>";



if($userrow['authlevel'] == 3){
	$tiempo = microtime();
	$tiempo = explode(" ",$tiempo);
	$tiempo = $tiempo[1] + $tiempo[0];
	$tiempoFin = $tiempo;
	$tiempoReal = ($tiempoFin - $tiempoInicio);
	echo $depurerwrote001.$tiempoReal.$depurerwrote002.$numqueries.$depurerwrote003;
}



?>



<link rel="stylesheet" type="text/css" media="screen" href="http://80.237.203.201/download/use/epicblue/formate.css" />

</style> 



