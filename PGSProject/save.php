<?php
	session_start();	
	require_once "connect.php";

	$connection = @new mysqli($host,$db_user,$db_password,$db_name);
	$idsurvey= $_SESSION['idsurvey'];
	$iduser = $_SESSION['iduser'];
	$_SESSION['title']="UPDATE surveys SET status='complete' where idsurvey=$idsurvey";
    $_SESSION['title']="INSERT INTO access VALUE (NULL,$iduser,$idsurvey,'rw')";
	$connection->query($_SESSION['title']);


    unset($_SESSION['survey']);
    unset($_SESSION['idsurvey']);
    unset($_SESSION['status']);
    unset($_SESSION['question']);
    unset($_SESSION['idquestion']);
    unset($_SESSION['idanswere']);
    unset($_SESSION['answere']);

	header("Location: home.php");
?>