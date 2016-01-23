<?php
require_once __DIR__ . '/vendor/autoload.php';

session_start();
include 'hnrsecret.php';
$fb = new Facebook\Facebook([
  'app_id' => $app_id,
  'app_secret' => $app_secret,
  'default_graph_version' => 'v2.5',
  'default_access_token' => isset($_SESSION['facebook_access_token']) ? $_SESSION['facebook_access_token'] : $app_id.'|'.$app_secret
]);

try {
  $request = $fb->request('GET', '/me/picture?type=large');
  
  $response = $request->execute();
  $graphObject = $response->getGraphObject();
  // echo 'Name: ' . $user['name'];
  // echo 'Name: ' . $user['picture']['url'];
  // $url = $user['picture']['url'];
  $img = 'originalpics/test.jpg';
  file_put_contents($img, $graphObject);
  exit; //redirect, or do whatever you want
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // echo 'Graph returned an error: ' . $e->getMessage();
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // echo 'Facebook SDK returned an error: ' . $e->getMessage();
}

$helper = $fb->getRedirectLoginHelper();
$permissions = ['public_profile'];
$loginUrl = $helper->getLoginUrl('http://hacknrollify.nuscomputing.tk/getmerolling.php', $permissions);

echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';

?>
<html>
<head>
<title>HacknRollify</title>
</head>
<body>
  <H1>HacknRollify</H1>

<a href="/imagemerge.php">try merge</a>

</body>
</html>
