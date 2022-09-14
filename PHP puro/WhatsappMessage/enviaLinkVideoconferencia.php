<?php

require_once('../vendor/autoload.php');
use HTTP_Request2;

$method = 'POST';
$space_name ='PEGAR NO APP.INI';
$channel = 'WHATSAPP';
$group = 'Atendentes';
$authorization = 'PEGAR NO APP.INI';
$endpoint = 'https://soluti.tm2digital.com/chat/api/send/message';

$message = 'Olá, {{1}}! Tudo bem?\nO agendamento da sua videoconferência foi realizado com sucesso!\n*Data agendada:* {{2}}\n*Horário agendado:* {{3}}\n*Link de acesso:* {{4}}\n*Orientações para o dia da videoconferência:*\nO link deve ser acessado preferencialmente pelo computador, utilizando navegador Chrome ou Firefox. Caso o acesso seja pelo celular, no iPhone utilize o navegador Safari e no Android, navegador Chrome *(não funciona em navegadores Samsung)*\nDurante o atendimento será necessário que você esteja posicionado de frente a câmera a todo momento. E o local deve ser tranquilo, sem barulhos que possam atrapalhar a gravação.\nConforme normas da _ICP Brasil_, será necessário o atendente coletar uma foto durante o atendimento, para isso orientamos que esteja em *um local com fundo claro, sem objetos ou pessoas*, e sem nenhum acessório/item que dificulte o processo de reconhecimento (ex: Boné, Óculos, etc)\n.Caso precise reagendar ou reenviar documentos, clique aqui {{6}} utilize o número do protocolo {{5}} e a senha de emissão que cadastrou no sistema durante o agendamento.\n\nSe tiver alguma dúvida, ficamos à disposição!';
$phoneNumber = 'dd+numero';
$element_name = 'link_conf';
$clientName = "Winicius";
$scheduledHours = '09';
$schduledMinutes = '00';
$linkVideoconference = 'https://crm-dev.lab.ca.inf.br/';
$linkReschedule = 'https://crm-dev.lab.ca.inf.br/';
$protocol = '01655610';

$jsonData = json_encode([
    "message" => $message,
    "channel" => $channel,
    "group" => $group,
    "phone" => '55' . $phoneNumber,
    "additionalInfo" => json_encode([
        "namespace" => $space_name,
        "elementName" => $element_name,
        "parameters" => ["BODY" => [
            [
                "type" => "text",
                "text" => $clientName,
                "payload" => null,
                "currency" => null
            ],
            [
                "type" => "text",
                "text" => $scheduledHours,
                "payload" => null,
                "currency" => null
            ],
            [
                "type" => "text",
                "text" => $schduledMinutes,
                "payload" => null,
                "currency" => null
            ],
            [
                "type" => "text",
                "text" => $linkVideoconference,
                "payload" => null,
                "currency" => null
            ],
            [
                "type" => "text",
                "text" => $linkReschedule,
                "payload" => null,
                "currency" => null
            ],
            [
                "type" => "text",
                "text" => $protocol,
                "payload" => null,
                "currency" => null
            ],
        ]],
        "medias" => (object)[],
        "openSession" => false
    ])
]);


$header = [
    'Content-Type' => 'application/json',
    'Authorization' => $authorization
];

$request = new HTTP_Request2();
$request->setUrl($endpoint);
$request->setMethod(HTTP_Request2::METHOD_POST);
$request->setHeader($header);
$request->setBody($jsonData);


$request->setConfig(array(
    'ssl_verify_peer'   => false,
    'ssl_verify_host'   => false
));

$response = $request->send();

echo "\n";
echo $response->getBody() . "\n\n";