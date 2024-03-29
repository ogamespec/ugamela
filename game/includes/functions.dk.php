<?php  //functions.php
function add_points($resources,$userid){
return false;}
function remove_points($resources,$userid){
return false;}
function check_user(){
$row = checkcookies();
if($row != false){
global $user;
$user = $row;
return true;}
return false;}
function get_userdata(){
echo "pendiente";}
function is_email($email){
return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|Num|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i",$email));}
function checkcookies(){
global $lang,$game_config,$ugamela_root_path,$phpEx;
includeLang('cookies');
include($ugamela_root_path.'config.'.$phpEx);
$row = false;
if (isset($_COOKIE[$game_config['COOKIE_NAME']])){
$theuser = explode(" ",$_COOKIE[$game_config['COOKIE_NAME']]);
$query = doquery("SELECT * FROM {{table}} WHERE username='{$theuser[1]}'", "users");
if (mysql_num_rows($query) != 1){
message($lang['cookies']['Error1']);}
$row = mysql_fetch_array($query);
if ($row["id"] != $theuser[0]){
message($lang['cookies']['Error2']);}
if (md5($row["password"]."--".$dbsettings["secretword"]) !== $theuser[2]){
message($lang['cookies']['Error3']);}
$newcookie = implode(" ",$theuser);
if($theuser[3] == 1){ $expiretime = time()+31536000;}else{ $expiretime = 0;}
setcookie ($game_config['COOKIE_NAME'], $newcookie, $expiretime, "/", "", 0);
doquery("UPDATE {{table}} SET onlinetime=".time().", user_lastip='{$_SERVER['REMOTE_ADDR']}' WHERE id='{$theuser[0]}' LIMIT 1", "users");}
unset($dbsettings);
return $row;
}

function parsetemplate($template, $array){

	foreach($array as $a => $b) {
		$template = str_replace("{{$a}}", $b, $template);
	}
	return $template;
}
function gettemplate($templatename){ 
	global $ugamela_root_path;

	$filename =  $ugamela_root_path . TEMPLATE_DIR . TEMPLATE_NAME . '/' . $templatename . ".tpl";
	return ReadFromFile($filename);
	
}

function includeLang($filename,$ext='.mo'){
	global $ugamela_root_path,$lang;

	include($ugamela_root_path."language/".DEFAULT_LANG.'/'.$filename.$ext);

}

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
	$day = floor($seconds / (24*3600));
	$hs = floor($seconds / 3600 % 24);
	$min = floor($seconds  / 60 % 60);
	$seg = floor($seconds / 1 % 60);
	
	$time = '';
	if($day != 0){ $time .= $day.'d ';}
	if($hs != 0){ $time .= $hs.'h ';}
	if($min != 0){ $time .= $min.'m ';}
	$time .= $seg.'s';
	
	return $time;
}

function pretty_time_hour($seconds){
	$min = floor($seconds  / 60 % 60);

	$time = '';
	
	if($min != 0){ $time .= $min.'min ';}
	return $time;
}

function echo_topnav(){

	global $user, $planetrow, $galaxyrow,$mode,$messageziel,$gid,$lang;


	if(!$user){return;}
	if(!$planetrow){ $planetrow = doquery("SELECT * FROM {{table}} WHERE id ={$user['current_planet']}","planets",true);}
	calculate_resources_planet($planetrow);
	$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];

	$parse = $lang;
	$parse['dpath'] = $dpath;
	$parse['image'] = $planetrow['image'];
	?><script language="JavaScript" src="scripts/flotten.js"></script>
<script language="JavaScript" src="scripts/ocnt.js"></script>
<?
	$parse['planetlist'] = '';
	$planets_list = doquery("SELECT id,name,galaxy,system,planet FROM {{table}} WHERE id_owner='{$user['id']}'","planets");
	while($p = mysql_fetch_array($planets_list)){
		if($p["destruyed"] == 0){
			$parse['planetlist'] .= "<option ";
			if($p["id"] == $user["current_planet"]) $parse['planetlist'] .= 'selected="selected" ';
			$parse['planetlist'] .= "value=\"?cp={$p['id']}&amp;mode=$mode&amp;gid=$gid&amp;messageziel=$messageziel&amp;re=0\">";
			$parse['planetlist'] .= "{$p['name']} [{$p['galaxy']}:{$p['system']}:{$p['planet']}]</option>";
		}
	}
	$energy = pretty_number($planetrow["energy_max"]-$planetrow["energy_used"])."/".pretty_number($planetrow["energy_max"]);
	if($planetrow["energy_max"]-$planetrow["energy_used"]< 0){
		$parse['energy'] = colorRed($energy);
	}else{$parse['energy'] = $energy;}
	$metal = pretty_number($planetrow["metal"]);
	if(($planetrow["metal"] > $planetrow["metal_max"])){
		$parse['metal'] = colorRed($metal);
	}else{$parse['metal'] = $metal;}
	$crystal = pretty_number($planetrow["crystal"]);
	if(($planetrow["crystal"] > $planetrow["crystal_max"])){
		$parse['crystal'] = colorRed($crystal);
	}else{$parse['crystal'] = $crystal;}
	$deuterium = pretty_number($planetrow["deuterium"]);
	if(($planetrow["deuterium"] > $planetrow["deuterium_max"])){
		$parse['deuterium'] = colorNumber($deuterium);
	}else{$parse['deuterium'] = $deuterium;}

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

	$left_time = (time() - $planet['last_update']);
	$planet['last_update'] = time();
	if($planet['energy_max']==0){
		$planet['metal_perhour'] = 0;
		$planet['crystal_perhour'] = $game_config['crystal_basic_income'] ;
		$planet['deuterium_perhour'] = $game_config['deuterium_basic_income'];
		$production_level=100;
	}elseif($planet["energy_max"]>=$planet["energy_used"]){
		$production_level=100;
	}else{
		$production_level = floor(($planet['energy_max']/$planet['energy_used'])*100);
	}
	if($production_level>100){$production_level=100;}
	if($production_level<0){$production_level=0;}
	if($planet['metal'] < ($planet['metal_max'] + $planet['metal_max'] * 0.1)){
		$planet['metal'] += (($left_time * ($planet['metal_perhour']/3600)) * $game_config['resource_multiplier'])*(0.01*$production_level);
		$planet['metal'] += $left_time * (($game_config['metal_basic_income']*$game_config['resource_multiplier'])/3600);
	}
	if($planet['crystal'] < ($planet['crystal_max'] + $planet['crystal_max'] * 0.1)){
		$planet['crystal'] += (($left_time * ($planet['crystal_perhour']/3600)) * $game_config['resource_multiplier'])*(0.01*$production_level);
		$planet['crystal'] += $left_time * (($game_config['crystal_basic_income']*$game_config['resource_multiplier'])/3600);
	}
	if($planet['deuterium'] < ($planet['deuterium_max'] + $planet['deuterium_max'] * 0.1)){
		$planet['deuterium'] += (($left_time * ($planet['deuterium_perhour']/3600)) * $game_config['resource_multiplier'])*(0.01*$production_level);
		$planet['deuterium'] += $left_time * (($game_config['deuterium_basic_income']*$game_config['resource_multiplier'])/3600);
	}
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
		
		$endtaillist = false;
		foreach($buildArray as $a => $b){
			
			while($planet['b_hangar']>=$b[2] && !$endtaillist){
				
				if($b[1]>0){
					
					$planet['b_hangar']-=$b[2];
					$summon[$b[0]]++;
					$planet[$resource[$b[0]]]++;
					$b[1]--;
					
				}else{
					$endtaillist=true;
					break;
				}
				
			}
			if($b[1]!=0){
				$planet['b_hangar_id'] .= "{$b[0]},{$b[1]};";
			}
		}
	}else{$planet['b_hangar'] = 0;}
	
	$query = "UPDATE {{table}} SET
	metal='{$planet['metal']}',
	crystal='{$planet['crystal']}',
	deuterium='{$planet['deuterium']}',
	last_update='{$planet['last_update']}',
	b_hangar_id='{$planet['b_hangar_id']}',";

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
  
	touchPlanet($planet);

}

function check_field_current(&$planet){
	global $resource;
	$cfc = $planet[$resource[1]]+$planet[$resource[2]]+$planet[$resource[3]];
	$cfc += $planet[$resource[4]]+$planet[$resource[12]]+$planet[$resource[14]];
	$cfc += $planet[$resource[15]]+$planet[$resource[21]]+$planet[$resource[22]];
	$cfc += $planet[$resource[23]]+$planet[$resource[24]]+$planet[$resource[31]];
	$cfc += $planet[$resource[33]]+$planet[$resource[34]]+$planet[$resource[44]];
	
	if($planet['field_current'] != $cfc){
		$planet['field_current'] = $cfc;
		doquery("UPDATE {{table}} SET field_current=$cfc WHERE id={$planet['id']}",'planets');
	}
}

function check_abandon_planet(&$planet){

	if($planet['destruyed'] <= time()){
		doquery("DELETE FROM {{table}} WHERE id={$planet['id']}",'planets');
		doquery("UPDATE {{table}} SET id_planet=0 WHERE id_planet={$planet['id']}",'galaxy');
		
	}
}

function check_building_progress($planet){
	if($planet['b_building'] > time()) return true;

}

function is_tech_available($user,$planet,$i){

	global $requeriments,$resource;

	if(isset($requeriments[$i])){ 
		
		$enabled = true;
		foreach($requeriments[$i] as $r => $l){
			
			if(@$user[$resource[$r]] && $user[$resource[$r]] >= $l){
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

function is_buyable($user,$planet,$i,$userfactor=true){

	global $pricelist,$resource,$lang;

	$level = (isset($planet[$resource[$i]])) ? $planet[$resource[$i]] : $user[$resource[$i]];
  $is_buyeable = true;
  $array = array('metal'=>$lang["Metal"],'crystal'=>$lang["Crystal"],'deuterium'=>$lang["Deuterium"],'energy_max'=>$lang["Energy"]);
  foreach($array as $a => $b){
  
    if(@$pricelist[$i][$a] != 0){
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

function echo_price($user,$planet,$i,$userfactor=true){
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

function rest_price($user,$planet,$i,$userfactor=true){
  global $pricelist,$resource,$lang;
  
  if($userfactor)
    $level = ($planet[$resource[$i]]) ? $planet[$resource[$i]] : $user[$resource[$i]];

  $array = array('metal'=>$lang["Metal"],'crystal'=>$lang["Crystal"],'deuterium'=>$lang["Deuterium"],'energy_max'=>$lang["Energy"]);
  
  $str .= '<br><font color="#7f7f7f">Reszta: ';
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

function is_buyeable($user,$planet,$i,$userfactor=true){
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

function price($user,$planet,$i,$userfactor=true){
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
				$is_buyeable = false;
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
}

function get_building_time($user,$planet,$i){
	global $pricelist,$resource,$reslist,$game_config;
	$level = ($planet[$resource[$i]]) ? $planet[$resource[$i]] : $user[$resource[$i]];
	
	if(in_array($i,$reslist['build']))
	{
		$cost_metal = 	floor($pricelist[$i]['metal'] * pow($pricelist[$i]['factor'],$level));
		$cost_crystal = floor($pricelist[$i]['crystal'] * pow($pricelist[$i]['factor'],$level));
		$time = ((($cost_crystal )+($cost_metal)) / $game_config['game_speed']) * (1 / ($planet[$resource['14']] + 1)) * pow(0.5,$planet[$resource['15']]);
		$time = floor($time * 60 * 60);
		return $time;
	}
	elseif(in_array($i,$reslist['tech']))
	{
		$cost_metal = 	floor($pricelist[$i]['metal'] * pow($pricelist[$i]['factor'],$level));
		$cost_crystal = floor($pricelist[$i]['crystal'] * pow($pricelist[$i]['factor'],$level));
		$msbnlvl = $user['intergalactic_tech'];
		if ($msbnlvl < "1")
		{
		$laborka = $planet[$resource['31']];
		}
		elseif ($msbnlvl >= "1")
		{
//		$msbnlvl = $msbnlvl+1;
		$msbnzapytanie = doquery("SELECT * FROM {{table}} WHERE id_owner='{$user[id]}'", "planets");
		$i = 0;
		$laborka_wyn = 0;		
		while ($msbNumow = mysql_fetch_array($msbnzapytanie)){
		$laborka[$i] = $msbNumow['laboratory'];
		$tescik[$i] = $msbNumow['name'];
		$i++;
		}
if ($msbnlvl >= "1")
{		
		$laborka_temp = max($laborka);
		arsort($laborka);
		$wytnij = array_shift($laborka);
		$laborka_temp1 = max($laborka);
if ($msbnlvl >= "2")
{
		arsort($laborka);
		$wytnij = array_shift($laborka);
		$laborka_temp2 = max($laborka);
}
if ($msbnlvl >= "3")
{
		arsort($laborka);
		$wytnij = array_shift($laborka);
		$laborka_temp3 = max($laborka);		
}
if ($msbnlvl >= "4")
{
		arsort($laborka);
		$wytnij = array_shift($laborka);
		$laborka_temp4 = max($laborka);		
}
if ($msbnlvl >= "5")
{

		arsort($laborka);
		$wytnij = array_shift($laborka);
		$laborka_temp5 = max($laborka);		
}
if ($msbnlvl >= "6")
{

		arsort($laborka);
		$wytnij = array_shift($laborka);
		$laborka_temp6 = max($laborka);		
}
if ($msbnlvl >= "7")
{

		arsort($laborka);
		$wytnij = array_shift($laborka);
		$laborka_temp7 = max($laborka);		
}
if ($msbnlvl >= "8")
{

		arsort($laborka);
		$wytnij = array_shift($laborka);
		$laborka_temp8 = max($laborka);		
}
}
//		foreach ($laborka as $key => $val) {
//		    echo "; lab[" . $key . "] = " . $val . "<BR>";
//		    }
//		echo "$laborka_wyn";
		$laborka = $laborka_temp + $laborka_temp1 + $laborka_temp2 + $laborka_temp3 + $laborka_temp4 + $laborka_temp5 + $laborka_temp6 + $laborka_temp7 + $laborka_temp8;
//		echo"$laborka";
		}
		$time = (($cost_metal + $cost_crystal) / $game_config['game_speed']) / ( ($laborka + 1 )*2);
		$time = floor($time*60*60);
		return $time;
	}
	elseif(in_array($i,$reslist['defense'])||in_array($i,$reslist['fleet']))
	{
		$time = (($pricelist[$i]['metal'] + $pricelist[$i]['crystal']) / $game_config['game_speed']) * (1 / ($planet[$resource['21']] + 1 )) * pow(1/2,$planet[$resource['15']]);
		$time = $time*60*60;
		return $time;
	}

}

function get_building_price($user,$planet,$i,$userfactor=true){
	global $pricelist,$resource;

	if($userfactor){$level = (isset($planet[$resource[$i]])) ? $planet[$resource[$i]] : $user[$resource[$i]];}
	$array = array('metal','crystal','deuterium');
	foreach($array as $a){
		if($userfactor){
			$cost[$a] = floor($pricelist[$i][$a] * pow($pricelist[$i]['factor'],$level));
		}else{
			$cost[$a] = floor($pricelist[$i][$a]);
		}
	}

	return $cost;

}


function touchPlanet(&$planet){
	global $resource;
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


	while($f = mysql_fetch_array($fleetquery)){
		switch($f["fleet_mission"]){
			//
			//--[1:Atakowanie]--------------------------------------------------
			//
		case 1:{
				if($f['fleet_start_time']<=time()){
					if ($f['fleet_mess'] ==0){	
					global $user;
					$idwroga = doquery("SELECT * FROM {{table}} WHERE galaxy={$f['fleet_end_galaxy']} AND system={$f['fleet_end_system']} AND planet={$f['fleet_end_planet']}",'planets',true);
					$idwrog=$idwroga['id_owner'];
					$tech_wrog = doquery("SELECT `military_tech`, `defence_tech`, `shield_tech` FROM  {{table}} WHERE id={$idwrog}",'users',true);
					$tech_atakujacy = doquery("SELECT `military_tech`, `defence_tech`, `shield_tech` FROM  {{table}} WHERE id={$user["id"]}",'users',true);
				
					for ($i =200; $i <500;$i++){
						if($idwroga[$resource[$i]] > 0){
							$wrog[$i]["ilosc"] = $idwroga[$resource[$i]];
						}
					}
					$fleet = explode(";",$f['fleet_array']);
					foreach($fleet as $a =>$b){
						if($b != ''){
							$a = explode(",",$b);
							$atakujacy[$a[0]]["ilosc"] = $a[1];
						}
					}
					global $phpEx,$ugamela_root_path,$pricelist;
					include_once($ugamela_root_path . 'includes/ataki.'.$phpEx);
					$walka = walka($atakujacy,$wrog,$tech_atakujacy,$tech_wrog);
					$atakujacy=$walka["atakujacy"];
					$wrog=$walka["wrog"];
					$wygrana=$walka["wygrana"];
					$dane_do_rw=$walka["dane_do_rw"];
					$zlom=$walka["zlom"];
					$farray = "";
					$famount = 0;
					$pojemosc = 0;
					foreach($atakujacy as $a =>$b){
						$pojemosc = $pojemosc + $pricelist[$a]["capacity"]*$b["ilosc"];
						$farray .= "{$a},{$b["ilosc"]};";
						$famount = $famount + $b["ilosc"];
					}
					$pojemosc = $pojemosc - $f["fleet_resource_metal"] - $f["fleet_resource_crystal"] - $f["fleet_resource_deuterium"];
					$fquery = "";
					if (!is_null($wrog)) {
						foreach($wrog as $a =>$b){
							$fquery .= "{$resource[$a]}={$b["ilosc"]}, ";
						}	
					}
					if ($wygrana == "a"){
						if ($pojemosc > 0){
							$metal = $idwroga["metal"]/2;
							$krysztal = $idwroga["crystal"]/2;
							$deuter	= $idwroga["deuterium"]/2;
							if (($metal) > $pojemosc/3) {
								$ladownia["metal"] = $pojemosc/3;						
								$pojemosc = $pojemosc - $ladownia["metal"];
							} else {
								$ladownia["metal"] = $metal;
								$pojemosc = $pojemosc - $ladownia["metal"];
							}
					
							if (($krysztal) > $pojemosc/2) {
								$ladownia["krysztal"] = $pojemosc/2;						
								$pojemosc = $pojemosc - $ladownia["krysztal"];
							} else {
								$ladownia["krysztal"] = $krysztal;
								$pojemosc = $pojemosc - $ladownia["krysztal"];
							}
					
							if (($deuter) > $pojemosc) {
								$ladownia["deuter"] = $pojemosc;						
								$pojemosc = $pojemosc - $ladownia["deuter"];
							} else {
								$ladownia["deuter"] = $deuter;
								$pojemosc = $pojemosc - $ladownia["deuter"];
							}
					
						}
					}
					//przeniesienie surowcow z planety do ladowni
					doquery("UPDATE {{table}} SET $fquery
						metal=metal - '{$ladownia["metal"]}',
						crystal=crystal - '{$ladownia["krysztal"]}',
						deuterium=deuterium - '{$ladownia["deuter"]}'
						WHERE galaxy={$f['fleet_end_galaxy']} 
						AND system={$f['fleet_end_system']} 
						AND planet={$f['fleet_end_planet']}	LIMIT 1 ;",'planets');

					doquery("UPDATE {{table}} SET 
						metal=metal + '{$zlom["metal"]}',
						crystal=crystal + '{$zlom["krysztal"]}'
						WHERE galaxy={$f['fleet_end_galaxy']} 
						AND system={$f['fleet_end_system']} 
						AND planet={$f['fleet_end_planet']}	LIMIT 1 ;",'galaxy');

					//kod na moona od DxPpLmOs
					$debris = $zlom["metal"] + $zlom["krysztal"];
					$deb = "Na tych wsp�rz�dnych znajduje si� teraz {$zlom["metal"]} metalu i {$zlom["krysztal"]} kryszta�u.";
					$szansa2 = $debris/100000; 
					$enemyrow =doquery("SELECT * FROM {{table}} WHERE galaxy={$f['fleet_end_galaxy']} AND system={$f['fleet_end_system']} AND planet={$f['fleet_end_planet']}",'planets',true); 
					$galenemyrow =doquery("SELECT * FROM {{table}} WHERE galaxy={$f['fleet_end_galaxy']} AND system={$f['fleet_end_system']} AND planet={$f['fleet_end_planet']}",'galaxy',true); 
					$maxtemp = $enemyrow['temp_max']-rand(10, 45);
					$mintemp = $enemyrow['temp_min']-rand(10, 45);
					$sre = rand(4000, 10000);
					if($debris > 2000000){
						$szansa2 = 20;
					} 
					if($debris < 100000){
						$szansa = 0;
						$szanmoon = "";
					} elseif ($debris >= 100000){
						$szansa = rand(1, 100);
						$szanmoon = "Szansa na powstanie ksi�yca wynosi $szansa2 % ";
					}
					
					if(($szansa > 0) and ($szansa <= $szansa2) and $galenemyrow['id_luna'] != 0){
						doquery("INSERT INTO {{table}} SET
							`name`='moon',
							`galaxy`='{$f['fleet_end_galaxy']}',
							`system`='{$f['fleet_end_system']}',
							`lunapos`='{$f['fleet_end_planet']}',
							`id_owner`='{$enemyrow['id_owner']}',
							`temp_max`='$maxtemp',
							`temp_min`='$mintemp',
							`diameter`='$sre',
							`id_luna`='{$f['fleet_start_time']}'"
							,"lunas"); 
						$lunarow =doquery("SELECT * FROM {{table}} WHERE galaxy={$f['fleet_end_galaxy']} AND system={$f['fleet_end_system']} AND lunapos={$f['fleet_end_planet']}",'lunas',true); 
						doquery("UPDATE {{table}} SET 
							`id_luna`='{$lunarow['id']}', 
							`luna`='0' WHERE 
							`galaxy`='{$f['fleet_end_galaxy']}' AND 
							`system`='{$f['fleet_end_system']}' AND 
							`planet`='{$f['fleet_end_planet']}'" 
							,"galaxy"); 
						$powtal = "Gratulacje!!! z od�amk�w statk�w kr���cych woko�o planety {$enemyrow['name']} [{$f['fleet_end_galaxy']}:{$f['fleet_end_system']}:{$f['fleet_end_planet']}] zacz�� formowa� si� naturalny satelita";
						} elseif ($szansa = 0 or $szansa > $szansa2){ 
							$powtal = "";
						}
						
						switch ($wygrana) {
							case "a":
								$wiadomosc = "Twoja flota z planety {$idja['name']} [{$f['fleet_start_galaxy']}:{$f['fleet_start_system']}:{$f['fleet_start_planet']}] zaatakowa�a planete {$idwroga['name']} [{$f['fleet_end_galaxy']}:{$f['fleet_end_system']}:{$f['fleet_end_planet']}]<br><center>Wynik walki:<br>Wygra�e� i zrabowa�e�:<br>Metal: {$ladownia["metal"]}<br>Kryszta�: {$ladownia["krysztal"]}<br>Deuter: {$ladownia["deuter"]}</center>";
								$wiadomosc1 = "Obca flota z planety {$idja['name']} [{$f['fleet_start_galaxy']}:{$f['fleet_start_system']}:{$f['fleet_start_planet']}] zaatakowa�a  twoj� planete {$idwroga['name']} [{$f['fleet_end_galaxy']}:{$f['fleet_end_system']}:{$f['fleet_end_planet']}]<br><center>Wynik walki:<br>Agesor wygra� i zrabowa�:<br>Metal: {$ladownia["metal"]}<br>Kryszta�: {$ladownia["krysztal"]}<br>Deuter: {$ladownia["deuter"]}<br>$deb<br>$szanmoon<br>$powtal</center>";
								break;
							case "r":
								$wiadomosc = "Twoja flota z planety {$idja['name']} [{$f['fleet_start_galaxy']}:{$f['fleet_start_system']}:{$f['fleet_start_planet']}] zaatakowa�a planete {$idwroga['name']} [{$f['fleet_end_galaxy']}:{$f['fleet_end_system']}:{$f['fleet_end_planet']}]<br><center>Wynik walki:<br>Remis<br>Obie floty wracaj� na swoje macierzyste planety</center>";
								$wiadomosc1 = "Obca flota z planety {$idja['name']} [{$f['fleet_start_galaxy']}:{$f['fleet_start_system']}:{$f['fleet_start_planet']}] zaatakowa�a twoj� planete {$idwroga['name']} [{$f['fleet_end_galaxy']}:{$f['fleet_end_system']}:{$f['fleet_end_planet']}]<br><center>Wynik walki:<br>Remis<br>Obie floty wracaj� na swoje macierzyste planety<br>$deb<br>$szanmoon<br>$powtal</center>";
								break;
							case "w":
								$wiadomosc = "Twoja flota z planety {$idja['name']} [{$f['fleet_start_galaxy']}:{$f['fleet_start_system']}:{$f['fleet_start_planet']}] zaatakowa�a planete {$idwroga['name']} [{$f['fleet_end_galaxy']}:{$f['fleet_end_system']}:{$f['fleet_end_planet']}]<br><center>Wynik walki:<br>Obro�ca wygra�<br>Twoja flota zosta�a Points</center>";
								$wiadomosc1 = "Obca flota z planety {$idja['name']} [{$f['fleet_start_galaxy']}:{$f['fleet_start_system']}:{$f['fleet_start_planet']}] zaatakowa�a twoj� planete {$idwroga['name']} [{$f['fleet_end_galaxy']}:{$f['fleet_end_system']}:{$f['fleet_end_planet']}]<br><center>Wynik walki:<br>Wygra�e�<br>Obca flota zosta�a Points<br>$deb<br>$szanmoon<br>$powtal</center>";
								doquery("DELETE FROM {{table}} WHERE fleet_id=".$f["fleet_id"],'fleets');
								break;
							default:
								break;
						}
						$ladownia["metal"] = $ladownia["metal"] + $f["fleet_resource_metal"];
						$ladownia["krysztal"] = $ladownia["krysztal"] + $f["fleet_resource_crystal"];
						$ladownia["deuter"] = $ladownia["deuter"] + $f["fleet_resource_deuterium"];
						
						doquery("UPDATE {{table}} SET 
							`fleet_amount`='{$famount}', 
							`fleet_array`='{$farray}',
							`fleet_resource_metal`='{$ladownia["metal"]}', 
							`fleet_resource_crystal`='{$ladownia["krysztal"]}',
							`fleet_resource_deuterium`='{$ladownia["deuter"]}'
							WHERE fleet_id={$f['fleet_id']} 
							LIMIT 1 ;",'fleets');
						doquery("INSERT INTO {{table}} SET 
							`message_owner`='{$f['fleet_owner']}',
							`message_sender`='',
							`message_time`='".time()."',
							`message_type`='0',
							`message_from`='Dow�dztwo Floty',
							`message_subject`='Walka',
							`message_text`='{$wiadomosc}'"
							,'messages');
						doquery("UPDATE {{table}} SET new_message=new_message+1 WHERE id='{$f['fleet_owner']}'",'users'); 
						doquery("INSERT INTO {{table}} SET 
							`message_owner`='{$idwrog}',
							`message_sender`='',
							`message_time`='".time()."',
							`message_type`='0',
							`message_from`='Dow�dztwo Floty',
							`message_subject`='Walka',
							`message_text`='{$wiadomosc1}'"
							,'messages');
						doquery("UPDATE {{table}} SET new_message=new_message+1 WHERE id='{$idwrog}'",'users'); 
						doquery("UPDATE {{table}} SET fleet_mess='1' WHERE fleet_id=".$f["fleet_id"],'fleets');
					}
				}
				
				if($f['fleet_end_time']<=time()){
					if (!is_null($atakujacy)) {
						foreach($atakujacy as $a =>$b){
							$fquery .= "{$resource[$a]}={$b["ilosc"]}, ";
						}	
					}
						doquery("DELETE FROM {{table}} WHERE fleet_id=".$f["fleet_id"],'fleets');
					if (!($wygrana == "w")){
						doquery("UPDATE {{table}} SET
							$fquery
							metal=metal + {$f['fleet_resource_metal']},
							crystal=crystal + {$f['fleet_resource_crystal']},
							deuterium=deuterium + {$f['fleet_resource_deuterium']}
							WHERE galaxy = {$f['fleet_start_galaxy']} AND
							system = {$f['fleet_start_system']} AND
							planet = {$f['fleet_start_planet']}
							LIMIT 1 ;",'planets');
					}
				}
			break;}
			//
			//--[3:Transportowanie]--------------------------------------------------
			//
			case 3:{ 

$messmojax =doquery("SELECT * FROM {{table}} WHERE galaxy={$f['fleet_start_galaxy']} AND system={$f['fleet_start_system']} AND planet={$f['fleet_start_planet']}",'planets',true);
$messtwojax =doquery("SELECT * FROM {{table}} WHERE galaxy={$f['fleet_end_galaxy']} AND system={$f['fleet_end_system']} AND planet={$f['fleet_end_planet']}",'planets',true);
$nazwamojej = $messmojax['name'];
$nazwatwojej = $messtwojax['name'];

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
				if ($f["fleet_mess"] != "1")
{
doquery("INSERT INTO {{table}} SET
                     `message_owner`='{$f['fleet_owner']}',
                     `message_sender`='',
                     `message_time`='".time()."',
                     `message_type`='0',
                     `message_from`='Dow�dztwo floty',
                     `message_subject`='Raport Transportu',
                     `message_text`='Flota dotar�a do planety $nazwatwojej [{$f['fleet_end_galaxy']}:{$f['fleet_end_system']}:{$f['fleet_end_planet']}] i dostarczy�a surowce [Metal: {$f['fleet_resource_metal']} Kryszta�: {$f['fleet_resource_crystal']} Deuter: {$f['fleet_resource_deuterium']}]'"
                     ,'messages');              
doquery("UPDATE {{table}} SET new_message=new_message+1 WHERE id='{$f['fleet_owner']}'",'users'); 
doquery("UPDATE {{table}} SET fleet_mess='1' WHERE fleet_id=".$f["fleet_id"],'fleets');
}	
					
					if($f['fleet_end_time']<=time()){
						$fleet = explode(";",$f['fleet_array']);
						foreach($fleet as $a =>$b){
							if($b != ''){
								$a = explode(",",$b);
								$fquery .= "{$resource[$a[0]]}={$resource[$a[0]]} + {$a[1]}, \n";
							}
						}
						doquery("DELETE FROM {{table}} WHERE fleet_id=".$f["fleet_id"],'fleets');
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
					if ($f["fleet_mess"] == "1")
{
doquery("INSERT INTO {{table}} SET
                     `message_owner`='{$f['fleet_owner']}',
                     `message_sender`='',
                     `message_time`='".time()."',
                     `message_type`='0',
                     `message_from`='Dow�dztwo floty',
                     `message_subject`='Raport Transportu',
                     `message_text`='Flota wr�ci�a na planet� $nazwamojej [{$f['fleet_start_galaxy']}:{$f['fleet_start_system']}:{$f['fleet_start_planet']}] bez surowc�w'"
                     ,'messages');              
doquery("UPDATE {{table}} SET new_message=new_message+1 WHERE id='{$f['fleet_owner']}'",'users'); 
doquery("UPDATE {{table}} SET fleet_mess='2' WHERE fleet_id=".$f["fleet_id"],'fleets');
}				
					}
				}
				break;}
			//
			//--[4:Stacjonuj]--------------------------------------------------
			//
			case 4:{
				if($f['fleet_start_time']<=time()){
					$fleet = explode(";",$f['fleet_array']);
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
			//--[5:Niszcz]--------------------------------------------------
			//
			case 5:
			//
			//--[6:Szpieguj]--------------------------------------------------
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
									$debs =doquery("SELECT * FROM {{table}} WHERE galaxy={$f['fleet_end_galaxy']} AND system={$f['fleet_end_system']} AND planet={$f['fleet_end_planet']}",'galaxy',true);
				$debsc = $debs['crystal'];
				$debss = $LS*300;

				
//$all="<table width=400><tr><td class=c colspan=4> Surowce na {$idwroga['name']}[{$idwroga['galaxy']}:{$idwroga['system']}:{$idwroga['planet']}]".gmdate("d-m-Y H:i:s",time())."</td></tr>";
$surka="<table width=440><tr><td class=c colspan=4> Surowce na {$idwroga['name']}[{$idwroga['galaxy']}:{$idwroga['system']}:{$idwroga['planet']}]".gmdate("d-m-Y H:i:s",time()+2*60*60)."</td></tr><tr><td>Metal:</td><td>".pretty_number($idwroga['metal'])."</td><td>Kryszta�:</td><td>".pretty_number($idwroga['crystal'])."</td></tr> <tr><td>Deuter:</td><td>".pretty_number($idwroga['deuterium'])."</td> <td>Energia:</td><td>".pretty_number($idwroga['energy_max'])."</td></tr> </table>";

if($idwroga['small_ship_cargo'] > "0"){$mt="<td>Ma�y Transporter</td><td>{$idwroga['small_ship_cargo']}</td>";}
if($idwroga['big_ship_cargo'] > "0"){$dt="<td>Du�y Transporter</td><td>{$idwroga['big_ship_cargo']}</td></tr>";}
if($idwroga['light_hunter'] > "0"){$lm="<td>Lekki My�liwiec</td><td>{$idwroga['light_hunter']}</td>";}
if($idwroga['heavy_hunter'] > "0"){$cm="<td>Ci�ki My�liwiec</td><td>{$idwroga['heavy_hunter']}</td></tr>";}
if($idwroga['crusher'] > "0"){$kr="<td>Kr��ownik</td><td>{$idwroga['crusher']}</td>";}
if($idwroga['battle_ship'] > "0"){$ow="<td>Okr�t Wojenny</td><td>{$idwroga['battle_ship']}</td></tr>";}
if($idwroga['colonizer'] > "0"){$colon="<td>Kolonizator</td><td>{$idwroga['colonizer']}</td>";}
if($idwroga['recycler'] > "0"){$recek="<td>Recykler</td><td>{$idwroga['recycler']}</td></tr>";}
if($idwroga['spy_sonde'] > "0"){$spysonda="<td>Sonda Szpiegowska</td><td>{$idwroga['spy_sonde']}</td>";}
if($idwroga['bomber_ship'] > "0"){$bombo="<td>Bombowiec</td><td>{$idwroga['bomber_ship']}</td></tr>";}
if($idwroga['solar_satelit'] > "0"){$satki="<td>Satelita S�oneczny</td><td>{$idwroga['solar_satelit']}</td>";}
if($idwroga['destructor'] > "0"){$niszcz="<td>Niszczyciel</td><td>{$idwroga['destructor']}</td></tr>";}
if($idwroga['dearth_star'] > "0"){$gwiazdeczka="<td>Gwiazda �mierci</td><td>{$idwroga['dearth_star']}</td>";}
if($idwroga['battleship'] > "0"){$panc="<td>Pancernik</td><td>{$idwroga['battleship']}</td></tr>";}
//if($idwroga['silo'] > "0"){$silos="<td>Silos Rakietowy</td><td>{$idwroga['silo']}</td></tr>";}

$floty="<table width=440><tr><td class=c colspan=4> Surowce na {$idwroga['name']}[{$idwroga['galaxy']}:{$idwroga['system']}:{$idwroga['planet']}]".gmdate("d-m-Y H:i:s",time()+2*60*60)."</td></tr><tr><td>Metal:</td><td>".pretty_number($idwroga['metal'])."</td><td>Kryszta�:</td><td>".pretty_number($idwroga['crystal'])."</td></tr> <tr><td>Deuter:</td><td>".pretty_number($idwroga['deuterium'])."</td> <td>Energia:</td><td>".pretty_number($idwroga['energy_max'])."</td></tr> </table><table width=440><tr><td class=c colspan=6>Floty</td></tr>$mt$dt$lm$cm$kr$ow$colon$recek$spysonda$bombo$satki$niszcz$gwiazdeczka$panc </table>";

if($idwroga['misil_launcher'] > "0"){$ml="<td>Wyrzutnia Rakiet</td><td>{$idwroga['misil_launcher']}</td>";}
if($idwroga['small_laser'] > "0"){$sl="<td>Lekkie Dzia�o Laserowe</td><td>{$idwroga['small_laser']}</td></tr>";}
if($idwroga['big_laser'] > "0"){$bl="<td>Cie�kie Dzia�o Laserowe</td><td>{$idwroga['big_laser']}</td>";}
if($idwroga['gauss_canyon'] > "0"){$gauss="<td>Dzia�o Gaussa</td><td>{$idwroga['gauss_canyon']}</td></tr>";}
if($idwroga['ionic_canyon'] > "0"){$ionic="<td>Dzia�o Jonowe</td><td>{$idwroga['ionic_canyon']}</td>";}
if($idwroga['buster_canyon'] > "0"){$buster="<td>Wyrzutnia Plazmy</td><td>{$idwroga['buster_canyon']}</td></tr>";}
if($idwroga['small_protection_shield'] > "0"){$mp="<td>Ma�a Pow�oka Ochronna</td><td>{$idwroga['small_protection_shield']}</td>";}
if($idwroga['big_protection_shield'] > "0"){$dp="<td>Du�a Pow�oka Ochronna</td><td>{$idwroga['big_protection_shield']}</td>";}


$obrona="<table width=440><tr><td class=c colspan=4> Surowce na {$idwroga['name']}[{$idwroga['galaxy']}:{$idwroga['system']}:{$idwroga['planet']}]".gmdate("d-m-Y H:i:s",time()+2*60*60)."</td></tr><tr><td>Metal:</td><td>".pretty_number($idwroga['metal'])."</td><td>Kryszta�:</td><td>".pretty_number($idwroga['crystal'])."</td></tr> <tr><td>Deuter:</td><td>".pretty_number($idwroga['deuterium'])."</td> <td>Energia:</td><td>".pretty_number($idwroga['energy_max'])."</td></tr> </table><table width=440><tr><td class=c colspan=6>Floty</td></tr>$mt$dt$lm$cm$kr$ow$colon$recek$spysonda$bombo$satki$niszcz$gwiazdeczka$panc </table> <table width=440><tr><td class=c colspan=4>Obrona</td></tr>$ml$sl$bl$gauss$ionic$buster$mp$dp </table>";

if($idwroga['metal_mine'] > "0"){$kop_metal="<td>Kopalnia metalu</td><td>{$idwroga['metal_mine']}</td>";}
if($idwroga['crystal_mine'] > "0"){$kop_krysia="<td>Kopalnia kryszta�u</td><td>{$idwroga['crystal_mine']}</td>";}
if($idwroga['deuterium_sintetizer'] > "0"){$kop_deut="<td>Ekstraktor Deuteru</td><td>{$idwroga['deuterium_sintetizer']}</td></tr>";}
if($idwroga['solar_plant'] > "0"){$solar="<td>Elektrownia S�oneczna</td><td>{$idwroga['solar_plant']}</td>";}
if($idwroga['fusion_plant'] > "0"){$fusion="<td>Elektrownia Fuzyjna</td><td>{$idwroga['fusion_plant']}</td>";}
if($idwroga['robot_factory'] > "0"){$robot="<td>Fabryka Robot�w</td><td>{$idwroga['robot_factory']}</td></tr>";}
if($idwroga['nano_factory'] > "0"){$nano="<td>Fabryka Nanit�w</td><td>{$idwroga['nano_factory']}</td>";}
if($idwroga['hangar'] > "0"){$stocznia="<td>Stocznia</td><td>{$idwroga['hangar']}</td>";}
if($idwroga['metal_store'] > "0"){$mag_mety="<td>Magazyn Metalu</td><td>{$idwroga['metal_store']}</td></tr>";}
if($idwroga['crystal_store'] > "0"){$mag_krysi="<td>Magazyn Kryszta�u</td><td>{$idwroga['crystal_store']}</td>";}
if($idwroga['deuterium_store'] > "0"){$mag_deut="<td>Magazyn Deuteru</td><td>{$idwroga['deuterium_store']}</td>";}
if($idwroga['laboratory'] > "0"){$lab="<td>Laboratorium</td><td>{$idwroga['laboratory']}</td></tr>";}
if($idwroga['terraformer'] > "0"){$tetra="<td>Terraformer</td><td>{$idwroga['terraformer']}</td>";}
if($idwroga['ally_deposit'] > "0"){$allydepo="<td>Depozyt Sojuszniczy</td><td>{$idwroga['ally_deposit']}</td>";}
if($idwroga['silo'] > "0"){$silos="<td>Silos Rakietowy</td><td>{$idwroga['silo']}</td></tr>";}

$budynki="<table width=440><tr><td class=c colspan=4> Surowce na {$idwroga['name']}[{$idwroga['galaxy']}:{$idwroga['system']}:{$idwroga['planet']}]".gmdate("d-m-Y H:i:s",time()+2*60*60)."</td></tr><tr><td>Metal:</td><td>".pretty_number($idwroga['metal'])."</td><td>Kryszta�:</td><td>".pretty_number($idwroga['crystal'])."</td></tr> <tr><td>Deuter:</td><td>".pretty_number($idwroga['deuterium'])."</td> <td>Energia:</td><td>".pretty_number($idwroga['energy_max'])."</td></tr> </table><table width=440><tr><td class=c colspan=6>Floty</td></tr>$mt$dt$lm$cm$kr$ow$colon$recek$spysonda$bombo$satki$niszcz$gwiazdeczka$panc </table> <table width=440><tr><td class=c colspan=4>Obrona</td></tr>$ml$sl$bl$gauss$ionic$buster$mp$dp </table> <table width=440><tr><td class=c colspan=6>Budynki</td></tr></tr>$kop_metal$kop_krysia$kop_deut$solar$fusion$robot$nano$stocznia$mag_mety$mag_krysi$mag_deut$lab$tetra$allydepo$silos</table>";

if($szpiegwrog['spy_tech'] > "0"){$spy_tech="<td>Technologia Szpiegowska</td><td>{$szpiegwrog['spy_tech']}</td>";}
if($szpiegwrog['computer_tech'] > "0"){$pc_tech="<td>Technologia Komputerowa</td><td>{$szpiegwrog['computer_tech']}</td></tr>";}
if($szpiegwrog['military_tech'] > "0"){$boj_tech="<td>Technologia Bojowa</td><td>{$szpiegwrog['military_tech']}</td>";}
if($szpiegwrog['defence_tech'] > "0"){$obr_tech="<td>Technologia Obronna</td><td>{$szpiegwrog['defence_tech']}</td></tr>";}
if($szpiegwrog['shield_tech'] > "0"){$op_tech="<td>Opancerzenie</td><td>{$szpiegwrog['shield_tech']}</td>";}
if($szpiegwrog['energy_tech'] > "0"){$ene_tech="<td>Technologia Energetyczna</td><td>{$szpiegwrog['energy_tech']}</td></tr>";}
if($szpiegwrog['hyperspace_tech'] > "0"){$nadp_tech="<td>Technologia Nadprzestrzenna</td><td>{$szpiegwrog['hyperspace_tech']}</td>";}
if($szpiegwrog['combustion_tech'] > "0"){$spal_tech="<td>Nap�d Spalinowy</td><td>{$szpiegwrog['combustion_tech']}</td></tr>";}
if($szpiegwrog['impulse_motor_tech'] > "0"){$imp_tech="<td>Nap�d Impulsowy</td><td>{$szpiegwrog['impulse_motor_tech']}</td>";}
if($szpiegwrog['hyperspace_motor_tech'] > "0"){$napna_tech="<td>Nap�d Nadprzestrzenny</td><td>{$szpiegwrog['hyperspace_motor_tech']}</td></tr>";}
if($szpiegwrog['laser_tech'] > "0"){$las_tech="<td>Technologia Laserowa</td><td>{$szpiegwrog['laser_tech']}</td>";}
if($szpiegwrog['ionic_tech'] > "0"){$jon_tech="<td>Technologia Jonowa</td><td>{$szpiegwrog['ionic_tech']}</td></tr>";}
if($szpiegwrog['buster_tech'] > "0"){$plaz_tech="<td>Technologia Plazmowa</td><td>{$szpiegwrog['buster_tech']}</td>";}
if($szpiegwrog['intergalactic_tech'] > "0"){$msbn_tech="<td>Mi�dzygalaktyczna Sie� Bada� Naukowych</td><td>{$szpiegwrog['intergalactic_tech']}</td></tr>";}
if($szpiegwrog['graviton_tech'] > "0"){$gra_tech="<td>Rozw�j Grawiton�w</td><td>{$szpiegwrog['graviton_tech']}</td>";}

$badania="<table width=440><tr><td class=c colspan=4> Surowce na {$idwroga['name']}[{$idwroga['galaxy']}:{$idwroga['system']}:{$idwroga['planet']}]".gmdate("d-m-Y H:i:s",time()+2*60*60)."</td></tr><tr><td>Metal:</td><td>".pretty_number($idwroga['metal'])."</td><td>Kryszta�:</td><td>".pretty_number($idwroga['crystal'])."</td></tr> <tr><td>Deuter:</td><td>".pretty_number($idwroga['deuterium'])."</td> <td>Energia:</td><td>".pretty_number($idwroga['energy_max'])."</td></tr> </table><table width=440><tr><td class=c colspan=6>Floty</td></tr>$mt$dt$lm$cm$kr$ow$colon$recek$spysonda$bombo$satki$niszcz$gwiazdeczka$panc </table> <table width=440><tr><td class=c colspan=4>Obrona</td></tr>$ml$sl$bl$gauss$ionic$buster$mp$dp </table> <table width=440><tr><td class=c colspan=6>Budynki</td></tr></tr>$kop_metal$kop_krysia$kop_deut$solar$fusion$robot$nano$stocznia$mag_mety$mag_krysi$mag_deut$lab$tetra$allydepo$silos</table><table width=440><tr><td class=c colspan=4>Badania   </td></tr></tr>$spy_tech$pc_tech$boj_tech$obr_tech$op_tech$ene_tech$nadp_tech$spal_tech$imp_tech$napna_tech$las_tech$jon_tech$plaz_tech$msbn_tech$gra_tech</table>";
$szansamax = (($idwroga['small_ship_cargo'] + $idwroga['big_ship_cargo'] + $idwroga['light_hunter'] + $idwroga['heavy_hunter'] + $idwroga['crusher'] + $idwroga['battle_ship'] + $idwroga['colonizer'] + $idwroga['recycler'] + $idwroga['spy_sonde'] + $idwroga['bomber_ship'] + $idwroga['solar_satelit'] + $idwroga['destructor'] + $idwroga['dearth_star'] + $idwroga['battleship'] + $idwroga['destruktor'])*$LS)/4; 
//********************************************************************************************
//Trzeba jeszcze doda� zale�no�� przewagi technologii szpiegowskiej:
//-Ten sam poziom techniki, ok 4 statki daja 1% szans na zestrzelenie
//-Przeciwnik ma tech szpieg o jeden poziom nizsz�, ok 8 statkow daje 1% szans na zestrzelenie
//-Przeciwnik ma tech szpieg o dwa poziomy nizsz�, ok 16 statkow daje 1% szans na zestrzelenie 
//i odwrotnie.
//********************************************************************************************
if($szansamax > 100)
	{$szansamax = 100;}
$szansawzor = rand(0, $szansamax);
$szansazest = rand(0, 100);
if($szansawzor >= $szansazest)
{$wiadja = "<font color=\"red\">Zestrzelona</font>";
$wiadty = ", naszcz�cie dzi�ki zaawansowanej technologii uda�o si� j� przechwyci� i zestrzeli�!";}
elseif($szansawzor < $szansazest)
{$wiadja = "<font color=\"lime\">Ocalona</font>";
$wiadty = "";}
$szansa=" <center> Szansa na przechwycenie sond: $szansawzor% <br><b>$wiadja</b></center> </td> </tr>";


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
if ($f["fleet_mess"] != "1")
{
doquery("INSERT INTO {{table}} SET
                     `message_owner`='{$f['fleet_owner']}',
                     `message_sender`='',
                     `message_time`='".time()."',
                     `message_type`='0',
                     `message_from`='Dow�dztwo floty',
                     `message_subject`='Raport Szpiegowski',
                     `message_text`='$surka<br> $szansa'"
                     ,'messages');              
doquery("UPDATE {{table}} SET new_message=new_message+1 WHERE id='{$f['fleet_owner']}'",'users'); 
doquery("INSERT INTO {{table}} SET
                     `message_owner`='{$idwrog}',
                     `message_sender`='',
                     `message_time`='".time()."',
                     `message_type`='0',
                     `message_from`='Dow�dztwo floty',
                     `message_subject`='Obca Flota (szpiegowanie)',
                     `message_text`='Obca Flota z planety {$messmoja['name']} zawita�a na planecie {$idwroga['name']} $wiadty'"
                     ,'messages');              
doquery("UPDATE {{table}} SET new_message=new_message+1 WHERE id='{$idwrog}'",'users'); 
doquery("UPDATE {{table}} SET fleet_mess='1' WHERE fleet_id=".$f["fleet_id"],'fleets');
}
}
if ($ST == "2")
{
if ($f["fleet_mess"] != "1")
{
doquery("INSERT INTO {{table}} SET
                     `message_owner`='{$f['fleet_owner']}',
                     `message_sender`='',
                     `message_time`='".time()."',
                     `message_type`='0',
                     `message_from`='Dow�dztwo floty',
                     `message_subject`='Raport Szpiegowski',
                     `message_text`='$flota<br> $szansa'"
                     ,'messages');              
doquery("UPDATE {{table}} SET new_message=new_message+1 WHERE id='{$f['fleet_owner']}'",'users'); 
doquery("INSERT INTO {{table}} SET
                     `message_owner`='{$idwrog}',
                     `message_sender`='',
                     `message_time`='".time()."',
                     `message_type`='0',
                     `message_from`='Dow�dztwo floty',
                     `message_subject`='Obca Flota (szpiegowanie)',
                     `message_text`='Obca Flota z planety {$messmoja['name']} zawita�a na planecie {$idwroga['name']} $wiadty'"
                     ,'messages');              
doquery("UPDATE {{table}} SET new_message=new_message+1 WHERE id='{$idwrog}'",'users'); 
doquery("UPDATE {{table}} SET fleet_mess='1' WHERE fleet_id=".$f["fleet_id"],'fleets');
}
}
if ($ST == "4" or $ST == "3")
{
if ($f["fleet_mess"] != "1")
{
doquery("INSERT INTO {{table}} SET
                     `message_owner`='{$f['fleet_owner']}',
                     `message_sender`='',
                     `message_time`='".time()."',
                     `message_type`='0',
                     `message_from`='Dow�dztwo floty',
                     `message_subject`='Raport Szpiegowski',
                     `message_text`='$obrona<br> $szansa'"
                     ,'messages');              
doquery("UPDATE {{table}} SET new_message=new_message+1 WHERE id='{$f['fleet_owner']}'",'users'); 
doquery("INSERT INTO {{table}} SET
                     `message_owner`='{$idwrog}',
                     `message_sender`='',
                     `message_time`='".time()."',
                     `message_type`='0',
                     `message_from`='Dow�dztwo floty',
                     `message_subject`='Obca Flota (szpiegowanie)',
                     `message_text`='Obca Flota z planety {$messmoja['name']} zawita�a na planecie {$idwroga['name']} $wiadty'"
                     ,'messages');              
doquery("UPDATE {{table}} SET new_message=new_message+1 WHERE id='{$idwrog}'",'users'); 
doquery("UPDATE {{table}} SET fleet_mess='1' WHERE fleet_id=".$f["fleet_id"],'fleets');
}
}
if ($ST == "5" or $ST == "6")
{
if ($f["fleet_mess"] != "1")
{
doquery("INSERT INTO {{table}} SET
                     `message_owner`='{$f['fleet_owner']}',
                     `message_sender`='',
                     `message_time`='".time()."',
                     `message_type`='0',
                     `message_from`='Dow�dztwo floty',
                     `message_subject`='Raport Szpiegowski',
                     `message_text`='$budynki<br> $szansa'"
                     ,'messages');              
doquery("UPDATE {{table}} SET new_message=new_message+1 WHERE id='{$f['fleet_owner']}'",'users'); 
doquery("INSERT INTO {{table}} SET
                     `message_owner`='{$idwrog}',
                     `message_sender`='',
                     `message_time`='".time()."',
                     `message_type`='0',
                     `message_from`='Dow�dztwo floty',
                     `message_subject`='Obca Flota (szpiegowanie)',
                     `message_text`='Obca Flota z planety {$messmoja['name']} zawita�a na planecie {$idwroga['name']} $wiadty'"
                     ,'messages');              
doquery("UPDATE {{table}} SET new_message=new_message+1 WHERE id='{$idwrog}'",'users'); 
doquery("UPDATE {{table}} SET fleet_mess='1' WHERE fleet_id=".$f["fleet_id"],'fleets');
}
}
if ($ST >= "7")
{
if ($f["fleet_mess"] != "1")
{
doquery("INSERT INTO {{table}} SET
                     `message_owner`='{$f['fleet_owner']}',
                     `message_sender`='',
                     `message_time`='".time()."',
                     `message_type`='0',
                     `message_from`='Dow�dztwo floty',
                     `message_subject`='Raport Szpiegowski',
                     `message_text`='$badania<br> $szansa'"
                     ,'messages');              
doquery("UPDATE {{table}} SET new_message=new_message+1 WHERE id='{$f['fleet_owner']}'",'users'); 
doquery("INSERT INTO {{table}} SET
                     `message_owner`='{$idwrog}',
                     `message_sender`='',
                     `message_time`='".time()."',
                     `message_type`='0',
                     `message_from`='Dow�dztwo floty',
                     `message_subject`='Obca Flota (szpiegowanie)',
                     `message_text`='Obca Flota z planety {$messmoja['name']} zawita�a na planecie {$idwroga['name']} $wiadty'"
                     ,'messages');              
doquery("UPDATE {{table}} SET new_message=new_message+1 WHERE id='{$idwrog}'",'users'); 
doquery("UPDATE {{table}} SET fleet_mess='1' WHERE fleet_id=".$f["fleet_id"],'fleets');
}
}
if($szansawzor >= $szansazest)
{
doquery("UPDATE {{table}} SET crystal=$debsc+$debss WHERE id_planet='{$idwroga['id']}'",'galaxy');
doquery("DELETE FROM {{table}} WHERE fleet_id=".$f["fleet_id"],'fleets');
doquery("UPDATE {{table}} SET 
`points_fleet2`='points_fleet2-$LS',
`points_fleet_old`='points_fleet_old-$LS*1000'
WHERE id='{$user['id']}'",'users');
}
//echo $rapT;
}
			}}
else{				if($f['fleet_end_time']<=time()){
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

}}
}}
			break;}
			
			//
			//--[7:Zatrzymaj]--------------------------------------------------
			//
			case 7:
			//
			//--[8:Zbieraj]--------------------------------------------------
			//
			case 8:
			//
			//--[9:Kolonizuj]-----------------------------------------------
			//
			case 9:
				
				
$limit_planet=15;
$ilosc=mysql_result(doquery("SELECT count(208) FROM {{table}} WHERE id_owner='{$f['fleet_owner']}'",'planets'),0);
if($ilosc>=$limit_planet){
doquery("INSERT INTO {{table}} SET
                     `message_owner`='{$f['fleet_owner']}',
                     `message_sender`='',
                     `message_time`='".time()."',
                     `message_type`='0',
                     `message_from`='Dow�dztwo floty',
                     `message_subject`='Kolonizacja',
                     `message_text`='Kolonizacja planety [{$f['fleet_end_galaxy']}:{$f['fleet_end_system']}:{$f['fleet_end_planet']}] nie powiod�a si�, poniewa� masz ju� 15 planet...'"
                     ,'messages');              
doquery("UPDATE {{table}} SET new_message=new_message+1 WHERE id='{$f['fleet_owner']}'",'users'); 
 }else
if(make_planet($f['fleet_end_galaxy'],$f['fleet_end_system'],$f['fleet_end_planet'],$f['fleet_owner']))
					{
			doquery("INSERT INTO {{table}} SET 
				`message_owner`='{$f['fleet_owner']}',
				`message_sender`='',
				`message_time`='".time()."',
				`message_type`='0',
				`message_from`='Dow�dztwo Floty',
				`message_subject`='Kolonizacja',
				`message_text`='Planeta [{$f['fleet_end_galaxy']}:{$f['fleet_end_system']}:{$f['fleet_end_planet']}] zosta�a skolonizowana'"
				,'messages');
					}else{echo "error";}
			default:
			doquery("DELETE FROM {{table}} WHERE fleet_id=".$f["fleet_id"],'fleets');

			
		}
	}

}
function get_max_field(&$planet){
return $planet["field_max"]+($planet["terraformer"]*5);
} 
//*********************************************************************************************************
//Powered by Perberos and other people 2006-2007. All rights reserved!!!
//*********************************************************************************************************
?>
