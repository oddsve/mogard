<?php
    $melding = "";
    $error = false;
    if ( !empty($_POST) ){
        
        foreach ( $_POST as  $key => $val ){
            if ($val == null) {
                $error = true;
                $melding = "$melding <li>$key må fylles inn</li>";
            }
        }
        
        if (!$error){
            if (!date_create_from_format("j.n.Y",  $_POST["dato"])){
                $error = true;
                $melding = "$melding <li>dato må skrives på formatet dd.mm.åååå</li>";
            }
        }
            
    
        if (!$error){
            $date = date_create_from_format("j.n.Y",  $_POST["dato"]);

            $year = date_format($date, "Y");
            $formatedDate = date_format($date, "d.m.Y");

            $nyFangst = array();
            
            array_push($nyFangst,$year);
            array_push($nyFangst,$formatedDate);
            array_push($nyFangst,$_POST["art"]);
            array_push($nyFangst,$_POST["vekt"]);
            array_push($nyFangst,$_POST["redskap"]);
            array_push($nyFangst,$_POST["navn"]);
            
            
            
            $handle = fopen("data/statistikk.csv", "a");
            fputcsv($handle, $nyFangst,";");
            fclose($handle);
        }
                
    }
?>

<div class="statistik"> 

    <h2>Registrer ny fangst</h2>
    
    <?php
        if ($error) {
            echo("<div class=\"error\"><h3>Skjemaet inneholder noen feil</h3><ul>$melding</ul></div>");
            $errorR = $_POST;
        }
    ?>

    <form method="POST" action="#">
        <table>
            <tr><th>Dato</th><th>Navn</th><th>Art</th><th>Redskap</th><th>Vekt</th></tr>
            <tr>
                <td><input name="dato" value="<?php echo $errorR["dato"] ?>"/></td>
                <td><input name="navn" value="<?php echo $errorR["navn"] ?>"/></td>
                <td><input name="art" value="<?php echo $errorR["art"] ?>"/></td>
                <td><input name="redskap" value="<?php echo $errorR["redskap"] ?>"/></td>
                <td><input name="vekt" value="<?php echo $errorR["vekt"] ?>"/>
                    <input type="submit"/></td>
                
            </tr>
        </table>
    </form>
        
</div>
