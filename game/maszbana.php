<?  //mboss

define('INSIDE', true);
$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);

if(!check_user()){ header("Location: login.php"); }
if($user['bana']!="1"){ header("Location: overview.php"); }

$dpath = (!$userrow["dpath"]) ? DEFAULT_SKINPATH : $userrow["dpath"];

$i = (is_numeric($from)&&isset($from)) ? $from : 0;

echo_head("Suspensiones en Ugamela");
if($userrow){echo_topnav();}
echo "<center>\n";

echo '   <b>--=={[ <font color=lime>m<font color=red>b<font color=lime>o<font color=red>s<font color=lime>s</font></font></font></font></font> ]}==--</b>

   <p>Cos Przeskrobales</p>

   <table border="0" cellpadding="2" cellspacing="1">
    <tr height="20">
     <td class="c">Nick Usera</td>
     <td class="c">Powód kary</td>
     <td class="c">Data nadania</td>
     <td class="c">Ban do:</td>
     <td class="c">Pozosta³o:</td>
     <td class="c">Kto nada³:</td>
    </tr>';

$count = 0;
$banned = doquery("SELECT * FROM {{table}} WHERE who2='{$user['username']}' LIMIT $i,1","banned");
$t['time'] = time();
$dni = $user['banaday']-$t['time'];
$dnii = $user['banaday']-$t['time'];
$sekund = "sekund(y)";
if($dni < "1"){ $dni="<a href=overview.php>Koniec Bana</a>";}
if($dnii < "1"){ $sekund="";}

while($b = mysql_fetch_array($banned)){
	echo "<tr height=20>";
	echo "<th>".$b["who"]."</th>";
	echo "<th>".$b["theme"]."</th>";
	echo "<th>".gmdate("d.m.Y G:i:s",$b['time'])."</th>";
	echo "<th>".gmdate("d.m.Y G:i:s",$b['longer'])."</th>";
	echo "<th>{$dni} {$sekund}</b></th>";
	echo '<th><a href="mailto:'.$b["email"].'?subject=banned:'.$b["who"].'">'.$b["author"]."</a></th>";
	echo "</tr>";
	$count++;
}



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
$t['time'] = time();
doquery("UPDATE {{table}} SET	bana=0, banaday=0 WHERE banaday<'{$t['time']}'","users");
doquery("UPDATE {{table}} SET	who2='Koniec Bana' WHERE longer<'{$t['time']}'","banned");

?>