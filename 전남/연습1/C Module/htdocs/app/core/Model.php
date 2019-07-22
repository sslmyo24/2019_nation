<?php
	namespace app\core;

	class Model {
		// database
		private static $db;

		/**
		 * connect database and return database
		 * @return object database
		 */
		private static function getDB () {
			if (is_null(self::$db)) {
				$option = array(\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ);
				self::$db = new \PDO("mysql:host=127.0.0.1;charset=utf8;dbname=busanmovie", "root", "", $option);
			}

			return self::$db;
		}

		/**
		 * query
		 * @param  string $sql   sql code
		 * @param  array  $param params
		 * @return object        query result
		 */
		public static function query ($sql, $param = []) {
			$res = self::getDB()->prepare($sql);
			if (!$res->execute($param)) {
				echo $sql;
				print_r($param);
				print_r(self::getDB()->errorInfo());
				exit;
			}

			return $res;
		}

		/**
		 * get data
		 * @param  string $sql   sql code
		 * @param  array  $param params
		 * @return object        data
		 */
		public static function fetch ($sql, $param = []) {
			return self::query($sql, $param)->fetch();
		}

		/**
		 * get data list
		 * @param  string $sql   sql code
		 * @param  array  $param params
		 * @return array        data list
		 */
		public static function fetchAll ($sql, $param = []) {
			return self::query($sql, $param)->fetchAll();
		}

		/**
		 * get the number of data
		 * @param  string $sql   sql code
		 * @param  array  $param params
		 * @return number        the number of data
		 */
		public static function rowCount ($sql, $param = []) {
			return self::query($sql, $param)->rowCount();
		}

		/**
		 * parse json
		 * @param  string $name json name
		 */
		public static function parseJson ($name) {
			$json_arr = json_decode(file_get_contents(_PUBLIC."/data/{$name}.json"));
			foreach ($json_arr as $data) {
				$sql = "INSERT INTO {$name} SET ";
				$param = [];
				foreach ($data as $key => $val) {
					$sql .= "{$key} = ?, ";
					$param[] = $val;
				}
				self::query(substr($sql, 0, strlen($sql) - 2), $param);
			}
		}

	}