<?php

require_once('../vendor/autoload.php');
use HTTP_Request2;

$base_url = "https://crm-dev.lab.ca.inf.br/";

$uri = "{$base_url}/videoconferencia-api/gera-codigo-aceite";
$method = 'POST';

$hmacVersion = 1;
$clientId = 0;


$ds = $method . $uri ;

$key = 'CHAVESECRETAAPI';

$nonce = time();
$hkey = $nonce . $key;
$hmac = hash('sha256',hash('sha256', $hkey) . hash('sha256', $hkey . $ds));

$header = [
    'HMAC-Authentication' => $hmacVersion . ':' . $clientId . ':' . $nonce . ':' . $hmac
];

$request = new HTTP_Request2();
$request->setUrl($uri);
$request->setMethod(HTTP_Request2::METHOD_POST);
$request->setHeader($header);
//$request->setBody($m);

$request->setConfig(array(
    'ssl_verify_peer'   => false,
    'ssl_verify_host'   => false
));

$response = $request->send();

echo "\n";
echo $response->getBody() . "\n\n";

$codigo_aceite = json_decode($response->getBody(),true)['codigo_aceite'];
