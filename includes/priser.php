<div class="priser">

<?php
 ini_set("auto_detect_line_endings", true);
  $handle = fopen("data/priser.csv", "r");
  
  $data = fgetcsv($handle, 1000, ";");

  echo "<h2>Priser $data[0]</h2>";
?>
  <table>
<?php
  
  while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
    echo "<tr>\n";
    for ($c=0; $c < count($data); $c++) {
        ( $c === 0 ) ? $class='class="leftAlign"' : $class='';
        
          echo "<td $class >" . $data[$c] . "</td>\n";
    }
    echo "<tr>\n";
  }
  fclose($handle);
?>
    
  </table>
</div>
