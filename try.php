<?php 
include "ResizeImage.php";

header("Content-Type: image/png");

// read the images from file
$profilepic = imagecreatefromjpeg("ben.jpg");

$profilepicWidth = imagesx($profilepic);
$profilepicHeight = imagesy($profilepic);

// create the black image overlay
$blackoverlay = imagecreate($profilepicWidth, $profilepicHeight);
imagecolorallocate($blackoverlay, 0, 0, 0);

// then merge the black and profilepic
imagecopymerge($profilepic, $blackoverlay, 0, 0, 0, 0, $profilepicWidth, $profilepicHeight, 50);

// merge the resized logo
$logo = resizeImage("logo.png", $profilepicWidth, 99999);
imageAlphaBlending($logo, false);
imageSaveAlpha($logo, true);

$logoWidth = imagesx($logo);
$logoHeight = imagesy($logo);

$verticalOffset = ($profilepicHeight / 2) - ($logoHeight / 2);

imagecopyresampled($profilepic, $logo, 0, $verticalOffset, 0, 0, $logoWidth, $logoHeight, $logoWidth, $logoHeight);

imagepng($profilepic);
?>
