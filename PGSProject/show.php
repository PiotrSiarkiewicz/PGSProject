<html>
<head>
</head>
<body>

	<form action="index.php" >
		<input type="submit" value="Page_Start"> 

	</form>
</body>
</html>

<?php
	session_start();
	require_once "connect.php";
	
	
	
	$connection = @new mysqli($host,$db_user,$db_password,$db_name);
	
	
	$rezultat = @$connection->query(sprintf("SELECT * FROM surveys order by idsurvey  LIMIT 1"));
	$surveytext=$rezultat->fetch_assoc();
	$idsurvey=$surveytext['idsurvey'];
	echo "<b>".$surveytext['text']."</b><br>";

	$rezultat = @$connection->query(sprintf("SELECT * FROM questions WHERE idsurvey=$idsurvey"));
	//$result =$connection->query($rezultat) or die($connection->error);
	$questiontext=$rezultat->fetch_assoc();
	//$number_questions=$rezultat->num_rows;
	$rezultat = @$connection->query(sprintf("SELECT * FROM questions Where idsurvey=$idsurvey order by idquestion desc LIMIT 1"));
	$maxidquestion = $rezultat->fetch_assoc();
	
	$rezultat = @$connection->query(sprintf("SELECT * FROM questions WHERE idsurvey=$idsurvey order by idquestion LIMIT 1"));
	$minidquestion= $rezultat->fetch_assoc();
	
	echo "<ol>";
	for($i=$minidquestion['idquestion']; $i<=$maxidquestion['idquestion']; $i++){
		$idquestion=$i;
		
		$rezultat = @$connection->query(sprintf("SELECT * FROM questions Where idquestion=$idquestion"));
		$questiontext=$rezultat->fetch_assoc();
		echo "<li>".$questiontext['text']."</li><br>";
		
		
		$rezultat = @$connection->query(sprintf("SELECT * FROM answeres WHERE idquestion=$idquestion"));
		$answeretext=$rezultat->fetch_assoc();
		$number_anweres=$rezultat->num_rows;
		//if($number_anweres>1){
			$rezultat = @$connection->query(sprintf("SELECT * FROM answeres Where idquestion=$idquestion order by idanswer desc LIMIT 1"));
			$maxidanswere = $rezultat->fetch_assoc();
			
			
			$rezultat = @$connection->query(sprintf("SELECT * FROM answeres WHERE idquestion=$idquestion order by idanswer LIMIT 1"));
			$minidanswere= $rezultat->fetch_assoc();
			echo "<ul>";
			for($j=$minidanswere['idanswer']; $j<=$maxidanswere['idanswer']; $j++){
				$idanswere=$j;
				
				$rezultat = @$connection->query(sprintf("SELECT * FROM answeres Where idanswer=$idanswere"));
				$answeretext=$rezultat->fetch_assoc();
				echo "<li><i>".$answeretext['text']."</i></li><br>";}
			echo "</ul>";
		//}
	} echo "</ol>";
	
	/*$idsurvey = $_SESSION['idsurvey'];

	if($exsurvey>0) //if survey with this title exist
	{
		$_SESSION['blad']='<span style="color:red">This name for survey is busy</span>'; //create text for error
		header('Location: creation.php');  //return to creation.php
	}else{

		$_SESSION['title'] = "UPDATE surveys SET text='$survey' WHERE idsurvey=$idsurvey";
		$connection->query($_SESSION['title']);
		unset($_SESSION['blad']);
		header('Location: creation.php');
		
	}*/
?>