<?php  //Galaktyka by DxPpLmOs
define('INSIDE', true);
$ugamela_root_path = '../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);
includeLang('admin');

$query = "ALTER TABLE `ugml_lunas` ADD (
  `max_temp` int(11) NOT NULL default '87',
  `min_temp` int(11) NOT NULL default '24',
  `diameter` int(11) NOT NULL default '8651');";

	doquery($query,"flota");
	

	message($lang['Fix_welldone'],$lang['Fix'],'./');

// Created by DxPpLmOs. All rights reversed (C) 2007
?>
