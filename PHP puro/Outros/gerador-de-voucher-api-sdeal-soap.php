<?php

$url = "https://gvshom.ca.inf.br/GVS/webservices/GVSServices.jws?wsdl";// hom
// $url = "https://gvs.ca.inf.br/GVS/webservices/GVSServices.jws?wsdl"; // prod

$usuario = 'ecommerce';
$senha = 'f17f01d8da94fd01e7bcd459308a70ac';

// 10: PJA1
// 9: PFA1
// 11: PF A3 3anos
// 12: PJ A3 3anos
// 16310:SSL
// 2970: BirdId Trial
// 695: PF A3 5 anos
// 17701: SSL G4
// 797 CERT-JUS CODIGO SEGURO A1
$codProduto = '12992';
$codVenda = '';
$negociacao = '112020'; // 160222 SPro | 112020 Emissao
$sequencia = '1';
$sugestao = 'banana';
$cpfcnpj = '56539899000170'; //'03744186164';
$restrito = 'false'; // consegue alterar os dados caso false
$serial = '';

############# HMAC #########################
$key = $senha;
$nonce = time() . rand(1000, 9999);
$hkey = $nonce . $key;
$hash_hkey = hash("sha256", $hkey);


$dados = $usuario . $nonce . $codProduto . $codVenda . $negociacao . $sequencia . $sugestao . $cpfcnpj . $serial . $restrito;

$hash_hkey_dados = hash("sha256", $hkey . $dados);

$hmac = hash("sha256", $hash_hkey . $hash_hkey_dados);


echo "key: " . $key . "\n nonce: " . $nonce . "\nhkey: " . $hkey . "\nhash_hkey: " . $hash_hkey . "\ndados: " . $dados . "\nhash_hkey_dados: " . $hash_hkey_dados . "\nhmac: " . $hmac;

############# /HMAC #########################
try {
    $soap = new SoapClient($url, array(
            'trace' => 1,
            'soap_version' => SOAP_1_2,
            'cache_wsdl' => WSDL_CACHE_NONE,
            'stream_context' => stream_context_create(
                array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false
                    ))))
    );

    $jsonReq = array(
        'Usuario' => $usuario,
        'Nonce' => $nonce,
        'Codproduto' => $codProduto,
        'Codvenda' => $codVenda,
        'Negociacao' => $negociacao,
        'sequencia' => $sequencia,
        'sugestao' => $sugestao,
        'cpf-cnpj' => $cpfcnpj,
        'restrito' => $restrito,
        'hmac' => $hmac,
        #'serial' => $serial,
    );

    echo PHP_EOL;

    $qtVouchers = 1;
    for ($i = 0; $i < $qtVouchers; $i++) {

        $resposta = call_user_func_array(array($soap, 'getVoucherNegociacao'), $jsonReq);

        $retorno = json_decode($resposta, true);

        echo PHP_EOL;

        echo $retorno['mensagem'];

        // echo '<pre>', print_r($usuario), '<br \><br \>';
        // echo '<pre>', print_r($negociacao), '<br \><br \>';
        // echo '<pre>', print_r($codProduto), '<br \><br \>';
        //echo '<pre>', print_r( json_decode($resposta, true)), '<br \><br \>';
        // echo ('Dados enviados:');
        // echo '<pre>', print_r($jsonReq), '</pre>';

    }

    echo PHP_EOL;
    echo PHP_EOL;

} catch (Exception $e) {

    echo $e->getMessage();

}