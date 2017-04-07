<?php
	session_start();	
	require_once "connect.php";

    if ((!isset($_SESSION['log_in'])))
    {
        header('Location: index.php');
        exit();
    }

	if(!isset($_SESSION['status']))
	{
	    $iduser=$_SESSION['iduser'];
        $date = new DateTime();
		$connection = @new mysqli($host,$db_user,$db_password,$db_name);
        $result = @$connection->query(sprintf("INSERT INTO surveys VALUE (NULL,$iduser,'','in progress',now())"));
        $_SESSION['text']="";

		$result = @$connection->query(sprintf("SELECT * FROM surveys WHERE text='' AND iduser=$iduser"));
		
		$surveytab = $result ->fetch_assoc();
		$_SESSION['idsurvey']=$surveytab['idsurvey'];
		$_SESSION['status']=$surveytab['status'];
		
	}
?>

<!DOCTYPE HTML>

<html>
<head>
	<meta charset="utf-8"/>
	<meta http-equiv=" X-UA-Compatible" content= "IE=edge,chrome=1"/> 
	<title>Survey</title>
</head>


<body>
	

	<form action="name_survey.php" method="post">
		Write title of the survey:
		<input type="text" name="survey">
		<input type="submit" value="OK"> 
		<?php
            if(isset($_SESSION['survey'])&& !isset($_SESSION['error']))
            {
                echo "<b>".$_SESSION['survey']."</b>";
            }
            if(isset($_SESSION['error'])){
                echo $_SESSION['error'];
            }
        ?>
        <br/><br /></form>



    <?php
    if(isset($_SESSION['survey'])) {
        if ($_SESSION['survey'] != '') {
            echo '<form action="data.php" method="post">';
            echo "Write your question.";
            echo '<input type="text" name="question">';
            echo '<input type="Submit" value="Add new question">';
            if (isset($_SESSION['question'])) {
                echo "<b>" . $_SESSION['question'] . "</b>";
            }
            echo '</form>';
        }
    }
		?><br/>


    <?php
    if(isset($_SESSION['idquestion'])){

        if(isset($_SESSION['idanswer'])) {
            $idanswer=$_SESSION['idanswer'];
            $idquestion=$_SESSION['idquestion'];
            $connection = @new mysqli($host,$db_user,$db_password,$db_name);
            if(isset($_SESSION['num'])) {
                for ($j = 0; $j <= $_SESSION['num']; $j++) {
                    if (isset($_POST['answerupdate' . $j])) {
                        $answerupdate = $_POST['answerupdate' . $j];
                        $idanswer = $_SESSION['idanswer' . $j];
                        $connection->query(sprintf("UPDATE answeres SET text='$answerupdate' WHERE idanswer='$idanswer'"));  //typy nie zrobiony jeszcze ostatnia wartość
                        unset($_POST['answerupdate' . $j]);
                        unset($_SESSION['idanswer'.$j]);
                    }
                }
            }
            $rezultat = $connection->query(sprintf("SELECT * FROM answeres WHERE idquestion='$idquestion'"));
            $_SESSION['num'] = $rezultat->num_rows;
            echo "<ol>";
            $i=0;
            while ($answer = $rezultat->fetch_assoc()) {
                $i = $i + 1;
                echo '<form method="post">';
                $text = $answer['text'];
                echo "<li><input type='text' name='answerupdate".$i."' value='$text'>";
                echo '<input type="Submit" value="Change Answer"></form><br></li>';
                 $_SESSION['idanswer'.$i] = $answer['idanswer'];
            }
            echo "</ol>";
        }



        echo '<form action="answeres.php" method="post">';
        echo "Write answeres.";

        echo '<input type="text" name="answer">';
        echo '<input type="Submit" value="Add new answer"></form>';

    }
    ?><br/><br />

	<form action="save.php">
		<input type="submit" value="Submit">
	</form>
	
	<form action="delete.php"><input type="submit" value="Delete"></form>


</body>


</html>