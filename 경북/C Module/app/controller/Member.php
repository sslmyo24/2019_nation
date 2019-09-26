<?php
	namespace app\controller;

	use app\core\App;
	use app\core\DB;

	class Member extends App {
		function logout () {
			session_destroy();
			move(HOME."/home");
		}

		function loginChk () {
			access(!$this->member(), '회원은 접근할 수 없습니다.', HOME."/home");
		}

		function login () {
			$this->loginChk();
		}

		function join () {
			$this->loginChk();
		}

		function action () {
			extract($_POST);

			switch ($action) {
				case 'join':
					
					access(preg_match("/^[a-zA-Z]+$/", $id) || (preg_match("/^[a-zA-Z0-9]+$/", $id) && !preg_match("/^[0-9]+$/", $id)), "아이디 형식이 잘못되었습니다.");
					access(mb_strlen($pw, 'utf-8') >= 8, "비밀번호 형식이 잘못되었습니다.");
					access(mb_strlen($name, 'utf-8') <= 4 && preg_match("/^[가-힣]+$/", $name), "이름 형식이 잘못되었습니다.");

					DB::query("INSERT INTO member SET id = ?, pw = ?, name = ?", [$id, $pw, $name]);
					move(HOME."/member/login");

					break;
				case 'login':

					access($member = DB::fetch("SELECT * FROM member where id = ? and pw = ?", [$id, $pw]), "아이디 또는 비밀번호가 잘못되었습니다.");

					$_SESSION['member'] = $member;
					move(HOME."/home");

					break;
			}
		}
	}