<?php
require('header.php');
if(in_array($action, $page)){
		require($action.'.php');
}
else{
	require('../error.php');
}
require('footer.php');
?>