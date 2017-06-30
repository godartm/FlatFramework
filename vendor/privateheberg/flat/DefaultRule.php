<?php


namespace PrivateHeberg\Flat;
/**
 * Created by PhpStorm.
 * User: Marc Moreau
 * Date: 27/02/2017
 * Time: 17:41
 */
class DefaultRule extends Rule
{

    public function setAccess($args, $method, $_route, $target)
    {
        if (_CONFIG['firewallDefaultPolicy']) {
            $this->allowAccess(true);
        } else {
            $this->allowAccess(false);
        }
    }
}