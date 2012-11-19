<?php
    require "Slim/Slim.php";
    
    use Slim\Slim;
    Slim::registerAutoloader();
    
    $app = new Slim();
    
    $app->get('/years', 'getYears');
    $app->get('/years/:year', 'getUkePris');
    $app->put('/years/:year/:week', 'updateUkePris');
    $app->post('/years', 'createNewYear');
    
    
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
            
             
            $fromDate=strtotime($year."W".$key);
            if ($fromDate < strtotime($year."0601")){
                $fromDate = strtotime($year."0601");
            }
            $y['fromDate']=date('d.m',$fromDate);

            $toDate=strtotime($year."W".$key. "+ 6 days");
            if ($toDate > strtotime($year."0831")){
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
        
        $startDate = strtotime($newYear."0601");
        $startWeek = date('W',$startDate);
        
        $endDate = strtotime($newYear."0831");
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

    
    
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
