<?php

session_start();

require_once '../core/Router.php';

$router = new Router();
$router->route();