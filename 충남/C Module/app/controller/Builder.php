<?php
	namespace app\controller;

	use app\core\App;
	use app\core\DB;

	class Builder extends App {

		function upload ($file, $type) {
			$save_name = time()."_".rand(0,99999).".{$type}";
			if (!move_uploaded_file($file['tmp_name'], "./data/{$save_name}")) {
				print_r($file);
			}
		}

		function action () {
			extract($_POST);

			switch ($action) {
				case 'imgUpload':
					access(is_uploaded_file($_FILES['img']['tmp_name']), "이미지가 누락되었습니다.");

					$this->upload($_FILES['img'], $type);
					break;

				case 'pageUpload':

					$file_name = "teaser_{$code}.php";
					$file = fopen("./app/view/teaser/{$file_name}", 'w');
					fwrite($file, $html);
					fclose($file);

					if (DB::rowCount("SELECT * FROM page where code = ?", [$code]) == 1) {
						DB::query("UPDATE page SET name = ?, title = ?, description = ?, keyword = ?, mod_date = now() where code = ?", [$name, $title, $description, $keyword, $code]);
					} else {
						DB::query("INSERT INTO page SET code = ?, name = ?, title = ?, description = ?, keyword = ?, html = ?, add_date = now(), mod_date = now()", [$code, $name, $title, $description, $keyword, $file_name]);
					}
					break;
			}
		}

		function builder () {
			if (!$this->url->member) move("/admin");
		}

		function statistic () {

			if (isset($_GET['start_date'])) {
				$option_list = array(
					'referer' => '1,2,3,4,5,others',
					'os' => 'Window,Linux,iOS,others',
					'browser, version' => 'all',
					'device' => 'all'
				);

				$i = 1;
				foreach ($option_list as $option => $type) {
					$order = $option === "browser, version" ? "FIELD(os, 'Window', 'Linux', 'iOS')" : 'cnt desc';
					$list = DB::fetchAll("SELECT count(*) as cnt, {$option} FROM statistic where date >= '{$_GET['start_date']}' and date <= '{$_GET['end_date']}' group by {$option} order by {$order}");
					$this->draw_stick_graph($list, $type, $i);
					$i++;
 				}
			}
		}

		function draw_stick_graph ($data, $type, $idx) {

			$name = "./img/graph/stick{$idx}.php";

			$width = 1000;
			$height = 400;
			$text = '

				<?php
					header("Content-Type: image/jpeg");

					$image = imagecreate('.$width.', '.$height.');
					imagecolorallocate($image, 255, 255, 255);
					$line = imagecolorallocate($image, 0, 0, 0);

					imageline($image, 0, 0, 1000, 0, $line);

					imagejpeg($image);
					imagedestroy($image);

			';

			$file = fopen($name, "w");
			fwrite($file, $text);
			fclose($file);
		}

	}