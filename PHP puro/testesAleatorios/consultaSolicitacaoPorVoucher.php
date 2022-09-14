<?php

require_once('../vendor/autoload.php');
use HTTP_Request2;

$base_url = "http://crm-dev.lab.ca.inf.br/";
//$base_url = "https://arsoluti.acsoluti.com.br/";
$uri = "{$base_url}/webservice/teste";

$mensagem = array(
   "voucher" => "0003dc5ca340", //7899 ABC123 00883afcb334
    "extPedido" => "7899"
);

$m = json_encode($mensagem);


$request = new HTTP_Request2();
$request->setUrl($uri);
$request->setMethod(HTTP_Request2::METHOD_POST);
$request->setBody($m);

$request->setConfig(array(
    'ssl_verify_peer'   => false,
    'ssl_verify_host'   => false
));

$response = $request->send();
echo "\n";
echo $response->getBody() . "\n\n";
