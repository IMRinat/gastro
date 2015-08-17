<?php
// add domains here to prevent proxy chaining by nefarious people; default allows all domains
$domainWhitelist = array("core.localhost", "localhost", "10.14.17.31:9083");
$isDomainValid = true;
if (sizeof($domainWhitelist)) {
    $domain = preg_replace("/^www\./", "", $_SERVER["HTTP_HOST"]);
    // this attempts to prevent proxy chaining
//    $isXMLHttpRequest = array_key_exists("HTTP_X_REQUESTED_WITH", $_SERVER) && "XMLHttpRequest" === $_SERVER["HTTP_X_REQUESTED_WITH"];
//    $isDomainValid = $isXMLHttpRequest && in_array($domain, $domainWhitelist);
    $isDomainValid = in_array($domain, $domainWhitelist);
}


if ($isDomainValid) {
// Get the url of to be proxied
// Is it a POST or a GET?

//$isPost = array_key_exists("url", $_POST);
$isPost = (count($_POST)>0);
//$url = ($isPost) ? $_POST["url"] : $_GET["url"]; //пусть адрес всегда беретс€ из GET даже дл€ POST
$url = $_GET["url"];
$headers = "";
$mimeType = "";
 
if ($isPost) {
    if (array_key_exists("headers", $_POST)) {$headers = $_POST["headers"];}
    if (array_key_exists("mimeType", $_POST)) {$mimeType = $_POST["mimeType"];}
}
else {
    if (array_key_exists("headers", $_GET)) {$headers = $_GET["headers"];}
    if (array_key_exists("mimeType", $_GET)) {$mimeType = $_GET["mimeType"];}
}
 
//Start the Curl session
$session = curl_init($url);
 
    curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($session, CURLOPT_HEADER, false);
    curl_setopt($session, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($session, CURLOPT_ENCODING, "");
    curl_setopt($session, CURLOPT_USERAGENT, "spider");
    curl_setopt($session, CURLOPT_CONNECTTIMEOUT, 120);
    curl_setopt($session, CURLOPT_TIMEOUT, 120);
    curl_setopt($session, CURLOPT_MAXREDIRS, 10);
    curl_setopt($session, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($session, CURLOPT_COOKIEFILE, "cookie.txt");
    curl_setopt($session, CURLOPT_COOKIEJAR,  "cookie.txt");

    // If itТs a POST, put the POST data in the body
    if ($isPost) {
      $postvars = "";
      foreach ($_POST as $key => $value) {
        $postvars .= $key."=".$value."&";
        //echo " люч: $key; «начение: $value<br />\n";
      }
      //print_r($_POST);
      curl_setopt ($session, CURLOPT_POST, true);
      curl_setopt ($session, CURLOPT_POSTFIELDS, $postvars);
    }
 
// Make the call
$response = curl_exec($session); // remove the "\" between the "exe" and "c", this was causing issues with wordpress
 
if ($mimeType != "") {
    // The web service returns XML. Set the Content-Type appropriately
    header("Content-Type: ".$mimeType);
}

echo $response;
curl_close($session);
} 
?>