<?php
    session_start();

    if ((!isset($_SESSION['log_in'])))
    {
        header('Location: index.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>Home</title>


    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Home</title>
    <link href="Content/bootstrap.css" rel="stylesheet" />

    <link href="Content/site.css" rel="stylesheet" />
</head>
<body class="card--logo">
    <div class="container">
        <header class="row ">

            <br><br><br><br><br><br><br><br>

        </header>
        <main class="row">
            <form action="creation.php">
                <div class=" form-group">
                    <button class="btn btn-primary" tFype="button"> Create New Survey</button>

                </div>
            </form>

            <div class="container-fluid text-center ">
                <div class="row content">
                    <div class="col-sm-8  card--white">
                        <?php
                        require_once "connect.php";
                        $connection = @new mysqli($host,$db_user,$db_password,$db_name);

                        $iduser=$_SESSION['iduser'];
                        echo $iduser;
                        $result = @$connection->query(sprintf("SELECT * FROM access WHERE iduser='$iduser' "));
                        while($access= $result->fetch_assoc())
                        {
                            $idsurvey = $access['idsurvey'];

                            if($rezultat = @$connection->query(sprintf("SELECT text FROM surveys WHERE idsurvey='$idsurvey'"))) {
                                $show_text = $rezultat->fetch_assoc();
                                $show = $show_text['text'];
                                echo  $show . '<br/>';
                            }
                        }

                        ?>
                        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                    </div>
                    <div class="col-sm-2 ">
                        <div class="form-group">
                            <button class="btn btn-primary btn-block" type="button">Edit</button>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btn-block" type="button">Delete</button>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btn-block" type="button">Share</button>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btn-block" type="button">Fill out</button>
                        </div>

                        <form action="logout.php">
                            <div class="form-group">
                                <button class="btn btn-primary" tFype="button">Log out</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </main>
    </div>

</body>
</html>