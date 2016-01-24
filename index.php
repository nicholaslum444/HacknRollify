<?php
require_once __DIR__ . '/vendor/autoload.php';

session_start();
include 'hnrsecret.php';
include 'lib_hacknrollify.php';
use Facebook\FacebookRequest;
use Facebook\GraphObject;
use Facebook\FacebookRequestException;
$fb = new Facebook\Facebook([
  'app_id' => $app_id,
  'app_secret' => $app_secret,
  'default_graph_version' => 'v2.5',
  'default_access_token' => isset($_SESSION['facebook_access_token']) ? $_SESSION['facebook_access_token'] : $app_id.'|'.$app_secret
  ]);

try {
  $response = $fb->get('/me?fields=id,picture.width(10000)');
  
  $user = $response->getGraphUser();
  echo 'Name: ' . $user['id'];
  $url = $user['picture']['url'];
  $img = $user['id'].'.jpg';
  file_put_contents('originalpics/'.$img, file_get_contents($url));
  $editedpath = hacknrollify($img);
  echo 'newpath ' . $editedpath;
  
  $data = [
  'message' => 'My awesome photo upload example.',
  'source' => $fb->fileToUpload($editedpath),
  ];

try {
  // Returns a `Facebook\FacebookResponse` object
  $response = $fb->post('/me/photos', $data);

} catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

$graphNode = $response->getGraphNode();

echo 'Photo ID: ' . $graphNode['id'];
  header('Location: http://www.facebook.com/photo.php?fbid='.$graphNode['id'].'&makeprofile=1');
  exit; //redirect, or do whatever you want
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // echo 'Graph returned an error: ' . $e->getMessage();
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // echo 'Facebook SDK returned an error: ' . $e->getMessage();
}



$helper = $fb->getRedirectLoginHelper();
$permissions = ['public_profile', 'publish_actions'];
$loginUrl = $helper->getLoginUrl('http://hacknrollify.nuscomputing.tk/getmerolling.php', $permissions);

echo '<a id="fbLink" href="' . $loginUrl . '"> Log In with Facebook</a>';

?>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
  <script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
  <title>HacknRollify</title>

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
</head>
<body>
  <div class="transparent">
    <h1 id="teamName">HacknRollify</h1>
    <script type="text/javascript">
    // Shift facebook login link to the bottom of <h1> HacknRollify
    var link = $("#fbLink")
    link.detach().insertAfter("#teamName");
    link.addClass("pure-button").prepend("<i class=\"fa fa-facebook-official\"></i>");
    </script>
  </div>
</body>
</html>
