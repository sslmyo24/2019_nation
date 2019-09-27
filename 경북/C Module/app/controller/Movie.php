<?php
	namespace app\controller;

	use app\core\App;
	use app\core\DB;

	class Movie extends App {
		function request () {
			access($this->member(), "회원만 접근가능합니다.");
		}

		function search () {
			$sql = "SELECT s.start, s.end, me.name, me.id, mv.name as title, mv.duration, mv.year, mv.category FROM schedule s JOIN movie mv ON mv.idx = s.midx JOIN member me ON me.idx = mv.midx";
			$this->all = DB::rowCount($sql);
			if (isset($_GET['key'])) {
				$sql .= " where mv.name like '%{$_GET['key']}%' ";
				if ($_GET['category'] != '전체') {
					$sql .= "and mv.category = '{$_GET['category']}'";
				}
			}
			$this->schList = DB::fetchAll($sql);
		}

		function contest () {
			$this->teaserList = DB::fetchAll("SELECT e.idx, m.name, e.cover FROM edit e LEFT JOIN member m ON m.idx = e.midx");
			$this->sum = [];
			foreach ($this->teaserList as $data) {
				$this->sum[$data->idx] = DB::fetch("SELECT sum(point) as sum FROM rating where eidx = ?", [$data->idx])->sum ?? 0;
			}
		}

		function view () {
			$this->data = DB::fetch("SELECT e.video, e.svg, e.idx, m.name FROM edit e JOIN member m ON e.midx = m.idx where e.idx = ?", [$_GET['idx']]);
			$this->sum = DB::fetch("SELECT sum(point) as sum FROM rating where eidx = ?", [$this->data->idx])->sum ?? 0;
		}

		function action () {
			extract($_POST);

			switch ($action) {
				case 'request':
					
					DB::query("INSERT INTO movie SET midx = ?, name = ?, duration = ?, year = ?, category = ?", [$this->member()->idx, $name, $duration, $year, $category]);
					move(HOME."/movie/request");

					break;
				case 'edit':

					access($this->member(), "로그인 후 사용가능합니다.", HOME."/home");

					DB::query("INSERT INTO edit SET midx = ?, video = ?, svg = ?, cover = ?", [$this->member()->idx, $video, $svg, $cover]);
					move(HOME."/movie/edit");

					break;

				case 'rating':

					DB::query("INSERT INTO rating SET eidx = ?, point = ?", [$_GET['idx'], $point]);
					move(HOME."/movie/contest");

					break;
			}
		}
	}