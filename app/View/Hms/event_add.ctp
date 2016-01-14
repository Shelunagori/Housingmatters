<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>



<div style="border:solid 2px #44b6ae; width:80%; margin-left:10%;margin-top:4px;">
<div style="border-bottom:solid 2px #44b6ae; color:white; background-color: #44b6ae; padding:4px; font-size:20px;"><i class="icon-calendar"></i> Create New Event</div>
<div style="padding:10px;background-color:#fff;">

<form method="post" id="contact-form" enctype="multipart/form-data">
<!-------------------------------------->


<div class="control-group">
  <label class="control-label">Event Name</label>
  <div class="controls">
	 <input type="text" name="e_name" class="span8 m-wrap" maxlength="50" id="alloptions" placeholder="Event Name">
  </div>
</div>


<div class="control-group ">
  <div class="controls">
   <label class="" style="font-size:14px;">Description</label>
	  <textarea name="description" rows="2"  id="textarea" maxlength="500" class="span8 m-wrap" style="resize:none;" placeholder="More info about enent"></textarea>
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




<div class="control-group">
  <label class="control-label">Location</label>
  <div class="controls">
	 <input type="text" name="location" class="span8 m-wrap" maxlength="100" id="alloptions" placeholder="Location">
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
			<label  id="requirecheck1"></label>
			</div>

			<div class="controls">
			<label class="radio line">
			<div class="radio"><span><input type="radio" name="visible" value="3" id="v3" ></span></div>Wing Wise
			</label> 
			</div>
			<div id="show_3" style="display:none; margin-left:5%;">
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
			</div><br/>
			<label id="requirecheck2"></label>
			</div>
			
			<div class="controls">
			<label class="radio line">
			<div class="radio" ><span><input type="radio"  name="visible" value="6" id="v4" ></span></div> Manually
			</label>
			</div>
			<div id="show_4" style="margin-left:5%;">
			<div class="controls">
			<!-->
			<div class="control-group">
			<div class="controls">

			<select data-placeholder="Type or select name"  name="multi[]" id="multi" class="chosen span5" multiple="multiple" tabindex="6" >
			<?php
			foreach ($result_users as $collection) 
			{
			$user_id=$collection["user"]["user_id"];
			$user_name=$collection["user"]["user_name"];
			$email=$collection["user"]["email"];
			$wing=$collection["user"]["wing"];
			$flat=$collection["user"]["flat"];

			$flat=$this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'), array('pass' => array($wing,$flat)));

			?>
			<option value="<?php echo $user_id; ?>" ><?php echo $user_name; ?>&nbsp;&nbsp;<?php echo $flat; ?></option>
			<?php } ?>           

			</select>
			</div>
			</div>
			<!-->
			</div>
			</div>
			<!---------------end visible-------------------------------->
			
			
<!-------------------------------------->
</div>

<div class="form-actions" style="margin-bottom:0px !important;">
	<button type="submit" name="create_event" class="btn blue" style="font-size: 20px;padding: 12px;"><i class="icon-calendar"></i> Create Event</button>
</div>
</form>
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
$("#show_4").hide();
	 $("#v3").live('click',function(){
		$("#show_3").slideDown('fast');
		$("#show_2").slideUp('fast');
		$("#show_1").slideUp('fast');
		$("#show_4").slideUp('fast');
	 });
	 
	 $("#v2").live('click',function(){
		$("#show_2").slideDown('fast');
		$("#show_3").slideUp('fast');
		$("#show_1").slideUp('fast');
		$("#show_4").slideUp('fast');
	 });
	 
	 $("#v1").live('click',function(){
		$("#show_1").slideDown('fast');
		$("#show_2").slideUp('fast');
		$("#show_3").slideUp('fast');
		$("#show_4").slideUp('fast');
	 });
	 
	 $("#v4").live('click',function(){
		$("#show_4").slideDown('fast');
		$("#show_1").slideUp('fast');
		$("#show_2").slideUp('fast');
		$("#show_3").slideUp('fast');
	 });
});
</script>

<script>
$(document).ready(function(){
		$('#contact-form').validate({
	    rules: {
	      question: {
	       
	        //required: true
	      },
		description:
        {
           //required: true,
            remote: "content_check_des"
        },
		  password: {
	        required: true,
	      },

	    },
		messages: {
	                email: {
	                    remote: "Login-Id is Already Exist."
	                },
					 description: {
	                    remote: "You have enter wrong word."
	                }
	            },
		
			highlight: function(element) {
				$(element).closest('.control-group').removeClass('success').addClass('error');
			},
			success: function(element) {
				element
				.text('OK!').addClass('valid')
				.closest('.control-group').removeClass('error').addClass('success');
			}
	  });
	  
}); 

</script>

	
	