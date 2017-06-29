<?php

use PrivateHeberg\Flat\Bootstrap;
use PrivateHeberg\Flat\SessionManager;

define('SOCKET', false);
/** FlatFramework V2.0 By PrivateHeberg */

require_once __DIR__ . '/../app/autoload.php'; //Loading all composer features

if (isset($_COOKIE['PHPSESSID'])) {
    $session_id = $_COOKIE['PHPSESSID'];
} else {
    $session_id = null;
}

$session = new SessionManager($session_id);
$session->restore();
$process = new Bootstrap();

$session->flush();

date_default_timezone_set('Europe/Paris');


