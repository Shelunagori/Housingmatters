<!DOCTYPE html>
<html lang="en">
<head>

<title>HousingMatters</title>


<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet'  type='text/css'>
<!-- Include external files and scripts here (See HTML helper for more info.) -->
<?php
echo $this->fetch('meta');
$webroot_path=$this->requestAction(array('controller' => 'Hms', 'action' => 'webroot_path'));
?>

<style>
@media print {
    a:link:after,
    a:visited:after {
        content: "" !important;
    }
}
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
			.hide_to_show{
			    display: block !important;
			
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
    <script src="<?php echo $webroot_path; ?>assets/js/shortcut.js"></script> 	
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
	
	(function(){
		check_session_destroy();
		setTimeout(arguments.callee, 2000);
	})();
	
	function check_session_destroy(){
		$.ajax({
			url: "<?php echo Router::url(array('controller' => 'Hms', 'action' =>'check_session_destroy_or_not'), true); ?>",
		}).done(function(response) {
			if(response==0){
				$(".modal-backdrop").show();
				$(".session_destroy_container").show();
			}
		});
	}
	
	
	
	
	
	setTimeout(function() { 
		slide_show();
   }, 500);
	
	
	
	
	
	function slide_show(){
		$.ajax({
			url: "<?php echo Router::url(array('controller' => 'Hms', 'action' =>'check_slide_show_displayed_or_not'), true); ?>",
		}).done(function(response) {
			if(response==0){
				$.ajax({
					url: "<?php echo Router::url(array('controller' => 'Hms', 'action' =>'fetch_slide_1'), true); ?>",
				}).done(function(response) {
					$(".modal-backdrop").show();
					$(".slide_show_container").show().html(response);
				});
			}
		});
	} 
	
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



<script type="text/javascript">
 
  /* Replace #your_subdomain# by the subdomain of a Site in your OneAll account */    
  var oneall_subdomain = '#your_subdomain#';
 
  /* The library is loaded asynchronously */
  var oa = document.createElement('script');
  oa.type = 'text/javascript'; oa.async = true;
  oa.src = '//' + oneall_subdomain + '.api.oneall.com/socialize/library.js';
  var s = document.getElementsByTagName('script')[0];
  s.parentNode.insertBefore(oa, s);
       
</script>


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
					$f_profile_pic=@$data10["user"]["f_profile_pic"];
					$g_profile_pic=@$data10["user"]["g_profile_pic"];
					}
					
					?>
					<li class="dropdown user">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<?php if(!empty($profile_pic) && $profile_pic!="blank.jpg"){ ?>
						<img alt="" src="<?php echo $webroot_path; ?>profile/<?php echo @$profile_pic; ?>"  style="width:28px; height:28px;" />
						<?php }
						elseif(!empty($f_profile_pic)){ ?>
							<img alt="" src="<?php echo $f_profile_pic; ?>"  style="width:28px; height:28px;" />
						<?php }
						elseif(!empty($g_profile_pic)){ ?>
							<img alt="" src="<?php echo $g_profile_pic; ?>"  style="width:28px; height:28px;" />
						<?php }
						else{ ?>
							<img alt="" src="<?php echo $webroot_path; ?>profile/blank.jpg"  style="width:28px; height:28px;" />
						<?php } ?>
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
			<form class="sidebar-search" />
				<div class="input-box">
					<input type="text" class="" placeholder="Search" />
					<input type="button" class="submit" value=" " />
				</div>
			</form>
			<div class="clearfix"></div>
			<!-- END RESPONSIVE QUICK SEARCH FORM -->
			<!-- BEGIN SIDEBAR MENU -->
			<ul>
				<li class="active">
					<a href="index.html">
					<i class="icon-home"></i> Dashboard
					<span class="selected"></span>
					</a>					
				</li>
				<li class="has-sub">
					<a href="javascript:;" class="">
					<i class="icon-bookmark-empty"></i> UI Features
					<span class="arrow"></span>
					</a>
					<ul class="sub">
						<li><a class="" href="ui_general.html">General</a></li>
						<li><a class="" href="ui_buttons.html">Buttons</a></li>
						<li><a class="" href="ui_tabs_accordions.html">Tabs & Accordions</a></li>
						<li><a class="" href="ui_typography.html">Typography</a></li>
					</ul>
				</li>
				<li class="has-sub">
					<a href="javascript:;" class="">
					<i class="icon-table"></i> Form Stuff
					<span class="arrow"></span>
					</a>
					<ul class="sub">
						<li><a class="" href="form_layout.html">Form Layouts</a></li>
						<li><a class="" href="form_component.html">Form Components</a></li>
						<li><a class="" href="form_wizard.html">Form Wizard</a></li>
						<li><a class="" href="form_validation.html">Form Validation</a></li>
					</ul>
				</li>
				<li class="has-sub">
					<a href="javascript:;" class="">
					<i class="icon-th-list"></i> Data Tables
					<span class="arrow"></span>
					</a>
					<ul class="sub">
						<li><a class="" href="table_basic.html">Basic Tables</a></li>
						<li><a class="" href="table_managed.html">Managed Tables</a></li>
					</ul>
				</li>
				<li><a class="" href="grids.html"><i class="icon-th"></i> Grids & Portlets</a></li>
				<li class="has-sub">
					<a href="javascript:;" class="">
					<i class="icon-map-marker"></i> Maps
					<span class="arrow"></span>
					</a>
					<ul class="sub">
						<li><a class="" href="maps_google.html">Google Maps</a></li>
						<li><a class="" href="maps_vector.html">Vector Maps</a></li>
					</ul>
				</li>
				<li><a class="" href="charts.html"><i class="icon-bar-chart"></i> Visual Charts</a></li>
				<li><a class="" href="calendar.html"><i class="icon-calendar"></i> Calendar</a></li>
				<li><a class="" href="gallery.html"><i class="icon-camera"></i> Gallery</a></li>
				<li class="has-sub">
					<a href="javascript:;" class="">
					<i class="icon-briefcase"></i> Extra
					<span class="arrow"></span>
					</a>
					<ul class="sub">
						<li><a class="" href="extra_pricing_table.html">Pricing Tables</a></li>
						<li><a class="" href="extra_404.html">404 Page</a></li>
						<li><a class="" href="extra_500.html">500 Page</a></li>
						<li><a class="" href="extra_blank.html">Blank Page</a></li>
					</ul>
				</li>
				<li><a class="" href="login.html"><i class="icon-user"></i> Login Page</a></li>
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
	
	
	
	<div style="display: none;" id="myModal1" class="modal hide fade in slide_show_container animated zoomIn" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="false">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
			<h3 id="myModalLabel1">Modal Header</h3>
		</div>
		<div class="modal-body">
			<p>Body goes here...</p>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
			<button class="btn yellow">Save</button>
		</div>
	</div>
	<div class="modal-backdrop fade in" style="display:none;"></div>
	
	<!----Session Destroy----->
	<div style="display: none;" id="myModal1" class="modal hide fade in session_destroy_container" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="false">
		<div class="modal-body">
			<p><b>Disconnected from the server</b></p><br/>
			<p>Your session has expired. please re-login for access.</p><br/>
			<a href="<?php $webroot_path; ?>" class="btn green">Login</a>
		</div>
	</div>
	<!-----end---->
	
	<!----No Connection----->
	<div style="display: none;" id="myModal1" class="modal hide fade in no_connection_container" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="false">
		<div class="modal-body">
			<p><b>Disconnected from the server (No Internet Connection)</b></p><br/>
			<p>This can occur either because you're not connected to the Internet or because our servers are temporarily having problems. Reload the page.</p>
		</div>
	</div>
	<!-----end---->
</body>
</html>