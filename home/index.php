<?php
require_once('home/header.php');
if(in_array($action, $home)){
	require($action.'.php');
} else{
	require('../error.php');
}
require_once('home/footer.php');
?>