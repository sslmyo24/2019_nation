

				<?php
					header("Content-Type: image/jpeg");

					$image = imagecreate(1000, 400);
					imagecolorallocate($image, 255, 255, 255);
					$line = imagecolorallocate($image, 0, 0, 0);

					imageline($image, 0, 0, 1000, 0, $line);

					imagejpeg($image);
					imagedestroy($image);

			