<?php
	namespace app\controller;

	use app\core\App;
	use app\core\DB;

	class Invite extends App {

		function action () {
			extract($_POST);

			$file = $_FILES['file'];
			$handle = fopen($file['tmp_name'], "r");
			$contents = fread($handle, filesize($file['tmp_name']));
			fclose($handle);

			print_pre($contents);
			exit;
		}

		function getList () {
			
		}
	}