<?php

namespace PrivateHeberg\Flat\Event\EventWrapper;

class FinishLoadEvent
{
    private $errorCode;

    /**
     * @return int
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * @param int $errorCode
     */
    public function setErrorCode(int $errorCode)
    {
        $this->errorCode = $errorCode;
    }

}