<?php //DxPpLmOs & ShadoV
define('INSIDE', true);
$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);
include('ban.php');
$users = $game_config['users_amount']-1;
$planetdelete = doquery("SELECT * FROM {{table}} WHERE id_owner='{$user['id']}'","planets");
while ($gala = mysql_fetch_row($planetdelete)){
if(!check_user()){ header("Location: login.php");}
if($user['db_deaktjava'] == "0"){header("Location: neusuw.php");}
elseif($user['db_deaktjava'] == "1"){ 
doquery("DELETE FROM {{table}} WHERE id_planet='{$gala['id']}'",'galaxy');
doquery("DELETE FROM {{table}} WHERE id_owner='{$user['id']}'",'galaxy');
doquery("DELETE FROM {{table}} WHERE id_owner='{$user['id']}'",'planets');
doquery("DELETE FROM {{table}} WHERE id='{$user['id']}'",'users');
doquery("UPDATE {{table}} SET
`config_value`='$users'
WHERE `config_name` = 'users_amount'","config");
message("Twoje konto zosta³o skasowane.","Complete","login.".$phpEx,4);}}
display($page,$lang['Options']);
?>