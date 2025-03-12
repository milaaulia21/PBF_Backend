<?php

namespace App\Models;

use CodeIgniter\Model;

class DosenPengujiModel extends Model
{
    protected $table = 'dosen_penguji';
    protected $primaryKey = 'id_penguji';
    protected $allowedFields = ['id_sidang', 'id_dosen', 'peran'];
}
