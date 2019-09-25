<?php
	define("_DIR", __dir__);
	define("HOME", str_replace("/index.php", "", $_SERVER['PHP_SELF']));


	session_start();

	function __autoload ($c) {
		require_once $c . ".php";
	}

	require_once _DIR."/app/config/lib.php";

	app\core\App::run();