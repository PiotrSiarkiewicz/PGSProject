<?php
	session_start();	
	require_once "connect.php";
	if(!isset($_SESSION['status']))
	{
	    $iduser=$_SESSION['iduser'];
        $date = new DateTime();
		$connection = @new mysqli($host,$db_user,$db_password,$db_name);
        $result = @$connection->query(sprintf("INSERT INTO surveys VALUE (NULL,$iduser,'','in progress',now())"));
        $_SESSION['text']="";
		//$_SESSION['question']="INSERT INTO questions VALUE (NULL,'')";


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
		<?php  if(isset($_SESSION['survey']))
        {
            echo "<b>".$_SESSION['survey']."</b>";
        }?><br/><br />
	</form>



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
		?><br/><br />


    <?php
    if(isset($_SESSION['idquestion'])){
        echo '<form action="answeres.php" method="post">';
        echo "Write answeres..";
        echo '<input type="text" name="answer">';
        echo '<input type="Submit" value="Add new answer">';
        if(isset($_SESSION['answer'])){
            echo "<b>".$_SESSION['answer']."</b>";}
        echo '</form>';}
    ?><br/><br />

	<form action="save.php">
		<input type="submit" value="Submit">
	</form>
	
	<form action="delete.php"><input type="submit" value="Delete"></form>
<?php

	if(isset($_SESSION['error'])){
		echo $_SESSION['error'];
	}
?>

</body>


</html>