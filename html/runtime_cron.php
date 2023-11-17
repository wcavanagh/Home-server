<?php

$command = '/var/www/html/neocli.py call \'{"GET_LIVE_DATA":0}\'';
$response = shell_exec($command);

$zones_ = array();
$obj = json_decode($response);
foreach($obj->devices as $zone){
    if($zone->HEAT_ON)
        $zones_[] = ['name'=>$zone->ZONE_NAME,'heat'=>"on"];
}

$zone_status = json_encode($zones_);

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://empirebeauty.org/neohub/boiler_running_status.php",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"status\"\r\n\r\n".$zone_status."\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
    CURLOPT_HTTPHEADER => array(
        "Postman-Token: 8ac62a87-84e5-4f6e-b499-5f91ffd3d36b",
        "cache-control: no-cache",
        "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW"
    ),
));
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$curl_response = curl_exec($curl);
$err = curl_error($curl);

echo $curl_response;

curl_close($curl);
if (strpos($curl_response, '****OK****') !== false) {

}else{

}



