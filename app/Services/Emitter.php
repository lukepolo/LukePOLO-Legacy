<?php

namespace App\Services;


use \ElephantIO\Client;
use \ElephantIO\Engine\SocketIO\Version1X;

class Emitter
{
    public $client;

    public function __construct()
    {
        $this->client = new Client(new Version1X(url().':'.env('NODE_SERVER_PORT')));
        $this->client->initialize();
    }

    public function emit($function, $room = null, $data)
    {
        $data['room'] = $room;
        $this->client->emit($function, $data);
        unset($this);
    }

    public function __destruct()
    {
        $this->client->close();
        echo 'yay'; die;
    }
}