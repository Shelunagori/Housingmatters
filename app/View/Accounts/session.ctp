<!DOCTYPE html>
<html lang="en">
<head>
<title>HousingMatters</title>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<!-- Include external files and scripts here (See HTML helper for more info.) -->
<?php
echo $this->fetch('meta');
$webroot_path=$this->requestAction(array('controller' => 'Hms', 'action' => 'webroot_path'));
?>
<script type="text/javascript">
var key = 1;
//(function(a) {var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true; ga.src = 'http://52.74.43.53/growth-heacker/feed.js?key='+key;var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);}(window, document))
</script>
<style>
#loading{
	background-color: rgba(0, 0, 0, 0.21);
	height: 100%;
	width: 100%;
	position: fixed;
	z-index: 1;
	margin-top: 0px;
	top: 0px;
	display:none;
}
#loading-center{
	width: 100%;
	height: 100%;
	position: relative;
}
#loading-center-absolute {
	position: absolute;
	left: 50%;
	top: 50%;
	height: 150px;
	width: 150px;
	margin-top: -75px;
	margin-left: -75px;
}
.object{
	width: 20px;
	height: 20px;
	background-color: #008DD2;
	float: left;
	margin-right: 20px;
	margin-top: 65px;
	-moz-border-radius: 50% 50% 50% 50% !important;
	-webkit-border-radius: 50% 50% 50% 50% !important;
	border-radius: 50% 50% 50% 50% !important;
}

#object_one {	
	-webkit-animation: object_one 1.5s infinite;
	animation: object_one 1.5s infinite;
	}
#object_two {
	-webkit-animation: object_two 1.5s infinite;
	animation: object_two 1.5s infinite;
	-webkit-animation-delay: 0.25s; 
    animation-delay: 0.25s;
	}
#object_three {
    -webkit-animation: object_three 1.5s infinite;
	animation: object_three 1.5s infinite;
	-webkit-animation-delay: 0.5s;
    animation-delay: 0.5s;
	
	}
@-webkit-keyframes object_one {
75% { -webkit-transform: scale(0); }
}

@keyframes object_one {

  75% { 
    transform: scale(0);
    -webkit-transform: scale(0);
  }

}
@-webkit-keyframes object_two {
  75% { -webkit-transform: scale(0); }
}

@keyframes object_two {
  75% { 
    transform: scale(0);
    -webkit-transform:  scale(0);
  }

}

@-webkit-keyframes object_three {
  75% { -webkit-transform: scale(0); }
}

@keyframes object_three {

  75% { 
    transform: scale(0);
    -webkit-transform: scale(0);
  }
  
}
</style>
<div id="loading">
<div id="loading-center">
<div id="loading-center-absolute">
<div class="object" id="object_one"></div>
<div class="object" id="object_two"></div>
<div class="object" id="object_three"></div>
</div>
</div>
</div>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link href="<?php echo $webroot_path; ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="<?php echo $webroot_path; ?>assets/css/metro.css" rel="stylesheet" />
	
	<link href="<?php echo $webroot_path; ?>assets/bootstrap/css/bootstrap-responsive.min.1.css" rel="stylesheet" />
	<link href="<?php echo $webroot_path; ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
	<link href="<?php echo $webroot_path; ?>assets/fullcalendar/fullcalendar/bootstrap-fullcalendar.css" rel="stylesheet" />
	<link href="<?php echo $webroot_path; ?>assets/css/style.1.css" rel="stylesheet" />
	<link href="<?php echo $webroot_path; ?>assets/css/flash.css" rel="stylesheet" />
	<link href="<?php echo $webroot_path; ?>assets/css/style_responsive.css" rel="stylesheet" />
	<link href="<?php echo $webroot_path; ?>assets/css/style_default.1.css" rel="stylesheet" id="style_color" />
	<link rel="stylesheet" type="text/css" href="<?php echo $webroot_path; ?>assets/uniform/css/uniform.default.css" />
	    <link href="<?php echo $webroot_path; ?>assets/bootstrap/css/bootstrap-fileupload.css" rel="stylesheet" />
     <link rel="stylesheet" type="text/css" href="<?php echo $webroot_path; ?>assets/gritter/css/jquery.gritter.css" />
   <link rel="stylesheet" type="text/css" href="<?php echo $webroot_path; ?>assets/chosen-bootstrap/chosen/chosen.css" />
   <link rel="stylesheet" type="text/css" href="<?php echo $webroot_path; ?>assets/jquery-tags-input/jquery.tagsinput.css" />
   <link rel="stylesheet" type="text/css" href="<?php echo $webroot_path; ?>assets/clockface/css/clockface.css" />
   <link rel="stylesheet" type="text/css" href="<?php echo $webroot_path; ?>assets/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
   <link rel="stylesheet" type="text/css" href="<?php echo $webroot_path; ?>assets/bootstrap-datepicker/css/datepicker.css" />
   <link rel="stylesheet" type="text/css" href="<?php echo $webroot_path; ?>assets/bootstrap-timepicker/compiled/timepicker.css" />
   <link rel="stylesheet" type="text/css" href="<?php echo $webroot_path; ?>assets/bootstrap-colorpicker/css/colorpicker.css" />
   <link rel="stylesheet" href="<?php echo $webroot_path; ?>assets/bootstrap-toggle-buttons/static/stylesheets/bootstrap-toggle-buttons.css" />
   <link rel="stylesheet" href="<?php echo $webroot_path; ?>assets/data-tables/DT_bootstrap.css" />
   <link rel="stylesheet" type="text/css" href="<?php echo $webroot_path; ?>assets/bootstrap-daterangepicker/daterangepicker.css" />
   <link href="<?php echo $webroot_path; ?>assets/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
	<link href="<?php echo $webroot_path; ?>assets/jqvmap/jqvmap/jqvmap.css" media="screen" rel="stylesheet" type="text/css" />
	<link rel="shortcut icon" href="favicon.ico" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo $webroot_path; ?>as/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo $webroot_path; ?>as/animate.css" rel="stylesheet" />
<link href="<?php echo $webroot_path; ?>as/demo-styles.css" rel="stylesheet" />

		<style>
		label.valid {
		  width: 24px;
		  height: 0px;
		  background: url(as/img/valid.png) center center no-repeat;
		  text-indent: -9999px;
		  position:fixed;
		}
		label.error {
			/*font-weight: bold;*/
			color: red;
			padding: 2px 8px;
			margin-top: 10px;
		}
		</style>
		<style media="print">
		.hide_at_print {
			display:none !important;
		}
		.print_margin {
			margin-left:5%;
			}
		</style>
		
		
		
	<!-----notification css--------------->
	<style>
	.ntfction_list {
		padding:10px;
		color:#313131;
		border-bottom: solid 1px #ddd;
		cursor: pointer;
	}
	.ntfction_list:hover {
		color:#000;
		background-color:#f5f5f5;
	}
	</style>
	<!-----notification css--------------->
	
<!-----js--------------->
	<script src="<?php echo $webroot_path; ?>assets/js/jquery-1.8.3.min.js"></script>			
	<script src="<?php echo $webroot_path; ?>assets/breakpoints/breakpoints.js"></script>			
	<script src="<?php echo $webroot_path; ?>assets/jquery-slimscroll/jquery-ui-1.9.2.custom.min.js"></script>	
	<script src="<?php echo $webroot_path; ?>assets/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php echo $webroot_path; ?>assets/js/jquery.blockui.js"></script>
	<script src="<?php echo $webroot_path; ?>assets/fullcalendar/fullcalendar/fullcalendar.min.js"></script>	
	<script type="text/javascript" src="<?php echo $webroot_path; ?>assets/uniform/jquery.uniform.min.js"></script>
	<script type="text/javascript" src="<?php echo $webroot_path; ?>assets/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
	<script src="<?php echo $webroot_path; ?>assets/flot/jquery.flot.js"></script>
	<script src="<?php echo $webroot_path; ?>assets/flot/jquery.flot.resize.js"></script>
	<script src="<?php echo $webroot_path; ?>assets/flot/jquery.flot.pie.js"></script>
	<script src="<?php echo $webroot_path; ?>assets/flot/jquery.flot.stack.js"></script>
	<script src="<?php echo $webroot_path; ?>assets/flot/jquery.flot.crosshair.js"></script>
	   <script type="text/javascript" src="<?php echo $webroot_path; ?>assets/ckeditor/ckeditor.js"></script>  
   <script type="text/javascript" src="<?php echo $webroot_path; ?>assets/bootstrap/js/bootstrap-fileupload.js"></script>
     <script type="text/javascript" src="<?php echo $webroot_path; ?>assets/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script> 
   <script type="text/javascript" src="<?php echo $webroot_path; ?>assets/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
   <script type="text/javascript" src="<?php echo $webroot_path; ?>assets/jquery-tags-input/jquery.tagsinput.min.js"></script>
   <script type="text/javascript" src="<?php echo $webroot_path; ?>assets/bootstrap-toggle-buttons/static/js/jquery.toggle.buttons.js"></script>
   <script type="text/javascript" src="<?php echo $webroot_path; ?>assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
   <script type="text/javascript" src="<?php echo $webroot_path; ?>assets/clockface/js/clockface.js"></script>
   <script type="text/javascript" src="<?php echo $webroot_path; ?>assets/bootstrap-daterangepicker/date.js"></script>
   <script type="text/javascript" src="<?php echo $webroot_path; ?>assets/bootstrap-daterangepicker/daterangepicker.js"></script> 
   <script type="text/javascript" src="<?php echo $webroot_path; ?>assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>  
   <script type="text/javascript" src="<?php echo $webroot_path; ?>assets/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
    <script src="<?php echo $webroot_path; ?>assets/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
   	<script src="<?php echo $webroot_path; ?>assets/fancybox/source/jquery.fancybox.pack.js"></script>
	<script src="<?php echo $webroot_path; ?>assets/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="<?php echo $webroot_path; ?>assets/js/jquery.cookie.js"></script>
	<script src="<?php echo $webroot_path; ?>assets/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>	
	<script src="<?php echo $webroot_path; ?>assets/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
	<script src="<?php echo $webroot_path; ?>assets/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
	<script src="<?php echo $webroot_path; ?>assets/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
	<script src="<?php echo $webroot_path; ?>assets/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
	<script src="<?php echo $webroot_path; ?>assets/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
	<script src="<?php echo $webroot_path; ?>assets/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>	
		<script type="text/javascript" src="<?php echo $webroot_path; ?>assets/gritter/js/jquery.gritter.js"></script>
	<script type="text/javascript" src="<?php echo $webroot_path; ?>assets/js/jquery.pulsate.min.js"></script>	
	  <script src="<?php echo $webroot_path; ?>assets/uniform/jquery.uniform.min.js"></script> 
 	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
	<script src="<?php echo $webroot_path; ?>assets/js/gmaps.js"></script>
	<script src="<?php echo $webroot_path; ?>assets/js/demo.gmaps.js"></script>
		<script type="text/javascript" src="<?php echo $webroot_path; ?>assets/data-tables/jquery.dataTables.js"></script>
	<script type="text/javascript" src="<?php echo $webroot_path; ?>assets/data-tables/DT_bootstrap.js"></script>
		<script src="<?php echo $webroot_path; ?>assets/js/app.1.js"></script>		
	<script>
		jQuery(document).ready(function() {			
			// initiate layout and plugins
			App.setPage('calendar');
			App.init();
		});
	</script>
	<script type="text/javascript">
	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-37564768-1']);
	  _gaq.push(['_setDomainName', 'keenthemes.com']);
	  _gaq.push(['_setAllowLinker', true]);
	  _gaq.push(['_trackPageview']);
	  (function() {
	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();
	</script>
<script src="<?php echo $webroot_path; ?>as/js/jquery.validate.min.js"></script>

<script type="text/javascript">
window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute('charset','utf-8');
$.src='//cdn.zopim.com/?25CVPI3AsDiohJ2nP10yu4aiVbl5xnVV';z.t=+new Date;$.
type='text/javascript';e.parentNode.insertBefore($,e)})(document,'script');
</script>

<!--------------------url ajx------------------>


<script>

$(document).ready(function() {
	$("a[rel='tab']").live('click',function(e){
		e.preventDefault();
		$("#loading").show();
				
		pageurl = $(this).attr('href');
		$.ajax({
			url: pageurl,
			}).done(function(response) {
			
			$("#loading_ajax").html('');
			
			$(".page-content").html(response);
			$("#loading").hide();
			$("html, body").animate({
				scrollTop:0
			},"slow");
			 $('#submit_success').hide();
			});
		
		window.history.pushState({path:pageurl},'',pageurl);
		
	});
	
	$("a[role='button']").live('click',function(e){
		e.preventDefault();
	});
	
	$('a[role="button"]').live('click',function(e){
		e.preventDefault();
	});
	
	
	
	
	window.onpopstate = function(s) {
		pageurl = location.pathname;
		$('.page-content').load(pageurl+'?rel=tab');
		
	};
	
	
		

		

});
</script>


<!--------notification start--------------->
<script>
$(document).ready(function() {
	$(window).bind("load", function() {
	   $('#notification_count').load('<?php echo Router::url(array('controller' => 'Hms', 'action' =>'notifications_count'), true); ?>');
	   $('#alert_count').load('<?php echo Router::url(array('controller' => 'Hms', 'action' =>'alerts_count'), true); ?>');
	   
	   setTimeout(
		  function() 
		  {
			//get_flash_message_output();
		  }, 5000);
	   
	});
	
	function get_flash_message_output(){
		$.ajax({
			url: "<?php echo Router::url(array('controller' => 'Hms', 'action' =>'flash_output'), true); ?>",
		}).done(function(response) {
			$('#flash_output_div').prepend(response);
			var h=$("#flash_div").height();
			h=h+0;
			
			$("#header_div_container").css("margin-top","+="+h);
		
		});
		
		
	}
	
	$(".remove_flash").live("click", function() {
		var h=$("#flash_div").height();
		h=h+2;
		$("#header_div_container").css("margin-top","-="+h);
		$("#flash_div").remove();
	});
	
	setInterval(function(){ 
	   $('#notification_count').load('<?php echo Router::url(array('controller' => 'Hms', 'action' =>'notifications_count'), true); ?>');
	   $('#alert_count').load('<?php echo Router::url(array('controller' => 'Hms', 'action' =>'alerts_count'), true); ?>');
	   $('#alert_div').load('<?php echo Router::url(array('controller' => 'Hms', 'action' =>'alerts'), true); ?>');
	}, 3000);
	
	$(".notification_button").live('click',function(){
	   $('#notification_div').html('<div align="center" style="padding: 20px;"><img src="<?php echo $webroot_path; ?>as/windows.gif" /></div>').load('<?php echo Router::url(array('controller' => 'Hms', 'action' =>'notifications'), true); ?>');
	});
	
	$(".alert_button").live('click',function(){
	   $('#alert_div').html('<div align="center" style="padding: 20px;"><img src="<?php echo $webroot_path; ?>as/windows.gif" /></div>').load('<?php echo Router::url(array('controller' => 'Hms', 'action' =>'alerts'), true); ?>');
	});
});
</script>
<!--------notification end--------------->
<!------------JS-------------------->
</head>
<body class="fixed-top">
<!-- BEGIN HEADER -->
<div id="loading_ajax"></div>
	<div class="header navbar navbar-inverse navbar-fixed-top" id="flash_output_div">


		<!-- BEGIN TOP NAVIGATION BAR -->
		<div class="navbar-inner hide_at_print">
			<div class="container-fluid" style="padding-right: 0px;">
				<!-- BEGIN LOGO -->
				<a class="brand" href="<?php echo $webroot_path; ?>Hms/dashboard" style="margin-top:-9px;">
				<img src="<?php echo $webroot_path; ?>as/hm/hm-logo.png" alt="logo" height="16px" width="120px"/>
				</a>
				
				<!--change Society -->
				<?php
					$login_id=$this->Session->read('login_id');
					$society_id=$this->Session->read('society_id');
					$s_user_id=$this->Session->read('user_id');
					$s_mult_data=$this->requestAction(array('controller' => 'hms', 'action' => 'login_user_id'), array('pass' => array((int)$login_id)));
					
									
					$soc_id=$this->requestAction(array('controller' => 'hms', 'action' => 'society_name'), array('pass' => array((int)$society_id)));
					
					foreach($soc_id as $data7)
					{
					 $soc_n=$data7['society']['society_name'];
					}
					
					?>
				<div class="btn-group">
					<a class="btn" href="#"  data-toggle="dropdown" style="color: #DEDEDE;background-color: #1F1F1F;font-size: 14px;font-weight: bold;"><?php echo @$soc_n; ?></a>
					<?php
					if(sizeof($s_mult_data)>1)
					{
					?>
					<ul class="dropdown-menu">
						<li><a href="#" role="button" style="background-color: #eee;font-weight: 100;font-size: 13px;">Change Your Society</a></li>
						<?php
							foreach($s_mult_data as $data)
							{
							$sco_id=$data['user']['society_id'];
							$role_name2=$this->requestAction(array('controller' => 'hms', 'action' => 'society_name'), array('pass' => array((int)$sco_id)));
							foreach($role_name2 as $data2)
							{
							 $soc=$data2['society']['society_name'];
							
						 ?>
						<li><a href="change_society?society=<?php echo $sco_id; ?>"><?php echo $soc; ?><?php if($sco_id==$society_id) { ?><i class="icon-ok"></i><?php } else { ?><?php } ?></a></li>
						<?php } } ?>
					</ul>
					<?php } 
					else
					{
					?>
					<ul class="dropdown-menu" style=" padding: 2px; color: rgb(103, 103, 102); ">
						<li>
							<p>You have single Society.</p>
						</li>
					</ul>
					
					<?php }?>
				</div>
				
				
				<!-- END LOGO -->
				<!-- BEGIN RESPONSIVE MENU TOGGLER -->
				<a href="javascript:;" class="btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
				<img src="<?php echo $this->webroot; ?>assets/img/menu-toggler.png" alt="" />
				</a>          
				<!-- END RESPONSIVE MENU TOGGLER -->				
				<!-- BEGIN TOP NAVIGATION MENU -->					
				<ul class="nav pull-right" >
				

					
					
					
					
					
				
				
					<!--------facebook--------------->
					<!--<li class="external">
						<a href="https://www.facebook.com/HousingMatters.co.in" target="_blank"><img src="<?php echo $webroot_path; ?>as/fb.jpg" width="25px" height="20px"></a>
					</li>--->
					<!--------facebook------------------->
					
					
					<!-- BEGIN NOTIFICATION DROPDOWN -->	
					<li class="dropdown " id="header_notification_bar">
						<a href="#" class="dropdown-toggle notification_button" data-toggle="dropdown">
						<i class="icon-bell"></i>
						<span class="badge" id="notification_count"></span>
						</a>
						<ul class="dropdown-menu extended_new notification">
						
							<div style="border: solid 1px #ccc;">
							
							<div style="background-color:#eee; padding:5px;color:#02689b;font-weight: bold;">
							<i class=" icon-bell"></i> Notifications
							
							</div>
							
							
							<div class="scroller" data-height="300px" data-height="200px" data-always-visible="1" data-rail-visible="1" id="notification_div">
							
							</div>
							
							<div align="right" style="background-color:#eee; padding:5px;color:#02689b;font-weight: bold;"><a href="<?php echo $this->webroot; ?>Hms/see_all_notifications" rel="tab"> See all notifications <i class=" icon-circle-arrow-right"></i></a></div>
							
							</div>
							
						</ul>
					</li>
					<!-- END NOTIFICATION DROPDOWN -->
					<!-- BEGIN ALERT DROPDOWN -->	
					<li class="dropdown " id="header_notification_bar">
						<a href="#" class="dropdown-toggle alert_button" data-toggle="dropdown">
						<i class="icon-warning-sign"></i>
						<span class="badge" id="alert_count"></span>
						</a>
						<ul class="dropdown-menu extended_new notification">
						
							<div style="border: solid 1px #ccc;">
							
							<div style="background-color:#eee; padding:5px;color:#e02222;font-weight: bold;">
							<i class=" icon-warning-sign"></i> Alerts
							<div class="pull-right" ><a href="#" style="color:#e02222;"><i class=" icon-cog"></i></a></div>
							</div>
							
							
							<div class="scroller" data-height="300px" data-height="200px" data-always-visible="1" data-rail-visible="1" id="alert_div">
							
							</div>
							
							<div align="right" style="background-color:#eee; padding:5px;font-weight: bold;"><a href="#" style="color:#e02222;"> See all alerts <i class=" icon-circle-arrow-right"></i></a></div>
							
							</div>
							
						</ul>
					</li>
					<!-- END ALERT DROPDOWN -->
					
					
					<!--change role---->
					<?php
					$s_role_id=$this->Session->read('role_id');
					$role_name=$this->requestAction(array('controller' => 'hms', 'action' => 'fetch_rolename_via_roleid'), array('pass' => array($s_role_id)));
					?>
					<li class="dropdown" id="header_task_bar">
						<a href="#" class="dropdown-toggle tooltips"  data-Placement="bottom"  data-original-title="Change Role"  data-toggle="dropdown">
						<i class="icon-tasks"></i><span style="color:#FFF; padding:2px; "><?php echo $role_name; ?></span>
						</a>
						<?php
						$users_roles=$this->requestAction(array('controller' => 'hms', 'action' => 'fetch_users_role'), array('pass' => array()));
						
						if(sizeof($users_roles)>1)
						{
						?>
                            <ul class="dropdown-menu extended tasks">
							<li>
								<p>Change Your Role</p>
							</li>
                            <?php
							foreach ($users_roles as $role_id) 
							{
							
							 
							 $role_name2=$this->requestAction(array('controller' => 'hms', 'action' => 'fetch_rolename_via_roleid'), array('pass' => array($role_id)));
							 ?>
							<li class="external ">
								<a href="<?php echo $this->webroot; ?>Hms/change_role?role=<?php echo $role_id; ?>"><?php echo $role_name2; ?><?php if($role_id==$s_role_id) { ?><i class="icon-ok"></i><?php } else { ?><i class=" icon-circle-arrow-right"></i><?php } ?></a>
							</li>
                       <?php } ?>
							</ul>
					<?php } 
					else
					{
					?>
					<ul class="dropdown-menu extended tasks">
						<li>
							<p>You have single role.</p>
						</li>
					</ul>
					<?php
					}?>
                            
					</li>
					<!---change role-->
					<!-- BEGIN USER LOGIN DROPDOWN -->
					<?php
					$s_user_id=$this->Session->read('user_id');
					$result_user_name_profile=$this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'), array('pass' => array($s_user_id)));
					foreach ($result_user_name_profile as $data10) 
					{
					$user_name=$data10["user"]["user_name"];
					$profile_pic=$data10["user"]["profile_pic"];
					}
					
					?>
					<li class="dropdown user">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<img alt="" src="<?php echo $webroot_path; ?>profile/<?php echo @$profile_pic; ?>"  style="width:28px; height:28px;" />
						<span class="username">Hello <?php echo @$user_name; ?></span>
						<i class="icon-angle-down"></i>
						</a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo $this->webroot; ?>Hms/profile" rel='tab'><i class="icon-user"></i> My Profile</a></li>
							<li><a href="<?php echo $this->webroot; ?>Hms/notification_email" rel='tab'><i class="icon-calendar"></i> User Settings</a></li>
							<li class="divider"></li>
							<li><a href="<?php echo $this->webroot; ?>Hms/logout"><i class="icon-key"></i> Log Out</a></li>
						</ul>
					</li>
					<!-- END USER LOGIN DROPDOWN -->
				</ul>
				<!-- END TOP NAVIGATION MENU -->	
			</div>
		</div>
		<!-- END TOP NAVIGATION BAR -->
	</div>
	<!-- END HEADER -->

	
	
	
<!-- BEGIN CONTAINER -->	
	<div class="page-container row-fluid" id="header_div_container">
		<!-- BEGIN SIDEBAR -->
		<div class="page-sidebar nav-collapse collapse">
			<!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
			<div class="slide hide">
				<i class="icon-angle-left"></i>
			</div>
			
			<div class="clearfix"></div>
			<!-- END RESPONSIVE QUICK SEARCH FORM -->
			<!-- BEGIN SIDEBAR MENU -->
			<ul>
				<li>
					<a href="<?php echo $this->webroot; ?>Hms/dashboard" rel='tab'>
					<i class="icon-home"></i> Dashboard
					</a>					
				</li>
<?php
$result=$this->requestAction(array('controller' => 'hms', 'action' => 'menus_from_role_privileges'));

if(sizeof(@$result)>0){
	foreach($result as $data1){
		$group_module_id[]=@$data1['role_privileges']['module_id'];
		$group_sub_module_id[]=@$data1['role_privileges']['sub_module_id'];
	}
	
	$distinct_group_module_id = array_unique($group_module_id);
	sort($distinct_group_module_id);
	foreach($distinct_group_module_id as $child1){
		
	$result_moduletype_id=(int)$this->requestAction(array('controller' => 'hms', 'action' => 'fetch_module_type_id'), array('pass' => array($child1)));
		
	$complete_menu[$result_moduletype_id][]=$child1;
	}
	ksort($complete_menu);
	foreach($complete_menu as $key=>$child2){
		$result_module_type_info=$this->requestAction(array('controller' => 'hms', 'action' => 'fetch_module_type_name'), array('pass' => array($key)));
		
		foreach($result_module_type_info as $result_module_type_info_child)
		{
		$icon=@$result_module_type_info_child['module_type']['icon'];
		$module_type_name=$result_module_type_info_child['module_type']['module_type_name'];
		}
	?>
	<li class="has-sub">
	<a href="javascript:;" class="">
	<i class="<?php echo $icon; ?>"></i> <?php echo $module_type_name; ?>
	<span class="arrow"></span>
	</a>
		<ul class="sub" style="display: none;">	
		<?php foreach($child2 as $child_sub){
			$result_mainmodulename=$this->requestAction(array('controller' => 'hms', 'action' => 'fetch_mainmodulename_usermanagement'), array('pass' => array($child_sub)));

			foreach($result_mainmodulename as $data5)
			{
			$module_name=$data5['main_module']['module_name'];
			}
			$new_array_module_group[]=array($module_name,$child_sub);
			sort($new_array_module_group);
			
		} ?>
		<?php foreach($new_array_module_group as $child_22){
			$child_22[1];
			
			$result_role_prvg=@$this->requestAction(array('controller' => 'hms', 'action' => 'fetch_sub_module_id_from_role_prvg'), array('pass' => array($child_22[1])));
		
			foreach($result_role_prvg as $data44)
			{
			$sub_module_id=$data44['role_privilege']['sub_module_id'];
			}
			
			$result_page=@$this->requestAction(array('controller' => 'hms', 'action' => 'fetch_pagename_main_module_usermanagement'), array('pass' => array($child_22[1],$sub_module_id)));
			foreach($result_page as $data4)
			{
			$page_name=$data4['page']['page_name'];
			$controller=$data4['page']['controller'];
			}
			
			$result_module_name=@$this->requestAction(array('controller' => 'hms', 'action' => 'fetch_mainmodulename_usermanagement'), array('pass' => array($child_22[1])));
			foreach($result_module_name as $data44)
			{
			$main_module_icon=$data44['main_module']['icon'];
			}
		?>
		<li>
		<a href="<?php echo $this->webroot.@$controller; ?>/<?php echo @$page_name; ?>" rel="tab">
		<i class="<?php echo $main_module_icon; ?>"></i>
		<?php echo $child_22[0]; ?>
		</a>					
		</li>
		<?php } unset($new_array_module_group); ?>
		
		
		</ul>
	</li>
	<?php }
} ?>












<!---------Commitee member------------->
<?php if($s_role_id==1)	{ ?>
<li>
	<a href="new_tenant_enrollment_view">
	<i class="icon-home"></i> Tenant
	</a>					
</li>




<?php } ?>
<!--------- end Commitee member------------->
<?php 
$s_society_id=$this->Session->read('society_id');
$soc_id2=$this->requestAction(array('controller' => 'hms', 'action' => 'society_name'), array('pass' => array($s_society_id)));
foreach($soc_id2 as $data)
{

@$complaints= $data['society']['help_desk'];

}
if(@$complaints==1)
{
?>
<li>
	<a href="<?php echo $webroot_path; ?>Hms/feedback" rel='tab'>
	<i class="icon-phone"></i> Contact Us
	</a>					
</li>
<?php } ?>
<!---------housingmatters------------->
<?php if($s_role_id==0)	{?>
<li>
	<a href="hm_assign_module">
	<i class="icon-home"></i> Assign Modules
	</a>					
</li>

<li>
	<a href="new_society_enrollment">
	<i class="icon-home"></i> New Enrollment
	</a>					
</li>
<li>
	<a href="society_approve">
	<i class="icon-home"></i> Approve Society
	</a>					
</li>

<li>
	<a href="feedback_view">
	<i class="icon-home"></i> Feedback
	</a>					
</li>	

<li>
	<a href="hm_society_member_view">
	<i class="icon-home"></i> Society View
	</a>					
</li>	


<li>
	<a href="master_accounts_category_hm">
	<i class="icon-home"></i>Master Charts Of Account HM
	</a>					
</li>

<li>
	<a href="flash_message">
	<i class="icon-home"></i>Flash Message
	</a>					
</li>


<?php } ?>
<!---------housingmatters------------->
			
<!--<li>
	<a href="<?php echo $webroot_path; ?>Classifieds/post_ad" rel='tab'>
	<i class="icon-phone"></i> Classifieds
	</a>					
</li>-->
			
			</ul>
			<!-- END SIDEBAR MENU -->
		</div>
		<!-- END SIDEBAR -->
		<!-- BEGIN PAGE -->
		<div class="page-content" style="padding:5px;background: #f1f3fa;">
			<!-- BEGIN PAGE CONTAINER-->
			<div class="" ><!--container-fluid-->
				
				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid">
					<div  id="content">
						
						
						<!-- Here's where I want my views to be displayed-->
						<?php echo $this->fetch('content'); ?>
						
						
					</div>
				</div>
				<!-- END PAGE CONTENT-->
			</div>
			<!-- END PAGE CONTAINER-->	
		</div>
		<!-- END PAGE -->	 	
	</div>
	<!-- END CONTAINER -->

	
	
	
	<!-- BEGIN FOOTER -->
	<div class="footer hide_at_print">
		HousingMatters
		<div class="span pull-right">
			<span class="go-top"><i class="icon-angle-up"></i></span>
		</div>
	</div>
	<!-- END FOOTER -->


</body>
</html>