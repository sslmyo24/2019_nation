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
			$color = imagecolorallocate($image, 242, 159, 168);
					imagefilledarc($image, $width/2, $height/2, $pieW, $pieH, 0, 0+9, $color, IMG_ARC_PIE);
				$color = imagecolorallocate($image, 227, 198, 83);
					imagefilledarc($image, $width/2, $height/2, $pieW, $pieH, 9, 9+342, $color, IMG_ARC_PIE);
				$color = imagecolorallocate($image, 214, 213, 107);
					imagefilledarc($image, $width/2, $height/2, $pieW, $pieH, 351, 351+9, $color, IMG_ARC_PIE);
				imagejpeg($image);