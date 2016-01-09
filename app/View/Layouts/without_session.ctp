
<!DOCTYPE html>
<html lang="en">
<head>
<title>HousingMatters</title>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<script src="https://apis.google.com/js/platform.js" async defer></script>
<meta name="google-signin-client_id" content=" 988444218833-kvcpdmfktulgbrjb8k9lsfo0ukrm7258.apps.googleusercontent.com">
<!-- Include external files and scripts here (See HTML helper for more info.) -->
<script src="https://apis.google.com/js/platform.js" async defer></script>
<meta name="google-signin-client_id" content="453149326689-97see3052rrsfg41v4gdhkmjpm94ialn.apps.googleusercontent.com">
<?php
echo $this->fetch('meta');
$webroot_path=$this->requestAction(array('controller' => 'Hms', 'action' => 'webroot_path')); 
?>
<link href="<?php echo $webroot_path; ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
  <link href="<?php echo $webroot_path; ?>assets/css/metro.css" rel="stylesheet" />
  <link href="<?php echo $webroot_path; ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <link href="<?php echo $webroot_path; ?>assets/css/style.1.css" rel="stylesheet" />
  <link href="<?php echo $webroot_path; ?>assets/css/style_responsive.1.css" rel="stylesheet" />
  <link href="<?php echo $webroot_path; ?>assets/css/style_default.css" rel="stylesheet" id="style_color" />
  <link rel="stylesheet" type="text/css" href="<?php echo $webroot_path; ?>assets/uniform/css/uniform.default.css" />
   <link rel="stylesheet" type="text/css" href="<?php echo $webroot_path; ?>assets/chosen-bootstrap/chosen/chosen.css" />
     <link rel="stylesheet" type="text/css" href="<?php echo $webroot_path; ?>assets/chosen-bootstrap/chosen/chosen.css" />
     <link rel="shortcut icon" href="favicon.ico" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />



<link href="<?php echo $webroot_path; ?>as/bootstrap.min.css" rel="stylesheet">
		<style>
		label.valid {
		  width: 24px;
		  height: 0px;
		  background: url(as/img/valid.png) center center no-repeat;
		  text-indent: -9999px;
		}
		label.error {
			/*font-weight: bold;*/
			color: red;
			padding: 2px 8px;
			margin-top: 2px;
		}
		</style>
 <script src="<?php echo $webroot_path; ?>as/js/jquery-1.7.1.min.js"></script>
<script src="<?php echo $webroot_path; ?>as/js/jquery.validate.min.js"></script>

<script type="text/javascript">
 var oa = document.createElement('script');
 oa.type = 'text/javascript'; oa.async = true;
 oa.src = '//housingmattersapp.api.oneall.com/socialize/library.js'
 var s = document.getElementsByTagName('script')[0];
 s.parentNode.insertBefore(oa, s)
</script>


</head>
<body class="login">

<!-- Here's where I want my views to be displayed-->
<?php echo $this->fetch('content'); ?>




<!-----------js----------------->

<!-----js--------------->
<script src="<?php echo $webroot_path; ?>assets/js/jquery-1.8.3.min.js"></script>			
	<script src="<?php echo $webroot_path; ?>assets/breakpoints/breakpoints.js"></script>			
	<script src="<?php echo $webroot_path; ?>assets/jquery-slimscroll/jquery-ui-1.9.2.custom.min.js"></script>	
	<script src="<?php echo $webroot_path; ?>assets/bootstrap/js/bootstrap.min.js"></script>
	  <script src="<?php echo $webroot_path; ?>assets/uniform/jquery.uniform.min.js"></script> 
	<script src="<?php echo $webroot_path; ?>assets/js/jquery.blockui.js"></script>
	
	
	<script type="text/javascript" src="<?php echo $webroot_path; ?>assets/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
	
	
	
		<script src="<?php echo $webroot_path; ?>assets/js/app.1.js"></script>		
	<script>
		jQuery(document).ready(function() {			
			// initiate layout and plugins
			App.setPage('calendar');
			App.init();
		});
	</script>
	
<script src="<?php echo $webroot_path; ?>as/js/jquery.validate.min.js"></script>
</body>
</html>