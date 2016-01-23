<?php 
require "ImageResize.php";
include "ResizeImage.php";
use \Eventviva\ImageResize;

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
$logoResized = resizeImage("logo.png", $profilepicWidth, 99999);
imagecopymerge($profilepic, $logoResized, 0, 0, 0, 0, imagesx($logoResized), imagesy($logoResized), 100);

header("Content-Type: image/png");
imagepng($profilepic);
?>
