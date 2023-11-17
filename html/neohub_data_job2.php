<?php

$dblink = mysqli_connect("localhost", "ledyatt", "", "devices_data");
/* If connection fails throw an error */
if (mysqli_connect_errno()) {
    echo "Could  not connect to database: Error: ".mysqli_connect_error();
    exit();
}

$sqlquery = "SELECT * FROM neohub_data where status = 'PENDING' limit 1";
if ($result = mysqli_query($dblink, $sqlquery)) {
    /* fetch associative array */
    while ($row = mysqli_fetch_assoc($result)) {

        $response = $row["data"];
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://empirebeauty.org/neohub/dump_api.php",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"payload\"\r\n\r\n".$response."\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
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

        echo( $curl_response );
        if (strpos($curl_response, '****OK****') !== false) {
            mysqli_query($dblink, "update neohub_data set status = 'SENT' where id = ".$row['id']);
            
        }



    }
    /* free result set */
    mysqli_free_result($result);
}
/* close connection */
mysqli_close($dblink);
