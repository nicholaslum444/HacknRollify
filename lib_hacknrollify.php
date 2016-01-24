<?php 
include "ResizeImage.php";

function hacknrollify($picfilename) {
    $logofilename = "logo.png";
    $logoPicPath = "logopics/".$logofilename;

    $originalPicPath = "originalpics/".$picfilename;

    $editedfilename = "hnr_".$picfilename;
    $editedPicPath = "editedpics/".$editedfilename;

    // read the original image from file
    $profilepic = imagecreatefromjpeg($originalPicPath);

    $profilepicWidth = imagesx($profilepic);
    $profilepicHeight = imagesy($profilepic);

    // create the black image overlay
    $blackoverlay = imagecreate($profilepicWidth, $profilepicHeight);
    imagecolorallocate($blackoverlay, 0, 0, 0);

    // then merge the black and profilepic
    imagecopymerge($profilepic, $blackoverlay, 0, 0, 0, 0, $profilepicWidth, $profilepicHeight, 50);
    imagedestroy($blackoverlay);

    // merge the resized logo
    $logo = resizeImage($logoPicPath, $profilepicWidth - 80, 999999);
    imageAlphaBlending($logo, false);
    imageSaveAlpha($logo, true);

    $logoWidth = imagesx($logo);
    $logoHeight = imagesy($logo);

    $verticalOffset = ($profilepicHeight / 2) - ($logoHeight / 2);
    $horizontalOffset = 40;

    imagecopyresampled($profilepic, $logo, $horizontalOffset, $verticalOffset, 0, 0, $logoWidth, $logoHeight, $logoWidth, $logoHeight);

    $mergeSuccess = imagejpeg($profilepic, $editedPicPath);

    if (!$mergeSuccess) {
            echo("Image merge failed!");
    }

    imagedestroy($profilepic);
    imagedestroy($logo);

    return $editedPicPath;
}
?>
