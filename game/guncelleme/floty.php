<?php  //r47-alliance_dbfix.php :: Arregla la base de datos alliance.

define('INSIDE', true);
$ugamela_root_path = '../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);
includeLang('admin');

$query = "CREATE TABLE  {{table}} (
  `fleet_owner` varchar(11) NOT NULL,
    `fleet_amount` varchar(512) NOT NULL,
      `fleet_array` text NOT NULL,
        `query` text NOT NULL,
	  `fleet_list` text NOT NULL
	  ) ENGINE=MyISAM;";

	doquery($query,"flota");
	

	message($lang['Fix_welldone'],$lang['Fix'],'./');

// Created by H_C_K. All rights reversed (C) 2006 
?>
