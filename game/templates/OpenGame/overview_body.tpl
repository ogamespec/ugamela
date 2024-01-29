<script src="scripts/cnt.js" type="text/javascript"></script>
<center>
<br>
<br>
<table width="519">
  <tr>
	<td class="c" colspan="4">
	  <a href="overview.php?mode=renameplanet" title="{Planet_menu}">{Planet} "{planet_name}"</a> ({user_username})
	</td>
  </tr>
  
  <!-- Notificacion del mensaje -->

{Have_new_message}

<tr><th>{Server_time}</th><th colspan=3>

{time}

	</th>
  </tr>
  <tr>
	<td colspan="4" class="c">{Events}</td>
  </tr>
  <script language="javascript"> anz=0; t(); </script>

{fleet_list}

  <tr>
	<th></th>
	<th colspan="2">
	  <img src="{dpath}planeten/{planet_image}.jpg" height="200" width="200">
	  <br>{building}
	</th>
	<th class="s">
      <table class="s" align="top" border="0">
		<tr>
			<!-- Grupo de planetas -->
			{anothers_planets}
		</tr>
     </table>
    </th>
    </tr>
  <tr>
      <th>
    {Diameter}</th><th colspan="3">{planet_diameter} km (<a title="{Developed_fields}">{planet_field_current} </a> / <a title="{max_eveloped_fields}">{planet_field_max} </a> {fields})</th>
  </tr>
  <tr>
	<th>{Temperature}</th> <th colspan="3">{approx} {planet_temp_min}{Centigrade} {to} {planet_temp_max}{Centigrade}</th>
  </tr>
  <tr>
	<th>{Position}</th><th colspan="3"><a href="galaxy.php?g={galaxy_galaxy}&s={galaxy_system}">[{galaxy_galaxy}:{galaxy_system}:{galaxy_planet}]</a></th>
  </tr>
  <tr>
	<th>{Debris}</th><th colspan="3">{Metal}: {metal_debris} / {Crystal}: {crystal_debris}{get_link}</th>
  </tr>
	<tr>
  <!-- UNDO THIS LINE -->
	<th>{Points}</th><th colspan="3"><font color="Yellow">Online Users</font> <font color="Lime">{online_users}</font>
  <!--	<th>{Points}</th><th colspan="3">{points_total}
<br>Online Users <font color="Lime">{online_users}</font> -->

    <br>{Rank} <a href="stat.php?start={u_user_rank}">{user_rank}</a> {of} {max_users}<br>Points: {user_points}<br>User Fleets: {user_fleet}<br>User Buildings {user_buili}<br>User Research {player_points_tech}</th>
  </tr>
</table>
 <br>
</center>
  <script language="JavaScript" src="scripts/wz_tooltip.js"></script>
</body>
</html>