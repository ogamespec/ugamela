<?php

/*
  Perberos escribio:
    por ahora solo se envian flotas fantasmas. (es decir, la cantidad que
	hay en el planeta, no varia. Y cuando llegan al otro lado, Desaparecen)
	
	Corregi un pequeño bug en los tiempos que se muestran en la lista de flotas.
	
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
		7 => 'Filo Pozisyonu',
		8 => 'Geri D�nd�rme',
		9 => 'S�m�rge',
		);
		
	$speed = array(
		1 => 10,
		2 => 20,
		3 => 30,
		4 => 40,
		5 => 50,
		6 => 60,
		7 => 70,
		8 => 80,
		9 => 90,
		10 => 100,
		);
}

if($_POST){
	/*
	  UUURRRRGGGGGG!!!!
	*/
	//en caso de que no exista el tipo de planeta destino
	if(!$_POST['planettype']){message('Debes elegir el tipo de destino.'."Error");}

	//para las coordenadas del planeta destino
	if(!$_POST['galaxy']){$error++;$errorlist .= 'Debes elegir la galaxia destino.';}
	if(!$_POST['system']){$error++;$errorlist .= 'Debes elegir el sistema destino.';}
	if(!$_POST['planet']){$error++;$errorlist .= 'Debes elegir la posicion destino.';}

	//Para comprobar de que la flota que se envia, sea la misma del planeta
    if($_POST['thisgalaxy'] != $planetrow['galaxy']|$_POST['thissystem'] != $planetrow['system']|$_POST['thisplanet'] != $planetrow['planet']|$_POST['thisplanettype'] != $planetrow['planet_type']){message('...',"WTF!");}
	//Se comprueba de que se tengan los recursos.
	if($_POST['resource1'] > $planetrow['metal']|$_POST['resource2'] > $planetrow['crystal']|$_POST['resource3'] > $planetrow['deuterium']){message("No tienes suficientes recursos.","Error");}
	
	/*
	  Ahora se debe obtener la lista de naves, para agregarlas a la array
	  Solo un megaloop comprobando si esta la nave, y cuantas.
	*/
	$fleet='';

	foreach($reslist['fleet'] as $n => $i){
		
		if($i > 200&&$i < 300 && $_POST["ship$i"] != 0){
			
			if($_POST["ship$i"] <= $planetrow[$resource[$i]]){
				$fleet['fleetarray'][$i] = $_POST["ship$i"];
				$fleet['fleetlist'] .= $i.",".$_POST["ship$i"]."\r\n";
				$fleet['amount'] += $_POST["ship$i"];
				$planetrow[$resource[$i]] -= $_POST["ship$i"];
				$pquery .= $resource[$i]."= '".$planetrow[$resource[$i]]."' ,";
			}
		}
	}
	
	if(!$fleet['fleetlist']){message("Debes seleccionar al menos una nave.","Error");}
	//alguien sabe alguna formula para el tiempo? :D
	$fleet['start_time'] = 30 + time();
	$fleet['end_time'] = 60 + time();

	//$fleetlist contiene la lista de flotas, Esta se colocara en una row
	//dentro de la sql
	doquery("INSERT INTO {{table}} SET
	`fleet_owner`='{$user['id']}',
	`fleet_mission`='{$_POST['mission']}',
	`fleet_amount`='{$fleet['amount']}',
	`fleet_array`='{$fleet['fleetlist']}',
	`fleet_start_time`= '{$fleet['start_time']}',
	`fleet_start_galaxy`='{$_POST['thisgalaxy']}',
	`fleet_start_system`='{$_POST['thissystem']}',
	`fleet_start_planet`='{$_POST['thisplanet']}',
	`fleet_start_type`='{$_POST['planettype']}',
	`fleet_end_time`='{$fleet['end_time']}',
	`fleet_end_galaxy`='{$_POST['galaxy']}',
	`fleet_end_system`='{$_POST['system']}',
	`fleet_end_planet`='{$_POST['planet']}',
	`fleet_end_type`='{$_POST['thisplanettype']}',
	`fleet_resource_metal` = '{$_POST['resource1']}',
	`fleet_resource_crystal` = '{$_POST['resource2']}',
	`fleet_resource_deuterium` = '{$_POST['resource3']}'",'fleets');
	
	//ahora se deven quitar las naves correspondientes
	//o mejor dicho. actualizar el row del planet
	$query = "UPDATE {{table}} SET
	$pquery
	metal='{$planetrow['metal']}',
	crystal='{$planetrow['crystal']}',
	deuterium='{$planetrow['deuterium']}'
	WHERE id={$planetrow['id']}";
	doquery($query,"planets");
	//$missiontype corresponde al tipo de accion a tomar.

	$page = '<table border="0" cellpadding="0" cellspacing="1" width="519">';
	$page .= '<tr height="20"><td class="c" colspan="2">';
	$page .= '<span class="success">La flota ha sido enviada:</span>';
	$page .= '</td></tr>';
	$page .= "<tr height=20><th>Mision</th><th>Transportar</th></tr>";
	$page .= "<tr height=20><th>distancia</th><th>{$fleet[distance]}</th></tr>";
	$page .= "<tr height=20><th>Velocidad</th><th>{$fleet[speed]}</th></tr>";
	$page .= "<tr height=20><th>Consumo</th><th>{$fleet[speed]}</th></tr>";
	$page .= "<tr height=20><th>Comienzo</th><th>{$fleet[start]}</th></tr>";
	$page .= "<tr height=20><th>Objetivo</th><th>{$fleet[objetivo]}</th></tr>";
	$page .= "<tr height=20><th>Hora de llegada</th><th>";
	//hora de lleada
	$page .= date("M D d H:m:s",$fleet['start_time']).'</th></tr>';
	$page .= '<tr height="20"><th>Hora de vuelta</th><th>';
	//Hora de vuelta
	$page .= date("M D d H:m:s",$fleet['end_time']).'</th></tr>';
	$page .= '<tr height="20"><td class="c" colspan="2">Naves</td></tr>';
	//Naves
	foreach($fleet['fleetarray'] as $a => $b){
		$a = $lang['tech'][$a];
		$page .= "<tr height=\"20\"><th width=\"50%\">$a</th><th>$b</th></tr>";
	}
	
	$page .= '</table>';
	display($page,'Flotas');
}
else{

	if(!$g){$g = $planetrow['galaxy'];}
	if(!$s){$s = $planetrow['system'];}
	if(!$p){$p = $planetrow['planet'];}
	if(!$t){$t = $planetrow['planet_type'];}

	$page = '<script language="JavaScript" src="scripts/flotten.js"></script>
<script language="JavaScript" src="scripts/ocnt.js"></script>
<form action="" method="post">
  <center>
    <table width="519" border="0" cellpadding="0" cellspacing="1">
      <tr height="20">
        <td colspan="8" class="c">Filo (azami '.++$user[$resource[108]].')</td>
      </tr>
      <tr height="20">
        <th>Nr.</th>
        <th>G�rev</th>
        <th>Adet</th>
        <th>Start</th>
        <th>Hedefe G�nderis Zamani</th>
        <th>Hedef</th>
        <th>Hedefe Varis Zamani</th>
        <th>Emir</th>
      </tr>';
	/*
	  Here must show the fleet movings of owner player.
	*/

	$fq = doquery("SELECT * FROM {{table}} WHERE fleet_owner={$user[id]}",'fleets');

	$i=0;
	while($f = mysql_fetch_array($fq)){
		$i++;
		
		$page .= "<tr height=20><th>$i</th><th>";
		$page .= "<a title=\"\">{$missiontype[$f[fleet_mission]]}</a>";
		$page .= "<a title=\"Volver al planeta\">(V)</a>";
		$page .= "</th><th><a title=\"";
		/*
		  Se debe hacer una lista de las tropas
		*/
		$fleet = explode("\r\n",$f['fleet_array']);
		$e=0;
		foreach($fleet as $a =>$b){
			if($b != ''){
				$e++;
				$a = explode(",",$b);
				$page .= "{$tech{$a[0]}}: {$a[1]}\n";
				if($e>1){$page .= "\t";}
			}
		}
		$page .= "\">{$f[fleet_amount]}</a></th>";
		$page .= "<th>[{$f[fleet_start_galaxy]}:{$f[fleet_start_system]}:{$f[fleet_start_planet]}]</th>";
		$page .= "<th>".gmdate("D M d H:i:s",$f['fleet_start_time']-3*60*60)."</th>";
		$page .= "<th>[{$f[fleet_end_galaxy]}:{$f[fleet_end_system]}:{$f[fleet_end_planet]}]</th>";
		$page .= "<th>".gmdate("D M d H:i:s",$f['fleet_end_time']-3*60*60)."</th>";
		
		$page .= "    <th>
			 <form action=\"fleet\" method=\"post\">
		
		<input name=\"order_return\" value=23680670 type=hidden>
			<input value=\"Enviar de regreso\" type=\"submit\">
		 </form>
				<font color=\"lime\"><div id=\"time_0\"><font>".pretty_time(floor($f['fleet_end_time']+1-time()))."</font></div></font></th>
				</tr>";
	}

	if($i==0){$page .= "<th>-</th><th>-</th><th>-</th><th>-</th><th>-</th><th>-</th><th>-</th><th>-</th>";}
		 /*      <tr height="20">
			<th>2</th>
			<th> <a title="">Recolectar</a> <a title="Volver al planeta">(V)</a> </th>
			<th> <a title="Reciclador: 1">1</a></th>
			<th>[5:328:12]</th>
			<th>Thu Jun 29 1:52:13</th>
			<th>[5:328:13]</th>
			<th>Thu Jun 29 4:44:59</th>
			<th> </th>
		  </tr> */
	$page .= '
		</table>
	  </center>
	  <center>
		<table width="519" border="0" cellpadding="0" cellspacing="1">
		  <tr height="20">
			<td colspan="4" class="c">Yeni G�rev: Uzay gemilerini secmek</td>
		  </tr>
		  <tr height="20">
			<th>Gemi Ismi</th>
			<th>Mevcut</th>';
			//<!--    <th>Gesch.</th> -->
			$page .= '
			<th>-</th>
			<th>-</th>
		  </tr>';
	if(!$planetrow){message('WTF! ERROR!','ERROR');}//uno nunca sabe xD
	/*
	  Peque�o loop para mostrar las naves que se encuentran en el planeta.
	*/
	
	foreach($reslist['fleet'] as $n => $i){
		  
		if($planetrow[$resource[$i]] > 0){
			
			$page .= '<tr height="20">
			<th><a title="Velocidad: '.$pricelist[$i]['speed'].'">'.$lang['tech'][$i].'</a></th>
			<th>'.$planetrow[$resource[$i]].'
			  <input type="hidden" name="maxship'.$i.'" value="'.$planetrow[$resource[$i]].'"/></th>
			<!--    <th>28000 -->
			<input type="hidden" name="consumption'.$i.'" value="'.$pricelist[$i]['consumption'].'"/>
			<input type="hidden" name="speed'.$i.'" value="'.$pricelist[$i]['speed'].'" />
			</th>
			<input type="hidden" name="capacity'.$i.'" value="'.$pricelist[$i]['capacity'].'" />
			</th>
			<th><a href="javascript:maxShip(\'ship'.$i.'\');shortInfo();">m&aacute;x</a> </th>
			<th><input name="ship'.$i.'" size="10" value="0" alt="'.$lang['tech'][$i].$planetrow[$resource[$i]].'"  onChange="shortInfo()" onKeyUp="shortInfo()"/></th>
			</tr>';
			$have_ships = true;
		}

	}

	if(!$have_ships){
		/*
		  En caso de que no se tenga nunguna nave, solo se cambia el boton
		  por uno que no tenga submit, y la propiedad disabled
		*/
		$page .= '<tr height="20">
		<th colspan="4">Hicbir uzay gemisine sahip degilsiniz.</th>
		</tr>
		<tr height="20">
		<th colspan="4">
		<input type="button" value="Devam" disabled/></th>
		</tr>
		</table>
		</center>
		</form>';
	}
	else{
		$page .= '
		  <tr height="20">
			<th colspan="2"><a href="javascript:noShips();shortInfo();noResources();" >Hicbir gemi</a></th>
			<th colspan="2"><a href="javascript:maxShips();shortInfo();" >T�m gemiler</a></th>
		  </tr>';
		  

		$page .= '
		</table>
	  </center>
	  <div id="xform" style="display:none;"><center>
		<table width="519" border="0" cellpadding="0" cellspacing="1">';
		  
		  
		$page .= '
		  <input name="thisgalaxy" type="hidden" value="'.$planetrow["galaxy"].'" />
		  <input name="thissystem" type="hidden" value="'.$planetrow["system"].'" />
		  <input name="thisplanet" type="hidden" value="'.$planetrow["planet"].'" />
		  <input name="speedfactor" type="hidden" value="1" />
		  <input name="thisplanettype" type="hidden" value="1" />
		  <input name="thisresource1" type="hidden" value="'.floor($planetrow["metal"]).'" />
		  <input name="thisresource2" type="hidden" value="'.floor($planetrow["crystal"]).'" />
		  <input name="thisresource3" type="hidden" value="'.floor($planetrow["deuterium"]).'" />';
		  
		  
		  
		  
		$page .= '
		  <tr height="20">
			<td colspan="2" class="c">Geli�mi�</td>
		  </tr>
		  <tr height="20">
			<th width="50%">Kordinat</th>
			<th> <input name="galaxy" size="3" maxlength="2" onChange="shortInfo()" onKeyUp="shortInfo()" value="'.$g.'" />
			  <input name="system" size="3" maxlength="3" onChange="shortInfo()" onKeyUp="shortInfo()" value="'.$s.'" />
			  <input name="planet" size="3" maxlength="2" onChange="shortInfo()" onKeyUp="shortInfo()" value="'.$p.'" />
			  <select name="planettype" onChange="shortInfo()" onKeyUp="shortInfo()">';
				
		$page .= '<option value="1"'.(($t==1)?" SELECTED":"").">Gezegen</option>";
		$page .= '<option value="2"'.(($t==2)?" SELECTED":"").">��pl�k</option>";
		$page .= '<option value="3"'.(($t==3)?" SELECTED":"").">Uydu</option>";
		
		
		$page .= '
			  </select>
		  </tr>
		  <tr height="20">
			<th>H�z</th>
			<th> <select name="speed" onChange="shortInfo()" onKeyUp="shortInfo()">';
			
			foreach($speed as $a => $b){
				$page .= "<option value=\"$a\">$b</option>";
			}

		$page .= '</select>
			  % </th>
		  </tr>
		  <tr height="20">
			<th>Misi�</th>
			<th> <select name="mission" onChange="shortInfo()" onKeyUp="shortInfo()">';
			
			foreach($missiontype as $a => $b){
				$page .= "<option value=\"$a\">$b</option>";
			}

		$page .= '
			  </select>
			  % </th>
		  </tr>
		  <tr height="20">
			<th>Uzakl�k</th>
			<th><div id="distance">-</div></th>
		  </tr>
		  <tr height="20">
			<th>Ulasma Zaman�</th>
			<th><div id="duration">-</div></th>
		  </tr>
		  <tr height="20">
			<th>Filo</th>
			<th><div id="consumption">-</div></th>
		  </tr>
		  <tr height="20">
			<th>En Y�ksek H�z</th>
			<th><div id="maxspeed">-</div></th>
		  </tr>
		  <tr height="20">
			<th>Depolama</th>
			<th><div id="storage">-</div></th>
		  </tr>
		  
		  </table>
		  <table width="519" border="0" cellpadding="0" cellspacing="1">
		  
		  
		  <tr height="20">
			<td colspan="3" class="c">Mission</td>
		  </tr>
		   <tr height="20">
		  <th>Metal</th>
		  <th><a href="javascript:maxResource(\'1\');">+</a></th>
		  <th width="50%"><input name="resource1" type="text" alt="Metal '.floor($planetrow["metal"]).'" size="21" onChange="calculateTransportCapacity();" /></th>

		 </tr>
		   <tr height="20">
		  <th>Kristal</th>
		  <th><a href="javascript:maxResource(\'2\');">+</a></th>
		  <th width="50%"><input name="resource2" type="text" alt="cristal '.floor($planetrow["crystal"]).'" size="21" onChange="calculateTransportCapacity();" /></th>
		 </tr>
		   <tr height="20">
		  <th>Deuterium</th>

		  <th><a href="javascript:maxResource(\'3\');">+</a></th>
		  <th width="50%"><input name="resource3" type="text" alt="Deuterium'.floor($planetrow["deuterium"]).'" size="21" onChange="calculateTransportCapacity();" /></th>
		 </tr>
		   <tr height="20">
	  <th>Kalan Depo Alan�</th>
		  <th colspan="2"><div id="remainingresources">-</div></th>
		 </tr>      
		 <tr height="20">
	  <th colspan="2"><a href="javascript:noResources()">Bo�alt</a></th>
	  <th><a href="javascript:maxResources()">All Resources</a></th>
		 </tr>

		  </table>
		  <table width="519" border="0" cellpadding="0" cellspacing="1">
		  <tr height="20">
			<td colspan="2" class="c">Fleet Shortcut <a href="fleetshortcut.php">(View)</a></td>
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
			if($i==1){$page .= "<th></th></tr>";}
		
		}else{$page .= "<th colspan=\"2\">Direk Adres Yok</th>";}

		$page .= '	  
		  </th>
		  
		  </tr>
		  
		  <tr height="20">
			<td colspan="2" class="c">Konfederasyon Sava��
		  </tr>
		  <tr height="20">
			<th colspan="2">-</th>
		  </tr>
		  <tr height="20" >
			<th colspan="2"><input type="submit" value="Devam" /></th>
		  </tr>
		</table>
		  </center>
		</div>
	</form>';
	}
	display($page,"Flota");
}

// Created by Perberos. All rights reversed (C) 2006
?>
