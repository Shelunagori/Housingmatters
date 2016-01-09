<?php
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

function decode($string,$key) {
$key = sha1($key);
$strLen = strlen($string);
$keyLen = strlen($key);
for ($i = 0; $i < $strLen; $i+=2) {
$ordStr = hexdec(base_convert(strrev(substr($string,$i,2)),36,16));
if (@$j == $keyLen) { @$j = 0; }
$ordKey = ord(substr($key,@$j,1));
@$j++;
@$hash .= chr($ordStr - $ordKey);
}
return @$hash;
}



session_start();
// added in v4.0.0
require_once 'autoload.php';
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\Entities\AccessToken;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\HttpClients\FacebookHttpable;
// init app with app id and secret
FacebookSession::setDefaultApplication( '1067899399889225','527e7b602a8a0f66bba15078670a7757' );
// login helper with redirect_uri
    $helper = new FacebookRedirectLoginHelper('http://app.housingmatters.co.in/1353/fbconfig.php' );
try {
  $session = $helper->getSessionFromRedirect();
} catch( FacebookRequestException $ex ) {
  // When Facebook returns an error
} catch( Exception $ex ) {
  // When validation fails or other local issues
}
// see if we have a session
if ( isset( $session ) ) {
  // graph api request for user data
  $request = new FacebookRequest( $session, 'GET', '/me?locale=en_US&fields=name,email' );
  $response = $request->execute();
  
	
  // get response
  $graphObject = $response->getGraphObject();
     	$fbid = $graphObject->getProperty('id');              // To Get Facebook ID
 	    $fbfullname = $graphObject->getProperty('name'); // To Get Facebook full name
	    $femail = $graphObject->getProperty('email');    // To Get Facebook email ID
	/* ---- Session Variables -----*/
	    $_SESSION['FBID'] = $fbid;           
        $_SESSION['FULLNAME'] = $fbfullname;
	    $_SESSION['EMAIL'] =  $femail;
		$femail=encode($femail,'Housingmatters_facebook');
    /* ---- header location after session ----*/
  header("Location: http://app.housingmatters.co.in?aqazp2yd=".$femail."&source=f&uid=".$fbid); 
} else {
  $loginUrl = $helper->getLoginUrl(array('scope' => 'email'));
 header("Location: ".$loginUrl);
} 
?>