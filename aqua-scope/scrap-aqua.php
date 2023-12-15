<?php

function secondsToTime($seconds) {
    $dtF = new \DateTime('@0');
    $dtT = new \DateTime("@$seconds");
    return $dtF->diff($dtT)->format('%a days, %h hours, %i minutes');
}
$handle = curl_init();
$url = "http://192.168.5.174/json";
curl_setopt($handle, CURLOPT_URL, $url);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

$output = curl_exec($handle);

$valuesObj = json_decode($output);
$html = "<html><body>";

$html.= "Uptime <span class='uptime'>".secondsToTime($valuesObj->uptime->value)." </span><br>";
$html.= "Temperature <span class='uptime'>". floatval($valuesObj->temperature->value)/10 ."</span><br>";
$html.= "Voltage <span class='uptime'>".$valuesObj->voltage->value." ". $valuesObj->voltage->scale ."</span><br>";
$html.= "Battery <span class='uptime'>".$valuesObj->battery->value." ". $valuesObj->battery->scale ."</span><br>";
$html.= "Pressure <span class='uptime'>". floatval($valuesObj->pressure->value)/1000 ."</span><br>";
$html.= "Consumption <span class='uptime'>".$valuesObj->consumption->value." ". $valuesObj->consumption->scale." </span><br>";
$html.= "Meter <span class='uptime'>".$valuesObj->meter->value ." ".$valuesObj->meter->scale." </span><br>";
$html.="</body></html>";

file_put_contents("device-1.html", $html);

echo "device-1.html generated";
