<div class="modal-body" style="height: 300px; overflow: hidden;">
	<div class="row-fluid">
		<div class="span3" align="center">
			<span style="padding: 20px 17px;font-size: 30px;"><i class="icon-home"></i></span>
		</div>
		<div class="span9">
			<span style="color:#1D1D1D;font-size:14px;line-height:20px;font-weight:bold">My Flat View: </span>
			<br/>
			<span style="color:#454545;font-size:14px;line-height:20px;font-weight:bold" >Check history all your maintenance bills and payments made by you.</span>
		</div>
	</div>
	<br/>
	<div class="row-fluid">
		<div class="span3" align="center">
			<span style="padding: 20px 17px;font-size: 30px;"><i class="icon-shopping-cart"></i></span>
		</div>
		<div class="span9">
			<span style="color:#1D1D1D;font-size:14px;line-height:20px;font-weight:bold">Classified ads: </span>
			<br/>
			<span style="color:#454545;font-size:14px;line-height:20px;font-weight:bold" >Next time you want to say, dispose of your mobile phone or looking for a bicycle, do check the classifieds section. It may just be available next door in your society.</span>
		</div>
	</div>
	<br/>
	<div class="row-fluid">
		<div class="span3" align="center">
			<span style="padding: 20px 17px;font-size: 30px;"><i class="icon-th-list"></i></span>
		</div>
		<div class="span9">
			<span style="color:#1D1D1D;font-size:14px;line-height:20px;font-weight:bold">Contact Handbook: </span>
			<br/>
			<span style="color:#454545;font-size:14px;line-height:20px;font-weight:bold" >If you have utilized services of any good electrician, please feel free to update your society handbook for benefit of your community. And you just might find a better service provider from someone’sfirst-hand experience. </span>
		</div>
	</div>
</div>

<div class="modal-footer" style="padding: 10px 15px;background-color: #E4E1E1;">
	<a class="btn mini blue remind" style="padding: 7px 10px;background-color: #008BCE;"><b>Show Me Later</b> <i class="fa fa-bell-o"></i></a>
	<a class="btn mini blue next" style="padding: 7px 10px;background-color: #008BCE;"><b>Next</b> <i class="fa fa-arrow-right"></i></a>
</div>
<script>
$( document ).ready(function() {
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
			url: "<?php echo Router::url(array('controller' => 'Hms', 'action' =>'fetch_slide_5'), true); ?>",
		}).done(function(response) {
			$(".slide_show_container").html(response);
		});
		
	});
	
});
</script>