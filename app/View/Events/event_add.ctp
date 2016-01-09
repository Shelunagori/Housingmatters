<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>
<script>
$(document).ready(function() {
$("#fix<?php echo @$id_current_page; ?>").removeClass("blue");
$("#fix<?php echo @$id_current_page; ?>").addClass("red");
});
</script>

<div id="success_div2">
<div style="border-bottom:solid 2px #44b6ae; color:white; background-color: #44b6ae; padding:4px; font-size:20px;"><i class="icon-calendar"></i> Create New Event</div>
<div style="padding:10px;background-color:#fff;border: solid 1px rgb(68, 182, 174);">


<form method="post"  enctype="multipart/form-data">
<!-------------------------------------->
<div class="row-fluid">
	<div class="span6">
		
		
		<div class="control-group">
		  <label class="control-label">Event Name</label>
		  <div class="controls">
			 <input type="text" name="e_name" class="span9 m-wrap" maxlength="50" id="alloptions" placeholder="Event Name">
			 <label report="e_name" class="remove_report"></label>
		  </div>
		</div>

		<div class="control-group ">
		  <div class="controls">
		   <label class="" style="font-size:14px;">Description</label>
			  <textarea name="description" rows="2"  id="textarea" maxlength="500" class="span9 m-wrap" style="resize:none;" placeholder="More info about event"></textarea>
			  <label report="description" class="remove_report"></label>
		  </div>
		</div>

		<div class="controls">
			<label class="radio">
			<input type="radio" name="day_type" id="single" checked=""  value="1" style="opacity: 0;">
			Single day Event
			</label>
			<label class="radio">
			<input type="radio" name="day_type" id="multiple" value="2" style="opacity: 0;">
			Multiple days Event
			</label> 
		</div>

		<div class="control-group" id="dubble_date" style="display:none;">
		  <div class="controls">
			<input type="text" name="date_from" data-date-format="dd-mm-yyyy" class="span3 m-wrap date-picker" placeholder="Date From">
			<input type="text" name="date_to" data-date-format="dd-mm-yyyy" class="span3 m-wrap date-picker" placeholder="Date To">
		  </div>
		</div>

		<div class="control-group" id="single_date" >
		  <div class="controls">
			<input type="text" name="date_single" data-date-format="dd-mm-yyyy" class="span3 m-wrap date-picker" placeholder="Date">
		  </div>
		</div>
		<label report="day_type" class="remove_report"></label>
		
		<div class="control-group">
			 <label class="checkbox">
			 <div class="checker"><span><div class="checker" id="uniform-undefined"><span><input type="checkbox" value="1" name="ask_no_of_member" style="opacity: 0;"></span></div></span></div>
			 Do you want to ask how many members will attend this event from participator family to participator?   
			 </label>
		</div>
		
		
		
	</div>
	<div class="span6">
		
			<div class="control-group">
			  <label class="control-label">Time</label>
			  <div class="controls">
				 <div class="input-append bootstrap-timepicker-component">
					<input class="m-wrap m-ctrl-small timepicker-default " type="text" name='e_time'>
					<span class="add-on"><i class="icon-time"></i></span>
					<label report="e_time" class="remove_report"></label>
				 </div>
			  </div>
			</div>

		
		
		
		
		
		<div class="control-group">
  <label class="control-label">Location</label>
  <div class="controls">
	 <textarea name="location" rows="3" id="alloptions" class="span9 m-wrap" placeholder="Location"></textarea>
	 <label report="location" class="remove_report"></label>
  </div>
</div>

	<!---------------start visible-------------------------------->
	<label class="" style="font-size:14px;">Event should be visible to<span style="color:red;">*</span>   <i class=" icon-info-sign tooltips" data-placement="right" data-original-title="Please select any one"> </i></label>

	<div class="controls">
	<label class="radio line">
	<div class="radio"><span><input type="radio" checked name="visible" value="1" id="v1"></span></div>All Users
	</label>
	</div>

	<div class="controls">
	<label class="radio line">
	<div class="radio"><span><input type="radio"  name="visible" value="4" id="v1"></span></div>All Owners  
	</label>
	</div>

	<div class="controls">
	<label class="radio line">
	<div class="radio"><span><input type="radio"  name="visible" value="5" id="v1"></span></div>All Tenant
	</label>
	</div>


	<div class="controls">
	<label class="radio line">
	<div class="radio" ><span><input type="radio"  name="visible" value="2" id="v2" ></span></div>Role Wise
	</label>
	</div>

	<div id="show_2" style="display:none; margin-left:5%;">
	<div class="controls">
	<?php
	foreach ($role_result as $collection) 
	{
	$role_id=$collection["role"]["role_id"];
	$role_name=$collection["role"]["role_name"];
	?>
	<label class="checkbox">
	<div class="checker"><span><input type="checkbox"  value="<?php echo $role_id; ?>" name="role<?php echo $role_id; ?>" class="v2 requirecheck1" id="requirecheck1"></span></div> <?php echo $role_name; ?>
	</label>
	<?php } ?>
	</div>
	<label report="visible_role" class="remove_report"></label>	
	</div>

	<div class="controls">
	<label class="radio line">
	<div class="radio"><span><input type="radio" name="visible" value="3" id="v3" ></span></div>Wing Wise
	</label> 
	</div>
	<div id="show_3" style="display:none; margin-left:5%;overflow: auto;">
	<label report="visible_wing" class="remove_report"></label>
	<div class="controls">
	<?php
	foreach ($wing_result as $collection) 
	{
	$wing_id=$collection["wing"]["wing_id"];
	$wing_name=$collection["wing"]["wing_name"];
	?>
	<div style="float:left; padding-left:15px;">
	<label class="checkbox" >
	<div class="checker"><span><input type="checkbox"  value="<?php echo $wing_id; ?>" name="wing<?php echo $wing_id; ?>" class="v3 requirecheck2" id="requirecheck2" ></span></div> <?php echo $wing_name; ?>
	</label>
	</div>
	<?php } ?>
	</div>
	
	</div>	
	<!---------------end visible-------------------------------->
	
	</div>
	
</div>
		
<div  style="margin-bottom:0px !important;">
	<button type="submit" name="create_event" class="btn blue" style="font-size: 20px;padding: 12px;"><i class="icon-calendar"></i> Create Event</button>
	 <div style="display:none;" id='wait'><img src="<?php echo $webroot_path; ?>as/fb_loading.gif" /> Please Wait...</div>
</div>
</form>
</div>
</div>

<script>
$(document).ready(function(){
  $("#multiple").click(function(){
    $("#dubble_date").show();
	$("#single_date").hide();
  });
  
  $("#single").click(function(){
    $("#single_date").show();
	$("#dubble_date").hide();
  });
});
</script>

<script>
$(document).ready(function() { 
	 $("#v3").live('click',function(){
		$("#show_3").slideDown('fast');
		$("#show_2").slideUp('fast');
		$("#show_1").slideUp('fast');
	 });
	 
	 $("#v2").live('click',function(){
		$("#show_2").slideDown('fast');
		$("#show_3").slideUp('fast');
		$("#show_1").slideUp('fast');
	 });
	 
	 $("#v1").live('click',function(){
		$("#show_1").slideDown('fast');
		$("#show_2").slideUp('fast');
		$("#show_3").slideUp('fast');
	 });
});
</script>

<script>
$(document).ready(function() {
	$('form').submit( function(ev){
	ev.preventDefault();
		
		
		var m_data = new FormData();    
		m_data.append( 'e_name', $('input[name=e_name]').val());
		m_data.append( 'description', $('textarea[name=description]').val());
		var day_type=$('input:radio[name=day_type]:checked').val();
	
		
		m_data.append( 'day_type', day_type);
		if(day_type==1){
			m_data.append( 'date_single', $('input[name=date_single]').val());
		}else{
			m_data.append( 'date_from', $('input[name=date_from]').val());
			m_data.append( 'date_to', $('input[name=date_to]').val());
		}
		m_data.append( 'e_time', $('input[name=e_time]').val());
		m_data.append( 'location', $('textarea[name=location]').val());
		
		var visible=$('input:radio[name=visible]:checked').val();
		m_data.append( 'visible', visible);
		if(visible==2){
			var allVals = [];
			$('.v2:checked').each(function() {
			allVals.push($(this).val());
			});
			if(allVals.length==0){
				m_data.append( 'sub_visible', 0);
			}else{
				m_data.append( 'sub_visible', allVals);
			}
		}
		if(visible==3){
			var allVals = [];
			$('.v3:checked').each(function() {
			allVals.push($(this).val());
			});
			if(allVals.length==0){
				m_data.append( 'sub_visible', 0);
			}else{
				m_data.append( 'sub_visible', allVals);
			}
		}
		if(visible==1 || visible==4 || visible==5){
			m_data.append( 'sub_visible', 0);
		}
		
		m_data.append( 'ask_no_of_member', $('input:checkbox[name=ask_no_of_member]:checked').val());
		$(".form_post").addClass("disabled");
		$("#wait").show();
			
			$.ajax({
			url: "event_submit",
			data: m_data,
			processData: false,
			contentType: false,
			type: 'POST',
			dataType:'json',
			}).done(function(response) {
			//$("#wait").html(response);
				if(response.report_type=='error'){
					$(".remove_report").html('');
						jQuery.each(response.report, function(i, val) {
						$("label[report="+val.label+"]").html('<span style="color:red;">'+val.text+'</span>');
					});
				}
				if(response.report_type=='success'){
					
					$("#success_div2").html("<div class='alert alert-block alert-success fade in'><h4 class='alert-heading'>Success!</h4><p>Your Event is successfully reated.</p><p><a class='btn green' href='<?php echo $webroot_path ?>Events/events' rel='tab' role='button'>ok</a></p></div>");
					
				}
			$("html, body").animate({
			scrollTop:0
			},"slow");
			$(".form_post").removeClass("disabled");
			$("#wait").hide();
			});

	 
	});
});

</script>