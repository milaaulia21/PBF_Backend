<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class DosenController extends ResourceController
{
    protected $modelName = 'App\Models\DosenModel';
    protected $format = 'json';

    public function index()
    {
        $dosen = $this->model->findAll();
        return $this->respond(['status' => 'success', 'data' => $dosen]);
    }

    public function show($id = null)
    {
        $dosen = $this->model->find($id);
        if ($dosen) {
            return $this->respond(['status' => 'success', 'data' => $dosen]);
        }
        return $this->failNotFound('Data Dosen tidak ditemukan');
    }

    public function getByUserId($id_user = null)
    {
        $dosen = $this->model->where('id_user', $id_user)->first();
        if ($dosen) {
            return $this->respond(['status' => 'success', 'data' => $dosen]);
        }
        return $this->failNotFound('Data Dosen dengan id_user tersebut tidak ditemukan');
    }

    public function create()
    {
        $data = $this->request->getJSON(true);

        if (!$this->model->insert($data)) {
            return $this->failValidationErrors($this->model->errors());
        }

        return $this->respondCreated(['status' => 'success', 'message' => 'Data Dosen berhasil ditambahkan']);
    }

    public function update($id = null)
    {
        $data = $this->request->getJSON(true);

        if (!$this->model->find($id)) {
            return $this->failNotFound('Data Dosen tidak ditemukan');
        }

        if (!$this->model->update($id, $data)) {
            return $this->failValidationErrors($this->model->errors());
        }

        return $this->respond(['status' => 'success', 'message' => 'Data Dosen berhasil diubah']);
    }

    public function delete($id = null)
    {
        if (!$this->model->find($id)) {
            return $this->failNotFound('Data Dosen tidak ditemukan');
        }

        if (!$this->model->delete($id)) {
            return $this->failServerError('Gagal menghapus data Dosen');
        }

        return $this->respondDeleted(['status' => 'success', 'message' => 'Data Dosen dihapus']);
    }
}
