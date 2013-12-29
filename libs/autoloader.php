<?php
function __autoload($class) {
	$paths = array(
		LIBS,
		MODELS,
		CONTROLLERS
	);
	foreach ($paths as $path) {
		$file = $path . $class . '.php';
		if(file_exists($file)):
			require_once $file;
		endif;
	}
}
?>