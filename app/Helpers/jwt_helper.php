<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function generateJWT($data)
{

    $key = getenv('JWT_SECRET_KEY');
    $payload = [
        'data' => $data,
        'iat' => time(),
        'iss' => getenv('JWT_ISSUERRRR'),
        'exp' => time() + 60 * 60 * 24,
    ];

    return JWT::encode($payload, $key, 'HS256');
}

function validateJWT($token)
{
    $key = getenv('JWT_SECRET_KEY');
    return JWT::decode($token, new Key($key, 'HS256'));
}
