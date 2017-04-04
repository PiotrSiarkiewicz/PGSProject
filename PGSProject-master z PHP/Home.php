<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>Home</title>
    <link href="PGSProject-master/test/Content/bootstrap.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href="Content/Site.css" rel="stylesheet" />
</head>
<body class="card--logo">
    <div class="container">
        <header class="row ">

            <div class="col-md-1">
                <i id="icon" class="fa fa-check-square-o" style="text-shadow: rgb(7, 168, 168) 0px 0px 0px, rgb(7, 173, 173) 1px 1px 0px, rgb(7, 178, 178) 2px 2px 0px, rgb(8, 182, 182) 3px 3px 0px, rgb(8, 187, 187) 4px 4px 0px, rgb(8, 192, 192) 5px 5px 0px, rgb(8, 197, 197) 6px 6px 0px, rgb(8, 202, 202) 7px 7px 0px, rgb(9, 206, 206) 8px 8px 0px, rgb(9, 211, 211) 9px 9px 0px, rgb(9, 216, 216) 10px 10px 0px, rgb(9, 221, 221) 11px 11px 0px, rgb(9, 226, 226) 12px 12px 0px, rgb(10, 230, 230) 13px 13px 0px, rgb(10, 235, 235) 14px 14px 0px; font-size: 84px; color: rgb(255, 255, 255); height: 106px; width: 106px; line-height: 106px; border-radius: 0%; text-align: center; background-color: rgb(10, 240, 240);"></i>
            </div>

            <div class="col-md-10">
                <p id="icon" style="text-shadow: rgb(7, 168, 168) 0px 0px 0px, rgb(7, 177, 177) 1px 1px 0px, rgb(8, 186, 186) 2px 2px 0px, rgb(8, 195, 195) 3px 3px 0px, rgb(9, 204, 204) 4px 4px 0px, rgb(9, 213, 213) 5px 5px 0px, rgb(9, 222, 222) 6px 6px 0px, rgb(10, 231, 231) 7px 7px 0px; font-size: 20px; color: rgb(255, 255, 255); height: 108px; width: 108px; line-height: 108px; border-radius: 37%; text-align: center; background-color: rgb(10, 240, 240);">          yourSurvey              </p>
            </div>

            <div class="col-md-1">
                <i id="icon" class="fa fa-cog" style="text-shadow: rgb(7, 168, 168) 0px 0px 0px, rgb(7, 177, 177) 1px 1px 0px, rgb(8, 186, 186) 2px 2px 0px, rgb(8, 195, 195) 3px 3px 0px, rgb(9, 204, 204) 4px 4px 0px, rgb(9, 213, 213) 5px 5px 0px, rgb(9, 222, 222) 6px 6px 0px, rgb(10, 231, 231) 7px 7px 0px; font-size: 43px; color: rgb(255, 255, 255); height: 56px; width: 56px; line-height: 56px; border-radius: 0%; text-align: center; background-color: rgb(10, 240, 240);"></i>
            </div>

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
                        session_start();
                        require_once "connect.php";
                        $connection = @new mysqli($host,$db_user,$db_password,$db_name);

                        $iduser=$_SESSION['iduser'];
                        $result = @$connection->query(sprintf("SELECT * FROM access WHERE iduser='$iduser' "));
                        while($access= $result->fetch_assoc())
                        {
                            $idsurvey = $access['idsurvey'];

                            if($rezultat = @$connection->query(sprintf("SELECT text FROM surveys WHERE idsurvey='$idsurvey'"))) {
                                $show_text = $rezultat->fetch_assoc();
                                $show = $show_text['text'];
                                //echo '<form action=show.php method=post><input type="submit" value='.$show.' name='.$i.'></form>';
                                echo '<a href="survey.php">' . $show . '</a></p><br/>';
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