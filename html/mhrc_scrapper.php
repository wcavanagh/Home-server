<?php

$endpoints = array('http://192.168.5.120',
'http://192.168.5.121',
'http://192.168.5.118',
'http://192.168.5.117');
require dirname ( __FILE__ )."/simple_html_dom.php";
$data = array();
foreach($endpoints as $endpoint){
	
	$response1 = file_get_contents($endpoint);
	$html = str_get_html($response1);
	$device_name = strip_tags( $html->find('h2')[0] );
	echo $device_name ."|";
	
	$response2 = file_get_contents($endpoint."/?m=1");
	$tmp = explode("Temperature{m}",$response2);
	$tmp1 = explode("&deg;", $tmp[1]);
	$temperature = $tmp1[0];
	echo $temperature."<br>";
	
	$data[] = array('device_name'=>$device_name,'temperature'=>$temperature);
	
}
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://empirebeauty.org/neohub/mhrc_api.php",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"payload\"\r\n\r\n".json_encode($data)."\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
    CURLOPT_HTTPHEADER => array(
        "Postman-Token: 8ac62a87-84e5-4f6e-b499-5f91ffd3d36b",
        "cache-control: no-cache",
        "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW"
    ),
));
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$curl_response = curl_exec($curl);
echo $curl_response;

