

<?php
	session_start();
	require_once "connect.php";
	
	$connection = @new mysqli($host,$db_user,$db_password,$db_name);
	$idsurvey=$_SESSION['idsurvey'];

	$result = @$connection->query(sprintf("DELETE FROM surveys WHERE idsurvey=$idsurvey"));
//	$connection->query($delete_survey);
	
	$result= @$connection->query(sprintf("DELETE FROM questions WHERE idsurvey=$idsurvey"));
//	$connection->query($delete_question);
	
	$result=@$connection->query(sprintf("DELETE FROM answeres WHERE idsurvey=$idsurvey"));
//	$connection->query($delete_answeres);

   // $result=@$connection->query(sprintf("DELETE FROM answeres WHERE idsurvey=$idsurvey"));

	unset($_SESSION['survey']);
	unset($_SESSION['idsurvey']);
    unset($_SESSION['status']);
    unset($_SESSION['question']);
    unset($_SESSION['idquestion']);
    unset($_SESSION['answere']);
    unset($_SESSION['error']);

	header('Location: home.php');
	
?>