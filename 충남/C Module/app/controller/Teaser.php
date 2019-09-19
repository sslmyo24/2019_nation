<?php
	namespace app\controller;

	use app\core\App;
	use app\core\DB;

	class Teaser extends App {

		function get_data () {

			$referer = $_SERVER['SERVER_NAME'];

			$agent = $_SERVER['HTTP_USER_AGENT'];

			$os = false;
			$os_list = array(
				'/win/i' => 'Window',
				'/linux/i' => 'Linux',
		        '/ip/i' => 'iOS'
			);

			foreach ($os_list as $preg => $name) {
				if (preg_match($preg, $agent)) {
					$os = $name;
					break;
				}
			}
			if ($os === false) $os = '기타';

			$device = preg_match('/mobile/i', $agent) ? "Mobile" : "PC";

			$browser = $ub = false;
			$browser_list = ["Opera", "Edge", "Chrome", "Safari", "Firefox", "MSIE", "Trident"];
			foreach ($browser_list as $preg) {
				if (preg_match("/{$preg}/i", $agent)) {
					$browser = $ub = $preg;
					break;
				}
			}
			switch ($browser) {
				case 'Chrome':
					$browser = "Google Chrome";
					break;
				case 'MSIE':
				case 'Trident':
					$browser = "Internet Explorer";
					break;
				case 'Edge':
					$browser = "Microsoft Edge";
					break;
			}

			$version = false;
			$known = array('Version', $ub, 'other', 'rv:');
			$pattern = '#(?<browser>' . join('|', $known) . ')[/ ]?+(?<version>[0-9.|a-zA-Z.]*)#';
			preg_match_all($pattern, $agent, $matches);

			$i = count($matches['browser']);
			if ($i != 1) {
				if (strripos($agent, "Version") < strpos($agent, $ub)) $version = $matches['version'][0];
				else $version = $matches['version'][1];
			}
			else $version = $matches['version'][0];

			DB::query("INSERT INTO statistic SET referer = ?, os = ?, browser = ?, device = ?, date = now()", [$referer, $os, $browser." ".$version, $device]);
		}

		function teaser () {
			$this->page_info = DB::fetch("SELECT title, description, keyword FROM page where code = ?", [$this->url->code]);
			if ($this->url->type === 'teaser') $this->get_data();
		}

	}