<?php
error_reporting(0);
if (isset($_GET['link'])) {
    $link = $_GET['link'];
} else
    $link = "";
$data = bucksapi($link);
if (!empty($data)) {
    echo $data;
} elseif (isset($_GET['shink'])) {
    $url  = $_GET['shink'];
    $link = "http://shink.in/stxt/0/id/178913/auth_token/W0e2xk?s=" . $url;
    $data = file_get_contents($link);
    $str  = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "", $data);
    //$str  = Googlzip($str);
    echo $str;
}
else echo "Invalid";
function Googlzip($longUrl)
{
    $GoogleApiKey = "AIzaSyCUnvs3IzK9X-L7tnky-eljZ3mlYwElHGU";
    $postData     = array(
        'longUrl' => $longUrl,
        'key' => $GoogleApiKey
    );
    $curlObj      = curl_init();
    curl_setopt($curlObj, CURLOPT_URL, "https://www.googleapis.com/urlshortener/v1/url?key=" . $GoogleApiKey);
    curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curlObj, CURLOPT_HEADER, 0);
    curl_setopt($curlObj, CURLOPT_HTTPHEADER, array(
        'Content-type:application/json'
    ));
    curl_setopt($curlObj, CURLOPT_POST, 1);
    curl_setopt($curlObj, CURLOPT_POSTFIELDS, json_encode($postData));
    $response = curl_exec($curlObj);
    $json     = json_decode($response, true);
    curl_close($curlObj);
    return $json['id'];
}
function bucksapi($longUrl)
{
    $bucksapi = '847a7444ac8248b0';
    $sinoone  = 'hitpro';
    $adts     = '2';
    $contype  = '1';
    $domainss = 'qqc.co';
    $postData = array(
        'originalLink' => $longUrl,
        'user' => $sinoone,
        'apiPassword' => $bucksapi,
        'contentType' => $contype,
        'adType' => $adts,
        'domain' => $domainss
    );
    $jsonData = json_encode($postData);
    $curlObj  = curl_init();
    curl_setopt($curlObj, CURLOPT_URL, 'https://www.linkbucks.com/api/createLink/single');
    curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curlObj, CURLOPT_HEADER, 0);
    curl_setopt($curlObj, CURLOPT_HTTPHEADER, array(
        'Content-type:application/json'
    ));
    curl_setopt($curlObj, CURLOPT_POST, 1);
    curl_setopt($curlObj, CURLOPT_POSTFIELDS, $jsonData);
    $response = curl_exec($curlObj);
    $json     = json_decode($response);
    curl_close($curlObj);
    return $json->link;
}
?>