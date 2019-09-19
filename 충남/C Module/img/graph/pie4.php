<?php
				$width = 400;
				$height = 400;
				$pieW = 300;
				$pieH = 300;
			
				header("Content-Type: image/jpeg");

				$image = imagecreatetruecolor($width, $height);

				$black = imagecolorallocate($image, 0, 0, 0);
				$bg = imagecolorallocate($image, 230, 230, 230);
				imagefill($image, 0, 0, $bg);
			$color = imagecolorallocate($image, 33, 34, 174);
					imagefilledarc($image, $width/2, $height/2, $pieW, $pieH, 0, 0+360, $color, IMG_ARC_PIE);
				imagejpeg($image);