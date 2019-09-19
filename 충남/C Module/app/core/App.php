<?php
	namespace app\core;

	class App {
		protected $url;

		private static function set_url () {
			$get = isset($_GET['url']) ? explode("/", $_GET['url']) : null;

			if (isset($get[0])) $url['type'] = $get[0];
			else move("/admin");
			if ($url['type'] !== 'admin' && $url['type'] !== 'builder') {
				$url['code'] = $url['type'];
				$url['type'] = 'teaser';
			}

			$url['page'] = isset($get[1]) ? $get[1] : $url['type'];

			$url['member'] = isset($_SESSION['member']);
			return (Object)$url;
		}

		public static function run () {
			$url = self::set_url();
			$ctr_name = "app\\controller\\".ucfirst($url->type);
			$ctr = new $ctr_name();
			$ctr->url = $url;
			$ctr->index();
		}

		protected function index () {
			if (isset($_POST['action'])) {
				$this->action();
			}
			if (method_exists($this, $this->url->page)) {
				$this->{$this->url->page}();
			}

			require_once("./app/view/header.php");

			$page = $this->url->type === 'teaser' ? "teaser_{$this->url->code}" : $this->url->page;
			require_once("./app/view/{$this->url->type}/{$page}.php");

			require_once("./app/view/footer.php");
		}

	}