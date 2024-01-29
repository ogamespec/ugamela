<?	


//define('INSIDE', true);
//$ugamela_root_path = './';
//include($ugamela_root_path . 'extension.inc');
//include($ugamela_root_path . 'common.'.$phpEx);

$lunas_query = doquery("SELECT * FROM {{table}} WHERE id_owner='{$user['id']}'","lunas");
	$lu = 1;
	while($plu = mysql_fetch_array($lunas_query)){
		
		if($plu["id"] != $user["current_luna"]){
			$aplu .= "<th>{$plu['name']}<br>
			<a href=\"?cplu={$plu['id']}&re=0\" title=\"{$plu['name']}\"><img src=\"{$dpath}planeten/small/{$plu['image']}.jpg\" height=\"50\" width=\"50\"></a><br>
			<center>";
			/*
			  Gracias al 'b_building_id' y al 'b_building' podemos mostrar en el overview
			  si se esta construyendo algo en algun planeta.
			*/
			if($plu['b_building_id'] != 0){
				if(check_building_progress($plu)){
					$aplu .= $lang['tech'][$plu['b_building_id']];
					$time = pretty_time($plu['b_building'] - time());
					$aplu .= "<br><font color=\"#7f7f7f\">({$time})</font>";
				}
				else{$aplu .= $lang['Free'];}
			}else{$aplu .= $lang['Free'];}
			
			$aplu .= "<center></center></center></th>";
			//Para ajustar a dos columnas
			if($lu <= 1){$lu++;}else{$aplu .= "</tr><tr>";$lu = 1;	}
		}
	}


	$parse = $lang;

	$parse['moon'] = $lunarow['name'];
#Moon END
	$parse['luna_name'] = $lunarow['name'];
	$parse['luna_diameter'] = $lunarow['diameter'];
	$parse['luna_field_current'] = $lunarow['field_current'];
	$parse['luna_field_max'] = $lunarow['field_max'];
	$parse['luna_temp_min'] = $lunarow['temp_min'];
	$parse['luna_temp_max'] = $lunarow['temp_max'];
	$parse['galaxy_galaxy'] = $galaxyrow['galaxy'];
	$parse['galaxy_luna'] = $galaxyrow['luna'];
	$parse['galaxy_system'] = $galaxyrow['system'];
	$parse['user_points'] = pretty_number($user['points_points']/1000);
	$rank = doquery("SELECT COUNT(DISTINCT(id)) FROM {{table}} WHERE points_points>={$user['points_points']}","users",true);
	$parse['user_rank'] = $rank[0];
	$parse['u_user_rank'] = $rank[0];
	$parse['user_username'] = $user['username'];
	$parse['fleet_list'] = $fpage;
	$parse['energy_used'] = $lunarow["energy_max"]-$lunarow["energy_used"];

	$parse['Have_new_message'] = $Have_new_message;
	$parse['time'] = date("D M d H:i:s",time());

	$parse['dpath'] = $dpath;

	$parse['luna_image'] = $lunarow['image'];
	$parse['anothers_lunas'] = $aplu;
	$parse['max_users'] = $game_config['users_amount'];
	//Muestra los escombros en la posicion del lunaa  * Agregado en v0.1 r46 *
	$parse['metal_debris'] = $galaxyrow['metal'];
	$parse['crystal_debris'] = $galaxyrow['crystal'];
	//El link
	if(($galaxyrow['metal']!=0||$galaxyrow['crystal']!=0)&&$lunarow[$resource[209]]!=0){
		$parse['get_link'] = " (<a href=\"quickfleet.php?mode=harvest&g={$galaxyrow['system']}&s={$galaxyrow['system']}&p={$galaxyrow['luna']}\">{$lang['Harvest']}</a>)";
	}else{$parse['get_link'] = '';}
	//
	//Muestra la actual contruccion en el lunaa
	//Y un contador, gracias NaNiN por la sugerencia
	if($lunarow['b_building_id']!=0&&$lunarow['b_building']>time()){
		$parse['building'] = $lang['tech'][$lunarow['b_building_id']].
		'<br><div id="bxx" class="z">'.pretty_time($lunarow['b_building'] - time()).'</div><SCRIPT language=JavaScript>
		pp="'.($lunarow['b_building'] - time()).'";
		pk="'.$lunarow["b_building_id"].'";
		pl="'.$lunarow["id"].'";
		ps="buildings.php";
		t();
	</script>';
		//$time =  pretty_time();
		//$a['building'] = "<br><font color=\"#7f7f7f\">({$time})</font>";
		// = parsetemplate(gettemplate('overview_body'), $parse);
	}else{
		$parse['building'] = $lang['Free'];
	}

?>