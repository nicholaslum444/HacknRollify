<!DOCTYPE html>
<html lang="en">
<head>
<title>Hack n' Rollify Me!</title>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

</head>

<body>
<div class="container">

    <div class="row">
        <div class="col-xs-12 text-center">
            <h1>Hack n' Rollify Me!</h1>
            <p><em>Put the Hack &amp; Roll logo on your pictures!</em></p>
        </div>
        <div class="col-xs-12 text-center">
            <h4>Example:</h4>
        </div>
        <?php
        $names = array("kailin", "many", "nick");
        foreach ($names as $name) {
        ?>
            <div class="col-xs-4">
                <img class="img-rounded img-responsive" src="samplepics/hnr_<?php echo $name ?>.jpg">
            </div>
        <?php
        }
        ?>
    </div>

    <hr>
    <div class="row">
        <div class="col-sm-4 col-sm-offset-4">
        <div class="panel">
            <form action="upload.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="fileToUpload">Image Upload</label>
                    <input type="file" name="fileToUpload" id="fileToUpload">
                    <p class="help-block">Select an image to Hack n' Rollify!</p>
                </div>
                <input class="btn btn-default" type="submit" value="Upload Image" name="submit">
            </form>
        </div>
        </div>
    </div>

</div>
</body>
</html>
