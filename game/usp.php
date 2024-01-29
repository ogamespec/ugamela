<?  //Mboss

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

echo '   <b>MesGame</b>

   <p>Lista Usery ze zgloszonym IP</p>

   <table border="0" cellpadding="2" cellspacing="1">
    <tr height="20">
     <td class="c">Nick1</td>
     <td class="c">Nick2</td>
     <td class="c">Nick3</td>
     <td class="c">Nick4</td>
     <td class="c">Nick5</td>
     <td class="c">Powod</td>
    </tr>';

$count = 0;
$banned = doquery("SELECT * FROM {{table}} ORDER BY `n1` DESC LIMIT $i,50","zglos");

while($b = mysql_fetch_array($banned)){
	echo "<tr height=20>";
	echo "<th>".$b["n1"]."</th>";
	echo "<th>".$b["n2"]."</th>";
	echo "<th>".$b["n3"]."</th>";
	echo "<th>".$b["n4"]."</th>";
	echo "<th>".$b["n5"]."</th>";
	echo "<th>".$b["tekst"]."</th>";
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



?>