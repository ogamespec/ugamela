<?php //Mboss


define('INSIDE', true);
$ugamela_root_path = '../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);

if(!check_user()){ header("Location: login.php"); }
if($user['authlevel']!="4"&&$user['authlevel']!="5"){ header("Location: ../login.php");}



$lang['PHP_SELF'] = 'options.'.$phpEx;

$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];


if($_POST && $mode == "change"){ //Array ( [db_character] 


	if(isset($_POST["Nick_Usera"])&& $_POST["Nick_Usera"] != ''){
		$game_config['Nick_Usera'] = $_POST['Nick_Usera'];
	}
	

	doquery("DELETE FROM {{table}} WHERE
	`who`='{$game_config['Nick_Usera']}'",'banned');
	doquery("UPDATE {{table}} SET bana=0 WHERE username='{$game_config['Nick_Usera']}'","users");

	
	message('Odbanowales','Informacja','?');
}
else
{
	$parse = $game_config;

	$parse['dpath'] = $dpath;
	$parse['debug'] = ($game_config['debug'] == 1) ? " checked='checked'/":'';

	$page .= parsetemplate(gettemplate('oparator/unbanned'), $parse);

	display($page,'Odbanuj');

}


?>
