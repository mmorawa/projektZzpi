<div id="tables">
	<div id="left">
	<table border="1" cellspacing="1" cellpadding="5">
	<tr>
	<td align ="center" colspan="6"><b>Godziny wejścia
	</tr>
	<tr>
	<td align="center"><b>Nazwisko</b></td>
	<td align="center"><b>Imię</b></td>
	<td align="center"><b>Godzina wejścia</b></td>
	</tr>
	<?php
	$godz_we = mysqli_query($db, "SELECT Pracownicy.Nazwisko, Pracownicy.Imie, RejestrWe.godz_WE FROM Pracownicy INNER JOIN RejestrWe ON Pracownicy.Id = RejestrWe.IdPracownika ORDER BY RejestrWe.godz_WE");
	while($wynik = mysqli_fetch_array($godz_we)) {
			echo "
				<tr>
					<td>".$wynik['Nazwisko']."</td>
					<td>".$wynik['Imie']."</td>
					<td>".$wynik['godz_WE']."</td>
				</tr>";
			}
		echo "</table>";

	?>
	</div>
	<div id="middle">
	<table border="1" cellspacing="1" cellpadding="5">
	<tr>
	<td align ="center" colspan="6"><b>Godziny wyjścia
	</tr>
	<tr>
	<td align="center"><b>Nazwisko</b></td>
	<td align="center"><b>Imię</b></td>
	<td align="center"><b>Godzina wyjścia</b></td>
	</tr>
	<?php
	$godz_wy = mysqli_query($db, "SELECT Pracownicy.Nazwisko, Pracownicy.Imie, RejestrWy.godz_WY FROM Pracownicy INNER JOIN RejestrWy ON Pracownicy.Id = RejestrWy.IdPracownika ORDER BY RejestrWy.godz_WY");
	while($wynik = mysqli_fetch_array($godz_wy)) {
			echo "
				<tr>
					<td>".$wynik['Nazwisko']."</td>
					<td>".$wynik['Imie']."</td>
					<td>".$wynik['godz_WY']."</td>
				</tr>";
			}
		echo "</table>";
	?>
	</div>
	<div id="right">
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
	</div>
</div>
<div style="clear:both"></div>
