<!DOCTYPE html>
<html lang="en">
<head>
<title>HousingMatters</title>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<!-- Include external files and scripts here (See HTML helper for more info.) -->
<?php
echo $this->fetch('meta');
?>
<link href="<?php echo $this->webroot ; ?>/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="<?php echo $this->webroot ; ?>/assets/css/metro.css" rel="stylesheet" />
	<link href="<?php echo $this->webroot ; ?>/assets/bootstrap/css/bootstrap-responsive.min.1.css" rel="stylesheet" />
	<link href="<?php echo $this->webroot ; ?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
	<link href="<?php echo $this->webroot ; ?>/assets/fullcalendar/fullcalendar/bootstrap-fullcalendar.css" rel="stylesheet" />
	<link href="<?php echo $this->webroot ; ?>/assets/css/style.1.css" rel="stylesheet" />
	<link href="<?php echo $this->webroot ; ?>/assets/css/style_responsive.css" rel="stylesheet" />
	<link href="<?php echo $this->webroot ; ?>/assets/css/style_default.1.css" rel="stylesheet" id="style_color" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->webroot ; ?>/assets/uniform/css/uniform.default.css" />
	    <link href="<?php echo $this->webroot ; ?>/assets/bootstrap/css/bootstrap-fileupload.css" rel="stylesheet" />
     <link rel="stylesheet" type="text/css" href="<?php echo $this->webroot ; ?>/assets/gritter/css/jquery.gritter.css" />
   <link rel="stylesheet" type="text/css" href="<?php echo $this->webroot ; ?>/assets/chosen-bootstrap/chosen/chosen.css" />
   <link rel="stylesheet" type="text/css" href="<?php echo $this->webroot ; ?>/assets/jquery-tags-input/jquery.tagsinput.css" />
   <link rel="stylesheet" type="text/css" href="<?php echo $this->webroot ; ?>/assets/clockface/css/clockface.css" />
   <link rel="stylesheet" type="text/css" href="<?php echo $this->webroot ; ?>/assets/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
   <link rel="stylesheet" type="text/css" href="<?php echo $this->webroot ; ?>/assets/bootstrap-datepicker/css/datepicker.css" />
   <link rel="stylesheet" type="text/css" href="<?php echo $this->webroot ; ?>/assets/bootstrap-timepicker/compiled/timepicker.css" />
   <link rel="stylesheet" type="text/css" href="<?php echo $this->webroot ; ?>/assets/bootstrap-colorpicker/css/colorpicker.css" />
   <link rel="stylesheet" href="<?php echo $this->webroot ; ?>/assets/bootstrap-toggle-buttons/static/stylesheets/bootstrap-toggle-buttons.css" />
   <link rel="stylesheet" href="<?php echo $this->webroot ; ?>/assets/data-tables/DT_bootstrap.css" />
   <link rel="stylesheet" type="text/css" href="<?php echo $this->webroot ; ?>/assets/bootstrap-daterangepicker/daterangepicker.css" />
   <link href="<?php echo $this->webroot ; ?>/assets/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
	<link href="<?php echo $this->webroot ; ?>/assets/jqvmap/jqvmap/jqvmap.css" media="screen" rel="stylesheet" type="text/css" />
	<link rel="shortcut icon" href="favicon.ico" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo $this->webroot ; ?>/as/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo $this->webroot ; ?>/as/animate.css" rel="stylesheet" />
<link href="<?php echo $this->webroot ; ?>/as/demo-styles.css" rel="stylesheet" />
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
	<script src="<?php echo $this->webroot ; ?>/assets/js/jquery-1.8.3.min.js"></script>			
	<script src="<?php echo $this->webroot ; ?>/assets/breakpoints/breakpoints.js"></script>			
	<script src="<?php echo $this->webroot ; ?>/assets/jquery-slimscroll/jquery-ui-1.9.2.custom.min.js"></script>	
	<script src="<?php echo $this->webroot ; ?>/assets/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php echo $this->webroot ; ?>/assets/js/jquery.blockui.js"></script>
	<script src="<?php echo $this->webroot ; ?>/assets/fullcalendar/fullcalendar/fullcalendar.min.js"></script>	
	<script type="text/javascript" src="<?php echo $this->webroot ; ?>/assets/uniform/jquery.uniform.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->webroot ; ?>/assets/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
	<script src="<?php echo $this->webroot ; ?>/assets/flot/jquery.flot.js"></script>
	<script src="<?php echo $this->webroot ; ?>/assets/flot/jquery.flot.resize.js"></script>
	<script src="<?php echo $this->webroot ; ?>/assets/flot/jquery.flot.pie.js"></script>
	<script src="<?php echo $this->webroot ; ?>/assets/flot/jquery.flot.stack.js"></script>
	<script src="<?php echo $this->webroot ; ?>/assets/flot/jquery.flot.crosshair.js"></script>
	   <script type="text/javascript" src="<?php echo $this->webroot ; ?>/assets/ckeditor/ckeditor.js"></script>  
   <script type="text/javascript" src="<?php echo $this->webroot ; ?>/assets/bootstrap/js/bootstrap-fileupload.js"></script>
     <script type="text/javascript" src="<?php echo $this->webroot ; ?>/assets/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script> 
   <script type="text/javascript" src="<?php echo $this->webroot ; ?>/assets/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
   <script type="text/javascript" src="<?php echo $this->webroot ; ?>/assets/jquery-tags-input/jquery.tagsinput.min.js"></script>
   <script type="text/javascript" src="<?php echo $this->webroot ; ?>/assets/bootstrap-toggle-buttons/static/js/jquery.toggle.buttons.js"></script>
   <script type="text/javascript" src="<?php echo $this->webroot ; ?>/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
   <script type="text/javascript" src="<?php echo $this->webroot ; ?>/assets/clockface/js/clockface.js"></script>
   <script type="text/javascript" src="<?php echo $this->webroot ; ?>/assets/bootstrap-daterangepicker/date.js"></script>
   <script type="text/javascript" src="<?php echo $this->webroot ; ?>/assets/bootstrap-daterangepicker/daterangepicker.js"></script> 
   <script type="text/javascript" src="<?php echo $this->webroot ; ?>/assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>  
   <script type="text/javascript" src="<?php echo $this->webroot ; ?>/assets/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
     <script src="<?php echo $this->webroot ; ?>/assets/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
   	<script src="<?php echo $this->webroot ; ?>/assets/fancybox/source/jquery.fancybox.pack.js"></script>
		<script src="<?php echo $this->webroot ; ?>/assets/jquery-slimscroll/jquery.slimscroll.min.js"></script>
			<script src="<?php echo $this->webroot ; ?>/assets/js/jquery.cookie.js"></script>
	<script src="<?php echo $this->webroot ; ?>/assets/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>	
	<script src="<?php echo $this->webroot ; ?>/assets/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
	<script src="<?php echo $this->webroot ; ?>/assets/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
	<script src="<?php echo $this->webroot ; ?>/assets/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
	<script src="<?php echo $this->webroot ; ?>/assets/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
	<script src="<?php echo $this->webroot ; ?>/assets/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
	<script src="<?php echo $this->webroot ; ?>/assets/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>	
		<script type="text/javascript" src="<?php echo $this->webroot ; ?>/assets/gritter/js/jquery.gritter.js"></script>
	<script type="text/javascript" src="<?php echo $this->webroot ; ?>/assets/js/jquery.pulsate.min.js"></script>	
	  <script src="<?php echo $this->webroot ; ?>/assets/uniform/jquery.uniform.min.js"></script> 
 	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
	<script src="<?php echo $this->webroot ; ?>/assets/js/gmaps.js"></script>
	<script src="<?php echo $this->webroot ; ?>/assets/js/demo.gmaps.js"></script>
		<script type="text/javascript" src="<?php echo $this->webroot ; ?>/assets/data-tables/jquery.dataTables.js"></script>
	<script type="text/javascript" src="<?php echo $this->webroot ; ?>/assets/data-tables/DT_bootstrap.js"></script>
		<script src="<?php echo $this->webroot ; ?>/assets/js/app.1.js"></script>		
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
<script src="<?php echo $this->webroot ; ?>/as/js/jquery.validate.min.js"></script>

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
		//$('body').append('<div class="modal-backdrop fade in"></div>');
		pageurl = $(this).attr('href');
		$( "#content" ).load( pageurl+'?rel=tab', function() {
			//$('.modal-backdrop').remove();
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
		$('#content').load(pageurl+'?rel=tab');
	};
});
</script>


<!--------notification start--------------->
<script>
$(document).ready(function() {		
	$(window).bind("load", function() {
	   $('#notification_count').load('notifications_count');
	   $('#alert_count').load('alerts_count');
	});
	
	setInterval(function(){ 
	   $('#notification_count').load('notifications_count');
	   $('#alert_count').load('alerts_count');
	   $('#alert_div').load('alerts');
	}, 3000);
	
	
	$(".notification_button").live('click',function(){
	   $('#notification_div').html('<div align="center" style="padding: 20px;"><img src="<?php echo $this->webroot ; ?>/as/windows.gif" /></div>').load('notifications');
	});
	
	$(".alert_button").live('click',function(){
	   $('#alert_div').html('<div align="center" style="padding: 20px;"><img src="<?php echo $this->webroot ; ?>/as/windows.gif" /></div>').load('alerts');
	});
});
</script>
<!--------notification end--------------->
<!------------JS-------------------->
</head>
<body class="fixed-top">
<!-- BEGIN HEADER -->
	<div class="header navbar navbar-inverse navbar-fixed-top">
		<!-- BEGIN TOP NAVIGATION BAR -->
		<div class="navbar-inner hide_at_print">
			<div class="container-fluid" style="padding-right: 0px;">
				<!-- BEGIN LOGO -->
				<a class="brand" href="dashboard" style="margin-top:-9px;">
				<img src="<?php echo $this->webroot ; ?>/as/hm/hm-logo.png" alt="logo" height="16px" width="120px"/>
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
						<a href="https://www.facebook.com/HousingMatters.co.in" target="_blank"><img src="<?php echo $this->webroot ; ?>/as/fb.jpg" width="25px" height="20px"></a>
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
							
							<div align="right" style="background-color:#eee; padding:5px;color:#02689b;font-weight: bold;"><a href="see_all_notifications" rel="tab"> See all notifications <i class=" icon-circle-arrow-right"></i></a></div>
							
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
					<!-- BEGIN TODO DROPDOWN -->
					<!-- <li class="dropdown" id="header_task_bar">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="icon-tasks"></i>
						<span class="badge">5</span>
						</a>
						<ul class="dropdown-menu extended tasks">
							<li>
								<p>You have 12 pending tasks</p>
							</li>
							<li>
								<a href="#">
								<span class="task">
								<span class="desc">New release v1.2</span>
								<span class="percent">30%</span>
								</span>
								<span class="progress progress-success ">
								<span style="width: 30%;" class="bar"></span>
								</span>
								</a>
							</li>
							<li>
								<a href="#">
								<span class="task">
								<span class="desc">Application deployment</span>
								<span class="percent">65%</span>
								</span>
								<span class="progress progress-danger progress-striped active">
								<span style="width: 65%;" class="bar"></span>
								</span>
								</a>
							</li>
							<li>
								<a href="#">
								<span class="task">
								<span class="desc">Mobile app release</span>
								<span class="percent">98%</span>
								</span>
								<span class="progress progress-success">
								<span style="width: 98%;" class="bar"></span>
								</span>
								</a>
							</li>
							<li>
								<a href="#">
								<span class="task">
								<span class="desc">Database migration</span>
								<span class="percent">10%</span>
								</span>
								<span class="progress progress-warning progress-striped">
								<span style="width: 10%;" class="bar"></span>
								</span>
								</a>
							</li>
							<li>
								<a href="#">
								<span class="task">
								<span class="desc">Web server upgrade</span>
								<span class="percent">58%</span>
								</span>
								<span class="progress progress-info">
								<span style="width: 58%;" class="bar"></span>
								</span>
								</a>
							</li>
							<li>
								<a href="#">
								<span class="task">
								<span class="desc">Mobile development</span>
								<span class="percent">85%</span>
								</span>
								<span class="progress progress-success">
								<span style="width: 85%;" class="bar"></span>
								</span>
								</a>
							</li>
							<li class="external">
								<a href="#">See all tasks <i class="m-icon-swapright"></i></a>
							</li>
						</ul>
					</li>-->
					<!-- END TODO DROPDOWN -->
					
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
								<a href="change_role?role=<?php echo $role_id; ?>"><?php echo $role_name2; ?><?php if($role_id==$s_role_id) { ?><i class="icon-ok"></i><?php } else { ?><i class=" icon-circle-arrow-right"></i><?php } ?></a>
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
						<img alt="" src="<?php echo $this->webroot ; ?>/profile/<?php echo $profile_pic; ?>"  style="width:28px; height:28px;" />
						<span class="username">Hello <?php echo $user_name; ?></span>
						<i class="icon-angle-down"></i>
						</a>
						<ul class="dropdown-menu">
							<li><a href="profile"><i class="icon-user"></i> My Profile</a></li>
							<li><a href="notification_email"><i class="icon-calendar"></i> User Settings</a></li>
							<!--<li><a href="#"><i class="icon-tasks"></i> My Tasks</a></li>-->
							<li class="divider"></li>
							<li><a href="logout"><i class="icon-key"></i> Log Out</a></li>
						</ul>
					</li>
					
					<!--<li class="dropdown" id="header_notification_bar">
						<a href="#" class="dropdown-toggle open_msg" data-toggle="dropdown">
						<i class=" icon-envelope"></i>
						<span class="badge">6</span>
						</a>
					</li>-->
					<!-- END USER LOGIN DROPDOWN -->
				</ul>
				<!-- END TOP NAVIGATION MENU -->	
			</div>
		</div>
		<!-- END TOP NAVIGATION BAR -->
	</div>
	<!-- END HEADER -->

	
	
	
<!-- BEGIN CONTAINER -->	
	
		
		<!-- BEGIN PAGE -->
		<div class="page-content" style="padding:5px;background: #f1f3fa;margin:42px 0px 0px 0px;">
			<!-- BEGIN PAGE CONTAINER-->
			<div class="" ><!--container-fluid-->
				
				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid">
					<div class="" id="content">
						
						
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