<div class="modal-body" style="height: 300px; overflow: hidden;">
	<div align="center" style="display:none;" class="img_hm">
	<img src="<?php echo $ip.$this->webroot; ?>/as/hm/hm150px.jpg"/>
	</div>
	<br/><br/>
	<div align="center" style="display:none;" class="welcome_text">
		<span style="color:#141823;text-decoration:none;font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:20px;line-height:25px;font-weight:bold" target="_blank">Welcome to your housing society’s online portal hosted exclusively for society members on HousingMatters</span>
	</div>
</div>

<div class="modal-footer" style="padding: 10px 15px;background-color: #E4E1E1;">
	<a class="btn mini blue remind" style="padding: 7px 10px;background-color: #008BCE;"><b>Show Me Later</b> <i class="fa fa-bell-o"></i></a>
	<a class="btn mini blue next" style="padding: 7px 10px;background-color: #008BCE;"><b>Next</b> <i class="fa fa-arrow-right"></i></a>
</div>
<script>
$( document ).ready(function() {
	setTimeout(function() { 
		 $('.img_hm').show().addClass('animated bounceInUp');
   }, 1500);
   
   setTimeout(function() { 
		$('.welcome_text').show().addClass('animated bounceInLeft');
   }, 2000);
   
   $( ".remind" ).click(function() {
	   $.ajax({
			url: "<?php echo Router::url(array('controller' => 'Hms', 'action' =>'update_slide_show_me_later'), true); ?>",
		}).done(function(response) {
			$('.slide_show_container').addClass('animated zoomOut');
			 setTimeout(function() { 
				 $('.modal-backdrop').hide();
				 $('.slide_show_container').hide();
			}, 800);
		});
	 
	});
	
	$( ".next" ).click(function() {
		$( ".next" ).html('<b>Next</b> <i class="fa fa-spinner fa-pulse"></i>');
		$.ajax({
			url: "<?php echo Router::url(array('controller' => 'Hms', 'action' =>'fetch_slide_2'), true); ?>",
		}).done(function(response) {
			$(".slide_show_container").html(response);
		});
		
	});
	
});
</script>