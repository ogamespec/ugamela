<?php

if ( !defined('INSIDE') )
{
	die("Hacking attempt");
}

// Lista de recursos
{$resource = array(

1 => "metal_mine",
2 => "crystal_mine",
3 => "deuterium_sintetizer",
4 => "solar_plant",
12 => "fusion_plant",
14 => "robot_factory",
15 => "nano_factory",
21 => "hangar",
22 => "metal_store",
23 => "crystal_store",
24 => "deuterium_store",
31 => "laboratory",
33 => "terraformer",
34 => "ally_deposit",
44 => "silo",

106 => "spy_tech",
108 => "computer_tech",
109 => "military_tech",
110 => "defence_tech",
111 => "shield_tech",
113 => "energy_tech",
114 => "hyperspace_tech",
115 => "combustion_tech",
117 => "impulse_motor_tech",
118 => "hyperspace_motor_tech",
120 => "laser_tech",
121 => "ionic_tech",
122 => "buster_tech",
123 => "intergalactic_tech",
199 => "graviton_tech",

202 => "small_ship_cargo",
203 => "big_ship_cargo",
204 => "light_hunter",
205 => "heavy_hunter",
206 => "crusher",
207 => "battle_ship",
208 => "colonizer",
209 => "recycler",
210 => "spy_sonde",
211 => "bomber_ship",
212 => "solar_satelit",
213 => "destructor",
214 => "dearth_star",
215 => "battleship",

401 => "misil_launcher",
402 => "small_laser",
403 => "big_laser",
404 => "gauss_canyon",
405 => "ionic_canyon",
406 => "buster_canyon",
407 => "small_protection_shield",
408 => "big_protection_shield",
502 => "interceptor_misil",
503 => "interplanetary_misil",
41 => "lunar_base",
42 => "sensor_phalax",
43 => "quantic_jump"
);}

// Requerimientos
{$requeriments = array(
//Edificios
12 => array(3=>5,113=>3),
15 => array(14=>10,108=>10),
21 => array(14=>2),
33 => array(15=>1,113=>12),
//Tecnologias
106 => array(31=>3),
108 => array(31=>1),
109 => array(31=>4),
110 => array(113=>3,31=>6),
111 => array(31=>2),
113 => array(31=>1),
114 => array(113=>5,110=>5,31=>7),
115 => array(113=>1,31=>1),
117 => array(113=>1,31=>2),
118 => array(114=>3,31=>7),
120 => array(31=>1,113=>2),
121 => array(31=>4,120=>5,113=>4),
122 => array(31=>5,113=>8,120=>10,121=>5),
123 => array(31=>10,108=>8,114=>8),
199 => array(31=>12),
//Naves espaciales
202 => array(21=>2,115=>2),
203 => array(21=>4,115=>6),
204 => array(21=>1,115=>1),
205 => array(21=>3,111=>2,117=>2),
206 => array(21=>5,117=>4,121=>2),
207 => array(21=>7,118=>4),
208 => array(21=>4,117=>3),
209 => array(21=>4,115=>6,110=>2),
210 => array(21=>3,115=>3,106=>2),
211 => array(117=>6,21=>8,122=>5),
212 => array(21=>1),
213 => array(21=>9,118=>6,114=>5),
214 => array(21=>12,118=>7,114=>6,199=>1),
215 => array(114=>5,120=>12,118=>5,21=>8),
//Sistemas de defensa
401 => array(21=>1),
402 => array(113=>1,21=>2,120=>3),
403 => array(113=>3,21=>4,120=>6),
404 => array(21=>6,113=>6,109=>3,110=>1),
405 => array(21=>4,121=>4),
406 => array(21=>8,122=>7),
407 => array(110=>2,21=>1),
408 => array(110=>6,21=>6),
502 => array(44=>2),
503 => array(44=>4),
//Construcciones especiales
42 => array(41=>1),
43 => array(41=>1,114=>7)
);}

{$pricelist = array(

1 => array('metal'=>60,'crystal'=>15,'deuterium'=>0,'energy'=>0,'factor'=>3/2),
2 => array('metal'=>48,'crystal'=>24,'deuterium'=>0,'energy'=>0,'factor'=>1.6,),
3 => array('metal'=>225,'crystal'=>75,'deuterium'=>0,'energy'=>0,'factor'=>3/2),
4 => array('metal'=>75,'crystal'=>30,'deuterium'=>0,'energy'=>0,'factor'=>3/2),
12 => array('metal'=>900,'crystal'=>360,'deuterium'=>180,'energy'=>0,'factor'=>1.8),
14 => array('metal'=>400,'crystal'=>120,'deuterium'=>200,'energy'=>0,'factor'=>2),
15 => array('metal'=>1000000,'crystal'=>500000,'deuterium'=>100000,'energy'=>0,'factor'=>2),
21 => array('metal'=>400,'crystal'=>200,'deuterium'=>100,'energy'=>0,'factor'=>2),
22 => array('metal'=>2000,'crystal'=>0,'deuterium'=>0,'energy'=>0,'factor'=>2),
23 => array('metal'=>2000,'crystal'=>1000,'deuterium'=>0,'energy'=>0,'factor'=>2),
24 => array('metal'=>2000,'crystal'=>2000,'deuterium'=>0,'energy'=>0,'factor'=>2),
31 => array('metal'=>200,'crystal'=>400,'deuterium'=>200,'energy'=>0,'factor'=>2),
33 => array('metal'=>0,'crystal'=>50000,'deuterium'=>100000,'energy'=>1000,'factor'=>2),
34 => array('metal'=>20000,'crystal'=>40000,'deuterium'=>0,'energy'=>0,'factor'=>2),
44 => array('metal'=>20000,'crystal'=>20000,'deuterium'=>1000,'energy'=>0,'factor'=>2),
//Tecnologias
106 => array('metal'=>200,'crystal'=>1000,'deuterium'=>200,'energy'=>0,'factor'=>2),
108 => array('metal'=>0,'crystal'=>400,'deuterium'=>600,'energy'=>0,'factor'=>2),
109 => array('metal'=>800,'crystal'=>200,'deuterium'=>0,'energy'=>0,'factor'=>2),
110 => array('metal'=>200,'crystal'=>600,'deuterium'=>0,'energy'=>0,'factor'=>2),
111 => array('metal'=>1000,'crystal'=>0,'deuterium'=>0,'energy'=>0,'factor'=>2),
113 => array('metal'=>0,'crystal'=>800,'deuterium'=>400,'energy'=>0,'factor'=>2),
114 => array('metal'=>0,'crystal'=>4000,'deuterium'=>2000,'energy'=>0,'factor'=>2),
115 => array('metal'=>400,'crystal'=>0,'deuterium'=>600,'energy'=>0,'factor'=>2),
117 => array('metal'=>2000,'crystal'=>4000,'deuterium'=>6000,'energy'=>0,'factor'=>2),
118 => array('metal'=>10000,'crystal'=>20000,'deuterium'=>6000,'energy'=>0,'factor'=>2),
120 => array('metal'=>200,'crystal'=>100,'deuterium'=>0,'energy'=>0,'factor'=>2),
121 => array('metal'=>1000,'crystal'=>300,'deuterium'=>100,'energy'=>0,'factor'=>2),
122 => array('metal'=>2000,'crystal'=>4000,'deuterium'=>1000,'energy'=>0,'factor'=>2),
123 => array('metal'=>240000,'crystal'=>400000,'deuterium'=>160000,'energy'=>0,'factor'=>2),
199 => array('metal'=>0,'crystal'=>0,'deuterium'=>0,'energy_max'=>300000,'factor'=>3),
//Naves espaciales
202 => array('metal'=>2000,'crystal'=>2000,'deuterium'=>0,'energy'=>0,'factor'=>1,'consumption'=>20,'speed'=>5000,'capacity'=>5000,'shield'=>10,'attack'=>5, 'sd'=>array(210=>5,212=>5)),
203 => array('metal'=>6000,'crystal'=>6000,'deuterium'=>0,'energy'=>0,'factor'=>1,'consumption'=>50,'speed'=>7500,'capacity'=>25000,'shield'=>25,'attack'=>5, 'sd'=>array(210=>5,212=>5)),
204 => array('metal'=>3000,'crystal'=>1000,'deuterium'=>0,'energy'=>0,'factor'=>1,'consumption'=>20,'speed'=>12500,'capacity'=>50,'shield'=>10,'attack'=>50, 'sd'=>array(210=>5,212=>5)),
205 => array('metal'=>6000,'crystal'=>4000,'deuterium'=>0,'energy'=>0,'factor'=>1,'consumption'=>75,'speed'=>10000,'capacity'=>100,'shield'=>25,'attack'=>150, 'sd'=>array(210=>5,212=>5,202=>3)),
206 => array('metal'=>20000,'crystal'=>7000,'deuterium'=>2000,'energy'=>0,'factor'=>1,'consumption'=>300,'speed'=>15000,'capacity'=>800,'shield'=>50,'attack'=>400, 'sd'=>array(210=>5,212=>5,204=>6,401=>10)),
207 => array('metal'=>45000,'crystal'=>15000,'deuterium'=>0,'energy'=>0,'factor'=>1,'consumption'=>500,'speed'=>10000,'capacity'=>1500,'shield'=>200,'attack'=>1000, 'sd'=>array(210=>5,212=>5)),
208 => array('metal'=>10000,'crystal'=>20000,'deuterium'=>10000,'energy'=>0,'factor'=>1,'consumption'=>1000,'speed'=>2500,'capacity'=>7500,'shield'=>100,'attack'=>50, 'sd'=>array(210=>5,212=>5)),
209 => array('metal'=>10000,'crystal'=>6000,'deuterium'=>2000,'energy'=>0,'factor'=>1,'consumption'=>300,'speed'=>2000,'capacity'=>20000, 'shield'=>10,'attack'=>1, 'sd'=>array(210=>5,212=>5)),
210 => array('metal'=>0,'crystal'=>1000,'deuterium'=>0,'energy'=>0,'factor'=>1,'consumption'=>1,'speed'=>100000000,'capacity'=>5, 'shield'=>0,'attack'=>0, 'sd'=>array(210=>0)),
211 => array('metal'=>50000,'crystal'=>25000,'deuterium'=>15000,'energy'=>0,'factor'=>1,'consumption'=>1000,'speed'=>4000,'capacity'=>500, 'shield'=>500,'attack'=>1000, 'sd'=>array(210=>5,212=>5,401=>20,402=>20,403=>10,405=>10)),
212 => array('metal'=>0,'crystal'=>2000,'deuterium'=>500,'energy'=>0,'factor'=>1,'shield'=>10,'attack'=>5, 'attack'=>1, 'sd'=>array(212=>0)),
213 => array('metal'=>60000,'crystal'=>50000,'deuterium'=>15000,'energy'=>0,'factor'=>1,'consumption'=>1000,'speed'=>5000,'capacity'=>2000, 'shield'=>500,'attack'=>2000, 'sd'=>array(210=>5,212=>5,402=>10,215=>2)),
214 => array('metal'=>5000000,'crystal'=>4000000,'deuterium'=>1000000,'energy'=>0,'factor'=>1,'consumption'=>100,'speed'=>100,'capacity'=>1000000, 'shield'=>50000,'attack'=>200000, 'sd'=>array(210=>1250,212=>1250,202=>250,203=>250,204=>200,205=>100,206=>33,207=>30,208=>250,209=>250,211=>25,215=>15,401=>200,402=>200,403=>100,404=>50,405=>100)),
215 => array('metal'=>30000,'crystal'=>40000,'deuterium'=>15000,'energy'=>0,'factor'=>1,'consumption'=>250,'speed'=>10000,'capacity'=>750, 'shield'=>400,'attack'=>700, 'sd'=>array(210=>5,212=>5,202=>3,203=>3,205=>4,206=>4,207=>7)),
//Sistemas de defensa
401 => array('metal'=>2000,'crystal'=>0,'deuterium'=>0,'energy'=>0,'factor'=>1, 'shield'=>20, 'attack'=>80, 'sd'=>array(401=>0)),
402 => array('metal'=>1500,'crystal'=>500,'deuterium'=>0,'energy'=>0,'factor'=>1, 'shield'=>25, 'attack'=>100, 'sd'=>array(402=>0)),
403 => array('metal'=>6000,'crystal'=>2000,'deuterium'=>0,'energy'=>0,'factor'=>1, 'shield'=>100, 'attack'=>250, 'sd'=>array(403=>0)),
404 => array('metal'=>20000,'crystal'=>15000,'deuterium'=>2000,'energy'=>0,'factor'=>1, 'shield'=>200, 'attack'=>1100, 'sd'=>array(404=>0)),
405 => array('metal'=>2000,'crystal'=>6000,'deuterium'=>0,'energy'=>0,'factor'=>1, 'shield'=>500, 'attack'=>150, 'sd'=>array(405=>0)),
406 => array('metal'=>50000,'crystal'=>50000,'deuterium'=>30000,'energy'=>0,'factor'=>1, 'shield'=>300, 'attack'=>3000, 'sd'=>array(406=>0)),
407 => array('metal'=>10000,'crystal'=>10000,'deuterium'=>0,'energy'=>0,'factor'=>1, 'shield'=>2000, 'attack'=>1, 'sd'=>array(407=>0)),
408 => array('metal'=>50000,'crystal'=>50000,'deuterium'=>0,'energy'=>0,'factor'=>1, 'shield'=>2000, 'attack'=>1, 'sd'=>array(408=>0)),
//rakiety 
502 => array('metal'=>8000,'crystal'=>2000,'deuterium'=>0,'energy'=>0,'factor'=>1,'shield'=>1,'attack'=>1),
503 => array('metal'=>12500,'crystal'=>2500,'deuterium'=>10000,'energy'=>0,'factor'=>1,'shield'=>1,'attack'=>12000),


//ksiezyc
41 => array('metal'=>20000,'crystal'=>40000,'deuterium'=>20000,'energy'=>0,'factor'=>1),
42 => array('metal'=>20000,'crystal'=>40000,'deuterium'=>20000,'energy'=>0,'factor'=>1),
43 => array('metal'=>2000000,'crystal'=>4000000,'deuterium'=>2000000,'energy'=>0,'factor'=>1)

);}

{$production = array(
1 => array('metal'=>40,'crystal'=>10,'deuterium'=>0,'energy'=>0,'factor'=>3/2,
	'formular' => array(
		//Produccion = 30 * Nivel * 1,1^Nivel
		'metal'=>'return (30 * $planetrow[$resource[1]] *  pow((1.1),$planetrow[$resource[1]])) *(0.1*$planetrow["{$resource[1]}_porcent"]);',
		'crystal'=>'return "0";',
		'deuterium'=>'return "0";',
		//10 * Nivel * 1,1^Nivel
		'energy'=>'return - (10 * $planetrow[$resource[1]] *  pow((1.1),$planetrow[$resource[1]]))*( 0.1*$planetrow["{$resource[1]}_porcent"]);')
),
2 => array('metal'=>30,'crystal'=>15,'deuterium'=>0,'energy'=>0,'factor'=>1.6,
	'formular' => array(
		'metal'=>'return "0";',
		//Produccion = 20 * Nivel * 1,1^Nivel
		'crystal'=>'return ( 20*$planetrow[$resource[2]]*  pow((1.1),$planetrow[$resource[2]]))* (0.1*$planetrow["{$resource[2]}_porcent"]);',
		'deuterium'=>'return "0";',
		//10 * Nivel * 1,1^Nivel
		'energy'=>'return - (10*$planetrow[$resource[2]]*  pow((1.1),$planetrow[$resource[2]])) * (0.1*$planetrow["{$resource[2]}_porcent"]);')
),
3 => array('metal'=>150,'crystal'=>50,'deuterium'=>0,'energy'=>0,'factor'=>3/2,
	'formular' => array(
		'metal'=>'return "0";',
		'crystal'=>'return "0";',
		//Produccion = 10 * Nivel * 1,1^Nivel * ( − 0,002 * Temp.maxima + 1,28)
		'deuterium'=>'return ((10 *$planetrow[$resource[3]]*  pow((1.1),$planetrow[$resource[3]]))*(-0.002*$planetrow["temp_max"]+1.28))* 0.1 * $planetrow["{$resource[3]}_porcent"];',
		'energy'=>'return -(30 * $planetrow[$resource[3]] * pow((1.1),$planetrow[$resource[3]])) * 0.1*$planetrow["{$resource[3]}_porcent"];')
),
4 => array('metal'=>50,'crystal'=>20,'deuterium'=>0,'energy'=>0,'factor'=>3/2,
	'formular' => array(
		'metal'=>'return "0";',
		'crystal'=>'return "0";',
		'deuterium'=>'return "0";',
		//Produccion = 20 * Nivel * 1,1^Nivel
		'energy'=>'return (20 * $planetrow[$resource[4]] * pow((1.1),$planetrow[$resource[4]]))* (0.1*$planetrow["{$resource[4]}_porcent"]);')
),
12 => array('metal'=>500,'crystal'=>200,'deuterium'=>100,'energy'=>0,'factor'=>1.8,
	'formular' => array(
		'metal'=>'return "0";',
		'crystal'=>'return "0";',
		//10 * Nivel * 1,1Nivel
		'deuterium'=>'return -(10*$planetrow[$resource[12]]*pow((1.1),$planetrow[$resource[12]]))* (0.1*$planetrow["{$resource[12]}_porcent"]);',
		//Produccion = 50 * Nivel * 1,1^Nivel
		'energy'=>'return (50 * $planetrow[$resource[12]] *  pow((1.1),$planetrow[$resource[12]]))* (0.1*$planetrow["{$resource[12]}_porcent"]);')
),
//
//This work perfectly :)
212 => array('metal'=>0,'crystal'=>2000,'deuterium'=>500,'energy'=>0,'factor'=>0.5,
	'formular' => array(
		'metal'=>'return 0;',
		'crystal'=>'return 0;',
		'deuterium'=>'return 0;',
		'energy'=>'return (($planetrow["temp_max"]/4)+20)*$planetrow[$resource[212]]* 0.1*$planetrow["{$resource[212]}_porcent"];')
),
);}

$reslist['build'] = array(1,2,3,4,12,14,15,21,22,23,24,31,33,34,44);
$reslist['tech'] = array(106,108,109,110,111,113,114,115,117,118,120,121,122,123,199);
$reslist['fleet'] = array(202,203,204,205,206,207,208,209,210,211,212,213,214,215);
$reslist['defense'] = array(401,402,403,404,405,406,407,408,502,503);

// Created by Perberos. All rights reversed (C) 2006
?>