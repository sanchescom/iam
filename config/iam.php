<?php
return [
    'jwt_secret' => env('JWT_SERCRET','hash'),
    'jwt_alg' => env('JWT_ALG','HS256'),
    'jwt_expires' => env('JWT_EXPIRES',true),
    'jwt_expiration_minutes_time' => env('JWT_EXPIRATION_MINUTES_TIME','60'),
];