<?php
function __autoload($class) {
	$paths = array(
		LIBS,
		MODELS,
		CONTROLLERS,
		TOOLS
	);
	foreach ($paths as $path) {
		$file = $path . $class . '.php';
		if(file_exists($file)):
			require_once $file;
		endif;
	}
}
?>