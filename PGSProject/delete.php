

<?php
	session_start();
	require_once "connect.php";
	
	$connection = @new mysqli($host,$db_user,$db_password,$db_name);
	$idsurvey=$_SESSION['idsurvey'];

	$result = @$connection->query(sprintf("DELETE FROM surveys WHERE idsurvey=$idsurvey"));


	unset($_SESSION['survey']);
	unset($_SESSION['idsurvey']);
    unset($_SESSION['status']);
    unset($_SESSION['question']);
    unset($_SESSION['idquestion']);
    unset($_SESSION['answere']);
    unset($_SESSION['error']);

	header('Location: home.php');
	
?>