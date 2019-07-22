<?php
	namespace app\core;

	class Controller {
		protected $param;

		public static function setParam () {
			$get_param = isset($_GET['param']) ? explode("/", $_GET['param']) : null;
			$param['type'] = isset($get_param[0]) && strlen($get_param[0]) ? $get_param[0] : 'home';
			$param['action'] = isset($get_param[1]) ? $get_param[1] : null;
			$param['include_file'] = isset($param['action']) ? $param['action'] : $param['type'];
			$param['isMember'] = isset($_SESSION['member']);
			$param['member'] = $param['isMember'] ? $_SESSION['member'] : null;
			return (Object)$param;
		}

		public static function run () {
			$param = self::setParam();
			$ctr = "app\\controller\\".ucfirst($param->type)."Controller";
			$ctr = new $ctr();
			$ctr->param = $param;
			$ctr->index();
		}

		protected function index () {
			if (Model::rowCount("SELECT * FROM movie") == 0) Model::parseJson('movie');
			if (Model::rowCount("SELECT * FROM movielist") == 0) Model::parseJson('movieList');
			if (Model::rowCount("SELECT * FROM theater") == 0) Model::parseJson('theater');
			if (isset($_POST['action'])) {
				if (isset($_POST['type']) && $_POST['type'] == 'member') $this->memberAction();
				$this->action();
			}
			if (method_exists($this, $this->param->include_file)) {
				$this->{$this->param->include_file}();
			}

			require_once(_APP."/view/template/header.php");
			require_once(_APP."/view/{$this->param->type}/{$this->param->include_file}.php");
			require_once(_APP."/view/template/footer.php");
		}

		protected function memberAction () {
			extract($_POST);

			switch ($action) {
				// 회원가입
				case 'join':
					access(!empty($id), "누락된 항목이 있습니다.");
					access(!empty($pw), "누락된 항목이 있습니다.");
					access(!empty($pw_chk), "누락된 항목이 있습니다.");
					access(!empty($name), "누락된 항목이 있습니다.");


					access(preg_match("/^[a-zA-Z0-9]+$/", $id), "형식이 잘못된 항목이 있습니다.");
					access(preg_match("/^[a-zA-Z0-9]{4,}$/", $pw) && !preg_match("/^[a-zA-Z]+$/", $pw) && !preg_match("/^[0-9]+$/", $pw), "형식이 잘못된 항목이 있습니다.");
					access($pw == $pw_chk, "비밀번호 확인이 일치하지 않습니다.");
					access(preg_match("/^[a-zA-Z가-힣]+$/u", $name) && !preg_match("/^[ㄱ-ㅎ]+$/u", $name), "형식이 잘못된 항목이 있습니다.");

					access(Model::rowCount("SELECT * FROM member where id = ?", [$id]) == 0, "아이디가 중복되었습니다.");

					$pw = hash("sha256", $pw.$id);
					Model::query("INSERT INTO member SET id = ?, pw = ?, name = ?", [$id, $pw, $name]);
					alert("회원가입 되었습니다.");
					move(HOME."/home");
					break;
				// 로그인
				case 'login':
					access(!empty($id), "누락된 항목이 있습니다.");
					access(!empty($pw), "누락된 항목이 있습니다.");

					$pw = hash("sha256", $pw.$id);
					access($member = Model::fetch("SELECT * FROM member where id = ? and pw = ?", [$id, $pw]), "아이디 또는 비밀번호가 틀립니다");
					$_SESSION['member'] = $member;

					alert("로그인 되었습니다.");
					move(HOME."/home");
					break;
			}
		}
	}