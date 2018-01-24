<div >
<center>
<table border="1" cellspacing="1" cellpadding="5">
<tr>
<td align ="center" colspan="6"><b>Obecni na zakładzie
</tr>
<tr>
<td align="center"><b>Nazwisko</b></td>
<td align="center"><b>Imię</b></td>
</tr>
<?php
$kto = mysqli_query($db, "SELECT Imie, Nazwisko FROM Pracownicy WHERE NaZakladzie=1 ");
while($wynik = mysqli_fetch_array($kto)) {
	echo "
		<tr>
		<td>".$wynik['Nazwisko']."</td>
		<td>".$wynik['Imie']."</td>
		</tr>";
	}
echo "</table>";
?>
</center>
</div>
