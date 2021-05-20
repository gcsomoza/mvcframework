<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');

$ROOT_DIR = __DIR__;

require $ROOT_DIR.'/app/require.php';

use Core\Router;

Router::run();
