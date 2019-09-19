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
					'browser' => 'all',
					'device' => 'all'
				);

				$i = 1;
				foreach ($option_list as $option => $type) {
					$order = $option === "browser" ? "FIELD(os, 'Window', 'Linux', 'iOS')" : 'cnt desc';
					$list = DB::fetchAll("SELECT count(*) as cnt, {$option} FROM statistic where date >= '{$_GET['start_date']}' and date <= '{$_GET['end_date']}' group by {$option} order by {$order}");
					$this->draw_bar_graph($list, $option, $type, $i);
					$i++;
 				}
			}
		}

		function draw_bar_graph ($list, $standard, $type, $idx) {

			$order = explode(",", $type);
			$dataCnt = $type === 'all' ? count($list) : count($order);

			$max = 0;
			foreach ($list as $data) {
				if ($max < $data->cnt) $max = $data->cnt;
			}
			$max = floor($max/10)*10 < $max ? (floor($max/10)+1)*10 : $max;

			$text = 
'<?php

	// header("Content-Type: image/jpeg");

	$width = 700;
	$height = 400;
	$xmargin = 60;
	$ymargin = $height - $xmargin;
	$xstart = $xmargin + 80;
	$xend = $width - 80;
	$ystart = $ymargin - 15;
	$yend = 100;
	$maxHeight = $ystart - $yend;
	$xWidth = $xend - $xstart;
	$barLen = 30;
	$barMargin = 0;
';

			if ($dataCnt > 1) $text .=
'	$barMargin = ($xWidth - $barLen*'.$dataCnt.')/('.$dataCnt.' - 1);';
	
			$text .=
'	$image = imagecreatetruecolor($width, $height);

	$black = imagecolorallocate($image, 0, 0, 0);
	$bg = imagecolorallocate($image, 230, 230, 230);
	// $text_color = imagecolorallocate($image, 44, 46, 80);
	$bar = imagecolorallocate($image, 0, 160, 255);

	imagefill($image, 0, 0, $bg);
	imageline($image, $xmargin, 60, $xmargin, $ymargin, $black);
	imageline($image, $xmargin, $ymargin, $width - 40, $ymargin, $black);
	imagestring($image, 5, $xmargin + 20, 30, \''.$standard.'\', $black);

	imagestring($image, 4, $xmargin - 20, $yend, '.$max.', $black);
	imagestring($image, 4, $xmargin - 20, ($yend + $ystart)/2, '.$max.'/2, $black);
	imagestring($image, 4, $xmargin - 15, $ystart, 0, $black);
';

			$i = 0;
			foreach ($list as $data) {
				$len = strlen($data->$standard);

				$text .= '
	$h = $ystart - ('.$data->cnt.'/'.$max.'*$maxHeight);
	imagefilledrectangle($image, $xstart + $barMargin*'.$i.', $ymargin, $xstart + $barLen + $barMargin*'.$i.', $h, $bar);
	imagestring($image, 4, $xstart + 7 + $barMargin*'.$i.', $h - 20, '.$data->cnt.', $black);
	imagestring($image, 2, $xstart - '.$len.' + $barMargin*'.$i.', $ystart + 20, \''.$data->$standard.'\', $black);
				';

				$i++;
			}

			$text .= '
	imagejpeg($image);';

			$file = fopen("./img/graph/stick{$idx}.php", "w");
			fwrite($file, $text);
			fclose($file);
		}

	}