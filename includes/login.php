<?php

    $error = false;
    if (array_key_exists("reason", $_GET)){

        $melding= "";
        if ($_GET["reason"] == "pwd"){
            $melding = "$melding <li> Feil passord </li>";
        }

        $error = true;
    }

?>

<div class="statistik"> 

    <h2>Login</h2>
    
    <?php
        if ($error) {
            echo("<div class=\"error\"><h3>Du ble ikke logget inn</h3><ul>$melding</ul></div>");
            
        }
    ?>

    <form method="POST" action="auth.php">
                <input name="passord" type="password"/>
                    <input value="Log inn" type="submit"/>
                
    </form>
        
</div>
