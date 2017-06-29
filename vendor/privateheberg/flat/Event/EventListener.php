<?php
/**
 * Created by PhpStorm.
 * User: Marc Moreau
 * Date: 22/02/2017
 * Time: 05:51
 */

namespace PrivateHeberg\Flat\Event;


use PrivateHeberg\Flat\Event\EventWrapper\FinishLoadEvent;
use PrivateHeberg\Flat\Event\EventWrapper\GetGlobalUpdaterEvent;
use PrivateHeberg\Flat\Event\EventWrapper\GetUserInfoEvent;
use PrivateHeberg\Flat\Event\EventWrapper\ViolationEvent;


/**
 * Class EventListener
 * @package PrivateHeberg\Flat\Event
 */
class  EventListener
{
    /**
     * On page Load
     * @param FinishLoadEvent $e
     */
    public function onFinishLoader(FinishLoadEvent $e) {
        //IT'S A VIRTUAL METHOD
    }

    /**
     * On User Get indo action
     * @param FinishLoadEvent $e
     */
    public function onGetUserInfo(GetUserInfoEvent $e) {
        //IT'S A VIRTUAL METHOD
    }

    /**
     * On get global updater
     * @param FinishLoadEvent $e
     */
    public function onGetGlobalUpdater(GetGlobalUpdaterEvent $e) {
        //IT'S A VIRTUAL METHOD
    }

    /**
     * On Error
     * @param FinishLoadEvent $e
     */
    public function onViolation(ViolationEvent $e) {
        //IT'S A VIRTUAL METHOD
    }

}

