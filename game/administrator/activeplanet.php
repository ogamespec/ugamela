<?php //activeplanet.php :: DxPpLmOs

define('INSIDE', true);
$ugamela_root_path = '../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);
if(!check_user()){ header("Location: login.php"); }
if($user['authlevel']!="5"&&$user['authlevel']!="1"){ header("Location: ../login.php");}
$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
includeLang('overview');
$parse = $lang;
$parse['dpath'] = $dpath;
$parse['mf'] = $mf;
$parse['version'] = @file_get_contents('http://ugamela.sourceforge.net/lastversion.php?v='.VERSION);
if($parse['version']!=VERSION){
$parse['VERSION'] = colorRed(VERSION);
}else{
$parse['VERSION'] = colorGreen(VERSION);
}
$query = doquery("SELECT * FROM {{table}} WHERE last_update>='".(time()-15*60)."' ORDER BY id ASC",'planets'); 
$i=0;
while($u = mysql_fetch_array($query)){
	$parse['online_list'] .= 
                "<tr><td class=b><center><b>".$u[1]."</center></td></b>".
	"<td class=b><center><b>".$u[3].":".$u[4].":".$u[5]."</center></b></td>".
	"<td class=m><center><b>".pretty_number($u['18']/1000)."</center></b></td>".
	"<td class=b><center><b>".pretty_time(time()-$u['6'])."</center></b></td></tr>";
	$i++;
}
$parse['online_list'] .= "<tr><th class=b colspan=4>there are currently {$i} planet(s) active.</th></tr>";
display(parsetemplate(gettemplate('sgo/activeplanet_body'), $parse),"activeplanet",true);


// Created by DxPpLmOs. All rights reversed (C) 2007
?>