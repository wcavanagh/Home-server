<?php
$curl = curl_init();
$payload = "";
curl_setopt_array($curl, array(
    CURLOPT_URL => "https://empirebeauty.org/wp-content/plugins/carmen-appointments-alerts/duplicate_customers_alert.php",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"payload\"\r\n\r\n".$payload."\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
    CURLOPT_HTTPHEADER => array(
        "Postman-Token: 8ac62a87-84e5-4f6e-b499-5f91ffd3d36b",
        "cache-control: no-cache",
        "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW"
    ),
));
$curl_response = curl_exec($curl);
$err = curl_error($curl);

echo( $curl_response );
