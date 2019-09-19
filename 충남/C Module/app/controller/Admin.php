<?php
	namespace app\controller;

	use app\core\App;
	use app\core\DB;

	class Admin extends App {
		function action () {
			extract($_POST);

			switch ($action) {
				case 'login':

					access($member = DB::fetch("SELECT * FROM member where id = ? and pw = ?", [$id, hash('sha256', $pw)]), "아이디와 패스워드가 일치하지 않습니다.");

					$_SESSION['member'] = $member;
					echo '<script>sessionStorage.setItem("start", Date.now())</script>';

					alert('로그인 되었습니다.');
					$this->nextPage();
					break;

				case 'join':

					access(preg_match("/^[a-zA-Z]+$/", $id), "아이디는 영문만 입력 가능합니다.");
					access(preg_match("/^[a-zA-Z0-9]+$/", $pw) && !preg_match("/^[0-9]+$/", $pw) && !preg_match("/^[a-zA-Z]+$/", $pw), "패스워드는 영문, 숫자 조합만 입력 가능합니다.");

					DB::query("INSERT INTO member SET name = ?, id = ?, pw = ?, email = ?", [$name, $id, hash('sha256', $pw), $email]);
					alert('회원가입 되었습니다.');
					move("/admin");
					break;
			}
		}

		function nextPage () {
			$last = DB::fetch("SELECT * FROM page order by mod_date desc limit 1");
			if ($last) move("/".$last->code);
			else move("/builder");
		}

		function logout () {
			session_destroy();
			$back = explode("/",$_GET['back']);
			if ($back[0] === 'admin' || $back[0] === 'builder') move("/admin");
			else move("/{$_GET['back']}");
		}

		function admin () {
			if ($this->url->member) $this->nextPage();
		}

		function join () {
			if ($this->url->member) $this->nextPage();
		}
	}