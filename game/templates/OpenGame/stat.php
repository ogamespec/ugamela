<?php//Stat player access by Ersiu.

define('INSIDE', true);
$ugamela_root_path = '/';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);

if(!check_user()){ header("Location: login.php"); }

includeLang('stat');

$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];

$parse = $lang;
$who = (isset($_POST["who"]))?$_POST["who"]:$_GET["who"];
$type = (isset($_POST["type"]))?$_POST["type"]:$_GET["type"];
$start = (isset($_POST["start"]))?$_POST["start"]:$_GET["start"];
//
//  Formulario donde se muestran los diferentes tipos de categoria
//  y los rangos
//
$parse['who'] = '<option value="player"'.
   (($who == "player") ? " SELECTED" : "").'>Player</option>
  <option value="ally"'.
   (($who == "ally") ? " SELECTED" : "").'>Alliance</option>';
 
 
$parse['type'] = '
  <option value="pts"'.
   (($type == "pts") ? " SELECTED" : "").'>Points</option>
<option value="flt"'.
   (($type == "flt") ? " SELECTED" : "").'>Fleet</option>
  <option value="res"'.
   (($type == "res") ? " SELECTED" : "").'>Research</option>';
 
$parse['start'] = '
      <option value="1"'.
   (($start == "1") ? " SELECTED" : "").'>1-100</option>
      <option value="101"'.
   (($start == "101") ? " SELECTED" : "").'>101-200</option>
      <option value="201"'.
   (($start == "201") ? " SELECTED" : "").'>201-300</option>
      <option value="301"'.
   (($start == "301") ? " SELECTED" : "").'>301-400</option>
      <option value="401"'.
   (($start == "401") ? " SELECTED" : "").'>401-500</option>
      <option value="501"'.
   (($start == "501") ? " SELECTED" : "").'>501-600</option>
      <option value="601"'.
   (($start == "601") ? " SELECTED" : "").'>601-700</option>
      <option value="701"'.
   (($start == "701") ? " SELECTED" : "").'>701-800</option>
      <option value="801"'.
   (($start == "801") ? " SELECTED" : "").'>801-900</option>
      <option value="901"'.
   (($start == "901") ? " SELECTED" : "").'>901-1000</option>
      <option value="1001"'.
   (($start == "1001") ? " SELECTED" : "").'>1001-1100</option>
      <option value="1101"'.
   (($start == "1101") ? " SELECTED" : "").'>1101-1200</option>
      <option value="1201"'.
   (($start == "1201") ? " SELECTED" : "").'>1201-1300</option>
      <option value="1301"'.
   (($start == "1301") ? " SELECTED" : "").'>1301-1400</option>
      <option value="1401"'.
   (($start == "1401") ? " SELECTED" : "").'>1401-1500</option>';

//
//  Parece que fuera ayer, que solo el juego era una fachada.
//  Bueno, Here we go!
//


if($who == "ally"){
   
   $parse['body_table'] = parsetemplate(gettemplate('stat_alliancetable_header'), $parse);
   //pequei?1 fix para prevenir desastres
   $start = (is_numeric($start)&&$start>1)?round($start):1;
   //pequeA�a condicion
   $start = floor($start / 100 % 100)*100;
   //Realizamos la quiery en la table de jugadores
   $query = doquery('SELECT * FROM {{table}} ORDER BY ally_points DESC LIMIT '.($start).',100','alliance');
   $start++;
   $parse['body_values'] = '';//en caso de que no hubieran datos...
   $parse['data'] = $game_config['stats'];
   while ($row = mysql_fetch_assoc($query)){
      $parse['ally_rank'] = $start;
      
      $parse['ally_rankplus'] = '<font color="lime">?</font>';
      $parse['ally_name'] = '<a href="alliance.php?mode=ainfo&tag='.$row['ally_tag'].'">'.$row['ally_name'].'</a>';
      $parse['ally_mes'] = '';//'<a href="alliance.php?mode=apply&tag='.$row['ally_tag'].'">
     //<img src="images/img/m.gif" border="0" alt="Escribir mensaje" /></a>';
      $parse['ally_members'] = $row['ally_members'];
      if($type == "res"){
         $ally_points = $row['ally_points_tech'];
      }elseif($type == "flt"){
         $ally_points = $row['ally_points_fleet'];
      }else{
         $ally_points = floor($row['ally_points']/1000);
      }
   
      $parse['ally_points'] = pretty_number($ally_points);
      $parse['ally_members_points'] = @floor($ally_points/$row['ally_members']);
      $parse['body_values'] .= parsetemplate(gettemplate('stat_alliancetable'), $parse);
      $start++;
   }
   
   
}
else{
   
   $parse['body_table'] = parsetemplate(gettemplate('stat_playertable_header'), $parse);
   
   //pequei?1 fix para prevenir desastres
   $start = (is_numeric($start)&&$start>1)?round($start):1;

   //pequeA�a condicion
   $start = floor($start / 100 % 100)*100;
   //Realizamos la quiery en la table de jugadores
      if($type == "res"){
            $query = doquery('SELECT * FROM {{table}} ORDER BY points_tech DESC LIMIT '.$start.',100','users');
      }elseif($type == "flt"){
            $query = doquery('SELECT * FROM {{table}} ORDER BY points_fleet DESC LIMIT '.$start.',100','users');
      }else{
         $query = doquery('SELECT * FROM {{table}} ORDER BY points_points DESC LIMIT '.$start.',100','users');
      }


   $start++;
   $parse['data'] = $game_config['stats'];
   $parse['body_values'] = '';//en caso de que no hubieran datos...
   while ($row = mysql_fetch_assoc($query)){
      $playername_rank =  $row['username'];
           $player_access =  $row['authlevel'];

      $rank_old = $row['rank_old'];
//      $query_rank = doquery("UPDATE {{table}} SET `rank_old`='{$rank_old}' WHERE `username` = '{$playername_rank}'" ,"users");      
      $parse['player_rank'] = $start;
      $rank_new = $start;
      $ranking = $rank_old - $rank_new;
      if ($ranking == "0")
      {
      $parse['player_rankplus'] = "<font color=\"#87CEEB\">0</font>";
      }
      if ($ranking < "0")
      {
      $parse['player_rankplus'] = "<font color=\"red\">$ranking</font>";
      }
      if ($ranking > "0")
      {
      $parse['player_rankplus'] = "<font color=\"green\">+$ranking</font>";
      }
//      $query_rank = doquery("UPDATE {{table}} SET `rank`='{$start}' WHERE `username` = '{$playername_rank}'" ,"users");
      //$parse['player_rankplus'] = '<font color="#87CEEB">?</font>';
               
      $parse['player_name'] = $row['username'];
      if($player_access == "5")
      {
      $parse['pos'] = "<b><font color=green>SGO</font></b>";
      }
      if($player_access == "4")
      {
      $parse['pos'] = "<b><font color=orange>GO</font></b>";
      }
      if($player_access == "3")
      {
      $parse['pos'] = "<b><font color=red>Admin</font></b>";
      }
      if($player_access == "0")
      {
      $parse['pos'] = "User";
      }
                $parse['player_mes'] = '<a href="messages.php?mode=write&id='.$row['id'].'">
      <img src="'.$dpath.'img/m.gif" border="0" alt="Napisz Wiadomo�a" /></a>';
      $parse['player_alliance'] = $row['ally_name'];

      if($type == "res"){
         $parse['player_points'] = pretty_number($row['points_tech']);
      }elseif($type == "flt"){
         $parse['player_points'] = pretty_number($row['points_fleet']);
      }else{
         $parse['player_points'] = pretty_number($row['points_points']/1000);
      }

      
      $parse['body_values'] .= parsetemplate(gettemplate('stat_playertable'), $parse);
      $start++;
   }
   
}

$page = parsetemplate(gettemplate('stat_body'), $parse);

display($page,$lang['Resources']);
//
//  bueno, no se pudo hacer mucho que digamos ...
//
// Created by Perberos. All rights reversed (C) 2006
?> 