<?php
    $melding = "";
    $error = false;
    if ( !empty($_POST) ){
        if ($_POST["passord"] != "jak0b") {
            $error = true;
            $melding = "$melding <li>Passordet du oppga var feil.</li>";
        }
 

        if (!$error){
            $_SESSION["loggedin"] = "Jepp";
            header("Location: index.php"); /* Redirect browser */
        } else {
            $_SESSION["loggedin"] = "Nope";
        }

    }
?>

<div class="statistik"> 

    <h2>Login</h2>
    
    <?php
        if ($error) {
            echo("<div class=\"error\"><h3>Du ble ikke logget inn</h3><ul>$melding</ul></div>");
            
        }
    ?>

    <form method="POST" action="#">
                <input name="passord" type="password"/>
                    <input value="Log inn" type="submit"/>
                
    </form>
        
</div>
