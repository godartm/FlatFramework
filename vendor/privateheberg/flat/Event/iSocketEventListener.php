<?php
/**
 * Created by PhpStorm.
 * User: Marc Moreau
 * Date: 06/03/2017
 * Time: 03:47
 */

namespace PrivateHeberg\Flat\Event;


use PrivateHeberg\Flat\Event\EventWrapper\FinishLoadEvent;

/**
 * Class qui interface le serveurs socket
 * Interface iSocketEventListener
 * @package PrivateHeberg\Flat\Event
 */
interface iSocketEventListener
{
    /**
     * Appelez au moment de la connexion
     *
     * @param FinishLoadEvent $e
     *
     * @return void
     */
    public function onConnect(FinishLoadEvent $e);

    public function onDisconect(FinishLoadEvent $e);

    public function onMessage(FinishLoadEvent $e);

}