<?php

namespace App\Services;

use Config\PusherConfig;
use Pusher\Pusher;

class PusherService
{
    protected $pusher;

    public function __construct()
    {
        $config = new PusherConfig;

        $this->pusher = new Pusher(
            $config->key,
            $config->secret,
            $config->app_id,
            [
                'cluster' => $config->cluster,
                'useTLS' => $config->useTLS
            ]
        );
    }

    public function sendNotification($channel, $event, $data)
    {
        $this->pusher->trigger($channel, $event, $data);
    }
}
