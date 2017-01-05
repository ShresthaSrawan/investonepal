<?php

return [
    'appkey' => env('APP_KEY'),
    'client_auth' => false,
    'user_model' => [
        'username_column' => 'email',
        'password_column' => 'password',
    ],
];
