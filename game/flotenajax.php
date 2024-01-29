<?php
//status ilosc_flot_w_powietrzu sondy recki miedzyplanetarki
/*
 *
 *  600   OK
 *  601   no planet exists there
 *  602   no moon exists there
 *  603   player is in noob protection
 *  604   player is too strong
 *  605   player is in u-mode 
 *  610   not enough espionage probes, sending x (parameter is the second return value)
 *  611   no espionage probes, nothing send
 *  612   no fleet slots free, nothing send
 *  613   not enough deuterium to send a probe
 *	618   buu
 */
define('INSIDE', true);
$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);
include('ban.php');
if(!check_user()){ header("Location: login.php"); die();}

//
// Esta funcion permite cambiar el planeta actual.
//
include($ugamela_root_path . 'includes/planet_toggle.'.$phpEx);

$planetrow = doquery("SELECT * FROM {{table}} WHERE id={$user['current_planet']}",'planets',true);
$enemyrow =doquery("SELECT * FROM {{table}} WHERE galaxy={$_POST['galaxy']} AND system={$_POST['system']} AND planet={$_POST['planet']}",'planets',true);
$_POST['speed'] = 10;
	foreach($reslist['fleet'] as $n => $i){
		
		if($i > 200&&$i < 300 && $_POST["ship$i"] > "0"){
			if($_POST["ship$i"] > $planetrow[$resource[$i]])
			{
			$page .='za duzo statkow';
			}
			else {
				$fleet['fleetarray'][$i] = $_POST["ship$i"];
				$fleet['fleetlist'] .= $i.",".$_POST["ship$i"].";";
				$fleet['amount'] += $_POST["ship$i"];
				//$planetrow[$resource[$i]] -= $_POST["ship$i"];
				//$pquery .= $resource[$i]."= '".$planetrow[$resource[$i]]."' ,";
				//$aquery .= $fleet['fleetarray'][$i]."^";
				$speedalls[$i] = $_POST["speed$i"];
			}	
			
		}
	}	

$galaxyrow = doquery("SELECT * FROM {{table}} WHERE id_planet={$planetrow['id']}",'galaxy',true);
$mnoznik = $game_config['resource_multiplier'];
$protection = $game_config['noobprotection'];
$protectiontime = $game_config['noobprotectiontime'];
$protectionmulti = $game_config['noobprotectionmulti'];
$galaxy = $_POST['galaxy'];
$system = $_POST['system'];
$planet = $_POST['planet'];
$flota = $fleet['fleetarray'];
$ilosc_flot_w_powietrzu =mysql_fetch_assoc(doquery("SELECT COUNT(fleet_id) as ilosc FROM {{table}} WHERE `fleet_owner`='{$user['id']}'",'fleets'));
$ilosc_flot_w_powietrzu = $ilosc_flot_w_powietrzu["ilosc"];
check_field_current($planetrow);
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
	
if (($user[$resource[108]] + 1) <= $ilosc_flot_w_powietrzu){
	die("612");
}


if (!is_array($flota)) {
	die("618");	
}

if (!(($_POST["mission"] == 6) or ($_POST["mission"] == 8))) {
	die("618");
}

foreach ($flota as $a => $b){
	if ($b > $planetrow[$resource[$a]]){
	die("611");
	}
}
if($protectiontime < 1){
	$protectiontime = 9999999999999999;
}

if($noobja > ($noobty*$protectionmulti) and $enemyrow['id_owner'] != '' and $_POST['mission'] == 1 and $protection == 1 and $noobty < ($protectiontime*1000)){
die("603");
}
	
if($noobja > ($noobty*$protectionmulti) and $enemyrow['id_owner'] != '' and $_POST['mission'] == 5 and $protection == 1 and $noobty < ($protectiontime*1000))
{
die("603");
}
	
if($noobja > ($noobty*$protectionmulti) and $enemyrow['id_owner'] != '' and $_POST['mission'] == 6 and $protection == 1 and $noobty < ($protectiontime*1000))
{
die("603");
}
	
if(($noobja*$protectionmulti) < $noobty and $enemyrow['id_owner'] != '' and $_POST['mission'] == 1 and $protection == 1 and $noobja < ($protectiontime*1000))
{
die("604");
}

if(($noobja*$protectionmulti) < $noobty and $enemyrow['id_owner'] != '' and $_POST['mission'] == 5 and $protection == 1 and $noobja < ($protectiontime*1000))
{
die("604");
}

if(($noobja*$protectionmulti) < $noobty and $enemyrow['id_owner'] != '' and $_POST['mission'] == 6 and $protection == 1 and $noobja < ($protectiontime*1000))
{
die("604");
}

if ($enemyrow['id_owner'] == ''){
die("601");
}
if (($enemyrow["id_owner"] == $planetrow["id_owner"]) and ($_POST["mission"] == 6)) {
die("618");
}
includeLang('fleet');
includeLang('tech');

	if(!$g){$g = $planetrow['galaxy'];}
	if(!$s){$s = $planetrow['system'];}
	if(!$p){$p = $planetrow['planet'];}
	if(!$t){$t = $planetrow['planet_type'];}
	

//Para comprobar de que la flota que se envia, sea la misma del planeta
if($_POST['thisgalaxy'] != $planetrow['galaxy']|$_POST['thissystem'] != $planetrow['system']|$_POST['thisplanet'] != $planetrow['planet']|$_POST['thisplanettype'] != $planetrow['planet_type']){die("618");}
	

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
$_POST['speedallsmin'] = $pricelist["210"]["speed"];
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
	$pojemosc = $pojemosc + $pricelist[$a]["capacity"]*$b;
	$ilosc_floty = $ilosc_floty + $b;
	$fleet_array .= $a.",".$b.";";
	$pquery .= $resource[$a]." = ".$resource[$a]." - ".$b." , ";
}
$consumption = round($consumption) + 1;


if($_POST['resource1'] > $planetrow['metal']|$_POST['resource2'] > $planetrow['crystal']|$_POST['resource3'] > ($planetrow['deuterium'] - $consumption)){
	die("613");
}
if(($_POST['resource1'] + $_POST['resource2'] + $_POST['resource3']) > ($pojemosc - $consumption)){
	die("613");
}
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
	$transport["deuterium"] = 0 + $consumption;
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
	$planetrow = doquery("SELECT * FROM {{table}} WHERE id={$user['current_planet']}",'planets',true);
	echo "600 ".($ilosc_flot_w_powietrzu+1)." {$planetrow['spy_sonde']} {$planetrow['recycler']} {$planetrow['interplanetary_misil']}";
	display();
?>