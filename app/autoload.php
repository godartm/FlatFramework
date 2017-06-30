<?php

use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

session_save_path(__DIR__ . '/../app/tmp/session');
ini_set('session.save_path', __DIR__ . '/../app/tmp/session');

if (!SOCKET) {
    session_start();
}
require_once __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/../app/config/app.php';
if (_CONFIG['environement'] == "dev") {
    $whoops = new Run;
    $whoops->pushHandler(new PrettyPageHandler);
    $whoops->register();
}


foreach (glob(__DIR__ . '/../app/listener/*.php') as $file) { // iterate files
    include $file;
}

foreach (glob(__DIR__ . '/../app/firewall/*.php') as $file) { // iterate files
    include $file;
}

foreach (glob(__DIR__ . '/../app/task/*.php') as $file) { // iterate files
    include $file;
}

foreach (glob(__DIR__ . '/../app/task/*/*.php') as $file) { // iterate files
    include $file;
}

foreach (glob(__DIR__ . '/../app/task/*/*/*.php') as $file) { // iterate files
    include $file;
}

foreach (glob(__DIR__ . "/../app/model/*.php") as $filename) {
    include $filename;
}

foreach (glob(__DIR__ . "/../controller/*.php") as $filename) {
    include $filename;
}
foreach (glob(__DIR__ . "/../controller/*/*.php") as $filename) {
    include $filename;
}


include(_CONFIG['dirs']['global']);

