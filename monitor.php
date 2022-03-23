<?php

$settingFile = './settings.txt';
if (file_exists($settingFile) === false) {
    echo $settingFile , " is not found." . PHP_EOL;
    exit(1);
}

$settings = explode(PHP_EOL, file_get_contents($settingFile));

if (count($settings) - 1 !== 2) {
    echo 'Settings line numbers should be 2.' . PHP_EOL;
    exit(1);
}

if (substr($settings[0], 0, 4) !== 'url=') {
    echo 'Setting should begin with url= in the first line.' . PHP_EOL;
    exit(1);
}

if (substr($settings[1], 0, 24) !== 'ifttt_maker_service_url=') {
    echo 'Setting should begin with ifttt_maker_service_url= in the second line.' . PHP_EOL;
    exit(1);
}

$monitoredUrl = substr($settings[0], 4);
$makerServiceUrl = substr($settings[1], 24);

$curl = curl_init($monitoredUrl);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
$responseInfo = curl_getinfo($curl);

if ($responseInfo['http_code'] === 200) {
    curl_close($curl);
    echo $monitoredUrl . ' healthy is good!' . PHP_EOL;
    exit(0);
}
curl_close($curl);

$curl = curl_init($makerServiceUrl);
$json = [
    'date' => date('Y-m-d H:i:s'),
    'status' => $monitoredUrl . ' website is down!',
    'status_code' => $responseInfo['http_code'],
];

curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($json));
curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
$response = curl_exec($curl);
curl_close($curl);

$responseInfo = curl_getinfo($curl);

if ($responseInfo['http_code'] === 200) {
    echo $response, PHP_EOL;
}
