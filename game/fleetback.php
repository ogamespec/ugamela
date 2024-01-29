<?php //fleetback.php
define('INSIDE', true);
$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);
include('ban.php');
if(!check_user()){ header("Location: login.php"); }
$fq = doquery("SELECT * FROM {{table}} WHERE fleet_id={$_POST['zawracanie']}",'fleets');
$i=0;
while($f = mysql_fetch_array($fq)){
	$i++;
	$fleet['end_pow'] = time()+$f['fleet_start_planet']-$f['fleet_start_planet'];
	if($f['fleet_mess'] == 0){
		$czas_lotu = $f['fleet_end_time']-$f['fleet_start_time'];
		$ile_juz_leci = $czas_lotu - ($f['fleet_start_time'] - time());
		$czas_powrotu = $ile_juz_leci + time();
		doquery("UPDATE {{table}} SET
			`fleet_mission`='4',
			`fleet_start_time`='{$czas_powrotu}',
			`fleet_end_time`='".($czas_powrotu+1)."',
			`fleet_ofiara`='{$user['id']}',
			`fleet_end_galaxy`=fleet_start_galaxy,
			`fleet_end_system`=fleet_start_system,
			`fleet_end_planet`=fleet_start_planet,
			`fleet_mess`='1'
			WHERE `fleet_id` = '{$_POST['zawracanie']}'" ,"fleets");
		message("<font color=\"lime\">Geri Donduruldu","Tamam","fleet.".$phpEx,2);
	} elseif($f['fleet_mess'] == 1){
		message("<font color=\"red\">Geri Donemedi","error","fleet.".$phpEx,2);
	}
}

// Created by DxPpLmOs. All rights reversed (C) 2007
?>
