<?php

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
	$barMargin = ($xWidth - $barLen*6)/(6 - 1);	$image = imagecreatetruecolor($width, $height);

	$black = imagecolorallocate($image, 0, 0, 0);
	$bg = imagecolorallocate($image, 230, 230, 230);
	// $text_color = imagecolorallocate($image, 44, 46, 80);
	$bar = imagecolorallocate($image, 0, 160, 255);

	imagefill($image, 0, 0, $bg);
	imageline($image, $xmargin, 60, $xmargin, $ymargin, $black);
	imageline($image, $xmargin, $ymargin, $width - 40, $ymargin, $black);
	imagestring($image, 5, $xmargin + 20, 30, 'referer', $black);

	imagestring($image, 4, $xmargin - 20, $yend, 10, $black);
	imagestring($image, 4, $xmargin - 20, ($yend + $ystart)/2, 10/2, $black);
	imagestring($image, 4, $xmargin - 15, $ystart, 0, $black);

	$h = $ystart - (7/10*$maxHeight);
	imagefilledrectangle($image, $xstart + $barMargin*0, $ymargin, $xstart + $barLen + $barMargin*0, $h, $bar);
	imagestring($image, 4, $xstart + 7 + $barMargin*0, $h - 20, 7, $black);
	imagestring($image, 2, $xstart - 17 + $barMargin*0, $ystart + 20, '/builderstatistic', $black);
				
	$h = $ystart - (3/10*$maxHeight);
	imagefilledrectangle($image, $xstart + $barMargin*1, $ymargin, $xstart + $barLen + $barMargin*1, $h, $bar);
	imagestring($image, 4, $xstart + 7 + $barMargin*1, $h - 20, 3, $black);
	imagestring($image, 2, $xstart - 6 + $barMargin*1, $ystart + 20, '/admin', $black);
				
	$h = $ystart - (2/10*$maxHeight);
	imagefilledrectangle($image, $xstart + $barMargin*2, $ymargin, $xstart + $barLen + $barMargin*2, $h, $bar);
	imagestring($image, 4, $xstart + 7 + $barMargin*2, $h - 20, 2, $black);
	imagestring($image, 2, $xstart - 0 + $barMargin*2, $ystart + 20, '', $black);
				
	$h = $ystart - (2/10*$maxHeight);
	imagefilledrectangle($image, $xstart + $barMargin*3, $ymargin, $xstart + $barLen + $barMargin*3, $h, $bar);
	imagestring($image, 4, $xstart + 7 + $barMargin*3, $h - 20, 2, $black);
	imagestring($image, 2, $xstart - 19 + $barMargin*3, $ystart + 20, '/imggraphstick3.php', $black);
				
	$h = $ystart - (1/10*$maxHeight);
	imagefilledrectangle($image, $xstart + $barMargin*4, $ymargin, $xstart + $barLen + $barMargin*4, $h, $bar);
	imagestring($image, 4, $xstart + 7 + $barMargin*4, $h - 20, 1, $black);
	imagestring($image, 2, $xstart - 21 + $barMargin*4, $ystart + 20, '/http:localhost:88013', $black);
				
	$h = $ystart - (1/10*$maxHeight);
	imagefilledrectangle($image, $xstart + $barMargin*5, $ymargin, $xstart + $barLen + $barMargin*5, $h, $bar);
	imagestring($image, 4, $xstart + 7 + $barMargin*5, $h - 20, 1, $black);
	imagestring($image, 2, $xstart - 4 + $barMargin*5, $ystart + 20, '/013', $black);
				
	$h = $ystart - (1/10*$maxHeight);
	imagefilledrectangle($image, $xstart + $barMargin*6, $ymargin, $xstart + $barLen + $barMargin*6, $h, $bar);
	imagestring($image, 4, $xstart + 7 + $barMargin*6, $h - 20, 1, $black);
	imagestring($image, 2, $xstart - 4 + $barMargin*6, $ystart + 20, '/012', $black);
				
	$h = $ystart - (1/10*$maxHeight);
	imagefilledrectangle($image, $xstart + $barMargin*7, $ymargin, $xstart + $barLen + $barMargin*7, $h, $bar);
	imagestring($image, 4, $xstart + 7 + $barMargin*7, $h - 20, 1, $black);
	imagestring($image, 2, $xstart - 8 + $barMargin*7, $ystart + 20, '/builder', $black);
				
	imagejpeg($image);