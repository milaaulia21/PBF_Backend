<?php

namespace App\Models;

use CodeIgniter\Model;

class SidangModel extends Model
{
    protected $table = 'sidang';
    protected $primaryKey = 'id_sidang';
    protected $allowedFields = ['id_mhs', 'id_ruangan', 'tanggal_sidang', 'waktu_mulai', 'waktu_selesai', 'status'];
}
