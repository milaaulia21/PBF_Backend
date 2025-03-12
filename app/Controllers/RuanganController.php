<?php

namespace App\Controllers;

use App\Models\RuanganModel;
use CodeIgniter\RESTful\ResourceController;

class RuanganController extends ResourceController
{
    protected $modelName = 'App\Models\RuanganModel';
    protected $format = 'json';

    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    public function show($id = null)
    {
        $data = $this->model->find($id);
        return $data ? $this->respond($data) : $this->failNotFound('Data Ruangan tidak ditemukan');
    }

    public function create()
    {
        $data = $this->request->getJSON(true);
        if ($this->model->insert($data)) {
            return $this->respondCreated(['message' => 'Data Ruangan berhasil ditambahkan']);
        }
        return $this->fail($this->model->errors());
    }

    public function update($id = null)
    {
        $data = $this->request->getJSON(true);
        if ($this->model->update($id, $data)) {
            return $this->respond(['message' => 'Data Ruangan berhasil diubah']);
        }
        return $this->fail($this->model->errors());
    }

    public function delete($id = null)
    {
        if ($this->model->delete($id)) {
            return $this->respondDeleted(['message' => 'Data Ruangan dihapus']);
        }
        return $this->failNotFound('Data Ruangan tidak ditemukan');
    }
}
