<?php
/**
 * Created by PhpStorm.
 * User: Marc Moreau
 * Date: 27/02/2017
 * Time: 19:46
 */

namespace PrivateHeberg\Flat\Threading;


abstract class Runnable
{
    public abstract function run($args);


    public function close()
    {
        exit();
    }


}