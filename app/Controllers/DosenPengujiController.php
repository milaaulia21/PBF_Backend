<?php

namespace App\Controllers;

use App\Models\DosenPengujiModel;
use CodeIgniter\RESTful\ResourceController;

class DosenPengujiController extends ResourceController
{
    protected $modelName = 'App\Models\DosenPengujiModel';
    protected $format = 'json';

    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    public function show($id = null)
    {
        $data = $this->model->find($id);
        return $data ? $this->respond($data) : $this->failNotFound('Data Dosen Penguji tidak ditemukan');
    }

    public function create()
    {
        $data = $this->request->getJSON(true);

        $allowedPeran = ['PENGUJI 1', 'PENGUJI 2'];
        if (!in_array($data['peran'], $allowedPeran)) {
        return $this->failValidationErrors('Peran tidak valid. Pilih: ' . implode(', ', $allowedPeran));
        }

        if ($this->model->insert($data)) {
            return $this->respondCreated(['message' => 'Data Dosen Penguji berhasil ditambahkan']);
        }
        return $this->fail($this->model->errors());
    }

    public function update($id = null)
    {
        $data = $this->request->getJSON(true);

        $allowedPeran = ['PENGUJI 1', 'PENGUJI 2'];
        if (!in_array($data['peran'], $allowedPeran)) {
        return $this->failValidationErrors('Peran tidak valid. Pilih: ' . implode(', ', $allowedPeran));
        }

        if ($this->model->update($id, $data)) {
            return $this->respond(['message' => 'Data Dosen Penguji berhasil diubah']);
        }
        return $this->fail($this->model->errors());
    }

    public function delete($id = null)
    {
        if ($this->model->delete($id)) {
            return $this->respondDeleted(['message' => 'Data Dosen Penguji dihapus']);
        }
        return $this->failNotFound('Data Dosen Penguji tidak ditemukan');
    }
}
