<?php
session_start(); //session start

require_once ('libraries/Google/autoload.php');

//Insert your cient ID and secret 
//You can get it from : https://console.developers.google.com/
$client_id = '453149326689-5k5b4ar6s49bs1rv0n4k9umno56qf113.apps.googleusercontent.com'; 
$client_secret = 'ZFs4SMg6MhupH6FEGCGKnJC2';
$redirect_uri = 'http://app.housingmatters.co.in/google-login-api/index.php';



//incase of logout request, just unset the session var
if (isset($_GET['logout'])) {
  unset($_SESSION['access_token']);
}

/************************************************
  Make an API request on behalf of a user. In
  this case we need to have a valid OAuth 2.0
  token for the user, so we need to send them
  through a login flow. To do this we need some
  information from our API console project.
 ************************************************/
$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->addScope("email");
$client->addScope("profile");

/************************************************
  When we create the service here, we pass the
  client to it. The client then queries the service
  for the required scopes, and uses that when
  generating the authentication URL later.
 ************************************************/
$service = new Google_Service_Oauth2($client);

/************************************************
  If we have a code back from the OAuth 2.0 flow,
  we need to exchange that with the authenticate()
  function. We store the resultant access token
  bundle in the session, and redirect to ourself.
*/
  
if (isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
   $_SESSION['access_token'] = $client->getAccessToken();
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
  exit;
}

/************************************************
  If we have an access token, we can make
  requests, else we generate an authentication URL.
 ************************************************/
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']);
} else {
  $authUrl = $client->createAuthUrl();
}


//Display user info or display login url as per the info we have.

if (isset($authUrl)){
	//show login url
	echo '<div align="center">';
	echo '<h3>Login with Google -- Demo</h3>';
	echo '<div>Please click login button to connect to Google.</div>';
	echo '<a class="login" href="' . $authUrl . '"><img src="images/google-login-button.png" /></a>';
	echo '</div>';
	
} else {
	
	$user = $service->userinfo->get(); //get user info 
	
	$email=encode($user->email,'Housingmatters_facebook');
	header("Location: http://app.housingmatters.co.in?aqazp2yd=".$email."&source=g&uid=".$user->picture);
}


function encode($string,$key) {
$key = sha1($key);
$strLen = strlen($string);
$keyLen = strlen($key);
for ($i = 0; $i < $strLen; $i++) {
$ordStr = ord(substr($string,$i,1));
if (@$j == $keyLen) { $j = 0; }
$ordKey = ord(substr($key,@$j,1));
@$j++;
@$hash .= strrev(base_convert(dechex($ordStr + $ordKey),16,36));
}
return @$hash;
}


?>

