<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Hack n' Rollify your pictures">
    <meta name="author" content="Hack n' Rollify Team">
	
	<link rel="icon" href="favicon.png">

    <title>Hack n' Rollify Me!</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/landing-page.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top topnav" role="navigation">
        <div class="container topnav">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand topnav" href="/hacknrollify#upload">Hack n' Rollify</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="/hacknrollify#upload">Back</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
	
	
    <!-- Header -->
    <a name="about"></a>
    <div class="intro-header">
        <div class="container">

            <div class="row">
                <div class="col-lg-12">
                    <div class="intro-message">
						<?php
						require "../lib_hacknrollify.php";

						$target_dir = "originalpics/";
						$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
						$uploadOk = 1;
						$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
						// Check if image file is a actual image or fake image
						if(isset($_POST["submit"])) {
							$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
							if($check !== false) {
								//echo "File is an image - " . $check["mime"] . ".";
								$uploadOk = 1;
							} else {
								echo "<p>File is not an image.</p>";
								$uploadOk = 0;
							}
						}
						// Check file size
						if ($_FILES["fileToUpload"]["size"] > 5000000) {
							echo "<p>Sorry, your file is too large.</p>";
							$uploadOk = 0;
						}
						// Allow certain file formats
						if($imageFileType != "jpg") {
						?>
							<p>Sorry, only JPG files are allowed.</p>
						<?php
							$uploadOk = 0;
						}
						// Check if $uploadOk is set to 0 by an error
						if ($uploadOk == 0) {
						?>
						
							<p>Sorry, your file was not uploaded.</p>
						<?php
						// if everything is ok, try to upload file
						} else {
							$moveSuccess = move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
							if ($moveSuccess) {
								$editedPicPath = hacknrollify(basename($_FILES["fileToUpload"]["name"]));
								$editedFilename = basename( $_FILES["fileToUpload"]["name"]);
						?>

							<p>The file <?php echo $editedFilename ?> has been uploaded. Check it out below or download it directly.</p>

						<?php
							} else {
						?>
								<p>Sorry, there was an error uploading your file.</p>
						<?php
							}
						}
						?>
							<hr class="intro-divider">
							<ul class="list-inline intro-social-buttons">
						<?php 
						if ($moveSuccess) {
						?>
							<li>
								<a href="<?php echo $editedPicPath ?>" download class="btn btn-success btn-lg"><i class="fa fa-download fa-fw"></i> <span class="network-name">Download</span></a>
							</li>
						<?php 
						}
						?>
							<li>
								<a href="/hacknrollify" class="btn btn-warning btn-lg"><i class="fa fa-hand-o-left fa-fw"></i> <span class="network-name">Back</span></a>
							</li>
						</ul>
				</div>
                </div>
            </div>

        </div>
        <!-- /.container -->

    </div>
    <!-- /.intro-header -->

	<hr>
	
    <div class="image-block">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
				<?php
				if ($moveSuccess) {
					?>
					<img class="img-responsive img-rounded" src="<?php echo $editedPicPath ?>">
					<?php
				}
				?>
				</div>
			</div>
		</div>
	</div>
</body>
</html>

