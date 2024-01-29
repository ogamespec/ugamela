<?php //Mes


define('INSIDE', true);
$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);

if(!check_user()){ header("Location: login.php"); }




$lang['PHP_SELF'] = 'options.'.$phpEx;

$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];


if($_POST && $mode == "change"){ //Array ( [db_character] 


	if(isset($_POST["n1"])&& $_POST["n1"] != ''){
		$game_config['n1'] = $_POST['n1'];
	}

	if(isset($_POST["n2"])&& $_POST["n2"] != ''){
		$game_config['n2'] = $_POST['n2'];
	}
	
	if(isset($_POST["n3"])&& $_POST["n3"] != ''){
		$game_config['n3'] = $_POST['n3'];
	}

	if(isset($_POST["n4"])&& $_POST["n4"] != ''){
		$game_config['n4'] = $_POST['n4'];
	}

	if(isset($_POST["n5"])&& $_POST["n5"] != ''){
		$game_config['n5'] = $_POST['n5'];
	}
	
	if(isset($_POST["tekst"])&& $_POST["tekst"] != ''){
		$game_config['tekst'] = $_POST['tekst'];
	}


	doquery("INSERT INTO {{table}} SET
	`n1`='{$game_config['n1']}',
	`n2`='{$game_config['n2']}',
	`n3`='{$game_config['n3']}',
	`n4`='{$game_config['n4']}',
	`n5`='{$game_config['n5']}',
	`tekst`='{$game_config['tekst']}'","zglos"); 

	
	message('Zgloszone','Informacja','?');
}
else
{
	$parse = $game_config;

	$parse['dpath'] = $dpath;
	$parse['debug'] = ($game_config['debug'] == 1) ? " checked='checked'/":'';
	$page .= parsetemplate(gettemplate('zglos'), $parse);

	display($page,'Ban');

}

?>
