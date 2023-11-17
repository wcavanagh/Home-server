<?php

require 'simple_html_dom.php';
function secondsToTime($seconds) {
    $dtF = new \DateTime('@0');
    $dtT = new \DateTime("@$seconds");
    return $dtF->diff($dtT)->format('%a days, %h hours, %i minutes');
}
$htmlString = file_get_contents(  'http://192.168.5.111');
$html = str_get_html($htmlString);

$ul = $html->find('ul',0);
$ul->remove();

$div = $html->find('div',0);
$statsText = trim( $div->plaintext );

$lines = explode(PHP_EOL, $statsText);
$cleanValues = [];
foreach ($lines as $line){
    $tmp = explode(":", $line);
    if( count($tmp) == 2 ){
        $key = trim( str_replace(" ","_", $tmp[0]) );
        $cleanValues[ $key ] = trim($tmp[1]);
        //clean
        switch( strtolower($key) ){
            case "pressure":{
                $tmpValue = explode(" ",trim($tmp[1]));
                $cleanValues[$key] = floatval($tmpValue[0])/1000 ;
                break;
            }

            case "water_temperature":{
                $tmpValue = explode(" ",trim($tmp[1]));
                $cleanValues[$key] = floatval($tmpValue[0])/10 ;
                break;
            }

            case "uptime":{
                $tmpValue = explode(" ",trim($tmp[1]));
                $cleanValues[$key] = secondsToTime($tmpValue[0]) ;
                break;
            }
        }
    }
}

//print_r( $cleanValues );
$html = "<html><body>";

foreach($cleanValues as $key => $value){
    $html.="$key <span class='$key'>$value</span><br>";
}
$html.="</body></html>";

file_put_contents("device-2.html", $html);

echo "device-2.html generated";
