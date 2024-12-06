<?php
require_once('../vendor/autoload.php');
use HTTP_Request2;

$baseURL = "https://sis.certificadodigital.com/webservice/criar-solicitacao";

$method = 'POST';
$hmacVersion = 1;
$clientId = 2;

$data = [
    'nome' => 'Fulano da silva!',
    'data_nascimento' => '2023-12-25', // formato Y-m-d
    'cpf' => '05431645196',
    'email' => 'winicius.leal@soluti.com.br',
    'cod_ibge_titular' => 2700102,
    'cod_ibge_validacao' => 1100049,
    'perfil_crt' => 'a1 Pf',
    'ac_id' => 25,//PROD
    'produto_id' => 121,//PROD
    'produto_id' => 89,
    'aprovacao_direta' => 1,
];

$dataCert = $data ;
$m = json_encode($dataCert);
$ds = $method . $baseURL . $m;

$key = 'Solicitar chave HMAC';//PROD

$nonce = time();
$hkey = $nonce . $key;
$hmac = hash('sha256', hash('sha256', $hkey) . hash('sha256', $hkey . $ds));

$header = [
    'Content-Type' => 'application/json',
    'HMAC-Authentication' => $hmacVersion . ':' . $clientId . ':' . $nonce . ':' . $hmac
];

$request = new HTTP_Request2();
try {
    $request->setUrl($baseURL);
    $request->setMethod(HTTP_Request2::METHOD_POST);
    $request->setHeader($header);
    $request->setBody($m);

    $request->setConfig(array(
        'ssl_verify_peer'   => false,
        'ssl_verify_host'   => false
    ));

    $response = $request->send();

    echo "\n";
    var_dump(json_decode($response->getBody(), true)) . "\n\n";
} catch (HTTP_Request2_LogicException $e) {
    echo '1: ' . $e->getMessage();
} catch (HTTP_Request2_Exception $e) {
    echo '2: ' . $e->getMessage();
}


