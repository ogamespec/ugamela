<?
define('INSIDE', true);
$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);
include('ban.php');


if(!check_user()){ header("Location: login.php"); }


//
// Esta funcion permite cambiar el planeta actual.
//
include($ugamela_root_path . 'includes/planet_toggle.'.$phpEx);

$planetrow = doquery("SELECT * FROM {{table}} WHERE id={$user['current_planet']}",'planets',true);
$galaxyrow = doquery("SELECT * FROM {{table}} WHERE id_planet={$planetrow['id']}",'galaxy',true);
$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
check_field_current($planetrow);
$f = doquery("SELECT * FROM {{table}} WHERE fleet_owner={$user['id']} AND fleet_id={$_POST['order_return']}",'fleets',true);


includeLang('fleet');
includeLang('tech');

message(time()-$f['fleet_start_time']."  \  ".pretty_time(floor($f['fleet_end_time']-time())),"Error","fleet.".$phpEx,4);

?>
