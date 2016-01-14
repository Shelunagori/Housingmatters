<div class="modal-body" style="height: 300px; overflow: hidden;">
	<div class="row-fluid">
		<div class="span3" align="center">
			<span style="padding: 20px 17px;font-size: 30px;"><i class="icon-file"></i></span>
		</div>
		<div class="span9">
			<span style="color:#1D1D1D;font-size:14px;line-height:20px;font-weight:bold">Documents: </span>
			<br/>
			<span style="color:#454545;font-size:14px;line-height:20px;font-weight:bold" >All important documents, reports and templates/forms of your society are available for viewing, download and printing at a click.</span>
		</div>
	</div>
	<br/>
	<div class="row-fluid">
		<div class="span3" align="center">
			<span style="padding: 20px 17px;font-size: 30px;"><i class="icon-book"></i></span>
		</div>
		<div class="span9">
			<span style="color:#1D1D1D;font-size:14px;line-height:20px;font-weight:bold">Residents Directory: </span>
			<br/>
			<span style="color:#454545;font-size:14px;line-height:20px;font-weight:bold" >Your society’s resident directory with members’ details is now online and accessible from anywhere. Please do update your profile for the benefit of all members.</span>
		</div>
	</div>
	<br/>
	<div class="row-fluid">
		<div class="span3" align="center">
			<span style="padding: 20px 17px;font-size: 30px;"><i class="icon-question-sign"></i></span>
		</div>
		<div class="span9">
			<span style="color:#1D1D1D;font-size:14px;line-height:20px;font-weight:bold">Polls: </span>
			<br/>
			<span style="color:#454545;font-size:14px;line-height:20px;font-weight:bold" >You can create opinion polls to get views from your society members & equally participate in opinion polls raised by your society members. For instance: Which sports do we include for our annual day celebrations this year?</span>
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
			url: "<?php echo Router::url(array('controller' => 'Hms', 'action' =>'fetch_slide_4'), true); ?>",
		}).done(function(response) {
			$(".slide_show_container").html(response);
		});
		
	});
	
});
</script>