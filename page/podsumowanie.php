<?php
if ($_SESSION['stanowisko'] < 3){
	echo "</BR><form action='?a=podsumowanie' method='post'>
		 <input type='submit' style='width:250px' name='pmiesiaca' value='Pokaż aktualny miesiąc'/></BR>";
	// POTWIERDZENIE WYSŁANIA FORMULARZA
	if (isset($_POST['pmiesiaca'])){
		// SPRAWDZENIE LICZBY PRACOWNIKÓW DLA KTÓRYCH MA BYĆ WYKONANE PODSUMOWANIE
		$liczbapracownikow = mysqli_fetch_array(mysqli_query($db, "SELECT count(*) FROM Pracownicy"));
		$liczbapracownikow = $liczbapracownikow[0];
			
		//TABLICA PODSUMOWANIA
		$podsum[$liczbapracownikow-1][2] =array();
		for($i=0;$i<=$liczbapracownikow-1;$i++){
			for ($j=0;$j<=4;$j++){
				$podsum[$i][$j] = 0;
			}
		}
		$miesiac = date('m');
		$rok = date('Y');
		//SPRAWDZENIE ILOSCI DNI W MIESIACU
		$dni = date('t', mktime(0, 0, 0, $miesiac , 1, $rok));
		echo "Wykonywanie podsumowania za : ".$miesiac."-".$rok."</BR>";
		if ($dni > date('d')) $dni = date('d') ;
		//PETLA SPRAWDZAJACA KOLEJNO DNI MIESIACA
		for($i=$dni;$i>1;$i--){
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
				$pracownik = $last['Imie']." ".$last['Nazwisko'];
				echo "<font color='red' >Pracownik: ".$pracownik."</font></BR>";
				
				$sql1 = mysqli_query($db, "SELECT * FROM RejestrWe WHERE IdPracownika=".$idpracownika." AND godz_WE LIKE '".date( 'Y-m-d', $ndata )."%' ");
				$l_wejsc = mysqli_num_rows($sql1); 
					
				$sql2 = mysqli_query($db, "SELECT * FROM RejestrWy WHERE IdPracownika=".$idpracownika." AND godz_WY LIKE '".date( 'Y-m-d', $ndata )."%' ");
				$l_wyjsc = mysqli_num_rows($sql2);
					
				if($l_wejsc > 0) { 
					echo "Wejścia : ".$l_wejsc."</BR>";
					$we_tab[$l_wejsc-1]=array();
					$wy_tab[$l_wyjsc-1]=array();
					$z=0;
					$smin = 0;
					$ssec = 0;
					$sh =0;
					$smin2 = 0;
					$ssec2 = 0;
					$sh2 =0;
					$godziny = 0;
					while($r = mysqli_fetch_assoc($sql1)){
						$we = strtotime($r['godz_WE']);
						$we_tab[$z] = date('H:i:s', $we );
						echo $we_tab[$z]."</BR>";
						$z++;
					}
					echo "Wyjścia : ".$l_wyjsc."</BR>";
					$z = 0;
					while($r = mysqli_fetch_assoc($sql2)){ 
						$wy = strtotime($r['godz_WY']);
						$wy_tab[$z] = date('H:i:s', $wy );
						echo $wy_tab[$z]."</BR>";
						$z++;
					}
					for($z=0;$z<($l_wejsc);$z++){ 
						$we = (strtotime($we_tab[$z]));
						$wy = (strtotime($wy_tab[$z]));
						//GODZINY PRACY
						$roznica = (strtotime($wy_tab[$z]) - strtotime($we_tab[$z]));
						$min = floor($roznica / 60);
						$sec = $roznica-($min*60);
						$h = floor($min/60);
						$min = $min-($h*60);
						//SUMA
						$smin += $min;
						$ssec += $sec;
						$sh += $h;
								
						if ( (date( 'H', $we )) < 8 ){ 
							$we_tab[$z] = "08:00:00";
						}						
						if ( (date( 'H', $wy )) >= 16){ 
							$wy_tab[$z] = "16:00:00";
						};
						//PŁATNE GODZINY
						if ( (date( 'H', $we )) < 16){ 
							$roznica2 = (strtotime($wy_tab[$z]) - strtotime($we_tab[$z]));
							$min2 = floor($roznica2 / 60);
							$sec2 = $roznica2-($min2*60);
							$h2 = floor($min2/60);
							$min2 = $min2-($h2*60);
							$godziny += $h2;					
						}
						
					}
					echo "Czas pracy: ".$sh." godzin ".$smin." minut ".$ssec." sekund</BR>";
				}
					
				// Brak aktualizacji do bazy danych ze względu na brak podliczania wynagrodzenia,
				// które będzie obliczane w nsatępnym sprincie.
				$zarobek = $godziny * $last['Stawka'];
				echo "<font color='grey'> <B>Godziny płatne: ".$godziny." </B> Szacowany zarobek: <B>".$zarobek."</B></font></BR>"; 
				$sh = 0;
				$smin = 0;
				$ssec = 0;
				$podsum[$j-1][0] = $pracownik;
				$podsum[$j-1][1] += $l_wejsc;
				$podsum[$j-1][2] += $l_wyjsc;
				$podsum[$j-1][3] += $godziny;
				$podsum[$j-1][4] += $zarobek;
		
			}
			//KONIEC PETLI SPRAWDZAJACEJ KOLEJNO WSZYSTKICH PRACOWNIKOW
			echo "</BR>";
		}
		//KONIEC PETLI SPRAWDZAJACEJ KOLEJNO DNI MIESIACA
		//TABLEA PODSUMOWUJĄCA: ID PRACOWNIKA, LICZBA WE, LICZBA WY.
		echo "<HR>";
		for($i=0;$i<=$liczbapracownikow-1;$i++){
			for ($j=0;$j<=4;$j++){
				switch($j){
					case 0:
						echo "<font color='red'> Pracownik : ";
						break;
					case 1:
						echo "<BR><font color='navy'> Wejść : ";
						break;
					case 2:
						echo "<font color='navy'>  / Wyjść : ";
						break;	
					case 3:
						echo "<BR><font color='grey' >Godziny: ";
						break;
					case 4:
						echo "<font color='grey' > = Zarobek: ";
						break;
				}
				echo "<B>".$podsum[$i][$j]."</B></font>";
			}
			echo "</BR></BR>";
		}
	}
}
else{
	echo "</BR><form action='?a=podsumowanie' method='post'>
		 <input type='submit' style='width:250px' name='pmiesiaca' value='Pokaż aktualny miesiąc'/></BR>";
	// POTWIERDZENIE WYSŁANIA FORMULARZA
	if (isset($_POST['pmiesiaca'])){
		// SPRAWDZENIE LICZBY PRACOWNIKÓW DLA KTÓRYCH MA BYĆ WYKONANE PODSUMOWANIE
		//TABLICA PODSUMOWANIA
		$podsum[0][2] =array();
		for($i=0;$i<=0;$i++){
			for ($j=0;$j<=4;$j++){
				$podsum[$i][$j] = 0;
			}
		}
		//ZMIANA DATY TAK ABY PODSUMOWANIE BYŁO TWORZONE Z POPRZEDNIEGO MIESIACA
		$miesiac = date('m');
		$rok = date('Y');
		//SPRAWDZENIE ILOSCI DNI W MIESIACU
		$dni = date('t', mktime(0, 0, 0, $miesiac , 1, $rok));
		if ($dni > date('d')) $dni = date('d');
		//PETLA SPRAWDZAJACA KOLEJNO DNI MIESIACA
		for($i=$dni;$i>1;$i--){
			//UTWORZENIE NOWEJ DATY DO SPRAWDZANIA
			$dzien = $i;
			if ($dzien < 10){
				$dzien = "0".$dzien;
			}
			$ndata = $dzien."-".$miesiac."-".$rok;
			$ndata = strtotime($ndata);
			echo "<font color='darkgreen' ><B>". date( 'd-m-Y', $ndata )."</B></font></BR>";
			//PETLA SPRAWDZAJACA KOLEJNO WSZYSTKICH PRACOWNIKOW
			$idpracownika = $_SESSION['id'];
				
			for ($j=1;$j<=1;$j++){
				$godziny = 0;
				$last = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM Pracownicy WHERE Id=".$idpracownika." LIMIT 1 "));
				$idpracownika = $last['Id'];
				$pracownik = $last['Imie']." ".$last['Nazwisko'];
				echo "<font color='red' >Pracownik: ".$pracownik."</font></BR>";
				
				$sql1 = mysqli_query($db, "SELECT * FROM RejestrWe WHERE IdPracownika=".$idpracownika." AND godz_WE LIKE '".date( 'Y-m-d', $ndata )."%' ");
				$l_wejsc = mysqli_num_rows($sql1); 
					
				$sql2 = mysqli_query($db, "SELECT * FROM RejestrWy WHERE IdPracownika=".$idpracownika." AND godz_WY LIKE '".date( 'Y-m-d', $ndata )."%' ");
				$l_wyjsc = mysqli_num_rows($sql2);
					
				if($l_wejsc > 0) { 
					echo "Wejścia : ".$l_wejsc."</BR>";
					$we_tab[$l_wejsc-1]=array();
					$wy_tab[$l_wyjsc-1]=array();
					$z=0;
					$smin = 0;
					$ssec = 0;
					$sh =0;
					$smin2 = 0;
					$ssec2 = 0;
					$sh2 =0;
					$godziny = 0;
					while($r = mysqli_fetch_assoc($sql1)){
						$we = strtotime($r['godz_WE']);
						$we_tab[$z] = date('H:i:s', $we );
						echo $we_tab[$z]."</BR>";
						$z++;
					}
					echo "Wyjścia : ".$l_wyjsc."</BR>";
					$z = 0;
					while($r = mysqli_fetch_assoc($sql2)){ 
						$wy = strtotime($r['godz_WY']);
						$wy_tab[$z] = date('H:i:s', $wy );
						echo $wy_tab[$z]."</BR>";
						$z++;
					}
					for($z=0;$z<($l_wejsc);$z++){ 
						$we = (strtotime($we_tab[$z]));
						$wy = (strtotime($wy_tab[$z]));
						//GODZINY PRACY
						$roznica = (strtotime($wy_tab[$z]) - strtotime($we_tab[$z]));
						$min = floor($roznica / 60);
						$sec = $roznica-($min*60);
						$h = floor($min/60);
						$min = $min-($h*60);
						//SUMA
						$smin += $min;
						$ssec += $sec;
						$sh += $h;
								
						if ( (date( 'H', $we )) < 8 ){ 
							$we_tab[$z] = "08:00:00";
						}						
						if ( (date( 'H', $wy )) >= 16){ 
							$wy_tab[$z] = "16:00:00";
						};
						//PŁATNE GODZINY
						if ( (date( 'H', $we )) < 16){ 
							$roznica2 = (strtotime($wy_tab[$z]) - strtotime($we_tab[$z]));
							$min2 = floor($roznica2 / 60);
							$sec2 = $roznica2-($min2*60);
							$h2 = floor($min2/60);
							$min2 = $min2-($h2*60);
							$godziny += $h2;					
						}
						
					}
					echo "Czas pracy: ".$sh." godzin ".$smin." minut ".$ssec." sekund</BR>";
				}
					
				// Brak aktualizacji do bazy danych ze względu na brak podliczania wynagrodzenia,
				// które będzie obliczane w nsatępnym sprincie.
				$zarobek = $godziny * $last['Stawka'];
				echo "<font color='grey'> <B>Godziny płatne: ".$godziny." </B> Szacowany zarobek: <B>".$zarobek."</B></font></BR>"; 
				$sh = 0;
				$smin = 0;
				$ssec = 0;
				$podsum[$j-1][0] = $pracownik;
				$podsum[$j-1][1] += $l_wejsc;
				$podsum[$j-1][2] += $l_wyjsc;
				$podsum[$j-1][3] += $godziny;
				$podsum[$j-1][4] += $zarobek;
		
			}
			//KONIEC PETLI SPRAWDZAJACEJ KOLEJNO WSZYSTKICH PRACOWNIKOW
			echo "</BR>";
		}
		//KONIEC PETLI SPRAWDZAJACEJ KOLEJNO DNI MIESIACA
		//TABLEA PODSUMOWUJĄCA: ID PRACOWNIKA, LICZBA WE, LICZBA WY.
		echo "<HR>";
		for($i=0;$i<=0;$i++){
			for ($j=0;$j<=4;$j++){
				switch($j){
					case 0:
						echo "<font color='red'> Pracownik : ";
						break;
					case 1:
						echo "<BR><font color='navy'> Wejść : ";
						break;
					case 2:
						echo "<font color='navy'>  / Wyjść : ";
						break;	
					case 3:
						echo "<BR><font color='grey' >Godziny: ";
						break;
					case 4:
						echo "<font color='grey' > = Zarobek: ";
						break;
				}
				echo "<B>".$podsum[$i][$j]."</B></font>";
			}
			echo "</BR></BR>";
		}
	}
}
?>
