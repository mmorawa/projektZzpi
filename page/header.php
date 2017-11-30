<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ZPI</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="./style/style.css" type="text/css" />
</head>
<body>

<div id="all">
	<div id="header">
	<?php
	$pracownik = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM pracownicy WHERE IdPracownika=".$_SESSION['id'].""));
	$imie = $pracownik['Imie'];
	$nazwisko = $pracownik['Nazwisko'];
	$idstanowiska = $pracownik['IdStanowiska'];
	$stanowisko = mysqli_fetch_array(mysqli_query($db, "SELECT Nazwa FROM stanowisko WHERE IdStanowiska=".$idstanowiska.""));
	$stanowisko = $stanowisko[0];
	echo "Zalogowano jako ".$imie." ".$nazwisko." na stanowisku ".$stanowisko;
	?>
	</div>
	<div id="nav">
	<a href="?a=start"> Strona główna </a><BR>
	<BR>
	Tu pobierane po id stanowiska i odpowiednio do stanowiska opcje menu na if'ach/case wyświetlane/importowane.
	<BR>
	<?php
	if ($idstanowiska == 1){
		echo "np. menu prezesa: ";
		echo "<a href='?a=pracownicy&i=0'> Ludziki </a><BR>";
		echo "<a href='?a=stanowiska'> Stanowiska </a><BR>";
		echo "<a href='?a=dodaj'> Dodaj nowego pracownika </a><BR>";
	}
	?>
	<BR>
	<BR>
	
	
	
	
	<a href="?a=logout"> Wyloguj </a>
	</div>
	<div id="page">