<?php

namespace App\Controllers;

use App\Models\SidangModel;
use CodeIgniter\RESTful\ResourceController;
use App\Services\SidangService;

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
        try {
            $data = $this->request->getJSON(true);
            $service = new SidangService();
            $result = $service->scheduleSidang($data['id_mhs']);
            return $this->respondCreated($result);
        } catch (\Exception $e) {
            return $this->fail($e->getMessage());
        }
    }
    

    public function updateStatus($id = null)
{
    try {
        $data = $this->request->getJSON(true);

        if (!isset($data['status'])) {
            return $this->failValidationErrors('Field status wajib diisi');
        }

        $allowedStatus = ['DITUNDA', 'DIJADWALKAN', 'DIBATALKAN'];
        if (!in_array($data['status'], $allowedStatus)) {
            return $this->failValidationErrors('Status tidak valid. Pilih: ' . implode(', ', $allowedStatus));
        }

        $sidang = $this->model->find($id);
        if (!$sidang) {
            return $this->failNotFound('Data Sidang tidak ditemukan');
        }

        $this->model->update($id, ['status' => $data['status']]);

        return $this->respond(['message' => 'Status Sidang berhasil diperbarui']);
    } catch (\Exception $e) {
        return $this->fail($e->getMessage());
    }
}


    public function update($id = null)
    {
        $data = $this->request->getJSON(true);

        $allowedStatus = ['DITUNDA', 'DIJADWALKAN', 'DIBATALKAN'];
        if (!in_array($data['status'], $allowedStatus)) {
        return $this->failValidationErrors('Status tidak valid. Pilih: ' . implode(', ', $allowedStatus));
        }

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
