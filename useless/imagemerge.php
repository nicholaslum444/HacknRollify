<?php

$picfilename = "ben.jpg";
$hacknrollifiedPicfilename = "hnr_".$picfilename;

$originalPicPath = "originalpics/".$picfilename;
$editedPicPath = "editedpics/".$hacknrollifiedPicfilename;

//$mergeSuccess = imagejpeg(hacknrollify($originalPicPath), $editedPicPath);

if (!$mergeSuccess) {
    //die("Image merge failed!");
}

?>
<html>
<head>
<title>Image Merge</title>
</head>
<body>
<form action="upload.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>
</body>
</html>
