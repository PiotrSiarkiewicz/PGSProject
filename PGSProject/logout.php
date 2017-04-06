<?php

	session_start();
	unset($_SESSION['log_in']);
	session_unset();
	
	header('Location: index.php');

?>