<?php

	session_start();	
	require_once "connect.php";


	$connection = @new mysqli($host,$db_user,$db_password,$db_name);
	$question=$_POST['question'];
	$_SESSION['question']=$question;
	$idsurvey = $_SESSION['idsurvey'];

    if(isset($_SESSION['idquestion']))
    {
        $idquestion = $_SESSION['idquestion'];
    }

    if($question=='')
    {
        $_SESSION['e_quesname']='<span style="color:red">Please insert question text</span>'; //create text for error
        header('Location: creation.php');  //return to creation.php
    }else {

        if ($connection->connect_errno != 0) {
            echo "Error: " . $connection->connect_errno;
        } else {

            if(isset($_POST['quesprev']))
            {
                $rezultat = @$connection->query(sprintf("SELECT * FROM questions WHERE idsurvey ='$idsurvey' AND idquestion<'$idquestion' ORDER  by idquestion DESC Limit 1 "));
                if($rezultat->num_rows>0) {
                    $questions_tab = $rezultat->fetch_assoc();
                    $_SESSION['idquestion'] = $questions_tab['idquestion'];
                    $_SESSION['question'] = $questions_tab['text'];
                    unset($_SESSION['e_quesprev']);
                }
                else
                    $_SESSION['e_quesprev']='<span style="color:red">This is First question</span>';
                 unset($_SESSION['e_quesnext']);

            }

            if(isset($_POST['quesnext'])) {
                $rezultat = @$connection->query(sprintf("SELECT * FROM questions WHERE idsurvey ='$idsurvey' AND idquestion>'$idquestion' ORDER by idquestion Limit 1 "));
                if($rezultat->num_rows>0) {
                    $questions_tab = $rezultat->fetch_assoc();
                    $_SESSION['idquestion'] = $questions_tab['idquestion'];
                    $_SESSION['question']=$questions_tab['text'];
                    unset($_SESSION['e_quesnext']);

                }
                else
                    $_SESSION['e_quesnext']='<span style="color:red">This is last question</span>';
                    unset($_SESSION['e_quesprev']);

            }

            if (isset($_POST['queschange'])) {
                $connection->query(sprintf("UPDATE questions SET text='$question' WHERE idquestion='$idquestion'"));
            }


            if ($rezultat = @$connection->query(sprintf("SELECT * FROM surveys WHERE idsurvey=$idsurvey")) && !isset($_POST['queschange']) && !isset($_POST['quesprev']) && !isset($_POST['quesnext'])) {
                $connection->query(sprintf("INSERT INTO questions VALUE(NULL, $idsurvey, '$question' )"));
                $rezultat = @$connection->query(sprintf("SELECT * FROM questions WHERE idsurvey ='$idsurvey' AND text='$question'"));
                $questions_tab = $rezultat->fetch_assoc();
                $_SESSION['idquestion'] = $questions_tab['idquestion'];
                $rezultat->close();
                $connection->close();
            }


            if (isset($_POST['quesdelete']) && isset($_SESSION['idquestion'])) {
                $result = $connection->query(sprintf("DELETE FROM questions WHERE idquestion=$idquestion"));
                $result = $connection->query(sprintf("DELETE FROM answeres WHERE idquestion=$idquestion"));
                unset($_SESSION['idquestion']);
                unset($_SESSION['question']);

            }

            unset($_SESSION['e_ques']);
            header("Location: creation.php");
        }
    }

?>