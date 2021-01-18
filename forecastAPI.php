<?php

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.weatherbit.io/v2.0/forecast/daily?city_id=1735158&key=fbb63bec393640caa60e680e4620c5ed",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => [
        "x-rapidapi-host: weatherbit-v1-mashape.p.rapidapi.com",
        "x-rapidapi-key: fbb63bec393640caa60e680e4620c5ed"
    ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    file_put_contents('forecastdata.json', $response);
    // $data = json_decode($response);
    // $cityname = $data->data;
    // echo $cityname[0]->valid_date;
}
