<?php
require_once 'HTTP/Request2.php';

$base_url = "https://crm-dev.lab.ca.inf.br/";

$uri = "{$base_url}/videoconferencia-api/importar-pedido";
$method = 'POST';
$hmacVersion = 1;
$clientId = 0;

$mensagem = array(
    'pedido' => '00887dfb1f40',
);

$m = json_encode($mensagem);

$ds = $method . $uri . $m;

$key = 'CHAVESECRETAAPI';

$nonce = time();
$hkey = $nonce . $key;
$hmac = hash('sha256', hash('sha256', $hkey) . hash('sha256', $hkey . $ds));

$headers = [
    'Content-type' => 'application/json',
    'HMAC-Authentication' => $hmacVersion . ':' . $clientId . ':' . $nonce . ':' . $hmac
];

$request = new HTTP_Request2();
$request->setUrl($uri);
$request->setMethod(HTTP_Request2::METHOD_POST);
$request->setHeader($headers);
$request->setBody($m);

$request->setConfig(array(
    'ssl_verify_peer'   => false,
    'ssl_verify_host'   => false
));

$response = $request->send();

echo "\n";
echo $response->getBody() . "\n\n";

$produtos = json_decode($response->getBody(),true)['data']['produtos'];

