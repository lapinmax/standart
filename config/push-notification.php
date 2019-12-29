<?php

return [
    'ios' => [
        'environment' => 'production',
        'certificate' => storage_path() . '/app/pushcert.pem',
        'passPhrase' => '',
        'service' => 'apns'
    ],
    'android' => [
        'environment' => 'production',
        'apiKey' => 'yourAPIKey',
        'service' => 'gcm'
    ]
];
