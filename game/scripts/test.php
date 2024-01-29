<div id="okienko" style="text-align:center;"></div>
<script type="text/javascript">
<!-- <![CDATA[
<?
echo "delta = ".time()." - new Date().getTime()/1000;\n";
?>
function zegar() {
  var teraz = new Date().getTime()/1000 + delta; // aktualna data + delta
    var dzien = new Date(2006,11,31,23,59,59).getTime()/1000; // 2006.12.31 - 23:59:59
     
      // wyliczanie roznicy
        var sekund = Math.abs(teraz-dzien);
	  var minut = Math.floor(sekund/60);
	    var godzin = Math.floor(minut/60);
	      var dni = Math.floor(godzin/24);
	        var lat = Math.floor(dni/365);
		 
		  // wyliczanie calego okresu
		    sekund = Math.floor(sekund-minut*60);
		      minut = Math.floor(minut-godzin*60);
		        godzin = Math.floor(godzin-dni*24);
			  dni = Math.floor(dni-lat*365);
			   
			    var roznica="<b>lat:</b> "+lat+" <b>dni:</b> "+dni+"; <b>godzin:</b> "+
			        godzin+" <b>minut:</b> "+((minut<10)?"0":"")+minut+
				    " <b>sekund:</b> "+((sekund<10)?"0":"")+sekund;
				      document.getElementById("okienko").innerHTML =
				          "Do koñca roku 2006 zosta³o<br />"+roznica;
					    if (teraz<dzien) {
					        setTimeout("zegar()",1000);
						  } else {
						      document.getElementById("okienko").innerHTML = "Mamy Nowy Rok!";
						        }
							}
							zegar();
							// ]]> -->
							</script>