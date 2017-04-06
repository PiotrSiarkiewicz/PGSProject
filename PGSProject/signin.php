<?php

	session_start();
	
	if ((!isset($_POST['user'])) || (!isset($_POST['pass'])))
	{
		header('Location: index.php');
		exit();
	}

	require_once "connect.php";

	$connection = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if ($connection->connect_errno!=0)
	{
		echo "Error: ".$connection->connect_errno;
	}
	else
	{
		$login = $_POST['user'];
		$password = $_POST['pass'];

		echo $login."  i hasło ".$password;
		
		$login = htmlentities($login, ENT_QUOTES, "UTF-8");
	
		if ($result = @$connection->query(sprintf("SELECT * FROM users WHERE login='%s'",
		mysqli_real_escape_string($connection,$login)))) {
		    echo "Przesszło";
            $am_users = $result->num_rows;
            if ($am_users > 0) {

                $wiersz = $result->fetch_assoc();
                echo $password." i ".$wiersz['pass'];
                if (password_verify($password, $wiersz['pass'])) {
                    $_SESSION['log_in'] = true;
                    $_SESSION['iduser'] = $wiersz['iduser'];
                    $_SESSION['user'] = $wiersz['login'];


                    unset($_SESSION['error']);
                    $result->free_result();
                    header('Location: home.php');
                } else {

                    $_SESSION['error'] = '<span style="color:red">Invalid login or password!</span>';
                    header('Location: index.php');
                }

            } else {

                $_SESSION['error'] = '<span style="color:red">Invalid login or password!</span>';
                header('Location: index.php');

            }


            $connection->close();
        }
	}
	
?>