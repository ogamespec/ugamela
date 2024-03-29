<?php
/*
Some rights reserved
Code by jacekowski (jacekowski@wklej.org)
licensed under CC BY-NC-SA http://creativecommons.org/licenses/by-nc-sa/2.5/ http://creativecommons.org/licenses/by-nc-sa/2.5/pl/
all violations of BY, NC and SA rule will be punished
*/
function walka($atakujacy,$wrog,$tech_atakujacy,$tech_wrog){
	global $pricelist,$game_config;
	$runda = array();
	$atakujacy_n=array();
	$wrog_n=array();
	if (!is_null($atakujacy)) {
		$atakujacy_zlom_poczatek["metal"] =0;
		$atakujacy_zlom_poczatek["krysztal"] =0;
			foreach($atakujacy as $a => $b){
				$atakujacy_zlom_poczatek["metal"] = $atakujacy_zlom_poczatek["metal"] + $atakujacy[$a]["ilosc"] * $pricelist[$a]["metal"];
				$atakujacy_zlom_poczatek["krysztal"] = $atakujacy_zlom_poczatek["krysztal"] + $atakujacy[$a]["ilosc"] * $pricelist[$a]["crystal"];
			}
	}
	$wrog_zlom_poczatek["metal"] = 0;
	$wrog_zlom_poczatek["krysztal"] = 0;
	$wrog_poczatek=$wrog;
	if (!is_null($wrog)) {
		foreach($wrog as $a => $b){
			if ($a < 300){
				$wrog_zlom_poczatek["metal"] = $wrog_zlom_poczatek["metal"] + $wrog[$a]["ilosc"] * $pricelist[$a]["metal"];
				$wrog_zlom_poczatek["krysztal"] = $wrog_zlom_poczatek["krysztal"] + $wrog[$a]["ilosc"] * $pricelist[$a]["crystal"];
			} else {
				$wrog_zlom_poczatek_obrona["metal"] = $wrog_zlom_poczatek_obrona["metal"] + $wrog[$a]["ilosc"] * $pricelist[$a]["metal"];
				$wrog_zlom_poczatek_obrona["krysztal"] = $wrog_zlom_poczatek_obrona["krysztal"] + $wrog[$a]["ilosc"] * $pricelist[$a]["crystal"];
			}
		}
	}
	for ($i = 1; $i<=7;$i++){
		$atakujacy_atak=0;
		$wrog_atak=0;
		$atakujacy_obrona=0;
		$wrog_obrona=0;
		$atakujacy_ilosc=0;
		$wrog_ilosc=0;
		$wrog_tarcza=0;
		$atakujacy_tarcza=0;
		
		if (!is_null($atakujacy)) {
			foreach($atakujacy as $a => $b){
				$atakujacy[$a]["obrona"] = $atakujacy[$a]["ilosc"] * ($pricelist[$a]["metal"] + $pricelist[$a]["crystal"])/10 * (1 + (0.1 * ($tech_atakujacy["defence_tech"])));
				$rand = rand(80,120)/100;
				$atakujacy[$a]["tarcza"] = $atakujacy[$a]["ilosc"] * $pricelist[$a]["shield"] * (1 + (0.1 *$tech_atakujacy["shield_tech"])) * $rand;
				$atak_statku = $pricelist[$a]["attack"];
				$technologie = (1 + (0.1 * $tech_atakujacy["military_tech"]));
				$rand = rand(80,120)/100;
				$ilosc = $atakujacy[$a]["ilosc"];
				$atakujacy[$a]["atak"] = $ilosc * $atak_statku * $technologie * $rand;
				$atakujacy_atak = $atakujacy_atak + $atakujacy[$a]["atak"];
				$atakujacy_obrona = $atakujacy_obrona + $atakujacy[$a]["obrona"];
				$atakujacy_ilosc = $atakujacy_ilosc + $atakujacy[$a]["ilosc"];
			}
		} else {
			$atakujacy_ilosc = 0;
			break;
		}
	
		if (!is_null($wrog)) {
			foreach($wrog as $a => $b){
				$wrog[$a]["obrona"] = $wrog[$a]["ilosc"] * ($pricelist[$a]["metal"] + $pricelist[$a]["crystal"])/10 * (1 + (0.1 * ($tech_wrog["defence_tech"])));
				$rand = rand(80,120)/100;
				$wrog[$a]["tarcza"] = $wrog[$a]["ilosc"] * $pricelist[$a]["shield"] * (1 + (0.1 *$tech_wrog["shield_tech"])) * $rand;
				$atak_statku = $pricelist[$a]["attack"];
				$technologie = (1 + (0.1 * $tech_wrog["military_tech"]));
				$rand = rand(80,120)/100;
				$ilosc = $wrog[$a]["ilosc"];
				$wrog[$a]["atak"] = $ilosc * $atak_statku * $technologie * $rand;
				$wrog_atak = $wrog_atak + $wrog[$a]["atak"];
				$wrog_obrona = $wrog_obrona + $wrog[$a]["obrona"];
				$wrog_ilosc = $wrog_ilosc + $wrog[$a]["ilosc"];
			}
		} else {
			$wrog_ilosc = 0;
			break;
		}

		$runda[$i]["atakujacy"] = $atakujacy;
		$runda[$i]["wrog"] = $wrog;
		$runda[$i]["atakujacy"]["atak"] = $atakujacy_atak;
		$runda[$i]["wrog"]["atak"] = $wrog_atak;
		$runda[$i]["atakujacy"]["ilosc"] = $atakujacy_ilosc;
		$runda[$i]["wrog"]["ilosc"] = $wrog_ilosc;
	
		if (($atakujacy_ilosc == 0) or ($wrog_ilosc == 0)){
			break;
		}
		foreach($atakujacy as $a => $b){
			if ($atakujacy_ilosc > 0){
				$wrog_moc=$atakujacy[$a]["ilosc"] * $wrog_atak/$atakujacy_ilosc;
				if ($atakujacy[$a]["tarcza"] < $wrog_moc){
					$max_zdjac = floor($atakujacy[$a]["ilosc"]*$wrog_ilosc/$atakujacy_ilosc);
					$wrog_moc = $wrog_moc - $atakujacy[$a]["tarcza"];
					$atakujacy_tarcza = $atakujacy_tarcza + $atakujacy[$a]["tarcza"];
					$ile_zdjac = floor(($wrog_moc/(($pricelist[$a]["metal"] + $pricelist[$a]["crystal"])/10)));
					if ($ile_zdjac > $max_zdjac) {
						$ile_zdjac = $max_zdjac;
					}
					$atakujacy_n[$a]["ilosc"] = ceil($atakujacy[$a]["ilosc"] - $ile_zdjac);
					if ($atakujacy_n[$a]["ilosc"] <= 0){
						$atakujacy_n[$a]["ilosc"] = 0;
					}
				} else {
					$atakujacy_n[$a]["ilosc"] = $atakujacy[$a]["ilosc"];
					$atakujacy_tarcza = $atakujacy_tarcza + $wrog_moc;
				}
			} else {
				$atakujacy_n[$a]["ilosc"] = $atakujacy[$a]["ilosc"];
				$atakujacy_tarcza = $atakujacy_tarcza + $wrog_moc;
			}
		}
	
		foreach($wrog as $a => $b){
			if ($wrog_ilosc > 0){
				$atakujacy_moc = $wrog[$a]["ilosc"] * $atakujacy_atak/$wrog_ilosc;
				if ($wrog[$a]["tarcza"] < $atakujacy_moc){
					$max_zdjac = floor($wrog[$a]["ilosc"]*$atakujacy_ilosc/$wrog_ilosc);
					$atakujacy_moc = $atakujacy_moc - $wrog[$a]["tarcza"];
					$wrog_tarcza = $wrog_tarcza + $wrog[$a]["tarcza"];
					$ile_zdjac = floor(($atakujacy_moc/(($pricelist[$a]["metal"] + $pricelist[$a]["crystal"])/10)));
					if ($ile_zdjac > $max_zdjac) {
						$ile_zdjac = $max_zdjac;
					}
					$wrog_n[$a]["ilosc"] = ceil($wrog[$a]["ilosc"] - $ile_zdjac);
					if ($wrog_n[$a]["ilosc"] <= 0){
						$wrog_n[$a]["ilosc"] = 0;
					} 
				} else {
					$wrog_n[$a]["ilosc"] = $wrog[$a]["ilosc"];
					$wrog_tarcza = $wrog_tarcza + $atakujacy_moc;
				}
			} else {
				$wrog_n[$a]["ilosc"] = $wrog[$a]["ilosc"];
				$wrog_tarcza = $wrog_tarcza + $atakujacy_moc;
			}
		}

		
		
		
		foreach($atakujacy as $a => $b){
			foreach ($pricelist[$a]['sd'] as $c => $d){
				if (isset($wrog[$c])){
					$wrog_n[$c]["ilosc"] = $wrog_n[$c]["ilosc"] - floor($d * rand(50,100)/100);
					if ($wrog_n[$c]["ilosc"] <= 0){
						$wrog_n[$c]["ilosc"] = 0;
					}
				}
			}
		}
	
		foreach($wrog as $a => $b){
			foreach ($pricelist[$a]['sd'] as $c => $d){
				if (isset($atakujacy[$c])){
					$atakujacy_n[$c]["ilosc"] = $atakujacy_n[$c]["ilosc"] - floor($d * rand(50,100)/100);
					if ($atakujacy_n[$c]["ilosc"] <= 0){
						$atakujacy_n[$c]["ilosc"] = 0;
					}
				}
			}
		}

		$runda[$i]["atakujacy"]["tarcza"] = $atakujacy_tarcza;
		$runda[$i]["wrog"]["tarcza"] = $wrog_tarcza;
		//print_r($runda[$i]);
		$wrog = $wrog_n;	
		$atakujacy = $atakujacy_n;
	}


	if (($atakujacy_ilosc == 0) or ($wrog_ilosc == 0)){
		if (($atakujacy_ilosc == 0) and ($wrog_ilosc == 0)){
			$wygrana = "r";
		} else {
			if ($atakujacy_ilosc == 0){
				$wygrana = "w";
			} else {
				$wygrana = "a";
			}
		}
	} else {
		$wygrana = "r";
	}
	$atakujacy_zlom_koniec["metal"] = 0;
	$atakujacy_zlom_koniec["krysztal"] = 0;
	if (!is_null($atakujacy)) {
		foreach($atakujacy as $a => $b){
			$atakujacy_zlom_koniec["metal"] = $atakujacy_zlom_koniec["metal"] + $atakujacy[$a]["ilosc"] * $pricelist[$a]["metal"];
			$atakujacy_zlom_koniec["krysztal"] = $atakujacy_zlom_koniec["krysztal"] + $atakujacy[$a]["ilosc"] * $pricelist[$a]["crystal"];
		}
	}
	$wrog_zlom_koniec["metal"] = 0;
	$wrog_zlom_koniec["krysztal"] = 0;
	if (!is_null($wrog)) {
		foreach($wrog as $a => $b){
			if ($a < 300){
				$wrog_zlom_koniec["metal"] = $wrog_zlom_koniec["metal"] + $wrog[$a]["ilosc"] * $pricelist[$a]["metal"];
				$wrog_zlom_koniec["krysztal"] = $wrog_zlom_koniec["krysztal"] + $wrog[$a]["ilosc"] * $pricelist[$a]["crystal"];
			} else {
				$wrog_zlom_koniec_obrona["metal"] = $wrog_zlom_koniec_obrona["metal"] + $wrog[$a]["ilosc"] * $pricelist[$a]["metal"];
				$wrog_zlom_koniec_obrona["krysztal"] = $wrog_zlom_koniec_obrona["krysztal"] + $wrog[$a]["ilosc"] * $pricelist[$a]["crystal"];
			}
		}
	}
	$ilosc_wrog=0;
	$straty_obrona_wrog=0;
	if (!is_null($wrog)) {
		foreach($wrog as $a => $b){
			if ($a > 300){
				$straty_obrona_wrog = $straty_obrona_wrog + (($wrog_poczatek[$a]["ilosc"] - $wrog[$a]["ilosc"]) * ($pricelist[$a]["metal"] + $pricelist[$a]["crystal"]));
				$wrog[$a]["ilosc"] = $wrog[$a]["ilosc"] + (($wrog_poczatek[$a]["ilosc"] - $wrog[$a]["ilosc"])*rand(60,80)/100);
				$ilosc_wrog = $ilosc_wrog + $wrog[$a]["ilosc"];
			}
		}
	}
	if (($ilosc_wrog > 0) and ($atakujacy_ilosc == 0)){
		$wygrana = "w";
	}
	$zlom["metal"] = ((($atakujacy_zlom_poczatek["metal"] - $atakujacy_zlom_koniec["metal"]) + ($wrog_zlom_poczatek["metal"] - $wrog_zlom_koniec["metal"]))*($game_config["flota_na_zlom"]/100));
	$zlom["krysztal"] = ((($atakujacy_zlom_poczatek["krysztal"] - $atakujacy_zlom_koniec["krysztal"]) + ($wrog_zlom_poczatek["krysztal"] - $wrog_zlom_koniec["krysztal"]))*($game_config["flota_na_zlom"]/100));

	$zlom["metal"] = $zlom["metal"] + ((($atakujacy_zlom_poczatek["metal"] - $atakujacy_zlom_koniec["metal"]) + ($wrog_zlom_poczatek["metal"] - $wrog_zlom_koniec["metal"]))*($game_config["obrona_na_zlom"]/100));
	$zlom["krysztal"] = $zlom["krysztal"] + ((($atakujacy_zlom_poczatek["krysztal"] - $atakujacy_zlom_koniec["krysztal"]) + ($wrog_zlom_poczatek["krysztal"] - $wrog_zlom_koniec["krysztal"]))*($game_config["obrona_na_zlom"]/100));
	
	$zlom["atakujacy"] = (($atakujacy_zlom_poczatek["metal"] - $atakujacy_zlom_koniec["metal"]) + ($atakujacy_zlom_poczatek["krysztal"] - $atakujacy_zlom_koniec["krysztal"]));
	$zlom["wrog"] = (($wrog_zlom_poczatek["metal"] - $wrog_zlom_koniec["metal"]) + ($wrog_zlom_poczatek["krysztal"] - $wrog_zlom_koniec["krysztal"]) + $straty_obrona_wrog);
	return array("atakujacy" => $atakujacy, "wrog" => $wrog, "wygrana" => $wygrana, "dane_do_rw" => $runda, "zlom" => $zlom);
}
?>
