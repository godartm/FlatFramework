<?php
use PrivateHeberg\Flat\Event\EventListener;
use PrivateHeberg\Flat\Event\EventWrapper\FinishLoadEvent;
use PrivateHeberg\Flat\Event\EventWrapper\GetGlobalUpdaterEvent;
use PrivateHeberg\Flat\Event\EventWrapper\GetUserInfoEvent;
use PrivateHeberg\Flat\Event\EventWrapper\ViolationEvent;


/**
 * Created by PhpStorm.
 * User: Marc Moreau
 * Date: 22/02/2017
 * Time: 05:50
 */
class DefaultListener extends EventListener
{

    public function onFinishLoader(FinishLoadEvent $e)
    {

    }

    public function onGetUserInfo(GetUserInfoEvent $e)
    {

    }

    public function onGetGlobalUpdater(GetGlobalUpdaterEvent $e)
    {

    }

    public function onViolation(ViolationEvent $e)
    {

    }

}