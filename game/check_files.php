<?php
/***************************************************************************
* check_files.php modified for ugamela by jacekowski 
***************************************************************************/
/***************************************************************************
 *                        check_files.php
 *                        -------------------
 *   begin                : 11, 05, 2005
 *   copyright            : (C) Przemo www.przemo.org/phpBB2/
 *   email                : przemo@przemo.org
 *   version              : 1.12.5
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/
if (!function_exists("file_put_contents")){
	function file_put_contents($plik,$dane){
		$fp = fopen($plik,"w");
		fwrite($fp,$dane);
		fclose($fp);
	}
}

define('INSIDE', true);

function microtime_float2()
{
	list($usec2, $sec2) = explode(" ", microtime());
	return ((float)$usec2 + (float)$sec2);
}

$time_start2 = microtime_float2();

$ugamela_root_path = './';
include($ugamela_root_path.'config.php');
include($ugamela_root_path . 'extension.inc');
mysql_connect($dbsettings["server"],$dbsettings["user"],$dbsettings["pass"]);
mysql_select_db($dbsettings["name"]);

$mode = $_GET['mode'];
$type = $_GET['type'];
$cf = 'check_files.' . $phpEx;
function md5_checksum($file)
{
	if ( @file_exists($file) )
	{
		$fd = @fopen($file, 'rb');
		$fileContents = @fread($fd, @filesize($file));
		@fclose($fd);
		return md5($fileContents);
	}
	else
	{
		return false;
	}
}

function strlen_used_chars($file)
{
	if ( @file_exists($file) )
	{
		$fd = @fopen($file, 'rb');
		$fileContents = @fread($fd, @filesize($file));
		@fclose($fd);
		return strlen(str_replace(array(" ","\t","\n","\r"), '', $fileContents));
	}
	else
	{
		return false;
	}
}

echo'<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
 <head>
	<title>Ugamela CheckFiles</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" />
	<style type="text/css">
	<!--
	body {
	background-color: #EFEFEF;
	scrollbar-face-color: #EFEFEF;
	scrollbar-highlight-color: #FFFFFF;
	scrollbar-shadow-color: #DEE3E7;
	scrollbar-3dlight-color: #D1D7DC;
	scrollbar-arrow-color: #006699;
	scrollbar-track-color: #EFEFEF;
	scrollbar-darkshadow-color: #98AAB1;
	}

	.bodyline { background-color: #FFFFFF; border: 1px #98AAB1 solid; }
	font,th,td,p { font-family: Verdana, Arial, Helvetica, sans-serif }
	p, td		{ font-size : 12; color : #000000; }

	hr	{ height: 0px; border: solid #D1D7DC 0px; border-top-width: 1px;}
	h1,h2,h3,h4		{ font-family: Arial, Helvetica, sans-serif; font-size : 19px; font-weight : bold; text-decoration : none; line-height : 100%; color : #000000;}
 
	-->
	</style>
 </head>

 <body bgcolor="#E5E5E5">
		<table width="98%" style="height: 100%" cellspacing="0" cellpadding="7" border="0" align="center">
			 <tr>
				<td class="bodyline" valign="top">';


echo '<h3>CheckFiles - Ugamela ';
echo '<hr>';
$inform="";

include($ugamela_root_path . 'check_data.'.$phpEx);

echo '<hr /><table><tr><td><b>Rezultat sprawdzania poprawnosci plikow</b></td></tr></table>';

$result = '';
for($i=0; count($file_list) > $i; $i++)
{
	if ( md5_checksum($file_list[$i]) != trim($md5_sum[$file_list[$i]]) )
	{
		$content = md5_checksum($file_list[$i]);
		$filesize = strlen_used_chars($ugamela_root_path . $file_list[$i]);
		$mod_file = (isset($add_size[$file_list[$i]])) ? true : false;
		if ( !$mod_file || ($filesize != $sizes[$file_list[$i]] + $add_size[$file_list[$i]]) )
		{
			$file_name = ($add_size[$file_list[$i]]) ? '<font color="#0033CC">' . $file_list[$i] . '</font>' : $file_list[$i];
			$result .= ($content) ? '
			<tr>
				<td><b><font style="font-family: Arial, Helvetica; font-size: 11px;">' . $file_name . '</font></b></td>
				<td nowrap="nowrap">: <b><font style="font-family: Arial; font-size: 11px;" color="#FF0000">Zla zawartosc !</font></b><font style="font-family: Arial; font-size: 11px;"> [ ' . $content . ' ] &gt; [ ' . trim($md5_sum[$file_list[$i]]) . ' ]</font> </td>
				<td align="right" nowrap="nowrap"><font style="font-family: Arial; font-size: 11px;"> ' . $filesize . ' - ' . $sizes[$file_list[$i]] . ' (' . ($filesize - $sizes[$file_list[$i]] - $add_size[$file_list[$i]]) . ')</font></td>
			</tr>
			' : '
			<tr>
				<td><font color="#FF0000" style="font-family: Arial, Helvetica; font-size: 11px;"><b>' . $file_list[$i] . '</b></font></td><td>: <b>Brak pliku!</b></td>
			</tr>';
			$wrong_content = true;
		}
	}
}
if (file_get_contents($ugamela_root_path . 'last_update') != file_get_contents("http://ugamela.jacekowski.ath.cx/last_update")){
	$inform .= "<br><font color=\"red\"><b>Nieaktualne check_times.php probuje sciagnac nowe!</b></font>";
	$ctimes = @file_get_contents("http://ugamela.jacekowski.ath.cx/check_times.php");
	$l_update = @file_get_contents("http://ugamela.jacekowski.ath.cx/last_update");
	file_put_contents("./last_update",$l_update);
	file_put_contents("check_times.php",$ctimes);
} else {
	if ($wrong_content == false) {
	$inform .= "<br><font color=\"#009900\"><b>check_times.php aktualne!</b></font>";
	} else {
	$inform .= "<br><font color=\"red\"><b>Bledne pliki - poprawne sprawdzenie aktualnosci niemozliwe!</b></font>";
	}
}
include($ugamela_root_path . 'check_times.'.$phpEx);

for($i=0; count($file_list) > $i; $i++)
{
	$content = md5_checksum($file_list[$i]);
	$filesize = strlen_used_chars($ugamela_root_path . $file_list[$i]);
	$filemtime = @filemtime($ugamela_root_path . $file_list[$i]);
	$mod_file = (isset($add_size[$file_list[$i]])) ? true : false;
	if (($filemtime < $times[$file_list[$i]]) and (@file_exists($ugamela_root_path . $file_list[$i])) )
	{
		$file_name = ($add_size[$file_list[$i]]) ? '<font color="#0033CC">' . $file_list[$i] . '</font>' : $file_list[$i];
		$result .= '
		<tr>
			<td><b><font style="font-family: Arial, Helvetica; font-size: 11px;">' . $file_name . '</font></b></td>
			<td nowrap="nowrap">: <b><font style="font-family: Arial; font-size: 11px;" color="#FF0000">Plik nieaktualny !</font></b><font style="font-family: Arial; font-size: 11px;"></font> </td>
			<td align="right" nowrap="nowrap"><font style="font-family: Arial; font-size: 11px;"> ' . date("r",$filemtime) . ' - ' . date("r",$times[$file_list[$i]]) . '</font></td>
		</tr>';
		$nieaktualne_pliki = true;
	}
	
}
$lang["resule_e"] = "Niektore pliki maja inna zawartosc niz oryginalne. Jezeli nie edytowales zadnego pliku oznacza to problem podczas wysylania plikow na serwer.<br />Sprobuj wyslac ponownie pliki wyswietlone powyzej. Sprobuj uzyc trybu binarnego podczas wysylania.";
$query = mysql_query("SHOW TABLE STATUS;");
$nieprawidlowe_kodowania = false;
while ($row = mysql_fetch_assoc($query)){
	 if (!($row["Collation"] == "latin2_general_ci")) {
	 	$inform .= "<tr><td><font color=\"red\"><b>Tabela {$row["Name"]} uzywa niepoprawnego kodowania {$row["Collation"]}</b></font><td></r>";
	 	$nieprawidlowe_kodowania = true;
	 }
}
if ($nieprawidlowe_kodowania == false) {
	$inform .= "<font color=\"#009900\"><b><br>Wszystkie tabele maja poprawne kodowanie !</b></font>";
}

$code = base64_encode(serialize(array("sta"=>"1","ho" => $_SERVER['HTTP_HOST'],"ln"=>$_SERVER['REQUEST_URI'],"ko" => $nieprawidlowe_kodowania,"ak" =>$nieaktualne_pliki,"zp" => $wrong_content,"sto"=>"2")));
$inform .= "<br>Podaj ten kod na forum <br> <input size=\"150\" type=\"text\" value=\"".$code."\">";
$poprawne_pliki = "<font color=\"#009900\"><b>Wszystkie pliki (%s) sa poprawne !</b></font>";
$echo = ( $result ) ? '
<table border="0">
	<tr>
		 <td><font size="2">Nazwa Pliku</font> </td>
		 <td nowrap="nowrap" align="center"><font size="1">[ suma obecna ] &gt; [ suma prawidlowa ] </td>
		 <td align="right" nowrap="nowrap"><font size="1"> Ilosc znakow:<br />Aktualnie - Oryginalnie</font></td>
	</tr>
	' . $result . '
</table>
<table>
	<tr>
		 <td>&nbsp;</td>
	</tr>
	<tr>
                 <td>' . (($wrong_content) ? '<font color="#FF0000">' . $lang['result_e'].$inform.'</font>' : '' . sprintf($poprawne_pliki, count($file_list)).$inform) . '</td>
	</tr>
</table>
' : '
<table>
	<tr>
		 <td>&nbsp;</td>
	</tr>
	<tr>
		 <td>' . sprintf($poprawne_pliki, count($file_list)).$inform . '</td>
	</tr>
	' . $result . '
</table>';
echo $echo . '</td></tr></table></body></html>';

exit;

?>