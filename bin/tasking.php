<?php


define('SOCKET', false);
require_once(__DIR__ . '/../app/autoload.php');

if (isset($argv[1])) {
    if (ctype_digit($argv[1])) {
        \PrivateHeberg\Flat\Event\Event::call('onTaskLaunch', $argv[1]);
    }
}