<?php
require 'simple_html_dom.php';

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://portal.smartguard.co/FuelLogin',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => 'name=william%40willcavanagh.co.uk&pass=Will190481&Submit2=Login&generic=yes&r=https%3A%2F%2Fportal.smartguard.co%2Findex.html',
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/x-www-form-urlencoded',
        'Authorization: Bearer A21AAPud3YEoxq8X9lPFAjE69QClGB1E6Wfwy3w9kCQiFTuSJYo2zqHEe3jkBztL8X8oSrdoQAC20_MlObWKjeiL4Mo1Jq3sA'
    ),
));

$response = curl_exec($curl);
curl_close($curl);


$tmp = explode("/GetGroupData?generic=yes&sc=", $response);
if( count($tmp) == 2 ){
    $tmp1 = explode("&sess=", $tmp[1]);
    if(count($tmp1) == 2){
        $sc = $tmp1[0];
    }
}
$tmp = explode("&sess=", $response);
if( count($tmp) == 2 ){
    $tmp1 = explode("&opt=", $tmp[1]);
    if(count($tmp1) == 2){
        $sess = $tmp1[0];
    }
}

if(!isset($sess) || !isset($sc) ) exit;
function sanitize($plaintext){
    $plaintext = str_replace(" ","_", trim($plaintext));
    $plaintext = str_replace("(","", $plaintext);
    $plaintext = str_replace(")","", $plaintext);

    return $plaintext;
}
$scrapUrl = "https://portal.smartguard.co/GetGroupData?generic=yes&sess=$sess&sc=$sc&size=&co=&opt=S0&var1=6751706&var2=single&var3=1&var7=N";
$htmlString = file_get_contents(  $scrapUrl);

$html = str_get_html($htmlString);

$cleanValues = [];
$table = $html->find('table[id=accounts]',0);

foreach ($table->find('tr') as $tr){
    $cleanValues[ sanitize( $tr->find('td', 0)->plaintext) ] = trim($tr->find('td', 1)->plaintext);
    $cleanValues[ sanitize( $tr->find('td', 2)->plaintext) ] = trim($tr->find('td', 3)->plaintext);
}

foreach($cleanValues as $key=>$value){
    if($key == "Days_Left"){
        $cleanValues[$key] = explode(" ", $value)[0];
    }
    if($key == "Tank_Level"){
        $cleanValues[$key] = explode(" ", $value)[0];
    }
}

//print_r( $cleanValues );
$html = "<html><body>";

foreach($cleanValues as $key => $value){
    $html.="$key <span class='$key'>$value</span><br>";
}
$html.="</body></html>";

file_put_contents("smart-guard.html", $html);

echo "smart-guard.html generated";