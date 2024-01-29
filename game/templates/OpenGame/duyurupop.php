<?
@include "../../administrator/baglan.php";

$sql=mysql_query("select id, DATE_FORMAT(tarih, '%d/%m/%Y %H:%i:%s') zaman, aciklama from duyuru where id = '".$_GET['ID']."' limit 1");
$fa=mysql_fetch_array($sql);

?>
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9">
<title>G&uuml;ncel Duyuru</title>
<link href="styles.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
body {
	background-color: #EFEFEF;
}
-->
</style>
<meta name="generator" content="Namo WebEditor v6.0">
</head>
<?
if ($fa[id]=="") {
  echo "<body onload=\"javascript: self.close();\">";
}
?>
<body topmargin="0" leftmargin="0">

<table border="0" cellpadding="0" cellspacing="3" style="border-collapse: collapse" bordercolor="#111111" width="100%">
  <tr>
    <td width="100%" bgcolor="#999999">&nbsp;<img src="images/arka/info.gif">&nbsp;<font color="white"><b><?=$fa[zaman]?></b></font></td>
  </tr>
  <tr>
        <td width="100%" bgcolor="#EFEFEF">
            <p align="center">&nbsp;</p>
            <p align="center">&nbsp;<?=nl2br($fa[aciklama])?></p>
            <p align="center"></font></p>
        </td>
  </tr>
  <tr>
        <td width="100%" bgcolor="#999999">
            <p align="center"><a href="javascript: self.close();">
    <font face="Tahoma" color="white">[Pencereyi Kapat]</font></a>
    </td>
  </tr>
</table>

</body>

</html>