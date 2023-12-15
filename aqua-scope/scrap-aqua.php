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

$html.= "Device ID <span class='Device-Id'>".$valuesObj->eid."</span><br>";
$html.= "Uptime <span class='Uptime'>".secondsToTime($valuesObj->uptime->value)."</span><br>";
$html.= "FlowState <span class='FlowState'>1</span><br>";
$html.= "Water Consumption <span class='Water_Cons'>".$valuesObj->consumption->value."</span> ". $valuesObj->consumption->scale."<br>";
$html.= "Pressure <span class='Pressure'>". floatval($valuesObj->pressure->value)/1000 ."</span><br>";
$html.= "Ext_Water_Sensor <span class='Ext_Water_Sensor'>".$valuesObj->meter->value ."</span> ".$valuesObj->meter->scale."<br>";
$html.= "Battery_Voltage <span class='Battery_Voltage'>".$valuesObj->voltage->value."</span> ". $valuesObj->voltage->scale ."<br>";
$html.= "Water_Temperature <span class='Water_Temperature'>". floatval($valuesObj->temperature->value)/10 ."</span><br>";

$html.="</body></html>";

file_put_contents("device-1.html", $html);

echo "device-1.html generated";
