<?php

    return [
        'API_DEV' => env('API_DEV'),
        'API_DEV' => 'https://arcintel-database.vercel.app/',
        // 'API_PROD' => env('API_PROD'),
        'VALID_URIS' => [
            'login',
            /****************************** START GET ******************************/
            'users',
            'articles',
            'company',
        ]
    ];


?>