<?php //galaxy.php rapaired by DxPpLmOs

define('INSIDE', true);
$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);
include('ban.php');


if(!check_user()){ header("Location: login.php"); die();}

//
// Esta funcion permite cambiar el planeta actual.
//
include($ugamela_root_path . 'includes/planet_toggle.'.$phpEx);

$planetrow = doquery("SELECT * FROM {{table}} WHERE id={$user['current_planet']}",'planets',true);
$lunarow = doquery("SELECT * FROM {{table}} WHERE id={$user['current_luna']}",'lunas',true);
$galaxyrow = doquery("SELECT * FROM {{table}} WHERE id_planet={$planetrow['id']}",'galaxy',true);
$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
$mnoznik = $game_config['resource_multiplier'];
$fleetmax = $user['computer_tech']+1;
$mojaplaneta = doquery("SELECT * FROM {{table}} WHERE id={$user['current_planet']}",'planets',true);
$rmp = $mojaplaneta['interplanetary_misil'];
$recek = $mojaplaneta['recycler'];
$probes = $mojaplaneta['spy_sonde'];

$maxfleet = doquery("SELECT * FROM {{table}} WHERE fleet_owner='{$user['id']}'",'fleets');
$maxfleet_count = mysql_num_rows($maxfleet);

check_field_current($planetrow);
check_field_current($lunarow);

	if($_POST["galaxyLeft"]){
	
	if ($_POST["galaxy"] < 1)
	    {$_POST["galaxy"] = 1;}
	elseif ($_POST["galaxy"] == 1)
	    {$_POST["galaxy"] = 1;}
        else{
	    $galaxy = $_POST["galaxy"] -1;
	    }
	}elseif($_POST["galaxyRight"]){
	
	if ($_POST["galaxy"] > 9 or $_POST["galaxyRight"] > 9 or $galaxy > 9)
		{$_POST["galaxy"] = 9;
		 $_POST["galaxyRight"] = 9;
		 $galaxy = 9;
		}
	elseif ($_POST["galaxy"] == 9)
	    {$_POST["galaxy"] = 9;
	     $galaxy = 9;}
	    else{
		$galaxy =  $_POST["galaxy"] +1;
		}
	}

function echo_galaxy($g,$s){

	global $planetcount,$dpath,$user;
  
	for($i = 1; $i < 16; $i++){//mega loop para listar los jugadores y las alianzas
		unset($planetrow);
		unset($lunarow);
		
		unset($playerrow);
		unset($allyrrow);
		
		//$planet = doquery( ,"galaxy",true);
		
		$galaxyrow = doquery("SELECT * FROM {{table}} WHERE galaxy = '$g' AND system='$s' AND planet = '$i' AND luna = '$l'","galaxy",true);
		
	if($galaxyrow){
		$planetrow = doquery("SELECT * FROM {{table}} WHERE id = '".$galaxyrow["id_planet"]."'","planets",true);
		$lunarow = doquery("SELECT * FROM {{table}} WHERE id = '".$galaxyrow["id_luna"]."'","lunas",true);
		
		/*
		  Pequeña conprovacion para verificar que un planeta esta destruido
		  En caso de que sea cierto, este se quita de la base de datos si cumplio el maximo
		  de tiempo establecido en el campo destruyed
		*/
		
		if($planetrow["destruyed"] != 0 and $planetrow["id_owner"] != '' and $galaxyrow["id_planet"] != ''){
			check_abandon_planet($planetrow);
		}else{
		$planetcount++;
		$playerrow = doquery("SELECT * FROM {{table}} WHERE id = '".$planetrow["id_owner"]."'","users",true);
		}
		
		if($lunarow["destruyed"] != 0){
			check_abandon_luna($lunarow);
		}else{
//		$lunacount++;
//		$playerrow = doquery("SELECT * FROM {{table}} WHERE id = '".$lunarow["id_owner"]."'","users",true);
		}
	}
		echo '
    <tr>
    <th width="30">
      <a href="#"';
	  
		$tabindex = $i + 1;
		$tab = ($galaxyrow["id_planet"] != 0) ? " tabindex=\"$tabindex\">": ">";
		
		echo $tab.$i;
		echo'</a>
    </th>
    <th width="30">
     ';
	   $nieaktplanetquery = doquery("SELECT * FROM {{table}} WHERE id='{$planetrow['id_owner']}'",'users',true); 
  if($galaxyrow && $planetrow["destruyed"] == 0 && $galaxyrow["id_planet"] != 0){
  if($nieaktplanetquery['id'] != $user['id'])
	  {$szpiegowanie = "<a href=\'javascript:doit(6, $g, $s, $i, 1, {$user["spio_anz"]});\'>Espionage</a><br /><br />";}
  elseif($nieaktplanetquery['id'] == $user['id'])
		  {$szpiegowanie = "";}
   if($nieaktplanetquery['id'] != $user['id'])
	  {$atakowanie = "<a href=\'fleet.php?galaxy=$g&amp;system=$s&amp;planet=$i&amp;planettype=1&amp;target_mission=1\'>Attack</a><br />";}
  elseif($nieaktplanetquery['id'] == $user['id'])
		  {$atakowanie = "";}
     if($nieaktplanetquery['id'] != $user['id'])
	  {$zatrzymaj = "<a href=\'fleet.php?galaxy=$g&system=$s&planet=$i&planettype=1&target_mission=2\'>ACS Defend</a><br />";}
  elseif($nieaktplanetquery['id'] == $user['id'])
		  {$zatrzymaj = "";}
    if($nieaktplanetquery['id'] == $user['id'])
	  {$stacjonuj = "<a href=\'fleet.php?galaxy=$g&system=$s&planet=$i&planettype=1&target_mission=4\'>Deploy<br />";}
  elseif($nieaktplanetquery['id'] != $user['id'])
		  {$stacjonuj = "";}
  $transportuj = "<a href=\'fleet.php?galaxy=$g&system=$s&planet=$i&planettype=1&target_mission=3\'>Transport</a>";
  
  ?>
<a style="cursor: pointer;" onmouseover="this.T_WIDTH=250;this.T_OFFSETX=-110;this.T_OFFSETY=-30;this.T_STICKY=true;this.T_TEMP=<?php $T_TEMP = $user["settings_tooltiptime"]*1000; echo $T_TEMP; ; ?>;this.T_STATIC=true;return escape('<table width=\'240\'><tr><td class=\'c\' colspan=\'2\'>Planet Name <?php echo $planetrow["name"]." [$g:$s:$i]"; ?></td></tr><tr><th width=\'80\'><img src=\'<?php echo $dpath."planeten/small/s_".$planetrow["image"].".jpg"; ?>\' height=\'75\' width=\'75\'/></th><th style=\'text-align: left\'> <?php echo $szpiegowanie; ?> <?php echo $atakowanie; ?> <?php echo $zatrzymaj; ?> <?php echo $stacjonuj; ?> <?php echo $transportuj; ?></th></tr></table>');">
      <img src="<?php echo $dpath."planeten/small/s_".$planetrow["image"].".jpg"; ?>" height="30" width="30"></a>
<?php
  }
?>
</th>
<th style="white-space: nowrap;" width="130">
<?php 
 $nieaktplanetquery = doquery("SELECT * FROM {{table}} WHERE id='{$planetrow['id_owner']}'",'users',true); 
$activeplanetquery = doquery("SELECT * FROM {{table}} WHERE name='{$planetrow['name']}'",'planets',true);
if($nieaktplanetquery['ally_id'] == $user['ally_id'] and $nieaktplanetquery['id'] != $user['id'] and $user['ally_id'] != '')
		{
			$kolorname = "<font color=\"green\">";
			$kolorend = "</font>";}
			
elseif($nieaktplanetquery['id'] == $user['id'])
		{
			$kolorname = "<font color=\"red\">";
			$kolorend = "</font>";}
			else
				{
			$kolorname = '';
			$kolorend = "";}

if($activeplanetquery['last_update'] > (time()-59*60) and $nieaktplanetquery['id'] != $user['id'])
    {
	$czas = pretty_time_hour(time()-$activeplanetquery['6']);
    }	
if($galaxyrow && $planetrow["destruyed"] == 0)
{ 
  echo $kolorname ,$planetrow{"name"} ,$kolorend;
 if ($activeplanetquery['last_update'] > (time()-59*60) and $nieaktplanetquery['id'] != $user['id'])
 {
     if ($activeplanetquery['last_update'] > (time()-10*60) and $nieaktplanetquery['id'] != $user['id'])
     {
echo "(*)";
    }
    else
    {
      echo "({$czas})"; 
	  
    }
 }
}

  
  elseif ($planetrow["destruyed"] != 0){echo "Porzucona Planeta";} ?></th>
<th style="white-space: nowrap;" width="30">
<?   
	  $nieaktmoonquery = doquery("SELECT * FROM {{table}} WHERE id_owner='{$planetrow['id_owner']}'",'lunas',true); 
  if($nieaktmoonquery['id_owner'] != $user['id'])
	  {$szpiegowaniem = "<a href=\'floten3.php?galaxy=$g&system=$s&planet=$i&planettype=3&target_mission=6\'>Espionage</a><br /><br />";}
  elseif($nieaktmoonquery['id_owner'] == $user['id'])
		  {$szpiegowaniem = "";}
   if($nieaktmoonquery['id_owner'] != $user['id'])
	  {$atakowaniem = "<a href=\'fleet.php?galaxy=$g&system=$s&planet=$i&planettype=3&target_mission=1\'>Attack</a><br />";}
  elseif($nieaktmoonquery['id_owner'] == $user['id'])
		  {$atakowaniem = "";}
     if($nieaktmoonquery['id_owner'] != $user['id'])
	  {$zatrzymajm = "<a href=\'fleet.php?galaxy=$g&system=$s&planet=$i&planettype=3&target_mission=2\'>Transport</a><br />";}
  elseif($nieaktmoonquery['id_owner'] == $user['id'])
		  {$zatrzymajm = "";}
    if($nieaktmoonquery['id_owner'] == $user['id'])
	  {$stacjonujm = "<a href=\'fleet.php?galaxy=$g&system=$s&planet=$i&planettype=3&target_mission=4\'>Deploy</a><br />";}
  elseif($nieaktmoonquery['id_owner'] != $user['id'])
		  {$stacjonujm = "";}
  if($nieaktmoonquery['id_owner'] != $user['id'])
	  {$niszczm = "<a href=\'fleet.php?galaxy=$g&system=$s&planet=$i&planettype=3&target_mission=5\'>Destroy</a><br />";}
  elseif($nieaktmoonquery['id_owner'] == $user['id'])
		  {$niszczm = "";}
  $transportujm = "<a href=\'fleet.php?galaxy=$g&system=$s&planet=$i&planettype=3&target_mission=3\'>Transport<br /></a>";
	  if($galaxyrow && $lunarow["destruyed"] == 0 && $galaxyrow["id_luna"] != 0){
  ?>
<a href="fleet.php?galaxy=<?php echo $g; ?>&amp;system=<?php echo $s; ?>&amp;planet=<?php echo $i; ?>&amp;planettype=3&amp;target_mission=3" style="cursor: pointer;" onmouseover="this.T_WIDTH=250;this.T_OFFSETX=-110;this.T_OFFSETY=-110;this.T_STICKY=true;this.T_TEMP=<?php $T_TEMP = $user["settings_tooltiptime"]*1000; echo $T_TEMP; ; ?>;return escape('<table width=\'240\'><tr><td class=\'c\' colspan=\'2\'><?php echo $lunarow["name"]; ?> <?php echo "[$g:$s:$i]"; ?></td></tr><tr><th width=\'80\'><img src=\'<?php echo $dpath; ?>planeten/mond.jpg\' height=\'75\' width=\'75\' alt=\'T\'/></th><th><table><tr><td class=\'c\' colspan=\'2\'>Properties</td></tr><tr><th>Size:</th><th><?php echo number_format($lunarow["diameter"],0, '', '.'); ?></th></tr><tr><th>Temp:</th><th><?php echo number_format($lunarow["temp_min"],0, '', '.'); ?></th></tr><tr><td class=\'c\' colspan=\'2\'>Actions:</tr><tr><th colspan=\'2\' style=\'text-align: left\'><?php echo $szpiegowaniem; ?> <?php echo $transportujm; ?> <?php echo $stacjonujm; ?> <?php echo $atakowaniem; ?> <?php echo $zatrzymajm; ?> <?php echo $niszczm; ?></tr></table></th></tr></table>');">
      <img src="<?php echo $dpath."planeten/small/s_mond.jpg"; ?>" height="22" width="22"></a>
<?php
  }
?> 
</th>


<?php //Para mostrar escombros


	if($galaxyrow){
		
		if($galaxyrow["metal"] != 0 || $galaxyrow["crystal"] != 0 )
		{
			echo "\n	    <th style=\""; 
			//muestra de color rojo el fondo cuando hay muchos recursos
			if (($galaxyrow["metal"] + $galaxyrow["crystal"]) >= 10000000)
				echo "background-color: rgb(100, 0, 0);";
			elseif (($galaxyrow["metal"] + $galaxyrow["crystal"]) >= 1000000)
				echo "background-color: rgb(100, 100, 0);";
			elseif (($galaxyrow["metal"] + $galaxyrow["crystal"]) >= 100000)
				echo "background-color: rgb(0, 100, 0);";
		

?>background-image: none;" width="30">

	<a href="fleet.php?galaxy=<?php echo $g; ?>&amp;system=<?php echo $s; ?>&amp;planet=<?php echo $i; ?>&amp;planettype=2&amp;target_mission=8" style="cursor: pointer;" onmouseover="this.T_WIDTH=250;this.T_OFFSETX=-110;this.T_OFFSETY=-110;this.T_STICKY=true;this.T_TEMP=<?php $T_TEMP = $user["settings_tooltiptime"]*1000; echo $T_TEMP; ; ?>;return escape('<table width=\'240\'><tr><td class=\'c\' colspan=\'2\'>Debris field <?php echo "[$g:$s:$i]"; ?></td></tr><tr><th width=\'80\'><img src=\'<?php echo $dpath; ?>planeten/debris.jpg\' height=\'75\' width=\'75\' alt=\'T\'/></th><th><table><tr><td class=\'c\' colspan=\'2\'>Resources:</td></tr><tr><th>Metal:</th><th><?php echo number_format($galaxyrow["metal"],0, '', '.'); ?></th></tr><tr><th>Crystal:</th><th><?php echo number_format($galaxyrow["crystal"],0, '', '.'); ?></th></tr><tr><td class=\'c\' colspan=\'2\'>Actions:</tr><tr><th colspan=\'2\' style=\'text-align: left\'><a href=\'javascript:doit(8, <?php echo $g; ?>, <?php echo $s; ?>, <?php echo $i; ?>, 1, <?php echo $user["spio_anz"]?>);\'>Harvest</a></tr></table></th></tr></table>');">
<img src="<?php echo $dpath; ?>planeten/debris.jpg" alt="Harabe Alani" height="22" width="22"></a>

	  <?php
	  }else{
		echo "	      </th> \n    <th width=\"30\">";
	}//Fin escombros
	}else{
		echo "	      </th> \n    <th width=\"30\">";
	}//Fin escombros
	
echo "\n\n   </th>\n    <th width=\"150\"> \n\n     ";

  if($playerrow  && $planetrow["destruyed"] == 0){
	$noobquery2 = doquery("SELECT * FROM {{table}} WHERE config_name='noobprotection'",'config',true);
$noobquery3 = doquery("SELECT * FROM {{table}} WHERE config_name='noobprotectiontime'",'config',true);
$noobquery4 = doquery("SELECT * FROM {{table}} WHERE config_name='noobprotectionmulti'",'config',true);
  
  $nieaktplanetquery = doquery("SELECT * FROM {{table}} WHERE id='{$planetrow['id_owner']}'",'users',true); 
  $noobja = $user['points_points'];
   $noobty = $nieaktplanetquery['points_points'];
   $mnozenieja = $noobja*$noobquery4['config_value'];
	   $mnozeniety = $noobty*$noobquery4['config_value'];
 if ($nieaktplanetquery['bana'] == 1 and $nieaktplanetquery['urlaubs_modus'] == 1)
	  {
$status2 = "u <a href=\"banned.php\"><span class=\"banned\">g</span></a>";
$status = '<span class="vacation">';}
 elseif ($nieaktplanetquery['bana'] == 1)
	  {
$status2 = "<a href=\"banned.php\"><span class=\"banned\">g</span></a>";
$status = '';}
elseif ($nieaktplanetquery['urlaubs_modus'] == 1)
	  {
$status2 = "<span class=\"vacation\">u</span>";
$status = '<span class="vacation">';
}
elseif ($nieaktplanetquery['onlinetime'] < (time()-60*60*24*7) and $nieaktplanetquery['onlinetime'] > (time()-60*60*24*28))
 {
$status2 = "<span class=\"inactive\">i</span>";
       $status = '<span class="inactive">';
}
elseif ($nieaktplanetquery['onlinetime'] < (time()-60*60*24*28))
	  {
$status2 = "<span class=\"inactive\">i</span><span class=\"longinactive\"> I</span>";
   $status = '<span class="longinactive">';
}
elseif ($mnozeniety < $noobja and $noobquery2['config_value'] == 1 and $noobquery3['config_value']*1000 > $noobty)
	  {
$status2 = "<span class=\"noob\">s</span>";
$status = '<span class="noob">';
}
elseif ($noobty > $mnozenieja and $noobquery2['config_value'] == 1 and $noobquery3['config_value']*1000 > $noobja)
	  {
$status2 = "d";
$status = '<span class="strong">';
}
else
	  {
$status2 = "";
$status = '';
}
if($nieaktplanetquery['rank'] < 1501)
	  {
$status3 = "Rank: ";
	$status4 = $nieaktplanetquery['rank'];}
else
{
	$status3 = "";
	$status4 = "";}
if($status2 != '')
	  {$status6 = "<font color=\"white\">(</font>";
$status7 = "<font color=\"white\">)</font>";}
if($status2 == '')
	  {$status6 = "";
$status7 = "";}
if($nieaktplanetquery['authlevel'] > 0)
	  {
$admin = "<font color=\"lime\"><blink>A</blink></font>";}
elseif($nieaktplanetquery['authlevel'] == 0)
	  {$admin = "";}
?>
<a style="cursor: pointer;" onmouseover="this.T_WIDTH=200;this.T_OFFSETX=-20;this.T_OFFSETY=-30;this.T_STICKY=true;this.T_TEMP=<?php $T_TEMP = $user["settings_tooltiptime"]*1000; echo $T_TEMP; ; ?>;return escape('<table width=\'190\'><tr><td class=\'c\' colspan=\'2\'>Player Name :<?php echo $playerrow["username"];?> <?php echo $status3;?> <?php echo $status4;?></td></tr><tr><td><a href=\'messages.php?mode=write&id=<?php echo $playerrow["id"];?>\'>Message User</a></td></tr><tr><td><a href=\'buddy.php?a=2&u=<?php echo $playerrow["id"];?>\'>Request Buddy List</a></td></tr></table>');"><?php echo $status;?><?php echo $playerrow["username"];?></span> <?php echo $status6;?><?php echo $status;?><?php echo $status2;?><?php echo $status7;?> <?php echo $admin;?></span></a>

<?php
}//(<span class="noob">d</span>)
?>

</th>
<th width="80">
<?php
//Alianzas!

if($playerrow['ally_id'] &&$playerrow['ally_id'] !=0){
	
	$allyquery = doquery("SELECT * FROM {{table}} WHERE id=".$playerrow['ally_id'],"alliance",true);
if($allyquery["ally_web"] == '')
	{$allywww = '';}
if($allyquery["ally_web"] != '')
	{$allywww = "Strona WWW sojuszu";}
	if($allyquery){
		$members_count = doquery("SELECT COUNT(DISTINCT(id)) FROM {{table}} WHERE ally_id=".$allyquery['id'].";","users",true);
		echo "<a style=\"cursor:pointer\" onmouseover=\"this.T_WIDTH=250;this.T_OFFSETX=-30;this.T_OFFSETY=-30;this.T_STICKY=true;this.T_TEMP=5000;return escape('&lt;table width=\'240\'&gt;&lt;tr&gt;&lt;td class=\'c\'&gt;Alliance Name : ".$allyquery['ally_name']." Total Members :".$members_count[0]. "&gt;&lt;th&gt;&lt;table&gt;&lt;tr&gt;&lt;td&gt;&lt;a href=\'alliance.php?mode=ainfo&a=".$allyquery['id']."\'&gt;Alliance Information&lt;/a&gt;&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td&gt;&lt;a href=\'stat.php?start=101&who=ally\'&gt;Alliance Stats&lt;/a&gt;&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td&gt;&lt;a href=\'".$allyquery["ally_web"]."\' target=\'_new\'&gt;$allywww &lt;/td&gt;&lt;/tr&gt;&lt;/table&gt;&lt;/th&gt;&lt;/table&gt;');\">";
		echo $allyquery['ally_tag']."</a>";
	}
}

?>

<a href=\'fleet.php?galaxy=<?php echo $g; ?>&system=<?php echo $s; ?>&planet=<?php echo $i; ?>&planettype=1&target_mission=1\'>
</th>
<th style="white-space: nowrap;" width="125">

<?php
	$mojaplaneta = doquery("SELECT * FROM {{table}} WHERE id={$user['current_planet']}",'planets',true);
if($user['impulse_motor_tech'] > 0)
		{$zrmp = $user['impulse_motor_tech']*2-1;}
elseif($user['impulse_motor_tech'] == 0)
	{$zrmp = 0;}
if($s-$mojaplaneta['system'] > 0)
		{
$odlegloscsystem = $s-$mojaplaneta['system'];
		}
elseif($s-$mojaplaneta['system'] < 0)
	{
$odlegloscsystem = ($s-$mojaplaneta['system'])*-1;
		}
  if($playerrow && $planetrow["destruyed"] == 0){
if($user["settings_mis"] == "1" and $mojaplaneta['silo'] > 3 and $odlegloscsystem <= $zrmp){
		?>
<a href="fleet.php?galaxy=<?php echo $g; ?>&system=<?php echo $s; ?>&planet=<?php echo $i; ?>&planettype=1&target_mission=X"><img src="<?php echo $dpath; ?>img/r.gif" alt="Attack" title="Attack" border="0"></a>
		<?php
	}
	if($user["settings_esp"] == "1"){
	
		?><a style="cursor: pointer;" onclick="<?php
		echo "javascript:doit(6, $g, $s, $i, 1, {$user["spio_anz"]});";
		?>"><img src="<?php echo $dpath; ?>img/e.gif" alt="Espionage" title="Espionage" border="0"></a>
		<?php
	}
	if($user["settings_wri"] == "1"){
		?>
<a href="messages.php?mode=write&id=<?php echo $playerrow["id"];?>"><img src="<?php echo $dpath; ?>img/m.gif" alt="Message User" title="Message User" border="0"></a>
		<?php
	}
	if($user["settings_bud"] == "1"){
		?>
<a href="buddy.php?a=2&amp;u=<?php echo $playerrow["id"];?>"><img src="http://gameo.ath.cx:8080/images/img/b.gif" alt="Request Buddy" title="Request Buddy" border="0"></a>
<?php	}
  }
?></th>
</tr>
<?php
	}
	
}


$planetcount = 0;
$lunacount = 0;
if(isset($g) && isset($s)){
	$galaxy =  $g;
	$system =  $s;
	if ($g > 9)
	{
	$galaxy = 9;
	}
	if ($s > 499)
	{
	$system = 499;
	}
}elseif(!$_POST){

	$planetrow = doquery("SELECT * FROM {{table}} WHERE id = '".$user["current_planet"]."'","planets",true);
//	$lunarow = doquery("SELECT * FROM {{table}} WHERE id = '".$user["current_luna"]."'","lunas",true);

	$galaxyrow = doquery("SELECT * FROM {{table}} WHERE id_planet = '".$planetrow["id"]."'","galaxy",true);
	//la posicion actual donde se encuentra el planeta activo.
	$galaxy =  (!$galaxy) ? $galaxyrow["galaxy"] : $galaxy;
	$system =  (!$system) ? $galaxyrow["system"] : $system;
  
}else{
	//Agrega o quita +1 en $galaxy
	if($_POST["galaxyLeft"]){
	
	if ($_POST["galaxy"] < 1)
	    {$_POST["galaxy"] = 1;}
	elseif ($_POST["galaxy"] == 1)
	    {$_POST["galaxy"] = 1;}
        else{
	    $galaxy = $_POST["galaxy"] -1;
	    }
	}elseif($_POST["galaxyRight"]){
	
	if ($_POST["galaxy"] > 9 or $_POST["galaxyRight"] > 9 or $galaxy > 9)
		{$_POST["galaxy"] = 9;
		 $_POST["galaxyRight"] = 9;
		 $galaxy = 9;
		}
	elseif ($_POST["galaxy"] == 9)
	    {$_POST["galaxy"] = 9;
	     $galaxy = 9;}
	    else{
		$galaxy =  $_POST["galaxy"] +1;
		}
	}else{
		$galaxy = (!$galaxy) ? $_POST["galaxy"] : $galaxy;//default
	}
	
	//Agrega o quita +1 en $system
	if($_POST["systemLeft"]){
	if ($_POST["system"] < 1)
	    {$_POST["system"] = 1;}
	elseif ($_POST["system"] == 1)
	    {$_POST["system"] = 1;}
        else{
	    $system = $_POST["system"] -1;
	    }
	}elseif($_POST["systemRight"]){
	if ($_POST["system"] > 499 or $_POST["systemRight"] > 499)
	{$_POST["system"] = 499;}
	elseif ($_POST["system"] == 499)
	{$_POST["system"] = 499;}
	else {
		$system =  $_POST["system"] +1;
		}
	}else{
		$system = (!$system) ? $_POST["system"] : $system;//default
	}

}




{

echo_head("Galaxia"); ?>
  <script language="JavaScript">
    function galaxy_submit(value) {
      document.getElementById('auto').name = value;
      document.getElementById('galaxy_form').submit();
    }

    function fenster(target_url,win_name) {
      var new_win = window.open(target_url,win_name,'resizable=yes,scrollbars=yes,menubar=no,toolbar=no,width=640,height=480,top=0,left=0');
new_win.focus();
    }
  </script><script language="JavaScript" src="scripts/tw-sack.js"></script><script type="text/javascript">
var ajax = new sack();
var strInfo = "";
      
function whenLoading(){
  //var e = document.getElementById('fleetstatus'); 
  //e.innerHTML = "{Sending_fleet}";
}
      
function whenLoaded(){
  //    var e = document.getElementById('fleetstatus'); 
  // e.innerHTML = "{Sent_fleet}";
}
      
function whenInteractive(){
  //var e = document.getElementById('fleetstatus'); 
  // e.innerHTML = "{Obtaining_data}";
}

/* 
   We can overwrite functions of the sack object easily. :-)
   This function will replace the sack internal function runResponse(), 
   which normally evaluates the xml return value via eval(this.response).
*/

function whenResponse(){

 /*
 *
 *  600   OK
 *  601   no planet exists there
 *  602   no moon exists there
 *  603   player is in noob protection
 *  604   player is too strong
 *  605   player is in u-mode 
 *  610   not enough Casusluk probes, sending x (parameter is the second return value)
 *  611   no Casusluk probes, nothing send
 *  612   no fleet slots free, nothing send
 *  613   not enough deuterium to send a probe
 *
 */

  // the first three digit long return value
  retVals = this.response.split(" ");
  // and the other content of the response
  // but since we only got it if we can send some but not all probes 
  // theres no need to complicate things with better parsing
  // each case gets a different table entry, no language file used :P
  switch(retVals[0]) {
  case "600":
    addToTable("done", "success");
        changeSlots(retVals[1]);
    setShips("probes", retVals[2]);
    setShips("recyclers", retVals[3]);
    setShips("missiles", retVals[4]);
        break;
  case "601":
    addToTable("Nie ma planety", "error");
    break;
  case "602":
    addToTable("Nie ma ksiezyca", "error");
    break;
  case "603":
    addToTable("Zayif Oyuncu", "error");
    break;
  case "604":
    addToTable("Gracz jest za mocny dla ciebie", "error");
    break;
  case "605":
    addToTable("Nie mozna skanowac graczy bedacych na urlopie", "vacation");
    break;
  case "610":
    addToTable("{error_only_x_available_probes_sending}", "notice");
    break;
  case "611":
    addToTable("Brak sond szpiegowskich", "error");
    break;
  case "612":
    addToTable("Basariyla Gönderildi", "error");
    break;
  case "613":
    addToTable("Masz za malo deuteru", "error");
    break;
  case "614":
    addToTable("Nie mozna skanowac planety nie skolonizowanej", "error");
    break;
  case "615":
    addToTable("{error_there_is_no_sufficient_fuel}", "error");
    break;
  case "616":
    addToTable("Multialarm!", "error");
    break;
  case "617":
	addToTable("Geri Donusumcu Yok", "error");
  break;
  case "618":
	addToTable("Gonderilecek Gemi Yok", "error");
  break;
  }
}

function doit(order, galaxy, system, planet, planettype, shipcount){
  	if(order==6)	
	strInfo = "Send "+shipcount+" "+(shipcount>1?"Espionage Probe":"Casus Sondasi")+" Coordinate "+galaxy+":"+system+":"+planet+"...";
   if(order==8)	
	strInfo = "Send"+shipcount+" "+(shipcount>1?"Geri Donusumcu":"Geri Donusumcu")+" Coordinate Message "+galaxy+":"+system+":"+planet+"...";

	//addToTable(strInfo+order,"notice");
    ajax.requestFile = "flotenajax.php?action=send";

    // no longer needed, since we don't want to write the cryptic
    // response somewhere into the output html
    //ajax.element = 'fleetstatus';
    //ajax.onLoading = whenLoading;
    //ajax.onLoaded = whenLoaded; 
    //ajax.onInteractive = whenInteractive;

    // added, overwrite the function runResponse with our own and
    // turn on its execute flag
    ajax.runResponse = whenResponse;
    ajax.execute = true;

    ajax.setVar("thisgalaxy", <?php echo $planetrow["galaxy"];?>)
    ajax.setVar("thissystem", <?php echo $planetrow["system"];?>);
    ajax.setVar("thisplanet", <?php echo $planetrow["planet"];?>);
    ajax.setVar("thisplanettype", <?php echo $planetrow["planet_type"];?>);
    ajax.setVar("mission", order);
    ajax.setVar("galaxy", galaxy);
    ajax.setVar("system", system);
    ajax.setVar("planet", planet);
    ajax.setVar("speedfactor", 1000);
    ajax.setVar("planettype", planettype);
    if(order==6)
    ajax.setVar("ship210", shipcount);
    if(order==8)
    ajax.setVar("ship209", shipcount);
    
    ajax.runAJAX();

}

/*
 * This function will manage the table we use to output up to three lines of
 * actions the user did. If there is no action, the tr with id 'fleetstatusrow'
 * will be hidden (display: none;) - if we want to output a line, its display 
 * value is cleaned and therefore its visible. If there are more than 2 lines 
 * we want to remove the first row to restrict the history to not more than 
 * 3 entries. After using the object function of the table we fill the newly
 * created row with text. Let the browser do the parsing work. :D
 */
function addToTable(strDataResult, strClass) {
  var e = document.getElementById('fleetstatusrow');
  var e2 = document.getElementById('fleetstatustable');

  // make the table row visible
  e.style.display = '';
  if(e2.rows.length > 2) {
    e2.deleteRow(2);
  }
  
  var row = e2.insertRow(0);

  var td1 = document.createElement("td");
  var td1text = document.createTextNode(strInfo);
  td1.appendChild(td1text);

  var td2 = document.createElement("td");

  var span = document.createElement("span");
  var spantext = document.createTextNode(strDataResult);

  var spanclass = document.createAttribute("class");
  spanclass.nodeValue = strClass;
  span.setAttributeNode(spanclass);

  span.appendChild(spantext);
  td2.appendChild(span);
  
  row.appendChild(td1);
  row.appendChild(td2);
}

function changeSlots(slotsInUse) {
  var e = document.getElementById('slots');
  e.innerHTML = slotsInUse;
}

function setShips(ship, count) {
  var e = document.getElementById(ship);
  e.innerHTML = count;
}

</script>
  
  
  
  
 <body onmousemove="tt_Mousemove(event);">
  <center>
<form action="galaxy.php" method="post" id="galaxy_form">
<input id="auto" value="dr" type="hidden">
<table border="0"> 
  <tbody><tr>
    <td>
      <table>
        <tbody><tr>
         <td class="c" colspan="3">Galaxy</td>
        </tr>
        <tr>
          <td class="l"><input name="galaxyLeft" value="&lt;-" onclick="galaxy_submit('galaxyLeft')" type="button"></td>
          <td class="l"><input name="galaxy" value="<?php if ($galaxy > 9) {$galaxy = 9;} if ($galaxy < 1) {$galaxy = 1;} echo $galaxy; ?>" size="5" maxlength="3" tabindex="1" type="text">
          </td><td class="l"><input name="galaxyRight" value="-&gt;" onclick="galaxy_submit('galaxyRight')" type="button"></td>
        </tr>
       </tbody></table>
      </td>
      <td>
       <table>
        <tbody><tr>
         <td class="c" colspan="3">Solar System</td>
        </tr>
         <tr>
          <td class="l"><input name="systemLeft" value="&lt;-" onclick="galaxy_submit('systemLeft')" type="button"></td>
          <td class="l"><input name="system" value="<?php if ($system > 499) {$system = 499;} if ($system < 1) {$system = 1;}echo $system; ?>" size="5" maxlength="3" tabindex="2" type="text">
          </td><td class="l"><input name="systemRight" value="-&gt;" onclick="galaxy_submit('systemRight')" type="button"></td>
         </tr>
        </tbody></table>
       </td>
      </tr>
      <tr>
        <td colspan="2" align="center"> <input value="Refresh" type="submit"></td>
      </tr>
     </tbody></table>
</form>
   <table width="569">
<tbody><tr>
  <td class="c" colspan="8">Solar System <?php echo "$galaxy:$system"; ?></td>
</tr>
   <tr>
    <td class="c">ID</td>
    <td class="c">Planet</td>
    <td class="c">Name</td>
    <td class="c">Moon</td>
    <td class="c">DF</td>
    <td class="c">Username</td>
    <td class="c">Alliance</td>
    <td class="c">Actions</td>
 <td class="c"></td>   </tr>
    <?php echo_galaxy($galaxy,$system); ?>
<tr>
<td class="c" colspan="6">( <?php
  if($planetcount==1){
    echo "$planetcount colonized planet";
  }elseif($planetcount==0){
    echo "No planets colonized!";
  }else{
    echo "$planetcount colonized planets";
  }
?> )</td>
<td class="c" colspan="2"><a href="#" onmouseover="this.T_WIDTH=150;return escape('<table><tr><td class=\'c\' colspan=\'2\'>Legend</td></tr><tr><td width=\'125\'>Strong</td><td><span class=\'strong\'>d</span></td></tr><tr><td>Noob</td><td><span class=\'noob\'>s</span></td></tr><tr><td>Vacation</td><td><span class=\'vacation\'>u</span></td></tr><tr><td>Banned</td><td><span class=\'banned\'>g</span></td></tr><tr><td>7 days inactive</td><td><span class=\'inactive\'>i</span></td></tr><tr><td>28 days inactive</td><td><span class=\'longinactive\'>I</span></td></tr><tr><td>Admin</td><td><font color=\'lime\'><blink>A</font></blink></td></tr></table>')">Legend</a></td>
</tr>
<tr>
<td class="c" colspan="4">
<span id="missiles"><?php echo "$rmp"; ?></span> : Missile(s)</td><td class="c" colspan="2">
<span id="slots"><?php echo "$maxfleet_count"; ?></span> / <?php echo "$fleetmax"; ?> Fleet Max</td><td class="c" colspan="2">
<span id="recyclers"><?php echo "$recek"; ?></span>: Recyclers<br><span id="probes"><?php echo "$probes"; ?></span>: Probes</td>
</tr>


<tr style="display: none; align:left" id="fleetstatusrow">
	  <th colspan="8"><div style="align:left" id="fleetstatus"></div>
		<table style="font-weight: bold; align:left" id="fleetstatustable" width="100%">
		</table>
</th>
</tr>
</tbody></table>
<!--(*) Movimiento de flotas o actividad en el planeta &nbsp;&nbsp;&nbsp;&nbsp;(g) Usuario suspendido<br>(i) Jugador 2 semanas inactivo&nbsp;&nbsp;&nbsp;    (I) Jugador 4 semanas inactivo<br>
<font color="#ffa0a0">Jugador fuerte </font> &nbsp;&nbsp;&nbsp; <font color="#a0ffa0">Jugador débil</font><font color="#ffffff">&nbsp;&nbsp;&nbsp; <font color="#0000ff">Modo de vacaciones</font>-->
  </center> <!-- OH MY GOD! --->
  <script language="JavaScript" src="scripts/wz_tooltip.js"></script>
	<!-- tablita  con informacion sobre algunas abreviaciones---><?php


	if($_POST["galaxyLeft"]){
	
	if ($_POST["galaxy"] < 1)
	    {$_POST["galaxy"] = 1;}
	elseif ($_POST["galaxy"] == 1)
	    {$_POST["galaxy"] = 1;}
        else{
	    $galaxy = $_POST["galaxy"] -1;
	    }
	}elseif($_POST["galaxyRight"]){
	
	if ($_POST["galaxy"] > 9 or $_POST["galaxyRight"] > 9 or $galaxy > 9)
		{$_POST["galaxy"] = 9;
		 $_POST["galaxyRight"] = 9;
		 $galaxy = 9;
		}
	elseif ($_POST["galaxy"] == 9)
	    {$_POST["galaxy"] = 9;
	     $galaxy = 9;}
	    else{
		$galaxy =  $_POST["galaxy"] +1;
		}
	}else{
		$galaxy = (!$galaxy) ? $_POST["galaxy"] : $galaxy;//default
	}
	
	//Agrega o quita +1 en $system
	if($_POST["systemLeft"]){
	if ($_POST["system"] < 1)
	    {$_POST["system"] = 1;}
	elseif ($_POST["system"] == 1)
	    {$_POST["system"] = 1;}
        else{
	    $system = $_POST["system"] -1;
	    }
	}elseif($_POST["systemRight"]){
	if ($_POST["system"] > 499 or $_POST["systemRight"] > 499)
	{$_POST["system"] = 499;}
	elseif ($_POST["system"] == 499)
	{$_POST["system"] = 499;}
	else {
		$system =  $_POST["system"] +1;
		}
	}else{
		$system = (!$system) ? $_POST["system"] : $system;//default
	}

?>

 </body></html>
<?php

}

 
// Created by Perberos. All rights reversed (C) 2006
?>
