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
			
				header("Content-Type: image/jpeg");

				$image = imagecreatetruecolor($width, $height);

				$black = imagecolorallocate($image, 0, 0, 0);
				$bg = imagecolorallocate($image, 230, 230, 230);
				imagefill($image, 0, 0, $bg);
			
				imageline($image, $xmargin, 60, $xmargin, $ymargin, $black);
				imageline($image, $xmargin, $ymargin, $width - 40, $ymargin, $black);
				imagestring($image, 5, $xmargin + 20, 30, 'device', $black);

				imagestring($image, 4, $xmargin - 20, $yend, 40, $black);
				imagestring($image, 4, $xmargin - 20, ($yend + $ystart)/2, 40/2, $black);
				imagestring($image, 4, $xmargin - 15, $ystart, 0, $black);
			$color = imagecolorallocate($image, 33, 34, 174);
					$h = $ystart - (40/40*$maxHeight);
					imagefilledrectangle($image, $xstart + $barMargin*0, $ymargin, $xstart + $barLen + $barMargin*0, $h, $color);
					imagestring($image, 4, $xstart + 7 + $barMargin*0, $h - 20, 40, $black);
					imagestring($image, 3, $xstart - 2 + $barMargin*0, $ystart + 20, 'PC', $black);
				imagejpeg($image);