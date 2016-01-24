

<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
  <script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
  <style type="text/css">
    h1 {
      color: white;
      font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
      font-weight: 200;
      padding-top: 20%;
    }

    body {
      background-image: linear-gradient(to right, #dd4b39 0, #720e9e 100%);
    }

    .pure-button {
      background: #3B5998;
      color: white;
      font-family: "Lucida Grande", "Tahoma";
      transition: background .4s ease;
    }

    .transparent {
      display: inline-block;
      width: 100%;
      height: 100%;
      background: rgba(255, 255, 255, 0.1);
      text-align: center;
      margin: auto;
      padding-top: 
    }

  </style>
  <title>HacknRollify</title>
</head>
<body>
  <div class="transparent">
    <h1>HacknRollify</h1>
    <?php
    require_once __DIR__ . '/vendor/autoload.php';
    include 'hnrsecret.php';
    include 'lib_hacknrollify.php';
    use Facebook\FacebookRequest;
    use Facebook\GraphObject;
    use Facebook\FacebookRequestException;

    session_start();
    $fb = new Facebook\Facebook([
      'app_id' => $app_id,
      'app_secret' => $app_secret,
      'default_graph_version' => 'v2.5',
      'default_access_token' => isset($_SESSION['facebook_access_token']) ? $_SESSION['facebook_access_token'] : $app_id.'|'.$app_secret
      ]);

    try {
      $response = $fb->get('/me?fields=id,picture.width(10000)');
      
      $user = $response->getGraphUser();
      // echo 'Name: ' . $user['id'];
      $url = $user['picture']['url'];
      $img = $user['id'].'.jpg';
      file_put_contents('originalpics/'.$img, file_get_contents($url));
      $editedpath = hacknrollify($img);
      // echo 'newpath ' . $editedpath;

    ?>

      <p>The file <?php echo $img ?> has been uploaded.</p>
      <p>Enjoy your new picture below!</p>
      <a class="btn btn-info" href="<?php echo $editedpath ?>" download="<?php echo "hnr_".$img ?>">Download</a>
      <hr>
      <img src="<?php echo $editedpath ?>">

    <?php 

    } catch(Facebook\Exceptions\FacebookResponseException $e) {
      // echo 'Graph returned an error: ' . $e->getMessage();
      $helper = $fb->getRedirectLoginHelper();
      $permissions = ['public_profile'];
      $loginUrl = $helper->getLoginUrl('http://hacknrollify.nuscomputing.tk/getmerolling.php', $permissions);
      echo '<a id="fbLink" href="' . $loginUrl . '"> Log in with Facebook!</a>';
    
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
      // echo 'Facebook SDK returned an error: ' . $e->getMessage();
    }

    ?>

    <script type="text/javascript">
    // Shift facebook login link to the bottom of <h1> HacknRollify
    var link = $("#fbLink");
    link.addClass("pure-button").prepend("<i class=\"fa fa-facebook-official\"></i>");
    </script>
  </div>
</body>
</html>