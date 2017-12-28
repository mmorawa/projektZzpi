<CENTER.<h3><center>Zwolnij pracownika</h3> 
<form action="?a=zwolnij" method="post"> 
<table> 
<tr><td>ID:</td><td><input type="text" name="id"></td></tr> 
<tr><td><input type="submit" name='zwolnij' value="Zwolnij"></td></tr> 
</table> </form> 
</center>
<br><br>
<center>
<table border="1">
<tr>
<td align ="center" colspan="6"><b>Pracownicy
</tr>
<tr>
<td align="center"><b>Id</b</td>
<td align="center"><b>Nazwisko</b></td>
<td align="center"><b>Imię</b></td>
<td align="center"><b>Stanowisko</b></td>
</tr>
<?php
$pracownicy = mysqli_query($db, "SELECT * FROM Pracownicy WHERE IdStanowiska NOT IN (1)");
$liczbapracownikow = mysqli_num_rows($pracownicy);

while($wynik = mysqli_fetch_array($pracownicy)) {
		$stanowisko = mysqli_fetch_array(mysqli_query($db, "SELECT Nazwa FROM Stanowisko WHERE Id=".$wynik['IdStanowiska'].""));
		$stanowisko = $stanowisko[0];
		echo "<tr>
				<td>".$wynik['Id']."</td>
				<td>".$wynik['Nazwisko']."</td>
				<td>".$wynik['Imie']."</td>
				<td>".$stanowisko."</td>
			</tr>";
		}
echo "</table>";


if(isset($_POST["zwolnij"])){
	$id = $_POST["id"];
	if ( $id > 1){ 
		$zapytanie="DELETE from RejestrWe WHERE IdPracownika='$id'"; 
		$wykonaj = mysqli_query($db,$zapytanie);
		$zapytanie="DELETE from RejestrWy WHERE IdPracownika='$id'"; 
		$wykonaj = mysqli_query($db,$zapytanie);
		$zapytanie="DELETE from WebSiteUsers WHERE IdPracownika='$id'"; 
		$wykonaj = mysqli_query($db,$zapytanie);
		$zapytanie="DELETE from ZestawienieDzienne WHERE IdPracownika='$id'"; 
		$wykonaj = mysqli_query($db,$zapytanie);
		$zapytanie="DELETE from ZestawienieMiesieczne WHERE IdPracownika='$id'"; 
		$wykonaj = mysqli_query($db,$zapytanie);
		$zapytanie="DELETE from Pracownicy WHERE Id='$id'"; 
		$wykonaj = mysqli_query($db,$zapytanie);
	}
	else{
		echo "Nie można zwolnić głównego kierownika!";
	}
}
?>