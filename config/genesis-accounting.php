<?php

return [

    /*
    |--------------------------------------------------------------------------
    | ERP API Base URL
    |--------------------------------------------------------------------------
    |
    | The base URL for the Genesis ERP API. This should be set in your
    | application's .env file using the ERP_API_BASE_URL variable.
    |
    */

    'base_url' => env('ERP_API_BASE_URL', 'https://stepserp.webnstech.net/Webns/steperp/med/'),

    /*
    |--------------------------------------------------------------------------
    | ERP API Key
    |--------------------------------------------------------------------------
    |
    | The API key used to authenticate requests to the Genesis ERP API.
    | This should be set in your application's .env file using the
    | ERP_API_KEY variable.
    |
    */

    'api_key' => env('ERP_API_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | HTTP Timeout
    |--------------------------------------------------------------------------
    |
    | The number of seconds to wait for a response from the ERP API
    | before timing out.
    |
    */

    'timeout' => env('ERP_API_TIMEOUT', 30),

    'projects' => [
        '00001' => 'FCPS Part-I',
        '00002' => 'FCPS Part-II',
        '00003' => 'MidTerm',
        '00004' => 'Residency',
        '00005' => 'Diploma',
        '00006' => 'BCS',
        '00007' => 'Edudent',
        '00008' => 'Outlier',
        '00009' => 'Online University',
        '00010' => 'GRC',
        '00011' => 'DSC',
        '00012' => 'AVR',
        '00013' => 'Medigine IT',
        '00014' => 'GP',
        '00015' => 'Ultra',
        '00016' => 'CMRD',
        '00017' => 'Banglamed Publication',
        '00018' => 'Bayanno MediMart',
        '00019' => 'Sales Books Corner',
    ]

];
