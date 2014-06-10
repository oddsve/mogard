<div class="statistik"> 
<?php

    $loggedIn = false;
    if (array_key_exists("loggedin", $_SESSION)){
        $loggedIn = ($_SESSION["loggedin"] == "Jepp");
    }

    ini_set("auto_detect_line_endings", true);
    $pickedYear = -1;
    if (array_key_exists('year', $_GET)) $pickedYear = $_GET['year'];
   
    
    $fangst = array();
    $years = array();
    $handle = fopen("data/statistikk.csv", "r",";");
    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
        $fangstArray = array();
        $fangstArray["dato"] = $data[1];
        $fangstArray["vekt"] = $data[3];
        $fangstArray["redskap"] = $data[4];
        $fangstArray["art"] = $data[2];
        $fangstArray["navn"] = $data[5];
        
        $fangst[$data[0]][]=$fangstArray;
        
    }
    fclose($handle);

    
    ksort($fangst);
    
    
    if ($pickedYear == -1) 
    {
        $fangstAr = end($fangst);
        $pickedYear = key($fangst);
    } else {
        $fangstAr = $fangst[$pickedYear];
    }
    
    
    echo "<h2>Fangststatistikk $pickedYear</h2>";

    echo "<div class=\"years\">Andre år: ";
    foreach ($fangst as $key => $value) {
        echo "<a href=\"index.php?year=$key\">$key</a> ";
    }
    echo "</div>";

?>
  <table>
  <tr>
      <th>Dato</th><th>Navn</th><th>Art</th><th>Redskap</th><th>Vekt</th>
  </tr> 
      
<?php

    $i = 0;
    foreach ( $fangstAr as $linje ){

        echo "<tr>\n";
        
        echo "<td>" . $linje["dato"] . "</td>\n";
        echo "<td>" . $linje["navn"] . "</td>\n";
        echo "<td>" . $linje["art"] . "</td>\n";
        echo "<td>" . $linje["redskap"] . "</td>\n";
        echo "<td class=\"rightAlign\">" . $linje["vekt"] . " kg</td>\n";
        if ($loggedIn) {
            echo "<td><a href='deleteFangst.php?year=$pickedYear&line=" . $i ."'>Slett </a></td>\n";
        }
        $i ++;
        echo "<tr>\n";
    }
    
    
?>  
  </table>
<?php
?>    
    
</div>
