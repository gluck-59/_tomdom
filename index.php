<?php
    require_once 'settings.php';

echo YOUTUBE_APIKEY;
$res = get();
print_r($res);

    function get()
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, YOUTUBE_URL);

//        curl_setopt($curl, CURLOPT_HEADER, true);
//        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Authorization:Bearer '.YOUTUBE_APIKEY, 'Accept:application/json']);
//        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        if (($response = curl_exec($curl)) === false) {
            throw new \Exception(curl_error($curl));
        }




        $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        curl_close($curl);

//echo $header_size;
        return $response;

//    echo trim(substr($response, $header_size));
    }