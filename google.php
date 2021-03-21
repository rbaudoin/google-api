<?php
require_once 'vendor/autoload.php';
  
// init configuration
$clientID = '208456615763-oaiajsokkhf4ae1aq312gqld8k3pnufj.apps.googleusercontent.com';
$clientSecret = '1sxRr8FiY__zf87zm5I3A3FF';
$redirectUri = 'http://localhost/google-api/google.php';
   
// create Client Request to access Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");
$client->addScope("openid");
  
// authenticate code from Google OAuth Flow
if (isset($_GET['code'])) {
  $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
  $client->setAccessToken($token['access_token']);
   
  // get profile info
  $google_oauth = new Google_Service_Oauth2($client);
  $google_account_info = $google_oauth->userinfo->get();
  $email =  $google_account_info->email;
  $name =  $google_account_info->name;
  
  // now you can use this profile info to create account in your website and make user logged in.
echo "Mail:".PHP_EOL;
echo $email;
echo "<br>";
echo "<br>"; 
echo "Nombre:".PHP_EOL;
echo $name;
echo "<br>"; 
echo "<br>";
echo "Token:".PHP_EOL;
echo implode($token);
echo "<br>";
echo "<br>";
echo "UserInfo:".PHP_EOL;
echo serialize($google_account_info);
echo "<br>"; 



} else {
  echo "<a href='".$client->createAuthUrl()."'>Google Login</a>";
}

?>