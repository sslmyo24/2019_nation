<?php
	namespace app\controller;

	use app\core\App;
	use app\core\DB;

	class Member extends App {
		
		function logout () {
			session_destroy();
			move(HOME."/home");
		}

		function login_chk () {
			access(!$this->member(), "비회원만 접근가능합니다.");
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

					access($member = DB::fetch("SELECT * FROM member where id = ? and pw = ?", [$id, $pw]), "아이디 또는 비밀번호가 잘못되었습니다.");
					$_SESSION['member'] = $member;

					break;
				case 'join':

					access(filter_var($id, FILTER_VALIDATE_EMAIL), "아이디 이메일 형식이어야 합니다.");
					access(mb_strlen($pw,'utf-8') >= 4, "비밀번호는 4자리 이상이어야 합니다.");
					access($pw === $pw_chk, "비밀번호와 비밀번호 확인이 같지 않습니다.");

					DB::query("INSERT INTO member SET id = ?, pw = ?, name = ?, level = ?", [$id, $pw, $name, $level]);

					break;
			}
			move(HOME."/home");
		}
	}