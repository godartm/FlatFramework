<?php
/**
 * Created by PhpStorm.
 * User: Marc Moreau
 * Date: 09/04/2017
 * Time: 12:13
 */

namespace Privateheberg\Flat\Socket;


class WebSocketUser
{
    public $socket;
    public $id;
    public $headers               = array();
    public $handshake             = false;
    public $handlingPartialPacket = false;
    public $partialBuffer         = "";
    public $sendingContinuous     = false;
    public $partialMessage        = "";

    public $hasSentClose = false;

    function __construct($id, $socket)
    {
        $this->id = $id;
        $this->socket = $socket;
    }
}