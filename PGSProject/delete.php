

<?php
	session_start();
	require_once "connect.php";
	
	$connection = @new mysqli($host,$db_user,$db_password,$db_name);
	$idsurvey=$_SESSION['idsurvey'];

	$delete_survey="DELETE FROM surveys WHERE idsurvey=$idsurvey";
	$connection->query($delete_survey);
	
	$delete_question="DELETE FROM questions WHERE idsurvey=$idsurvey";
	$connection->query($delete_question);
	
	$delete_answeres="DELETE FROM answeres WHERE idsurvey=$idsurvey";
	$connection->query($delete_answeres); 


	unset($_SESSION['survey']);
	unset($_SESSION['idsurvey']);
    unset($_SESSION['status']);
    unset($_SESSION['question']);
    unset($_SESSION['idquestion']);
    unset($_SESSION['answere']);

	header('Location: home.php');
	
?>