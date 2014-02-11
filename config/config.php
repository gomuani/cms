<?php

/*******************************
		Configuration
*******************************/

define('URL', 'http://' . $_SERVER['SERVER_NAME'] . rtrim($_SERVER['PHP_SELF'], 'index.php'));

/* Paths */
define('FW', '../cms/');
define('LIBS', FW . 'libs/');
define('LOGS', FW . 'logs/');
define('VIEWS', 'views/');
define('MODELS', 'models/');
define('CONTROLLERS', 'controllers/');
define('TOOLS', FW . 'tools/');
define('ASSETS', 'assets/');
define('CSS', ASSETS . 'css/');
define('JS', ASSETS . 'js/');
define('IMG', ASSETS . 'img/');

?>