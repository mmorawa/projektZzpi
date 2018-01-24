<CENTER>Informacje o zatrudnianym pracowniku:
<form action='?a=zatrudnij' method='post'>
	<table>
			<tr>
			<td>
			Stanowisko :
			</td>
			<td>
				<select name='idstanowiska'>
				<?php
					$wynik = mysqli_query($db, "SELECT * FROM Stanowisko");
					if(mysqli_num_rows($wynik) > 0) { 
						while($r = mysqli_fetch_array($wynik)) { 
							echo "<option name='idstanowiska' value=".$r[0]." >".$r[1]."</option>";
						}
					} 		
				?>
				</select>
			</td>
		</tr>
		</tr>
			<tr>
			<td>
			Identyfikator karty:
			</td>
			<td>
				<select name='idkarty'>
				<?php
					$wynik = mysqli_query($db, "SELECT * FROM Karty WHERE IdKarty NOT IN (SELECT IdKarty FROM Pracownicy);");
					if(mysqli_num_rows($wynik) > 0) { 
						while($r = mysqli_fetch_array($wynik)) { 
							echo "<option>".$r[1]."</option>";
						}
					} 		
				?>
				</select>
			</td>
		</tr>
		<tr>
			<td>
				Nazwisko:
			</td>
			<td>
				<input type='text' style='width:200px' name='nazwisko' />
			</td>
		</tr>
		<tr>
			<td>
				Imię:
			</td>
			<td>
				<input type='text' style='width:200px' name='imie'  />
			</td>
		</tr>
		<tr>
			<td>
				Miejscowość:
			</td>
			<td>
				<input type='text' style='width:200px' name='miejscowosc' />
			</td>
		</tr>
		<tr>
			<td>
				Ulica:
			</td>
			<td>
				<input type='text' style='width:200px' name='ulica'  />
			</td>
		</tr>
			<tr>
			<td>
			Numer budynku:
			</td>
			<td>
			<input type='number' style='width:200px' name='nrdomu' min="1" pattern= '[0-9]{3}' />
			<td>
		</tr>
		<tr>
			<td>
				Numer Mieszkania:
			</td>
			<td>
				<input type='number' style='width:200px' name='nrmieszkania'  min="1" pattern= '[0-9]{2}'/>
			</td>
		</tr>
		<tr>
			<td>
				Kod Pocztowy:
			</td>
			<td>
				<input type='text' style='width:200px' name='kodpocztowy' placeholder=' Podaj kod pocztowy' pattern= '[0-9]{2}-[0-9]{3}' />
			</td>
		</tr>
			<tr>
			<td>
				Stawka Wynagrodzenia:
			</td>
			<td>
				<input type='number' style='width:200px' name='stawka' min="12"/>
			</td>
		</tr>
		<tr>
			<td>
			</td>
			<td>
			</td>
		</tr>
			<tr>
			<td>
			</td>
			<td>
			</td>
		</tr>
		<tr>
			<td colspan="2" >  <CENTER>
				Konto zakładowe:
				</CENTER>
			</td>
		</tr>
		<tr>
			<td>
			Login:
			</td>
			<td>
			<input type='text' style='width:200px' name='login' maxlength='15' />
			<td>
		</tr>
		<tr> 
			<td>
				Hasło:
			</td>
			<td>
				<input type='password' style='width:200px' name='password' />
			</td>
		</tr>
		<tr>
			<td>
				E-mail:
			</td>
			<td>
				<input type='email' style='width:200px' name='email'  />
			</td>
		</tr>
		<tr>
			<td>
			</td>
			<td>
				<input class='button' type='submit' style='width:100px' value='Zatrudnij'/>
			</td>
		</tr>
	</table>
</form></CENTER>
</html>



<?php
if(!empty($_POST)){
	if (empty($_POST['login']) || empty($_POST['password']) || empty($_POST['email']) || 
	empty($_POST['idkarty']) || empty($_POST['idstanowiska']) || empty($_POST['nazwisko']) ||
	empty($_POST['imie']) || empty($_POST['miejscowosc']) || empty($_POST['ulica']) || 
	empty($_POST['ulica']) || empty($_POST['nrdomu']) || empty($_POST['nrmieszkania']) || 
	empty($_POST['kodpocztowy']) || empty($_POST['stawka'] )) 
	echo '<CENTER>Uzupełnij wszystkie pola!</CENTER><BR>';
	else{
		$login = ($_POST['login']);
		$password = ($_POST['password']);
		$email = ($_POST['email']);
		
		$idkarty = $_POST['idkarty'];
		$idstanowiska =	($_POST['idstanowiska']);
		$nazwisko = $_POST['nazwisko'];
		$imie = $_POST['imie'];
		$miejscowosc = $_POST['miejscowosc'];
		$ulica	= $_POST['ulica'];
		$nrdomu	= $_POST['nrdomu'];
		$nrmieszkania = $_POST['nrmieszkania'];
		$kodpocztowy = $_POST['kodpocztowy'];
		$stawka	=	$_POST['stawka'];

		//sprawdzanie poprawności znaków
		if (! ctype_alnum($login) ) echo '<CENTER>Wprowadzono nieprawidłową nazwę użytkownika!</CENTER><BR>';
		else if (! filter_var($email,FILTER_VALIDATE_EMAIL) ) echo '<CENTER>Wprowadzono nieprawidłowy adres email!</CENTER><BR>!';
		else{ 
			// sprawdzanie czy dane istnieją
			$login2 = mysqli_query($db, "SELECT Login FROM WebSiteUsers WHERE Login='$login' ");
			$login2 = mysqli_fetch_assoc($login2);
			$email2 = mysqli_query($db,"SELECT Email FROM WebSiteUsers WHERE Email='$email' ");
			$email2 = mysqli_fetch_assoc($email2);
			//warunki jeżeli zajęty login lub email
		if (($login2['Login'])!='') echo '<CENTER>Nazwa użytkownika jest już zajęta!</CENTER><BR>';
		elseif (($email2['Email'])!='') echo '<CENTER>Wprowadzony adres E-mail jest już zajęty!</CENTER><BR>';
			else{
				// zakladanie konta
				$wynik = mysqli_query($db, "SELECT * FROM Karty WHERE IdKarty NOT IN (SELECT IdKarty FROM Pracownicy);");
				$wynik = mysqli_num_rows($wynik);
				if($wynik > 0){
					$password = md5($password);
					mysqli_query($db,"INSERT INTO Pracownicy (IdKarty, IdStanowiska, Nazwisko, Imie, Miejscowosc, Ulica, NrDomu, NrMieszkania, KodPocztowy, Stawka)VALUES ('$idkarty', $idstanowiska , '$nazwisko', '$imie', '$miejscowosc', '$ulica', '$nrdomu', '$nrmieszkania', '$kodpocztowy', '$stawka');");
					$idpracownika = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM Pracownicy ORDER BY id DESC LIMIT 1"));
					$idpracownika = $idpracownika['Id'];
					mysqli_query($db,"INSERT INTO WebSiteUsers (IdPracownika, Login,Haslo,Email) VALUES ('$idpracownika', '$login','$password','$email');");echo "<CENTER>Konto zostało pomyślnie założone!</CENTER>";
				}
				else{
					echo "Brak wolnych kart";
				}
			}
		}
	}
};
?>

