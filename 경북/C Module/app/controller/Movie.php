<?php
	namespace app\controller;

	use app\core\App;
	use app\core\DB;

	class Movie extends App {
		function request () {
			access($this->member(), "회원만 접근가능합니다.");
		}

		function action () {
			extract($_POST);

			switch ($action) {
				case 'request':
					
					DB::query("INSERT INTO movie SET midx = ?, name = ?, duration = ?, year = ?, category = ?", [$this->member()->idx, $name, $duration, $year, $category]);
					move(HOME."/movie/request");

					break;
			}
		}
	}