<?php
$src = imagecreatefrompng('filled_logo.png');
$dest = imagecreatefromjpeg('ben.jpg');

imagealphablending($dest, false);
imagesavealpha($dest, true);

imagecopymerge($dest, $src, 0, 0, 0, 0, 900, 880, 50); //have to play with these numbers for it to work for you, etc.

header('Content-Type: image/png');
imagepng($dest);

imagedestroy($dest);
imagedestroy($src);
?>
