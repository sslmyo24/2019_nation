<?php
	namespace app\controller;

	use app\core\Controller;
	use app\core\Model;

	class MovieController extends Controller {
		// 상영시간표
		function timetable () {
			if (isset($_GET['standard'])) {
				switch ($_GET['standard']) {
					case 'date':
						$this->theater_list = Model::fetchAll("SELECT t.* FROM theater t JOIN movielist m ON m.theaterCode = t.code where m.day = ?", [$_GET['day']]);
						foreach ($this->theater_list as $key => $data) {
							$time_list = "time_list".$key;
							$this->$time_list = Model::fetchAll("SELECT ml.*, m.title FROM movielist ml JOIN movie m ON m.code = ml.movieCode where theaterCode = ? and day = ?", [$data->code, $_GET['day']]);
						}
						break;
					case 'theater':
						$this->day_list = Model::fetchAll("SELECT m.day FROM movielist m JOIN theater t ON t.code = m.theaterCode where t.code = ? group by m.day", [$_GET['code']]);
						foreach ($this->day_list as $key => $data) {
							$time_list = "time_list".$key;
							$this->$time_list = Model::fetchAll("SELECT ml.*, m.title FROM movielist ml JOIN movie m ON m.code = ml.movieCode where theaterCode = ? and day = ?", [$_GET['code'], $data->day]);
						}
						break;
					case 'section':
						$this->movie_list = Model::fetchAll("SELECT * FROM movie where section like '{$_GET['section']}%'");
						foreach ($this->movie_list as $key => $movie) {
							$time_list = "time_list".$key;
							$this->$time_list = Model::fetchAll("SELECT m.*, t.name FROM movielist m JOIN theater t ON m.theaterCode = t.code where m.movieCode = ?", [$movie->code]);
						}
						break;
				}
			}
		}

		// 상영시간표 상세보기
		function info () {
			$this->movie_info = Model::fetch("SELECT * FROM movie where code = ?", [$_GET['code']]);
			$this->time_list = Model::fetchAll("SELECT m.*, t.name FROM movielist m JOIN theater t ON t.code = m.theaterCode where movieCode = ?", [$_GET['code']]);
			$this->comment_list = Model::fetchAll("SELECT c.*, m.name FROM comment c JOIN member m ON m.idx = c.midx where movieCode = ?", [$_GET['code']]);
		}

		function action () {
			extract($_POST);

			switch ($action) {
				// 댓글 작성
				case 'comment':
					access($this->param->isMember, "로그인 후 작성 가능합니다.");

					access(!empty($content), "누락된 항목이 있습니다.");

					Model::query("INSERT INTO comment SET midx = ?, content = ?, date = now(), movieCode = ?", [$this->param->member->idx, $content, $_GET['code']]);
					alert("작성 되었습니다.");
					move(HOME."/movie/info?code=".$_GET['code']);
					break;
			}
		}

		// 댓글 삭제
		function comment_delete () {
			$data = Model::fetch("SELECT * FROM comment where idx = ?", [$_GET['idx']]);
			access($this->param->isMember && $this->param->member->idx == $data->midx, "자신이 작성한 댓글만 삭제 할 수 있습니다.");
			Model::query("DELETE FROM comment where idx = ?", [$_GET['idx']]);
			alert("삭제 되었습니다.");
			move(HOME."/movie/info?code=".$data->movieCode);
		}

		function ticketing () {
			if (isset($_GET['day'])) {
				$this->time_list = Model::fetchAll("SELECT ml.*, m.title, t.name FROM movielist ml JOIN movie m ON m.code = ml.movieCode JOIN theater t ON t.code = ml.theaterCode where day = ?", [$_GET['day']]);
			}
		}
	}