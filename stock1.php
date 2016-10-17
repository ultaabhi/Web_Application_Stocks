<?php
// Array with names

header("Access-Control-Allow-Origin: *");
// get the q parameter from URL
if (isset($_GET["term"])){
    $q = $_GET["term"];
    if ($q !== "") {
    $json_file = file_get_contents("http://dev.markitondemand.com/MODApis/Api/v2/Lookup/json?input=$q");
     
    $jfoLook = json_decode($json_file);
     $arr2 = array();
        $m=0;
        foreach($jfoLook as $val)
        {       
            $arr1 = array();
            $arr1['value'] = $val->Symbol;
            $arr1['label'] = $val->Symbol.' - '.$val->Name.' ( '.$val->Exchange.' )';
                        
            $arr2[$m]=$arr1;
            $m++;
                       
        }   
      
      $jfo = json_encode($arr2);
        //$jfo = json_encode($json_file,TRUE);
    echo $jfo;

    }   
    
}
function TimeChange($f) {
          
       $time = strtotime($f);
       date_default_timezone_set("America/Los_Angeles");
$dateInLocal = date("d F Y, h:i:s a", $time);
       return $dateInLocal;
}

function MarketCap($g) {
       if($g<1000000000){
           return number_format(($g/1000000),2)." M" ;
       }
       elseif($g>=1000000000) {
           return number_format(($g/1000000000),2)." B" ;
       }
       else {
           return number_format(($g),2);
       }
   }


if (isset($_GET["sym"])){
    $sym = $_GET["sym"];


// GET QUOTE
    if ($sym !== "") {
        $json_file1 = file_get_contents("http://dev.markitondemand.com/MODApis/Api/v2/Quote/json?symbol=$sym");
        $jfo1 = json_decode($json_file1,TRUE);
        $arr1 = array();
        $arr1['Status'] = $jfo1['Status'];
        $arr1['Name'] = $jfo1['Name'];
        $arr1['Symbol'] = $jfo1['Symbol'];
        $arr1['LastPrice'] = '$ '.number_format($jfo1['LastPrice'],2);
        $arr1['Change'] = number_format($jfo1['Change'],2);
        $arr1['ChangePercent'] = number_format($jfo1['ChangePercent'],2);
        $arr1['Timestamp'] = TimeChange($jfo1['Timestamp']);
        $arr1['MarketCap'] = MarketCap($jfo1['MarketCap']);
        $arr1['Volume'] = $jfo1['Volume'];
        $arr1['ChangeYTD'] = number_format($jfo1['ChangeYTD'],2);
        $arr1['ChangePercentYTD'] = number_format($jfo1['ChangePercentYTD'],2);
        $arr1['High'] = '$ '.number_format($jfo1['High'],2);
        $arr1['Low'] = '$ '.number_format($jfo1['Low'],2);
        $arr1['Open'] = '$ '.number_format($jfo1['Open'],2);
        
        
        
        
        
        
          $jfo2 = json_encode($arr1,TRUE);
        echo $jfo2;
    }
    
}

if (isset($_GET["parameters"])){
    
    $map = $_GET["parameters"];


// lookup all hints from array if $q is different from ""
    if ($map !== "") {
        $json_file2 = file_get_contents("http://dev.markitondemand.com/MODApis/Api/v2/InteractiveChart/json?parameters=$map");


          //$jfo2 = json_encode($json_file2);
        echo $json_file2;
    }
    
}

if (isset($_GET['newssymbol'])) {
                    // Replace this value with your account key
                    $accountKey = '5wZp4zHiI2+J3eflqGZ7sM/iZdC9Fow71d/yUpYCPDY';
            
                    $ServiceRootURL =  "https://api.datamarket.azure.com/Bing/Search/";
                    
                    $WebSearchURL = $ServiceRootURL . 'v1/News?$format=json&Query=';
                    
                    $context = stream_context_create(array(
                        'http' => array(
                            'request_fulluri' => true,
                            'header'  => "Authorization: Basic " . base64_encode($accountKey . ":" . $accountKey)
                        )
                    ));

                    $request = $WebSearchURL . urlencode( '\'' . $_GET["newssymbol"] . '\'');
                    
                    
                    $response = file_get_contents($request, 0, $context);
                    
                    $jsonobj = json_decode($response);
            
                    $arr4 = array();
                    $i=0;
                    foreach($jsonobj->d->results as $value)
                    {       
                        $arr3 = array();
                        $arr3['Title'] = $value->Title;
                        $arr3['Desc'] = $value->Description;
                        $arr3['Pub'] = $value->Source;
                        $arr3['dat'] = $value->Date;
                        $arr3['url1'] = $value->Url;
                        
                        $arr4[$i]=$arr3;
                        $i++;
                       
                    }
                    
                    $jfo1 = json_encode($arr4,TRUE);
                    echo $jfo1;
} 





?> 