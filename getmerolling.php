<?php
require_once __DIR__ . '/vendor/autoload.php';

session_start();
include 'hnrsecret.php';
$fb = new Facebook\Facebook([
  'app_id' => $app_id,
  'app_secret' => $app_secret,
  'default_graph_version' => 'v2.5',
  'default_access_token' => $app_id.'|'.$app_secret
]);
$helper = $fb->getRedirectLoginHelper();

try {
  $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
}

if (isset($accessToken)) {
  // Logged in!
  $oAuth2Client = $fb->getOAuth2Client();
  $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
  $_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
} elseif ($helper->getError()) {
  // The user denied the request
}
header('Location: index.php');
?>
