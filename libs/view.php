<?php
class View{
	function render($view, $data = null){
		$header = VIEWS . "common/header.php";
		$sidebar = VIEWS . "common/sidebar.php";
		$footer = VIEWS . "common/footer.php";

		require_once VIEWS . "common/top.php";
		if(file_exists($header))
			require_once $header;
		if(file_exists($sidebar))
			require_once $sidebar;
		require_once VIEWS . $view . '.php';
		if(file_exists($footer))
			require_once $footer;
		require_once VIEWS . "common/bottom.php";
	}
}
?>