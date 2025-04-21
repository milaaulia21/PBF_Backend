<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class MahasiswaController extends ResourceController
{
    protected $modelName = 'App\Models\MahasiswaModel';
    protected $format = 'json';

    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    public function show($id = null)
    {
        $data = $this->model->find($id);
        return $data ? $this->respond($data) : $this->failNotFound('Data Mahasiswa tidak ditemukan');
    }

    public function create()
    {
        $data = $this->request->getJSON(true);

        $allowedProdi = ['D3 TI', 'D4 RKS', 'D4 ALKS', 'D4 TRM', 'D4 RPL'];
            if (!in_array($data['prodi_mhs'], $allowedProdi)) {
            return $this->failValidationErrors('Prodi tidak valid. Pilih: ' . implode(', ', $allowedProdi));
        }

        if ($this->model->insert($data)) {
            return $this->respondCreated(['message' => 'Data Mahasiswa berhasil ditambahkan']);
        }
        return $this->fail($this->model->errors());
    }

    public function update($id = null)
    {
        $data = $this->request->getJSON(true);

        $allowedProdi = ['D3 TI', 'D4 RKS', 'D4 ALKS', 'D4 TRM', 'D4 RPL'];
        if (!in_array($data['prodi_mhs'], $allowedProdi)) {
        return $this->failValidationErrors('Prodi tidak valid. Pilih: ' . implode(', ', $allowedProdi));
        }

        if ($this->model->update($id, $data)) {
            return $this->respond(['message' => 'Data Mahasiswa berhasil diubah']);
        }
        return $this->fail($this->model->errors());
    }

    public function delete($id = null)
    {
        if ($this->model->delete($id)) {
            return $this->respondDeleted(['message' => 'Data Mahasiswa dihapus']);
        }
        return $this->failNotFound('Data Mahasiswa tidak ditemukan');
    }
}
