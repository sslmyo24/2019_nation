<?php
	namespace app\controller;

	use app\core\App;
	use app\core\DB;

	class Admin extends App {

		function admin () {
			access($this->member() && $this->member()->level == 'C', "관리자만 접근가능합니다.");
		}

		function action () {
			extract($_POST);

			switch ($action) {
				case 'setBooth':
					print_r($_POST);
					print_r($_FILES);
					break;
				
				default:
					# code...
					break;
			}
		}

	}