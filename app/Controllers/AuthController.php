<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use Exception;

class AuthController extends ResourceController
{
    public function __construct()
    {
        helper('jwt_helper');
    }
    public function login()
    {
        $json = $this->request->getJSON();
        $username = $json->username ?? null;
        $password = $json->password ?? null;


        $userModel = new UserModel();
        $user = $userModel->getUserByUserName($username);

        if (!$user) {
            return $this->failNotFound("User Tidak Ditemukan");
        }

        if (!password_verify($password, $user['password'])) {
            return $this->failUnauthorized('Password Salah!!');
        }

        $token = generateJWT([
            'id' => $user['id_user'],
            'username' => $user['username'],
            'role' => $user['role']
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

    public function register()
    {
        $json = $this->request->getJSON();
        $username = $json->username ?? null;
        $password = $json->password ?? null;
        $role = $json->role ?? null;

        if (!$username || !$password) {
            return $this->failValidationErrors("Username dan Password wajib diisi.");
        }

        $userModel = new UserModel();

        // Cek apakah username sudah ada
        if ($userModel->where('username', $username)->first()) {
            return $this->fail("Username sudah digunakan.");
        }

        // Hash password sebelum disimpan
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Simpan ke database
        $userModel->insert([
            'username' => $username,
            'password' => $hashedPassword,
            'role' => $role
        ]);

        return $this->respondCreated([
            'message' => 'Registrasi berhasil',
            'username' => $username
        ]);
    }

}
