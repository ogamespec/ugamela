<?php  //r47-alliance_dbfix.php :: Arregla la base de datos alliance.

define('INSIDE', true);
$ugamela_root_path = '../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);
includeLang('admin');

$query = "ALTER TABLE {{table}} ADD `fleet_mess` INT( 2 ) NOT NULL DEFAULT '0';";

	doquery($query,"fleet");
	

	message($lang['Fix_welldone'],$lang['Fix'],'./');

// Created by H_C_K. All rights reversed (C) 2007 
?>
