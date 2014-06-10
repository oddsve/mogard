<?php
    session_start();

    $_SESSION["loggedin"] = "Nope";

    header("Location: index.php");
?>
