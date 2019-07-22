<?php
	// path
	define("_DIR", __DIR__);
	define("_APP", _DIR."/app");
	define("_PUBLIC", _DIR."/public");

	// url
	define("HOME", str_replace("/index.php", "", $_SERVER['PHP_SELF']));
	define("SRC", HOME."/public");

	// config
	require_once(_APP."/config/config.php");
	require_once(_APP."/config/lib.php");

	// run
	app\core\Controller::run();