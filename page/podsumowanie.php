<?php
// SPRAWDZENIE OSTATNIEGO PODSUMOWANIA
$ostatnie = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM ZestawienieMiesieczne ORDER BY id DESC LIMIT 1"));
$data = $ostatnie['DataPodsumowania'];
$data = strtotime( $data );
echo "Ostatnie podsumowanie wykonano: ";
if (date('d-m-Y',$data)!='01-01-1970'){ 
	echo date( 'd-m-Y', $data )."</BR>";
}else{
	echo "---</BR>";
}

// PORÓWNANIE DATY BIERZĄCEJ Z DATĄ OSTATNIEGO PODSUMOWANIA W CELU SPRAWDZENIA CZY NALEZY WYKONAC NOWE
if (date('m-Y',$data)!=date('m-Y')){
	echo "</BR>Rozpoczął się nowy miesiąc pracy należy wykonać podsumowanie za miesiąc poprzedni.";
	echo "</BR><form action='?a=podsumowanie' method='post'>
		  <input type='submit' style='width:300px' name='pmiesiaca' value='Podsumuj'/></BR>";
	// POTWIERDZENIE WYSŁANIA FORMULARZA
	if (isset($_POST['pmiesiaca'])){
		// SPRAWDZENIE LICZBY PRACOWNIKÓW DLA KTÓRYCH MA BYĆ WYKONANE PODSUMOWANIE
		$liczbapracownikow = mysqli_fetch_array(mysqli_query($db, "SELECT count(*) FROM Pracownicy"));
		$liczbapracownikow = $liczbapracownikow[0];
		//TABLICA PODSUMOWANIA
		$podsum[$liczbapracownikow-1][2] =array();
		for($i=0;$i<=$liczbapracownikow-1;$i++){
			for ($j=0;$j<=3;$j++){
				$podsum[$i][$j] = 0;
			}
		}
		//ZMIANA DATY TAK ABY PODSUMOWANIE BYŁO TWORZONE Z POPRZEDNIEGO MIESIACA
		if (date('m')>01){
			// zmiana na obecny miesiac ze wzgledu na testy
			//$miesiac = (date('m')-1);
			$miesiac = date('m');
			$rok = date('Y');
		}
		else{
			$miesiac = 12;
			$rok = (date('Y')-1);
		}
		//SPRAWDZENIE ILOSCI DNI W MIESIACU
		$dni = date('t', mktime(0, 0, 0, $miesiac , 1, $rok));
		echo "Wykonywanie podsumowania za : ".$miesiac."-".$rok."</BR>";
		
		//PETLA SPRAWDZAJACA KOLEJNO DNI MIESIACA
		for($i=1;$i<=$dni;$i++){
			//UTWORZENIE NOWEJ DATY DO SPRAWDZANIA
			$dzien = $i;
			if ($dzien < 10){
				$dzien = "0".$dzien;
			}
			$ndata = $dzien."-".$miesiac."-".$rok;
			$ndata = strtotime($ndata);
			echo "<font color='darkgreen' ><B>". date( 'd-m-Y', $ndata )."</B></font></BR>";
			//PETLA SPRAWDZAJACA KOLEJNO WSZYSTKICH PRACOWNIKOW
			$idpracownika = 0;
			for ($j=1;$j<=$liczbapracownikow;$j++){
				$godziny = 0;
				$last = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM Pracownicy WHERE Id>".$idpracownika." LIMIT 1 "));
				$idpracownika = $last['Id'];
				echo "<font color='red' >Pracownik ".$idpracownika."</font></BR>";
				
				$sql1 = mysqli_query($db, "SELECT * FROM RejestrWe WHERE IdPracownika=".$idpracownika." AND godz_WE LIKE '".date( 'Y-m-d', $ndata )."%' ");
				$l_wejsc = mysqli_num_rows($sql1); 
				
				$sql2 = mysqli_query($db, "SELECT * FROM RejestrWy WHERE IdPracownika=".$idpracownika." AND godz_WY LIKE '".date( 'Y-m-d', $ndata )."%' ");
				$l_wyjsc = mysqli_num_rows($sql2);
				
				if($l_wejsc > 0) { 
					if($l_wejsc == 1) { 
						$wejscie = mysqli_fetch_assoc($sql1);
						$wyjscie = mysqli_fetch_assoc($sql2);
						$we = strtotime( $wejscie['godz_WE'] );
						$wy = strtotime( $wyjscie['godz_WY'] );
						$godz_we = date( 'H:i:s', $we );
						$godz_wy = date( 'H:i:s', $wy );
						echo "Wejścia : ".$l_wejsc."</BR>";
						echo $godz_we."</BR>";
						echo "Wyjścia : ".$l_wyjsc."</BR>";
						echo $godz_wy."</BR>";
						
						$roznica = (strtotime($godz_wy) - strtotime($godz_we));
						$min = floor($roznica / 60);
						$sec = $roznica-($min*60);
						$h = floor($min/60);
						$min = $min-($h*60);
						echo "Czas pracy: ".$h." godzin ".$min." minut ".$sec." sekund</BR>";
						
						$godz_we2 = date( 'H:i:s', $we );
						$godz_wy2 = date( 'H:i:s', $wy );
						if ( (date( 'H', $we )) < 8 ){ 
							$godz_we2 = "08:00:00";
						};
						if ( (date( 'H', $wy )) >= 16){ 
							$godz_wy2 = "16:00:00";
						};

						$roznica2 = (strtotime($godz_wy2) - strtotime($godz_we2));
						$min2 = floor($roznica2 / 60);
						$sec2 = $roznica2-($min2*60);
						$h2 = floor($min2/60);
						$min2 = $min2-($h2*60);
						$godziny = $h2;
					}
				}
				
				// Brak obsługi dla kilkakrotnego we/wy
				// Brak aktualizacji do bazy danych ze względu na brak podliczania wynagrodzenia,
				// które będzie obliczane w nsatępnym sprincie.
				
				echo "<font color='grey'> <B>Godziny płatne: ".$godziny." </B></font></BR>"; 
		
				$podsum[$j-1][0] = $idpracownika;
				$podsum[$j-1][1] += $l_wejsc;
				$podsum[$j-1][2] += $l_wyjsc;
				$podsum[$j-1][3] += $godziny;
		
			}
			//KONIEC PETLI SPRAWDZAJACEJ KOLEJNO WSZYSTKICH PRACOWNIKOW
			echo "</BR>";
		}
		//KONIEC PETLI SPRAWDZAJACEJ KOLEJNO DNI MIESIACA
		//TABLEA PODSUMOWUJĄCA: ID PRACOWNIKA, LICZBA WE, LICZBA WY.
		echo "<HR>";
		for($i=0;$i<=$liczbapracownikow-1;$i++){
			for ($j=0;$j<=3;$j++){
				switch($j){
					case 0:
						echo "Pracownik : ";
						break;
					case 1:
						echo " WE : ";
						break;
					case 2:
						echo " WY : ";
						break;	
					case 3:
						echo " Godziny: ";
						break;
				}
				echo $podsum[$i][$j];
			}
			echo "</BR>";
		}
	}
}
?>