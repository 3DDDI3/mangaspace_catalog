<?php

return [
    'host' => env('RABBITMQ_HOST', 'rabbitmq'),
    'user' => env('RABBIMTQ_USER', 'rmuser'),
    'password' => env('RABBITMQ_PASSWORD', 'rmpassword'),
    'port' => env('RABBITMQ_PORT', 5672),
];