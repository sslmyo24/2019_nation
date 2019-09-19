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
				$option_list = ['referer', 'os', 'browser', 'device'];

				$i = 1;
				foreach ($option_list as $option) {
					$order = $option === "browser" ? "FIELD(os, 'Window', 'Linux', 'iOS')" : 'cnt desc';
					if ($option === "referer") $order .= " limit 5";
					$list = DB::fetchAll("SELECT count(*) as cnt, {$option} FROM statistic where date >= '{$_GET['start_date']}' and date <= '{$_GET['end_date']}' group by {$option} order by {$order}");
					if ($option === "referer" && count($list) >= 5) {
						$referers = [];
						foreach ($list as $data) $referers[] = "'{$data->referer}'";
						$referers = implode(",", $referers);
						$list[] = (Object)array("cnt" => DB::rowCount("SELECT * FROM statistic where date >= '{$_GET['start_date']}' and date <= '{$_GET['end_date']}' and referer NOT in ({$referers})"), "referer" => "기타");
					}
					$this->draw_graph($list, $option, $i);
					$i++;
 				}
			}
		}

		function draw_graph ($list, $standard, $idx) {

			$dataCnt = count($list);

			$max = 0;
			$sum = 0;
			foreach ($list as $data) {
				if ($max < $data->cnt) $max = $data->cnt;
				$sum += $data->cnt;
			}
			$max = floor($max/10)*10 < $max ? (floor($max/10)+1)*10 : $max;

			$bar = $pie =
'<?php';

			$bar .= '
				$width = 1100;
				$height = 400;
				$xmargin = 60;
				$ymargin = $height - $xmargin;
				$xstart = $xmargin*10/3;
				$xend = $width - $xmargin*4/3;
				$ystart = $ymargin - 15;
				$yend = 100;
				$maxHeight = $ystart - $yend;
				$xWidth = $xend - $xstart;
				$barLen = 50;
				$barMargin = 0;
			';

			$pie .= '
				$width = 400;
				$height = 400;
				$pieW = 300;
				$pieH = 300;
			';

			if ($dataCnt > 1) $bar .= '$barMargin = ($xWidth - $barLen*'.$dataCnt.')/('.$dataCnt.' - 1);';
	
			$default = '
				header("Content-Type: image/jpeg");

				$image = imagecreatetruecolor($width, $height);

				$black = imagecolorallocate($image, 0, 0, 0);
				$bg = imagecolorallocate($image, 230, 230, 230);
				imagefill($image, 0, 0, $bg);
			';

			$bar .= $default.'
				imageline($image, $xmargin, 60, $xmargin, $ymargin, $black);
				imageline($image, $xmargin, $ymargin, $width - 40, $ymargin, $black);
				imagestring($image, 5, $xmargin + 20, 30, \''.$standard.'\', $black);

				imagestring($image, 4, $xmargin - 20, $yend, '.$max.', $black);
				imagestring($image, 4, $xmargin - 20, ($yend + $ystart)/2, '.$max.'/2, $black);
				imagestring($image, 4, $xmargin - 15, $ystart, 0, $black);
			';

			$pie .= $default.'';

			$i = 0;
			$lastAngle = 0;
			foreach ($list as $data) {

				$num1 = rand(0, 255);
				$num2 = rand(0, 255);
				$num3 = rand(0, 255);

				$color = '$color = imagecolorallocate($image, '.$num1.', '.$num2.', '.$num3.');';

				$len = strlen($data->$standard);
				$bar .= $color.'
					$h = $ystart - ('.$data->cnt.'/'.$max.'*$maxHeight);
					imagefilledrectangle($image, $xstart + $barMargin*'.$i.', $ymargin, $xstart + $barLen + $barMargin*'.$i.', $h, $color);
					imagestring($image, 4, $xstart + 7 + $barMargin*'.$i.', $h - 20, '.$data->cnt.', $black);
					imagestring($image, 3, $xstart - '.$len.' + $barMargin*'.$i.', $ystart + 20, \''.$data->$standard.'\', $black);
				';

				$angle = $data->cnt/$sum*360;

				$pie .= $color.'
					imagefilledarc($image, $width/2, $height/2, $pieW, $pieH, '.$lastAngle.', '.$lastAngle.'+'.$angle.', $color, IMG_ARC_PIE);
				';

				$lastAngle += $angle;
				$i++;
			}

			$bar .= 'imagejpeg($image);';
			$pie .= 'imagejpeg($image);';

			$bar_file = fopen("./img/graph/bar{$idx}.php", "w");
			fwrite($bar_file, $bar);
			fclose($bar_file);

			$pie_file = fopen("./img/graph/pie{$idx}.php", "w");
			fwrite($pie_file, $pie);
			fclose($pie_file);
		}

	}