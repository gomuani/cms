<?php
class Bootstrap{
	function __construct(){
		$r = $_GET['r'];
		$r = rtrim($r, '/');
		$r = explode('/', $r);
		if(empty($r[0])):
			$controller = new controller;
			$controller->welcome();
			return false;
		else:
			$file = CONTROLLERS . $r[0] . '.php';
			if(isset($r[2])):
				if(file_exists($file)):
					$controller = new $r[0];
					if(method_exists($controller, $r[1])):
						$controller->{$r[1]}($r[2]);
					else:
						$controller->error404();
					endif;
				else:
					$controller = new controller;
					$controller->error404();
				endif;
			elseif(isset($r[1])):
				if(file_exists($file)):
					$controller = new $r[0];
					if(method_exists($controller, $r[1])):
						$controller->{$r[1]}();
					else:
						$controller->error404();
					endif;
				else:
					$controller = new controller;
					$controller->error404();
				endif;
			else:
				if(file_exists($file)):
					$controller = new $r[0];
					$controller->index();
				else:
					$controller = new controller;
					$controller->error404();
				endif;
			endif;
		endif;
	}
}
?>