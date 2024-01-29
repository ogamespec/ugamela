<?php //MfA (Message for All) By DxPpLmOs
define('INSIDE', true);
$ugamela_root_path = '../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);
include($ugamela_root_path . 'ban.'.$phpEx);
if(!check_user()){ header("Location: ../login.php"); }
if($user['authlevel'] < 1){ message("<font color=\"red\">Nie masz uprawnieñ do przegl±dania tej strony</font>","Security","../overview.".$phpEx,3);}
$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
if($_POST && $mode == "change"){
if(isset($_POST["tresc"])&& $_POST["tresc"] != ''){
$game_config['tresc'] = $_POST['tresc'];}
if(isset($_POST["temat"])&& $_POST["temat"] != ''){
$game_config['temat'] = $_POST['temat'];}
if($user['authlevel'] == 3)
{$kolor = 'red';
$ranga = 'Administrator';}
elseif($user['authlevel'] == 4)
{$kolor = 'skyblue';
$ranga = 'GameOperator';}
elseif($user['authlevel'] == 5)
{$kolor = 'yellow';
$ranga = 'SuperGameOperator';}
if($game_config['tresc'] !='' and $game_config['temat']){	
$sq = doquery("SELECT `id` FROM {{table}}","users");
		while($u = mysql_fetch_array($sq)){

			doquery("INSERT INTO {{table}} SET

				`message_owner`='{$u['id']}',

				`message_sender`='{$user['id']}' ,

				`message_time`='".time()."',

				`message_type`='0',

				`message_from`='<font color=\"$kolor\">$ranga {$user['username']}</font>',

				`message_subject`='<font color=\"$kolor\">{$game_config['temat']}</font>',

				`message_text`='<font color=\"$kolor\"><b>{$game_config['tresc']}</b></font>'

				","messages");

doquery("UPDATE {{table}} SET new_message=new_message+1 WHERE id='{$u['id']}'",'users');}
message("<font color=\"lime\">Wys³a³e¶ wiadomo¶æ do wszystkich Usery</font>","Complete","../overview.".$phpEx,3);}}
else{$parse = $game_config;
$parse['dpath'] = $dpath;
$parse['debug'] = ($game_config['debug'] == 1) ? " checked='checked'/":'';
$page .= parsetemplate(gettemplate('oparator/messall_body'), $parse);
display($page,'Wy¶lij');}
// Created by DxPpLmOs. All rights reserved (C) 2007
?>