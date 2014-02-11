<?php
	class randomString{
		function __construct($size){
			$c = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
			$s = "";
			for($i = 0; $i < $size; $i++):
				$s .= $c[rand(0,(strlen($c)-1))];
			endfor;
			return $s;
		}
	}
?>