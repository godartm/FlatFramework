<?php

/**
 * @var $router PrivateHeberg\Flat\Router
 */

$router->setBasePath('');

/** Page d'accueil */
$router->map('GET', '/', 'Home@default', FullAccessRule::class);