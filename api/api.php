<?php
    require "Slim/Slim.php";
    
    use Slim\Slim;
    Slim::registerAutoloader();
    
    $app = new Slim();
    
    $app->get('/years', 'getYears');
    $app->get('/years/:year', 'getUkePris');
    $app->put('/years/:year/:week', 'updateUkePris');
    $app->post('/years', 'createNewYear');
    $app->delete('/years/:year', 'deleteYear');
    
    
    
    $app->run();
    
     
    function getYears() {
        $filename = "../data/priser.json";
        
        $handle = fopen( $filename, "r"); 
        $json = fread($handle, filesize($filename));
        fclose($handle);
        
        $years = json_decode($json, true);
        
        
        $return = array();
        foreach ($years as $key => $value){
            $y['id']= $key;
            $y['year']=$key;
            array_push($return, $y);
        }
        
        $json  = json_encode($return);
        
        echo $json;
    }
    
    function getUkePris( $year ) {
        $filename = "../data/priser.json";
        
        $handle = fopen( $filename, "r"); 
        $json = fread($handle, filesize($filename));
        fclose($handle);
        
        $years = json_decode($json,true);
        
        $return = array();
        foreach ($years[$year] as $key => $value){
            $y['id']= $key;
            $y['Solgt']=$value['Solgt'];
            $y['Pris']=$value['Pris'];
            $y['Year']=$year;
            
             
            $fromDate=strtotime($year."W".$key. "- 2 days");
            if ($fromDate <= strtotime($year."0603")){
                //hvis første uken bare er en to dager legges den til dan 2. uken
                $fromDate = strtotime($year."0601");
            }
            $y['fromDate']=date('d.m',$fromDate);

            $toDate=strtotime($year."W".$key. "+ 5 days");
            if ($toDate >= strtotime($year."0828")){ 
                //uker som slutter etter 28. aug tar med seg siste helgen
                $toDate = strtotime($year."0831");
            }
            $y['toDate']=date('d.m',$toDate);
            
            $y['antDager']= ($toDate-$fromDate) / (24*3600);


  
            array_push($return, $y);
        }
        
        
        
        $json  = json_encode($return);
        
        echo $json;
     }
 
    
    function updateUkePris( $year, $week){
        $filename = "../data/priser.json";
        
        $handle = fopen( $filename, "r"); 
        $json = fread($handle, filesize($filename));
        fclose($handle);
        
        $priser = json_decode($json,true);
        
        $request = Slim::getInstance()->request();
        $pris = $request -> params('Pris');
        $solgt = $request -> params('Solgt');
        
        
        $priser[$year][$week]['Pris'] = $pris;
        $priser[$year][$week]['Solgt'] = $solgt;
        $json  = json_encode($priser);
        
        $handle = fopen( $filename, "w"); 
        fwrite($handle, $json);
        fclose($handle);
        
        echo "OK";
        
    }
    
    function createNewYear( ){
        
        $filename = "../data/priser.json";
        
        $handle = fopen( $filename, "r"); 
        $json = fread($handle, filesize($filename));
        fclose($handle);
        $priser = json_decode($json,true);
        
        if (count($priser) == 0 ){
            $newYear = date('Y');
        } else {
            $keys = array_keys($priser);
            $newYear = max($keys)+1;
        }
        
        date_default_timezone_set("Europe/Paris");
        
        $startDate = strtotime($newYear."0605"); 
        //legger til 2 dager for å håndtere at uken starter på lørdag
        //legger til 2 dager for å håndtere korte startuker
        $startWeek = date('W',$startDate);
        
        $endDate = strtotime($newYear."0831");
        //legger til 2 dager for å håndtere at uken starter på lørdag
        //trekker ifra 2 dager for siste uken begynner etter 29. aug blr den med i nest siste uke
        $endWeek = date('W',$endDate);
        
        
        
        for ($i = $startWeek; $i<= $endWeek; $i++){
            $priser[$newYear][$i]['Solgt']="Nei";
            $priser[$newYear][$i]['Pris']="10 000";
        }
        
        
        $json  = json_encode($priser);
        
        $handle = fopen( $filename, "w"); 
        fwrite($handle, $json);
        fclose($handle);
        
        echo '{"id":'.$newYear.'}';
        
    }

    function deleteYear( $year ){
        
        $filename = "../data/priser.json";
        
        $handle = fopen( $filename, "r"); 
        $json = fread($handle, filesize($filename));
        fclose($handle);
        $priser = json_decode($json,true);
        
        unset($priser[$year]);       
        
        $json  = json_encode($priser);
        
        $handle = fopen( $filename, "w"); 
        fwrite($handle, $json);
        fclose($handle);
        
        echo 'OK';
        
    }
    
    
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
