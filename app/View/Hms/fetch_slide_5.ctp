<div class="modal-body" style="height: 300px; overflow: hidden;">
	<div class="row-fluid">
		<div class="span12" align="center">
			<img src="<?php echo $ip.$this->webroot; ?>/as/hm/hm150px.jpg"/>
		</div>
	</div>
	<br/><br/>
	<div class="row-fluid">
		<div class="span12" align="center">
			<span style="color:#454545;font-size:16px;line-height:20px;font-weight:bold" >Thank You</span>
		</div>
	</div>
	<br/>
	<div class="row-fluid">
		<div class="span12" align="center">
			<span style="color:#454545;font-size:14px;line-height:20px;font-weight:bold" >And much more. So keep exploring & have fun. Happy to hear from you about any suggestions or ideas for making life simpler. Do write to us at support@housingmatters.in</span>
		</div>
	</div>
</div>

<div class="modal-footer" style="padding: 10px 15px;background-color: #E4E1E1;">
	<a class="btn mini blue close_popup" style="padding: 7px 10px;background-color: #008BCE;"><b>Close</b> <i class="icon-remove"></i></a>
</div>
<script>
$( document ).ready(function() {
   $( ".close_popup" ).click(function() {
	   $.ajax({
			url: "<?php echo Router::url(array('controller' => 'Hms', 'action' =>'have_seen_slide_show'), true); ?>",
		}).done(function(response) {
			$('.slide_show_container').addClass('animated zoomOut');
				 setTimeout(function() { 
					 $('.modal-backdrop').hide();
					 $('.slide_show_container').hide();
				}, 800);
			});
		});
	 
	
});
</script>