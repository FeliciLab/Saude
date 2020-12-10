<?php

use \MapasCulturais\i;

return [

    'app.siteName' => env('SITE_NAME', i::__('Mapas da Saúde')),
    'app.siteDescription' => env('SITE_DESCRIPTION', i::__('Mapa da Saúde.')),
    
    'maps.center' => [-5.058114374355702, -39.4134521484375],
    'maps.zoom.default' => 8,

    'plugins' => [
        'EvaluationMethodTechnical' => ['namespace' => 'EvaluationMethodTechnical', 'config' => ['step' => 0.1]],
        'EvaluationMethodSimple' => ['namespace' => 'EvaluationMethodSimple'],
        'EvaluationMethodDocumentary' => ['namespace' => 'EvaluationMethodDocumentary']
    ],

    'auth.provider' => 'OpauthKeyCloak',
    'auth.config' => [
        'logout_url'            => env('LOGOUT_URL', ''),
        'client_id'             => env('CLIENT_ID', ''),
        'client_secret'         => env('CLIENT_SECRET', ''),
        'auth_endpoint'         => env('AUTH_ENDPOINT', ''),
        'token_endpoint'        => env('TOKEN_ENDPOINT', ''),
        'user_info_endpoint'    => env('USER_INFO_ENDPOINT', ''),
        'redirect_uri'          => env('REDIRECT_URI', ''),
    ],

    // CEP API
    'cep.endpoint'      => env('CEP_ENDPOINT', 'https://www.cepaberto.com/api/v3/cep?cep=%s'),

    'cep.token_header'  => env('CEP_TOKEN_HEADER', 'Authorization: Token token="%s"'),
    'cep.token'         => env('CEP_TOKEN', ''),
];