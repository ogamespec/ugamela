<?

include("common.php");
include("cookies.php");


function infos(){




}

{//init
	$userrow = checkcookies(); // Login (or verify) if not logged in.
	CheckUserExist($userrow);
}
$planetrow = doquery("SELECT * FROM {{table}} WHERE id = '".$userrow["current_planet"]."'","planets",true);

?>
<html>
<? echo_head("Flota"); ?>
<script language=JavaScript> //if (parent.frames.length == 0) { top.location.href = "http://es.ogame.org/"; } </script> <script language="JavaScript">
function haha(z1) {
  eval("location='"+z1.options[z1.selectedIndex].value+"'");
}

</script>
  <script language="JavaScript" src="js/flotten.js"></script>
  <script language="JavaScript" src="js/ocnt.js"></script>
 <body onload="javascript: shortInfo();">
<center>
<? echo_topnav(); ?>
  </center>
<br />
  <script language="JavaScript">
  <!--
     function link_to_gamepay() {
    self.location = "https://www.gamepay.de/?lang=es&serverID=10&userID=122720&gameID=ogame&gui=v2&chksum=2eff45c27ded6d1828c2bf5cfad2f852";
  }
//-->
  </script>
  <center>
  <table width="519" border="0" cellpadding="0" cellspacing="1">
   <tr height="20">
    <td class="c" colspan="2">

      <span class="success">Filo Gönderildi:</span>
    </td>
   </tr>
   <tr height="20">
  <th>Gorev</th>
      <th>Ac</th>
   </tr>

   <tr height="20">
     <th>Uzaklik</th>
      <th>1010</th>
   </tr>
   <tr height="20">
  <th>Hiz</th>
      <th>28750</th>

   </tr>
   <tr height="20">
  <th>Yuk</th>
      <th>10</th>
   </tr>
   <tr height="20">
  <th>Baslangic</th>

    <th>[7:327:7]</th>
   </tr>
   <tr height="20">
  <th>Amac</th>
     <th>[7:327:5]</th>
   </tr>
   <tr height="20">

  <th>Varis Zamani</th>
     <th>Thu Jun 29 5:21:20</th>
   </tr>
   <tr height="20">
  <th>Geri Donus</th>
    <th>Thu Jun 29 5:56:04</th>
   </tr>

   <tr height="20">
  <td class="c" colspan="2">Gemiler</td>
   </tr>
      <tr height="20">
     <th width="50%">Agirlik</th><th>4</th>
   </tr>
     
   </table>

 </body>
</html>
   
<?

// Created by Perberos. All rights reversed (C) 2006
?>