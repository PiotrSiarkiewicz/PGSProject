<?php

	session_start();	
	require_once "connect.php";


	$connection = @new mysqli($host,$db_user,$db_password,$db_name);
	$question=$_POST['question'];
	$_SESSION['question']=$question;
	$idsurvey = $_SESSION['idsurvey'];
		if($connection -> connect_errno!=0)
		{
			echo "Error: ".$connection->connect_errno;
		}else{

			if($rezultat = @$connection->query(sprintf("SELECT * FROM surveys WHERE idsurvey=$idsurvey"))){
				

				//$sql = "INSERT INTO questions VALUE(NULL, $idsurvey, '$question' )";
				$connection->query(sprintf("INSERT INTO questions VALUE(NULL, $idsurvey, '$question' )"));
				
				$rezultat = @$connection->query(sprintf("SELECT * FROM questions WHERE text='$question'"));
	
				$questions_tab = $rezultat->fetch_assoc();
				$_SESSION['idquestion'] = $questions_tab['idquestion'];


					$rezultat->close();
					$connection->close();
					header("Location: creation.php");
											
			}	
		}
	
?>