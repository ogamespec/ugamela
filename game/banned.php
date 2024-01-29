<?  //mboss

define('INSIDE', true);
$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);

if(!check_user()){ header("Location: login.php"); }


$dpath = (!$userrow["dpath"]) ? DEFAULT_SKINPATH : $userrow["dpath"];

$i = (is_numeric($from)&&isset($from)) ? $from : 0;

echo_head("Suspensiones en Ugamela");
if($userrow){echo_topnav();}
echo "<center>\n";

echo '   <b>--=={[ Banned List ]}==--</b>

   <p>This is dedicated to the losers of GameO</p>

   <table border="0" cellpadding="2" cellspacing="1">
    <tr height="20">
     <td class="c">User</td>
     <td class="c">?</td>
     <td class="c">Ban Start</td>
     <td class="c">Ban End</td>
     <td class="c">Banned by:</td>
    </tr>';

$count = 0;
$banned = doquery("SELECT * FROM {{table}} ORDER BY `id` DESC LIMIT $i,50","banned");
while($b = mysql_fetch_array($banned)){
	echo "<tr height=20>";
	echo "<th>".$b["who"]."</th>";
	echo "<th>".$b["theme"]."</th>";
	echo "<th>".gmdate("d.m.Y G:i:s",$b['time'])."</th>";
	echo "<th>".gmdate("d.m.Y G:i:s",$b['longer'])."</th>";
	echo '<th><a href="mailto:'.$b["email"].'?subject=banned:'.$b["who"].'">'.$b["author"]."</a></th>";
	echo "</tr>";
	$count++;
}

if($count == 0){echo "<tr height=20><th colspan=\"5\">No users on this page.</th></tr>";}
$ia=$i-50;
$i+=50;
echo "<tr>";
echo '<th colspan="5">';
if($i >50){echo "<a href=\"?from=$ia\">&lt;&lt; Last 50</a>&nbsp;&nbsp;&nbsp;&nbsp;";}
echo "<a href=\"?from=$i\">Next 50 >></a>";
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