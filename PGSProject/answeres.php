<?php

	session_start();	
	require_once "connect.php";


	$connection = @new mysqli($host,$db_user,$db_password,$db_name);
	$answere=$_POST['answere'];
	$_SESSION['answere']=$answere;
	$idsurvey=$_SESSION['idsurvey'];
	$idquestion = $_SESSION['idquestion'];
	echo $idquestion;
	
		if($connection -> connect_errno!=0)
		{
			echo "Error: ".$connection->connect_errno;
		}else{

			if($rezultat = @$connection->query(sprintf("SELECT * FROM questions WHERE idquestion=$idquestion"))){
				
				echo "cos";
				$put = "INSERT INTO answeres VALUE(NULL, $idquestion, '$answere' ,$idsurvey,'')";  //typy nie zrobiony jeszcze ostatnia wartość
				$rezultat = @$connection->query(sprintf("SELECT * FROM answeres WHERE text='$answere'"));
				$answere_tab = $rezultat->fetch_assoc();
				$_SESSION['idanswere'] = $answere_tab['idanswere'];

				if ($connection->query($put) === FALSE) {
					echo "Error: " . $put . "<br>" . $connection->error;
				}else{
					$rezultat->close();
					$connection->close();
					header("Location: creation.php");
				}	
				echo "aja";
			}
			echo "ko";
		}
	
?>