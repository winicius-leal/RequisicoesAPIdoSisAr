<?php

require_once('../vendor/autoload.php');
use HTTP_Request2;

$base_url = "https://crm-dev.lab.ca.inf.br/";
$uri = "{$base_url}/webservice-soluti/certificates-issued?last-sync=2021-07-01&last-sync-end=2021-07-30";
$method = 'GET';
$hmacVersion = 1;
$clientId = 0;

$ds = $method . $uri;

$key = "CHAVESECRETAAPI";

$nonce = time();
$hkey = $nonce . $key;
$hmac = hash('sha256',hash('sha256', $hkey) . hash('sha256', $hkey . $ds));

$header = [
    'HMAC-Authentication' => $hmacVersion . ':' . $clientId . ':' . $nonce . ':' . $hmac
];

$request = new HTTP_Request2();
$request->setUrl($uri);
$request->setMethod(HTTP_Request2::METHOD_GET);
$request->setHeader($header);

$request->setConfig(array(
    'ssl_verify_peer'   => false,
    'ssl_verify_host'   => false
));

$response = $request->send();

echo "\n";
echo $response->getBody() . "\n\n";