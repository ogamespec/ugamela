<?

/*
  Perberos escribio
    por ahora solo se envian flotas fantasmas. (es decir, la cantidad que
	hay en el planeta, no varia. Y cuando llegan al otro lado, Desaparecen)
	
	Corregi un pequeno bug en los tiempos que se muestran en la lista de flotas.
	
	Al enviar las flotas, solo tardan 60 segundos. pero creo que le erre en
	el sistema...
	Al parecer, fleet_start_time es para el primer arrivo... Y yo tome el fleet_end_time
	como el arrivo...
	
	El seguro contra acciones o planetas que no existen, no esta. Por ahora.
	
	PD: las flotas se agregan desde sql. en la tabla planets.
	PD2: las sondas se pueden enviar xD xD xD

*/

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

	$missiontype = array(
		1 => 'Attack',
		3 => 'Transport',
		4 => 'Harvest',
		5 => 'Destroy',
		6 => 'Espionage',
		8 => 'Harvest',
		9 => 'Colonize',
		);
		
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
	$g = $_POST['galaxy'];
	$s = $_POST['system'];
	$p = $_POST['planet'];
	$t = $_POST['planet_type'];
	if(!$g){$g = $planetrow['galaxy'];}
	if(!$s){$s = $planetrow['system'];}
	if(!$p){$p = $planetrow['planet'];}
	if(!$t){$t = $planetrow['planet_type'];}
//	$fleet='';

	foreach($reslist['fleet'] as $n => $i){
		
		if($i > 200&&$i < 300 && $_POST["ship$i"] > "0"){
			if($_POST["ship$i"] > $planetrow[$resource[$i]])
			{
			$page .='za duzo statkow';
			}
			else {
				$fleet['fleetarray'][$i] = $_POST["ship$i"];
				$fleet['fleetlist'] .= $i.",".$_POST["ship$i"].";";
				$fleet['amount'] += $_POST["ship$i"];
				//$planetrow[$resource[$i]] -= $_POST["ship$i"];
				//$pquery .= $resource[$i]."= '".$planetrow[$resource[$i]]."' ,";
				//$aquery .= $fleet['fleetarray'][$i]."^";
				$speedalls[$i] = $_POST["speed$i"];
			}	
			
		}
	}	

if(!$fleet['fleetlist']){
		message( "Filo Yok.","Error","fleet.".$phpEx,1);
		}
	/*

	CREATE TABLE `ugml_flota` (
	`fleet_owner` VARCHAR( 11 ) NOT NULL ,
	`fleet_amount` VARCHAR( 11 ) NOT NULL ,
	`fleet_array` VARCHAR( 11 ) NOT NULL ,
	`query` VARCHAR( 99 ) NOT NULL
	) ENGINE = MYISAM ;
	*/

	
	//ahora se deven quitar las naves correspondientes
	//o mejor dicho. actualizar el row del planet
/*$page = '<script language="JavaScript" src="scripts/flotten.js"></script>
<script language="JavaScript" src="scripts/ocnt.js"></script>';
*/
$page .='<form action="floten2.php" method="post">';
$kolon = "0";
$sondka = "0";
$recek = "0";
$gwiazdka = "0";
//$predkosc[$i] =	$pricelist[$i]['speed']	;
//$speedalls += 100000000000000000000;
//echo "$speedalls";
$speedallsmin = min($speedalls);

foreach($reslist['fleet'] as $n => $i){
		
		if($i > 200&&$i < 300 && $_POST["ship$i"] > "0"){
	$page .= '	    
			<input type="hidden" name="maxship'.$i.'" value="'.$planetrow[$resource[$i]].'"/>
			<input type="hidden" name="consumption'.$i.'" value="'.$pricelist[$i]['consumption'].'"/>
			<input type="hidden" name="speed'.$i.'" value="'.$pricelist[$i]['speed'].'" />
			<input type="hidden" name="capacity'.$i.'" value="'.$pricelist[$i]['capacity'].'" />
			<input type="hidden" name="ship'.$i.'" size="10" value="'.$_POST["ship$i"].'""/>';

			if ("ship$i" == "ship208")
			{
			$kolon = "1";
			}
			if ("ship$i" == "ship210")
			{
			$sondka = "1";
			}
               if ("ship$i" == "ship209")
			{
			$recek = "1";
			}
if ("ship$i" == "ship214")
			{
			$gwiazdka = "1";
			}
			$page .='
			
			</tr>';
			$have_ships = true;
			
			}
	
		}
		$page .='<input type="hidden" name="speedallsmin" size="10" value="'.$speedallsmin.'"/>';



	$page .= '
		<input type="hidden" name="kolonizator" size="10" value="'.$kolon.'""/>
		<input type="hidden" name="sondeczka" size="10" value="'.$sondka.'""/>		
		<input type="hidden" name="Recykler" size="10" value="'.$recek.'""/>     
		<input type="hidden" name="Gwiazda" size="10" value="'.$gwiazdka.'""/>

	  <div><center>
		<table width="519" border="0" cellpadding="0" cellspacing="1">';
		  
		$page .= '
		  <input name="flota" type="hidden" value="'.base64_encode(serialize($fleet["fleetarray"])).'" />
		  <input name="thisgalaxy" type="hidden" value="'.$planetrow["galaxy"].'" />
		  <input name="thissystem" type="hidden" value="'.$planetrow["system"].'" />
		  <input name="thisplanet" type="hidden" value="'.$planetrow["planet"].'" />
		  <input name="galaxyend" type="hidden" value="'.$_POST["galaxy"].'" />
		  <input name="systemend" type="hidden" value="'.$_POST["system"].'" />
		  <input name="planetend" type="hidden" value="'.$_POST["planet"].'" />
		  <input name="speedfactor" type="hidden" value="'.($game_config['fleet_speed']/2500).'" />
		  <input name="thisplanettype" type="hidden" value="1" />
		  <input name="thisresource1" type="hidden" value="'.floor($planetrow["metal"]).'" />
		  <input name="thisresource2" type="hidden" value="'.floor($planetrow["crystal"]).'" />
		  <input name="thisresource3" type="hidden" value="'.floor($planetrow["deuterium"]).'" />';
		  
		  
		  
		  
		$page .= '
		  <tr height="20">
			<td colspan="2" class="c">Fleet Orders</td>
		  </tr>
		  <tr height="20">
			<th width="50%">Coordinates.</th>
			<th> <input name="galaxy" size="3" maxlength="2" onChange="shortInfo()" onKeyUp="shortInfo()"  value="'.$g.'" />
			  <input name="system" size="3" maxlength="3" onChange="shortInfo()" onKeyUp="shortInfo()" value="'.$s.'" />
			  <input name="planet" size="3" maxlength="2" onChange="shortInfo()" onKeyUp="shortInfo()" value="'.$p.'" />
			  <select name="planettype" onChange="shortInfo()" onKeyUp="shortInfo()">';
				
		$page .= '<option value="1"'.(($t==1)?" SELECTED":"").">Planet</option>";
		$page .= '<option value="2"'.(($t==2)?" SELECTED":"").">Moon</option>";
		$page .= '<option value="3"'.(($t==3)?" SELECTED":"").">DF</option>";
		
		
		$page .= '
			  </select>
		  </tr>
		  <tr height="20">
			<th>Speed</th>
			<th> <select name="speed" onChange="shortInfo()" onKeyUp="shortInfo()">';
			
			foreach($speed as $a => $b){
				$page .= "<option value=\"$a\">$b</option>";
			}

		$page .= '</select>
			  % </th>
';
			  

		$page .= '
		  </tr>
		  <tr height="20">
			<th>Distance</th>
			<th><div id="distance">-</div></th>
		  </tr>
		  <tr height="20">
			<th>Duration(One Way)</th>
			<th><div id="duration">-</div></th>
		  </tr>
		  <tr height="20">
			<th>Deuterium Consumption</th>
			<th><div id="consumption">-</div>
			<input name="consumption" type="hidden" value="'.$_POST["consumption"].'" /></th>
		  </tr>
		  <tr height="20">
			<th>Max. Speed</th>
			<th><div id="maxspeed">-</div></th>
		  </tr>
		  <tr height="20">
			<th>Cargo Capacity</th>
			<th><div id="storage">-</div></th>
		  </tr>
		  
		  </table>
		  <table width="519" border="0" cellpadding="0" cellspacing="1">
		  <tr height="20">
			<td colspan="2" class="c">Shortcuts <a href="fleetshortcut.php">(View)</a></td>
		  </tr>';
		  
		if($user['fleet_shortcut']){
			/*
			  Dentro de fleet_shortcut, se pueden almacenar las diferentes direcciones
			  de acceso directo, el formato es el siguiente.
			  Nombre, Galaxia,Sistema,Planeta,Tipo
			*/
			$scarray = explode("\r\n",$user['fleet_shortcut']);
			$i=0;
			
			foreach($scarray as $a => $b){
				if($b!=""){
				$c = explode(',',$b);
				if($i==0){$page .= "<tr height=\"20\">";}
				$page .= "<th><a href=\"javascript:setTarget";
				$page .= "({$c[1]},{$c[2]},{$c[3]},{$c[4]}); shortInfo();\">";
				$page .= "{$c[0]} {$c[1]}:{$c[2]}:{$c[3]}";
				//Muestra un (L) si el destino pertenece a luna, lo mismo para escombros
				if($c[4]==2){$page .= " (E)";}elseif($c[4]==3){$page .= " (L)";}
				$page .= "</a></th>";
				if($i==1){$page .= "</tr>";}
				if($i==1){$i=0;}else{$i=1;}
				}
			}
			if($i==1){$page .= "<th></th></tr><tr height=\"20\">
			<td colspan=\"2\" class=\"c\">Please view your fleet shortcuts:</td>
		  </tr>";}
		
		}else{$page .= "<th colspan=\"2\">View fleet shortcuts.</th><tr height=\"20\">
			<td colspan=\"2\" class=\"c\">Koloni:</td>
		  </tr>";}

		if($user['fleet_short']){
			/*
			  Dentro de fleet_shortcut, se pueden almacenar las diferentes direcciones
			  de acceso directo, el formato es el siguiente.
			  Nombre, Galaxia,Sistema,Planeta,Tipo
			*/
			$scarray = explode("\r\n",$user['fleet_short']);
			$i=0;
			
			foreach($scarray as $a => $b){
				if($b!=""){
				$c = explode(',',$b);
				if($i==0){$page .= "<tr height=\"20\">";}
				$page .= "<th><a href=\"javascript:setTarget";
				$page .= "({$c[1]},{$c[2]},{$c[3]},{$c[4]}); shortInfo();\">";
				$page .= "{$c[0]} {$c[1]}:{$c[2]}:{$c[3]}";
				//Muestra un (L) si el destino pertenece a luna, lo mismo para escombros
				if($c[4]==2){$page .= " (E)";}elseif($c[4]==3){$page .= " (L)";}
				$page .= "</a></th>";
				if($i==1){$page .= "</tr>";}
				if($i==1){$i=0;}else{$i=1;}
				}
			}
			if($i==1){$page .= "<th></th></tr>";}
		
		}else{$page .= "<th colspan=\"2\">Koloni Yok.</th>";}

		$page .= '	  
		  </th>
		  
		  </tr>
		  
		  <tr height="20">
			<td colspan="2" class="c">Savas iliskileri
		  </tr>
		  <tr height="20">
			<th colspan="2">-</th>
		  </tr>
		  <tr height="20" >
			<th colspan="2"><input type="submit" value="Devam" /></th>
			</form>
		  </tr>
		</table>
		  </center>
		</div>
';
	display($page,"Flota");
?>