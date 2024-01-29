<?php //Mboss


define('INSIDE', true);
$ugamela_root_path = '../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);

if(!check_user()){ header("Location: login.php"); }
if($user['authlevel']!="5"&&$user['authlevel']!="5"){ header("Location: ../login.php");}



$lang['PHP_SELF'] = 'options.'.$phpEx;

$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];


if($_POST && $mode == "change"){ //Array ( [db_character] 


	if(isset($_POST["Nick_Gracza"])&& $_POST["Nick_Gracza"] != ''){
		$game_config['Nick_Gracza'] = $_POST['Nick_Gracza'];
	}

	if(isset($_POST["Powod_kary"])&& $_POST["Powod_kary"] != ''){
		$game_config['Powod_kary'] = $_POST['Powod_kary'];
	}
	
	if(isset($_POST["Data_nadania"])&& $_POST["Data_nadania"] != ''){
		$game_config['Data_nadania'] = $_POST['Data_nadania'];
	}

	if(isset($_POST["Ban_do"])&& $_POST["Ban_do"] != ''){
		$game_config['Ban_do'] = $_POST['Ban_do'];
	}

	if(isset($_POST["Kto_nadal"])&& $_POST["Kto_nadal"] != ''){
		$game_config['Kto_nadal'] = $_POST['Kto_nadal'];
	}
	
	if(isset($_POST["dni"])&& $_POST["dni"] != ''){
		$game_config['dni'] = $_POST['dni'];
	}

	if(isset($_POST["email"])&& $_POST["email"] != ''){
		$game_config['email'] = $_POST['email'];
	}

	doquery("INSERT INTO {{table}} SET
	`who`='{$game_config['Nick_Gracza']}',
	`theme`='{$game_config['Powod_kary']}',
	`time`='{$game_config['Data_nadania']}',
	`longer`='{$game_config['Ban_do']}',
	`author`='{$game_config['Kto_nadal']}',
	`email`='{$game_config['email']}'",'banned');
	doquery("UPDATE {{table}} SET bana=1 WHERE username='{$game_config['Nick_Gracza']}'","users");
	doquery("UPDATE {{table}} SET banaday=banaday+'{$game_config['dni']}' WHERE username='{$game_config['Nick_Gracza']}'","users");

	
	message('Dales BANA','Informacja','?');
}
else
{
	$parse = $game_config;

	$parse['dpath'] = $dpath;
	$parse['debug'] = ($game_config['debug'] == 1) ? " checked='checked'/":'';

	$page .= parsetemplate(gettemplate('sgo/banned'), $parse);

	display($page,'Ban');

}

?>
