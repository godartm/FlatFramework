<?php

session_save_path(__DIR__.'/../app/tmp/session');
ini_set('session.save_path', __DIR__.'/../app/tmp/session');

if (!SOCKET) {
    session_start();
}
require_once __DIR__ . '/../vendor/autoload.php';

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


foreach (glob(__DIR__ . "/../controller/*.php") as $filename) {
    include $filename;
}
foreach (glob(__DIR__ . "/../controller/*/*.php") as $filename) {
    include $filename;
}

require_once __DIR__ . '/../app/config/app.php';
include(_CONFIG['dirs']['global']);

