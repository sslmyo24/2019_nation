<?php
	namespace app\controller;

	use app\core\App;
	use app\core\DB;

	class Booth extends App {

		function admin () {
			access($this->member() && $this->member()->level == 'C', "관리자만 접근가능합니다.");
		}

		function getPlanData ($option, $filter = false) {
			$this->plan_list = DB::fetchAll("SELECT * FROM plan where {$option} order by start_date");
			$this->select_plan = isset($_GET['pidx']) ? DB::fetch("SELECT * FROM plan where idx = ?", [$_GET['pidx']]) : $this->plan_list[0];
			$sql = "SELECT c.*, p.start_date, p.end_date, m.name FROM company c JOIN plan p ON p.idx = c.pidx JOIN member m ON m.idx = c.midx";
			if ($filter) $sql .= " where p.idx = ".$this->select_plan->idx;
			$this->company_list = DB::fetchAll($sql);
		}

		function company () {
			access($this->member() && $this->member()->level == 'B', "기업회원만 접근가능합니다.");
			$this->getPlanData('start_date > now()');
			$connected = [];
			if (count($this->company_list) > 0)
				foreach ($this->company_list as $data)
					if ($data->pidx == $this->select_plan->idx) $connected[] = $data->booth;
			$this->connected = json_encode($connected);
		}

		function plan () {
			$this->getPlanData('DATE_SUB(end_date, INTERVAL 1 DAY) >= date(now())', true);
		}

		function ticketing () {
			access($this->member(), "로그인 후 사용가능합니다.");
			$this->plan_list = DB::fetchAll("SELECT * FROM plan where DATE_SUB(end_date, INTERVAL 1 DAY) >= date(now()) order by start_date");
			if (isset($_GET['pidx'])) {
				$this->cnt = DB::rowCount("SELECT * FROM ticketing where pidx = ?", [$_GET['pidx']]);
				$this->max = DB::fetch("SELECT max FROM plan where idx = ?", [$_GET['pidx']])->max;
				$this->ticketing_list = DB::fetchAll("SELECT t.*, p.start_date, p.end_date FROM ticketing t JOIN plan p ON p.idx = t.pidx where pidx = ? and midx = ?", [$_GET['pidx'], $this->member()->idx]);
			}

		}


		function graph () {
			$cnt = DB::rowCount("SELECT * FROM ticketing where pidx = ?", [$_GET['pidx']]);
			$max = DB::fetch("SELECT max FROM plan where idx = ?", [$_GET['pidx']])->max;

			$w = 500;
			$h = 500;

			$img = imagecreatetruecolor($w, $h);
			$bg = imagecolorallocate($img, 180, 180, 180);
			$data = imagecolorallocate($img, 100, 100, 100);

			imagefill($img, 0, 0, imagecolorallocate($img, 255,255,255));
			imagefilledarc($img, $w/2, $h/2, 400, 400, 0, $cnt/$max*360, $data, IMG_ARC_PIE);
			if ($max > $cnt) imagefilledarc($img, $w/2, $h/2, 400, 400, $cnt/$max*360, 360, $bg, IMG_ARC_PIE);

			header('Content-Type: image/png');
			imagepng($img);
			imagedestroy($img);
		}

		function ticketing_cancel () {
			access(DB::rowCount("SELECT * FROM ticketing t JOIN plan p ON p.idx = t.pidx where t.idx = ? and DATE_SUB(p.end_date, INTERVAL 1 DAY) >= date(now())", [$_GET['idx']]) > 0, "행사종료일이 최소 1일 이상 남아야 취소가 가능합니다.");
			DB::query("DELETE FROM ticketing where idx = ?", [$_GET['idx']]);
			move(HOME."/booth/ticketing");
		}

		function action () {
			extract($_POST);

			switch ($action) {
				case 'setPlan':

					access(DB::rowCount("SELECT * FROM plan where start_date <= ? and end_date >= ?", [$end_date, $start_date]) == 0, "기존 행사일정과 겁칩니다.", HOME."/admin");

					DB::query("INSERT INTO plan SET start_date = ?, end_date = ?, layout = ?, max = ?", [$start_date, $end_date, $layout, $max]);
					break;
				case 'setBooth':

					$booth = explode(",", $booth);

					DB::query("INSERT INTO company SET pidx = ?, midx = ?, date = now(), booth = ?, area = ?", [$pidx, $this->member()->idx, $booth[0], $booth[1]]);

					break;
				case 'ticketing':

					access(isset($pidx), "행사일정을 선택해주세요");

					$cnt = DB::rowCount("SELECT * FROM ticketing where pidx = ?", [$_GET['pidx']]);
					$max = DB::fetch("SELECT max FROM plan where idx = ?", [$_GET['pidx']])->max;
					access($cnt < $max, "참관 가능 인원 정원을 초과하였습니다.");

					DB::query("INSERT INTO ticketing SET pidx = ?, midx = ?, date = now()", [$pidx, $this->member()->idx]);
					break;
			}
		}

	}