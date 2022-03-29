<?php

return [
	'version' =>'latest',    
    'use_path_style_endpoint' =>true,
    'bucket' => env('AWS_BUCKET'),
    'region'  => env('AWS_DEFAULT_REGION'),
    'endpoint' => env('AWS_ENDPOINT'),
    'credentials' => [
    	'key'    => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
    ]
];