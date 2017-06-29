<?php
/**
 * Created by PhpStorm.
 * User: Marc Moreau
 * Date: 22/02/2017
 * Time: 07:16
 */

namespace PrivateHeberg\Flat;


class SocketWrapper
{

    private static $userIP;

    public static function getIP()
    {
        if (!SOCKET)
            return BasicWrapper::getIP();

        return self::$userIP;

    }

    /**
     * @param mixed $userIP
     */
    public static function setUserIP($userIP)
    {
        self::$userIP = $userIP;
    }
}