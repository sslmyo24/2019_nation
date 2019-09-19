<?php
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
			$barMargin = ($xWidth - $barLen*3)/(3 - 1);
				header("Content-Type: image/jpeg");

				$image = imagecreatetruecolor($width, $height);

				$black = imagecolorallocate($image, 0, 0, 0);
				$bg = imagecolorallocate($image, 230, 230, 230);
				imagefill($image, 0, 0, $bg);
			
				imageline($image, $xmargin, 60, $xmargin, $ymargin, $black);
				imageline($image, $xmargin, $ymargin, $width - 40, $ymargin, $black);
				imagestring($image, 5, $xmargin + 20, 30, 'browser', $black);

				imagestring($image, 4, $xmargin - 20, $yend, 40, $black);
				imagestring($image, 4, $xmargin - 20, ($yend + $ystart)/2, 40/2, $black);
				imagestring($image, 4, $xmargin - 15, $ystart, 0, $black);
			$color = imagecolorallocate($image, 242, 159, 168);
					$h = $ystart - (1/40*$maxHeight);
					imagefilledrectangle($image, $xstart + $barMargin*0, $ymargin, $xstart + $barLen + $barMargin*0, $h, $color);
					imagestring($image, 4, $xstart + 7 + $barMargin*0, $h - 20, 1, $black);
					imagestring($image, 3, $xstart - 12 + $barMargin*0, $ystart + 20, 'Firefox 70.0', $black);
				$color = imagecolorallocate($image, 227, 198, 83);
					$h = $ystart - (38/40*$maxHeight);
					imagefilledrectangle($image, $xstart + $barMargin*1, $ymargin, $xstart + $barLen + $barMargin*1, $h, $color);
					imagestring($image, 4, $xstart + 7 + $barMargin*1, $h - 20, 38, $black);
					imagestring($image, 3, $xstart - 27 + $barMargin*1, $ystart + 20, 'Google Chrome 76.0.3809.132', $black);
				$color = imagecolorallocate($image, 214, 213, 107);
					$h = $ystart - (1/40*$maxHeight);
					imagefilledrectangle($image, $xstart + $barMargin*2, $ymargin, $xstart + $barLen + $barMargin*2, $h, $color);
					imagestring($image, 4, $xstart + 7 + $barMargin*2, $h - 20, 1, $black);
					imagestring($image, 3, $xstart - 21 + $barMargin*2, $ystart + 20, 'Internet Explorer 7.0', $black);
				imagejpeg($image);