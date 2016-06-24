<?php
session_start();
require_once 'google-api-php-client/src/Google_Client.php';
require_once 'google-api-php-client/src/contrib/Google_AnalyticsService.php';
print "connect me";
$client = new Google_Client();
$client->setApplicationName('Hello Analytics API Sample');
print "connect me2";
// Visit https://console.developers.google.com/ to generate your
// client id, client secret, and to register your redirect uri.
$client->setClientId('30476560005-14bbj43rv9mobfo6fopkemdr4tcs4c8h.apps.googleusercontent.com');
$client->setClientSecret('ajIGKhNOMD5-YTJfv5tkon4q');
$client->setRedirectUri('http://www.tviwebdev2.com/analytics/hello.php');
$client->setDeveloperKey('AIzaSyC4jYf8doyxn-_ynGeKl9rCcP51UnZ975U');
$client->setScopes(array('https://www.googleapis.com/auth/analytics.readonly'));
print "connect me3";
// Magic. Returns objects from the Analytics Service instead of associative arrays.
$client->setUseObjects(true);
if (isset($_GET['code'])) {
  $client->authenticate();
  $_SESSION['token'] = $client->getAccessToken();
  $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
  header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}
print "connect me4";
if (isset($_SESSION['token'])) {
  $client->setAccessToken($_SESSION['token']);
}
print "connect me56";
if (!$client->getAccessToken()) {
  $authUrl = $client->createAuthUrl();
  print "<a class='login' href='$authUrl'>Connect Me!</a>";
  print "connect me56";
} else {
	$analytics = new apiAnalyticsService($client);
	runMainDemo($analytics);
	print "connect me78";
}
print "connect me5";
?>
