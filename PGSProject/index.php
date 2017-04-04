<?php

session_start();

if ((isset($_SESSION['log_in'])) && ($_SESSION['log_in']==true))
{
    header('Location: home.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login user</title>
    <link href="Content/bootstrap.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href="Content/site.css" rel="stylesheet" />

</head>
<body class="card--logo">

    <div class="container "  >
        <header class="row ">
            <br><br><br><br><br><br><br><br><br>

        </header>
        <main class="row">
            <div class="col-md-6 ">
                <div class="container-fluid card--white">
                    <form action="signin.php" method="post">
                       <div class="row">
                           <div class="col-md-12 form-group">
                               <label for="username" >Username:</label>
                               <input  type="text" class="form-control" id="username" name="user" placeholder="user"></input>
                           </div>
                       </div>
                       <div class="row">
                           <div class="col-md-12 form-group">
                               <label for="password" >Password:</label>
                               <input  type="password" class="form-control" id="password" name="pass" placeholder="pass"></input>
                           </div>

                       </div>
                       <div class="row">

                           <div class="col-md-12 form-group">
                               <button tFype="button" class="btn btn-primary">Login</button>
                               <?php
                               if(isset($_SESSION['error']))	echo $_SESSION['error'];
                               ?>
                           </div>
                       </div>
                    </form>
                    <form action="signup.php">
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <button tFype="button" class="btn btn-primary">Sign Up</button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </main>
    </div>




</body>
</html>
