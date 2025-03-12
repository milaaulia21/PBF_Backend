<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use CodeIgniter\Database\Exceptions\DatabaseException;

class TestDB extends Controller
{
    public function index()
    {
        try {
            $db = \Config\Database::connect();
            if ($db->connID) {
                echo "✅ Koneksi database berhasil!";
            } else {
                echo "❌ Koneksi database gagal!";
            }
        } catch (DatabaseException $e) {
            echo "⚠️ Error: " . $e->getMessage();
        }
    }
}
