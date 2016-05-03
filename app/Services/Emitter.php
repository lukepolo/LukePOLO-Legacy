<?php

namespace App\Services;

use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version1X;

/**
 * Class Emitter
 * @package App\Services
 */
class Emitter
{
    public $client;

    /**
     * Emitter constructor.
     */
    public function __construct()
    {
        $this->client = new Client(new Version1X(env('NODE_SERVER_URL', url()) . ':' . env('NODE_SERVER_PORT')));
        $this->client->initialize();
    }

    /**
     * Emits to the socket.io instance data
     * @param $function
     * @param null $room
     * @param $data
     */
    public function emit($function, $room = null, $data)
    {
        $data['room'] = $room;
        $this->client->emit($function, $data);
        unset($this);
    }

    /**
     * Closes the socket.io connection
     */
    public function __destruct()
    {
        $this->client->close();
    }
}