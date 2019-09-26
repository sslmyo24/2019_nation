<?php
	namespace app\core;

	class DB {
		private static $db;

		private static function init () {
			if (is_null(self::$db)) {
				$option = array(\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ);
				self::$db = new \PDO("mysql:host=localhost;charset=utf8;dbname=film", "root", "", $option);
			}
			return self::$db;
		}

		public static function query ($sql, $vals = []) {
			$res = self::init()->prepare($sql);
			if (!$res->execute($vals)) {
				echo $sql;
				print_pre($vals);
				echo self::init()->errorCode().":";
				print_pre(self::init()->errorInfo());
				exit;
			}
			return $res;
		}

		public static function fetch ($sql, $vals = []) {
			return self::query($sql, $vals)->fetch();
		}

		public static function fetchAll ($sql, $vals = []) {
			return self::query($sql, $vals)->fetchAll();
		}

		public static function rowCount ($sql, $vals = []) {
			return self::query($sql, $vals)->rowCount();
		}
	}