<?php

    return [
        'API_DEV' => 'https://arcintel-database-git-main-fgporazos-projects.vercel.app/',
        'API_PROD' => env('API_PROD'),
        'VALID_URIS' => [
            'login',
            /****************************** START GET ******************************/
            'users',
            'articles',
            'company'
        ]
    ];


?>