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
	$pracownik = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM Pracownicy WHERE Id=".$_SESSION['id'].""));
	$imie = $pracownik['Imie'];
	$nazwisko = $pracownik['Nazwisko'];
	$idstanowiska = $pracownik['IdStanowiska'];
	$stanowisko = mysqli_fetch_array(mysqli_query($db, "SELECT Nazwa FROM Stanowisko WHERE Id=".$idstanowiska.""));
	$stanowisko = $stanowisko[0];
	echo "Zalogowano jako ".$imie." ".$nazwisko." na stanowisku ".$stanowisko;
	?>
	
	</div>
	<div id="nav">
	<a href="?a=start">Strona główna</a><BR><BR>
	<a href="?a=nazakladzie">Pracownicy na zakładzie</a><BR><BR>
	<?php
		// menu dla kierownika
	if ($idstanowiska == 1){
		$ostatnie = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM ZestawienieMiesieczne ORDER BY id DESC LIMIT 1"));
		$data = $ostatnie['DataPodsumowania'];
		$data = strtotime( $data );
		if (date('m-Y',$data)!=date('m-Y')){		
			echo "<a href='?a=wynagrodzenie' >! Wynagrodzenie !</a><BR><BR>";
		}
		echo "<a href='?a=zatrudnij'>Zatrudnij pracownika</a><BR><BR>";
		echo "<a href='?a=zwolnij'>Zwolnij pracownika</a><BR><BR>";
	}
	?>
	<?php
	// menu dla ksiegowego
	if ($idstanowiska == 2){
		$ostatnie = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM ZestawienieMiesieczne ORDER BY id DESC LIMIT 1"));
		$data = $ostatnie['DataPodsumowania'];
		$data = strtotime( $data );
		if (date('m-Y',$data)!=date('m-Y')){		
			echo "<a href='?a=wynagrodzenie' >! Wynagrodzenie !</a><BR><BR>";
		}
	
	}
	?>
	<?php
	// menu dla kadrowego
	if ($idstanowiska == 3){
		$ostatnie = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM ZestawienieMiesieczne ORDER BY id DESC LIMIT 1"));
		$data = $ostatnie['DataPodsumowania'];
		$data = strtotime( $data );
		if (date('m-Y',$data)!=date('m-Y')){		
		
		}
		echo "<a href='?a=zatrudnij'>Zatrudnij pracownika</a><BR><BR>";
		echo "<a href='?a=zwolnij'>Zwolnij pracownika</a><BR><BR>";
	}
	?>
	<BR>
	<BR>
	<a href="?a=logout"> Wyloguj </a>
	</div>
	<div id="page">
