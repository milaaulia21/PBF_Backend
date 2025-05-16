<?php

namespace App\Controllers;

use App\Models\DosenModel;
use App\Models\MahasiswaModel;
use CodeIgniter\RESTful\ResourceController;

class ProfileController extends ResourceController
{
    public function index()
    {
        $authHeader = $this->request->getHeaderLine('Authorization');
        $token = explode(' ', $authHeader)[1];
        $decoded = \Firebase\JWT\JWT::decode($token, new \Firebase\JWT\Key(getenv('JWT_SECRET'), 'HS256'));
        $userId = $decoded->id_user;

        // Mengambil role (mahasiswa atau dosen) dari hasil decode token
        $role = $decoded->role;
        if ($role === 'mahasiswa') {
            $model = new MahasiswaModel();
            $profile = $model->where('id_user', $userId)->first();
        } else if ($role === 'dosen') {
            $model = new DosenModel();
            $profile = $model->where('id_user', $userId)->first();
        }

        
        // Mengembalikan response JSON berisi id_user, role, dan data profil
        return $this->respond([
            'id_user' => $userId,
            'role' => $role,
            'profile' => $profile
        ]);
    }
}
