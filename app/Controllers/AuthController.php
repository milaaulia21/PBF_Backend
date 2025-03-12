<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use Exception;

class AuthController extends ResourceController
{
    public function __construct(){
        helper('jwt_helper');
    }
    public function login()
    {
        $json = $this->request->getJSON();
        $username = $json->username ?? null;
        $password = $json->password ?? null;

        log_message('debug', 'Username: ' . print_r($username, true));
        log_message('debug', 'Password: ' . print_r($password, true));

        $userModel = new UserModel();
        $user = $userModel->getUserByUserName($username);
        
        log_message('debug', 'password dari db : ' . print_r($user['password'], true));

        if (!$user) {
            log_message('error', 'User tidak ditemukan: ' . $username);
            return $this->failNotFound('User Tidak Ditemukan');
        }

        if(!$user){
            return $this->failNotFound("User Tidak Ditemukan");
        }

        if(!password_verify($password, $user['password'])){
            return $this->failUnauthorized('Password Salah!!');
        }

        $token = generateJWT([
            'id' => $user['id_user'],
            'username' => $user['username']
        ]);

        return $this->respond([
            'message' => 'Login Berhasil',
            'token' => $token
        ], 200);
    }

    public function profile()
{
    $authHeader = $this->request->getHeaderLine('Authorization');

    if (!$authHeader || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        return $this->response->setJSON(['error' => 'Token not provided']);
    }

    $token = $matches[1];

    try {
        $decoded = validateJWT($token);
        return $this->response->setJSON(['message' => 'Token valid', 'user' => $decoded]);
    } catch (Exception $e) {
        return $this->response->setJSON(['error' => $e->getMessage()]);
    }
}

}
