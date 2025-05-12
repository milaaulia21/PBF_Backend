<?php

namespace App\Controllers;

use App\Models\UserModel;
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
            'id_user' => $user['id_user'],
            'username' => $user['username'],
            'role' => $user['role']
        ]);

        $redirect = false;
        $target = null;

        if ($user['role'] === 'mahasiswa') {
            $mhs = model('MahasiswaModel')->where('id_user', $user['id_user'])->first();
            if ($mhs && $mhs['nim'] != null && $mhs['judul_skripsi'] !== '') {
                $redirect = false;
                $target = null;
            } else {
                $redirect = true;
                $target = 'mahasiswa';
            }
        } elseif ($user['role'] === 'dosen') {
            $dosen = model('DosenModel')->where('id_user', $user['id_user'])->first();
            if (!$dosen || !$dosen['nip']) {
                $redirect = true;
                $target = 'dosen';
            }
        }

        return $this->respond([
            'message' => 'Login Berhasil',
            'token' => $token,
            'role' => $user['role'],  
            'redirect' => $redirect,
            'target' => $target,
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

            $role = $decoded->data->role ?? null;
            $id_user = $decoded->data->id_user ?? null;

            if (!$role || !$id_user) {
                return $this->response->setJSON(['error' => 'Invalid token payload']);
            }

            $db = \Config\Database::connect();

            if ($role === 'mahasiswa') {
                $builder = $db->table('mahasiswa');
                $builder->select('mahasiswa.*, user.role, user.isAdmin');
                $builder->join('user', 'user.id_user = mahasiswa.id_user');
            } elseif ($role === 'dosen') {
                $builder = $db->table('dosen');
                $builder->select('dosen.*, user.role, user.isAdmin');
                $builder->join('user', 'user.id_user = dosen.id_user');
            } else {
                $builder = $db->table('user');
                $builder->where('id_user', $id_user);
                $userData = $builder->get()->getRowArray();
            }

            $builder->where('user.id_user', $id_user);
            $userData = $builder->get()->getRowArray();

            if (!$userData) {
                return $this->response->setJSON(['error' => 'User not found']);
            }

            return $this->response->setJSON([
                'message' => 'Token valid',
                'user' => $userData
            ]);
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

        if (!$username || !$password || !$role) {
            return $this->failValidationErrors("Username, Password, dan Role wajib diisi.");
        }

        $userModel = new UserModel();

        if ($userModel->where('username', $username)->first()) {
            return $this->fail("Username sudah digunakan.");
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $userModel->insert([
            'username' => $username,
            'password' => $hashedPassword,
            'role' => $role
        ]);

        return $this->respondCreated(['message' => 'User berhasil didaftarkan']);
    }
}
