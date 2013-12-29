<?php
class Controller{
	function __construct(){
		$this->view = new view;
		$this->session = new session;
		$this->session->start();
	}
	function welcome(){
		$this->view->render('welcome');
	}
	function error404(){
		$this->view->render('404');
	}
	function go($location){
		header("Location: " . $location);
	}
}
?>