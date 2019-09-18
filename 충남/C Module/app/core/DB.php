<?php
	namespace app\core;

	class DB {
		private static $db;

		private static function init () {
			if (is_null(self::$db)) {
				$option = array(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
				self::$db = new \PDO("mysql:host=127.0.0.1;charset=utf8;dbname=magic","root","",$option);
			}

			return self::$db;
		}

		public static function query ($sql, $val = []) {
			$res = self::init()->prepare($sql);
			if (!$res->execute($val)) {
				echo $res;
				print_r($val);
				print_r(self::init()->errorInfo());
				exit;
			}

			return $res;
		}

		public static function fetch ($sql, $val = []) {
			return self::query($sql, $val)->fetch();
		}

		public static function fetchAll ($sql, $val = []) {
			return self::query($sql, $val)->fetchAll();
		}

		public static function rowCount ($sql, $val = []) {
			return self::query($sql, $val)->rowCount();
		}
	}