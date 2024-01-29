<?php // logout.php :: Establece el tiempo de expiración de las cookies.

define('INSIDE', true);

$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);

includeLang('logout');

setcookie($game_config['COOKIE_NAME'], "", time()-100000, "/", "", 0);//le da el expire

message($lang['blad'],$lang['uniblad'],"login.".$phpEx);

// Created by Perberos. All rights reversed (C) 2006
?>
