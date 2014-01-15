<?php

/*******************************
		Configuration
*******************************/

/* Database Configuration */
$database['host'] = 'localhost';
$database['user'] = 'asaelx_equis';
$database['pass'] = 'qazWSX11';
$database['database'] = 'asaelx_cinepolis';

define('HOST', $database['host']);
define('USER', $database['user']);
define('PASS', $database['pass']);
define('DATABASE', $database['database']);

define('URL', 'http://' . $_SERVER['SERVER_NAME'] . rtrim($_SERVER['PHP_SELF'], 'index.php'));

/* Paths */
define('FW', '../cms/');
define('LIBS', FW . 'libs/');
define('LOGS', FW . 'logs/');
define('VIEWS', 'views/');
define('MODELS', 'models/');
define('CONTROLLERS', 'controllers/');
define('ASSETS', 'assets/');
define('CSS', ASSETS . 'css/');
define('JS', ASSETS . 'js/');
define('IMG', ASSETS . 'img/');

?>