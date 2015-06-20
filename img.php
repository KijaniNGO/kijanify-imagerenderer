<?php
	// get imgage url, title, and width
	$title = urlencode(urldecode($_GET["title"]));
	$image_url = $_GET["imgurl"];
	$width = $_GET["width"];

	// get quality and filetype, or set defaults
	$quality = intval($_GET["qual"]);
	$filetype = $_GET["type"];
	$quality = (0 < $quality && $quality <= 100) ? $quality : 70;
	$filetype = ($filetype == 'jpg' || $filetype == 'png') ? $filetype : 'jpg';

	// filename from unique hash
	$path = "http://kijani.co/imagerenderer/svg.php?img={$image_url}&title={$title}&width={$width}";
	$filename = 'cache/' . hash("md5", $path.$quality) . '.' . $filetype;

	// create image from svg, if needed
	$image = $filetype == 'jpg' ? @imagecreatefromjpeg($filename) : @imagecreatefrompng($filename);
	if ( !$image ) {
		`./phantomjs rasterize.js '{$path}' {$filename} {$quality}`;
		$image = ($filetype == 'jpg') ? imagecreatefromjpeg($filename) : imagecreatefrompng($filename);
	}

	// output image
	if ( $filetype == 'jpg' ) {
		header("Content-type: image/jpeg");
		imagejpeg($image);
	} else {
		header("Content-type: image/png");
		imagepng($image);
	}
?>
