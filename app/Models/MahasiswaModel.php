<?php

namespace App\Models;

use CodeIgniter\Model;

class MahasiswaModel extends Model
{
    protected $table = 'mahasiswa';
    protected $primaryKey = 'id_mhs';
    protected $allowedFields = ['nama_mhs', 'nim', 'prodi_mhs', 'thn_akademik', 'judul_skripsi', 'id_user'];
}
