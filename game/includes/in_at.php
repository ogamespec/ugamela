<?
/* 
instalator tabeli ataku w Poprawce AtakibyMerow, data 04.06.07, 
poprawka na wersje ugamella_0.2j


Wydane na Licencji GPL z zastrze¿eniem "Zabrania siê do u¿ytku w transakcja zawartych za poœrednictwem Firmy Allegro.pl"


*/


define('INSIDE', true);
$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);
include($ugamela_root_path . '/includes/vars.'.$phpEx);

$tabela = "ugml_users"; // Tabela users z ugamelli
$tabela_ally = "ugml_alliance"; // Tabela aliances z ugamelli
$tabela_config = "ugml_config"; // Tabela config z ugamelli

$punktyquery=doquery("SELECT * FROM {{table}} ",'users'); 



//echo("<br>Instalator testowy do atakow by Merow, Licencja GPL z zastrze¿eniem 'Zabrania siê do u¿ytku w transakcja zawartych za poœrednictwem Firmy Allegro.pl i podobnym' <br>"); 
//echo("Usuwam zawratosc tabeli 'param_oslona'<br>"); 

doquery("TRUNCATE TABLE {{table}} ",'param_oslona');
//echo("Usuwam tabeli 'param_oslona' unieta<br>"); 
//echo("Usuwam zawratosc tabeli 'param_atak'<br>"); 
doquery("TRUNCATE TABLE {{table}} ",'param_atak'); 
//echo("Usuwam tabeli 'param_atak' unieta<br>"); 
doquery("TRUNCATE TABLE {{table}} ",'param_pancerz');

while($row = mysql_fetch_assoc($punktyquery)){


$bojowa=$row['military_tech'];
$ochronna=$row['defence_tech'];
$pancerna=$row['shield_tech'];

$id=$row['id'];

//atak
$a202=$pricelist['202']['attack']*($bojowa+1*1.5);
$a203=$pricelist['203']['attack']*($bojowa+1*1.5);
$a204=$pricelist['204']['attack']*($bojowa+1*1.5);
$a205=$pricelist['205']['attack']*($bojowa+1*1.5);
$a206=$pricelist['206']['attack']*($bojowa+1*1.5);
$a207=$pricelist['207']['attack']*($bojowa+1*1.5);
$a208=$pricelist['208']['attack']*($bojowa+1*1.5);
$a209=$pricelist['209']['attack']*($bojowa+1*1.5);
$a210=$pricelist['210']['attack']*($bojowa+1*1.5);
$a211=$pricelist['211']['attack']*($bojowa+1*1.5);
$a212=$pricelist['212']['attack']*($bojowa+1*1.5);
$a213=$pricelist['213']['attack']*($bojowa+1*1.5);
$a214=$pricelist['214']['attack']*($bojowa+1*1.5);
$a215=$pricelist['215']['attack']*($bojowa+1*1.5);
$a401=$pricelist['401']['attack']*($bojowa+1*1.5);
$a402=$pricelist['402']['attack']*($bojowa+1*1.5);
$a403=$pricelist['403']['attack']*($bojowa+1*1.5);
$a404=$pricelist['404']['attack']*($bojowa+1*1.5);
$a405=$pricelist['405']['attack']*($bojowa+1*1.5);
$a406=$pricelist['406']['attack']*($bojowa+1*1.5);
$a407=$pricelist['407']['attack']*($bojowa+1*1.5);
$a408=$pricelist['408']['attack']*($bojowa+1*1.5);
$a502=$pricelist['502']['attack']*($bojowa+1*1.5);
$a503=$pricelist['503']['attack']*($bojowa+1*1.5);



$query=doquery
("INSERT INTO  {{table}} ( `id_user` , `202` , `203` , `204` , `205` , `206` , `207` , `208` , `209` , `210` , `211` , `212` , `213` , `214` , `215` , `401` , `402` , `403` , `404` , `405` , `406` , `407` , `408` , `502` , `503` )
VALUES 
('$id', '$a202', '$a203', '$a204', '$a205', '$a206', '$a207', '$a208', '$a209', '$a210', '$a211', '$a212', '$a213', '$a214', '$a215', '$a401', '$a402', '$a403', '$a404', '$a405', '$a406', '$a407', '$a408', '$a502', '$a503')"
,'param_atak');



//pole ochronne

$a202=$pricelist['202']['shield']*($ochronna+1*1.5);
$a203=$pricelist['203']['shield']*($ochronna+1*1.5);
$a204=$pricelist['204']['shield']*($ochronna+1*1.5);
$a205=$pricelist['205']['shield']*($ochronna+1*1.5);
$a206=$pricelist['206']['shield']*($ochronna+1*1.5);
$a207=$pricelist['207']['shield']*($ochronna+1*1.5);
$a208=$pricelist['208']['shield']*($ochronna+1*1.5);
$a209=$pricelist['209']['shield']*($ochronna+1*1.5);
$a210=$pricelist['210']['shield']*($ochronna+1*1.5);
$a211=$pricelist['211']['shield']*($ochronna+1*1.5);
$a212=$pricelist['212']['shield']*($ochronna+1*1.5);
$a213=$pricelist['213']['shield']*($ochronna+1*1.5);
$a214=$pricelist['214']['shield']*($ochronna+1*1.5);
$a215=$pricelist['215']['shield']*($ochronna+1*1.5);
$a401=$pricelist['401']['shield']*($ochronna+1*1.5);
$a402=$pricelist['402']['shield']*($ochronna+1*1.5);
$a403=$pricelist['403']['shield']*($ochronna+1*1.5);
$a404=$pricelist['404']['shield']*($ochronna+1*1.5);
$a405=$pricelist['405']['shield']*($ochronna+1*1.5);
$a406=$pricelist['406']['shield']*($ochronna+1*1.5);
$a407=$pricelist['407']['shield']*($ochronna+1*1.5);
$a408=$pricelist['408']['shield']*($ochronna+1*1.5);
$a502=$pricelist['502']['shield']*($ochronna+1*1.5);
$a503=$pricelist['503']['shield']*($ochronna+1*1.5);


$query=doquery
("INSERT INTO  {{table}} ( `id_user` , `202` , `203` , `204` , `205` , `206` , `207` , `208` , `209` , `210` , `211` , `212` , `213` , `214` , `215` , `401` , `402` , `403` , `404` , `405` , `406` , `407` , `408` , `502` , `503` )
VALUES 
('$id', '$a202', '$a203', '$a204', '$a205', '$a206', '$a207', '$a208', '$a209', '$a210', '$a211', '$a212', '$a213', '$a214', '$a215', '$a401', '$a402', '$a403', '$a404', '$a405', '$a406', '$a407', '$a408', '$a502', '$a503')"
,'param_oslona');

//pancerz
$a202=$pricelist['202']['shield']*($pancerna+1*1.5);
$a203=$pricelist['203']['shield']*($pancerna+1*1.5);
$a204=$pricelist['204']['shield']*($pancerna+1*1.5);
$a205=$pricelist['205']['shield']*($pancerna+1*1.5);
$a206=$pricelist['206']['shield']*($pancerna+1*1.5);
$a207=$pricelist['207']['shield']*($pancerna+1*1.5);
$a208=$pricelist['208']['shield']*($pancerna+1*1.5);
$a209=$pricelist['209']['shield']*($pancerna+1*1.5);
$a210=$pricelist['210']['shield']*($pancerna+1*1.5);
$a211=$pricelist['211']['shield']*($pancerna+1*1.5);
$a212=$pricelist['212']['shield']*($pancerna+1*1.5);
$a213=$pricelist['213']['shield']*($pancerna+1*1.5);
$a214=$pricelist['214']['shield']*($pancerna+1*1.5);
$a215=$pricelist['215']['shield']*($pancerna+1*1.5);
$a401=$pricelist['401']['shield']*($pancerna+1*1.5);
$a402=$pricelist['402']['shield']*($pancerna+1*1.5);
$a403=$pricelist['403']['shield']*($pancerna+1*1.5);
$a404=$pricelist['404']['shield']*($pancerna+1*1.5);
$a405=$pricelist['405']['shield']*($pancerna+1*1.5);
$a406=$pricelist['406']['shield']*($pancerna+1*1.5);
$a407=$pricelist['407']['shield']*($pancerna+1*1.5);
$a408=$pricelist['408']['shield']*($pancerna+1*1.5);
$a502=$pricelist['502']['shield']*($pancerna+1*1.5);
$a503=$pricelist['503']['shield']*($pancerna+1*1.5);


$query=doquery
("INSERT INTO  {{table}} ( `id_user` , `202` , `203` , `204` , `205` , `206` , `207` , `208` , `209` , `210` , `211` , `212` , `213` , `214` , `215` , `401` , `402` , `403` , `404` , `405` , `406` , `407` , `408` , `502` , `503` )
VALUES 
('{$id}', '$a202', '$a203', '$a204', '$a205', '$a206', '$a207', '$a208', '$a209', '$a210', '$a211', '$a212', '$a213', '$a214', '$a215', '$a401', '$a402', '$a403', '$a404', '$a405', '$a406', '$a407', '$a408', '$a502', '$a503')"
,'param_pancerz');

}

echo("<!-- przeliczono dane. -->"); 
?>