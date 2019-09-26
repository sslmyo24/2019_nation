<?php
	namespace app\controller;

	use app\core\App;
	use app\core\DB;

	class Schedule extends App {

		function calendar () {
			$info = [];
			$info['y'] = $y = $_GET['y'] ?? date("Y");
			$info['m'] = $m = substr('0'.($_GET['m'] ?? date("m")), -2);
			$nextM = $m + 1;
			$prevM = $m - 1;
			$nextY = $prevY = $y;
			if ($nextM > 12) {
				$nextM = 1;
				$nextY += 1;
			}
			if ($prevM < 1) {
				$prevM = 12;
				$prevY -= 1;
			}
			$info['pm'] = $prevM;
			$info['nm'] = $nextM;
			$info['py'] = $prevY;
			$info['ny'] = $nextY;

			$info['start'] = $start = date("w", strtotime("{$y}-{$m}-01"));
			$total = date("t", strtotime("{$y}-{$m}-01"));
			$info['last'] = date("w", strtotime("{$y}-{$m}-{$total}"));
			$info['line'] = ceil(($start + $total)/7);

			$this->info = $info;
		}

		function add () {
			$this->movieList = DB::fetchAll("SELECT * FROM movie where idx not in (SELECT midx FROM schedule)");
			access(count($this->movieList) > 0, "등록된 영화가 없습니다.", HOME."/schedule/calendar");
		}

		function action () {
			extract($_POST);

			switch ($action) {
				case 'add':

					$mInfo = DB::fetch("SELECT duration FROM movie where idx = ?", [$midx]);
					$start = strtotime($time);
					$end = strtotime("+{$mInfo->duration} minutes", $start);
					access(DB::rowCount("SELECT * FROM schedule where start <= ? and end >= ? and date = ?", [$end, $start, $date]) == 0, "다른 상영일정과 겹칩니다.");

					DB::query("INSERT INTO schedule SET midx = ?, date = ?, start = ?, end = ?", [$midx, $date, $start, $end]);
					move(HOME."/schedule/calendar");

					break;
			}
		}

		function view () {
			$this->schList = DB::fetchAll("SELECT s.start, s.end, me.name, me.id, mv.name as title, mv.duration, mv.year, mv.category FROM schedule s JOIN movie mv ON mv.idx = s.midx JOIN member me ON me.idx = mv.midx where s.date = ? ", [$_GET['date']]);
		}

	}