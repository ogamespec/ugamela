
<script language="JavaScript">
    function galaxy_submit(value) {
      document.getElementById('auto').name = value;
      document.getElementById('galaxy_form').submit();
    }

    function fenster(target_url,win_name) {
      var new_win = window.open(target_url,win_name,'resizable=yes,scrollbars=yes,menubar=no,toolbar=no,width=640,height=480,top=0,left=0');
new_win.focus();
    }
  </script>
<script language="JavaScript" src="scripts/tw-sack.js"></script>
<script type="text/javascript">
var ajax = new sack();
var strInfo = "";
      
function whenLoading(){
  //var e = document.getElementById('fleetstatus'); 
  //e.innerHTML = "{Sending_fleet}";
}
      
function whenLoaded(){
  //    var e = document.getElementById('fleetstatus'); 
  // e.innerHTML = "{Sent_fleet}";
}
      
function whenInteractive(){
  //var e = document.getElementById('fleetstatus'); 
  // e.innerHTML = "{Obtaining_data}";
}

/* 
   We can overwrite functions of the sack object easily. :-)
   This function will replace the sack internal function ruNumesponse(), 
   which normally evaluates the xml return value via eval(this.response).
*/

function wheNumesponse(){

 /*
 *
 *  600   OK
 *  601   no planet exists there
 *  602   no moon exists there
 *  603   player is in noob protection
 *  604   player is too strong
 *  605   player is in u-mode 
 *  610   not enough espionage probes, sending x (parameter is the second return value)
 *  611   no espionage probes, nothing send
 *  612   no fleet slots free, nothing send
 *  613   not enough deuterium to send a probe
 *
 */
  
  // the first three digit long return value
  retVals = this.response.split(" ");
  // and the other content of the response
  // but since we only got it if we can send some but not all probes 
  // theres no need to complicate things with better parsing

  // each case gets a different table entry, no language file used :P
  switch(retVals[0]) {
  case "600":
    addToTable("done", "success");
        changeSlots(retVals[1]);
    setShips("probes", retVals[2]);
    setShips("recyclers", retVals[3]);
    setShips("missiles", retVals[4]);
        break;
  case "601":
    addToTable("{an_error_has_happened_while_it_was_sent}", "error");
    break;
  case "602":
    addToTable("{error_there_is_no_moon}", "error");
    break;
  case "603":
    addToTable("{error_the_player_is_under_the_protection_of_beginners}", "error");
    break;
  case "604":
    addToTable("{error_the_player_is_too_strong}", "error");
    break;
  case "605":
    addToTable("{error_the_player_is_in_way_vacation}", "vacation");
    break;
  case "610":
    addToTable("{error_only_x_available_probes_sending}", "notice");
    break;
  case "611":
    addToTable("{error_there_are_no_available_probes_of_spying}", "error");
    break;
  case "612":
    addToTable("{error_you_cannot_send_any_more_fleets}", "error");
    break;
  case "613":
    addToTable("{error_you_do_not_have_sufficient_deuterium}", "error");
    break;
  case "614":
    addToTable("{There_is_not_planet}", "error");
    break;
  case "615":
    addToTable("{error_there_is_no_sufficient_fuel}", "error");
    break;
  case "616":
    addToTable("{multialarm}", "error");
    break;
  }
}

function doit(order, galaxy, system, planet, planettype, shipcount){
  strInfo = "{Sending} "+shipcount+" sonda"+(shipcount>1?"(s)":"")+" a "+galaxy+":"+system+":"+planet+"...";
    
    ajax.requestFile = "quickfleet.php";

    // no longer needed, since we don't want to write the cryptic
    // response somewhere into the output html
    //ajax.element = 'fleetstatus';
    //ajax.onLoading = whenLoading;
    //ajax.onLoaded = whenLoaded; 
    //ajax.onInteractive = whenInteractive;

    // added, overwrite the function ruNumesponse with our own and
    // turn on its execute flag
    ajax.ruNumesponse = wheNumesponse;
    ajax.execute = true;

    ajax.setVar("order", order);
    ajax.setVar("galaxy", galaxy);
    ajax.setVar("system", system);
    ajax.setVar("planet", planet);
    ajax.setVar("planettype", planettype);
    ajax.setVar("shipcount", shipcount);
    ajax.setVar("speed", 10);
    ajax.setVar("reply", "short");
    ajax.runAJAX();
}

/*
 * This function will manage the table we use to output up to three lines of
 * actions the user did. If there is no action, the tr with id 'fleetstatusrow'
 * will be hidden (display: none;) - if we want to output a line, its display 
 * value is cleaned and therefore its visible. If there are more than 2 lines 
 * we want to remove the first row to restrict the history to not more than 
 * 3 entries. After using the object function of the table we fill the newly
 * created row with text. Let the browser do the parsing work. :D
 */
function addToTable(strDataResult, strClass) {
  var e = document.getElementById('fleetstatusrow');
  var e2 = document.getElementById('fleetstatustable');

  // make the table row visible
  e.style.display = '';
  
  if(e2.rows.length > 2) {
    e2.deleteRow(2);
  }
  
  var row = e2.insertRow('test');

  var td1 = document.createElement("td");
  var td1text = document.createTextNode(strInfo);
  td1.appendChild(td1text);

  var td2 = document.createElement("td");

  var span = document.createElement("span");
  var spantext = document.createTextNode(strDataResult);

  var spanclass = document.createAttribute("class");
  spanclass.nodeValue = strClass;
  span.setAttributeNode(spanclass);

  span.appendChild(spantext);
  td2.appendChild(span);
  
  row.appendChild(td1);
  row.appendChild(td2);
}

function changeSlots(slotsInUse) {
  var e = document.getElementById('slots');
  e.innerHTML = slotsInUse;
}

function setShips(ship, count) {
  var e = document.getElementById(ship);
  e.innerHTML = count;
}

</script>


<body onmousemove="tt_Mousemove(event);">

<center>

<form action="" method="post" id="galaxy_form">
<input id="auto" value="dr" type="hidden">
<table border="0"> 
  <tr>
    <td>
      <table>
        <tbody><tr>
         <td class="c" colspan="3">{Galaxy}</td>
        </tr>
        <tr>
          <td class="l"><input name="galaxyLeft" value="&lt;-" onClick="galaxy_submit('galaxyLeft')" type="button"></td>
          <td class="l"><input name="galaxy" value="{galaxy}" size="5" maxlength="3" tabindex="1" type="text">
          </td><td class="l"><input name="galaxyRight" value="-&gt;" onClick="galaxy_submit('galaxyRight')" type="button"></td>
        </tr>
       </tbody></table>
      </td>
      <td>
       <table>
        <tbody><tr>
         <td class="c" colspan="3">{Solar_system}</td>
        </tr>
         <tr>
          <td class="l"><input name="systemLeft" value="&lt;-" onclick="galaxy_submit('systemLeft')" type="button"></td>
          <td class="l"><input name="system" value="{system}">
          </td><td class="l"><input name="systemRight" value="-&gt;" onclick="galaxy_submit('systemRight')" type="button"></td>
         </tr>
        </tbody></table>
       </td>
      </tr>
      <tr>
        <td colspan="2" align="center"> <input value="{Show}" type="submit"></td>
      </tr>
     </tbody></table>
</form>
   <table width="569">
<tbody><tr>
	<td class="c" colspan="8">{Solar_system_at}</td>
	</tr>
	<tr>
	  <td class="c">{Pos}</td>
	  <td class="c">{Planet}</td>
	  <td class="c">{Name}</td>
	  <td class="c">{Moon}</td>
	  <td class="c">{Debris}</td>
	  <td class="c">{Player} ({State})</td>
	  <td class="c">{Alliance}</td>
	  <td class="c">{Actions}</td>
	</tr>
    {echo_galaxy}
	<tr>
	  <td class="c" colspan="6">{planetcount}</td>
	  <td class="c" colspan="2"><a href="#" onmouseover="this.T_WIDTH=150;return escape('<table><tr><td class=\'c\' colspan=\'2\'>{Legend}</td></tr><tr><td width=\'125\'>{Strong_player}</td><td><span class=\'strong\'>f</span></td></tr><tr><td>{Weak_player}</td><td><span class=\'noob\'>d</span></td></tr><tr><td>{Way_vacation}</td><td><span class=\'vacation\'>v</span></td></tr><tr><td>{Pendent_user}</td><td><span class=\'banned\'>s</span></td></tr><tr><td>{Inactive_7_days}</td><td><span class=\'inactive\'>i</span></td></tr><tr><td>{Inactive_28_days}</td><td><span class=\'longinactive\'>I</span></td></tr></table>')">{Legend}</a></td>
	</tr>
	<!--<tr>
	  <td class="c" colspan="8">&nbsp;&nbsp;&nbsp;&nbsp;<span id="slots">0</span> de 9 hueco(s) in use</td>
	</tr>-->
	<tr style="display: none;" id="fleetstatusrow">
	  <th colspan="8"><!--<div id="fleetstatus"></div>-->
		<table style="font-weight: bold;" id="fleetstatustable" width="100%">
		<!-- will be filled with content later on while processing ajax replys -->
		</table>
	  </th>
	</tr>
</table>

</center> <!-- OH MY GOD! --->

<script language="JavaScript" src="scripts/wz_tooltip.js"></script>
