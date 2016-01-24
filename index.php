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

echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';

?>
<html>
<head>
  <title>HacknRollify</title>
</head>
<body>
  <H1>HacknRollify</H1>
</body>
</html>
