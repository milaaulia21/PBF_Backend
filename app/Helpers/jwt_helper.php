<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function generateJWT($data)
{
    log_message('debug', 'ENV JWT_SECRET_KEY: ' . getenv('JWT_SECRET_KEY'));
    log_message('debug', 'ENV JWT_ISSUERRRR: ' . getenv('JWT_ISSUERRRR'));

    $key = getenv('JWT_SECRET_KEY');
    $payload = [
        'data' => $data,
        'iat' => time(),
        'iss' => getenv('JWT_ISSUERRRR'),
        'exp' => time() + 60 * 60 * 24,
    ];

    log_message('debug', 'Payload: ' . print_r($payload, true));
    return JWT::encode($payload, $key, 'HS256');
}

function validateJWT($token)
{
    $key = getenv('JWT_SECRET_KEY');
    return JWT::decode($token, new Key($key, 'HS256'));
}
