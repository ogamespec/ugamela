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
    



<div id="mainmenu">
    <a href="login.php">:: Menu ::</a>
    <div class="menupoint">Register!</div>
    <a href="about.php">About GameO</a>
    <a href="pics.php">Screenshots</a>
    <a href="story.php">Ogame Story</a>
</div>

    <div id="rightmenu" class="rightmenu_register">
        <div id="title">Registration</div>
        <div id="content"  align="justify">
            <div id="text1">In order to play you only have to enter a <strong>username</strong>, a <strong>password</strong> and an <strong>E-Mail address</strong> and <strong>proceed to read the terms and conditions</strong> before activating the check box about your agreement to them.</div>

            
            <div id="register_container">
                <form name="registerForm"  method="POST" action="" onsubmit="changeAction('register');" >
                  <table><tr><td class="table_input"><div id="uni_infos_link">
                    <table width="310">
                      <tr>
                        <td width="89" class="table_lable">{GameName}</td>
                        <td width="123" class="table_input"><input name=character  type=text class="eingabe" onfocus="javascript:showInfo('201');javascript:pollUsername();" onblur="javascript:stopPollingUsername();" size=20 maxlength="12" /></td>
                      </tr>
                      <tr>
                        <td class="table_lable">{E-Mail}</td>
                        <td class="table_input"><input class="eingabe"  type=text name=email size=20 onfocus="javascript:showInfo('202')" /></td>
                      </tr>
                      <tr>
                        <td class="table_lable">Password</td>
                        <td class="table_input"><input class="eingabe" type="password" name=haslo size=20 onfocus="showInfo('205');" id="haslo" /></td>
                      </tr>
                      <tr>
                        <td id="uni_label">{MainPlanet}</td>
                        <td class="table_input"><input name="hplanet" type="text" class="eingabe" id="hplanet" onfocus="showInfo('205');" size="20" maxlength="12" /></td>
                      </tr>
                          <tr>
                            <td width="127">{Sex}</td>
                            <td width="171">
                              
                              <div align="justify">
                                  <select name="select" id="select">
                                    <option>Indefinide</option>
                                    <option value="M">Male</option>
                                    <option value="F">Female</option>
                                  </select>
                              </div></td>
                          </tr>
                          <tr>
                            <td>{accept}</td>
                            <td>
                              
                              <div align="justify">
                                <input type="checkbox" name="agb" onfocus="javascript:showInfo('204');" id="agb" />
                              </div></td>
                          </tr>
                                         <input type="hidden" name="v" value="2" />

                          <tr>
                            <td>&nbsp;</td>
                            <td>
                              
                              <div align="justify">
                                <input type="submit" value="{signup}" />
                              </div></td>
                          </tr>
                        </table>
                        <p>&nbsp;</p></td></tr>
                </table>
            
                  </form>
            </div>
            <div id="infotext"></div>
            <div id="statustext"></div>

<td colspan="2"><center>
  </div>
    </div></div>
</body></html>