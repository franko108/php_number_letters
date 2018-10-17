<?php

class Class_brojuslova {
	
	var $a;
	// var $slovima;
	
	function upravljac($a) {
		$slovima = "";
		$jednatisuca = 0;  
	
		// razdvaja broj na kune i  lipe. Može biti decimala ili ne, moze biti točka za decimalu, ili zarez
		if(strpos($a, ".")) {
			list($kuna, $lipa) = explode(".", $a);
		}
		elseif(strpos($a, ",")) {
			list($kuna, $lipa ) = explode(",", $a);
		}
		else {
			$kuna = $a;
			$lipa = 0;
		 }

		// koliko znamenki imamo za kune ?
		$duzinakuna = strlen($kuna);
		
		if($duzinakuna > 6) {
				echo "Sorry, preko milion kuna još ne obrađujemo, obratite se administratoru! ";
				exit;
		}

		// od 100000 - 999999; dosta za danas...
		if($duzinakuna == 6) {
				$sestaznamenka = substr($kuna, -6, 1);
				
				$slovima = $this->stododevetsto($sestaznamenka);
				// idemo na slijedecu decimalu
				$duzinakuna = 5;
		}


		// od 10000-100000
		if($duzinakuna == 5) {
			$petaznamenka = substr($kuna, -5, 1);
			
			if($petaznamenka == 1) {
				$petaznamenka = substr($kuna, -5, 2);
				$tmpslovima =  $this->desetdodvadeset($petaznamenka, "tisuća");
		
				$slovima = $slovima."".$tmpslovima;	
				
				// preskače slijedeci dio o desetinama tisuca, ide na stotine
				$duzinakuna = 3;
			}
			else {
				$tmpslovima =  $this->dvadesetdosto($petaznamenka, "tisuća");

				$slovima = $slovima."".$tmpslovima;
	
				// ide na dio od 1-9 (tisuca)
				$duzinakuna = 4;
				$jednatisuca = 1;
			}
			
		}


		// od 1000-9999
		if($duzinakuna == 4) {
			$cetvrtaznamenka = substr($kuna, -4, 1);
			
			if($cetvrtaznamenka == 0) {
				$tmpslovima = "tisuća";

				$slovima = $slovima."".$tmpslovima;	
				
			}
			elseif($cetvrtaznamenka == 1) {
				if($jednatisuca == 1) {
					$tmpslovima =  "jednatisuća";

					$slovima = $slovima."".$tmpslovima;	
				
				}
				else {
					$tmpslovima = "tisuću";

					$slovima = $slovima."".$tmpslovima;	
					
				}	
			}

			elseif($cetvrtaznamenka > 1) {
					$tisuce  = $this->brojdodeset($cetvrtaznamenka, "tisuća");
					
					$slovima = $slovima."".$tisuce;	
					
			}			
			// ide na slijedeci upit za stotine
			$duzinakuna = 3;
		}

		// od 100-999
		if($duzinakuna == 3) {
				$trecaznamenka = substr($kuna, -3, 1);
				
				// $stotina = stododevetsto($trecaznamenka);
				$stotina =  $this->stododevetsto($trecaznamenka);
			
				$slovima = $slovima."".$stotina;	
				
		}


		// od 1-99
		// $prvadvakuna = kunelipe($kuna, "kuna");
		$prvadvakuna = $this->kunelipe($kuna, "kuna");
		if($prvadvakuna == NULL) {
			$prvadvakuna[0] = "kuna";
			$prvadvakuna[1] = "";
		}
		
		$slovima = $slovima."".$prvadvakuna[0]."".$prvadvakuna[1];


		// ima decimalu, tj.lipe, vrati naziv
			if($lipa > 0) {
				$b = $this->kunelipe($a, "lipa");
				$tmplipe = "".$b[0]."".$b[1];

				$slovima = $slovima."".$tmplipe;	

				
		}
		// ovo je potrebno ako cesto mijanjemo iznose u racunu, zapamti veci iznos
		unset($jednatisuca);
		return $slovima;

	}
	


	function kunelipe($x, $kunalipa)  {

			$prvadva = substr($x, -2);
			if($prvadva > 0) {
				$prvadva_arr = array();
				// pokreni function brojuslova i vrati lipe
				if($prvadva > 0 && $prvadva < 10) {
					$prvadva_arr[0] = $this->brojdodeset(substr($x, -1), $kunalipa);
					// $lipe_arr[1] = brojuslova(substr($x, -2));
					$prvadva_arr[1] = "";
				
					return $prvadva_arr;
				}
				elseif($prvadva >= 10 && $prvadva < 20) {
					$prvadva_arr[0] = $this->desetdodvadeset(substr($x, -2), $kunalipa);
					$prvadva_arr[1] = "";
					
					return $prvadva_arr;
				}
				elseif($prvadva >= 20 && $prvadva < 100) {
					$prvadva_arr[0] = $this->dvadesetdosto(substr($x, -2, 1), $kunalipa);
					$prvaznamenka = substr($x, -1);
					if($prvaznamenka == 0) {
						$prvadva_arr[1] = $kunalipa;
					}
					else {
						$prvadva_arr[1] = $this->brojdodeset($prvaznamenka, $kunalipa);					
					}
					
					return $prvadva_arr;				
				}

			}		
	}


	function brojdodeset ($x, $kunalipa) {
			
		switch($x) {
			case 0;
				return " ";
			break;
			case 1;
				return "jedna".$kunalipa;
			break;
			case 2;
				if($kunalipa == "kuna") {
					return "dvijekune";
				}
				elseif($kunalipa == "lipa") {
					return "dvijelipe";
				}
				elseif($kunalipa == "tisuća") {
					return "dvijetisuće";
					}
			break;
			case 3;
				if($kunalipa == "kuna") {
					return "trikune";
				}
				elseif($kunalipa == "lipa") {
					return "trilipe";
				}
				elseif($kunalipa == "tisuća") {
					return "tritisuće";
				}
			break;
			case 4;
				if($kunalipa == "kuna") {
					return "četirikune";
				}
				elseif($kunalipa == "lipa") {
					return "četirilipe";
				}
				elseif($kunalipa == "tisuća") {
						return "četiritisuće";
				}
			break;
			case 5;
				return "pet".$kunalipa;
			break;
			case 6;
				return "šest".$kunalipa;
			break;
			case 7;
				return "sedam".$kunalipa;
			break;
			case 8;
				return "osam".$kunalipa;
			break;
			case 9;
				return "devet".$kunalipa;
			break;
		}
	}

	function desetdodvadeset ($x,$kunalipa) {
			switch($x) {
				case 10;
					return "deset".$kunalipa;
				break;
				case 11;
					return "jedanaest".$kunalipa;
				break;
				case 12;
					return "dvanaest".$kunalipa;
				break;
				case 13;
					return "trinaest".$kunalipa;
				break;
				case 14;
					return "četrnaest".$kunalipa;
				break;
				case 15;
					return "petnaest".$kunalipa;
				break;
				case 16;
					return "šesnaest".$kunalipa;
				break;
				case 17;
					return "sedamnaest".$kunalipa;
				break;
				case 18;
					return "osamnaest".$kunalipa;
				break;
				case 19;
					return "devetnaest".$kunalipa;
				break;		
			}
		
	}

	function dvadesetdosto($x) {
		switch($x) {
			case 2;
				return "dvadeset";
			break;	
			case 3;
				return "trideset";
			break;
			case 4;
				return "četrdeset";
			break;
			case 5;
				return "pedeset";
			break;
			case 6;
				return "šestdeset";
			break;
			case 7;
				return "sedamdeset";
			break;
			case 8;
				return "osamdeset";
			break;
			case 9;
				return "devedeset";
			break;	
		}
		
	}

	function stododevetsto ($x) {
			switch($x) {
			case 1;
				return "sto";
			break;	
			case 2;
				return "dvjesto";
			break;	
			case 3;
				return "tristo";
			break;	
			case 4;
				return "četiristo";
			break;	
			case 5;
				return "petsto";
			break;	
			case 6;
				return "šesto";
			break;	
			case 7;
				return "sedamsto";
			break;	
			case 8;
				return "osamsto";
			break;	
			case 9;
				return "devetsto";
			break;	
			}
	}


}