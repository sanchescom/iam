<?php
return [
    'jwt_secret' => env('JWT_SERCRET','hash'),
    'jwt_alg' => env('JWT_ALG','HS256'),
    'jwt_expiration_time' => env('JWT_EXPIRATION_TIME','60'),
];