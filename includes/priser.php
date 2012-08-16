<div class="priser">

<?php
  $loggedIn = ($_SESSION["loggedin"] == "Jepp");

  $filename = "data/priser.json";
  
  $handle = fopen( $filename, "r");  
  $json = fread($handle, filesize($filename));
  fclose($handle);
  
  $priser = json_decode($json,true);
  $thisYear = date("Y");
  $pickedYear = $thisYear;
  if (array_key_exists('year', $_GET)) $pickedYear = $_GET['year'];

  echo "<h2>Priser $pickedYear</h2>";

  echo "Andre år: ";

  foreach ($priser as $year => $value) {
    if ($year >= $thisYear)   echo "<a href=\"priser.php?year=$year\">$year</a> ";
  }

  if ($pickedYear == $thisYear){
    $thisWeek = date("W");
    $antGamleUker = 0;
    foreach ($priser[$pickedYear]["Uke"] as $uke) {
      if ($uke < $thisWeek) $antGamleUker++;
    }
  
    foreach ($priser[$pickedYear] as $key =>  $verdier) {
      $priser[$pickedYear][$key] = array_splice($verdier, $antGamleUker);
    }
  }

  if ($_GET["setSold"] == "Jepp") {
    $key = array_search($_GET["week"], $priser[$pickedYear]["Uke"]);
    $priser[$pickedYear]["Pris"][$key]="Solgt";

    $json  = json_encode($priser);

    $handle = fopen( $filename, "w");  
    fwrite($handle, $json);
    fclose($handle);
  }
  


?>
  <table>
<?php
  
  foreach ($priser[$pickedYear] as $key => $verdier) {
    echo "<tr>\n";
    $class='class="leftAlign"';
    echo "<td $class >" . $key .  "</td>\n";
    foreach ($verdier as  $value) {
      echo "<td >" . $value ; 

      if ($key == 'Uke' && $loggedIn ) {
        echo '<br/><a href="priser.php?setSold=Jepp&year='.$pickedYear.'&week='.$value.'">Solgt</a>';
      }

      echo "</td>\n";
      
    }
    echo "<tr>\n";
  }
?>
    
  </table>
</div>
