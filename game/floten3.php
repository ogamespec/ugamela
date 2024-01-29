<?
define('INSIDE', true);
$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);
include('ban.php');
if(!check_user()){ header("Location: login.php"); }

//
// Esta funcion permite cambiar el planeta actual.
//
include($ugamela_root_path . 'includes/planet_toggle.'.$phpEx);

$planetrow = doquery("SELECT * FROM {{table}} WHERE id={$user['current_planet']}",'planets',true);
$enemyrow =doquery("SELECT * FROM {{table}} WHERE galaxy={$_POST['galaxy']} AND system={$_POST['system']} AND planet={$_POST['planet']}",'planets',true);
$galaxyrow = doquery("SELECT * FROM {{table}} WHERE id_planet={$planetrow['id']}",'galaxy',true);
$mnoznik = $game_config['resource_multiplier'];
$protection = $game_config['noobprotection'];
$protectiontime = $game_config['noobprotectiontime'];
$protectionmulti = $game_config['noobprotectionmulti'];
$galaxy = $_POST['galaxy'];
$system = $_POST['system'];
$planet = $_POST['planet'];
$flota = unserialize(base64_decode($_POST["flota"]));
foreach ($flota as $a => $b){
	if ($b > $planetrow[$resource[$a]]){
	message("<font color=\"red\"><b>Filoda Hata","error","fleet.".$phpEx,2);
	}
}
if($protectiontime < 1){
	$protectiontime = 9999999999999999;
}
check_field_current($planetrow);
//$flota = doquery("SELECT * FROM {{table}} WHERE fleet_owner={$user['id']}",'flota',true);
$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
$enemyrow =doquery("SELECT * FROM {{table}} WHERE galaxy={$_POST['galaxy']} AND system={$_POST['system']} AND planet={$_POST['planet']}",'planets',true);
$idja = doquery("SELECT * FROM {{table}} WHERE id={$user['id']}",'users',true);
if($enemyrow['id_owner'] == ''){
	$idty = $idja;
} elseif($enemyrow['id_owner'] != ''){
	$idty = doquery("SELECT * FROM {{table}} WHERE id={$enemyrow['id_owner']}",'users',true);
}
$noobja = $idja['points_points'];
$noobty = $idty['points_points'];
	
$ilosc_flot_w_powietrzu =mysql_fetch_assoc(doquery("SELECT COUNT(fleet_id) as ilosc FROM {{table}} WHERE `fleet_owner`='{$user['id']}'",'fleets'));
$ilosc_flot_w_powietrzu = $ilosc_flot_w_powietrzu["ilosc"];
if (($user[$resource[108]] + 1) <= $ilosc_flot_w_powietrzu){
	message("Nie jestes w stanie utrzymac takiej ilosci lecacych flot.","Ilosc flot","fleet.".$phpEx,1);
}

if($noobja > ($noobty*$protectionmulti) and $enemyrow['id_owner'] != '' and $_POST['mission'] == 1 and $protection == 1 and $noobty < ($protectiontime*1000)){
	message("<font color=\"lime\"><b>Bu Oyuncu Sizin icin cok gucsuz!!!","Noobprotection-Attack","fleet.".$phpEx,2);
}
	
if($noobja > ($noobty*$protectionmulti) and $enemyrow['id_owner'] != '' and $_POST['mission'] == 5 and $protection == 1 and $noobty < ($protectiontime*1000))
{
	message("<font color=\"lime\"><b>Bu Player Sizin icin cok gucsuz!!!","Noobprotection-Yok Etme","fleet.".$phpEx,2);
}
	
if($noobja > ($noobty*$protectionmulti) and $enemyrow['id_owner'] != '' and $_POST['mission'] == 6 and $protection == 1 and $noobty < ($protectiontime*1000))
{
	message("<font color=\"lime\"><b>Bu Player Sizin icin cok gucsuz!!!","Noobprotection-Casusluk","fleet.".$phpEx,2);
}
	
if(($noobja*$protectionmulti) < $noobty and $enemyrow['id_owner'] != '' and $_POST['mission'] == 1 and $protection == 1 and $noobja < ($protectiontime*1000))
{
	message("<font color=\"red\"><b>Bu Player Sizin icin cok guclu!!!","Noobprotection-Attack","fleet.".$phpEx,2);
}

if(($noobja*$protectionmulti) < $noobty and $enemyrow['id_owner'] != '' and $_POST['mission'] == 5 and $protection == 1 and $noobja < ($protectiontime*1000))
{
	message("<font color=\"red\"><b>Bu Player Sizin icin cok guclu!!!","Noobprotection-Yok Etme","fleet.".$phpEx,2);
}

if(($noobja*$protectionmulti) < $noobty and $enemyrow['id_owner'] != '' and $_POST['mission'] == 6 and $protection == 1 and $noobja < ($protectiontime*1000))
{
	message("<font color=\"red\"><b>Bu Player Sizin icin cok guclu!!!","Noobprotection-Casuluk","fleet.".$phpEx,10);
}

if ($_POST['resource1'] + $_POST['resource2'] + $_POST['resource3'] < 1 and $_POST['mission'] == 3){
	message("Bu Transport Sadece hammadeler icin.","Transport","fleet.".$phpEx,1);
}

if ($enemyrow['id_owner'] == '' and $_POST['mission'] < 9){
	message("Bu Gezegen Terkedilmis.","error","fleet.".$phpEx,1);
}
		
if ($enemyrow['id_owner'] != '' and $_POST['mission'] == 9){
	message("Bu Gezegen Cok Dolu.","error","fleet.".$phpEx,1);
}
	
if($idty['ally_id'] != $idja['ally_id'] and $_POST['mission'] == 4){
	message("Oyuncular Ayni ittifakta.","B³±d","fleet.".$phpEx,1);
}

if($enemyrow['ally_deposit'] < 1 and $idty != $idja and $_POST['mission'] == 4){
	message("oyuncular ayni ittifakta olmali.","B³±d","fleet.".$phpEx,1);
}
if (($enemyrow["id_owner"] == $planetrow["id_owner"]) and ($_POST["mission"] == 1)) {
	message("Nie mozna atakowac samego siebie.","Error");
}
if (($enemyrow["id_owner"] == $planetrow["id_owner"]) and ($_POST["mission"] == 6)) {
	message("Nie mozna szpiegowaæ samego siebie.","Error");
}
if (($enemyrow["id_owner"] != $planetrow["id_owner"]) and ($_POST["mission"] == 4)) {
	message("Nie stacjonowac floty u kogos.","Error");
}

includeLang('fleet');
includeLang('tech');

{//info

	$missiontype = array(
		1 => 'Attack',
		3 => 'Transport',
		4 => 'Deploy',
		5 => 'Destroy',
		6 => 'Espionage',
		8 => 'Harvest',
		9 => 'Colonize',
		);
		
	$speed = array(
		10 => 100,
		9 => 90,
		8 => 80,
		7 => 70,
		6 => 60,
		5 => 50,
		4 => 40,
		3 => 30,
		2 => 20,
		1 => 10,
		);
}


	if(!$g){$g = $planetrow['galaxy'];}
	if(!$s){$s = $planetrow['system'];}
	if(!$p){$p = $planetrow['planet'];}
	if(!$t){$t = $planetrow['planet_type'];}
	
	/*
	  UUURRRRGGGGGG!!!!
	*/
	//en caso de que no exista el tipo de planeta destino
	if(!$_POST['planettype']){message('Debes elegir el tipo de destino.'."Error");}

	//para las coordenadas del planeta destino
	if(!$_POST['galaxy']){$error++;$errorlist .= 'Debes elegir la galaxia destino.';}
	if(!$_POST['system']){$error++;$errorlist .= 'Debes elegir el sistema destino.';}
	if(!$_POST['planet']){$error++;$errorlist .= 'Debes elegir la posicion destino.';}

	//Para comprobar de que la flota que se envia, sea la misma del planeta
    if($_POST['thisgalaxy'] != $planetrow['galaxy']|$_POST['thissystem'] != $planetrow['system']|$_POST['thisplanet'] != $planetrow['planet']|$_POST['thisplanettype'] != $planetrow['planet_type']){message('...',"WTF!");}
	//Se comprueba de que se tengan los recursos.
	/*
	  Ahora se debe obtener la lista de naves, para agregarlas a la array
	  Solo un megaloop comprobando si esta la nave, y cuantas.
	*/
/*	$pquery = str_replace("'","^",$pquery);
	$query = "`query`='{$pquery}',";
	doquery("INSERT INTO {{table}} SET
	$query
	`fleet_owner`='{$user['id']}',
	`fleet_amount`='{$fleet['amount']}',
	`fleet_array`='{$fleet['fleetlist']}'"
	,'flota');
	
*/
	
if(!isset($flota)){message("Gemi Sec.","Error");}

if (($_POST['thisgalaxy'] - $_POST['galaxy']) != 0){
	$dista = abs($_POST['thisgalaxy'] - $_POST['galaxy']) * 20000;
}
elseif (($_POST['thissystem'] - $_POST['system']) != 0){
	$dista = abs($_POST['thissystem'] - $_POST['system']) * 95 + 2700;
}	
elseif (($_POST['thisplanet'] - $_POST['planet']) != 0){
	$dista = abs($_POST['thisplanet'] - $_POST['planet']) * 5 + 1000;
} else {
	$dista = 5;
}
$fleet['fly_time'] = round(35000 / $_POST['speed'] * sqrt($dista * 10 / $_POST['speedallsmin'] )) / ($game_config['fleet_speed']/2500);
$fleet['start_time'] = round(35000 / $_POST['speed'] * sqrt($dista * 10 / $_POST['speedallsmin'] )) / ($game_config['fleet_speed']/2500) + time();
$fleet['end_time'] = 2*(round(35000 / $_POST['speed'] * sqrt($dista * 10 / $_POST['speedallsmin'] )) / ($game_config['fleet_speed']/2500) ) + time();
$consumption = 0;
$pojemosc = 0;
$ilosc_floty = 0;
$fleet_array="";
$pquery="";
foreach($flota as $a =>$b){
	$shipSpeed = $pricelist[$a]["speed"];
	$spd = 35000 / ($fleet['fly_time'] * ($game_config['fleet_speed']/2500) - 10) * sqrt($dista * 10 / $shipSpeed);
	$basicConsumption = $pricelist[$a]["consumption"] * $b ;
	$spidq = (($spd/10) + 1) * (($spd/10) + 1);
	$consumption = $consumption + $basicConsumption * $dista / 35000 * $spidq;
//	echo "dista: ".$dista." spd: ".$spd." spidq: ".$spidq." consumption: ".$basicConsumption." sumcons: ".$consumption."\n";
	$pojemosc = $pojemosc + $pricelist[$a]["capacity"]*$b;
	$ilosc_floty = $ilosc_floty + $b;
	$fleet_array .= $a.",".$b.";";
	$pquery .= $resource[$a]." = ".$resource[$a]." - ".$b." , ";
}
$consumption = round($consumption) + 1;

//echo $consumption."\n";
//die();

if($_POST['resource1'] > $planetrow['metal']|$_POST['resource2'] > $planetrow['crystal']|$_POST['resource3'] > ($planetrow['deuterium'] - $consumption)){
	message("Bu Gezegende Yeterli Hammadde yok.","Error");
}
if(($_POST['resource1'] + $_POST['resource2'] + $_POST['resource3']) > ($pojemosc - $consumption)){
	message("Yeterli Gemi Yok.:".(($_POST['resource1'] + $_POST['resource2'] + $_POST['resource3']) - ($pojemosc - $consumption)),"Error");
}
//$fleetlist contiene la lista de flotas, Esta se colocara en una row
//dentro de la sql
doquery("INSERT INTO {{table}} SET
	`fleet_owner`='{$user['id']}',
	`fleet_mission`='{$_POST['mission']}',
	`fleet_amount`='{$ilosc_floty}',
	`fleet_array`='{$fleet_array}',
	`fleet_start_time`= '{$fleet['start_time']}',
	`fleet_start_galaxy`='{$_POST['thisgalaxy']}',
	`fleet_start_system`='{$_POST['thissystem']}',
	`fleet_start_planet`='{$_POST['thisplanet']}',
	`fleet_start_type`='{$_POST['planettype']}',
	`fleet_end_time`='{$fleet['end_time']}',
	`fleet_end_galaxy`='{$_POST['galaxy']}',
	`fleet_end_system`='{$_POST['system']}',
	`fleet_end_planet`='{$_POST['planet']}',
	`fleet_end_type`='{$_POST['thisplanettype']}',
	`fleet_resource_metal` = '{$_POST['resource1']}',
	`fleet_resource_crystal` = '{$_POST['resource2']}',
	`fleet_resource_deuterium` = '{$_POST['resource3']}',
	`fleet_ofiara`='{$enemyrow['id_owner']}'",'fleets');

	if ($_POST['resource1'] < 1){
		$transport["metal"] = 0;
	} else {
		$transport["metal"] = $_POST['resource1'];
	}
	if ($_POST['resource2'] < 1){
		$transport["crystal"] = 0;
	} else {
		$transport["crystal"] = $_POST['resource2'];
	}
	if ($_POST['resource3'] < 1){
		$transport["deuterium"] = 0 + $consumption;
	} else {
		$transport["deuterium"] = $_POST['resource3'] + $consumption;
	}
	$planetrow["metal"] = $planetrow["metal"] - $transport["metal"];
	$planetrow["crystal"] = $planetrow["crystal"] - $transport["crystal"];
	$planetrow["deuterium"] = $planetrow["deuterium"] - $transport["deuterium"];
	$query = "UPDATE {{table}} SET
	metal=metal - '{$transport["metal"]}',
	crystal=crystal - '{$transport["crystal"]}',
	deuterium=deuterium - '{$transport["deuterium"]}',
	$pquery
	id_owner='{$planetrow['id_owner']}'
	WHERE id={$planetrow['id']}";
	doquery($query,"planets");

	//ahora se deven quitar las naves correspondientes
	//o mejor dicho. actualizar el row del planet

	//$missiontype corresponde al tipo de accion a tomar.


	$page = '<table border="0" cellpadding="0" cellspacing="1" width="519"><br>';
	$page .= '<tr height="20"><td class="c" colspan="2">';
	$page .= '<span class="success">Details:</span>';
	$page .= '</td></tr>';
	$misja = $missiontype[$_POST['mission']]  ;
	$page .= "<tr height=20><th>Mission</th><th>{$misja}</th></tr>";
	$page .= "<tr height=20><th>Distance</th><th>{$dista}</th></tr>";
	$page .= "<tr height=20><th>Speed</th><th>".$_POST['speedallsmin']."</th></tr>";
	$page .= "<tr height=20><th>Deuterium Consumption</th><th>{$consumption}</th></tr>";
	$page .= "<tr height=20><th>Start</th><th>{$_POST['thisgalaxy']}:{$_POST['thissystem']}:{$_POST['thisplanet']}</th></tr>";
	$page .= "<tr height=20><th>Target.</th><th>{$_POST['galaxy']}:{$_POST['system']}:{$_POST['planet']}</th></tr>";
	$page .= "<tr height=20><th>Begin</th><th>";
	//hora de lleada
	$page .= date("M D d H:i:s",$fleet['start_time']).'</th></tr>';
	$page .= '<tr height="20"><th>End</th><th>';
	//Hora de vuelta
	$page .= date("M D d H:i:s",$fleet['end_time']).'</th></tr>';
	$page .= '<tr height="20"><td class="c" colspan="2">Fleet</td></tr>';
	$page .= '</table>';
	display($page,'Flotas');

?>