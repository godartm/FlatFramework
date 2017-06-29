<?php
use PrivateHeberg\Flat\Rule;

/**
 * Created by PhpStorm.
 * User: Marc Moreau
 * Date: 28/06/2017
 * Time: 17:30
 */
class FullAccessRule extends Rule
{

    public function setAccess($args, $method, $_route, $target)
    {
       $this->allowAccess(true);
    }
}