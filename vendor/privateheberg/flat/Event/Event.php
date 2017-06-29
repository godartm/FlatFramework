<?php
/**
 * Created by PhpStorm.
 * User: Marc Moreau
 * Date: 22/02/2017
 * Time: 06:16
 */

namespace PrivateHeberg\Flat\Event;


class Event
{
    public static function call(string $eventName, $obj)
    {
        foreach (_CONFIG['listener'] as $classlistener) {
            $classname = '\\' . $classlistener;

            if (class_exists($classname)) {


                $class = new $classname();
                if (method_exists($class, $eventName)) {
                    return call_user_func_array([$class, $eventName], [$obj]);
                }
            }
        }

        return null;
    }

}