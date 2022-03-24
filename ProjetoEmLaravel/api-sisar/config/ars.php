<?php

return [
    'dev' => [
        'solutidev' => [
            'base_url' => 'https://crm-dev.lab.ca.inf.br/',
            'hmac_key' => [
                'webservice_api' => env('HMAC_KEY.SOLUTI_DEV.WEBSERVICE_API')
            ],
        ],
    ],
    'production' => [
        'soluti' => [
            'base_url' => 'https://arsoluti.acsoluti.com.br/',
            'hmac_key' => [
                'webservice_api' => env('HMAC_KEY.SOLUTI_PRODUCTION.WEBSERVICE_API')
            ],
        ],
    ],
    'homologation' => [
        'condicionado' => [
            'base_url' => 'https://arcondicionadohom.acsoluti.com.br/',
            'hmac_key' => [
                'webservice_api' => env('HMAC_KEY.CONDICIONADO_HOM.WEBSERVICE_API')
            ],
        ],
    ]
];
