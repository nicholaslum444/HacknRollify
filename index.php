

<html>
<head>
  <title>HacknRollify</title>
</head>
<body>
  <H1>HacknRollify</H1>
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

echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // echo 'Facebook SDK returned an error: ' . $e->getMessage();
}

?>
  
</body>
</html>