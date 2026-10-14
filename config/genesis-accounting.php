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

    'base_url' => env('ERP_API_BASE_URL', ''),

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

];
