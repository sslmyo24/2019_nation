<?php
	namespace app\controller;

	use app\core\App;
	use app\core\DB;

	class Teaser extends App {

		function get_data () {

			$referer = null;
			if (isset($_SERVER["HTTP_REFERER"])) {
				$referer = explode("?", $_SERVER["HTTP_REFERER"]);
				$referer = $referer[0];
			}

			$agent = $_SERVER['HTTP_USER_AGENT'];

			$device = $os = $browser = $ub = $version = false;

			$pc_os_list = array(
				'/win/i' => 'Window',
				'/mac/i' => 'Mac OS',
				'/linux/i' => 'Linux',
				'/ubuntu/i' => 'Ubuntu'
			);

			foreach ($pc_os_list as $preg => $name) {
				if (preg_match($preg, $agent)) {
					$os = $name;
					$device = "PC";
					break;
				}
			}

			if ($device !== false) {
				$mobile_os_list = array(
			        '/ip/i' => 'iOS', 
			        '/android/i' => 'Android', 
			        '/blackberry/i' => 'BlackBerry', 
			        '/webos/i' => 'Mobile'
				);

				foreach ($mobile_os_list as $preg => $name) {
					if (preg_match($preg, $agent)) {
						$os = $name;
						$device = "Mobile";
						break;
					}
				}
			}

			$browser_list = array(
				"MSIE" => "Internet Explorer",
				"Firefox" => "Mozilla Firefox",
				"Chrome" => "Google Chrome",
				"Safari" => "Apple Safari",
				"Opera" => "Opera",
				"Netscape" => "Netscape"
			);

			foreach ($browser_list as $preg => $name) {
				if (preg_match("/{$preg}/i", $agent)) {
					if ($preg == 'MSIE' && preg_match("/Opera/i", $agent)) continue;
					$browser = $name;
					$ub = $preg;
					break;
				}
			}

			$known = array('Version', $ub, 'other');
			$pattern = '#(?<browser>' . join('|', $known) . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
			preg_match_all($pattern, $agent, $matches);

			$i = count($matches['browser']);
			if ($i != 1) {
				if (strripos($agent, "Version") < strpos($agent, $ub)) $version = $matches['version'][0];
				else $version = $matches['version'][1];
			}
			else $version = $matches['version'][0];

			if ($version == null || $version == "") $version = "?";

			DB::query("INSERT INTO statistic SET referer = ?, os = ?, browser = ?, version = ?, device = ?, date = now()", [$referer, $os, $browser, $version, $device]);
		}

		function teaser () {
			$this->page_info = DB::fetch("SELECT title, description, keyword FROM page where code = ?", [$this->url->code]);
			$this->get_data();
		}

	}