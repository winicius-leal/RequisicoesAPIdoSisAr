<?php

require_once('vendor/autoload.php');
use HTTP_Request2;

$base_url = "http://crm-dev.lab.ca.inf.br/";
$uri = "{$base_url}/webservice-api/consulta-situacao-solicitacao";
$method = 'POST';
$hmacVersion = 1;
$clientId = 0;

$mensagem = array(
    "dataInicial" => '2022-02-02',
    "voucher" => array(
        "00881ffb3c40"
    )
);

$m = json_encode($mensagem);

$ds = $method . $uri . $m;

$key = "CHAVESECRETAAPI";
$nonce = time();
$hkey = $nonce . $key;
$hmac = hash('sha256', hash('sha256', $hkey) . hash('sha256', $hkey . $ds));

$headers = [
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

echo $response->getBody();
