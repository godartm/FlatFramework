<?php
/**
 * Created by PhpStorm.
 * User: Marc Moreau
 * Date: 10/04/2017
 * Time: 15:40
 */

namespace Privateheberg\Flat\Socket;


class BasePacket
{
    public $type; //Type de packet
    public $path; // genre /home /service path de la page
    public $get       = []; //value en get
    public $post      = []; //value post
    public $file      = []; //file
    public $sessionID = null;

    /**
     * @param array $packet
     *
     * @return $this
     */
    public function deserialize(array $packet)
    {
        if (isset($packet['type']) && isset($packet['path']) && isset($packet['post']) && isset($packet['file']) && isset($packet['get'])) {
            if (strstr($packet['path'], 'http') OR strstr($packet['path'], 'https')) {
                $url = parse_url($packet['path'], PHP_URL_PATH);
            } else {
                $url = $packet['path'];
            }

            $this->type = $packet['type'];
            $this->path = $url;
            $this->post = $packet['post'];
            $this->file = $packet['file'];
            $this->get = $packet['get'];
            $this->sessionID = $packet['sessionID'];

            return $this;
        } else {
            return null;
        }
    }

    /**
     * @return string
     */
    public function serialize()
    {
        return json_encode($this);
    }
}