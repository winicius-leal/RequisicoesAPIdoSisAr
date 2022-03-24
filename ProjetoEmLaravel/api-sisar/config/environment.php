<?php

return [
    'dev' => [   
        'base_url' => 'http://crm-dev.lab.ca.inf.br/',
        'hmac_key' => [
            'webservice_api' => env('HMAC_KEY.SOLUTI_DEV.WEBSERVICE_API')
        ]
    ]
];
