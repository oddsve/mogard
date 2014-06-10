<?php
    session_start();
    if ( !empty($_POST) ){
        if ($_POST["passord"] != "jak0b") {
            $error = true;
            $msg = "pwd";
        }


        if (!$error){
            $_SESSION["loggedin"] = "Jepp";
            header("Location: index.php");
            exit;

        } else {
            $_SESSION["loggedin"] = "Nope";
            header("Location: login.php?reason=$msg");
            exit;
        }

    }

?>
