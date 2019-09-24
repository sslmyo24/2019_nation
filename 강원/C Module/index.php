<?php
	
	session_start();

	function __autoload ($c) {
		require_once $c . ".php";
	}

	require_once "./app/config/lib.php";

	app\core\App::run();