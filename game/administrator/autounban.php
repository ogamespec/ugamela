<?php //Mboss to ja ^^

if ($_SERVER['REMOTE_ADDR'] != '62.193.231.80')
{
	die("Nie ze ja cie wyganiam ale WYPIERDAJAL LESZCZU!");
} 

define('INSIDE', true);
$ugamela_root_path = '../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);
$lang['PHP_SELF'] = 'options.'.$phpEx;
	doquery("UPDATE {{table}} SET banaday=banaday-1 WHERE banaday!=0","users");
	doquery("UPDATE {{table}} SET bana=0 WHERE banaday<1","users");
	$parse = $game_config;
	$parse['dpath'] = $dpath;
	$parse['debug'] = ($game_config['debug'] == 1) ? " checked='checked'/":'';
?>

