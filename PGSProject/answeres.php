<?php

	session_start();	
	require_once "connect.php";


	$connection = @new mysqli($host,$db_user,$db_password,$db_name);
	$idsurvey=$_SESSION['idsurvey'];
	$idquestion = $_SESSION['idquestion'];

	
		if($connection -> connect_errno!=0)
		{
			echo "Error: ".$connection->connect_errno;
		}else{

		    if(isset($_POST['answerupdate'])){
                $answer=$_POST['answerupdate'];
                $_SESSION['answer']=$answer;
                $idanswer = $_POST['idanswer'];

                $connection->query(sprintf( "UPDATE answeres SET text='$answer' WHERE idanswer='$idanswer'"));  //typy nie zrobiony jeszcze ostatnia wartość
                $rezultat = $connection->query(sprintf("SELECT * FROM answeres WHERE text='$answer' AND idquestion='$idquestion'"));
                $answer_tab = $rezultat->fetch_assoc();
                $_SESSION['idanswer'] = $answer_tab['idanswer'];
               // header("Location: creation.php");
            }
			if($rezultat = $connection->query(sprintf("SELECT * FROM questions WHERE idquestion='$idquestion'"))&& !isset($_POST['answerupdate'])){
                $answer=$_POST['answer'];
                $_SESSION['answer']=$answer;
                echo $answer;
				$connection->query(sprintf( "INSERT INTO answeres VALUE(NULL, $idquestion, '$answer' ,'')"));  //typy nie zrobiony jeszcze ostatnia wartość
				$rezultat = $connection->query(sprintf("SELECT * FROM answeres WHERE text='$answer' AND idquestion='$idquestion'"));
				$answer_tab = $rezultat->fetch_assoc();
				$_SESSION['idanswer'] = $answer_tab['idanswer'];
                header("Location: creation.php");
			}

		}
	
?>