<?php
	namespace app\controller;

	use app\core\App;
	use app\core\DB;

	class Member extends App {
		
		function logout () {
			session_destroy();
			move("/home");
		}

		function login_chk () {
			access(!$this->member(), "비회원만 접근가능합니다.", "/home");
		}

		function login () {
			$this->login_chk();
		}

		function join () {
			$this->login_chk();
		}

		function action () {
			extract($_POST);

			switch ($action) {
				case 'login':

					break;
				case 'join':

					break;
			}
			move("/home");
		}
	}