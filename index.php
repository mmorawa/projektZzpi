<?php
//require_once('config/errors.php');
ob_start();
require_once('config/database.php');
session_start();

if(empty($_GET['a'])) $_GET['a'] = "home";
$action = $_GET['a'];

$home = array(
"home",
);

$page = array(
"start",
);

if(in_array($action, $page)){
	require_once('page/index.php');
}
elseif(in_array($action, $home)){
	require_once('home/index.php');
}
else{
	require_once('error.php');
}

ob_end_flush();
?>
