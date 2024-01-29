<?
define('INSIDE', true);
$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);

if(!check_user()){ header("Location: login.php"); }

//
// Esta funcion permite cambiar el planeta actual.
//
include($ugamela_root_path . 'includes/planet_toggle.'.$phpEx);

$planetrow = doquery("SELECT * FROM {{table}} WHERE id={$user['current_planet']}",'planets',true);
$galaxyrow = doquery("SELECT * FROM {{table}} WHERE id_planet={$planetrow['id']}",'galaxy',true);
$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
check_field_current($planetrow);

includeLang('fleet');
includeLang('tech');

{//info
if ($_POST['kolonizator'] == "1" && $_POST['sondeczka' ]== "1" && $_POST['Gwiazda' ]== "1" && $_POST['Recykler' ]== "1")
{
	$missiontype = array(
		1 => 'Attack',
		3 => 'Transport',
		4 => 'Deploy',
		5 => 'Destroy',
		6 => 'Espionage',
		9 => 'Colonize',
		8 => 'Recycle',
		);
	}elseif ($_POST['kolonizator'] == "1" && $_POST['sondeczka' ]== "1" && $_POST['Gwiazda' ]== "1")
{
	$missiontype = array(
		1 => 'Attack',
		3 => 'Transport',
		4 => 'Deploy',
		5 => 'Destroy',
		6 => 'Espionage',
		9 => 'Colonize',
		);
}elseif ($_POST['kolonizator'] == "1" && $_POST['sondeczka' ]== "1" && $_POST['Recykler' ]== "1")
{
	$missiontype = array(
		1 => 'Attack',
		3 => 'Transport',
		4 => 'Deploy',
		8 => 'Harvest',
		6 => 'Espionage',
		9 => 'Colonize',
		);
}elseif ($_POST['kolonizator'] == "1" && $_POST['sondeczka' ]== "1" && $_POST['Recykler' ]== "1")
{
	$missiontype = array(
		1 => 'Attack',
		3 => 'Transport',
		4 => 'Deploy',
		8 => 'Harvest',
		6 => 'Espionage',
		9 => 'Colonize',
		);
}elseif ($_POST['kolonizator'] == "1" && $_POST['sondeczka' ]== "1")
{
	$missiontype = array(
		1 => 'Attack',
		3 => 'Transport',
		4 => 'Deploy',
		9 => 'Colonize',
		6 => 'Espionage',
		);
}elseif ($_POST['kolonizator'] == "1" && $_POST['Recykler' ]== "1")
{
	$missiontype = array(
		1 => 'Attack',
		3 => 'Transport',
		4 => 'Deploy',
		9 => 'Colonize',
		8 => 'Harvest',
		);
}elseif ($_POST['kolonizator'] == "1" && $_POST['Gwiazda' ]== "1")
{
	$missiontype = array(
		1 => 'Attack',
		3 => 'Transport',
		4 => 'Deploy',
		9 => 'Colonize',
		5 => 'Destroy',
		);
}elseif ($_POST['sondeczka'] == "1" && $_POST['Recykler' ]== "1")
{
	$missiontype = array(
		1 => 'Attack',
		3 => 'Transport',
		4 => 'Deploy',
		8 => 'Harvest',
		6 => 'Espionage',
		);
}elseif ($_POST['sondeczka'] == "1" && $_POST['Gwiazda' ]== "1")
{
	$missiontype = array(
		1 => 'Attack',
		3 => 'Transport',
		4 => 'Deploy',
		5 => 'Destroy',
		6 => 'Espionage',
		);
}elseif ($_POST['Recykler'] == "1" && $_POST['Gwiazda' ]== "1")
{
	$missiontype = array(
		1 => 'Attack',
		3 => 'Transport',
		4 => 'Deploy',
		8 => 'Harvest',
		5 => 'Destroy',
		);
}elseif ($_POST['sondeczka'] == "1")
{
	$missiontype = array(
		1 => 'Attack',
		3 => 'Transport',
		4 => 'Deploy',
		6 => 'Espionage',
		);
}elseif ($_POST['Recykler'] == "1")
{
	$missiontype = array(
		1 => 'Attack',
		3 => 'Transport',
		4 => 'Deploy',
		8 => 'Harvest',
		);
}elseif ($_POST['Gwiazda'] == "1")
{
	$missiontype = array(
		1 => 'Attack',
		3 => 'Transport',
		4 => 'Deploy',
		5 => 'Destroy',
		);
}elseif ($_POST['kolonizator'] == "1")
{
	$missiontype = array(
		1 => 'Attack',
		3 => 'Transport',
		4 => 'Deploy',
		9 => 'Colonize',
		);
}		
else
{
	$missiontype = array(
		1 => 'Attack',
		3 => 'Transport',
		4 => 'Deploy',
		);
}
	$speed = array(
		10 => 100,
		9 => 90,
		8 => 80,
		7 => 70,
		6 => 60,
		5 => 50,
		4 => 40,
		3 => 30,
		2 => 20,
		1 => 10,
		);
}
$g = $_POST['g'];
$s = $_POST['s'];
$p = $_POST['p'];
$t = $_POST['t'];
$galaxy = $_POST['galaxyend'];
$system = $_POST['systemend'];
$planet = $_POST['planetend'];
$t = $_POST['t'];



	
	if(!$g){$g = $planetrow['galaxy'];}
	if(!$s){$s = $planetrow['system'];}
	if(!$p){$p = $planetrow['planet'];}
	if(!$t){$t = $planetrow['planet_type'];}
$page ='	<table>
<form action="floten3.php" method="post">
		  <tr height="20">
			<th>Mission</th>
			<th></th>
			<th> <select name="mission" onChange="shortInfo()" onKeyUp="shortInfo()">';


/*function distance() {
	var thisGalaxy;
	var thisSystem;
	var thisPlanet;

	var targetGalaxy;
	var targetSystem;
	var targetPlanet;

	var dist;

	thisGalaxy = document.getElementsByName("thisgalaxy")[0].value;
	thisSystem = document.getElementsByName("thissystem")[0].value;
	thisPlanet = document.getElementsByName("thisplanet")[0].value;

	targetGalaxy = document.getElementsByName("galaxy")[0].value;
	targetSystem = document.getElementsByName("system")[0].value;
	targetPlanet = document.getElementsByName("planet")[0].value;

	dist = 0;
	if ((targetGalaxy - thisGalaxy) != 0) {
		dist = Math.abs(targetGalaxy - thisGalaxy) * 20000;
	} else if ((targetSystem - thisSystem) != 0) {
		dist = Math.abs(targetSystem - thisSystem) * 5 * 19 + 2700;
	} else if ((targetPlanet - thisPlanet) != 0) {
		dist = Math.abs(targetPlanet - thisPlanet) * 5 + 1000;
	} else {
		dist = 5;
	}

	return(dist);
}*/

	
			foreach($missiontype as $a => $b){
				$page .= "<option value=\"$a\">$b</option>";
			}
$flota = unserialize(base64_decode($_POST["flota"]));
$consumption = 0;
if (($_POST['thisgalaxy'] - $_POST['galaxy']) != 0){
	$dista = abs($_POST['thisgalaxy'] - $_POST['galaxy']) * 20000;
}
elseif (($_POST['thissystem'] - $_POST['system']) != 0){
	$dista = abs($_POST['thissystem'] - $_POST['system']) * 95 + 2700;
}	
elseif (($_POST['thisplanet'] - $_POST['planet']) != 0){
	$dista = abs($_POST['thisplanet'] - $_POST['planet']) * 5 + 1000;
} else {
	$dista = 5;
}
$fleet['fly_time'] = round(35000 / $_POST['speed'] * sqrt($dista * 10 / $_POST['speedallsmin'] )) / ($game_config['fleet_speed']/2500);
foreach($flota as $a =>$b){
	$shipSpeed = $pricelist[$a]["speed"];
	$spd = 35000 / ($fleet['fly_time'] * ($game_config['fleet_speed']/2500) - 10) * sqrt($dista * 10 / $shipSpeed);
	$basicConsumption = $pricelist[$a]["consumption"] * $b ;
	$spidq = (($spd/10) + 1) * (($spd/10) + 1);
	$consumption = $consumption + $basicConsumption * $dista / 35000 * $spidq;
//	echo "dista: ".$dista." spd: ".$spd." spidq: ".$spidq." consumption: ".$basicConsumption." sumcons: ".$consumption."\n";
}
$consumption = round($consumption) + 1;

$page.='			 <table width="519" border="0" cellpadding="0" cellspacing="1">
		  
		  </th>
		  <tr height="20">
			<td colspan="3" class="c">Resources</td>
		  </tr>
		   <tr height="20">
		  <th>Metal</th>
		  <th><a href="javascript:maxResource(\'1\');">max</a></th>
		  <th width="50%"><input name="resource1" type="text" alt="Metal '.floor($planetrow["metal"]).'" size="21" onChange="calculateTransportCapacity();" /></th>

		 </tr>
		   <tr height="20">
		  <th>Crystal</th>
		  <th><a href="javascript:maxResource(\'2\');">max</a></th>
		  <th width="50%"><input name="resource2" type="text" alt="Cristal '.floor($planetrow["crystal"]).'" size="21" onChange="calculateTransportCapacity();" /></th>
		 </tr>
		   <tr height="20">
		  <th>Deuterium</th>

		  <th><a href="javascript:maxResource(\'3\');">max</a></th>
		  <th width="50%"><input name="resource3" type="text" alt="Deuterio '.floor($planetrow["deuterium"]).'" size="21" onChange="calculateTransportCapacity();" /></th>
		 </tr>
		   <tr height="20">
	  <th>Remaining Resources</th>
		  <th colspan="2"><div id="remainingresources">-</div></th>
		 </tr>      
		 <tr height="20">
	  <th colspan="2"><a href="javascript:noResources()">No Resources</a></th>
	  <th><a href="javascript:maxResources()">All Resources</a></th>
		 </tr>
		  <tr height="20" >
		  <input name="thisresource1" type="hidden" value="'.$planetrow["metal"].'" />
		  <input name="thisresource2" type="hidden" value="'.$planetrow["crystal"].'" />
		  <input name="thisresource3" type="hidden" value="'.$planetrow["deuterium"].'" />
		  <input name="consumption_php" type="hidden" value="'.$consumption.'" />

		  <input name="thisgalaxy" type="hidden" value="'.$_POST["thisgalaxy"].'" />
		  <input name="thissystem" type="hidden" value="'.$_POST["thissystem"].'" />
		  <input name="thisplanet" type="hidden" value="'.$_POST["thisplanet"].'" />
		  <input name="galaxy" type="hidden" value="'.$_POST["galaxy"].'" />
		  <input name="system" type="hidden" value="'.$_POST["system"].'" />
		  <input name="planet" type="hidden" value="'.$_POST["planet"].'" />
		   <input name="speedfactor" type="hidden" value="'.($game_config['fleet_speed']/2500).'" />
		  <input name="thisplanettype" type="hidden" value="'.$_POST["thisplanettype"].'" />
		  
		  <input name="planettype" type="hidden" value="'.$_POST["planettype"].'" />
		  
		<input type="hidden" name="speedallsmin" size="10" value="'.$_POST["speedallsmin"].'"/>
	<input name="pquery" type="hidden" value="'.$pquery.'" />
	<input name="fleetarray" type="hidden" value="'.$fleet['fleetarray'].'" />
	<input name="fleetlist" type="hidden" value="'.$fleet['fleetlist'].'" />
			<th colspan="2"><input type="submit" value="Devam" /></th>

		  </tr>


		  </table>';

	foreach($reslist['fleet'] as $n => $i){


		if($planetrow[$resource[$i]] > 0){
$predkosc[$i] =	$pricelist[$i]['speed']	;
if ($_POST["ship$i"] > "0")
{		
	$page .= '

		    
			<input type="hidden" name="maxship'.$i.'" value="'.$planetrow[$resource[$i]].'"/>
			<input type="hidden" name="consumption'.$i.'" value="'.$pricelist[$i]['consumption'].'"/>
			<input type="hidden" name="speed'.$i.'" value="'.$pricelist[$i]['speed'].'" />
			<input type="hidden" name="capacity'.$i.'" value="'.$pricelist[$i]['capacity'].'" />
			<input type="hidden" name="ship'.$i.'" size="10" value="'.$_POST["ship$i"].'""/>';

			if ("ship$i" == "ship208" && $_POST["ship$i"] > "0")
			{
			$kolon = "1";
			}
			$page .='
			
			</tr>';
			$aaaaaaa = $pricelist[$i]['consumption'];
			$have_ships = true;
			}
		}

	}
 function rwAbs($liczba) {
      if ($liczba < 0)
            $liczba = -$liczba;
	        return $liczba;
		  }
$dist = "0";
if (($_POST['galaxy'] - $_POST['thisgalaxy']) != 0)
{
	$dist = rwAbs($_POST['galaxy'] - $_POST['thisgalaxy']) * 20000;
//	echo"{$_POST['galaxy']}";
}
elseif (($_POST['system'] - $_POST['thissystem']) != 0)
{
	$dist = rwAbs($_POST['system'] - $_POST['thissystem']) * 5 * 19 + 2700;
}
elseif (($_POST['planet'] - $_POST['thisplanet']) != 0)
{
	$dist = rwAbs($_POST['planet'] - $_POST['thisplanet']) * 5 + 1000;
} else {
	$dist ="5";
}

$page .='<input type="hidden" name="flota" size="10" value="'.$_POST["flota"].'"/>';
$page .='<input type="hidden" name="dist" size="10" value="'.$dist.'"/>';
$page .='<input type="hidden" name="speed" size="10" value="'.$_POST['speed'].'"/>';
$page .= '			</form>';
	display($page,'Flotas');
?>
