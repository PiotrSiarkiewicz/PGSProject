<?php
	session_start();
	require_once "connect.php";
	
	$connection = @new mysqli($host,$db_user,$db_password,$db_name);
	$_SESSION['survey']=$_POST['survey'];
	$survey=$_SESSION['survey'];
	$rezultat = @$connection->query(sprintf("SELECT * FROM surveys WHERE text='$survey'"));
	$exsurvey= $rezultat->num_rows;

	$idsurvey = $_SESSION['idsurvey'];

	if($exsurvey>0) //if survey with this title exist
	{
		$_SESSION['error']='<span style="color:red">This name for survey is busy</span>'; //create text for error
        header('Location: creation.php');  //return to creation.php
	}
	if($survey=='')
    {
        $_SESSION['error']='<span style="color:red">Please insert survey title</span>'; //create text for error
        header('Location: creation.php');  //return to creation.php
    }
    if($exsurvey==0 && $survey!=''){
        echo "cos";
		$result = @$connection->query(sprintf("UPDATE surveys SET text='$survey' WHERE idsurvey=$idsurvey")) ;

		unset($_SESSION['error']);
		header('Location: creation.php');
		
	}
?>