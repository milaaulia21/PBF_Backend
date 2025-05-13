<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;

class UserController extends BaseController
{
    use ResponseTrait;

    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // GET /users
    public function index()
    {
        $users = $this->userModel->findAll();
        return $this->respond($users);
    }

    // GET /users/{id}
    public function show($id = null)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            return $this->failNotFound("User dengan ID $id tidak ditemukan.");
        }

        return $this->respond($user);
    }

    // DELETE /users/{id}
    public function delete($id = null)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            return $this->failNotFound("User dengan ID $id tidak ditemukan.");
        }

        if ($this->userModel->delete($id)) {
            return $this->respondDeleted(['message' => 'User berhasil dihapus.']);
        } else {
            return $this->failServerError('Gagal menghapus user.');
        }
    }

    // PUT /users/{id}/isAdmin
    public function updateIsAdmin($id = null)
    {
        $json = $this->request->getJSON();

        if (!isset($json->isAdmin)) {
            return $this->failValidationErrors('Field isAdmin wajib diisi.');
        }

        $updated = $this->userModel->update($id, ['isAdmin' => $json->isAdmin]);

        if ($updated) {
            return $this->respond(['message' => 'Status isAdmin berhasil diperbarui.']);
        } else {
            return $this->failServerError('Gagal memperbarui status isAdmin.');
        }
    }
}
