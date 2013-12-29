<?php
class Session{
	function start(){
		session_start();
	}
	function set($key, $value){
		$_SESSION[$key] = $value;
	}
	function remove($key){
		unset($_SESSION[$key]);
	}
	function get($key){
		return $_SESSION[$key];
	}
	function destroy(){
		session_destroy();
	}
}
?>