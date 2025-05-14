<?php

namespace App\Config;

use CodeIgniter\Config\BaseConfig;
use Pusher\Pusher;

class PusherConfig extends BaseConfig
{
    public $pusherAppId = '1991470';
    public $pusherKey = '6c3887a5d173c66d80a2';
    public $pusherSecret = '0a27efe8baba6a180787';
    public $pusherCluster = 'ap1';


    // Deklarasi properti untuk pusher
    public $pusher;

    public function __construct()
    {
        // Inisialisasi objek Pusher
        $this->pusher = new Pusher(
            $this->pusherKey,
            $this->pusherSecret,
            $this->pusherAppId,
            [
                'cluster' => $this->pusherCluster,
                'useTLS' => true
            ]
        );
    }
}
