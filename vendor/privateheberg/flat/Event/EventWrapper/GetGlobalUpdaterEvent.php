<?php

namespace PrivateHeberg\Flat\Event\EventWrapper;

class GetGlobalUpdaterEvent
{

    public $controller;

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param mixed $controller
     */
    public function setController($controller)
    {
        $this->controller = $controller;
    }


}