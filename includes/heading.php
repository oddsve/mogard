<?php
    session_start();
    $loggedIn = false;
    if (array_key_exists("loggedin", $_SESSION)){
        $loggedIn = ($_SESSION["loggedin"] == "Jepp");
    }


?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Mo Gård, Laksefiske, Gaula, Movaldet, Mohølen, Arne Nordbotn, Melhus" />
    <title>Mo gård</title>
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Tangerine" />
    <link rel="stylesheet" href="stylesheets/style.css"/>


  </head>
  <body>
    <div class="top">
        <div class="hidden">Mo Gård, Laksefiske, Gaula, Movaldet, Mohølen, Arne Nordbotn, Melhus</div>
        <div class="header">
            <ul id="jsddm">
            <li >
                <a class="logo" href="index.php">Mo Gård</a>
            </li>
                    <li><a href="index.php">Movaldet</a></li>
            <li><a href="info.php">Mer info om valdet</a></li>
            <li><a href="holer.php">Hølene</a></li>
            <li><a href="overnatting.php">Overnatting</a></li>
            <li><a href="priser.php">Priser</a></li>
            <?php
                if ($loggedIn) echo '<li><a href="registrerFangst.php">Fangst</a></li>'   ;
                if ($loggedIn) echo '<li><a href="logout.php">Logg ut</a></li>'   ;
            ?>
            </ul>
        </div>

        <div class="bilder">
        <img class="ving" src="images/huset.jpg" />
        <img src="images/elva.jpg" />
        <img class="ving" src="images/holen.jpg" />
        </div>
    </div>
