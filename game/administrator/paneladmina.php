<style type="text/css">
<!--
body {
	background-image: url(http://80.237.203.201/download/use/g3cko/img/animspace.gif);
}
-->
</style><body bgcolor=black><?php // -> Panel de admin Creado por Prody {Con el notepad sabelo}

define('INSIDE', true);
$ugamela_root_path = './../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);
$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
//checkeamos que el usuario este logueado y que tenga los permisos de admin
if(!check_user()){ header("Location: ./../login.php"); }
if($user['authlevel']!="5"&&$user['authlevel']!="5"){ header("Location: ../login.php");}
//si todo esta bien continuamos
$r=0;
if($user['authlevel'] == "3"){ $user['authlevel']="Administratorze";}
elseif($user['authlevel'] == "1"){ $user['authlevel']="Administratorze";}
elseif($user['authlevel'] == "5"){ $user['authlevel']="SuperGameOperatorze";}

echo "<br><br><br><br><center><b>Welcome {$user['authlevel']} {$user['username']}";
echo "<br><br><br>";
echo "<div align=\"left\" valign=\"bottom\"  >
<center><table border = '1'>
	<tbody><tr>
     <td class=\"c\" colspan=\"5\" width=\"100%\"><font color=\"#FFFFFF\">Administrator Panel</font></td>
    </tr> 
	<th class=\"\"><b><a href=\"?op=1\">Find User</a><br></th> 
	<th class=\"\"><b><a href=\"?op=2\">Find IP</a><br></th> 
	<th class=\"\"><b><a href=\"?op=3\">Edit User</a><br></th> 
	<th class=\"\"><b><a href=\"?op=6\">Edit Planet</a><br></th> 
	<th class=\"\"><b><a href=\"?op=7\">Promote Someone</a></th></tbody></table></center><br><br></div>";

//formulario de busqueda por nombre de usuario
function form_1(){
echo "<table border = '1'><tbody><tr>
     <td class=\"c\" colspan=\"2\"><font color=\"#FFFFFF\">Find User</font></td>
    </tr>
<th class=\"\"><form name=\"buscar\" action=\"?doit=1\" method=\"GET\"><font color=\"#FFFFFF\">Username:</font><input type=\"text\" name=\"usuario\">
<br><a href=\"javascript:document.forms[0].submit()\">Continue</a></th></tbody></table>";}


//formulario de busqueda por numero de ip
function form_2(){
echo "<table border = '1'><tbody><tr>
     <td class=\"c\" colspan=\"2\"><font color=\"#FFFFFF\">Please enter an IP.</font></td>
    </tr>
<tr><th class=\"\"><form name=\"buscarip\" action=\"?doit=2\" method=\"GET\"><font color=\"#FFFFFF\">IP:</font><input type=\"text\" name=\"ip\">
<br><a href=\"javascript:document.forms[0].submit()\">Continue</a></tr></th></tbody></table>";}

//formulario para editar usuario
function form_3(){
echo "<table border = '1'><tbody><tr>
     <td class=\"c\" colspan=\"2\"><font color=\"#FFFFFF\">Edit User</font></td>
    </tr>
<tr><th class=\"\"><form name=\"editartipo\" action=\"?doit=3\" method=\"GET\"><font color=\"#FFFFFF\">Username:</font><input type=\"text\" name=\"edit_user\">
<br><a href=\"javascript:document.forms[0].submit()\">Edit</a></th></tbody></table>";}

//formulario para editar tecnologia
function form_4(){
echo "<table border = '1'><tbody><tr>
     <td class=\"c\" colspan=\"2\"><font color=\"#FFFFFF\">Edit Technology</font></td>
    </tr>
<th class=\"\">
<form method=\"GET\"  action=\"\">
<font color=\"#FFFFFF\">Username:</font> <input type=\"text\" name=\"edit_user_name\"><br>
<font color=\"#FFFFFF\">Level:</font> <input type=\"text\" name=\"edit_user_nivel\"><br>
<font color=\"#FFFFFF\">Technology<br></front>
<select name=\"editar[]\">
<option value=\"spy\">Espionage Technology</option>
<option value=\"computer\">Computer Technology</option>
<option value=\"military\">Military Technology</option>
<option value=\"defense\">Defense Technology</option>
<option value=\"shield\">Shield Technology</option>
<option value=\"energy\">Energy Technology</option>
<option value=\"hyperspace\">Hyperspace Technology</option>
<option value=\"combustion\">Combustion Technology</option>
<option value=\"impulse_motor\">Impulse Drive</option>
<option value=\"hyperspace_motor\">Hyperspace Drive</option>
<option value=\"laser\">Laser Technology</option>
<option value=\"ionic\">Ion Technology</option>
<option value=\"buster\">Buster Technology</option>
<option value=\"intergalactic\">Intergalactic Technology</option>
<option value=\"graviton\">Graviton Technology</option>


</select>
<a href=\"javascript:document.forms[0].submit()\">Edytuj!</a>
</form></th></tbody></table>";}


function form_6(){
echo "<table border = '1'><tbody><tr>
     <td class=\"c\" colspan=\"2\"><font color=\"#FFFFFF\">Edit Planet</font></td>
    </tr>
<th class=\"\">
<form method=\"GET\"  action=\"\">
<font color=\"#FFFFFF\">ID:</font> <input type=\"text\" name=\"galaxy\"><br>
<font color=\"#FFFFFF\">Position:</font> <input type=\"text\" name=\"edit_planet_nivel\"><br>
<select name=\"editar_planet[]\">
<option value=\"metal\">Metal</option>
<option value=\"crystal\">Crystal</option>
<option value=\"deuterium\">Deuterium</option>
<option value=\"metal_mine\">Metal Mine</option>
<option value=\"crystal_mine\">Crystal Mine</option>
<option value=\"deuterium_sintetizer\">Deuterium Mine</option>
<option value=\"solar_plant\">Solar Plant</option>
<option value=\"fusion_plant\">Fusion Plant</option>
<option value=\"robot_factory\">Robot Factory</option>
<option value=\"nano_factory\">Nano Factory</option>
<option value=\"hangar\">Hanger</option>
<option value=\"metal_store\">Metal Storage/option>
<option value=\"crystal_store\">Crystal Storage</option>
<option value=\"deuterium_store\">Deuterium Storage</option>
<option value=\"laboratory\">Research Center</option>
<option value=\"terraformer\">Terraformer</option>
<option value=\"ally_deposit\">Ally Depo</option>
<option value=\"silo\">Missile Silo</option>
<option value=\"stacja_obronna\">?</option>
</select>
<a href=\"javascript:document.forms[0].submit()\">Edytuj!</a>
</form>";}


function form_5(){
echo "<table border = '1'><tbody><tr>
     <td class=\"c\" colspan=\"2\"><font color=\"#FFFFFF\">Promote User</font></td>
    </tr>
<th class=\"\">
<form method=\"GET\"  action=\"\">
<font color=\"#FFFFFF\">Nazwa Gracza(teraz):</font> <input type=\"text\" name=\"edit_nazwa\"><br>
<font color=\"#FFFFFF\">Nazwa Gracza(jaka ma byc):</font> <input type=\"text\" name=\"edit_nazwa2\"><br>
</select>
<a href=\"javascript:document.forms[0].submit()\">Edytuj!</a>
</form></th></tbody></table>";}


function form_7(){
echo "<table border = '1'><tbody><tr>
     <td class=\"c\" colspan=\"2\"><font color=\"#FFFFFF\">Edytuj Planete</font></td>
    </tr>
<th class=\"\">
<form method=\"GET\"  action=\"\">
<font color=\"#FFFFFF\">Username:</font> <input type=\"text\" name=\"edit_ranga_name\"><br>
<select name=\"editar_ranga[]\">
<option value=\"3\">Administrator</option>
<option value=\"5\">SGO</option>
<option value=\"4\">GO</option>
<option value=\"0\">Ban User</option>


</select>
<a href=\"javascript:document.forms[0].submit()\">Edit</a>
</form></th></tbody></table>";}




switch($_GET['op']) {
   case 1:
       form_1();
       break;
   case 2:
       form_2();
       break;
   case 3:
       form_3();
       break;
   case 4:
       form_4();
       break;
   case 5:
       form_5();
       break;
   case 6:
       form_6();
       break;
   case 7:
       form_7();
       break;
/*
   default:
 htm();*/
       
}

//buscar por usuario
if(isset($_GET['usuario'])){
$result = doquery("SELECT * FROM {{table}} WHERE username LIKE '%{$_GET['usuario']}%' LIMIT 10;","users");
//doquery("SELECT ally_name FROM {{table}} WHERE id = {$s['ally_id']}","alliance",true);

$row = mysql_fetch_row($result);
echo "<table border = '1'> \n";
echo "<tbody><tr>
     <td class=\"c\" colspan=\"2\"><font color=\"#FFFFFF\">Informacje o Graczu</font></td>
    </tr>
<tr><div align=\"center\"><th class=\"\"><font color=\"#FFFFFF\">ID:</font></th></div>";
echo "<div align=\"center\"><th class=\"\"><font color=\"#FFFFFF\"><a href\"\"></a>{$row[0]}</font></th></div></tr>";
echo "<tr><div align=\"center\"><th class=\"\"><font color=\"#FFFFFF\">Nazwa Gracza:</font></th></div>";
echo "<div align=\"center\"><th class=\"\"><font color=\"#FFFFFF\"><a href\"\"></a>{$row[1]}</font></th></div></tr>";
echo "<tr><div align=\"center\"><th class=\"\"><font color=\"#FFFFFF\">IP:</font></th></div>";
echo "<div align=\"center\"><th class=\"\"><font color=\"#FFFFFF\"><a href\"\"></a>{$row[15]}</font></th></div></tr>";
echo "<tr><div align=\"center\"><th class=\"\"><font color=\"#FFFFFF\">E-Mail:</font></th></div>";
echo "<div align=\"center\"><th class=\"\"><font color=\"#FFFFFF\"><a href\"\"></a>{$row[3]}</font></th></div></tr>";
echo "<tr><div align=\"center\"><th class=\"\"><font color=\"#FFFFFF\">E-Mail2:</font></th></div>";
echo "<div align=\"center\"><th class=\"\"><font color=\"#FFFFFF\"><a href\"\"></a>{$row[4]}</font></th></div></tr>";
echo "<tr><div align=\"center\"><th class=\"\"><font color=\"#FFFFFF\">Ranga:</font></th></div>";
if($row[6] == "3"){ $row[6]="Administrator";}
elseif($row[6] == "1"){ $row[6]="Administrator";}
elseif($row[6] == "5"){ $row[6]="SuperGameOperator";}
elseif($row[6] == "4"){ $row[6]="GameOperator";}
elseif($row[6] == "0"){ $row[6]="Zwykly Gracz";}
echo "<div align=\"center\"><th class=\"\"><font color=\"red\"><a href\"\"></a>{$row[6]}</font></div></th></tr>";
echo "<tr><div align=\"center\"><th class=\"\"><font color=\"#FFFFFF\">P³eæ:</font></div></th>";
if($row[7] == "M"){ $row[7]="Me¿czyzna";}
elseif($row[7] == "F"){ $row[7]="Kobieta";}
echo "<div align=\"center\"><th class=\"\"><font color=\"#FFFFFF\"><a href\"\"></a>{$row[7]}</font></div></th></tr>";
echo "<tr><div align=\"center\"><th class=\"\"><font color=\"#FFFFFF\">ID Planety:</font></div></th>";
echo "<div align=\"center\"><th class=\"\"><font color=\"#FFFFFF\"><a href\"\"></a>{$row[10]}</font></div></th></tr>";
echo "<tr><div align=\"center\"><th class=\"\"><font color=\"#FFFFFF\">Polozenie:</font></div></th>";
echo "<div align=\"center\"><th class=\"\"><font color=\"#FFFFFF\"><a href\"\"></a>{$row[11]}:{$row[12]}:{$row[13]}</font></div></th></tr>";

echo "</tbody></table> \n";}

//buscar ip
if(isset($_GET['ip'])){
$ip=$_GET['ip'];
$result = doquery("SELECT * FROM {{table}} WHERE user_lastip='$ip' LIMIT 10;","users"); 
$row = mysql_fetch_row($result);
$result2 = doquery("SELECT * FROM {{table}} WHERE user_lastip='$ip' LIMIT 1,10;","users"); 
$row2 = mysql_fetch_row($result2);
$result3 = doquery("SELECT * FROM {{table}} WHERE user_lastip='$ip' LIMIT 2,10;","users"); 
$row3 = mysql_fetch_row($result3);
$result4 = doquery("SELECT * FROM {{table}} WHERE user_lastip='$ip' LIMIT 3,10;","users"); 
$row4 = mysql_fetch_row($result4);
$result5 = doquery("SELECT * FROM {{table}} WHERE user_lastip='$ip' LIMIT 4,10;","users"); 
$row5 = mysql_fetch_row($result5);
$result6 = doquery("SELECT * FROM {{table}} WHERE user_lastip='$ip' LIMIT 5,10;","users"); 
$row6 = mysql_fetch_row($result6);
$result7 = doquery("SELECT * FROM {{table}} WHERE user_lastip='$ip' LIMIT 6,10;","users"); 
$row7 = mysql_fetch_row($result7);
$result8 = doquery("SELECT * FROM {{table}} WHERE user_lastip='$ip' LIMIT 7,10;","users"); 
$row8 = mysql_fetch_row($result8);
$result9 = doquery("SELECT * FROM {{table}} WHERE user_lastip='$ip' LIMIT 8,10;","users"); 
$row9 = mysql_fetch_row($result9);
$result10 = doquery("SELECT * FROM {{table}} WHERE user_lastip='$ip' LIMIT 9,10;","users"); 
$row10 = mysql_fetch_row($result10);

echo "<table border = '1'> \n";
echo "<tbody><tr>
     <td class=\"c\" colspan=\"2\"><font color=\"#FFFFFF\">Informacje o {$ip}</font></td>
    </tr>
<tr><div align=\"center\"><th class=\"\"><font color=\"#FFFFFF\">Nazwa Gracza:</font></th></div></tr>";
echo "<tr><div align=\"center\"><th class=\"\"><font color=\"#FFFFFF\">{$row[1]}</font></th></div></tr>";
echo "<tr><div align=\"center\"><th class=\"\"><font color=\"#FFFFFF\">{$row2[1]}</font></th></div></tr>";
echo "<tr><div align=\"center\"><th class=\"\"><font color=\"#FFFFFF\">{$row3[1]}</font></th></div></tr>";
echo "<tr><div align=\"center\"><th class=\"\"><font color=\"#FFFFFF\">{$row4[1]}</font></th></div></tr>";
echo "<tr><div align=\"center\"><th class=\"\"><font color=\"#FFFFFF\">{$row5[1]}</font></th></div></tr>";
echo "<tr><div align=\"center\"><th class=\"\"><font color=\"#FFFFFF\">{$row6[1]}</font></th></div></tr>";
echo "<tr><div align=\"center\"><th class=\"\"><font color=\"#FFFFFF\">{$row7[1]}</font></th></div></tr>";
echo "<tr><div align=\"center\"><th class=\"\"><font color=\"#FFFFFF\">{$row8[1]}</font></th></div></tr>";
echo "<tr><div align=\"center\"><th class=\"\"><font color=\"#FFFFFF\">{$row9[1]}</font></th></div></tr>";
echo "<tr><div align=\"center\"><th class=\"\"><font color=\"#FFFFFF\">{$row10[1]}</font></th></div></tr>";
echo "</table> \n";}

//editar usuario
if(isset($_GET['edit_user'])){
$ed=$_GET['edit_user'];
$result=doquery("SELECT * FROM {{table}} WHERE username='$ed';","users");//aca buscamos el usuario
$row=mysql_fetch_row($result);//el resultado lo ponemos en un array no?
$gwor=$row[0];
$result2 = doquery("SELECT * FROM {{table}} WHERE id_owner={$row[0]} ORDER BY id ASC LIMIT 1,1","planets");//y aca buscamos los planetas del usuario.....
$row2=mysql_fetch_row($result2);//otro array mas no?
$result3 = doquery("SELECT * FROM {{table}} WHERE id_owner={$row[0]} ORDER BY id ASC LIMIT 2,1","planets");//y aca buscamos los planetas del usuario.....
$row3=mysql_fetch_row($result3);//otro array mas no?
$result4 = doquery("SELECT * FROM {{table}} WHERE id_owner={$row[0]} ORDER BY id ASC LIMIT 3,1","planets");//y aca buscamos los planetas del usuario.....
$row4=mysql_fetch_row($result4);//otro array mas no?
$result5 = doquery("SELECT * FROM {{table}} WHERE id_owner={$row[0]} ORDER BY id ASC LIMIT 4,1","planets");//y aca buscamos los planetas del usuario.....
$row5=mysql_fetch_row($result5);//otro array mas no?
$result6 = doquery("SELECT * FROM {{table}} WHERE id_owner={$row[0]} ORDER BY id ASC LIMIT 5,1","planets");//y aca buscamos los planetas del usuario.....
$row6=mysql_fetch_row($result6);//otro array mas no?
$result7 = doquery("SELECT * FROM {{table}} WHERE id_owner={$row[0]} ORDER BY id ASC LIMIT 5,1","planets");//y aca buscamos los planetas del usuario.....
$row7=mysql_fetch_row($result7);//otro array mas no?
$result8 = doquery("SELECT * FROM {{table}} WHERE id_owner={$row[0]} ORDER BY id ASC LIMIT 5,1","planets");//y aca buscamos los planetas del usuario.....
$row8=mysql_fetch_row($result8);//otro array mas no?
$result9 = doquery("SELECT * FROM {{table}} WHERE id_owner={$row[0]} ORDER BY id ASC LIMIT 5,1","planets");//y aca buscamos los planetas del usuario.....
$row9=mysql_fetch_row($result9);//otro array mas no?

echo "<table border = '1'><tbody><tr>
     <td class=\"c\" colspan=\"2\"><font color=\"#FFFFFF\">Ogolne</font></td>
    </tr><th class=\"\">
<font color=\"#FFFFFF\">Nazwa Gracza:</font> ";
if($row[6] != "3"){ $b="<a href=\"?op=5\" alt=\"Editar\">Zmien</a>";}
echo "<font color=\"#FFFFFF\">{$row[1]} {$b}</font><br>";
if($row[6] == "3"){ $row[6]="Administrator";}
elseif($row[6] == "1"){ $row[6]="Administrator";}
elseif($row[6] == "5"){ $row[6]="SuperGameOperator";}
elseif($row[6] == "4"){ $row[6]="GameOperator";}
elseif($row[6] == "0"){ $row[6]="Zwyk³y Gracz";}
echo "<font color=\"#FFFFFF\">Ranga: <font color=\"red\">{$row[6]}</font></tbody></table>";

echo "<table border = '1'><tbody><tr>
     <td class=\"c\" colspan=\"2\"><font color=\"#FFFFFF\">Planeta Glowna</font></td>
    </tr><th class=\"\"><font color=\"#FFFFFF\">ID[{$row[10]}] <th class=\"\"><font color=\"#FFFFFF\">{$row[11]}:{$row[12]}:{$row[13]}</tbody></table>";


echo "<table border = '1'><tbody><tr>
     <td class=\"c\" colspan=\"2\"><font color=\"#FFFFFF\">Kolonie</font></td>
    </tr><br>
<tr>
	<td class=\"c\" colspan=\"1\"><font color=\"#FFFFFF\">ID Planety</font></td>
	<td class=\"c\" colspan=\"1\"><font color=\"#FFFFFF\">Polozenie</font></td>
    <tr>
";

echo "<th class=\"\"><font color=\"#FFFFFF\">ID[{$row2[0]}]<br>";
echo "ID[{$row3[0]}]<br>";
echo "ID[{$row4[0]}]<br>";
echo "ID[{$row5[0]}]<br>";
echo "ID[{$row6[0]}]<br>";
echo "ID[{$row7[0]}]<br>";
echo "ID[{$row8[0]}]<br>";
echo "ID[{$row9[0]}]</th>";

echo "<th class=\"\"><font color=\"#FFFFFF\">{$row2[3]}:{$row2[4]}:{$row2[5]}<br>";
echo "{$row3[3]}:{$row3[4]}:{$row3[5]}<br>";
echo "{$row4[3]}:{$row4[4]}:{$row4[5]}<br>";
echo "{$row5[3]}:{$row5[4]}:{$row5[5]}<br>";
echo "{$row6[3]}:{$row6[4]}:{$row6[5]}<br>";
echo "{$row7[3]}:{$row7[4]}:{$row7[5]}<br>";
echo "{$row8[3]}:{$row8[4]}:{$row8[5]}<br>";
echo "{$row9[3]}:{$row9[4]}:{$row9[5]}<br></pre></tbody></table></tr></th>";


echo "<table border = '1'><tbody><tr>
     <td class=\"c\" colspan=\"2\"><font color=\"#FFFFFF\"><a href=\"?op=4\" alt=\"Editar\">Technologie</a> <- Edycja Technologi</font></td>
    </tr>";
echo "<tr><div align=\"center\"><th class=\"\"><font color=\"#FFFFFF\">Espionage Technology: {$row[46]}</a><br></div></td></tr>"."
<tr><div align=\"center\"><th class=\"\"><font color=\"#FFFFFF\">Computer Technology: {$row[47]}</font></div></td></tr>"."
<tr><div align=\"center\"><th class=\"\"><font color=\"#FFFFFF\">Technologia Bojowa: {$row[48]}</font></div></td></tr>"."
<tr><div align=\"center\"><th class=\"\"><font color=\"#FFFFFF\">Technologia Obronna: {$row[49]}</font></div></td></tr>"."
<tr><div align=\"center\"><th class=\"\"><font color=\"#FFFFFF\">Opancerzenie Statkow: {$row[50]}</font></div></td></tr>"."
<tr><div align=\"center\"><th class=\"\"><font color=\"#FFFFFF\">Technologia Energetyczna: {$row[51]}</font></div></td></tr>"."
<tr><div align=\"center\"><th class=\"\"><font color=\"#FFFFFF\">Technologia Nadprzestrzenna: {$row[52]}</font></div></td></tr>"."
<tr><div align=\"center\"><th class=\"\"><font color=\"#FFFFFF\">Naped Spalinowy: {$row[53]}</font></div></td></tr>"."
<tr><div align=\"center\"><th class=\"\"><font color=\"#FFFFFF\">Naped Impulsowy: {$row[54]}</font></div></td></tr>"."
<tr><div align=\"center\"><th class=\"\"><font color=\"#FFFFFF\">Naped Nadprzestrzenny: {$row[55]}</font></div></td></tr>"."
<tr><div align=\"center\"><th class=\"\"><font color=\"#FFFFFF\">Technologia Laserowa: {$row[56]}</font></div></td></tr>"."
<tr><div align=\"center\"><th class=\"\"><font color=\"#FFFFFF\">Technologia Jonowa: {$row[57]}</font></div></td></tr>"."
<tr><div align=\"center\"><th class=\"\"><font color=\"#FFFFFF\">Technologia Plazmowa: {$row[58]}</font></div></td></tr>"."
<tr><div align=\"center\"><th class=\"\"><font color=\"#FFFFFF\">Miedzygalaktyczna Siec Badan Naukowych: {$row[59]}</font></div></td></tr>"."
<tr><div align=\"center\"><th class=\"\"><font color=\"#FFFFFF\">Rozwoj Grawitonow: {$row[60]}</font>";}









//editar investigaciones

if(isset($_GET['editar'])){
$a=$_GET['editar'][0];
$b=$_GET['edit_user_nivel'];
$c=$_GET['edit_user_name'];

$query = doquery("UPDATE {{table}} SET {$a}_tech='$b' WHERE username='$c';","users");

message("Wlasnie zedytowales technologie graczowi {$c}!","Informacja");}


if(isset($_GET['editar_planet'])){
$a=$_GET['editar_planet'][0];
$b=$_GET['edit_planet_nivel'];
$c=$_GET['galaxy'];

$query = doquery("UPDATE {{table}} SET {$a}={$b} WHERE id={$c};","planets");

message("Wlasnie zedytowales planete o ID[{$c}]!","Informacja");}



if(isset($_GET['editar_ranga'])){
$c=$_GET['editar_ranga'][0];
$a=$_GET['edit_ranga_name'];
$b=$_GET['editar_ranga2'][0];
if($c == "3"){ $b="ADMIN_";}
elseif($c == "5"){ $b="SGO_";}
elseif($c == "4"){ $b="GO_";}
elseif($c == "0"){ $b=" ";}

if($c == "3"){ $d="Administratora";}
elseif($c == "5"){ $d="SuperGameOperator'a";}
elseif($c == "4"){ $d="GameOperator'a";}
elseif($c == "0"){ $d="Zwyklego Gracza";}
$query = doquery("UPDATE {{table}} SET authlevel='$c' WHERE username='$a';","users");

message("Wlasnie zedytowales range graczowi [ {$a} ] na <font color=\"red\">{$d}</font>!","Informacja");}


if(isset($_GET['edit_nazwa'])){
$a=$_GET['edit_nazwa'];
$b=$_GET['edit_nazwa2'];

$query = doquery("UPDATE {{table}} SET username='$b' WHERE username='$a';","users");

message("Wlasnie imie graczowi [ {$a} ] na [ {$b} ]!","Informacja");}


?>
<link rel="stylesheet" type="text/css" media="screen" href="http://www.ogametr.net/ogametr/formate.css" />

</style> 