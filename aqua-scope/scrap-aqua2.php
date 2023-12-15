<?php

function secondsToTime($seconds) {
    $dtF = new \DateTime('@0');
    $dtT = new \DateTime("@$seconds");
    return $dtF->diff($dtT)->format('%a days, %h hours, %i minutes');
}

$handle = curl_init();
$url = "http://192.168.5.111/json";
curl_setopt($handle, CURLOPT_URL, $url);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

$output = curl_exec($handle);

$valuesObj = json_decode($output);
$html = "<html><body>";

//<html><body>Device-Id <span class='Device-Id'>0ea5b1d9</span><br>Uptime <span class='Uptime'>0 days, 13 hours, 51 minutes</span><br>FlowState <span class='FlowState'>1</span><br>Water_Cons <span class='Water_Cons'>0 ml</span><br>Pressure <span class='Pressure'>1.854 mBar</span><br>Ext_Water_Sensor <span class='Ext_Water_Sensor'>0</span><br>Battery_Voltage <span class='Battery_Voltage'>600 mV</span><br>Water_Temperature <span class='Water_Temperature'>48.4 C</span><br></body></html>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 $html.= "Uptime <span class='Uptime'>".secondsToTime($valuesObj->uptime->value)."</span><br>";
$html.= "Device ID <span class='Device-Id'>".$valuesObj->eid."</span><br>";
$html.= "Uptime <span class='Uptime'>".secondsToTime($valuesObj->uptime->value)."</span><br>";
$html.= "FlowState <span class='FlowState'>1</span><br>";
$html.= "Water Consumption <span class='Water_Cons'>".$valuesObj->consumption->value."</span> ". $valuesObj->consumption->scale."<br>";
$html.= "Pressure <span class='Pressure'>". floatval($valuesObj->pressure->value)/1000 ."</span><br>";
$html.= "Ext_Water_Sensor <span class='Ext_Water_Sensor'>".$valuesObj->meter->value ."</span> ".$valuesObj->meter->scale."<br>";
$html.= "Battery_Voltage <span class='Battery_Voltage'>".$valuesObj->voltage->value."</span> ". $valuesObj->voltage->scale ."<br>";
$html.= "Water_Temperature <span class='Water_Temperature'>". floatval($valuesObj->temperature->value)/10 ."</span><br>";



$html.="</body></html>";

file_put_contents("device-2.html", $html);

echo "device-2.html generated";
