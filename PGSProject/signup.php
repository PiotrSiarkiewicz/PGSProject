<?php

	session_start();

	//checking if you are logged in
    if ((isset($_SESSION['log_in'])) && ($_SESSION['log_in']==true))
    {
        header('Location: home.php');
        exit();
    }

	if(isset($_POST['email']))
	{

		$everythig_OK=true;
		

		$nick = $_POST['nick'];
		
		//checking login
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
		
		
		//Checking email
		$email=$_POST['email'];
		$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if(filter_var($emailB,FILTER_VALIDATE_EMAIL)==false || $emailB!=$email)
		{
			$everythig_OK=false;
			$_SESSION['e_email']="Must be a valid email address";
		}
		
		//checking passwords
		$pass1 = $_POST['pass1'];
		$pass2 = $_POST['pass2'];
		echo strlen($pass1);
		if(strlen($pass1)<8 || strlen($pass1)>20)
		{
			$everythig_OK=false;
			$_SESSION['e_pass']="Password must be between 8 and 20 characters lon";
		}
		
		if($pass1!=$pass2)
		{
			$everythig_OK==false;
			$_SESSION['e_pass']="Passwod must match";
		}
		
		$pass_hash = password_hash($pass1, PASSWORD_DEFAULT);   //Making hash password for better safety

        $name = $_POST['name'];
        $name = preg_replace("/[^A-Za-z]/",'',$name);  //Deleting non eng letters and numbers
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
		mysqli_report(MYSQLI_REPORT_STRICT);

		//
		try
		{
			$connection = new mysqli($host, $db_user, $db_password, $db_name);
			if ($connection->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}

			//checking if email is available
			else
			{

				$result = $connection->query("SELECT * FROM users WHERE email='$email'");
				
				if(!$result) throw new Exception($connection->error);
				
				$mail_amount = $result->num_rows;

				if($mail_amount>0)
				{

					$everythig_OK==false;
					$_SESSION['e_email']="Account with this email already exist!";
				}
				
				
				//Checking if login is available
				$result = $connection->query("SELECT * FROM users WHERE login='$nick'");
				
				if(!$result) throw new Exception($connection->error);
				
				$users_amount= $result->num_rows;

				if($users_amount>0)
				{
					$everythig_OK=false;
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
    <link href="Content/bootstrap.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href="Content/site.css" rel="stylesheet" />

    <style>
	.error
	{
		color:red;
		margin-top: 10px;
		margin-bottom: 10px;
	}
	</style>
	
</head>

<body class="card--logo">
<div class="container">
    <header class="row ">
        <br><br><br><br><br><br><br><br><br><br>

    </header>
    <main class="row">
        <div class="col-md-6 card--white">
            <div class="container-fluid">
                <form method="post">

                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="nickname" >Nickname:</label>

                            <input  type="text" class="form-control" id="nickname" name="nick"<?php
                            //checking if good nickname was set and not deleting it from text lable
                            if(isset($nick) && !isset($_SESSION['e_nick']))
                            {
                                echo 'value='.$nick.'></input>';
                            }else
                                echo 'placeholder="Nickname:"></input>';
                            ?>

                        </div>
                    </div>


                    <?php
                    if(isset($_SESSION['e_nick']))
                    {
                        echo '<div class= "error">'. $_SESSION['e_nick'].'</div>';
                        unset($_SESSION['e_nick']);
                    }
                    ?>

                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="mail" >E-mail:</label>
                            <input  type="text" class="form-control" id="mail" name="email"
                            <?php
                            //checking if good email was set and not deleting it from text lable
                                if(isset($email) && !isset($_SESSION['e_email']))
                                {
                                   echo 'value='.$email.'></input>';
                                }else
                                echo 'placeholder="E-mail"></input>';
                            ?>

                        </div>
                    </div>


                    <?php
                    if(isset($_SESSION['e_email']))
                    {
                        echo '<div class= "error">'. $_SESSION['e_email'].'</div>';
                        unset($_SESSION['e_email']);
                    }
                    ?>

                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="pass" >Password:</label>
                            <input  type="password" class="form-control" id="pass" name="pass1" placeholder="Password:"></input>
                        </div>
                    </div>


                    <?php
                    if(isset($_SESSION['e_pass']))
                    {
                        echo '<div class= "error">'. $_SESSION['e_pass'].'</div>';
                        unset($_SESSION['e_pass']);
                    }
                    ?>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="pass2" >Confirm Password:</label>
                            <input  type="password" class="form-control" id="pass2" name="pass2" placeholder="Confirm Password:"></input>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="name" >Name:</label>

                            <input  type="text" class="form-control" id="name" name="name"
                            <?php
                            //checking if good name was set and not deleting it from text lable
                            if(isset($name) && !isset($_SESSION['e_name']))
                            {
                                echo 'value='.$name.'></input>';
                            }else
                                echo 'placeholder="Name:"></input>';
                            ?>

                        </div>
                    </div>

                    <?php
                    if(isset($_SESSION['e_name']))
                    {
                        echo '<div class= "error">'. $_SESSION['e_name'].'</div>';
                        unset($_SESSION['e_name']);
                    }
                    ?>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="surname" >Surname:</label>
                            <input  type="text" class="form-control" id="surname" name="surname"
                            <?php
                            //checking if good surname was set and not deleting it from text lable
                            if(isset($surname) && !isset($_SESSION['e_surname']))
                            {
                                echo 'value='.$surname.'></input>';
                            }else
                                echo 'placeholder="Surname:"></input>';
                            ?>

                        </div>
                    </div>

                    <?php
                    if(isset($_SESSION['e_surname']))
                    {
                        echo '<div class= "error">'. $_SESSION['e_surname'].'</div>';
                        unset($_SESSION['e_surname']);
                    }
                    ?>

                    <input type="submit" class="btn btn-primary" value="Sign up">
                </form>
                <br/>
                <form action="index.php">
                    <input type="submit" class="btn btn-primary" value="Back">
                </form>
            </div>

        </div>

    </main>
</div>



</body>
</html>