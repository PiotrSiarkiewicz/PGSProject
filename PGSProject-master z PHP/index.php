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
    <link href="Content/Site.css" rel="stylesheet" />
</head>
<body class="card--logo">

    <div class="container "  >
        <header class="row ">
            <div class="col-md-1">
                <i id="icon" class="fa fa-check-square-o" style="text-shadow: rgb(7, 168, 168) 0px 0px 0px, rgb(7, 173, 173) 1px 1px 0px, rgb(7, 178, 178) 2px 2px 0px, rgb(8, 182, 182) 3px 3px 0px, rgb(8, 187, 187) 4px 4px 0px, rgb(8, 192, 192) 5px 5px 0px, rgb(8, 197, 197) 6px 6px 0px, rgb(8, 202, 202) 7px 7px 0px, rgb(9, 206, 206) 8px 8px 0px, rgb(9, 211, 211) 9px 9px 0px, rgb(9, 216, 216) 10px 10px 0px, rgb(9, 221, 221) 11px 11px 0px, rgb(9, 226, 226) 12px 12px 0px, rgb(10, 230, 230) 13px 13px 0px, rgb(10, 235, 235) 14px 14px 0px; font-size: 84px; color: rgb(255, 255, 255); height: 106px; width: 106px; line-height: 106px; border-radius: 0%; text-align: center; background-color: rgb(10, 240, 240);"></i>

            </div>
            <div class="col-md-1">
                <p id="icon" style="text-shadow: rgb(7, 168, 168) 0px 0px 0px, rgb(7, 177, 177) 1px 1px 0px, rgb(8, 186, 186) 2px 2px 0px, rgb(8, 195, 195) 3px 3px 0px, rgb(9, 204, 204) 4px 4px 0px, rgb(9, 213, 213) 5px 5px 0px, rgb(9, 222, 222) 6px 6px 0px, rgb(10, 231, 231) 7px 7px 0px; font-size: 20px; color: rgb(255, 255, 255); height: 108px; width: 108px; line-height: 108px; border-radius: 37%; text-align: center; background-color: rgb(10, 240, 240);">          yourSurvey              </p>
            </div>

        </header>
        <main class="row">
            <section class="col-md-6 ">
                <form action="signin.php" method="post">
                   <div class="container-fluid card--white">
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
                           </div>
                       </div>
                   </div>

                </form>
                <?php
                    if(isset($_SESSION['error']))	echo $_SESSION['error'];
                ?>
            </section>
        </main>
    </div>




</body>
</html>
