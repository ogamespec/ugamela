<?php  //Zawracanie by DxPpLmOs
define('INSIDE', true);
$ugamela_root_path = '../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);
includeLang('admin');

$query = "ALTER TABLE `ugml_fleets` ADD (
  `fleet_pow` int(11) NOT NULL default '0',
  `fleet_start_hour` int(11) NOT NULL default '0',
  `fleet_end_pow` int(11) NOT NULL default '0',
  `fleet_start_pow` int(11) NOT NULL default '0');";

	doquery($query,"flota");
	

	message($lang['Fix_welldone'],$lang['Fix'],'./');

// Created by DxPpLmOs. All rights reversed (C) 2007
?>
