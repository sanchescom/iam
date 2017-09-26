<?php
return [
    'jwt_secret' => env('JWT_SERCRET','hash'),
    'alg' => env('JWT_ALG','HS256'),
];