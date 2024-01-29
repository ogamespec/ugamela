<?php //Mboss


define('INSIDE', true);
$ugamela_root_path = '../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);
if(!check_user()){ header("Location: login.php"); }
if($user['authlevel']!="5"&&$user['authlevel']!="1"){ header("Location: ../login.php");}





$lang['PHP_SELF'] = 'options.'.$phpEx;



if($_POST && $mode == "change"){ //Array ( [db_character] 

	//configuracion del juego 
	doquery("UPDATE {{table}} SET banaday=banaday-1 WHERE banaday!=0","users");
	doquery("UPDATE {{table}} SET bana=0 WHERE banaday<1","users");
	message('Zrobione','Informacja','?');
	
}
else
{
	$parse = $game_config;

	$parse['dpath'] = $dpath;
	$parse['debug'] = ($game_config['debug'] == 1) ? " checked='checked'/":'';

	$page .= parsetemplate(gettemplate('sgo/banadni'), $parse);

	display($page,'Odbanuj');

}


?>

