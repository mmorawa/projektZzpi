<?php
$config['db']['host'] = 'localhost';
$config['db']['user'] = 'root';
$config['db']['pass'] = '';
$config['db']['dbname'] = 'zpi';
$db = mysqli_connect($config['db']['host'], $config['db']['user'], $config['db']['pass'] , $config['db']['dbname']) or die('Błąd połączenia z bazą') ;
mysqli_query($db, "SET NAMES 'utf8'") or die('Błąd kodowania nazwy');
?>