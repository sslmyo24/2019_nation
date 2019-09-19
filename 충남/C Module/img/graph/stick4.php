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
	$image = imagecreatetruecolor($width, $height);

	$black = imagecolorallocate($image, 0, 0, 0);
	$bg = imagecolorallocate($image, 230, 230, 230);
	// $text_color = imagecolorallocate($image, 44, 46, 80);
	$bar = imagecolorallocate($image, 0, 160, 255);

	imagefill($image, 0, 0, $bg);
	imageline($image, $xmargin, 60, $xmargin, $ymargin, $black);
	imageline($image, $xmargin, $ymargin, $width - 40, $ymargin, $black);
	imagestring($image, 5, $xmargin + 20, 30, 'device', $black);

	imagestring($image, 4, $xmargin - 20, $yend, 20, $black);
	imagestring($image, 4, $xmargin - 20, ($yend + $ystart)/2, 20/2, $black);
	imagestring($image, 4, $xmargin - 15, $ystart, 0, $black);

	$h = $ystart - (18/20*$maxHeight);
	imagefilledrectangle($image, $xstart + $barMargin*0, $ymargin, $xstart + $barLen + $barMargin*0, $h, $bar);
	imagestring($image, 4, $xstart + 7 + $barMargin*0, $h - 20, 18, $black);
	imagestring($image, 2, $xstart - 6 + $barMargin*0, $ystart + 20, 'Mobile', $black);
				
	imagejpeg($image);