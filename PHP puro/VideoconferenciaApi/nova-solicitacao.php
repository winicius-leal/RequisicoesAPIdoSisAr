<?php
require_once('../vendor/autoload.php');
use HTTP_Request2;

include ('importar-pedido.php');
include ('gera-codigo-aceite.php');

$base_url = "https://crm-dev.lab.ca.inf.br/";

$uri = "{$base_url}/videoconferencia-api/nova-solicitacao";
$method = "POST";
$hmacVersion = 1;
$clientId = 0;

$mensagem = array(
    'pedido' => '00887dfb1f40',
    'cliente' => array(
        'nome' => 'WINICIUS TESTE API VIDEO',
        'email' => 'winicius.leal@soluti.com.br',
        'telefone' => '62999999999',
        'cpf' => '50974101060',
        'cnpj' => '94632451000195',
        'cnh' => '',
        'senha' => 'SoLuTI@123',
    ),
    'municipio' => array(
        'codigo' => '5208707'
    ),
    'produto' => $produtos[0],
    'codigo_aceite' => $codigo_aceite

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
