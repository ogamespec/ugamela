<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon"><title>SERVERNAME HERE</title>

<link rel="stylesheet" type="text/css" href="css/styles.css">
<link rel="stylesheet" type="text/css" href="css/about.css">
<script src="../scripts/functions.js" type="text/javascript"></script>
<script language="JavaScript" src="../scripts/tw-sack.js"></script>
<script language="JavaScript" src="../scripts/registration.js"></script>
</head><body>
<a href="#pustekuchen" style="display: none;">Loginlink</a>

<div id="main">
    
<div id="login">
     <a name="pustekuchen"></a>
     <div id="login_text_1">
        <div style="position: absolute; left: 12px; width: 110px;">Username</div>
        <div style="position: absolute; left: 195px; width: 50px;">Password</div>
	     </div>
     <div id="login_input">
     <table border="0" cellpadding="0" cellspacing="0"><tbody><tr style="vertical-align: top;"><td style="padding-right: 4px;">
	<form name="formular" action="login.php" method="post">
    <input type="hidden" name="v" value="2">
      <script type="text/javascript"> document.formular.Uni.focus(); </script>
	<input name="username" style="width: 180px" type="text" value="" class="eingabe" />
	<input name="password" style="width: 180px" type="password" value="" class="eingabe" /> 
  	<input name="submit" style="width: 62px" type="submit" value="Login" />
	         
     </td></tr></tbody></table>
     </div>
     <div id="downmenu">

	
     </div>    
</div>



<div id="mainmenu">
    <div class="menupoint">:: Menu ::</div>
    <a href="reg.php">Register!</a>
    <a href="about.php">About GameO</a>
    <a href="pics.php">Screenshots</a>
    <a href="story.php">Ogame Story</a>
</div>

<div id="rightmenu" class="rightmenu">
    <div id="title">SERVERNAME HERE</div>
    <div id="content">
        <div id="text1"><strong>OGame is a strategic space simulation game with thousands of players across the world competing with each other simultaneously. All you need to play is a standard web browser.</div>
        <div id="register" class="bigbutton" onclick="document.location.href='./reg.php';">Register now!</div>
        <div id="text2"><!--istatistikler!-->
          <div class="eingabe" align="center"><b>Players online: <font color="red">{online_users}</font> - Newest User: <font color="red">{last_user}</font> - Accounts created: <font color="red">{users_amount}</font></b><!-- - <a href="./reg.php"><font color=lime>Uyelik</font></a>--></div></div>
</div>
</div></body></html>