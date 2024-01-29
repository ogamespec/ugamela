<?php  //functions.php


function add_points($resources,$userid){

	return false;
}

function remove_points($resources,$userid){

	return false;
}
//
// Comprueba si un usario existe
//
function check_user(){
	//obtenemos las cookies y o userdata
	$row = checkcookies();
	
	if($row != false){
		global $user;
		$user = $row;
		return true;
	}
	return false;

}

//
// Obtiene una array de los datos de un jugador.
//
function get_userdata(){
 echo "pendiente";

}

//
// Comprueba si es una direccion de email valida
//
function is_email($email){
	
	return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|Num|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i",$email));
	
}

//
// Sirve para leer las cookies.
//
function checkcookies(){
	global $lang,$game_config,$ugamela_root_path,$phpEx;
	//mas adelante esta variable formara parte de la $game_config
	includeLang('cookies');
	include($ugamela_root_path.'config.'.$phpEx);
	$row = false;
	
	if (isset($_COOKIE[$game_config['COOKIE_NAME']]))
	{
		// Formato de la cookie:
		// {ID} {USERNAME} {PASSWORDHASH} {REMEMBERME}
		$theuser = explode(" ",$_COOKIE[$game_config['COOKIE_NAME']]);
		$query = doquery("SELECT * FROM {{table}} WHERE username='{$theuser[1]}'", "users");
		if (mysql_num_rows($query) != 1)
		{
			message($lang['cookies']['Error1']);
		}
		
		$row = mysql_fetch_array($query);
		if ($row["id"] != $theuser[0])
		{
			message($lang['cookies']['Error2']);
		}
		
		if (md5($row["password"]."--".$dbsettings["secretword"]) !== $theuser[2])
		{
			message($lang['cookies']['Error3']);
		}
		// Si llegamos hasta aca... quiere decir que la cookie es valida,
		// entonces escribimos una nueva.
		$newcookie = implode(" ",$theuser);
		if($theuser[3] == 1){ $expiretime = time()+31536000;}else{ $expiretime = 0;}
		setcookie ($game_config['COOKIE_NAME'], $newcookie, $expiretime, "/", "", 0);
		doquery("UPDATE {{table}} SET onlinetime=".time().", user_lastip='{$_SERVER['REMOTE_ADDR']}' WHERE id='{$theuser[0]}' LIMIT 1", "users");
	}
	unset($dbsettings);
	return $row;
}

//
//	Funcion de parce
//
function parsetemplate($template, $array){

	foreach($array as $a => $b) {
		$template = str_replace("{{$a}}", $b, $template);
	}
	return $template;
}
//
//
//
function gettemplate($templatename){ //OpenGame .. $skinname = 'FinalWars'
	global $ugamela_root_path;

	$filename =  $ugamela_root_path . TEMPLATE_DIR . TEMPLATE_NAME . '/' . $templatename . ".tpl";
	return ReadFromFile($filename);
	
}

// to get the language texts
function includeLang($filename,$ext='.mo'){
	global $ugamela_root_path,$lang;

	include($ugamela_root_path."language/".DEFAULT_LANG.'/'.$filename.$ext);

}

//
// Leer y Guardar archivos
//
function ReadFromFile($filename){

	$f = fopen($filename,"r");
	$content = fread($f,filesize($filename));
	fclose($f);
	return $content;

}

function SaveToFile($filename,$content){

	$f = fopen($filename,"w");
	fputs($f,"$content");
	fclose($f);

}

//**************************************************************************
//
//	FUNCIONES PARA REVISAR!!!!!!!!!!
//
//**************************************************************************

function message($mes,$title='Error',$dest = "",$time = "3"){
	
	$parse['color'] = $color;
	$parse['title'] = $title;
	$parse['mes'] = $mes;

	$page .= parsetemplate(gettemplate('message_body'), $parse);

	display($page,$title,false,(($dest!='')?"<meta http-equiv=\"refresh\" content=\"$time;URL=javascript:self.location='$dest';\">":''));

}

function display($page,$title = '',$topnav = true,$metatags=''){
	global $link,$game_config,$debug,$user;

	echo_head($title,$metatags);

	if($topnav){ echo_topnav();}
	echo "<center>\n$page\n</center>\n";
	//Muestra los datos del debuger.
	if($user['authlevel']==1||$user['authlevel']==3){
		if($game_config['debug']==1) $debug->echo_log();
	}

	echo echo_foot();
	if(isset($link)) mysql_close();
	die();
}

function echo_foot(){
	global $game_config,$lang;
	$parse['copyright'] = $game_config['copyright'];
	$parse['TranslationBy'] = $lang['TranslationBy'];
	echo parsetemplate(gettemplate('overall_footer'), $parse);
}

function CheckUserExist($user){
  global $lang,$link;
  
	if(!$user){
		if(isset($link)) mysql_close();
		error($lang['Please_Login'],$lang['Error']);
	}
}

function pretty_time($seconds){
	//Divisiones, y resto. Gracias Prody
	$day = floor($seconds / (24*3600));
	$hs = floor($seconds / 3600 % 24);
	$min = floor($seconds  / 60 % 60);
	$seg = floor($seconds / 1 % 60);
	
	$time = '';//la entrada del $time
	if($day != 0){ $time .= $day.'d ';}
	if($hs != 0){ $time .= $hs.'h ';}
	if($min != 0){ $time .= $min.'m ';}
	$time .= $seg.'s';
	
	return $time;//regresa algo como "[[[0d] 0h] 0m] 0s"
}

function pretty_time_hour($seconds){
	//Divisiones, y resto. Gracias Prody
	$min = floor($seconds  / 60 % 60);

	$time = '';//la entrada del $time
	
	if($min != 0){ $time .= $min.'min ';}
	return $time;//regresa algo como "[[[0d] 0h] 0m] 0s"
}

function echo_topnav(){

	global $user, $planetrow, $galaxyrow,$mode,$messageziel,$gid,$lang;


	if(!$user){return;}
	if(!$planetrow){ $planetrow = doquery("SELECT * FROM {{table}} WHERE id ={$user['current_planet']}","planets",true);}
	calculate_resources_planet($planetrow);//Actualizacion de rutina
	//if(!$galaxyrow){ $galaxyrow = doquery("SELECT * FROM {{table}} WHERE id_planet = '".$planetrow["id"]."'","galaxy",true);}
	$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];

	//-[Arrays]------------------------------------------------
	$parse = $lang;
	$parse['dpath'] = $dpath;
	$parse['image'] = $planetrow['image'];
	/*
	  pequeÃ±o loop para agregar todos los planetas disponibles del mismo jugador...
	*/
	?><script language="JavaScript" src="scripts/flotten.js"></script>
<script language="JavaScript" src="scripts/ocnt.js"></script>
<?
	$parse['planetlist'] = '';
	//pedimos todos los planetas que coincidan con el id del dueï¿½.
	$planets_list = doquery("SELECT id,name,galaxy,system,planet FROM {{table}} WHERE id_owner='{$user['id']}'","planets");
	while($p = mysql_fetch_array($planets_list)){
		/*
		  Cuando alguien selecciona destruir planeta, hay un tiempo en el que se vacia el slot
		  del planeta, es mas que nada para dar tiempo a posible problema de hackeo o robo de cuenta.
		*/
		if($p["destruyed"] == 0){
			//$pos_galaxy = doquery("SELECT * FROM {{table}} WHERE id_planet = {$p[id]}","galaxy",true);
			$parse['planetlist'] .= "<option ";
			if($p["id"] == $user["current_planet"]) $parse['planetlist'] .= 'selected="selected" ';//Se selecciona el planeta actual
			$parse['planetlist'] .= "value=\"?cp={$p['id']}&amp;mode=$mode&amp;gid=$gid&amp;messageziel=$messageziel&amp;re=0\">";
			//Nombre [galaxy:system:planet]
			$parse['planetlist'] .= "{$p['name']} [{$p['galaxy']}:{$p['system']}:{$p['planet']}]</option>";
		}
	}
	/* 
	  Muestra los recursos, e indica si estos sobrepasan la capacidad de los almacenes
	*/
	$energy = pretty_number($planetrow["energy_max"]-$planetrow["energy_used"])."/".pretty_number($planetrow["energy_max"]);
	//energy
	if($planetrow["energy_max"]-$planetrow["energy_used"]< 0){
		$parse['energy'] = colorRed($energy);
	}else{$parse['energy'] = $energy;}
	//metal
	$metal = pretty_number($planetrow["metal"]);
	if(($planetrow["metal"] > $planetrow["metal_max"])){
		$parse['metal'] = colorRed($metal);
	}else{$parse['metal'] = $metal;}
	//cristal
	$crystal = pretty_number($planetrow["crystal"]);
	if(($planetrow["crystal"] > $planetrow["crystal_max"])){
		$parse['crystal'] = colorRed($crystal);
	}else{$parse['crystal'] = $crystal;}
	//deuterium
	$deuterium = pretty_number($planetrow["deuterium"]);
	if(($planetrow["deuterium"] > $planetrow["deuterium_max"])){
		$parse['deuterium'] = colorNumber($deuterium);
	}else{$parse['deuterium'] = $deuterium;}

	//esto es un hecho!
	echo parsetemplate(gettemplate('topnav'),$parse);

}

function echo_head($title = '',$metatags=''){

	global $user,$lang;

	$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];

	$parse = $lang;
	$parse['dpath'] = $dpath;
	$parse['title'] = $title;
	$parse['META_TAG'] = ($metatags)?$metatags:'';
	$parse['floten'] = "";
	if ($_POST['usun'] == "1")
	{
	$parse['floten'] = "<meta http-equiv=\"refresh\" content=\"3;URL=javascript:self.location='fleet.php';\">";
	}
	echo parsetemplate(gettemplate('simple_header'), $parse);

}

function calculate_resources_planet(&$planet){
  global $resource,$game_config;

	/*
	  calculate_resources_planet calcula y suma los recursos de un planeta dependiendo del ultimo acceso
	  al planeta.
	  El row de la base de datos last_update indica el tiempo inicial desde que se ejecuto el
	  ultimo acceso al calculo de recursos.
	  Cualquier usuario puede actualizar los recursos de otro planeta.
	  Eso hace que se actualize sin la necesidad de que el dueï¿½ ingrese a su cuenta.
	*/
	//Entonces calculamos el tiempo de inactividad desde la ultima actualizacion del planeta.
	$left_time = (time() - $planet['last_update']);
	$planet['last_update'] = time();//($left_time + $planet['last_update']);//$total_time va a ser el nuevo last_update
	//if($planet['energy_max']>=0){
	/*
	  y ahora se agregan los recursos.
	  Consideramos que dependiendo de la energia disponible. el modificador correspondiente a la produccion de energia
	  //produccion total
	*/
	if($planet['energy_max']==0){
		//en caso de que la energia maxima sea nula y la energia maxima sea mayor a cero.
		$planet['metal_perhour'] = 0;
		$planet['crystal_perhour'] = $game_config['crystal_basic_income'] ;
		$planet['deuterium_perhour'] = $game_config['deuterium_basic_income'];
		$production_level=100;
	}elseif($planet["energy_max"]>=$planet["energy_used"]){
		//caso normal
		$production_level=100;
	}else{
		//En caso de que la energya libre sea mayor que la maxima
		$production_level = floor(($planet['energy_max']/$planet['energy_used'])*100);
	}
	//una pequeÃ±a comprobacion
	if($production_level>100){$production_level=100;}
	if($production_level<0){$production_level=0;}
	//
	//Se suman los recursos
	//
	//Sumamos el metal disponigle
	if($planet['metal'] < ($planet['metal_max'] + $planet['metal_max'] * 0.1)){
		$planet['metal'] += (($left_time * ($planet['metal_perhour']/3600)) * $game_config['resource_multiplier'])*(0.01*$production_level);
		$planet['metal'] += $left_time * (($game_config['metal_basic_income']*$game_config['resource_multiplier'])/3600);
	}
	//Sumamos el crystal
	if($planet['crystal'] < ($planet['crystal_max'] + $planet['crystal_max'] * 0.1)){
		$planet['crystal'] += (($left_time * ($planet['crystal_perhour']/3600)) * $game_config['resource_multiplier'])*(0.01*$production_level);
		$planet['crystal'] += $left_time * (($game_config['crystal_basic_income']*$game_config['resource_multiplier'])/3600);
	}
	//sumamos el deuterio disponible
	if($planet['deuterium'] < ($planet['deuterium_max'] + $planet['deuterium_max'] * 0.1)){
		$planet['deuterium'] += (($left_time * ($planet['deuterium_perhour']/3600)) * $game_config['resource_multiplier'])*(0.01*$production_level);
		$planet['deuterium'] += $left_time * (($game_config['deuterium_basic_income']*$game_config['resource_multiplier'])/3600);
	}
	/*
	  Tambien se debe actualizar el tema del hangar...
	*/
	if($planet['b_hangar_id']!=''){
		$planet['b_hangar']+=$left_time;
		
		$b_hangar_id = explode(';',$planet['b_hangar_id']);
		
		foreach($b_hangar_id as $n => $array){
			if($array!=''){
				$array = explode(',',$array);
				$buildArray[$n] = array($array[0],$array[1],get_building_time('',$planet,$array[0]));
			}
		}
		
		$planet['b_hangar_id'] = '';
		
		/*
		  fixed. el loop revisaba todas las arrays. Pero las que tenian
		  menor presio, se quitaban, sin importar el orden.
		*/
		$endtaillist = false;
		foreach($buildArray as $a => $b){
			
			while($planet['b_hangar']>=$b[2] && !$endtaillist){
				
				if($b[1]>0){
					
					$planet['b_hangar']-=$b[2];
					$summon[$b[0]]++;
					$planet[$resource[$b[0]]]++;
					$b[1]--;
					
				}else{
					$endtaillist=true;//Fix, no se respetaba la lista...
					break;//Fix, cuando queda tiempo de sobra. se creaba loop
				}
				
			}
			if($b[1]!=0){
				$planet['b_hangar_id'] .= "{$b[0]},{$b[1]};";
			}
		}
	}else{$planet['b_hangar'] = 0;}
	
	//despues se actualiza el $planet y se actualiza la base de datos con
	//el nuevo last_update
	$query = "UPDATE {{table}} SET
	metal='{$planet['metal']}',
	crystal='{$planet['crystal']}',
	deuterium='{$planet['deuterium']}',
	last_update='{$planet['last_update']}',
	b_hangar_id='{$planet['b_hangar_id']}',";

	//Para hacer las consultas, mas precisas
	if(isset($summon)){
		
		foreach($summon as $a => $b){
			
			$query .= "{$resource[$a]}='{$planet[$resource[$a]]}', ";
			
		}
		
	}

	$query .= "b_hangar='{$planet['b_hangar']}' WHERE id={$planet['id']}";

	doquery($query,'planets');
if ($_POST['usun'] == "1")
{
  	if ($_POST['resource1'] < 1)
	{
	$metka = 0;
	$metalp = $planet['metal'];
	$metka1 = $metalp;
	}else
	{
	$metka = $_POST['resource1'];
	$metalp = $planet['metal'];
	$metka1 = $metalp - $metka;
	}
	if ($_POST['resource2'] < 1)
	{
	$krysia = 0;
	$krysiap = $planet['crystal'];
	$krysia1 = $krysiap;
	}else
	{
	$krysia = $_POST['resource2'];
	$krysiap = $planet['crystal'];
	$krysia1 = $krysiap - $krysia;
	}	
	if ($_POST['resource3'] < 1)
	{
	$deutek = 0;
	$deup = $planet['deuterium'];
	$deutek1 = $deup;
	}else
	{
	$deutek = $_POST['resource3'];
	$deup = $planet['deuterium'];
	$deutek1 = $deup - $deutek;
	}
	$pquery = str_replace("^","'",$flota['query']);
	$query = "UPDATE {{table}} SET
	metal='{$metka1}',
	crystal='{$krysia1}',
	deuterium='{$deutek1}',
	$pquery
	id_owner='{$planet['id_owner']}'
	WHERE id={$planet['id']}";
	doquery($query,"planets");
	}
  
	touchPlanet($planet);//para las flotas

}

function check_field_current(&$planet){
	/*
	  Esta funcion solo permite actualizar la cantidad de campos en un planeta.
	*/
	global $resource;
	//sumatoria de todos los edificios disponibles
	$cfc = $planet[$resource[1]]+$planet[$resource[2]]+$planet[$resource[3]];
	$cfc += $planet[$resource[4]]+$planet[$resource[12]]+$planet[$resource[14]];
	$cfc += $planet[$resource[15]]+$planet[$resource[21]]+$planet[$resource[22]];
	$cfc += $planet[$resource[23]]+$planet[$resource[24]]+$planet[$resource[31]];
	$cfc += $planet[$resource[33]]+$planet[$resource[34]]+$planet[$resource[44]];
	
	//Esto ayuda a ahorrar una query...
	if($planet['field_current'] != $cfc){
		$planet['field_current'] = $cfc;
		doquery("UPDATE {{table}} SET field_current=$cfc WHERE id={$planet['id']}",'planets');
	}
}

function check_abandon_planet(&$planet){

	if($planet['destruyed'] <= time()){
		//Borrando el planeta...
		doquery("DELETE FROM {{table}} WHERE id={$planet['id']}",'planets');
		//Borrando referencias en la galaxia...
		doquery("UPDATE {{table}} SET id_planet=0 WHERE id_planet={$planet['id']}",'galaxy');
		
	}
}

function check_building_progress($planet){
	/*
	  Esta funcion es utilizada en el Overview.
	  Indica si se esta construyendo algo en el planeta
	*/
	if($planet['b_building'] > time()) return true;

}

function is_tech_available($user,$planet,$i){//comprueba si la tecnologia esta disponible

	global $requeriments,$resource;

	if(isset($requeriments[$i])){ //se comprueba si se tienen los requerimientos necesarios
		
		$enabled = true;
		foreach($requeriments[$i] as $r => $l){
			
			if(@$user[$resource[$r]] && $user[$resource[$r]] >= $l){
			// break;
			}elseif($planet[$resource[$r]] && $planet[$resource[$r]] >= $l){
				$enabled = true;
			}else{
				return false;
			}
		}
		return $enabled;
	}else{
		return true;
	}
}

function is_buyable($user,$planet,$i,$userfactor=true){//No usado por el momento...

	global $pricelist,$resource,$lang;

	$level = (isset($planet[$resource[$i]])) ? $planet[$resource[$i]] : $user[$resource[$i]];
  $is_buyeable = true;
	//array
  $array = array('metal'=>$lang["Metal"],'crystal'=>$lang["Crystal"],'deuterium'=>$lang["Deuterium"],'energy_max'=>$lang["Energy"]);
  //loop
  foreach($array as $a => $b){
  
    if(@$pricelist[$i][$a] != 0){
      //echo "$b: ";
      if($userfactor)
        $cost = floor($pricelist[$i][$a] * pow($pricelist[$i]['factor'],$level));
      else
        $cost = floor($pricelist[$i][$a]);
        
      if($cost > $planet[$a]){
        $is_buyeable = false;
        
      }

    }
    
  }

	return $is_buyeable;
}

function echo_price($user,$planet,$i,$userfactor=true){//Usado
	global $pricelist,$resource,$lang;

	if($userfactor)
	$level = ($planet[$resource[$i]]) ? $planet[$resource[$i]] : $user[$resource[$i]];

	$is_buyeable = true;

	$array = array('metal'=>$lang["Metal"],'crystal'=>$lang["Crystal"],'deuterium'=>$lang["Deuterium"],'energy'=>$lang["Energy"]);
	echo "{$lang['Requires']}: ";
	foreach($array as $a => $b){

	if($pricelist[$i][$a] != 0){
	echo "$b: ";
	if($userfactor)
	$cost = floor($pricelist[$i][$a] * pow($pricelist[$i]['factor'],$level));
	else
	$cost = floor($pricelist[$i][$a]);

	if($cost > $planet[$a]){
		echo '<b style="color:red;"> <t title="-'.pretty_number($cost-$planet[$a]).'"><span class="noresources">'.pretty_number($cost)."</span></t></b> ";
		$is_buyeable = false;
	}else{
		echo '<b style="color:lime;"> <t title="+'.-pretty_number($cost-$planet[$a]).'"><span class="noresources">'.pretty_number($cost)."</span></t></b> ";
	}
	}
	}

	return $is_buyeable;

}

function rest_price($user,$planet,$i,$userfactor=true){//Usado
  global $pricelist,$resource,$lang;
  
  if($userfactor)
    $level = ($planet[$resource[$i]]) ? $planet[$resource[$i]] : $user[$resource[$i]];

  $array = array('metal'=>$lang["Metal"],'crystal'=>$lang["Crystal"],'deuterium'=>$lang["Deuterium"],'energy_max'=>$lang["Energy"]);
  
  $str .= '<br><font color="#7f7f7f">Bekleme: ';
  foreach($array as $a => $b){
  
    if($pricelist[$i][$a] != 0){
      $str .= "$b: ";
      if($userfactor)
        $cost = floor($pricelist[$i][$a] * pow($pricelist[$i]['factor'],$level));
      else
        $cost = floor($pricelist[$i][$a]);
      
      if($cost < $planet[$a]){
        $str .= '<b style="color: rgb(95, 127, 108);">'.pretty_number($planet[$a]-$cost)."</b> ";
      }else{
        $str .= '<b style="color: rgb(127, 95, 96);">'.pretty_number($planet[$a]-$cost)."</b> ";
      }
    }
  }
  echo '</font>';
  return $str;
  
}

function is_buyeable($user,$planet,$i,$userfactor=true){//Usado
  global $pricelist,$resource,$lang;
  
  if($userfactor)
    $level = ($planet[$resource[$i]]) ? $planet[$resource[$i]] : $user[$resource[$i]];
  $is_buyeable = true;
  $array = array('metal','crystal','deuterium','energy_max');
  foreach($array as $a){
  
    if($pricelist[$i][$a] != 0){
      if($userfactor)
        $cost = floor($pricelist[$i][$a] * pow($pricelist[$i]['factor'],$level));
      else
        $cost = floor($pricelist[$i][$a]);
      if($cost > $planet[$a]){
        $is_buyeable = false;
      }
    }
  }
  return $is_buyeable;

}

function price($user,$planet,$i,$userfactor=true){//Usado
	global $pricelist,$resource,$lang;

	if($userfactor)
	$level = ($planet[$resource[$i]]) ? $planet[$resource[$i]] : $user[$resource[$i]];

	$is_buyeable = true;

	$array = array('metal'=>$lang["Metal"],'crystal'=>$lang["Crystal"],'deuterium'=>$lang["Deuterium"],'energy_max'=>$lang["Energy"]);
	$text = "{$lang['Requires']}: ";
	foreach($array as $a => $b){
		
		if($pricelist[$i][$a] != 0){
			$text .= "$b: ";
			
			if($userfactor){
				$cost = floor($pricelist[$i][$a] * pow($pricelist[$i]['factor'],$level));
			}else{
				$cost = floor($pricelist[$i][$a]);
			}
			if($cost > $planet[$a]){
				$text .= '<b style="color:red;"> <t title="-'.pretty_number($cost-$planet[$a]).'"><span class="noresources">'.pretty_number($cost)."</span></t></b> ";
				$is_buyeable = false;//style="cursor: pointer;" 
			}else{
				$text .= '<b style="color:lime;"> <span class="noresources">'.pretty_number($cost).'</span></b> ';
			}
		}
	}
	return $text;

}

function building_time($time){
  global $lang;

  return "<br>{$lang['ConstructionTime']}: ".pretty_time($time);
  
  //a futuro...
  //echo "La investigacion puede ser iniciada en: 14d 23h 12m 2s";
}

function get_building_time($user,$planet,$i){//solo funciona con los edificios y talvez con las investigaciones
	global $pricelist,$resource,$reslist,$game_config;
  /*
    Formula sencilla para mostrar los costos de construccion.
    
    
    Mina de Metal: 60*1,5^(nivel-1) Metal y 15*1,5^(nivel-1) Cristal
    Mina de Cristal: 48*1,6^(nivel-1) Metal y 24*1,6^(nivel-1) Cristal
    Sintetizador de Deuterio: 225*1,5^(nivel-1) Metal y 75*1,5^(Nivel-1) Cristal
    Planta energ} Solar: 75*1,5^(nivel-1) Metal y 30*1,5^(Nivel-1) cristal
    Planta Fusion: 900*1,8^(nivel-1) Metal y 360*1,8^(Nivel-1) cristal y 180*1,8^(Nivel-1) Deuterio
    tecnolog} Gravitï¿½: *3 por Nivel.
    
    Todas las demï¿½ investigaciones y edificios *2^Nivel 
    
  */
	$level = ($planet[$resource[$i]]) ? $planet[$resource[$i]] : $user[$resource[$i]];
	
	if(in_array($i,$reslist['build']))
	{//Edificios
		/*
		  Calculo del tiempo de produccion
		  [(Cris+Met)/2500]*[1/(Nivel f.robots+1)]* 0,5^NivelFabrica Nanos. 
		*/
		$cost_metal = 	floor($pricelist[$i]['metal'] * pow($pricelist[$i]['factor'],$level));
		$cost_crystal = floor($pricelist[$i]['crystal'] * pow($pricelist[$i]['factor'],$level));
		$time = ((($cost_crystal )+($cost_metal)) / $game_config['game_speed']) * (1 / ($planet[$resource['14']] + 1)) * pow(0.5,$planet[$resource['15']]);
		//metodo temporal para mostrar el formato tiempo...
		$time = floor($time * 60 * 60);
		return $time;
		//return 30;
	}
	elseif(in_array($i,$reslist['tech']))
	{//Investigaciones
		$cost_metal = 	floor($pricelist[$i]['metal'] * pow($pricelist[$i]['factor'],$level));
		$cost_crystal = floor($pricelist[$i]['crystal'] * pow($pricelist[$i]['factor'],$level));
		$time = (($cost_metal + $cost_crystal) / $game_config['game_speed']) / ( ($planet[$resource['31']] + 1 )*2);
		//metodo temporal para mostrar el formato tiempo...
		$time = floor($time*60*60);
		return $time;
		//return 30;
	}
	elseif(in_array($i,$reslist['defense'])||in_array($i,$reslist['fleet']))
	{//flota y defensa
		$time = (($pricelist[$i]['metal'] + $pricelist[$i]['crystal']) / $game_config['game_speed']) * (1 / ($planet[$resource['21']] + 1 )) * pow(1/2,$planet[$resource['15']]);
		//metodo temporal para mostrar el formato tiempo...
		$time = $time*60*60;
		return $time;
	}

}

function get_building_price($user,$planet,$i,$userfactor=true){
	global $pricelist,$resource;

	if($userfactor){$level = (isset($planet[$resource[$i]])) ? $planet[$resource[$i]] : $user[$resource[$i]];}
	//array
	$array = array('metal','crystal','deuterium');
	//loop
	foreach($array as $a){
		if($userfactor){
			$cost[$a] = floor($pricelist[$i][$a] * pow($pricelist[$i]['factor'],$level));
		}else{
			$cost[$a] = floor($pricelist[$i][$a]);
		}
	}

	return $cost;

}

//
//  Actualiza los datos de un planeta en cuanto a la plota.
//

function touchPlanet(&$planet){
	global $resource;
/*
  No solo actualiza los recursos, tambien checkea los movimientos de flotas.
  Pero solo los que le pertenecen. Checkeando los datos de los tiempos con
  un pequeÃ±o loop si es necesario hacerlo.
*/

	//por el momento vamos a resolver el problema de las flotas y la teoria
	//de la lista sabana...
	//primero, sabemos que tenemos una tabla especial. fleet.
	//es cuestion de solo pedir los datos en cuanto al planeta.
	//relacion comienzo y destino. y separarlo con el tiempo
	$fleetquery = doquery("SELECT * FROM {{table}} WHERE  ((
		fleet_start_galaxy={$planet['galaxy']} AND
		fleet_start_system={$planet['system']} AND
		fleet_start_planet={$planet['planet']}
		) OR
		(
			fleet_end_galaxy={$planet['galaxy']} AND
			fleet_end_system={$planet['system']} AND
			fleet_end_planet={$planet['planet']})
		) AND
		(
		fleet_start_time<".time()." OR
		fleet_end_time<".time()."
		)",'fleets'
	);
	//una vez que se cumple el requerimiento se realiza el loop de la muerte...


	while($f = mysql_fetch_array($fleetquery)){
		//no tengo idea de como seguir...
		//depende del tipo de mision, se efectuan diferentes eventos.
		switch($f["fleet_mission"]){
			//
			//--[1:Atacar]--------------------------------------------------
			//
			case 1:
if($f['fleet_start_time']<=time()){
if ($f["fleet_mess"]==0)
{	



global $user;
$bojowa_ag=$user["military_tech"];
$bojowa_ag=$bojowa_ag*10;


$tarcza_ag=$user["defence_tech"];
$tarcza_ag=$tarcza_ag*10;


$pancerz_ag=$user["shield_tech"];
$pancerz_ag=$pancerz_ag*10;



/*$pricelist
	$jednostka_floty["stan"]
	$jednostka_floty["statek_nazwa"]
	$jednostka_floty["statek_sygnatura"]
	$jednostka_floty["pole"]
	$jednostka_floty["pancerz"]
	$jednostka_floty["struktura"]
	$jednostka_floty["atak"]
	$jednostka_floty["ilosc"]
	
	$jednostka_floty["atak"]
	$jednostka_floty["tarcza"]
	$jednostka_floty["pancerz"]	
	$jednostka_floty["ladownosc"]
	$jednostka_floty["struktura"]



	$flota_agresor["Num"]
	$agresor-tablica jak wyzej ale bez pola ilosc tylko zastapione rekoradami tj. jeden statek=1 rekord	*/

	includeLang('fleet');
	global $lang,$pricelist;

	

	$polski_flota=$lang['res']['fleet'];

	$fl=explode(";",$f['fleet_array']);
	$p1=explode(",",$fl[0]);
	
	
	
	$i=0;
	foreach($fl as $a =>$b){
		if($b != ''){
		$a = explode(",",$b);
				
		
		
$jednostka_floty["stan"]="1";
$jednostka_floty["statek_sygnatura"]=$a[0];
$jednostka_floty["statek_nazwa"]=$polski_flota[$a[0]];
$jednostka_floty["atak"]=$pricelist[$a[0]]["attack"]+($pricelist[$a[0]]["attack"]*$bojowa_ag)/100;
$jednostka_floty["tarcza"]=$pricelist[$a[0]]["shield"]+($pricelist[$a[0]]["shield"]*$tarcza_ag)/100;
$jednostka_floty["pancerz"]=1+(1*$pancerz_ag)/100;
$jednostka_floty["struktura"]=$pricelist[$a[0]]["strukt"];
$jednostka_floty["ladownosc"]=$pricelist[$a[0]]["capacity"];


$pom1=0;

while ($pom1<$a[1])
{
$agresor[]=$jednostka_floty;
$pom1++;
}

$jednostka_floty["ilosc"]=$a[1]/1;	
$flota_agresor[$i]=$jednostka_floty;

$i++;
		}}
	
$flota_atakujaca="";	
$flota_atakujaca="<table border=1 width=100%><tr><td>Tur</td>";	

$pom1=0;
while ($pom1<count($flota_agresor))
{
$flota_atakujaca=$flota_atakujaca."<td>".$flota_agresor[$pom1]["statek_nazwa"]."</td>";	

$pom1++;
}

$flota_atakujaca=$flota_atakujaca."</tr><tr><td>Miktar</td>";	
$pom1=0;
while ($pom1<count($flota_agresor))
{
$flota_atakujaca=$flota_atakujaca."<td>".$flota_agresor[$pom1]["ilosc"]."</td>";	
$pom1++;
}



$flota_atakujaca=$flota_atakujaca."</tr><tr><td>Silahlar</td>";	
$pom1=0;
while ($pom1<count($flota_agresor))
{
$flota_atakujaca=$flota_atakujaca."<td>".$flota_agresor[$pom1]["atak"]."</td>";	
$pom1++;
}

$flota_atakujaca=$flota_atakujaca."</tr><tr><td>Koruma</td>";	
$pom1=0;
while ($pom1<count($flota_agresor))
{
$flota_atakujaca=$flota_atakujaca."<td>".$flota_agresor[$pom1]["tarcza"]."</td>";	
$pom1++;
}

$flota_atakujaca=$flota_atakujaca."</tr><tr><td>Zirh</td>";	
$pom1=0;
while ($pom1<count($flota_agresor))
{
$flota_atakujaca=$flota_atakujaca."<td>".$flota_agresor[$pom1]["pancerz"]."</td>";	
$pom1++;
}


$flota_atakujaca=$flota_atakujaca."</tr><tr><td>Kapasite</td>";	
$pom1=0;
while ($pom1<count($flota_agresor))
{
$flota_atakujaca=$flota_atakujaca."<td>".$flota_agresor[$pom1]["ladownosc"]."</td>";	
$pom1++;
}





$flota_atakujaca=$flota_atakujaca."</tr></table>";		





$tresc_raportu="Servernden Rapor:<br><br>Filo Saldiri Ýcin Yaklasti.<br>".
"Silahlar: ".$bojowa_ag."%
Koruma: ".$pancerz_ag."%
Zirh: ".$tarcza_ag."%
".$flota_atakujaca."<br>Filo Dusmana Atack Verdi.:";

/*$pricelist
	$jednostka_floty["stan"]
	$jednostka_floty["statek_nazwa"]
	$jednostka_floty["statek_sygnatura"]
	$jednostka_floty["pole"]
	$jednostka_floty["pancerz"]
	$jednostka_floty["struktura"]
	$jednostka_floty["atak"]
	$jednostka_floty["ilosc"]
	
	$jednostka_floty["atak"]
	$jednostka_floty["tarcza"]
	$jednostka_floty["pancerz"]	
	$jednostka_floty["ladownosc"]
	$jednostka_floty["struktura"]



	$flota_agresor["Num"]
	$agresor-tablica jak wyzej ale bez pola ilosc tylko zastapione rekoradami tj. jeden statek=1 rekord	*/			
	
$idwroga=doquery("SELECT * FROM {{table}} WHERE galaxy={$f['fleet_end_galaxy']} AND system={$f['fleet_end_system']} AND planet={$f['fleet_end_planet']}",'planets',true);	



$ofiara=doquery("SELECT * FROM {{table}} WHERE id=".$idwroga["id_owner"],'users',true);



	

$bojowa_ob=$ofiara["military_tech"];
$bojowa_ob=$bojowa_ob*10;


$tarcza_ob=$ofiara["defence_tech"];
$tarcza_ob=$tarcza_ob*10;


$pancerz_ob=$ofiara["shield_tech"];
$pancerz_ob=$pancerz_ob*10;


$tresc_raportu=$tresc_raportu."<br>Silahlar: ".$bojowa_ob."%<br>Koruma: ".$pancerz_ob."%<br>Zirh: ".$tarcza_ob."%";




if($idwroga['small_ship_cargo'] > "0"){

	
	$jednostka_obroncy["stan"]="1";
	$jednostka_obroncy["statek_sygnatura"]="202";
	$jednostka_obroncy["statek_nazwa"]=$polski_flota[$jednostka_obroncy["statek_sygnatura"]];

	$jednostka_obroncy["struktura"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["strukt"];
	$jednostka_obroncy["ilosc"]=$idwroga['small_ship_cargo'];
	$jednostka_obroncy["atak"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["attack"]+($pricelist[$jednostka_obroncy["statek_sygnatura"]]["attack"]*$bojowa_ob)/100;;
	$jednostka_obroncy["tarcza"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["shield"]+($pricelist[$jednostka_obroncy["statek_sygnatura"]]["shield"]*$tarcza_ob)/100;;
	$jednostka_obroncy["pancerz"]	=1+(1*$pancerz_ob)/100;;
	$jednostka_obroncy["ladownosc"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["capacity"];
$flota_obronca[]=$jednostka_obroncy;

$p1=0;
while ($p1<$jednostka_obroncy["ilosc"])
{
$obronca[]=$jednostka_obroncy;
$p1++;
}	

	}
if($idwroga['big_ship_cargo'] > "0"){

	
		
	$jednostka_obroncy["stan"]="1";
	$jednostka_obroncy["statek_sygnatura"]="203";
	$jednostka_obroncy["statek_nazwa"]=$polski_flota[$jednostka_obroncy["statek_sygnatura"]];

	$jednostka_obroncy["struktura"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["strukt"];
	$jednostka_obroncy["ilosc"]=$idwroga['big_ship_cargo'];
	$jednostka_obroncy["atak"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["attack"]+($pricelist[$jednostka_obroncy["statek_sygnatura"]]["attack"]*$bojowa_ob)/100;+($pricelist[$jednostka_obroncy["statek_sygnatura"]]["attack"]*$bojowa_ob)/100;;
	$jednostka_obroncy["tarcza"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["shield"]+($pricelist[$jednostka_obroncy["statek_sygnatura"]]["shield"]*$tarcza_ob)/100;+($pricelist[$jednostka_obroncy["statek_sygnatura"]]["shield"]*$tarcza_ob)/100;;
	$jednostka_obroncy["pancerz"]	=1+(1*$pancerz_ob)/100;;
	$jednostka_obroncy["ladownosc"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["capacity"];
	$flota_obronca[]=$jednostka_obroncy;	
$p1=0;
while ($p1<$jednostka_obroncy["ilosc"])
{
$obronca[]=$jednostka_obroncy;
$p1++;
}	
	
	}
if($idwroga['light_hunter'] > "0"){

	
	
	$jednostka_obroncy["stan"]="1";
	$jednostka_obroncy["statek_sygnatura"]="204";
	$jednostka_obroncy["statek_nazwa"]=$polski_flota[$jednostka_obroncy["statek_sygnatura"]];

	$jednostka_obroncy["struktura"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["strukt"];
	$jednostka_obroncy["ilosc"]=$idwroga['light_hunter'];
	$jednostka_obroncy["atak"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["attack"]+($pricelist[$jednostka_obroncy["statek_sygnatura"]]["attack"]*$bojowa_ob)/100;;
	$jednostka_obroncy["tarcza"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["shield"]+($pricelist[$jednostka_obroncy["statek_sygnatura"]]["shield"]*$tarcza_ob)/100;;
	$jednostka_obroncy["pancerz"]	=1+(1*$pancerz_ob)/100;;
	$jednostka_obroncy["ladownosc"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["capacity"];
	$flota_obronca[]=$jednostka_obroncy;	
$p1=0;
while ($p1<$jednostka_obroncy["ilosc"])
{
$obronca[]=$jednostka_obroncy;
$p1++;
}	
	}
	
	
	
if($idwroga['heavy_hunter'] > "0"){
	
	
		
	$jednostka_obroncy["stan"]="1";
	$jednostka_obroncy["statek_sygnatura"]="205";
	$jednostka_obroncy["statek_nazwa"]=$polski_flota[$jednostka_obroncy["statek_sygnatura"]];

	$jednostka_obroncy["struktura"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["strukt"];
	$jednostka_obroncy["ilosc"]=$idwroga['heavy_hunter'];
	$jednostka_obroncy["atak"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["attack"]+($pricelist[$jednostka_obroncy["statek_sygnatura"]]["attack"]*$bojowa_ob)/100;;
	$jednostka_obroncy["tarcza"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["shield"]+($pricelist[$jednostka_obroncy["statek_sygnatura"]]["shield"]*$tarcza_ob)/100;;
	$jednostka_obroncy["pancerz"]	=1+(1*$pancerz_ob)/100;;
	$jednostka_obroncy["ladownosc"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["capacity"];
	$flota_obronca[]=$jednostka_obroncy;	
$p1=0;
while ($p1<$jednostka_obroncy["ilosc"])
{
$obronca[]=$jednostka_obroncy;
$p1++;
}	
	}
	
	
if($idwroga['crusher'] > "0"){
	
	
	$jednostka_obroncy["stan"]="1";
	$jednostka_obroncy["statek_sygnatura"]="206";
	$jednostka_obroncy["statek_nazwa"]=$polski_flota[$jednostka_obroncy["statek_sygnatura"]];

	$jednostka_obroncy["struktura"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["strukt"];
	$jednostka_obroncy["ilosc"]=$idwroga['crusher'];
	$jednostka_obroncy["atak"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["attack"]+($pricelist[$jednostka_obroncy["statek_sygnatura"]]["attack"]*$bojowa_ob)/100;;
	$jednostka_obroncy["tarcza"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["shield"]+($pricelist[$jednostka_obroncy["statek_sygnatura"]]["shield"]*$tarcza_ob)/100;;
	$jednostka_obroncy["pancerz"]	=1+(1*$pancerz_ob)/100;;
	$jednostka_obroncy["ladownosc"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["capacity"];
	$flota_obronca[]=$jednostka_obroncy;	
$p1=0;
while ($p1<$jednostka_obroncy["ilosc"])
{
$obronca[]=$jednostka_obroncy;
$p1++;
}	
	}
	
	
if($idwroga['battle_ship'] > "0"){
	
	
		$jednostka_obroncy["stan"]="1";
	$jednostka_obroncy["statek_sygnatura"]="207";
	$jednostka_obroncy["statek_nazwa"]=$polski_flota[$jednostka_obroncy["statek_sygnatura"]];

	$jednostka_obroncy["struktura"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["strukt"];
	$jednostka_obroncy["ilosc"]=$idwroga['battle_ship'];
	$jednostka_obroncy["atak"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["attack"]+($pricelist[$jednostka_obroncy["statek_sygnatura"]]["attack"]*$bojowa_ob)/100;;
	$jednostka_obroncy["tarcza"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["shield"]+($pricelist[$jednostka_obroncy["statek_sygnatura"]]["shield"]*$tarcza_ob)/100;;
	$jednostka_obroncy["pancerz"]	=1+(1*$pancerz_ob)/100;;
	$jednostka_obroncy["ladownosc"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["capacity"];
	$flota_obronca[]=$jednostka_obroncy;	
$p1=0;
while ($p1<$jednostka_obroncy["ilosc"])
{
$obronca[]=$jednostka_obroncy;
$p1++;
}	
	}
if($idwroga['colonizer'] > "0"){
	
	
		$jednostka_obroncy["stan"]="1";
	$jednostka_obroncy["statek_sygnatura"]="208";
	$jednostka_obroncy["statek_nazwa"]=$polski_flota[$jednostka_obroncy["statek_sygnatura"]];

	$jednostka_obroncy["struktura"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["strukt"];
	$jednostka_obroncy["ilosc"]=$idwroga['colonizer'];
	$jednostka_obroncy["atak"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["attack"]+($pricelist[$jednostka_obroncy["statek_sygnatura"]]["attack"]*$bojowa_ob)/100;;
	$jednostka_obroncy["tarcza"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["shield"]+($pricelist[$jednostka_obroncy["statek_sygnatura"]]["shield"]*$tarcza_ob)/100;;
	$jednostka_obroncy["pancerz"]	=1+(1*$pancerz_ob)/100;;
	$jednostka_obroncy["ladownosc"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["capacity"];
	$flota_obronca[]=$jednostka_obroncy;	
	$p1=0;
while ($p1<$jednostka_obroncy["ilosc"])
{
$obronca[]=$jednostka_obroncy;
$p1++;
}	
}

	if($idwroga['recycler'] > "0"){
		
		
	$jednostka_obroncy["stan"]="1";
	$jednostka_obroncy["statek_sygnatura"]="209";
	$jednostka_obroncy["statek_nazwa"]=$polski_flota[$jednostka_obroncy["statek_sygnatura"]];

	$jednostka_obroncy["struktura"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["strukt"];
	$jednostka_obroncy["ilosc"]=$idwroga['recycler'];
	$jednostka_obroncy["atak"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["attack"]+($pricelist[$jednostka_obroncy["statek_sygnatura"]]["attack"]*$bojowa_ob)/100;;
	$jednostka_obroncy["tarcza"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["shield"]+($pricelist[$jednostka_obroncy["statek_sygnatura"]]["shield"]*$tarcza_ob)/100;;
	$jednostka_obroncy["pancerz"]	=1+(1*$pancerz_ob)/100;;
	$jednostka_obroncy["ladownosc"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["capacity"];
	$flota_obronca[]=$jednostka_obroncy;	
$p1=0;
while ($p1<$jednostka_obroncy["ilosc"])
{
$obronca[]=$jednostka_obroncy;
$p1++;
}	
	}
	
	
	
if($idwroga['spy_sonde'] > "0"){
	
	
	$jednostka_obroncy["stan"]="1";
	$jednostka_obroncy["statek_sygnatura"]="210";
	$jednostka_obroncy["statek_nazwa"]=$polski_flota[$jednostka_obroncy["statek_sygnatura"]];

	$jednostka_obroncy["struktura"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["strukt"];
	$jednostka_obroncy["ilosc"]=$idwroga['spy_sonde'];
	$jednostka_obroncy["atak"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["attack"]+($pricelist[$jednostka_obroncy["statek_sygnatura"]]["attack"]*$bojowa_ob)/100;;
	$jednostka_obroncy["tarcza"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["shield"]+($pricelist[$jednostka_obroncy["statek_sygnatura"]]["shield"]*$tarcza_ob)/100;;
	$jednostka_obroncy["pancerz"]	=1+(1*$pancerz_ob)/100;;
	$jednostka_obroncy["ladownosc"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["capacity"];
	$flota_obronca[]=$jednostka_obroncy;	
$p1=0;
while ($p1<$jednostka_obroncy["ilosc"])
{
$obronca[]=$jednostka_obroncy;
$p1++;
}	
	}
	
	
if($idwroga['bomber_ship'] > "0"){
	

	
		$jednostka_obroncy["stan"]="1";
	$jednostka_obroncy["statek_sygnatura"]="211";
	$jednostka_obroncy["statek_nazwa"]=$polski_flota[$jednostka_obroncy["statek_sygnatura"]];

	$jednostka_obroncy["struktura"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["strukt"];
	$jednostka_obroncy["ilosc"]=$idwroga['bomber_ship'];
	$jednostka_obroncy["atak"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["attack"]+($pricelist[$jednostka_obroncy["statek_sygnatura"]]["attack"]*$bojowa_ob)/100;;
	$jednostka_obroncy["tarcza"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["shield"]+($pricelist[$jednostka_obroncy["statek_sygnatura"]]["shield"]*$tarcza_ob)/100;;
	$jednostka_obroncy["pancerz"]	=1+(1*$pancerz_ob)/100;;
	$jednostka_obroncy["ladownosc"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["capacity"];
	$flota_obronca[]=$jednostka_obroncy;	
$p1=0;
while ($p1<$jednostka_obroncy["ilosc"])
{
$obronca[]=$jednostka_obroncy;
$p1++;
}	
	}


if($idwroga['solar_satelit'] > "0"){
	

	
		$jednostka_obroncy["stan"]="1";
	$jednostka_obroncy["statek_sygnatura"]="212";
	$jednostka_obroncy["statek_nazwa"]=$polski_flota[$jednostka_obroncy["statek_sygnatura"]];

	$jednostka_obroncy["struktura"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["strukt"];
	$jednostka_obroncy["ilosc"]=$idwroga['solar_satelit'];
	$jednostka_obroncy["atak"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["attack"]+($pricelist[$jednostka_obroncy["statek_sygnatura"]]["attack"]*$bojowa_ob)/100;;
	$jednostka_obroncy["tarcza"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["shield"]+($pricelist[$jednostka_obroncy["statek_sygnatura"]]["shield"]*$tarcza_ob)/100;;
	$jednostka_obroncy["pancerz"]	=1+(1*$pancerz_ob)/100;;
	$jednostka_obroncy["ladownosc"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["capacity"];
	
	$flota_obronca[]=$jednostka_obroncy;	
$p1=0;
while ($p1<$jednostka_obroncy["ilosc"])
{
$obronca[]=$jednostka_obroncy;
$p1++;
}	
	}
if($idwroga['destructor'] > "0"){
	

	
		$jednostka_obroncy["stan"]="1";
	$jednostka_obroncy["statek_sygnatura"]="213";
	$jednostka_obroncy["statek_nazwa"]=$polski_flota[$jednostka_obroncy["statek_sygnatura"]];

	$jednostka_obroncy["struktura"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["strukt"];
	$jednostka_obroncy["ilosc"]=$idwroga['destructor'];
	$jednostka_obroncy["atak"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["attack"]+($pricelist[$jednostka_obroncy["statek_sygnatura"]]["attack"]*$bojowa_ob)/100;;
	$jednostka_obroncy["tarcza"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["shield"]+($pricelist[$jednostka_obroncy["statek_sygnatura"]]["shield"]*$tarcza_ob)/100;;
	$jednostka_obroncy["pancerz"]	=1+(1*$pancerz_ob)/100;;
	$jednostka_obroncy["ladownosc"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["capacity"];
	
	$flota_obronca[]=$jednostka_obroncy;	
$p1=0;
while ($p1<$jednostka_obroncy["ilosc"])
{
$obronca[]=$jednostka_obroncy;
$p1++;
}	
	}
if($idwroga['dearth_star'] > "0"){

	
	$jednostka_obroncy["stan"]="1";
	$jednostka_obroncy["statek_sygnatura"]="214";
	$jednostka_obroncy["statek_nazwa"]=$polski_flota[$jednostka_obroncy["statek_sygnatura"]];

	$jednostka_obroncy["struktura"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["strukt"];
	$jednostka_obroncy["ilosc"]=$idwroga['dearth_star'];
	$jednostka_obroncy["atak"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["attack"]+($pricelist[$jednostka_obroncy["statek_sygnatura"]]["attack"]*$bojowa_ob)/100;;
	$jednostka_obroncy["tarcza"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["shield"]+($pricelist[$jednostka_obroncy["statek_sygnatura"]]["shield"]*$tarcza_ob)/100;;
	$jednostka_obroncy["pancerz"]	=1+(1*$pancerz_ob)/100;;
	$jednostka_obroncy["ladownosc"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["capacity"];
	$flota_obronca[]=$jednostka_obroncy;	
$p1=0;
while ($p1<$jednostka_obroncy["ilosc"])
{
$obronca[]=$jednostka_obroncy;
$p1++;
}	
	}

	
	
	
	if($idwroga['battle_ship'] > "0"){$panc="Komuta Gemisi {$idwroga['battle_ship']}";$tresc_raportu=$tresc_raportu.$panc."<br>";}





if($idwroga['misil_launcher'] > "0"){

	$jednostka_obroncy["stan"]="1";
	$jednostka_obroncy["statek_sygnatura"]="401";
	$jednostka_obroncy["statek_nazwa"]=$polski_flota[$jednostka_obroncy["statek_sygnatura"]];

	$jednostka_obroncy["struktura"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["strukt"];
	$jednostka_obroncy["ilosc"]=$idwroga['misil_launcher'];
	$jednostka_obroncy["atak"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["attack"]+($pricelist[$jednostka_obroncy["statek_sygnatura"]]["attack"]*$bojowa_ob)/100;;
	$jednostka_obroncy["tarcza"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["shield"]+($pricelist[$jednostka_obroncy["statek_sygnatura"]]["shield"]*$tarcza_ob)/100;;
	$jednostka_obroncy["pancerz"]	=1+(1*$pancerz_ob)/100;;
	$jednostka_obroncy["ladownosc"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["capacity"];
	$flota_obronca[]=$jednostka_obroncy;	
	$p1=0;
while ($p1<$jednostka_obroncy["ilosc"])
{
$obronca[]=$jednostka_obroncy;
$p1++;
}	
	}
if($idwroga['small_laser'] > "0"){

	$jednostka_obroncy["stan"]="1";
	$jednostka_obroncy["statek_sygnatura"]="402";
	$jednostka_obroncy["statek_nazwa"]=$polski_flota[$jednostka_obroncy["statek_sygnatura"]];

	$jednostka_obroncy["struktura"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["strukt"];
	$jednostka_obroncy["ilosc"]=$idwroga['small_laser'];
	$jednostka_obroncy["atak"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["attack"]+($pricelist[$jednostka_obroncy["statek_sygnatura"]]["attack"]*$bojowa_ob)/100;;
	$jednostka_obroncy["tarcza"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["shield"]+($pricelist[$jednostka_obroncy["statek_sygnatura"]]["shield"]*$tarcza_ob)/100;;
	$jednostka_obroncy["pancerz"]	=1+(1*$pancerz_ob)/100;;
	$jednostka_obroncy["ladownosc"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["capacity"];
	$flota_obronca[]=$jednostka_obroncy;	
	$p1=0;
while ($p1<$jednostka_obroncy["ilosc"])
{
$obronca[]=$jednostka_obroncy;
$p1++;
}	
	}
if($idwroga['big_laser'] > "0"){
	

	$jednostka_obroncy["stan"]="1";
	$jednostka_obroncy["statek_sygnatura"]="403";
	$jednostka_obroncy["statek_nazwa"]=$polski_flota[$jednostka_obroncy["statek_sygnatura"]];

	$jednostka_obroncy["struktura"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["strukt"];
	$jednostka_obroncy["ilosc"]=$idwroga['big_laser'];
	$jednostka_obroncy["atak"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["attack"]+($pricelist[$jednostka_obroncy["statek_sygnatura"]]["attack"]*$bojowa_ob)/100;;
	$jednostka_obroncy["tarcza"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["shield"]+($pricelist[$jednostka_obroncy["statek_sygnatura"]]["shield"]*$tarcza_ob)/100;;
	$jednostka_obroncy["pancerz"]	=1+(1*$pancerz_ob)/100;;
	$jednostka_obroncy["ladownosc"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["capacity"];
	$flota_obronca[]=$jednostka_obroncy;	
	$p1=0;
while ($p1<$jednostka_obroncy["ilosc"])
{
$obronca[]=$jednostka_obroncy;
$p1++;
}	
	}
if($idwroga['gauss_canyon'] > "0"){

	$jednostka_obroncy["stan"]="1";
	$jednostka_obroncy["statek_sygnatura"]="404";
	$jednostka_obroncy["statek_nazwa"]=$polski_flota[$jednostka_obroncy["statek_sygnatura"]];

	$jednostka_obroncy["struktura"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["strukt"];
	$jednostka_obroncy["ilosc"]=$idwroga['gauss_canyon'];
	$jednostka_obroncy["atak"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["attack"]+($pricelist[$jednostka_obroncy["statek_sygnatura"]]["attack"]*$bojowa_ob)/100;;
	$jednostka_obroncy["tarcza"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["shield"]+($pricelist[$jednostka_obroncy["statek_sygnatura"]]["shield"]*$tarcza_ob)/100;;
	$jednostka_obroncy["pancerz"]	=1+(1*$pancerz_ob)/100;;
	$jednostka_obroncy["ladownosc"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["capacity"];
	$flota_obronca[]=$jednostka_obroncy;	
	$p1=0;
while ($p1<$jednostka_obroncy["ilosc"])
{
$obronca[]=$jednostka_obroncy;
$p1++;
}	
	}
if($idwroga['ionic_canyon'] > "0"){

	$jednostka_obroncy["stan"]="1";
	$jednostka_obroncy["statek_sygnatura"]="405";
	$jednostka_obroncy["statek_nazwa"]=$polski_flota[$jednostka_obroncy["statek_sygnatura"]];

	$jednostka_obroncy["struktura"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["strukt"];
	$jednostka_obroncy["ilosc"]=$idwroga['ionic_canyon'];
	$jednostka_obroncy["atak"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["attack"]+($pricelist[$jednostka_obroncy["statek_sygnatura"]]["attack"]*$bojowa_ob)/100;;
	$jednostka_obroncy["tarcza"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["shield"]+($pricelist[$jednostka_obroncy["statek_sygnatura"]]["shield"]*$tarcza_ob)/100;;
	$jednostka_obroncy["pancerz"]	=1+(1*$pancerz_ob)/100;;
	$jednostka_obroncy["ladownosc"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["capacity"];
	$flota_obronca[]=$jednostka_obroncy;	
	
	$p1=0;
while ($p1<$jednostka_obroncy["ilosc"])
{
$obronca[]=$jednostka_obroncy;
$p1++;
}	
	
	}
if($idwroga['buster_canyon'] > "0"){

	$jednostka_obroncy["stan"]="1";
	$jednostka_obroncy["statek_sygnatura"]="406";
	$jednostka_obroncy["statek_nazwa"]=$polski_flota[$jednostka_obroncy["statek_sygnatura"]];

	$jednostka_obroncy["struktura"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["strukt"];
	$jednostka_obroncy["ilosc"]=$idwroga['buster_canyon'];
	$jednostka_obroncy["atak"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["attack"]+($pricelist[$jednostka_obroncy["statek_sygnatura"]]["attack"]*$bojowa_ob)/100;;
	$jednostka_obroncy["tarcza"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["shield"]+($pricelist[$jednostka_obroncy["statek_sygnatura"]]["shield"]*$tarcza_ob)/100;;
	$jednostka_obroncy["pancerz"]	=1+(1*$pancerz_ob)/100;;
	$jednostka_obroncy["ladownosc"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["capacity"];
	$flota_obronca[]=$jednostka_obroncy;	
	$p1=0;
while ($p1<$jednostka_obroncy["ilosc"])
{
$obronca[]=$jednostka_obroncy;
$p1++;
}	
	}
if($idwroga['small_protection_shield'] > "0"){

	$jednostka_obroncy["stan"]="1";
	$jednostka_obroncy["statek_sygnatura"]="407";
	$jednostka_obroncy["statek_nazwa"]=$polski_flota[$jednostka_obroncy["statek_sygnatura"]];

	$jednostka_obroncy["struktura"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["strukt"];
	$jednostka_obroncy["ilosc"]=$idwroga['small_protection_shield'];
	$jednostka_obroncy["atak"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["attack"]+($pricelist[$jednostka_obroncy["statek_sygnatura"]]["attack"]*$bojowa_ob)/100;;
	$jednostka_obroncy["tarcza"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["shield"]+($pricelist[$jednostka_obroncy["statek_sygnatura"]]["shield"]*$tarcza_ob)/100;;
	$jednostka_obroncy["pancerz"]	=1+(1*$pancerz_ob)/100;;
	$jednostka_obroncy["ladownosc"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["capacity"];
	$flota_obronca[]=$jednostka_obroncy;	
	$p1=0;
while ($p1<$jednostka_obroncy["ilosc"])
{
$obronca[]=$jednostka_obroncy;
$p1++;
}	
	}
if($idwroga['big_protection_shield'] > "0"){
	
	$jednostka_obroncy["stan"]="1";
	$jednostka_obroncy["statek_sygnatura"]="408";
	$jednostka_obroncy["statek_nazwa"]=$polski_flota[$jednostka_obroncy["statek_sygnatura"]];

	$jednostka_obroncy["struktura"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["strukt"];
	$jednostka_obroncy["ilosc"]=$idwroga['big_protection_shield'];
	$jednostka_obroncy["atak"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["attack"]+($pricelist[$jednostka_obroncy["statek_sygnatura"]]["attack"]*$bojowa_ob)/100;;
	$jednostka_obroncy["tarcza"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["shield"]+($pricelist[$jednostka_obroncy["statek_sygnatura"]]["shield"]*$tarcza_ob)/100;;
	$jednostka_obroncy["pancerz"]	=1+(1*$pancerz_ob)/100;;
	$jednostka_obroncy["ladownosc"]=$pricelist[$jednostka_obroncy["statek_sygnatura"]]["capacity"];
	$flota_obronca[]=$jednostka_obroncy;	
	$p1=0;
while ($p1<$jednostka_obroncy["ilosc"])
{
$obronca[]=$jednostka_obroncy;
$p1++;
}	
	}	

	
	
	$tresc_raportu=$tresc_raportu."<table border=1 width=100%><tr><td>Tur</td";
	$pom1=0;
	
	while ($pom1<count($flota_obronca))
	{
		
						
		$tresc_raportu=$tresc_raportu."<td>".$flota_obronca[$pom1]["statek_nazwa"]."</td>";
		$pom1++;
	}
	
	
	
	$tresc_raportu=$tresc_raportu."</tr><tr><td>Miktar</td>";
	$pom1=0;
	
	while ($pom1<count($flota_obronca))
	{
		
						
		$tresc_raportu=$tresc_raportu."<td>".$flota_obronca[$pom1]["ilosc"]."</td>";
		$pom1++;
	}

	$tresc_raportu=$tresc_raportu."</tr><tr><td>Silahlanma</td>";
	$pom1=0;
	
	while ($pom1<count($flota_obronca))
	{
		
						
		$tresc_raportu=$tresc_raportu."<td>".$flota_obronca[$pom1]["atak"]."</td>";
		$pom1++;
	}



	$tresc_raportu=$tresc_raportu."</tr><tr><td>Koruma</td>";
	$pom1=0;
	
	while ($pom1<count($flota_obronca))
	{
		
						
		$tresc_raportu=$tresc_raportu."<td>".$flota_obronca[$pom1]["tarcza"]."</td>";
		$pom1++;
	}


	
	

	$tresc_raportu=$tresc_raportu."</tr><tr><td>Zirh</td>";
	$pom1=0;
	
	while ($pom1<count($flota_obronca))
	{
		
						
		$tresc_raportu=$tresc_raportu."<td>".$flota_obronca[$pom1]["pancerz"]."</td>";
		$pom1++;
	}
	
	
	$tresc_raportu=$tresc_raportu."</tr></table>";
	
	//echo("Agresor\n");
	//print_r($agresor);
	//echo("Obronca\n");
	//print_r($obronca);
	
	
	$wielkosc_agresora=count($agresor);
	$wielkosc_ofiary=count($obronca);
	
	$sprawne_obronca=$wielkosc_ofiary;//ile zostalo sprawnych jednostek u ofiary
	$sprawne_agresor=$wielkosc_agresora;//ile zostalo sprawnych jednostek u agresora
	
	$pochloniecie_tarcza_obronca=0;//ile pochlonela tarcza obroncy w rundzie
	$pochloniecie_pancerz_obronca=0;//ile pochlonal panerz obroncy w rundzie
	
	$pochloniecie_tarcza_agresor=0;//ile pochlonela tarcza obroncy w rundzie
	$pochloniecie_pancerz_agresor=0;//ile pochlonal panerz obroncy w rundzie
	
	
	$itr_runda=1;
	
	$ile_rund=3;
print_r($obronca);
	
	while (($itr_runda<$ile_rund)&&($sprawne_obronca!=0)&&($sprawne_agresor!=0))
	{
		
		$kolejka=0;
	$tresc_raportu=$tresc_raportu."Round: ".$itr_runda."<br>";
	
	
	
	
	$strzal_Num=rand(0,$wielkosc_agresora);
	
	$strzal_Num=0;
	
	$strzal_numer=0;
	
	while (($strzal_numer<$wielkosc_agresora)&&($sprawne_obronca>0))
	{
		 $cel_Num=0;
	
		 if ($wielkosc_ofiary!=1)
		 {
		 $cel_Num=rand(0,$wielkosc_ofiary-1); //losowanie do ktorej jednostki wroga teraz strzelamy
		 }
		 
		 
	$kolejka=0;//strzelasz tylko1 raz, zeby ify sie nie pogiely
	
	$strzal=$agresor[$strzal_Num];
	$cel=$obronca[$cel_Num];


	
		
	$tresc_raportu=$tresc_raportu."<br>Amaci : ".$obronca[$cel_Num]["statek_nazwa"]."!!!<br>";
		$tresc_raportu=$tresc_raportu."Ates Acildi.Hedef : ".$strzal["statek_nazwa"]."!!!<br>".$cel_Num."IIIIIII";
		
		
		
	$sila=$strzal["atak"];
	
	if ($sila<$cel["tarcza"]){$obronca[$cel_Num]["tarcza"]=$obronca[$cel_Num]["tarcza"]-$sila; $kolejka=1;
	$pochloniecie_tarcza_obronca=$pochloniecie_tarcza_obronca+$sila;}
	
	
	if (($sila>$cel["tarcza"]) &&($kolejka==0)){
		$sila=$sila-$obronca[$cel_Num]["tarcza"];
		$pochloniecie_tarcza_obronca=$pochloniecie_tarcza_obronca+$obronca[$cel_Num]["tarcza"];//tarcza obroncy pochlonela tyle to altyle
		$obronca[$cel_Num]["tarcza"]="0";
	
		
		
		if ($sila<$cel["pancerz"]){$obronca[$cel_Num]["pancerz"]=$obronca[$cel_Num]["pancerz"]-$sila; $kolejka=1;
		$pochloniecie_pancerz_obronca=$pochloniecie_pancerz_obronca+$sila;}
	
	
		if (($sila>$cel["pancerz"]) &&($kolejka==0)){
		$sila=$sila-$obronca[$cel_Num]["pancerz"];
		


if ($cel["stan"]!=1)
		{

		$tresc_raportu=$tresc_raportu."Ateslenen Fuze Amacina Ulasamadi!!!: ".$obronca[$cel_Num]["statek_nazwa"]."<br>";
		}




		if ($cel["stan"]==1){
		$pochloniecie_pancerz_obronca=$pochloniecie_pancerz_obronca+$obronca[$cel_Num]["pancerz"];
		$obronca[$cel_Num]["pancerz"]="0";	
		$tresc_raportu=$tresc_raportu."Unite Yok Edildi!!!: ".$obronca[$cel_Num]["statek_nazwa"]."<br>";
		$obronca[$cel_Num]["stan"]=0;
		$sprawne_obronca--;}
		
		
		}
		
		
		
}$strzal_numer++;}


	if ($sprawne_obronca==0) ($tresc_raportu=$tresc_raportu."<br>Saldirilan Yok Edildi!!!<br>");
	
	
	$tresc_raportu=$tresc_raportu."<br>Saldirilanin Defansi: ".$pochloniecie_tarcza_obronca."Puan <br>";
	$tresc_raportu=$tresc_raportu."<br>Saldirilanin Zirhi: ".$pochloniecie_pancerz_obronca."Puan <br>";
	
	
	$strzal_numer=0;
	
	
	while (($strzal_numer<$wielkosc_ofiary)&&($sprawne_agresor>0)&&($sprawne_obronca>0))
	{
	$cel_Num=rand(0,$wielkosc_agresora-1); //losowanie do ktorej jednostki agresora teraz strzelamy
	
	
	 $cel_Num=0;
	
		 if ($wielkosc_ofiary!=1)
		 {
		 $cel_Num=rand(0,$wielkosc_agresora-1); //losowanie do ktorej jednostki wroga teraz strzelamy
		 }
		 
	
	$kolejka=0;//strzelasz tylko1 raz, zeby ify sie nie pogiely
	
	$strzal=$obronca[$strzal_numer];
	$cel=$agresor[$cel_Num];
	
		
	$tresc_raportu=$tresc_raportu."<br>Amac : ".$agresor[$cel_Num]["statek_nazwa"]."!!!<br>";
		$tresc_raportu=$tresc_raportu."Ates Acildi.Hedef : ".$strzal["statek_nazwa"]."!!!<br>";
		
		
		
	$sila=$strzal["atak"];
	
	if ($sila<$cel["tarcza"]){$agresor[$cel_Num]["tarcza"]=$agresor[$cel_Num]["tarcza"]-$sila; $kolejka=1;
	$agresor[$cel_Num]["tarcza"]=$agresor[$cel_Num]["tarcza"]+$sila;}
	
	
	if (($sila>$cel["tarcza"]) &&($kolejka==0)){
		$sila=$sila-$agresor[$cel_Num]["tarcza"];
		$pochloniecie_tarcza_agresor=$pochloniecie_tarcza_agresor+$agresor[$cel_Num]["tarcza"];//tarcza obroncy pochlonela tyle to altyle
		$agresor[$cel_Num]["tarcza"]="0";
	
		
		
		if ($sila<$cel["pancerz"]){$agresor[$cel_Num]["pancerz"]=$agresor[$cel_Num]["pancerz"]-$sila; $kolejka=1;
		$pochloniecie_pancerz_agresor=$pochloniecie_pancerz_agresor+$sila;}
	
	
		if (($sila>$cel["pancerz"]) &&($kolejka==0)){
		$sila=$sila-$agresor[$cel_Num]["pancerz"];
		
		$pochloniecie_pancerz_agresor=$pochloniecie_pancerz_agresor+$obronca[$cel_Num]["pancerz"];
		$agresor[$cel_Num]["pancerz"]="0";	
		$tresc_raportu=$tresc_raportu."Hedef Yok Edildi!!!: ".$agresor[$cel_Num]["statek_nazwa"]."<br>";
		$agresor[$cel_Num]["stan"]=0;
		$sprawne_agresor--;
		}
		
		
		
}$strzal_numer++;}


	if ($sprawne_agresor==0) ($tresc_raportu=$tresc_raportu."<br>Saldirgan Yok Edildi!!!<br>");
	
	
	$tresc_raportu=$tresc_raportu."<br>Saldirganin Defansi: ".$pochloniecie_tarcza_agresor." Puan <br>";
 	$tresc_raportu=$tresc_raportu."<br>Saldirganin Zirhi: ".$pochloniecie_pancerz_agresor." Puan <br>";
$itr_runda++;
 	}
	
	
	
	
doquery("INSERT INTO {{table}} SET
                     `message_owner`='{$f['fleet_owner']}',
                     `message_sender`='Server',
                     `message_time`='".time()."',
                     `message_type`='0',
                     `message_from`='Fleet Leader',
                     `message_subject`='Savas Raporu',
                     `message_text`='$tresc_raportu'"                   ,'messages'); 


doquery("UPDATE {{table}} SET fleet_mess='1' WHERE fleet_id=".$f["fleet_id"],'fleets');
 

doquery("UPDATE {{table}} SET new_message=new_message+1 WHERE id='{$f['fleet_owner']}'",'users');      
}}  

			//
			//--[3:Transportar]--------------------------------------------------
			//
			case 3:{ //bug...
				//ARGHH!!! ok, transportar implica enviar solo recursos y volver.
				//no es necesario revisar la flota.
				//comprobamos el primer viaje :)
//					$metal=$f['fleet_resource_metal'];
//					$cristal=$f['fleet_resource_crystal'];
//					$deuterium=$f['fleet_resource_deuterium'];


				if($f['fleet_start_time']<=time()){
					doquery("UPDATE {{table}} SET
						metal=metal+{$f['fleet_resource_metal']},
						crystal=crystal+{$f['fleet_resource_crystal']},
						deuterium=deuterium+{$f['fleet_resource_deuterium']}
						WHERE galaxy = {$f['fleet_end_galaxy']} AND
						system = {$f['fleet_end_system']} AND
						planet = {$f['fleet_end_planet']}
						LIMIT 1 ;",'planets');
					doquery("UPDATE {{table}} SET
						fleet_resource_metal=0,fleet_resource_crystal=0,fleet_resource_deuterium=0
						WHERE fleet_id = {$f['fleet_id']}
						LIMIT 1 ;",'fleets'
					);
					//en caso de que ya haya pasado el tiempo. 
					if($f['fleet_end_time']<=time()){
						$fleet = explode(";",$f['fleet_array']);
						//preparamos el array
						foreach($fleet as $a =>$b){
							if($b != ''){
								$a = explode(",",$b);
								$fquery .= "{$resource[$a[0]]}={$resource[$a[0]]} + {$a[1]}, \n";
							}
						}
						doquery("DELETE FROM {{table}} WHERE fleet_id=".$f["fleet_id"],'fleets');
						//ahora el planeta se le suman los recursos
						doquery("UPDATE {{table}} SET
							$fquery
							metal=metal,
							crystal=crystal,
							deuterium=deuterium
							WHERE galaxy = {$f['fleet_start_galaxy']} AND
							system = {$f['fleet_start_system']} AND
							planet = {$f['fleet_start_planet']}
							LIMIT 1 ;",'planets'
						);
					}
				}
				break;}
			//
			//--[4:Desplazar:Stacjonuj]--------------------------------------------------
			//
			case 4:{
				// Desplazar -finesh... talvez
///				$fleet = explode("Â¥rÂ¥n",$f['fleet_array']);
				//preparamos el array
				

//				echo"{$f['fleet_resource_crystal']}<BR>{$f['fleet_resource_metal']}<BR>{$f['fleet_resource_deuterium']}";
				//This work perfectly! i'm a genie! :3
				if($f['fleet_start_time']<=time()){
					$fleet = explode(";",$f['fleet_array']);
						//preparamos el array
					foreach($fleet as $a =>$b){
						if($b != ''){
						$a = explode(",",$b);
					$fquery .= "{$resource[$a[0]]}={$resource[$a[0]]} + {$a[1]}, \n";
							}
						}
					doquery("DELETE FROM {{table}} WHERE fleet_id=".$f["fleet_id"],'fleets');
					doquery("UPDATE {{table}} SET
						$fquery
						metal=metal+{$f['fleet_resource_metal']},
						crystal=crystal+{$f['fleet_resource_crystal']},
						deuterium=deuterium+{$f['fleet_resource_deuterium']}
						WHERE galaxy = {$f['fleet_end_galaxy']} AND
						system = {$f['fleet_end_system']} AND
						planet = {$f['fleet_end_planet']}
						LIMIT 1 ;",'planets'
					);
					
				}else{
					
					doquery("DELETE FROM {{table}} WHERE fleet_id=".$f["fleet_id"],'fleets');
					doquery("UPDATE {{table}} SET
						$fquery
						metal=metal+{$f['fleet_resource_metal']},
						crystal=crystal+{$f['fleet_resource_crystal']},
						deuterium=deuterium+{$f['fleet_resource_deuterium']}
						WHERE galaxy = {$f['fleet_start_galaxy']} AND
						system = {$f['fleet_start_system']} AND
						planet = {$f['fleet_start_planet']}
						LIMIT 1 ;","planets"
					);
				}
				
				break;}
			//
			//--[5:Destruir]--------------------------------------------------
			//
			case 5:
			//
			//--[6:Espiar]--------------------------------------------------
			//
			case 6:{
				if($f['fleet_start_time']<=time()){
				$szpiegja=doquery("SELECT * FROM {{table}} WHERE id={$f['fleet_owner']}",'users',true);
				$idwroga =doquery("SELECT * FROM {{table}} WHERE galaxy={$f['fleet_end_galaxy']} AND system={$f['fleet_end_system']} AND planet={$f['fleet_end_planet']}",'planets',true);
				$messmoja =doquery("SELECT * FROM {{table}} WHERE galaxy={$f['fleet_start_galaxy']} AND system={$f['fleet_start_system']} AND planet={$f['fleet_start_planet']}",'planets',true);
		    		$szpieg=$szpiegja['spy_tech'];
				$idwrog=$idwroga['id_owner'];
				$szpiegwrog=doquery("SELECT * FROM {{table}} WHERE id={$idwrog}",'users',true);
				$szpiegwroga=$szpiegwrog['spy_tech'];
				$pozT = $szpieg;
				$pozW = $szpiegwroga;
//				$LS = 1;
				$fleet = explode(";",$f['fleet_array']);
				foreach($fleet as $a => $b){
					if($b != ''){
					$a = explode(",",$b);
					    $fquery .= "{$resource[$a[0]]}={$resource[$a[0]]} + {$a[1]}, \n";
					{
					if ($a[0] == "210")
					{
					$LS = $a[1];
				
//$all="<table width=400><tr><td class=c colspan=4> Hammaddeler {$idwroga['name']}[{$idwroga['galaxy']}:{$idwroga['system']}:{$idwroga['planet']}]".gmdate("d-m-Y H:i:s",time())."</td></tr>";
$surka="<table width=400><tr><td class=c colspan=4> Hammaddeler {$idwroga['name']}[{$idwroga['galaxy']}:{$idwroga['system']}:{$idwroga['planet']}]".gmdate("d-m-Y H:i:s",time())."</td></tr><tr><td>Metal:</td><td>".pretty_number($idwroga['metal'])."</td><td>Crystal:</td><td>".pretty_number($idwroga['crystal'])."</td></tr> <tr><td>Deuter:</td><td>".pretty_number($idwroga['deuterium'])."</td> <td>Energia:</td><td>".pretty_number($idwroga['energy_max'])."</td></tr> </table>";

if($idwroga['small_ship_cargo'] > "0"){$mt="<td>Kucuk Tasima Gemisi</td><td>{$idwroga['small_ship_cargo']}</td>";}
if($idwroga['big_ship_cargo'] > "0"){$dt="<td>Buyuk Tasima Gemisi</td><td>{$idwroga['big_ship_cargo']}</td></tr>";}
if($idwroga['light_hunter'] > "0"){$lm="<td>Hafif Avci</td><td>{$idwroga['light_hunter']}</td>";}
if($idwroga['heavy_hunter'] > "0"){$cm="<td>Agir Avci</td><td>{$idwroga['heavy_hunter']}</td></tr>";}
if($idwroga['crusher'] > "0"){$kr="<td>Kruvazor</td><td>{$idwroga['crusher']}</td>";}
if($idwroga['battle_ship'] > "0"){$ow="<td>Komuta Gemisi</td><td>{$idwroga['battle_ship']}</td></tr>";}
if($idwroga['colonizer'] > "0"){$colon="<td>Koloni Gemisi</td><td>{$idwroga['colonizer']}</td>";}
if($idwroga['recycler'] > "0"){$recek="<td>Geri Donusumcu</td><td>{$idwroga['recycler']}</td></tr>";}
if($idwroga['spy_sonde'] > "0"){$spysonda="<td>Casus Gemisi</td><td>{$idwroga['spy_sonde']}</td>";}
if($idwroga['bomber_ship'] > "0"){$bombo="<td>Bombardiman Gemisi</td><td>{$idwroga['bomber_ship']}</td></tr>";}
if($idwroga['solar_satelit'] > "0"){$satki="<td>Solar Uydu</td><td>{$idwroga['solar_satelit']}</td>";}
if($idwroga['destructor'] > "0"){$niszcz="<td>Muhrip</td><td>{$idwroga['destructor']}</td></tr>";}
if($idwroga['dearth_star'] > "0"){$gwiazdeczka="<td>Olum Yildizi</td><td>{$idwroga['dearth_star']}</td>";}
if($idwroga['battle_ship'] > "0"){$panc="<td>Savas Gemisi</td><td>{$idwroga['battle_ship']}</td></tr>";}
//if($idwroga['silo'] > "0"){$silos="<td>Firkateyn</td><td>{$idwroga['silo']}</td></tr>";}

$floty="<table width=400><tr><td class=c colspan=4> Hammaddeler {$idwroga['name']}[{$idwroga['galaxy']}:{$idwroga['system']}:{$idwroga['planet']}]".gmdate("d-m-Y H:i:s",time())."</td></tr><tr><td>Metal:</td><td>".pretty_number($idwroga['metal'])."</td><td>Crystal:</td><td>".pretty_number($idwroga['crystal'])."</td></tr> <tr><td>Deuter:</td><td>".pretty_number($idwroga['deuterium'])."</td> <td>Eneji:</td><td>".pretty_number($idwroga['energy_max'])."</td></tr> </table><table width=400><tr><td class=c colspan=6>Floty</td></tr>$mt$dt$lm$cm$kr$ow$colon$recek$spysonda$bombo$satki$niszcz$gwiazdeczka$panc </table>";

if($idwroga['misil_launcher'] > "0"){$ml="<td>Roketatar</td><td>{$idwroga['misil_launcher']}</td>";}
if($idwroga['small_laser'] > "0"){$sl="<td>Kucuk Lazer</td><td>{$idwroga['small_laser']}</td></tr>";}
if($idwroga['big_laser'] > "0"){$bl="<td>Buyuk Lazer</td><td>{$idwroga['big_laser']}</td>";}
if($idwroga['gauss_canyon'] > "0"){$gauss="<td>Gauss Topu</td><td>{$idwroga['gauss_canyon']}</td></tr>";}
if($idwroga['ionic_canyon'] > "0"){$ionic="<td>Iyon Topu</td><td>{$idwroga['ionic_canyon']}</td>";}
if($idwroga['buster_canyon'] > "0"){$buster="<td>Plazma Silahi</td><td>{$idwroga['buster_canyon']}</td></tr>";}
if($idwroga['small_protection_shield'] > "0"){$mp="<td>Kucuk Koruma</td><td>{$idwroga['small_protection_shield']}</td>";}
if($idwroga['big_protection_shield'] > "0"){$dp="<td>Buyuk Koruma</td><td>{$idwroga['big_protection_shield']}</td>";}


$obrona="<table width=400><tr><td class=c colspan=4> Hammaddeler {$idwroga['name']}[{$idwroga['galaxy']}:{$idwroga['system']}:{$idwroga['planet']}]".gmdate("d-m-Y H:i:s",time())."</td></tr><tr><td>Metal:</td><td>".pretty_number($idwroga['metal'])."</td><td>Kryszta³:</td><td>".pretty_number($idwroga['crystal'])."</td></tr> <tr><td>Deuter:</td><td>".pretty_number($idwroga['deuterium'])."</td> <td>Energia:</td><td>".pretty_number($idwroga['energy_max'])."</td></tr> </table><table width=400><tr><td class=c colspan=6>Floty</td></tr>$mt$dt$lm$cm$kr$ow$colon$recek$spysonda$bombo$satki$niszcz$gwiazdeczka$panc </table> <table width=400><tr><td class=c colspan=4>Obrona</td></tr>$ml$sl$bl$gauss$ionic$buster$mp$dp </table>";

if($idwroga['metal_mine'] > "0"){$kop_metal="<td>Metal Madeni</td><td>{$idwroga['metal_mine']}</td>";}
if($idwroga['crystal_mine'] > "0"){$kop_krysia="<td>Crystal Madeni</td><td>{$idwroga['crystal_mine']}</td>";}
if($idwroga['deuterium_sintetizer'] > "0"){$kop_deut="<td>Deuter Sentezleyici</td><td>{$idwroga['deuterium_sintetizer']}</td></tr>";}
if($idwroga['solar_plant'] > "0"){$solar="<td>Solar Enerrji Santari</td><td>{$idwroga['solar_plant']}</td>";}
if($idwroga['fusion_plant'] > "0"){$fusion="<td>Elektrownia Fuzyjna</td><td>{$idwroga['fusion_plant']}</td>";}
if($idwroga['robot_factory'] > "0"){$robot="<td>Robot Fabrikasi</td><td>{$idwroga['robot_factory']}</td></tr>";}
if($idwroga['nano_factory'] > "0"){$nano="<td>Nanit Fabrikasi</td><td>{$idwroga['nano_factory']}</td>";}
if($idwroga['hangar'] > "0"){$stocznia="<td>Tersane</td><td>{$idwroga['hangar']}</td>";}
if($idwroga['metal_store'] > "0"){$mag_mety="<td>Metal Deposu</td><td>{$idwroga['metal_store']}</td></tr>";}
if($idwroga['crystal_store'] > "0"){$mag_krysi="<td>Crystal Deposu</td><td>{$idwroga['crystal_store']}</td>";}
if($idwroga['deuterium_store'] > "0"){$mag_deut="<td>Deuter Deposu</td><td>{$idwroga['deuterium_store']}</td>";}
if($idwroga['laboratory'] > "0"){$lab="<td>Laboratuar</td><td>{$idwroga['laboratory']}</td></tr>";}
if($idwroga['terraformer'] > "0"){$tetra="<td>Terraformer</td><td>{$idwroga['terraformer']}</td>";}
if($idwroga['ally_deposit'] > "0"){$allydepo="<td>Ittifak Deposu</td><td>{$idwroga['ally_deposit']}</td>";}
if($idwroga['silo'] > "0"){$silos="<td>Firkateyn</td><td>{$idwroga['silo']}</td></tr>";}

$budynki="<table width=400><tr><td class=c colspan=4> Hammaddeler {$idwroga['name']}[{$idwroga['galaxy']}:{$idwroga['system']}:{$idwroga['planet']}]".gmdate("d-m-Y H:i:s",time())."</td></tr><tr><td>Metal:</td><td>".pretty_number($idwroga['metal'])."</td><td>Crystal:</td><td>".pretty_number($idwroga['crystal'])."</td></tr> <tr><td>Deuter:</td><td>".pretty_number($idwroga['deuterium'])."</td> <td>Energia:</td><td>".pretty_number($idwroga['energy_max'])."</td></tr> </table><table width=400><tr><td class=c colspan=6>Filo</td></tr>$mt$dt$lm$cm$kr$ow$colon$recek$spysonda$bombo$satki$niszcz$gwiazdeczka$panc </table> <table width=400><tr><td class=c colspan=4>Korunma</td></tr>$ml$sl$bl$gauss$ionic$buster$mp$dp </table> <table width=400><tr><td class=c colspan=6>Binalar</td></tr></tr>$kop_metal$kop_krysia$kop_deut$solar$fusion$robot$nano$stocznia$mag_mety$mag_krysi$mag_deut$lab$tetra$allydepo$silos</table>";

if($szpiegwrog['spy_tech'] > "0"){$spy_tech="<td>Casus Teknolojisi</td><td>{$szpiegwrog['spy_tech']}</td>";}
if($szpiegwrog['computer_tech'] > "0"){$pc_tech="<td>Bilgisayar Teknolojisi</td><td>{$szpiegwrog['computer_tech']}</td></tr>";}
if($szpiegwrog['military_tech'] > "0"){$boj_tech="<td>Silah Teknigi</td><td>{$szpiegwrog['military_tech']}</td>";}
if($szpiegwrog['defence_tech'] > "0"){$obr_tech="<td>Defans Teknigi</td><td>{$szpiegwrog['defence_tech']}</td></tr>";}
if($szpiegwrog['shield_tech'] > "0"){$op_tech="<td>Zirhlanma</td><td>{$szpiegwrog['shield_tech']}</td>";}
if($szpiegwrog['energy_tech'] > "0"){$ene_tech="<td>Enerji Teknigi</td><td>{$szpiegwrog['energy_tech']}</td></tr>";}
if($szpiegwrog['hyperspace_tech'] > "0"){$nadp_tech="<td>Hiperuzay Teknigi</td><td>{$szpiegwrog['hyperspace_tech']}</td>";}
if($szpiegwrog['combustion_tech'] > "0"){$spal_tech="<td>Motor Enerjisi Teknigi</td><td>{$szpiegwrog['combustion_tech']}</td></tr>";}
if($szpiegwrog['impulse_motor_tech'] > "0"){$imp_tech="<td>Yanmali Motor Takimi</td><td>{$szpiegwrog['impulse_motor_tech']}</td>";}
if($szpiegwrog['hyperspace_motor_tech'] > "0"){$napna_tech="<td>Hiperuzay iticisi</td><td>{$szpiegwrog['hyperspace_motor_tech']}</td></tr>";}
if($szpiegwrog['laser_tech'] > "0"){$las_tech="<td>Lazer Teknigi</td><td>{$szpiegwrog['laser_tech']}</td>";}
if($szpiegwrog['ionic_tech'] > "0"){$jon_tech="<td>Iyon Teknigi</td><td>{$szpiegwrog['ionic_tech']}</td></tr>";}
if($szpiegwrog['buster_tech'] > "0"){$plaz_tech="<td>Plazma Teknigi</td><td>{$szpiegwrog['buster_tech']}</td>";}
if($szpiegwrog['intergalactic_tech'] > "0"){$msbn_tech="<td>Galaksiler Arasi Arastirma</td><td>{$szpiegwrog['intergalactic_tech']}</td></tr>";}
if($szpiegwrog['graviton_tech'] > "0"){$gra_tech="<td>Gravitasyon Tekngi</td><td>{$szpiegwrog['graviton_tech']}</td>";}

$badania="<table width=400><tr><td class=c colspan=4> Hammaddeler {$idwroga['name']}[{$idwroga['galaxy']}:{$idwroga['system']}:{$idwroga['planet']}]".gmdate("d-m-Y H:i:s",time())."</td></tr><tr><td>Metal:</td><td>".pretty_number($idwroga['metal'])."</td><td>Crystal:</td><td>".pretty_number($idwroga['crystal'])."</td></tr> <tr><td>Deuter:</td><td>".pretty_number($idwroga['deuterium'])."</td> <td>Energia:</td><td>".pretty_number($idwroga['energy_max'])."</td></tr> </table><table width=400><tr><td class=c colspan=6>Filo</td></tr>$mt$dt$lm$cm$kr$ow$colon$recek$spysonda$bombo$satki$niszcz$gwiazdeczka$panc </table> <table width=400><tr><td class=c colspan=4>Obrona</td></tr>$ml$sl$bl$gauss$ionic$buster$mp$dp </table> <table width=400><tr><td class=c colspan=6>Binalar</td></tr></tr>$kop_metal$kop_krysia$kop_deut$solar$fusion$robot$nano$stocznia$mag_mety$mag_krysi$mag_deut$lab$tetra$allydepo$silos</table><table width=400><tr><td class=c colspan=4>Arastirma   </td></tr></tr>$spy_tech$pc_tech$boj_tech$obr_tech$op_tech$ene_tech$nadp_tech$spal_tech$imp_tech$napna_tech$las_tech$jon_tech$plaz_tech$msbn_tech$gra_tech</table>";
$szansa=" <center> Uzay Sondajlarini Ele Gecirme Sansi:0%</center> </td> </tr>";


$pT = ($pozW - $pozT);
$pW = ($pozT - $pozW);
if ($pozW > $pozT)
{
$ST = ($LS - pow($pT,2));
}
if ($pozT > $pozW)
{
$ST = ($LS + pow($pW,2));
}
if ($pozW == $pozT)
{
$ST = "$pozT";
}
if ($ST <= "1")
{
doquery("INSERT INTO {{table}} SET
                     `message_owner`='{$f['fleet_owner']}',
                     `message_sender`='',
                     `message_time`='".time()."',
                     `message_type`='0',
                     `message_from`='Fleet Leader',
                     `message_subject`='Casusluk Raporu',
                     `message_text`='$surka'"
                     ,'messages');              
doquery("UPDATE {{table}} SET new_message=new_message+1 WHERE id='{$f['fleet_owner']}'",'users'); 
doquery("INSERT INTO {{table}} SET
                     `message_owner`='{$idwrog}',
                     `message_sender`='',
                     `message_time`='".time()."',
                     `message_type`='0',
                     `message_from`='Fleet Leader',
                     `message_subject`='Yabanci Filo Casusluk Yapiyor',
                     `message_text`='{$messmoja['name']} gezegeninden gelen filo {$idwroga['name']} dogru gidiyor'"
                     ,'messages');              
doquery("UPDATE {{table}} SET new_message=new_message+1 WHERE id='{$idwrog}'",'users'); 
doquery("UPDATE {{table}} SET fleet_mess='1' WHERE fleet_id=".$f["fleet_id"],'fleets');
}
if ($ST == "2")
{

doquery("INSERT INTO {{table}} SET
                     `message_owner`='{$f['fleet_owner']}',
                     `message_sender`='',
                     `message_time`='".time()."',
                     `message_type`='0',
                     `message_from`='Fleet Leader',
                     `message_subject`='Casus Raporu',
                     `message_text`='$flota'"
                     ,'messages');              
doquery("UPDATE {{table}} SET new_message=new_message+1 WHERE id='{$f['fleet_owner']}'",'users'); 
doquery("INSERT INTO {{table}} SET
                     `message_owner`='{$idwrog}',
                     `message_sender`='',
                     `message_time`='".time()."',
                     `message_type`='0',
                     `message_from`='Dowództwo floty',
                     `message_subject`='Obca Flota (szpiegowanie)',
                     `message_text`='{$messmoja['name']} gezegeninden gelen filo {$idwroga['name']} dogru gidiyor'"
                     ,'messages');              
doquery("UPDATE {{table}} SET new_message=new_message+1 WHERE id='{$idwrog}'",'users'); 
doquery("UPDATE {{table}} SET fleet_mess='1' WHERE fleet_id=".$f["fleet_id"],'fleets');
}
if ($ST == "4" or $ST == "3")
{
doquery("INSERT INTO {{table}} SET
                     `message_owner`='{$f['fleet_owner']}',
                     `message_sender`='',
                     `message_time`='".time()."',
                     `message_type`='0',
                     `message_from`='Fleet Leader',
                     `message_subject`='Casusluk Raporu',
                     `message_text`='$obrona'"
                     ,'messages');              
doquery("UPDATE {{table}} SET new_message=new_message+1 WHERE id='{$f['fleet_owner']}'",'users'); 
doquery("INSERT INTO {{table}} SET
                     `message_owner`='{$idwrog}',
                     `message_sender`='',
                     `message_time`='".time()."',
                     `message_type`='0',
                     `message_from`='Fleet Leader',
                     `message_subject`='Yabanci Filo Casusluk Yapiyor',
                     `message_text`='{$messmoja['name']} gezegeninden felen filo {$idwroga['name']} dogru gidiyor'"
                     ,'messages');              
doquery("UPDATE {{table}} SET new_message=new_message+1 WHERE id='{$idwrog}'",'users'); 
doquery("UPDATE {{table}} SET fleet_mess='1' WHERE fleet_id=".$f["fleet_id"],'fleets');
}
if ($ST == "5" or $ST == "6")
{
doquery("INSERT INTO {{table}} SET
                     `message_owner`='{$f['fleet_owner']}',
                     `message_sender`='',
                     `message_time`='".time()."',
                     `message_type`='0',
                     `message_from`='Dowództwo floty',
                     `message_subject`='Raport Szpiegowski',
                     `message_text`='$budynki'"
                     ,'messages');              
doquery("UPDATE {{table}} SET new_message=new_message+1 WHERE id='{$f['fleet_owner']}'",'users'); 
doquery("INSERT INTO {{table}} SET
                     `message_owner`='{$idwrog}',
                     `message_sender`='',
                     `message_time`='".time()."',
                     `message_type`='0',
                     `message_from`='Fleet Leader',
                     `message_subject`='Yabanci Filo Casusluk Yapiyor',
                     `message_text`='{$messmoja['name']} gezegeninden gelen filo {$idwroga['name']} ya dogru gidiyor'"
                     ,'messages');              
doquery("UPDATE {{table}} SET new_message=new_message+1 WHERE id='{$idwrog}'",'users'); 
doquery("UPDATE {{table}} SET fleet_mess='1' WHERE fleet_id=".$f["fleet_id"],'fleets');
}
if ($ST >= "7")
{
doquery("INSERT INTO {{table}} SET
                     `message_owner`='{$f['fleet_owner']}',
                     `message_sender`='',
                     `message_time`='".time()."',
                     `message_type`='0',
                     `message_from`='Fleet Leader',
                     `message_subject`='Casus Raporu',
                     `message_text`='$badania'"
                     ,'messages');              
doquery("UPDATE {{table}} SET new_message=new_message+1 WHERE id='{$f['fleet_owner']}'",'users'); 
doquery("INSERT INTO {{table}} SET
                     `message_owner`='{$idwrog}',
                     `message_sender`='',
                     `message_time`='".time()."',
                     `message_type`='0',
                     `message_from`='Fleet Leader',
                     `message_subject`='Yabanci Filo Casusluk Yapiyor',
                     `message_text`='{$messmoja['name']} Gezegeninden gelen filo {$idwroga['name']} ya doru gidiyor'"
                     ,'messages');              
doquery("UPDATE {{table}} SET new_message=new_message+1 WHERE id='{$idwrog}'",'users'); 
doquery("UPDATE {{table}} SET fleet_mess='1' WHERE fleet_id=".$f["fleet_id"],'fleets');

}
//echo $rapT;
}
			}}
else{
						doquery("UPDATE {{table}} SET
							$fquery
							metal=metal+{$f['fleet_resource_metal']},
							crystal=crystal+{$f['fleet_resource_crystal']},
							deuterium=deuterium+{$f['fleet_resource_deuterium']}
							WHERE galaxy = {$f['fleet_start_galaxy']} AND
							system = {$f['fleet_start_system']} AND
							planet = {$f['fleet_start_planet']}
							LIMIT 1 ;",'planets');

						doquery("DELETE FROM {{table}} WHERE fleet_id=".$f["fleet_id"],'fleets');

}
}}
			break;}
			
			//
			//--[7:Posicionar flota]--------------------------------------------------
			//
			case 7:
			//
			//--[8:Reciclar]--------------------------------------------------
			//
			case 8:
			//
			//--[9:Colonizar]-----------------------------------------------
			//
			case 9:
				
				
$limit_planet=9;
$ilosc=mysql_result(doquery("SELECT count(208) FROM {{table}} WHERE id_owner='{$f['fleet_owner']}'",'planets'),0);
if($ilosc>=$limit_planet){
doquery("INSERT INTO {{table}} SET
                     `message_owner`='{$f['fleet_owner']}',
                     `message_sender`='',
                     `message_time`='".time()."',
                     `message_type`='0',
                     `message_from`='Dowództwo floty',
                     `message_subject`='Koloni',
                     `message_text`='Zaten 9 Gezegen Var Daha Fazla Kolonilesemessiniz
                     ,'messages'); 
 query("UPDATE {{table}} SET new_message=new_message+1 WHERE id='{$f['fleet_owner']}'",'users');  }else
 if(make_planet($f['fleet_end_galaxy'],$f['fleet_end_system'],$f['fleet_end_planet'],$f['fleet_owner']))
					{
		//query para agregar un mensaje
			doquery("INSERT INTO {{table}} SET 
				`message_owner`='{$f['fleet_owner']}',
				`message_sender`='Filo Lider',
				`message_time`='".time()."',
				`message_type`='0',
				`message_from`='Filo Lider',
				`message_subject`='Koloni',
				`message_text`='Gezegen kolonilesti'"
				,'messages');
					}else{echo "error";}
					/*doquery("DELETE FROM {{table}} WHERE fleet_id=".$f["fleet_id"],'fleets');
					doquery("UPDATE {{table}} SET
						$fquery
						metal=metal+{$f['fleet_resource_metal']},
						crystal=crystal+{$f['fleet_resource_crystal']},
						deuterium=deuterium+{$f['fleet_resource_deuterium']}
						WHERE galaxy = {} AND
						system = {} AND
						planet = {}
						LIMIT 1 ;","planets"
					);*/
					
				/*}else{
					
					doquery("DELETE FROM {{table}} WHERE fleet_id=".$f["fleet_id"],'fleets');
					doquery("UPDATE {{table}} SET
						$fquery
						metal=metal+{$f['fleet_resource_metal']},
						crystal=crystal+{$f['fleet_resource_crystal']},
						deuterium=deuterium+{$f['fleet_resource_deuterium']}
						WHERE galaxy = {$f['fleet_start_galaxy']} AND
						system = {$f['fleet_start_system']} AND
						planet = {$f['fleet_start_planet']}
						LIMIT 1 ;","planets"
					);
				}*/
				
				
			default:
			//como parte final. se elimina la entrada.
			//esto es solo para saber si esta bien aplicada la teoria...
			doquery("DELETE FROM {{table}} WHERE fleet_id=".$f["fleet_id"],'fleets');

			
		}
	}

}
function get_max_field(&$planet){
return $planet["field_max"]+($planet["terraformer"]*5);
} 
?>
