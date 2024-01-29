<?php //infos.php


define('INSIDE', true);
$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);

if(!check_user()){ header("Location: login.".$phpEx); }

//
// Esta funcion permite cambiar el planeta actual.
//
include($ugamela_root_path . 'includes/planet_toggle.'.$phpEx);

$planetrow = doquery("SELECT * FROM {{table}} WHERE id={$user['current_planet']}",'planets',true);
$mnoznik = $game_config['resource_multiplier'];
echo"$res_multip";
includeLang('tech');
includeLang('infos');

$info = $lang['info'][$gid];

$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];

if($gid>=1 &&$gid<=44){$TitleClass = str_replace('%n',$lang['tech'][0],$lang['Information_on']);}
elseif($gid>=106 &&$gid<=199){$TitleClass = str_replace('%n',$lang['tech'][100],$lang['Information_on']);}
elseif($gid>=202 &&$gid<=214){$TitleClass = str_replace('%n',$lang['tech'][200],$lang['Information_on']);}
elseif($gid>=401 &&$gid<=503){$TitleClass = str_replace('%n',$lang['tech'][400],$lang['Information_on']);}

$parse = array();
$parse['TitleClass'] = $TitleClass;
$parse['Name'] = $lang['Name'];
$parse['tech'] = $info['name'];
$parse['dpath'] = $dpath;
$parse['gid'] = $gid;
$parse['description'] = nl2br($info['description']);
$parse['dodatek'] = $info['dodatek'];

$kolorpoziom = $user['kolorpoziom'];	
$kolorminus = $user['kolorminus'];	
$kolorplus = $user['kolorplus'];	

$parse['kopalnia-1'] = NULL;
$parse['wydobycie-1'] = NULL;
$parse['kopalnia-2'] = NULL;
$parse['wydobycie-2'] = NULL;
$parse['kopalnia'] = NULL;
$parse['wydobycie'] = NULL;
$parse['kopalnia+1'] = NULL;
$parse['wydobycie+1'] = NULL;
$parse['kopalnia+2'] = NULL;
$parse['wydobycie+2'] = NULL;
$parse['kopalnia+3'] = NULL;
$parse['wydobycie+3'] = NULL;
$parse['kopalnia+4'] = NULL;
$parse['wydobycie+4'] = NULL;
$parse['kopalnia+5'] = NULL;
$parse['wydobycie+5'] = NULL;
$parse['kopalnia+6'] = NULL;
$parse['wydobycie+6'] = NULL;
$parse['kopalnia+7'] = NULL;
$parse['wydobycie+7'] = NULL;
$parse['kopalnia+8'] = NULL;
$parse['wydobycie+8'] = NULL;
$parse['kopalnia+9'] = NULL;
$parse['wydobycie+9'] = NULL;
$parse['kopalnia+10'] = NULL;
$parse['wydobycie+10'] = NULL;
$parse['kopalnia+11'] = NULL;
$parse['wydobycie+11'] = NULL;
$parse['kopalnia+12'] = NULL;
$parse['wydobycie+12'] = NULL;

$parse['pobor-1'] = NULL;
$parse['pobor-2'] = NULL;
$parse['pobor'] = NULL;
$parse['pobor+1'] = NULL;
$parse['pobor+2'] = NULL;
$parse['pobor+3'] = NULL;
$parse['pobor+4'] = NULL;
$parse['pobor+5'] = NULL;
$parse['pobor+6'] = NULL;
$parse['pobor+7'] = NULL;
$parse['pobor+8'] = NULL;
$parse['pobor+9'] = NULL;
$parse['pobor+10'] = NULL;
$parse['pobor+11'] = NULL;
$parse['pobor+12'] = NULL;

$tr = "<tr><th>";
$thc = "</th><th>";
$trc = "</th></tr>";
if ($gid == 1)
{
$kop_metal = $planetrow["metal_mine"];
$kop_metal = $kop_metal;
$kop_metalmm1 = $kop_metal-1;
$kop_metalmm2 = $kop_metal-2;
$kop_metaldd1 = $kop_metal+1;
$kop_metaldd2 = $kop_metal+2;
$kop_metaldd3 = $kop_metal+3;
$kop_metaldd4 = $kop_metal+4;
$kop_metaldd5 = $kop_metal+5;
$kop_metaldd6 = $kop_metal+6;
$kop_metaldd7 = $kop_metal+7;
$kop_metaldd8 = $kop_metal+8;
$kop_metaldd9 = $kop_metal+9;
$kop_metaldd10 = $kop_metal+10;
$kop_metaldd11 = $kop_metal+11;
$kop_metaldd12 = $kop_metal+12;

$parse['kopalnia'] = "$tr<font color=$kolorminus>$kop_metal$thc";
$parse['kopalnia-1'] = "$tr$kop_metalmm1$thc";
$parse['kopalnia-2'] = "$tr$kop_metalmm2$thc";
$parse['kopalnia+1'] = "$tr$kop_metaldd1$thc";
$parse['kopalnia+2'] = "$tr$kop_metaldd2$thc";
$parse['kopalnia+3'] = "$tr$kop_metaldd3$thc";
$parse['kopalnia+4'] = "$tr$kop_metaldd4$thc";
$parse['kopalnia+5'] = "$tr$kop_metaldd5$thc";
$parse['kopalnia+6'] = "$tr$kop_metaldd6$thc";
$parse['kopalnia+7'] = "$tr$kop_metaldd7$thc";
$parse['kopalnia+8'] = "$tr$kop_metaldd8$thc";
$parse['kopalnia+9'] = "$tr$kop_metaldd9$thc";
$parse['kopalnia+10'] = "$tr$kop_metaldd10$thc";
$parse['kopalnia+11'] = "$tr$kop_metaldd11$thc";
$parse['kopalnia+12'] = "$tr$kop_metaldd12$thc";

$wyd_metal = $planetrow["metal_perhour"];
$parse['wydobycie'] = $wyd_metal;
$wyd_metalm1 = floor((30 * ($planetrow[$resource[1]]-1) *  pow((1.1),($planetrow[$resource[1]]-1)))*$mnoznik);
$wyd_metalm2 = floor((30 * ($planetrow[$resource[1]]-2) *  pow((1.1),($planetrow[$resource[1]]-2)))*$mnoznik);
$wyd_metal1 = floor((30 * ($planetrow[$resource[1]]+1) *  pow((1.1),($planetrow[$resource[1]]+1)))*$mnoznik);
$wyd_metal2 = floor((30 * ($planetrow[$resource[1]]+2) *  pow((1.1),($planetrow[$resource[1]]+2)))*$mnoznik);
$wyd_metal3 = floor((30 * ($planetrow[$resource[1]]+3) *  pow((1.1),($planetrow[$resource[1]]+3)))*$mnoznik);
$wyd_metal4 = floor((30 * ($planetrow[$resource[1]]+4) *  pow((1.1),($planetrow[$resource[1]]+4)))*$mnoznik);
$wyd_metal5 = floor((30 * ($planetrow[$resource[1]]+5) *  pow((1.1),($planetrow[$resource[1]]+5)))*$mnoznik);
$wyd_metal6 = floor((30 * ($planetrow[$resource[1]]+6) *  pow((1.1),($planetrow[$resource[1]]+6)))*$mnoznik);
$wyd_metal7 = floor((30 * ($planetrow[$resource[1]]+7) *  pow((1.1),($planetrow[$resource[1]]+7)))*$mnoznik);
$wyd_metal8 = floor((30 * ($planetrow[$resource[1]]+8) *  pow((1.1),($planetrow[$resource[1]]+8)))*$mnoznik);
$wyd_metal9 = floor((20 * ($planetrow["metal_mine"]+9) *  pow((1.1),($planetrow["metal_mine"]+9)))*$mnoznik);
$wyd_metal10 = floor((20 * ($planetrow["metal_mine"]+10) *  pow((1.1),($planetrow["metal_mine"]+10)))*$mnoznik);
$wyd_metal11 = floor((20 * ($planetrow["metal_mine"]+11) *  pow((1.1),($planetrow["metal_mine"]+11)))*$mnoznik);
$wyd_metal12 = floor((20 * ($planetrow["metal_mine"]+12) *  pow((1.1),($planetrow["metal_mine"]+12)))*$mnoznik);

$roznicam1 = $wyd_metalm1 - $wyd_metal;
$roznicam2 = $wyd_metalm2 - $wyd_metal;
$roznicad1 = $wyd_metal1 - $wyd_metal;
$roznicad2 = $wyd_metal2 - $wyd_metal;
$roznicad3 = $wyd_metal3 - $wyd_metal;
$roznicad4 = $wyd_metal4 - $wyd_metal;
$roznicad5 = $wyd_metal5 - $wyd_metal;
$roznicad6 = $wyd_metal6 - $wyd_metal;
$roznicad7 = $wyd_metal7 - $wyd_metal;
$roznicad8 = $wyd_metal8 - $wyd_metal;
$roznicad9 = $wyd_metal9 - $wyd_metal;
$roznicad10 = $wyd_metal10 - $wyd_metal;
$roznicad11 = $wyd_metal11 - $wyd_metal;
$roznicad12 = $wyd_metal12 - $wyd_metal;

$wyd_metalm1 = number_format($wyd_metalm1,0,'','.');
$wyd_metalm2 = number_format($wyd_metalm2,0,'','.');
$wyd_metal1 = number_format($wyd_metal1,0,'','.');
$wyd_metal2 = number_format($wyd_metal2,0,'','.');
$wyd_metal3 = number_format($wyd_metal3,0,'','.');
$wyd_metal4 = number_format($wyd_metal4,0,'','.');
$wyd_metal5 = number_format($wyd_metal5,0,'','.');
$wyd_metal6 = number_format($wyd_metal6,0,'','.');
$wyd_metal7 = number_format($wyd_metal7,0,'','.');
$wyd_metal8 = number_format($wyd_metal8,0,'','.');
$wyd_metal9 = number_format($wyd_metal9,0,'','.');
$wyd_metal10 = number_format($wyd_metal10,0,'','.'); 
$wyd_metal11 = number_format($wyd_metal11,0,'','.');
$wyd_metal12 = number_format($wyd_metal12,0,'','.');


$roznicam1 = number_format($roznicam1,0,'','.');
$roznicam2 = number_format($roznicam2,0,'','.');
$roznicad1 = number_format($roznicad1,0,'','.');
$roznicad2 = number_format($roznicad2,0,'','.');
$roznicad3 = number_format($roznicad3,0,'','.');
$roznicad4 = number_format($roznicad4,0,'','.');
$roznicad5 = number_format($roznicad5,0,'','.');
$roznicad6 = number_format($roznicad6,0,'','.');
$roznicad7 = number_format($roznicad7,0,'','.');
$roznicad8 = number_format($roznicad8,0,'','.');
$roznicad9 = number_format($roznicad9,0,'','.');
$roznicad10 = number_format($roznicad10,0,'','.'); 
$roznicad11 = number_format($roznicad11,0,'','.');
$roznicad12 = number_format($roznicad12,0,'','.');

$parse['wydobycie'] = "<font color=$kolorpoziom>$wyd_metal </font>$thc";
$parse['wydobycie-1'] = "$wyd_metalm1 <font color=$kolorminus>[$roznicam1]</font> $thc";
$parse['wydobycie-2'] = "$wyd_metalm2 <font color=$kolorminus>[$roznicam2]</font> $thc";
$parse['wydobycie+1'] = "$wyd_metal1 <font color=$kolorplus>[$roznicad1]</font> $thc";
$parse['wydobycie+2'] = "$wyd_metal2 <font color=$kolorplus>[$roznicad2]</font> $thc";
$parse['wydobycie+3'] = "$wyd_metal3 <font color=$kolorplus>[$roznicad3]</font> $thc";
$parse['wydobycie+4'] = "$wyd_metal4 <font color=$kolorplus>[$roznicad4]</font> $thc";
$parse['wydobycie+5'] = "$wyd_metal5 <font color=$kolorplus>[$roznicad5]</font> $thc";
$parse['wydobycie+6'] = "$wyd_metal6 <font color=$kolorplus>[$roznicad6]</font> $thc";
$parse['wydobycie+7'] = "$wyd_metal7 <font color=$kolorplus>[$roznicad7]</font> $thc";
$parse['wydobycie+8'] = "$wyd_metal8 <font color=$kolorplus>[$roznicad8]</font> $thc";
$parse['wydobycie+9'] = "$wyd_metal9 <font color=$kolorplus>[$roznicad9]</font> $thc";
$parse['wydobycie+10'] = "$wyd_metal10 <font color=$kolorplus>[$roznicad10]</font> $thc";
$parse['wydobycie+11'] = "$wyd_metal11 <font color=$kolorplus>[$roznicad11]</font> $thc";
$parse['wydobycie+12'] = "$wyd_metal12 <font color=$kolorplus>[$roznicad12]</font> $thc";

$pobor_metm1 = ceil((10 * ($planetrow[$resource[1]]-1) *  pow((1.1),($planetrow[$resource[1]]-1)))*$mnoznik);
$pobor_metm2 = ceil((10 * ($planetrow[$resource[1]]-2) *  pow((1.1),($planetrow[$resource[1]]-2)))*$mnoznik);
$pobor_met = ceil((10 * $planetrow[$resource[1]] *  pow((1.1),$planetrow[$resource[1]]))*$mnoznik);
$pobor_metd1 = ceil((10 * ($planetrow[$resource[1]]+1) *  pow((1.1),($planetrow[$resource[1]]+1)))*$mnoznik);
$pobor_metd2 = ceil((10 * ($planetrow[$resource[1]]+2) *  pow((1.1),($planetrow[$resource[1]]+2)))*$mnoznik);
$pobor_metd3 = ceil((10 * ($planetrow[$resource[1]]+3) *  pow((1.1),($planetrow[$resource[1]]+3)))*$mnoznik);
$pobor_metd4 = ceil((10 * ($planetrow[$resource[1]]+4) *  pow((1.1),($planetrow[$resource[1]]+4)))*$mnoznik);
$pobor_metd5 = ceil((10 * ($planetrow[$resource[1]]+5) *  pow((1.1),($planetrow[$resource[1]]+5)))*$mnoznik);
$pobor_metd6 = ceil((10 * ($planetrow[$resource[1]]+6) *  pow((1.1),($planetrow[$resource[1]]+6)))*$mnoznik);
$pobor_metd7 = ceil((10 * ($planetrow[$resource[1]]+7) *  pow((1.1),($planetrow[$resource[1]]+7)))*$mnoznik);
$pobor_metd8 = ceil((10 * ($planetrow[$resource[1]]+8) *  pow((1.1),($planetrow[$resource[1]]+8)))*$mnoznik);
$pobor_metd9 = ceil((10 * ($planetrow[$resource[1]]+9) *  pow((1.1),($planetrow[$resource[1]]+9)))*$mnoznik);
$pobor_metd10 = ceil((10 * ($planetrow[$resource[1]]+10) *  pow((1.1),($planetrow[$resource[1]]+10)))*$mnoznik);
$pobor_metd11 = ceil((10 * ($planetrow[$resource[1]]+11) *  pow((1.1),($planetrow[$resource[1]]+11)))*$mnoznik);
$pobor_metd12 = ceil((10 * ($planetrow[$resource[1]]+12) *  pow((1.1),($planetrow[$resource[1]]+12)))*$mnoznik);

$roznica_pobm1 = $pobor_met - $pobor_metm1;
$roznica_pobm2 = $pobor_met - $pobor_metm2;
$roznica_pobd1 = $pobor_met - $pobor_metd1;
$roznica_pobd2 = $pobor_met - $pobor_metd2;
$roznica_pobd3 = $pobor_met - $pobor_metd3;
$roznica_pobd4 = $pobor_met - $pobor_metd4;
$roznica_pobd5 = $pobor_met - $pobor_metd5;
$roznica_pobd6 = $pobor_met - $pobor_metd6;
$roznica_pobd7 = $pobor_met - $pobor_metd7;
$roznica_pobd8 = $pobor_met - $pobor_metd8;
$roznica_pobd9 = $pobor_met - $pobor_metd9;
$roznica_pobd10 = $pobor_met - $pobor_metd10;
$roznica_pobd11 = $pobor_met - $pobor_metd11;
$roznica_pobd12 = $pobor_met - $pobor_metd12;

$pobor_metm1 = number_format($pobor_metm1,0,'','.');
$pobor_metm2 = number_format($pobor_metm2,0,'','.');
$pobor_metd1 = number_format($pobor_metd1,0,'','.');
$pobor_metd2 = number_format($pobor_metd2,0,'','.');
$pobor_metd3 = number_format($pobor_metd3,0,'','.');
$pobor_metd4 = number_format($pobor_metd4,0,'','.');
$pobor_metd5 = number_format($pobor_metd5,0,'','.');
$pobor_metd6 = number_format($pobor_metd6,0,'','.');
$pobor_metd7 = number_format($pobor_metd7,0,'','.');
$pobor_metd8 = number_format($pobor_metd8,0,'','.');
$pobor_metd9 = number_format($pobor_metd9,0,'','.');
$pobor_metd10 = number_format($pobor_metd10,0,'','.'); 
$pobor_metd11 = number_format($pobor_metd11,0,'','.');
$pobor_metd12 = number_format($pobor_metd12,0,'','.');


$roznica_pobm1 = number_format($roznica_pobm1,0,'','.');
$roznica_pobm2 = number_format($roznica_pobm2,0,'','.');
$roznica_pobd1 = number_format($roznica_pobd1,0,'','.');
$roznica_pobd2 = number_format($roznica_pobd2,0,'','.');
$roznica_pobd3 = number_format($roznica_pobd3,0,'','.');
$roznica_pobd4 = number_format($roznica_pobd4,0,'','.');
$roznica_pobd5 = number_format($roznica_pobd5,0,'','.');
$roznica_pobd6 = number_format($roznica_pobd6,0,'','.');
$roznica_pobd7 = number_format($roznica_pobd7,0,'','.');
$roznica_pobd8 = number_format($roznica_pobd8,0,'','.');
$roznica_pobd9 = number_format($roznica_pobd9,0,'','.');
$roznica_pobd10 = number_format($roznica_pobd10,0,'','.'); 
$roznica_pobd11 = number_format($roznica_pobd11,0,'','.');
$roznica_pobd12 = number_format($roznica_pobd12,0,'','.');

$parse['pobor-2'] = "$pobor_metm2 <font color=$kolorplus>[$roznica_pobm2]</font> $trc";
$parse['pobor-1'] = "$pobor_metm1 <font color=$kolorplus>[$roznica_pobm1]</font> $trc";
$parse['pobor'] = "<font color=$kolorpoziom>$pobor_met$trc";
$parse['pobor+1'] = "$pobor_metd1 <font color=$kolorminus>[$roznica_pobd1]</font> $trc";
$parse['pobor+2'] = "$pobor_metd2 <font color=$kolorminus>[$roznica_pobd2]</font> $trc";
$parse['pobor+3'] = "$pobor_metd3 <font color=$kolorminus>[$roznica_pobd3]</font> $trc";
$parse['pobor+4'] = "$pobor_metd4 <font color=$kolorminus>[$roznica_pobd4]</font> $trc";
$parse['pobor+5'] = "$pobor_metd5 <font color=$kolorminus>[$roznica_pobd5]</font> $trc";
$parse['pobor+6'] = "$pobor_metd6 <font color=$kolorminus>[$roznica_pobd6]</font> $trc";
$parse['pobor+7'] = "$pobor_metd7 <font color=$kolorminus>[$roznica_pobd7]</font> $trc";
$parse['pobor+8'] = "$pobor_metd8 <font color=$kolorminus>[$roznica_pobd8]</font> $trc";
$parse['pobor+9'] = "$pobor_metd9 <font color=$kolorminus>[$roznica_pobd9]</font> $trc";
$parse['pobor+10'] = "$pobor_metd10 <font color=$kolorminus>[$roznica_pobd10]</font> $trc";
$parse['pobor+11'] = "$pobor_metd11 <font color=$kolorminus>[$roznica_pobd11]</font> $trc";
$parse['pobor+12'] = "$pobor_metd12 <font color=$kolorminus>[$roznica_pobd12]</font> $trc";
//264 - metal 1 lvl
//176 - elektr 1 lvl

}

if ($gid == 2)
{
$kop_crystal = $planetrow["crystal_mine"];
$kop_crystal = $kop_crystal;
$kop_crystalmm1 = $kop_crystal-1;
$kop_crystalmm2 = $kop_crystal-2;
$kop_crystaldd1 = $kop_crystal+1;
$kop_crystaldd2 = $kop_crystal+2;
$kop_crystaldd3 = $kop_crystal+3;
$kop_crystaldd4 = $kop_crystal+4;
$kop_crystaldd5 = $kop_crystal+5;
$kop_crystaldd6 = $kop_crystal+6;
$kop_crystaldd7 = $kop_crystal+7;
$kop_crystaldd8 = $kop_crystal+8;
$kop_crystaldd9 = $kop_crystal+9;
$kop_crystaldd10 = $kop_crystal+10;
$kop_crystaldd11 = $kop_crystal+11;
$kop_crystaldd12 = $kop_crystal+12;

$parse['kopalnia'] = "$tr<font color=$kolorminus>$kop_crystal$thc";
$parse['kopalnia-1'] = "$tr$kop_crystalmm1$thc";
$parse['kopalnia-2'] = "$tr$kop_crystalmm2$thc";
$parse['kopalnia+1'] = "$tr$kop_crystaldd1$thc";
$parse['kopalnia+2'] = "$tr$kop_crystaldd2$thc";
$parse['kopalnia+3'] = "$tr$kop_crystaldd3$thc";
$parse['kopalnia+4'] = "$tr$kop_crystaldd4$thc";
$parse['kopalnia+5'] = "$tr$kop_crystaldd5$thc";
$parse['kopalnia+6'] = "$tr$kop_crystaldd6$thc";
$parse['kopalnia+7'] = "$tr$kop_crystaldd7$thc";
$parse['kopalnia+8'] = "$tr$kop_crystaldd8$thc";
$parse['kopalnia+9'] = "$tr$kop_crystaldd9$thc";
$parse['kopalnia+10'] = "$tr$kop_crystaldd10$thc";
$parse['kopalnia+11'] = "$tr$kop_crystaldd11$thc";
$parse['kopalnia+12'] = "$tr$kop_crystaldd12$thc";

$wyd_crystal = $planetrow["crystal_perhour"];
$parse['wydobycie'] = $wyd_crystal;
$wyd_crystalm1 = floor((20 * ($planetrow["crystal_mine"]-1) *  pow((1.1),($planetrow["crystal_mine"]-1)))*$mnoznik);
$wyd_crystalm2 = floor((20 * ($planetrow["crystal_mine"]-2) *  pow((1.1),($planetrow["crystal_mine"]-2)))*$mnoznik);
$wyd_crystal1 = floor((20 * ($planetrow["crystal_mine"]+1) *  pow((1.1),($planetrow["crystal_mine"]+1)))*$mnoznik);
$wyd_crystal2 = floor((20 * ($planetrow["crystal_mine"]+2) *  pow((1.1),($planetrow["crystal_mine"]+2)))*$mnoznik);
$wyd_crystal3 = floor((20 * ($planetrow["crystal_mine"]+3) *  pow((1.1),($planetrow["crystal_mine"]+3)))*$mnoznik);
$wyd_crystal4 = floor((20 * ($planetrow["crystal_mine"]+4) *  pow((1.1),($planetrow["crystal_mine"]+4)))*$mnoznik);
$wyd_crystal5 = floor((20 * ($planetrow["crystal_mine"]+5) *  pow((1.1),($planetrow["crystal_mine"]+5)))*$mnoznik);
$wyd_crystal6 = floor((20 * ($planetrow["crystal_mine"]+6) *  pow((1.1),($planetrow["crystal_mine"]+6)))*$mnoznik);
$wyd_crystal7 = floor((20 * ($planetrow["crystal_mine"]+7) *  pow((1.1),($planetrow["crystal_mine"]+7)))*$mnoznik);
$wyd_crystal8 = floor((20 * ($planetrow["crystal_mine"]+8) *  pow((1.1),($planetrow["crystal_mine"]+8)))*$mnoznik);
$wyd_crystal9 = floor((20 * ($planetrow["crystal_mine"]+9) *  pow((1.1),($planetrow["crystal_mine"]+9)))*$mnoznik);
$wyd_crystal10 = floor((20 * ($planetrow["crystal_mine"]+10) *  pow((1.1),($planetrow["crystal_mine"]+10)))*$mnoznik);
$wyd_crystal11 = floor((20 * ($planetrow["crystal_mine"]+11) *  pow((1.1),($planetrow["crystal_mine"]+11)))*$mnoznik);
$wyd_crystal12 = floor((20 * ($planetrow["crystal_mine"]+12) *  pow((1.1),($planetrow["crystal_mine"]+12)))*$mnoznik);

$roznicam1 = $wyd_crystalm1 - $wyd_crystal;
$roznicam2 = $wyd_crystalm2 - $wyd_crystal;
$roznicad1 = $wyd_crystal1 - $wyd_crystal;
$roznicad2 = $wyd_crystal2 - $wyd_crystal;
$roznicad3 = $wyd_crystal3 - $wyd_crystal;
$roznicad4 = $wyd_crystal4 - $wyd_crystal;
$roznicad5 = $wyd_crystal5 - $wyd_crystal;
$roznicad6 = $wyd_crystal6 - $wyd_crystal;
$roznicad7 = $wyd_crystal7 - $wyd_crystal;
$roznicad8 = $wyd_crystal8 - $wyd_crystal;
$roznicad9 = $wyd_crystal9 - $wyd_crystal;
$roznicad10 = $wyd_crystal10 - $wyd_crystal;
$roznicad11 = $wyd_crystal11 - $wyd_crystal;
$roznicad12 = $wyd_crystal12 - $wyd_crystal;

$wyd_crystalm1 = number_format($wyd_crystalm1,0,'','.');
$wyd_crystalm2 = number_format($wyd_crystalm2,0,'','.');
$wyd_crystal1 = number_format($wyd_crystal1,0,'','.');
$wyd_crystal2 = number_format($wyd_crystal2,0,'','.');
$wyd_crystal3 = number_format($wyd_crystal3,0,'','.');
$wyd_crystal4 = number_format($wyd_crystal4,0,'','.');
$wyd_crystal5 = number_format($wyd_crystal5,0,'','.');
$wyd_crystal6 = number_format($wyd_crystal6,0,'','.');
$wyd_crystal7 = number_format($wyd_crystal7,0,'','.');
$wyd_crystal8 = number_format($wyd_crystal8,0,'','.');
$wyd_crystal9 = number_format($wyd_crystal9,0,'','.');
$wyd_crystal10 = number_format($wyd_crystal10,0,'','.'); 
$wyd_crystal11 = number_format($wyd_crystal11,0,'','.');
$wyd_crystal12 = number_format($wyd_crystal12,0,'','.');




$roznicam1 = number_format($roznicam1,0,'','.');
$roznicam2 = number_format($roznicam2,0,'','.');
$roznicad1 = number_format($roznicad1,0,'','.');
$roznicad2 = number_format($roznicad2,0,'','.');
$roznicad3 = number_format($roznicad3,0,'','.');
$roznicad4 = number_format($roznicad4,0,'','.');
$roznicad5 = number_format($roznicad5,0,'','.');
$roznicad6 = number_format($roznicad6,0,'','.');
$roznicad7 = number_format($roznicad7,0,'','.');
$roznicad8 = number_format($roznicad8,0,'','.');
$roznicad9 = number_format($roznicad9,0,'','.');
$roznicad10 = number_format($roznicad10,0,'','.'); 
$roznicad11 = number_format($roznicad11,0,'','.');
$roznicad12 = number_format($roznicad12,0,'','.');

$parse['wydobycie'] = "<font color=$kolorpoziom>$wyd_crystal </font>$thc";
$parse['wydobycie-1'] = "$wyd_crystalm1 <font color=$kolorminus>[$roznicam1]</font> $thc";
$parse['wydobycie-2'] = "$wyd_crystalm2 <font color=$kolorminus>[$roznicam2]</font> $thc";
$parse['wydobycie+1'] = "$wyd_crystal1 <font color=$kolorplus>[$roznicad1]</font> $thc";
$parse['wydobycie+2'] = "$wyd_crystal2 <font color=$kolorplus>[$roznicad2]</font> $thc";
$parse['wydobycie+3'] = "$wyd_crystal3 <font color=$kolorplus>[$roznicad3]</font> $thc";
$parse['wydobycie+4'] = "$wyd_crystal4 <font color=$kolorplus>[$roznicad4]</font> $thc";
$parse['wydobycie+5'] = "$wyd_crystal5 <font color=$kolorplus>[$roznicad5]</font> $thc";
$parse['wydobycie+6'] = "$wyd_crystal6 <font color=$kolorplus>[$roznicad6]</font> $thc";
$parse['wydobycie+7'] = "$wyd_crystal7 <font color=$kolorplus>[$roznicad7]</font> $thc";
$parse['wydobycie+8'] = "$wyd_crystal8 <font color=$kolorplus>[$roznicad8]</font> $thc";
$parse['wydobycie+9'] = "$wyd_crystal9 <font color=$kolorplus>[$roznicad9]</font> $thc";
$parse['wydobycie+10'] = "$wyd_crystal10 <font color=$kolorplus>[$roznicad10]</font> $thc";
$parse['wydobycie+11'] = "$wyd_crystal11 <font color=$kolorplus>[$roznicad11]</font> $thc";
$parse['wydobycie+12'] = "$wyd_crystal12 <font color=$kolorplus>[$roznicad12]</font> $thc";

$pobor_krm1 = ceil((10 * ($planetrow[$resource[2]]-1) *  pow((1.1),($planetrow[$resource[2]]-1)))*$mnoznik);
$pobor_krm2 = ceil((10 * ($planetrow[$resource[2]]-2) *  pow((1.1),($planetrow[$resource[2]]-2)))*$mnoznik);
$pobor_kr = ceil((10 * $planetrow[$resource[2]] *  pow((1.1),$planetrow[$resource[2]]))*$mnoznik);
$pobor_krd1 = ceil((10 * ($planetrow[$resource[2]]+1) *  pow((1.1),($planetrow[$resource[2]]+1)))*$mnoznik);
$pobor_krd2 = ceil((10 * ($planetrow[$resource[2]]+2) *  pow((1.1),($planetrow[$resource[2]]+2)))*$mnoznik);
$pobor_krd3 = ceil((10 * ($planetrow[$resource[2]]+3) *  pow((1.1),($planetrow[$resource[2]]+3)))*$mnoznik);
$pobor_krd4 = ceil((10 * ($planetrow[$resource[2]]+4) *  pow((1.1),($planetrow[$resource[2]]+4)))*$mnoznik);
$pobor_krd5 = ceil((10 * ($planetrow[$resource[2]]+5) *  pow((1.1),($planetrow[$resource[2]]+5)))*$mnoznik);
$pobor_krd6 = ceil((10 * ($planetrow[$resource[2]]+6) *  pow((1.1),($planetrow[$resource[2]]+6)))*$mnoznik);
$pobor_krd7 = ceil((10 * ($planetrow[$resource[2]]+7) *  pow((1.1),($planetrow[$resource[2]]+7)))*$mnoznik);
$pobor_krd8 = ceil((10 * ($planetrow[$resource[2]]+8) *  pow((1.1),($planetrow[$resource[2]]+8)))*$mnoznik);
$pobor_krd9 = ceil((10 * ($planetrow[$resource[2]]+9) *  pow((1.1),($planetrow[$resource[2]]+9)))*$mnoznik);
$pobor_krd10 = ceil((10 * ($planetrow[$resource[2]]+10) *  pow((1.1),($planetrow[$resource[2]]+10)))*$mnoznik);
$pobor_krd11 = ceil((10 * ($planetrow[$resource[2]]+11) *  pow((1.1),($planetrow[$resource[2]]+11)))*$mnoznik);
$pobor_krd12 = ceil((10 * ($planetrow[$resource[2]]+12) *  pow((1.1),($planetrow[$resource[2]]+12)))*$mnoznik);


$roznica_pobm1 = $pobor_kr - $pobor_krm1;
$roznica_pobm2 = $pobor_kr - $pobor_krm2;
$roznica_pobd1 = $pobor_kr - $pobor_krd1;
$roznica_pobd2 = $pobor_kr - $pobor_krd2;
$roznica_pobd3 = $pobor_kr - $pobor_krd3;
$roznica_pobd4 = $pobor_kr - $pobor_krd4;
$roznica_pobd5 = $pobor_kr - $pobor_krd5;
$roznica_pobd6 = $pobor_kr - $pobor_krd6;
$roznica_pobd7 = $pobor_kr - $pobor_krd7;
$roznica_pobd8 = $pobor_kr - $pobor_krd8;
$roznica_pobd9 = $pobor_kr - $pobor_krd9;
$roznica_pobd10 = $pobor_kr - $pobor_krd10;
$roznica_pobd11 = $pobor_kr - $pobor_krd11;
$roznica_pobd12 = $pobor_kr - $pobor_krd12;

$pobor_krm1 = number_format($pobor_krm1,0,'','.');
$pobor_krm2 = number_format($pobor_krm2,0,'','.');
$pobor_krd1 = number_format($pobor_krd1,0,'','.');
$pobor_krd2 = number_format($pobor_krd2,0,'','.');
$pobor_krd3 = number_format($pobor_krd3,0,'','.');
$pobor_krd4 = number_format($pobor_krd4,0,'','.');
$pobor_krd5 = number_format($pobor_krd5,0,'','.');
$pobor_krd6 = number_format($pobor_krd6,0,'','.');
$pobor_krd7 = number_format($pobor_krd7,0,'','.');
$pobor_krd8 = number_format($pobor_krd8,0,'','.');
$pobor_krd9 = number_format($pobor_krd9,0,'','.');
$pobor_krd10 = number_format($pobor_krd10,0,'','.'); 
$pobor_krd11 = number_format($pobor_krd11,0,'','.');
$pobor_krd12 = number_format($pobor_krd12,0,'','.');


$roznica_pobm1 = number_format($roznica_pobm1,0,'','.');
$roznica_pobm2 = number_format($roznica_pobm2,0,'','.');
$roznica_pobd1 = number_format($roznica_pobd1,0,'','.');
$roznica_pobd2 = number_format($roznica_pobd2,0,'','.');
$roznica_pobd3 = number_format($roznica_pobd3,0,'','.');
$roznica_pobd4 = number_format($roznica_pobd4,0,'','.');
$roznica_pobd5 = number_format($roznica_pobd5,0,'','.');
$roznica_pobd6 = number_format($roznica_pobd6,0,'','.');
$roznica_pobd7 = number_format($roznica_pobd7,0,'','.');
$roznica_pobd8 = number_format($roznica_pobd8,0,'','.');
$roznica_pobd9 = number_format($roznica_pobd9,0,'','.');
$roznica_pobd10 = number_format($roznica_pobd10,0,'','.'); 
$roznica_pobd11 = number_format($roznica_pobd11,0,'','.');
$roznica_pobd12 = number_format($roznica_pobd12,0,'','.');

$parse['pobor-2'] = "$pobor_krm2 <font color=$kolorplus>[$roznica_pobm2]</font> $trc";
$parse['pobor-1'] = "$pobor_krm1 <font color=$kolorplus>[$roznica_pobm1]</font> $trc";
$parse['pobor'] = "<font color=$kolorpoziom>$pobor_kr$trc";
$parse['pobor+1'] = "$pobor_krd1 <font color=$kolorminus>[$roznica_pobd1]</font> $trc";
$parse['pobor+2'] = "$pobor_krd2 <font color=$kolorminus>[$roznica_pobd2]</font> $trc";
$parse['pobor+3'] = "$pobor_krd3 <font color=$kolorminus>[$roznica_pobd3]</font> $trc";
$parse['pobor+4'] = "$pobor_krd4 <font color=$kolorminus>[$roznica_pobd4]</font> $trc";
$parse['pobor+5'] = "$pobor_krd5 <font color=$kolorminus>[$roznica_pobd5]</font> $trc";
$parse['pobor+6'] = "$pobor_krd6 <font color=$kolorminus>[$roznica_pobd6]</font> $trc";
$parse['pobor+7'] = "$pobor_krd7 <font color=$kolorminus>[$roznica_pobd7]</font> $trc";
$parse['pobor+8'] = "$pobor_krd8 <font color=$kolorminus>[$roznica_pobd8]</font> $trc";
$parse['pobor+9'] = "$pobor_krd9 <font color=$kolorminus>[$roznica_pobd9]</font> $trc";
$parse['pobor+10'] = "$pobor_krd10 <font color=$kolorminus>[$roznica_pobd10]</font> $trc";
$parse['pobor+11'] = "$pobor_krd11 <font color=$kolorminus>[$roznica_pobd11]</font> $trc";
$parse['pobor+12'] = "$pobor_krd12 <font color=$kolorminus>[$roznica_pobd12]</font> $trc";
//264 - crystal 1 lvl
//176 - elektr 1 lvl
}

if ($gid == 3)
{
$kop_deuterium = $planetrow["deuterium_sintetizer"];
$kop_deuterium = $kop_deuterium;
$kop_deuteriummm1 = $kop_deuterium-1;
$kop_deuteriummm2 = $kop_deuterium-2;
$kop_deuteriumdd1 = $kop_deuterium+1;
$kop_deuteriumdd2 = $kop_deuterium+2;
$kop_deuteriumdd3 = $kop_deuterium+3;
$kop_deuteriumdd4 = $kop_deuterium+4;
$kop_deuteriumdd5 = $kop_deuterium+5;
$kop_deuteriumdd6 = $kop_deuterium+6;
$kop_deuteriumdd7 = $kop_deuterium+7;
$kop_deuteriumdd8 = $kop_deuterium+8;
$kop_deuteriumdd9 = $kop_deuterium+9;
$kop_deuteriumdd10 = $kop_deuterium+10;
$kop_deuteriumdd11 = $kop_deuterium+11;
$kop_deuteriumdd12 = $kop_deuterium+12;

$parse['kopalnia'] = "$tr<font color=$kolorminus>$kop_deuterium$thc";
$parse['kopalnia-1'] = "$tr$kop_deuteriummm1$thc";
$parse['kopalnia-2'] = "$tr$kop_deuteriummm2$thc";
$parse['kopalnia+1'] = "$tr$kop_deuteriumdd1$thc";
$parse['kopalnia+2'] = "$tr$kop_deuteriumdd2$thc";
$parse['kopalnia+3'] = "$tr$kop_deuteriumdd3$thc";
$parse['kopalnia+4'] = "$tr$kop_deuteriumdd4$thc";
$parse['kopalnia+5'] = "$tr$kop_deuteriumdd5$thc";
$parse['kopalnia+6'] = "$tr$kop_deuteriumdd6$thc";
$parse['kopalnia+7'] = "$tr$kop_deuteriumdd7$thc";
$parse['kopalnia+8'] = "$tr$kop_deuteriumdd8$thc";
$parse['kopalnia+9'] = "$tr$kop_deuteriumdd9$thc";
$parse['kopalnia+10'] = "$tr$kop_deuteriumdd10$thc";
$parse['kopalnia+11'] = "$tr$kop_deuteriumdd11$thc";
$parse['kopalnia+12'] = "$tr$kop_deuteriumdd12$thc";

$wyd_deuterium = floor((10 * ($planetrow["deuterium_sintetizer"]) *  pow((1.1),($planetrow["deuterium_sintetizer"]))*(-0.002*$planetrow["max_tem"]+1.28)*$mnoznik));
$parse['wydobycie'] = $wyd_deuterium;
$wyd_deuteriumm1 = floor((10 * ($planetrow["deuterium_sintetizer"]-1) *  pow((1.1),($planetrow["deuterium_sintetizer"]-1))*(-0.002*$planetrow["max_tem"]+1.28)*$mnoznik));
$wyd_deuteriumm2 = floor((10 * ($planetrow["deuterium_sintetizer"]-2) *  pow((1.1),($planetrow["deuterium_sintetizer"]-2))*(-0.002*$planetrow["max_tem"]+1.28)*$mnoznik));
$wyd_deuterium1 = floor((10 * ($planetrow["deuterium_sintetizer"]+1) *  pow((1.1),($planetrow["deuterium_sintetizer"]+1))*(-0.002*$planetrow["max_tem"]+1.28)*$mnoznik));
$wyd_deuterium2 = floor((10 * ($planetrow["deuterium_sintetizer"]+2) *  pow((1.1),($planetrow["deuterium_sintetizer"]+2))*(-0.002*$planetrow["max_tem"]+1.28)*$mnoznik));
$wyd_deuterium3 = floor((10 * ($planetrow["deuterium_sintetizer"]+3) *  pow((1.1),($planetrow["deuterium_sintetizer"]+3))*(-0.002*$planetrow["max_tem"]+1.28)*$mnoznik));
$wyd_deuterium4 = floor((10 * ($planetrow["deuterium_sintetizer"]+4) *  pow((1.1),($planetrow["deuterium_sintetizer"]+4))*(-0.002*$planetrow["max_tem"]+1.28)*$mnoznik));
$wyd_deuterium5 = floor((10 * ($planetrow["deuterium_sintetizer"]+5) *  pow((1.1),($planetrow["deuterium_sintetizer"]+5))*(-0.002*$planetrow["max_tem"]+1.28)*$mnoznik));
$wyd_deuterium6 = floor((10 * ($planetrow["deuterium_sintetizer"]+6) *  pow((1.1),($planetrow["deuterium_sintetizer"]+6))*(-0.002*$planetrow["max_tem"]+1.28)*$mnoznik));
$wyd_deuterium7 = floor((10 * ($planetrow["deuterium_sintetizer"]+7) *  pow((1.1),($planetrow["deuterium_sintetizer"]+7))*(-0.002*$planetrow["max_tem"]+1.28)*$mnoznik));
$wyd_deuterium8 = floor((10 * ($planetrow["deuterium_sintetizer"]+8) *  pow((1.1),($planetrow["deuterium_sintetizer"]+8))*(-0.002*$planetrow["max_tem"]+1.28)*$mnoznik));
$wyd_deuterium9 = floor((10 * ($planetrow["deuterium_sintetizer"]+9) *  pow((1.1),($planetrow["deuterium_sintetizer"]+9))*(-0.002*$planetrow["max_tem"]+1.28)*$mnoznik));
$wyd_deuterium10 = floor((10 * ($planetrow["deuterium_sintetizer"]+10) *  pow((1.1),($planetrow["deuterium_sintetizer"]+10))*(-0.002*$planetrow["max_tem"]+1.28)*$mnoznik));
$wyd_deuterium11 = floor((10 * ($planetrow["deuterium_sintetizer"]+11) *  pow((1.1),($planetrow["deuterium_sintetizer"]+11))*(-0.002*$planetrow["max_tem"]+1.28)*$mnoznik));
$wyd_deuterium12 = floor((10 * ($planetrow["deuterium_sintetizer"]+12) *  pow((1.1),($planetrow["deuterium_sintetizer"]+12))*(-0.002*$planetrow["max_tem"]+1.28)*$mnoznik));

$roznicam1 = $wyd_deuteriumm1 - $wyd_deuterium;
$roznicam2 = $wyd_deuteriumm2 - $wyd_deuterium;
$roznicad1 = $wyd_deuterium1 - $wyd_deuterium;
$roznicad2 = $wyd_deuterium2 - $wyd_deuterium;
$roznicad3 = $wyd_deuterium3 - $wyd_deuterium;
$roznicad4 = $wyd_deuterium4 - $wyd_deuterium;
$roznicad5 = $wyd_deuterium5 - $wyd_deuterium;
$roznicad6 = $wyd_deuterium6 - $wyd_deuterium;
$roznicad7 = $wyd_deuterium7 - $wyd_deuterium;
$roznicad8 = $wyd_deuterium8 - $wyd_deuterium;
$roznicad9 = $wyd_deuterium9 - $wyd_deuterium;
$roznicad10 = $wyd_deuterium10 - $wyd_deuterium;
$roznicad11 = $wyd_deuterium11 - $wyd_deuterium;
$roznicad12 = $wyd_deuterium12 - $wyd_deuterium;


$wyd_deuteriumm1 = number_format($wyd_deuteriumm1,0,'','.');
$wyd_deuteriumm2 = number_format($wyd_deuteriumm2,0,'','.');
$wyd_deuterium1 = number_format($wyd_deuterium1,0,'','.');
$wyd_deuterium2 = number_format($wyd_deuterium2,0,'','.');
$wyd_deuterium3 = number_format($wyd_deuterium3,0,'','.');
$wyd_deuterium4 = number_format($wyd_deuterium4,0,'','.');
$wyd_deuterium5 = number_format($wyd_deuterium5,0,'','.');
$wyd_deuterium6 = number_format($wyd_deuterium6,0,'','.');
$wyd_deuterium7 = number_format($wyd_deuterium7,0,'','.');
$wyd_deuterium8 = number_format($wyd_deuterium8,0,'','.');
$wyd_deuterium9 = number_format($wyd_deuterium9,0,'','.');
$wyd_deuterium10 = number_format($wyd_deuterium10,0,'','.'); 
$wyd_deuterium11 = number_format($wyd_deuterium11,0,'','.');
$wyd_deuterium12 = number_format($wyd_deuterium12,0,'','.');


$roznicam1 = number_format($roznicam1,0,'','.');
$roznicam2 = number_format($roznicam2,0,'','.');
$roznicad1 = number_format($roznicad1,0,'','.');
$roznicad2 = number_format($roznicad2,0,'','.');
$roznicad3 = number_format($roznicad3,0,'','.');
$roznicad4 = number_format($roznicad4,0,'','.');
$roznicad5 = number_format($roznicad5,0,'','.');
$roznicad6 = number_format($roznicad6,0,'','.');
$roznicad7 = number_format($roznicad7,0,'','.');
$roznicad8 = number_format($roznicad8,0,'','.');
$roznicad9 = number_format($roznicad9,0,'','.');
$roznicad10 = number_format($roznicad10,0,'','.'); 
$roznicad11 = number_format($roznicad11,0,'','.');
$roznicad12 = number_format($roznicad12,0,'','.');

$parse['wydobycie'] = "<font color=$kolorpoziom>$wyd_deuterium </font>$thc";
$parse['wydobycie-1'] = "$wyd_deuteriumm1 <font color=$kolorminus>[$roznicam1]</font> $thc";
$parse['wydobycie-2'] = "$wyd_deuteriumm2 <font color=$kolorminus>[$roznicam2]</font> $thc";
$parse['wydobycie+1'] = "$wyd_deuterium1 <font color=$kolorplus>[$roznicad1]</font> $thc";
$parse['wydobycie+2'] = "$wyd_deuterium2 <font color=$kolorplus>[$roznicad2]</font> $thc";
$parse['wydobycie+3'] = "$wyd_deuterium3 <font color=$kolorplus>[$roznicad3]</font> $thc";
$parse['wydobycie+4'] = "$wyd_deuterium4 <font color=$kolorplus>[$roznicad4]</font> $thc";
$parse['wydobycie+5'] = "$wyd_deuterium5 <font color=$kolorplus>[$roznicad5]</font> $thc";
$parse['wydobycie+6'] = "$wyd_deuterium6 <font color=$kolorplus>[$roznicad6]</font> $thc";
$parse['wydobycie+7'] = "$wyd_deuterium7 <font color=$kolorplus>[$roznicad7]</font> $thc";
$parse['wydobycie+8'] = "$wyd_deuterium8 <font color=$kolorplus>[$roznicad8]</font> $thc";
$parse['wydobycie+9'] = "$wyd_deuterium9 <font color=$kolorplus>[$roznicad9]</font> $thc";
$parse['wydobycie+10'] = "$wyd_deuterium10 <font color=$kolorplus>[$roznicad10]</font> $thc";
$parse['wydobycie+11'] = "$wyd_deuterium11 <font color=$kolorplus>[$roznicad11]</font> $thc";
$parse['wydobycie+12'] = "$wyd_deuterium12 <font color=$kolorplus>[$roznicad12]</font> $thc";

$pobor_deum1 = ceil((30 * ($planetrow[$resource[3]]-1) *  pow((1.1),($planetrow[$resource[3]]-1)))*$mnoznik);
$pobor_deum2 = ceil((30 * ($planetrow[$resource[3]]-2) *  pow((1.1),($planetrow[$resource[3]]-2)))*$mnoznik);
$pobor_deu = ceil((30 * $planetrow[$resource[3]] *  pow((1.1),$planetrow[$resource[3]]))*$mnoznik);
$pobor_deud1 = ceil((30 * ($planetrow[$resource[3]]+1) *  pow((1.1),($planetrow[$resource[3]]+1)))*$mnoznik);
$pobor_deud2 = ceil((30 * ($planetrow[$resource[3]]+2) *  pow((1.1),($planetrow[$resource[3]]+2)))*$mnoznik);
$pobor_deud3 = ceil((30 * ($planetrow[$resource[3]]+3) *  pow((1.1),($planetrow[$resource[3]]+3)))*$mnoznik);
$pobor_deud4 = ceil((30 * ($planetrow[$resource[3]]+4) *  pow((1.1),($planetrow[$resource[3]]+4)))*$mnoznik);
$pobor_deud5 = ceil((30 * ($planetrow[$resource[3]]+5) *  pow((1.1),($planetrow[$resource[3]]+5)))*$mnoznik);
$pobor_deud6 = ceil((30 * ($planetrow[$resource[3]]+6) *  pow((1.1),($planetrow[$resource[3]]+6)))*$mnoznik);
$pobor_deud7 = ceil((30 * ($planetrow[$resource[3]]+7) *  pow((1.1),($planetrow[$resource[3]]+7)))*$mnoznik);
$pobor_deud8 = ceil((30 * ($planetrow[$resource[3]]+8) *  pow((1.1),($planetrow[$resource[3]]+8)))*$mnoznik);
$pobor_deud9 = ceil((30 * ($planetrow[$resource[3]]+9) *  pow((1.1),($planetrow[$resource[3]]+9)))*$mnoznik);
$pobor_deud10 = ceil((30 * ($planetrow[$resource[3]]+10) *  pow((1.1),($planetrow[$resource[3]]+10)))*$mnoznik);
$pobor_deud11 = ceil((30 * ($planetrow[$resource[3]]+11) *  pow((1.1),($planetrow[$resource[3]]+11)))*$mnoznik);
$pobor_deud12 = ceil((30 * ($planetrow[$resource[3]]+12) *  pow((1.1),($planetrow[$resource[3]]+12)))*$mnoznik);

$roznica_pobm1 = $pobor_deu - $pobor_deum1;
$roznica_pobm2 = $pobor_deu - $pobor_deum2;
$roznica_pobd1 = $pobor_deu - $pobor_deud1;
$roznica_pobd2 = $pobor_deu - $pobor_deud2;
$roznica_pobd3 = $pobor_deu - $pobor_deud3;
$roznica_pobd4 = $pobor_deu - $pobor_deud4;
$roznica_pobd5 = $pobor_deu - $pobor_deud5;
$roznica_pobd6 = $pobor_deu - $pobor_deud6;
$roznica_pobd7 = $pobor_deu - $pobor_deud7;
$roznica_pobd8 = $pobor_deu - $pobor_deud8;
$roznica_pobd9 = $pobor_deu - $pobor_deud9;
$roznica_pobd10 = $pobor_deu - $pobor_deud10;
$roznica_pobd11 = $pobor_deu - $pobor_deud11;
$roznica_pobd12 = $pobor_deu - $pobor_deud12;

$roznica_pobm1 = number_format($roznica_pobm1,0,'','.');
$roznica_pobm2 = number_format($roznica_pobm2,0,'','.');
$roznica_pobd1 = number_format($roznica_pobd1,0,'','.');
$roznica_pobd2 = number_format($roznica_pobd2,0,'','.');
$roznica_pobd3 = number_format($roznica_pobd3,0,'','.');
$roznica_pobd4 = number_format($roznica_pobd4,0,'','.');
$roznica_pobd5 = number_format($roznica_pobd5,0,'','.');
$roznica_pobd6 = number_format($roznica_pobd6,0,'','.');
$roznica_pobd7 = number_format($roznica_pobd7,0,'','.');
$roznica_pobd8 = number_format($roznica_pobd8,0,'','.');
$roznica_pobd9 = number_format($roznica_pobd9,0,'','.');
$roznica_pobd10 = number_format($roznica_pobd10,0,'','.'); 
$roznica_pobd11 = number_format($roznica_pobd11,0,'','.');
$roznica_pobd12 = number_format($roznica_pobd12,0,'','.');

$parse['pobor-2'] = "$pobor_deum2 <font color=$kolorplus>[$roznica_pobm2]</font> $trc";
$parse['pobor-1'] = "$pobor_deum1 <font color=$kolorplus>[$roznica_pobm1]</font> $trc";
$parse['pobor'] = "<font color=$kolorpoziom>$pobor_deu$trc";
$parse['pobor+1'] = "$pobor_deud1 <font color=$kolorminus>[$roznica_pobd1]</font> $trc";
$parse['pobor+2'] = "$pobor_deud2 <font color=$kolorminus>[$roznica_pobd2]</font> $trc";
$parse['pobor+3'] = "$pobor_deud3 <font color=$kolorminus>[$roznica_pobd3]</font> $trc";
$parse['pobor+4'] = "$pobor_deud4 <font color=$kolorminus>[$roznica_pobd4]</font> $trc";
$parse['pobor+5'] = "$pobor_deud5 <font color=$kolorminus>[$roznica_pobd5]</font> $trc";
$parse['pobor+6'] = "$pobor_deud6 <font color=$kolorminus>[$roznica_pobd6]</font> $trc";
$parse['pobor+7'] = "$pobor_deud7 <font color=$kolorminus>[$roznica_pobd7]</font> $trc";
$parse['pobor+8'] = "$pobor_deud8 <font color=$kolorminus>[$roznica_pobd8]</font> $trc";
$parse['pobor+9'] = "$pobor_deud9 <font color=$kolorminus>[$roznica_pobd9]</font> $trc";
$parse['pobor+10'] = "$pobor_deud10 <font color=$kolorminus>[$roznica_pobd10]</font> $trc";
$parse['pobor+11'] = "$pobor_deud11 <font color=$kolorminus>[$roznica_pobd11]</font> $trc";
$parse['pobor+12'] = "$pobor_deud12 <font color=$kolorminus>[$roznica_pobd12]</font> $trc";
//264 - deuterium 1 lvl
//176 - elektr 1 lvl
}
if ($gid == 4)
{
(20 * $planetrow[$resource[4]] * pow((1.1),$planetrow[$resource[4]]))* (0.1*$planetrow["{$resource[4]}_porcent"]);
$solar_ener = $planetrow[$resource[4]];
$solar_ener = $solar_ener;
$solar_enermm1 = $solar_ener-1;
$solar_enermm2 = $solar_ener-2;
$solar_enerdd1 = $solar_ener+1;
$solar_enerdd2 = $solar_ener+2;
$solar_enerdd3 = $solar_ener+3;
$solar_enerdd4 = $solar_ener+4;
$solar_enerdd5 = $solar_ener+5;
$solar_enerdd6 = $solar_ener+6;
$solar_enerdd7 = $solar_ener+7;
$solar_enerdd8 = $solar_ener+8;
$solar_enerdd9 = $solar_ener+9;
$solar_enerdd10 = $solar_ener+10;
$solar_enerdd11 = $solar_ener+11;
$solar_enerdd12 = $solar_ener+12;

$parse['kopalnia'] = "$tr<font color=$kolorminus>$solar_ener$thc";
$parse['kopalnia-1'] = "$tr$solar_enermm1$thc";
$parse['kopalnia-2'] = "$tr$solar_enermm2$thc";
$parse['kopalnia+1'] = "$tr$solar_enerdd1$thc";
$parse['kopalnia+2'] = "$tr$solar_enerdd2$thc";
$parse['kopalnia+3'] = "$tr$solar_enerdd3$thc";
$parse['kopalnia+4'] = "$tr$solar_enerdd4$thc";
$parse['kopalnia+5'] = "$tr$solar_enerdd5$thc";
$parse['kopalnia+6'] = "$tr$solar_enerdd6$thc";
$parse['kopalnia+7'] = "$tr$solar_enerdd7$thc";
$parse['kopalnia+8'] = "$tr$solar_enerdd8$thc";
$parse['kopalnia+9'] = "$tr$solar_enerdd9$thc";
$parse['kopalnia+10'] = "$tr$solar_enerdd10$thc";
$parse['kopalnia+11'] = "$tr$solar_enerdd11$thc";
$parse['kopalnia+12'] = "$tr$solar_enerdd12$thc";

$wyd_solar_ener = floor((20 * ($planetrow[$resource[4]]) *  pow((1.1),($planetrow[$resource[4]]))*$mnoznik));
$parse['wydobycie'] = $wyd_solar_ener;
$wyd_solar_enerm1 = floor((20 * ($planetrow[$resource[4]]-1) *  pow((1.1),($planetrow[$resource[4]]-1))*$mnoznik));
$wyd_solar_enerm2 = floor((20 * ($planetrow[$resource[4]]-2) *  pow((1.1),($planetrow[$resource[4]]-2))*$mnoznik));
$wyd_solar_ener1 = floor((20 * ($planetrow[$resource[4]]+1) *  pow((1.1),($planetrow[$resource[4]]+1))*$mnoznik));
$wyd_solar_ener2 = floor((20 * ($planetrow[$resource[4]]+2) *  pow((1.1),($planetrow[$resource[4]]+2))*$mnoznik));
$wyd_solar_ener3 = floor((20 * ($planetrow[$resource[4]]+3) *  pow((1.1),($planetrow[$resource[4]]+3))*$mnoznik));
$wyd_solar_ener4 = floor((20 * ($planetrow[$resource[4]]+4) *  pow((1.1),($planetrow[$resource[4]]+4))*$mnoznik));
$wyd_solar_ener5 = floor((20 * ($planetrow[$resource[4]]+5) *  pow((1.1),($planetrow[$resource[4]]+5))*$mnoznik));
$wyd_solar_ener6 = floor((20 * ($planetrow[$resource[4]]+6) *  pow((1.1),($planetrow[$resource[4]]+6))*$mnoznik));
$wyd_solar_ener7 = floor((20 * ($planetrow[$resource[4]]+7) *  pow((1.1),($planetrow[$resource[4]]+7))*$mnoznik));
$wyd_solar_ener8 = floor((20 * ($planetrow[$resource[4]]+8) *  pow((1.1),($planetrow[$resource[4]]+8))*$mnoznik));
$wyd_solar_ener9 = floor((20 * ($planetrow[$resource[4]]+9) *  pow((1.1),($planetrow[$resource[4]]+9))*$mnoznik));
$wyd_solar_ener10 = floor((20 * ($planetrow[$resource[4]]+10) *  pow((1.1),($planetrow[$resource[4]]+10))*$mnoznik));
$wyd_solar_ener11 = floor((20 * ($planetrow[$resource[4]]+11) *  pow((1.1),($planetrow[$resource[4]]+11))*$mnoznik));
$wyd_solar_ener12 = floor((20 * ($planetrow[$resource[4]]+12) *  pow((1.1),($planetrow[$resource[4]]+12))*$mnoznik));

$roznicam1 = $wyd_solar_enerm1 - $wyd_solar_ener;
$roznicam2 = $wyd_solar_enerm2 - $wyd_solar_ener;
$roznicad1 = $wyd_solar_ener1 - $wyd_solar_ener;
$roznicad2 = $wyd_solar_ener2 - $wyd_solar_ener;
$roznicad3 = $wyd_solar_ener3 - $wyd_solar_ener;
$roznicad4 = $wyd_solar_ener4 - $wyd_solar_ener;
$roznicad5 = $wyd_solar_ener5 - $wyd_solar_ener;
$roznicad6 = $wyd_solar_ener6 - $wyd_solar_ener;
$roznicad7 = $wyd_solar_ener7 - $wyd_solar_ener;
$roznicad8 = $wyd_solar_ener8 - $wyd_solar_ener;
$roznicad9 = $wyd_solar_ener9 - $wyd_solar_ener;
$roznicad10 = $wyd_solar_ener10 - $wyd_solar_ener;
$roznicad11 = $wyd_solar_ener11 - $wyd_solar_ener;
$roznicad12 = $wyd_solar_ener12 - $wyd_solar_ener;

$wyd_solar_enerm1 = number_format($wyd_solar_enerm1,0,'','.');
$wyd_solar_enerm2 = number_format($wyd_solar_enerm2,0,'','.');
$wyd_solar_ener1 = number_format($wyd_solar_ener1,0,'','.');
$wyd_solar_ener2 = number_format($wyd_solar_ener2,0,'','.');
$wyd_solar_ener3 = number_format($wyd_solar_ener3,0,'','.');
$wyd_solar_ener4 = number_format($wyd_solar_ener4,0,'','.');
$wyd_solar_ener5 = number_format($wyd_solar_ener5,0,'','.');
$wyd_solar_ener6 = number_format($wyd_solar_ener6,0,'','.');
$wyd_solar_ener7 = number_format($wyd_solar_ener7,0,'','.');
$wyd_solar_ener8 = number_format($wyd_solar_ener8,0,'','.');
$wyd_solar_ener9 = number_format($wyd_solar_ener9,0,'','.');
$wyd_solar_ener10 = number_format($wyd_solar_ener10,0,'','.'); 
$wyd_solar_ener11 = number_format($wyd_solar_ener11,0,'','.');
$wyd_solar_ener12 = number_format($wyd_solar_ener12,0,'','.');

$roznicam1 = number_format($roznicam1,0,'','.');
$roznicam2 = number_format($roznicam2,0,'','.');
$roznicad1 = number_format($roznicad1,0,'','.');
$roznicad2 = number_format($roznicad2,0,'','.');
$roznicad3 = number_format($roznicad3,0,'','.');
$roznicad4 = number_format($roznicad4,0,'','.');
$roznicad5 = number_format($roznicad5,0,'','.');
$roznicad6 = number_format($roznicad6,0,'','.');
$roznicad7 = number_format($roznicad7,0,'','.');
$roznicad8 = number_format($roznicad8,0,'','.');
$roznicad9 = number_format($roznicad9,0,'','.');
$roznicad10 = number_format($roznicad10,0,'','.'); 
$roznicad11 = number_format($roznicad11,0,'','.');
$roznicad12 = number_format($roznicad12,0,'','.');

$parse['wydobycie'] = "<font color=$kolorpoziom>$wyd_solar_ener </font>$trc";
$parse['wydobycie-1'] = "$wyd_solar_enerm1 <font color=$kolorminus>[$roznicam1]</font> $trc";
$parse['wydobycie-2'] = "$wyd_solar_enerm2 <font color=$kolorminus>[$roznicam2]</font> $trc";
$parse['wydobycie+1'] = "$wyd_solar_ener1 <font color=$kolorplus>[$roznicad1]</font> $trc";
$parse['wydobycie+2'] = "$wyd_solar_ener2 <font color=$kolorplus>[$roznicad2]</font> $trc";
$parse['wydobycie+3'] = "$wyd_solar_ener3 <font color=$kolorplus>[$roznicad3]</font> $trc";
$parse['wydobycie+4'] = "$wyd_solar_ener4 <font color=$kolorplus>[$roznicad4]</font> $trc";
$parse['wydobycie+5'] = "$wyd_solar_ener5 <font color=$kolorplus>[$roznicad5]</font> $trc";
$parse['wydobycie+6'] = "$wyd_solar_ener6 <font color=$kolorplus>[$roznicad6]</font> $trc";
$parse['wydobycie+7'] = "$wyd_solar_ener7 <font color=$kolorplus>[$roznicad7]</font> $trc";
$parse['wydobycie+8'] = "$wyd_solar_ener8 <font color=$kolorplus>[$roznicad8]</font> $trc";
$parse['wydobycie+9'] = "$wyd_solar_ener9 <font color=$kolorplus>[$roznicad9]</font> $trc";
$parse['wydobycie+10'] = "$wyd_solar_ener10 <font color=$kolorplus>[$roznicad10]</font> $trc";
$parse['wydobycie+11'] = "$wyd_solar_ener11 <font color=$kolorplus>[$roznicad11]</font> $trc";
$parse['wydobycie+12'] = "$wyd_solar_ener12 <font color=$kolorplus>[$roznicad12]</font> $trc";

//264 - deuterium 1 lvl
//176 - elektr 1 lvl
}

if ($gid == 12)
{
$kop_fusion = $planetrow[$resource[12]];
$kop_fusion = $kop_fusion;
$kop_fusionmm1 = $kop_fusion-1;
$kop_fusionmm2 = $kop_fusion-2;
$kop_fusiondd1 = $kop_fusion+1;
$kop_fusiondd2 = $kop_fusion+2;
$kop_fusiondd3 = $kop_fusion+3;
$kop_fusiondd4 = $kop_fusion+4;
$kop_fusiondd5 = $kop_fusion+5;
$kop_fusiondd6 = $kop_fusion+6;
$kop_fusiondd7 = $kop_fusion+7;
$kop_fusiondd8 = $kop_fusion+8;
$kop_fusiondd9 = $kop_fusion+9;
$kop_fusiondd10 = $kop_fusion+10;
$kop_fusiondd11 = $kop_fusion+11;
$kop_fusiondd12 = $kop_fusion+12;

$parse['kopalnia'] = "$tr<font color=$kolorminus>$kop_fusion$thc";
$parse['kopalnia-1'] = "$tr$kop_fusionmm1$thc";
$parse['kopalnia-2'] = "$tr$kop_fusionmm2$thc";
$parse['kopalnia+1'] = "$tr$kop_fusiondd1$thc";
$parse['kopalnia+2'] = "$tr$kop_fusiondd2$thc";
$parse['kopalnia+3'] = "$tr$kop_fusiondd3$thc";
$parse['kopalnia+4'] = "$tr$kop_fusiondd4$thc";
$parse['kopalnia+5'] = "$tr$kop_fusiondd5$thc";
$parse['kopalnia+6'] = "$tr$kop_fusiondd6$thc";
$parse['kopalnia+7'] = "$tr$kop_fusiondd7$thc";
$parse['kopalnia+8'] = "$tr$kop_fusiondd8$thc";
$parse['kopalnia+9'] = "$tr$kop_fusiondd9$thc";
$parse['kopalnia+10'] = "$tr$kop_fusiondd10$thc";
$parse['kopalnia+11'] = "$tr$kop_fusiondd11$thc";
$parse['kopalnia+12'] = "$tr$kop_fusiondd12$thc";
//(50 * $planetrow[$resource[12]]*(1.1^$planetrow[$resource[12]]))*(-0.002*$planetrow["max_temp"]+1.28))* (0.1*$planetrow["{$resource[12]}_porcent"]);
$wyd_fusion = floor((50 * ($planetrow[$resource[12]]) *  pow((1.1),($planetrow[$resource[12]])))*$mnoznik);
$wyd_fusionm1 = floor((50 * ($planetrow[$resource[12]]-1) * pow((1.1),($planetrow[$resource[12]]-1)))*$mnoznik);
$wyd_fusionm2 = floor((50 * ($planetrow[$resource[12]]-2) * pow((1.1),($planetrow[$resource[12]]-2)))*$mnoznik);
$wyd_fusion1 = floor((50 * ($planetrow[$resource[12]]+1) * pow((1.1),($planetrow[$resource[12]]+1)))*$mnoznik);
$wyd_fusion2 = floor((50 * ($planetrow[$resource[12]]+2) * pow((1.1),($planetrow[$resource[12]]+2)))*$mnoznik);
$wyd_fusion3 = floor((50 * ($planetrow[$resource[12]]+3) * pow((1.1),($planetrow[$resource[12]]+3)))*$mnoznik);
$wyd_fusion4 = floor((50 * ($planetrow[$resource[12]]+4) * pow((1.1),($planetrow[$resource[12]]+4)))*$mnoznik);
$wyd_fusion5 = floor((50 * ($planetrow[$resource[12]]+5) * pow((1.1),($planetrow[$resource[12]]+5)))*$mnoznik);
$wyd_fusion6 = floor((50 * ($planetrow[$resource[12]]+6) * pow((1.1),($planetrow[$resource[12]]+6)))*$mnoznik);
$wyd_fusion7 = floor((50 * ($planetrow[$resource[12]]+7) * pow((1.1),($planetrow[$resource[12]]+7)))*$mnoznik);
$wyd_fusion8 = floor((50 * ($planetrow[$resource[12]]+8) * pow((1.1),($planetrow[$resource[12]]+8)))*$mnoznik);
$wyd_fusion9 = floor((50 * ($planetrow[$resource[12]]+9) * pow((1.1),($planetrow[$resource[12]]+9)))*$mnoznik);
$wyd_fusion10 = floor((50 * ($planetrow[$resource[12]]+10) * pow((1.1),($planetrow[$resource[12]]+10)))*$mnoznik);
$wyd_fusion11 = floor((50 * ($planetrow[$resource[12]]+11) * pow((1.1),($planetrow[$resource[12]]+11)))*$mnoznik);
$wyd_fusion12 = floor((50 * ($planetrow[$resource[12]]+12) * pow((1.1),($planetrow[$resource[12]]+12)))*$mnoznik);

$roznicam1 = $wyd_fusionm1 - $wyd_fusion;
$roznicam2 = $wyd_fusionm2 - $wyd_fusion;
$roznicad1 = $wyd_fusion1 - $wyd_fusion;
$roznicad2 = $wyd_fusion2 - $wyd_fusion;
$roznicad3 = $wyd_fusion3 - $wyd_fusion;
$roznicad4 = $wyd_fusion4 - $wyd_fusion;
$roznicad5 = $wyd_fusion5 - $wyd_fusion;
$roznicad6 = $wyd_fusion6 - $wyd_fusion;
$roznicad7 = $wyd_fusion7 - $wyd_fusion;
$roznicad8 = $wyd_fusion8 - $wyd_fusion;
$roznicad9 = $wyd_fusion9 - $wyd_fusion;
$roznicad10 = $wyd_fusion10 - $wyd_fusion;
$roznicad11 = $wyd_fusion11 - $wyd_fusion;
$roznicad12 = $wyd_fusion12 - $wyd_fusion;

$parse['wydobycie'] = $wyd_fusion;
$wyd_fusionm1 = number_format($wyd_fusionm1,0,'','.');
$wyd_fusionm2 = number_format($wyd_fusionm2,0,'','.');
$wyd_fusion = number_format($wyd_fusion,0,'','.');
$wyd_fusion1 = number_format($wyd_fusion1,0,'','.');
$wyd_fusion2 = number_format($wyd_fusion2,0,'','.');
$wyd_fusion3 = number_format($wyd_fusion3,0,'','.');
$wyd_fusion4 = number_format($wyd_fusion4,0,'','.');
$wyd_fusion5 = number_format($wyd_fusion5,0,'','.');
$wyd_fusion6 = number_format($wyd_fusion6,0,'','.');
$wyd_fusion7 = number_format($wyd_fusion7,0,'','.');
$wyd_fusion8 = number_format($wyd_fusion8,0,'','.');
$wyd_fusion9 = number_format($wyd_fusion9,0,'','.');
$wyd_fusion10 = number_format($wyd_fusion10,0,'','.'); 
$wyd_fusion11 = number_format($wyd_fusion11,0,'','.');
$wyd_fusion12 = number_format($wyd_fusion12,0,'','.');



$parse['wydobycie'] = "<font color=$kolorpoziom>$wyd_fusion </font>$thc";
$parse['wydobycie-1'] = "$wyd_fusionm1 <font color=$kolorminus>[$roznicam1]</font> $thc";
$parse['wydobycie-2'] = "$wyd_fusionm2 <font color=$kolorminus>[$roznicam2]</font> $thc";
$parse['wydobycie+1'] = "$wyd_fusion1 <font color=$kolorplus>[$roznicad1]</font> $thc";
$parse['wydobycie+2'] = "$wyd_fusion2 <font color=$kolorplus>[$roznicad2]</font> $thc";
$parse['wydobycie+3'] = "$wyd_fusion3 <font color=$kolorplus>[$roznicad3]</font> $thc";
$parse['wydobycie+4'] = "$wyd_fusion4 <font color=$kolorplus>[$roznicad4]</font> $thc";
$parse['wydobycie+5'] = "$wyd_fusion5 <font color=$kolorplus>[$roznicad5]</font> $thc";
$parse['wydobycie+6'] = "$wyd_fusion6 <font color=$kolorplus>[$roznicad6]</font> $thc";
$parse['wydobycie+7'] = "$wyd_fusion7 <font color=$kolorplus>[$roznicad7]</font> $thc";
$parse['wydobycie+8'] = "$wyd_fusion8 <font color=$kolorplus>[$roznicad8]</font> $thc";
$parse['wydobycie+9'] = "$wyd_fusion9 <font color=$kolorplus>[$roznicad9]</font> $thc";
$parse['wydobycie+10'] = "$wyd_fusion10 <font color=$kolorplus>[$roznicad10]</font> $thc";
$parse['wydobycie+11'] = "$wyd_fusion11 <font color=$kolorplus>[$roznicad11]</font> $thc";
$parse['wydobycie+12'] = "$wyd_fusion12 <font color=$kolorplus>[$roznicad12]</font> $thc";

$pobor_deum1 = ceil((10 * ($planetrow[$resource[12]]-1) *  pow((1.1),($planetrow[$resource[12]]-1)))*$mnoznik);
$pobor_deum2 = ceil((10 * ($planetrow[$resource[12]]-2) *  pow((1.1),($planetrow[$resource[12]]-2)))*$mnoznik);
$pobor_deu = ceil((10 * $planetrow[$resource[12]] *  pow((1.1),$planetrow[$resource[12]]))*$mnoznik);
$pobor_deud1 = ceil((10 * ($planetrow[$resource[12]]+1) *  pow((1.1),($planetrow[$resource[12]]+1)))*$mnoznik);
$pobor_deud2 = ceil((10 * ($planetrow[$resource[12]]+2) *  pow((1.1),($planetrow[$resource[12]]+2)))*$mnoznik);
$pobor_deud3 = ceil((10 * ($planetrow[$resource[12]]+3) *  pow((1.1),($planetrow[$resource[12]]+3)))*$mnoznik);
$pobor_deud4 = ceil((10 * ($planetrow[$resource[12]]+4) *  pow((1.1),($planetrow[$resource[12]]+4)))*$mnoznik);
$pobor_deud5 = ceil((10 * ($planetrow[$resource[12]]+5) *  pow((1.1),($planetrow[$resource[12]]+5)))*$mnoznik);
$pobor_deud6 = ceil((10 * ($planetrow[$resource[12]]+6) *  pow((1.1),($planetrow[$resource[12]]+6)))*$mnoznik);
$pobor_deud7 = ceil((10 * ($planetrow[$resource[12]]+7) *  pow((1.1),($planetrow[$resource[12]]+7)))*$mnoznik);
$pobor_deud8 = ceil((10 * ($planetrow[$resource[12]]+8) *  pow((1.1),($planetrow[$resource[12]]+8)))*$mnoznik);
$pobor_deud9 = ceil((10 * ($planetrow[$resource[12]]+9) *  pow((1.1),($planetrow[$resource[12]]+9)))*$mnoznik);
$pobor_deud10 = ceil((10 * ($planetrow[$resource[12]]+10) *  pow((1.1),($planetrow[$resource[12]]+10)))*$mnoznik);
$pobor_deud11 = ceil((10 * ($planetrow[$resource[12]]+11) *  pow((1.1),($planetrow[$resource[12]]+11)))*$mnoznik);
$pobor_deud12 = ceil((10 * ($planetrow[$resource[12]]+12) *  pow((1.1),($planetrow[$resource[12]]+12)))*$mnoznik);

$pobor_deum1 = number_format($pobor_deum1,0,'','.');
$pobor_deum2 = number_format($pobor_deum2,0,'','.');
$pobor_deud1 = number_format($pobor_deud1,0,'','.');
$pobor_deud2 = number_format($pobor_deud2,0,'','.');
$pobor_deud3 = number_format($pobor_deud3,0,'','.');
$pobor_deud4 = number_format($pobor_deud4,0,'','.');
$pobor_deud5 = number_format($pobor_deud5,0,'','.');
$pobor_deud6 = number_format($pobor_deud6,0,'','.');
$pobor_deud7 = number_format($pobor_deud7,0,'','.');
$pobor_deud8 = number_format($pobor_deud8,0,'','.');
$pobor_deud9 = number_format($pobor_deud9,0,'','.');
$pobor_deud10 = number_format($pobor_deud10,0,'','.'); 
$pobor_deud11 = number_format($pobor_deud11,0,'','.');
$pobor_deud12 = number_format($pobor_deud12,0,'','.');


$roznica_pobm1 = $pobor_deu - $pobor_deum1;
$roznica_pobm2 = $pobor_deu - $pobor_deum2;
$roznica_pobd1 = $pobor_deu - $pobor_deud1;
$roznica_pobd2 = $pobor_deu - $pobor_deud2;
$roznica_pobd3 = $pobor_deu - $pobor_deud3;
$roznica_pobd4 = $pobor_deu - $pobor_deud4;
$roznica_pobd5 = $pobor_deu - $pobor_deud5;
$roznica_pobd6 = $pobor_deu - $pobor_deud6;
$roznica_pobd7 = $pobor_deu - $pobor_deud7;
$roznica_pobd8 = $pobor_deu - $pobor_deud8;
$roznica_pobd9 = $pobor_deu - $pobor_deud9;
$roznica_pobd10 = $pobor_deu - $pobor_deud10;
$roznica_pobd11 = $pobor_deu - $pobor_deud11;
$roznica_pobd12 = $pobor_deu - $pobor_deud12;

$roznica_pobm1 = number_format($roznica_pobm1,0,'','.');
$roznica_pobm2 = number_format($roznica_pobm2,0,'','.');
$roznica_pobd1 = number_format($roznica_pobd1,0,'','.');
$roznica_pobd2 = number_format($roznica_pobd2,0,'','.');
$roznica_pobd3 = number_format($roznica_pobd3,0,'','.');
$roznica_pobd4 = number_format($roznica_pobd4,0,'','.');
$roznica_pobd5 = number_format($roznica_pobd5,0,'','.');
$roznica_pobd6 = number_format($roznica_pobd6,0,'','.');
$roznica_pobd7 = number_format($roznica_pobd7,0,'','.');
$roznica_pobd8 = number_format($roznica_pobd8,0,'','.');
$roznica_pobd9 = number_format($roznica_pobd9,0,'','.');
$roznica_pobd10 = number_format($roznica_pobd10,0,'','.'); 
$roznica_pobd11 = number_format($roznica_pobd11,0,'','.');
$roznica_pobd12 = number_format($roznica_pobd12,0,'','.');

$parse['pobor-2'] = "$pobor_deum2 <font color=$kolorplus>[$roznica_pobm2]</font> $trc";
$parse['pobor-1'] = "$pobor_deum1 <font color=$kolorplus>[$roznica_pobm1]</font> $trc";
$parse['pobor'] = "<font color=$kolorpoziom>$pobor_deu$trc";
$parse['pobor+1'] = "$pobor_deud1 <font color=$kolorminus>[$roznica_pobd1]</font> $trc";
$parse['pobor+2'] = "$pobor_deud2 <font color=$kolorminus>[$roznica_pobd2]</font> $trc";
$parse['pobor+3'] = "$pobor_deud3 <font color=$kolorminus>[$roznica_pobd3]</font> $trc";
$parse['pobor+4'] = "$pobor_deud4 <font color=$kolorminus>[$roznica_pobd4]</font> $trc";
$parse['pobor+5'] = "$pobor_deud5 <font color=$kolorminus>[$roznica_pobd5]</font> $trc";
$parse['pobor+6'] = "$pobor_deud6 <font color=$kolorminus>[$roznica_pobd6]</font> $trc";
$parse['pobor+7'] = "$pobor_deud7 <font color=$kolorminus>[$roznica_pobd7]</font> $trc";
$parse['pobor+8'] = "$pobor_deud8 <font color=$kolorminus>[$roznica_pobd8]</font> $trc";
$parse['pobor+9'] = "$pobor_deud9 <font color=$kolorminus>[$roznica_pobd9]</font> $trc";
$parse['pobor+10'] = "$pobor_deud10 <font color=$kolorminus>[$roznica_pobd10]</font> $trc";
$parse['pobor+11'] = "$pobor_deud11 <font color=$kolorminus>[$roznica_pobd11]</font> $trc";
$parse['pobor+12'] = "$pobor_deud12 <font color=$kolorminus>[$roznica_pobd12]</font> $trc";
//264 - fusion 1 lvl
//176 - elektr 1 lvl
}


$page = parsetemplate(gettemplate('infos_body'), $parse);


display($page,$lang['Information']);

// Created by Perberos. All rights reversed (C) 2006
?>
