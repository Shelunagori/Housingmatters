<div class="modal-body" style="height: 300px; overflow: hidden;">
	<div class="row-fluid">
		<div class="span3" align="center">
			<span style="padding: 20px 17px;font-size: 30px;"><i class="fa fa-comments"></i></span>
		</div>
		<div class="span9">
			<span style="color:#1D1D1D;font-size:14px;line-height:20px;font-weight:bold">Discussion forum:</span>
			<br/>
			<span style="color:#454545;font-size:14px;line-height:20px;font-weight:bold">This is equivalent of your society facebook page where you can join or start new online discussion amongst your society members</span>
		</div>
	</div>
	<br/>
	<div class="row-fluid">
		<div class="span3" align="center">
			<span style="padding: 20px 17px;font-size: 30px;"><i class="icon-bullhorn"></i></span>
		</div>
		<div class="span9">
			<span style="color:#1D1D1D;font-size:14px;line-height:20px;font-weight:bold">Online Notice Board: </span>
			<br/>
			<span style="color:#454545;font-size:14px;line-height:20px;font-weight:bold" >You can view all your society notices here as well as give comments/feedback on notices issued by the society office.</span>
		</div>
	</div>
	<br/>
	<div class="row-fluid">
		<div class="span3" align="center">
			<span style="padding: 20px 17px;font-size: 30px;"><i class="icon-headphones"></i></span>
		</div>
		<div class="span9">
			<span style="color:#1D1D1D;font-size:14px;line-height:20px;font-weight:bold">Helpdesk:</span>
			<br/>
			<span style="color:#454545;font-size:14px;line-height:20px;font-weight:bold">You can raise helpdesk tickets for any ideas, suggestions or complaints to your Management Committee via helpdesk. You will get status updates on your helpdesk tickets as well as follow up for your pending helpdesk tickets becomes easier.</span>
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
			url: "<?php echo Router::url(array('controller' => 'Hms', 'action' =>'fetch_slide_3'), true); ?>",
		}).done(function(response) {
			$(".slide_show_container").html(response);
		});
		
	});
	
});
</script>