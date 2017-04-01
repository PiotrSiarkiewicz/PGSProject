<?php

	session_start();
	
	if(isset($_POST['email']))
	{

		$everythig_OK=true;
		

		$nick = $_POST['nick'];
		
		//checking lenght login
		if(strlen($nick)<3 || strlen($nick)>20)
		{
			$everythig_OK=false;
			$_SESSION['e_nick']="Login must be between 3 and 20 characters long";
		}
		
		if(ctype_alnum($nick)==false)
		{
			$everythig_OK=false;
			$_SESSION['e_nick']="Login must contain only letters and numbers";
		}
		
		
		//Sprawdzenie poprawnosci email
		$email=$_POST['email'];
		$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if(filter_var($emailB,FILTER_VALIDATE_EMAIL)==false || $emailB!=$email)
		{
			$everythig_OK=false;
			$_SESSION['e_email']="Must be a valid email address";
		}
		
		//Sprawdzenie poprawnosci hasła
		$pass1 = $_POST['pass1'];
		$pass2 = $_POST['pass2'];
		
		if(strlen($pass1)<8 || strlen($pass1)>20)
		{
			$everythig_OK==false;
			$_SESSION['e_pass']="Password must be between 8 and 20 characters lon";
		}
		
		if($pass1!=$pass2)
		{
			$everythig_OK==false;
			$_SESSION['e_pass']="Passwod must match";
		}
		
		$pass_hash = password_hash($pass1, PASSWORD_DEFAULT);

        $name = $_POST['name'];
        $name = preg_replace("/[^A-Za-z]/",'',$name);
        if($name=='')
        {
            $everythig_OK==false;
            $_SESSION['e_name']="Please enter your Name!";
        }

        $surname = $_POST['surname'];

        $surname = preg_replace("/[^A-Za-z]/",'',$surname);
        if($surname=='')
        {
            $everythig_OK==false;
            $_SESSION['e_surname']="Please enter your Name!";
        }




        require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT); //zamiast WARNING beda exception
		
		try
		{
			$connection = new mysqli($host, $db_user, $db_password, $db_name);
			if ($connection->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				echo $email;
				$result = $connection->query("SELECT iduser FROM users WHERE email='$email'");
				
				if(!$result) throw new Exception($connection->error);
				
				$mail_amount = $result->num_rows;
				if($mail_amount>0)
				{
					echo $mail_amount."<br/>";
					$everythig_OK==false;
					$_SESSION['e_email']="Account with this email already exist!";
				}
				
				
				//Czy nick jest zarezerwowany
				$result = $connection->query("SELECT iduser FROM users WHERE login='$nick'");
				
				if(!$result) throw new Exception($connection->error);
				
				$users_amount= $result->num_rows;
				if($users_amount>0)
				{
					$everythig_OK==false;
					$_SESSION['e_nick']="Account wtih this login already exist!";
				}
				
				if($everythig_OK==true)
				{
					//Adding user to base
					
					if($connection->query("INSERT INTO users VALUES(NULL,'$nick','$pass_hash','$email','$name','$surname')"))
					{
						$_SESSION['success']=true;
						header('Location: index.php');
					}
					else
					{
							throw new Exception($connection->error);
					}
				}
				
				$connection->close();
			}
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Server Error! Please try again later!</span>';
			echo $e;
			
		}		
	}
	


?>

<!DOCTYPE HTML>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Survey</title>

	
	<style>
	.error
	{
		color:red;
		margin-top: 10px;
		margin-bottom: 10px;
	}
	</style>
	
</head>

<body>
		<form method="post">
			Nickname <br/> <input type="text" name="nick"/> <br/>
			
			<?php
				if(isset($_SESSION['e_nick']))
				{
					echo '<div class= "error">'. $_SESSION['e_nick'].'</div>';
					unset($_SESSION['e_nick']);
				}
			?>
			
			E-mail: <br/> <input type="text" name="email"/> <br/>
			
			<?php
				if(isset($_SESSION['e_email']))
				{
					echo '<div class= "error">'. $_SESSION['e_email'].'</div>';
					unset($_SESSION['e_email']);
				}
			?>
			
			Password: <br/> <input type="password" name="pass1"/> <br/>
			<?php
				if(isset($_SESSION['e_pass']))
				{
					echo '<div class= "error">'. $_SESSION['e_pass'].'</div>';
					unset($_SESSION['e_pass']);
				}
			?>
			
			Confirm Passwod: <br/> <input type="password" name="pass2"/> <br/>

            Name: <br/> <input type="text" name="name"/><br/>
            <?php
            if(isset($_SESSION['e_name']))
            {
                echo '<div class= "error">'. $_SESSION['e_name'].'</div>';
                unset($_SESSION['e_name']);
            }
            ?>

            Surname <br/><input type="text" name="surname"/><br/>
            <?php
            if(isset($_SESSION['e_surname']))
            {
                echo '<div class= "error">'. $_SESSION['e_surname'].'</div>';
                unset($_SESSION['e_surname']);
            }
            ?>

			<input type="submit" value="Sign up">
			
		</form>

</body>
</html>