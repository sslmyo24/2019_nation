<?php
	namespace app\controller;

	use app\core\App;
	use app\core\DB;

	class Home extends App {
		
		function history () {
			$dataDir = "./public/data";
			$historyDir = $dataDir."/history";
			$jsonDir = $historyDir."/data.json";

			@unlink($jsonDir);
			@rmdir($historyDir);
			$zip = new \ZipArchive();
			$zip->open($dataDir."/history.zip");
			mkdir($historyDir);
			$zip->extractTo($historyDir);
			$zip->close();
			$json_text = file_get_contents($jsonDir);
			$json_text = preg_replace('/(\/\*)(\r|\n|\r\n)(.+)(\r|\n|\r\n)(\*\/)/', "", $json_text);
			$this->history = json_decode($json_text);
		}
	}