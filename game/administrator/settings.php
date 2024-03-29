<?php //settings.php :: Configuracion del juego


define('INSIDE', true);
$ugamela_root_path = '../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);

if(!check_user()){ header("Location: login.php"); }
if($user['authlevel']!="5"&&$user['authlevel']!="1"){ header("Location: ../login.php");}

//includeLang('options');

$lang['PHP_SELF'] = 'options.'.$phpEx;

$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];


if($_POST && $mode == "change"){ //Array ( [db_character] 
	
	//Activa el modo debug.
	if(isset($_POST["debug"])&& $_POST["debug"] == 'on'){
		$game_config['debug'] = "1";
	}else{
		$game_config['debug'] = "0";
	}

	//Nombre del juego
	if(isset($_POST["game_name"])&& $_POST["game_name"] != ''){
		$game_config['game_name'] = $_POST['game_name'];
	}

	//copyright
	if(isset($_POST["copyright"])&& $_POST["copyright"] != ''){
		$game_config['copyright'] = $_POST['copyright'];
	}
	
	//Campos iniciales
	if(isset($_POST["initial_fields"])&&is_numeric($_POST["initial_fields"])){
		$game_config['initial_fields'] = $_POST["initial_fields"];
	}
	
	//Campos iniciales
	if(isset($_POST["resource_multiplier"])&&is_numeric($_POST["resource_multiplier"])){
		$game_config['resource_multiplier'] = $_POST["resource_multiplier"];
	}
	//Campos iniciales
	if(isset($_POST["metal_basic_income"])&&is_numeric($_POST["metal_basic_income"])){
		$game_config['metal_basic_income'] = $_POST["metal_basic_income"];
	}
	//Campos iniciales
	if(isset($_POST["crystal_basic_income"])&&is_numeric($_POST["crystal_basic_income"])){
		$game_config['crystal_basic_income'] = $_POST["crystal_basic_income"];
	}
	//Campos iniciales
	if(isset($_POST["deuterium_basic_income"])&&is_numeric($_POST["deuterium_basic_income"])){
		$game_config['deuterium_basic_income'] = $_POST["deuterium_basic_income"];
	}
	//Campos iniciales
	if(isset($_POST["energy_basic_income"])&&is_numeric($_POST["energy_basic_income"])){
		$game_config['energy_basic_income'] = $_POST["energy_basic_income"];
	}
	//Campos iniciales
	if(isset($_POST["game_speed"])&&is_numeric($_POST["game_speed"])){
		$game_config['game_speed'] = $_POST["game_speed"];
	}
	//Campos iniciales
	if(isset($_POST["max_galaxy"])&&is_numeric($_POST["max_galaxy"])){
		$game_config['max_galaxy'] = $_POST["max_galaxy"];
	}
	//Campos iniciales
	if(isset($_POST["max_system"])&&is_numeric($_POST["max_system"])){
		$game_config['max_system'] = $_POST["max_system"];
	}
	//Campos iniciales
	if(isset($_POST["allow_investigate_while_lab_is_update"])&&is_numeric($_POST["allow_investigate_while_lab_is_update"])){
		$game_config['allow_invetigate_while_lab_is_update'] = $_POST["allow_invetigate_while_lab_is_update"];
	}
	//Campos iniciales
	if(isset($_POST["fleet_speed"])&&is_numeric($_POST["fleet_speed"])){
		$game_config['fleet_speed'] = $_POST["fleet_speed"];
	}
	//Campos iniciales
	if(isset($_POST["users_amount"])&&is_numeric($_POST["users_amount"])){
		$game_config['users_amount'] = $_POST["users_amount"];
	}
	//Campos iniciales
	if(isset($_POST["max_position"])&&is_numeric($_POST["max_position"])){
		$game_config['max_position'] = $_POST["max_position"];
	}
	
	//configuracion del juego
	doquery("UPDATE {{table}} SET config_value='{$game_config['game_name']}' WHERE config_name='game_name'",config);
	doquery("UPDATE {{table}} SET config_value='{$game_config['copyright']}' WHERE config_name='copyright'",config);
	//opciones de planetas
	doquery("UPDATE {{table}} SET config_value='{$game_config['initial_fields']}' WHERE config_name='initial_fields'",config);
	doquery("UPDATE {{table}} SET config_value='{$game_config['resource_multiplier']}' WHERE config_name='resource_multiplier'",config);
	doquery("UPDATE {{table}} SET config_value='{$game_config['metal_basic_income']}' WHERE config_name='metal_basic_income'",config);
	doquery("UPDATE {{table}} SET config_value='{$game_config['crystal_basic_income']}' WHERE config_name='crystal_basic_income'",config);
	doquery("UPDATE {{table}} SET config_value='{$game_config['deuterium_basic_income']}' WHERE config_name='deuterium_basic_income'",config);
	doquery("UPDATE {{table}} SET config_value='{$game_config['energy_basic_income']}' WHERE config_name='energy_basic_income'",config);
	doquery("UPDATE {{table}} SET config_value='{$game_config['game_speed']}' WHERE config_name='game_speed'",config);
	doquery("UPDATE {{table}} SET config_value='{$game_config['max_galaxy']}' WHERE config_name='max_galaxy'",config);
	doquery("UPDATE {{table}} SET config_value='{$game_config['max_system']}' WHERE config_name='max_system'",config);
	doquery("UPDATE {{table}} SET config_value='{$game_config['allow_invetigate_while_lab_is_update']}' WHERE config_name='allow_invetigate_while_lab_is_update'",config);
	doquery("UPDATE {{table}} SET config_value='{$game_config['fleet_speed']}' WHERE config_name='fleet_speed'",config);
	doquery("UPDATE {{table}} SET config_value='{$game_config['users_amount']}' WHERE config_name='users_amount'",config);
	doquery("UPDATE {{table}} SET config_value='{$game_config['max_position']}' WHERE config_name='max_position'",config);
	//miscelaneos
	doquery("UPDATE {{table}} SET config_value='{$game_config['debug']}' WHERE config_name='debug'",config);
	
	
	message('Configuration has been saved!','Configuration','?');
}
else
{
	$parse = $game_config;

	$parse['dpath'] = $dpath;
	$parse['debug'] = ($game_config['debug'] == 1) ? " checked='checked'/":'';

	$page .= parsetemplate(gettemplate('sgo/options_body'), $parse);

	display($page,'Configuracion');

}

// Created by Perberos. All rights reversed (C) 2006
?>
