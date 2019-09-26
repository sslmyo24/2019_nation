<?php
	namespace app\core;

	class App {
		protected $url;

		private static function get_url () {
			$get = isset($_GET['url']) ? explode("/", $_GET['url']) : null;
			$url['type'] = $get[0] ?? 'home';
			$url['page'] = $get[1] ?? $url['type'];
			return (Object)$url;
		}

		public static function run () {
			$url = self::get_url();
			$ctr_name = "app\\controller\\".ucfirst($url->type);
			$ctr = new $ctr_name();
			$ctr->url = $url;
			$ctr->index();
		}

		protected function index () {
			if (DB::rowCount("SELECT * FROM member where id = 'admin' and pw = '1234'") == 0) {
				DB::query("INSERT INTO member SET id = ?, pw = ?, name = ?", ['admin', '1234', '관리자']);
			}
			if (isset($_POST['action'])) {
				$this->action();
			}
			if (method_exists($this, $this->url->page)) {
				$this->{$this->url->page}();
			}

			require_once "./app/view/header.php";
			require_once "./app/view/{$this->url->type}/{$this->url->page}.php";
			require_once "./app/view/footer.php";
		}

		protected function member () {
			return $_SESSION['member'] ?? false;
		}
	}