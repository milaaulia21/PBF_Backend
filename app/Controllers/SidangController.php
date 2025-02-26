<?php

namespace App\Controllers;

use App\Models\SidangModel;
use CodeIgniter\RESTful\ResourceController;

class SidangController extends ResourceController
{
    protected $modelName = 'App\Models\SidangModel';
    protected $format = 'json';

    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    public function show($id = null)
    {
        $data = $this->model->find($id);
        return $data ? $this->respond($data) : $this->failNotFound('Data Sidang tidak ditemukan');
    }

    public function create()
    {
        $data = $this->request->getJSON(true);
        if ($this->model->insert($data)) {
            return $this->respondCreated(['message' => 'Data Sidang berhasil ditambahkan']);
        }
        return $this->fail($this->model->errors());
    }

    public function update($id = null)
    {
        $data = $this->request->getJSON(true);
        if ($this->model->update($id, $data)) {
            return $this->respond(['message' => 'Data Sidang berhasil diubah']);
        }
        return $this->fail($this->model->errors());
    }

    public function delete($id = null)
    {
        if ($this->model->delete($id)) {
            return $this->respondDeleted(['message' => 'Data Sidang dihapus']);
        }
        return $this->failNotFound('Data Sidang tidak ditemukan');
    }
}
