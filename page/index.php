<?php
if (!isset($_SESSION['id'])){
	header("Location: ?action=home");
}
else{
	require('header.php');
	if(in_array($action, $page)){
			require($action.'.php');
	}
	else{
		require('../error.php');
	} 
	require('footer.php');
}
?>