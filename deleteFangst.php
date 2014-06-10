<?php

    $lineNumber =  $_GET["line"];
    $year = $_GET["year"];
    $lineArray = array();

    $i = 0;
    $handle = fopen("data/statistikk.csv", "r",";");
    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {

        if($data[0] == $year ) {
            if ($i == $lineNumber){
                $i++;
                continue;
            }
            $i++;
        }
        array_push($lineArray, $data);
    }

    fclose($handle);

    $handle = fopen("data/statistikk.csv", "w");
    foreach( $lineArray as $line ){
        fputcsv($handle, $line, ";");
    }
    fclose($handle);

    header("Location: index.php");

?>
