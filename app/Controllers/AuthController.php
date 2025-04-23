<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\MahasiswaModel;
use App\Models\DosenModel;
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

        if (!$username || !$password || !$role) {
            return $this->failValidationErrors("Username, Password, dan Role wajib diisi.");
        }

        $userModel = new UserModel();

        // Cek apakah username sudah ada
        if ($userModel->where('username', $username)->first()) {
            return $this->fail("Username sudah digunakan.");
        }

        // Hash password sebelum disimpan
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Simpan user
        $userModel->insert([
            'username' => $username,
            'password' => $hashedPassword,
            'role' => $role
        ]);

        $id_user = $userModel->insertID(); // ambil id_user terakhir

        // Simpan ke tabel mahasiswa / dosen sesuai role
        if ($role === 'mahasiswa') {
            $mhsModel = new MahasiswaModel();
            $mhsModel->insert([
                'nama_mhs' => '',
                'nim' => 0,
                'prodi_mhs' => 'D4 RPL', // default
                'thn_akademik' => '',
                'judul_skripsi' => '',
                'id_user' => $id_user
            ]);
        } elseif ($role === 'dosen') {
            $dosenModel = new DosenModel();
            $dosenModel->insert([
                'nama_dosen' => '',
                'nip' => 0,
                'id_user' => $id_user
            ]);
        }

        return $this->respondCreated([
            'message' => 'Registrasi berhasil',
            'username' => $username,
            'role' => $role
        ]);
    }
}
