<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ZPI</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="./style/page.css" type="text/css" />
<script type="text/javascript"  src="../script/script.js" > </script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
</head>
<body onload='zegar()'>

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
	<div id="content">
	<div id="nav">
	<dl>
	<dt>MENU</dt>
	<dd><a href="?a=start">Strona główna</a></dd>
	<dd><a href="?a=nazakladzie">Rejestr wejścia/wyjścia</a></dd>
	<dd><a href='?a=podsumowanie'>Podsumowanie</a></dd>
	
	<?php
	// menu dla kierownikensa
	if ($idstanowiska == 1){
		$ostatnie = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM ZestawienieMiesieczne ORDER BY id DESC LIMIT 1"));
		$data = $ostatnie['DataPodsumowania'];
		$data = strtotime( $data );
	
		if (date('m-Y',$data)!=date('m-Y')){		
			echo "<dd><a href='?a=wynagrodzenie' >! Wynagrodzenie !</a></dd>";
		}
		echo "<dd><a href='?a=zatrudnij'>Zatrudnij pracownika</a></dd>";
		echo "<dd><a href='?a=zwolnij'>Zwolnij pracownika</a></dd>";
	}
	
	?>
	<?php
	// menu dla ksiegowego
	if ($idstanowiska == 2){
		$ostatnie = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM ZestawienieMiesieczne ORDER BY id DESC LIMIT 1"));
		$data = $ostatnie['DataPodsumowania'];
		$data = strtotime( $data );
		if (date('m-Y',$data)!=date('m-Y')){		
			echo "<dd><a href='?a=wynagrodzenie' >! Wynagrodzenie !</a></dd>";
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
		echo "<dd><a href='?a=zatrudnij'>Zatrudnij pracownika</a></dd>";
		echo "<dd><a href='?a=zwolnij'>Zwolnij pracownika</a></dd>";
		
	}
	?>
	</dl>
	<BR>
	<BR>
	<dl>
	<dd><a href='?a=opcje'>Opcje konta</a></dd>
	</dl>
	<dl>
	<dd><a href="?a=logout"> Wyloguj </a></dd>
	</dl>
	</div>
	<div id="page">