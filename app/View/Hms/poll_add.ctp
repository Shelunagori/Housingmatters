<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>
<script>
$(document).ready(function() {
$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>



<div style="border:solid 2px #4cae4c; width:80%; margin-left:10%;margin-top:4px;">
<div style="border-bottom:solid 2px #4cae4c; color:white; background-color: #5cb85c; padding:4px; font-size:20px;"><i class="icon-question-sign"></i> Create New Poll</div>
<div style="padding:10px;background-color: white;">

<form method="post" id="contact-form" enctype="multipart/form-data">
<!-------------------------------------->

<div class="control-group">
  <label class="control-label">Question</label>
  <div class="controls">
	 <input type="text" class="span9 m-wrap" name="question" id="question" placeholder="Type a question here..." >
	<label id="question"></label>
  </div>
</div>


<div class="control-group">
  <label class="control-label">Description</label>
  <div class="controls">
	 <textarea class="span9 m-wrap" name="description" id="description" rows="5" placeholder="Type description here..." style="resize:none;"></textarea>
	 	<label id="description"></label>
  </div>
</div>







<div class="row-fluid">
<!-------------CHOICE------------------------->
<div class="span6">
	<!-- BEGIN PORTLET-->
	<div class="portlet solid bordered" style="background-color:#fff;overflow: auto;">
		<!-------HEADER----------->
		<div class="control-group">
			<div class="controls">
			 <label class="radio">
			 <div class="radio" ><input type="radio" checked name="type" value="1" ></div>
			 Single Choice 
			 </label>
			 <label class="radio">
			 <div class="radio" ><input type="radio"  name="type" value="2" ></div>
			 Multiple Choice 
			 </label>  
			</div>
		</div>
		<!-------HEADER END----------->
		<div class="portlet-body">
		<!-------CONTENT--------->
		<div class="control-group">
		  <label class="control-label">Choices</label>
			<div id="choice_div">
			  <div class="controls">
				<input type="text" name="choice1" class="span10 m-wrap" placeholder="1." >
			  </div>
			  <div class="controls">
				<input type="text" name="choice2" class="span10 m-wrap" placeholder="2." >
			  </div>
			</div>
			<input type="hidden" value="2" name="choice_text_box" id="choice_text_box">
			<a class="btn mini" id="add">Add</a>
			<a class="btn mini" id="remove">Remove</a>
		</div>
		<!-------CONTENT END--------->
		</div>
	</div>
	<!-- END PORTLET-->
</div>
<!-------------CHOICE END------------------------->

<!-------------PIE------------------------->
<div class="span6">
	<!-- BEGIN PORTLET-->
	<div class="portlet solid bordered" style="background-color:#fff;overflow: auto;">
		<div class="portlet-body">
		<!-------CONTENT--------->
		<!--<div class="control-group">
		  <label class="control-label">Image Upload</label>
		  <div class="controls">
			 <div class="fileupload fileupload-new" data-provides="fileupload">
				<div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
				   <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="">
				</div>
				<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
				<div>
				   <span class="btn btn-file"><span class="fileupload-new">Select image</span>
				   <span class="fileupload-exists">Change</span>
				   <input type="file" name="file" class="default"></span>
				   <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
				</div>
			 </div>
			 <span class="label label-important">NOTE!</span>
			 <span>
			 Attached image thumbnail is
			 supported in Latest Firefox, Chrome, Opera, 
			 Safari and Internet Explorer 10 only
			 </span>
		  </div>
	   </div>-->
		<!-------CONTENT END--------->
		</div>
	</div>
	<!-- END PORTLET-->
</div>
<!-------------EVENTS PIE------------------------->
</div>
<!---------------start visible-------------------------------->
			<label class="" style="font-size:14px;">Who can participate in the poll? <span style="color:red;">*</span>   <i class=" icon-info-sign tooltips" data-placement="right" data-original-title="Please select any one"> </i></label>
			
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
			
			
			
			<!---------------end visible-------------------------------->
<br/>

<div class="control-group">
	<div class="controls">
	<label class="" style="font-size:14px;">Poll will be close after<span style="color:red;">*</span> <i class=" icon-info-sign tooltips" data-placement="right" data-original-title="Your poll will expire by this date and Archived"> </i></label>
	<input type="text" class="span4 m-wrap  m-ctrl-medium date-picker" data-date-format="dd-mm-yyyy" placeholder="Please select date"  name="poll_close_date">
	</div>
</div>
			
			
<div class="control-group">
  <label class="control-label">Is this secret poll?</label>
  
	 <label class="checkbox">
	 <div class="checker" ><span><input type="checkbox" value="1" name="private" style="opacity: 0;"></span></div>
	 if checked, the result will be private (only visible to you).
	 </label>
  
</div>			
			
<!-------------------------------------->
</div>

<div class="form-actions" style="margin-bottom:0px !important;">
	<button type="submit" name="create_poll" class="btn blue" ><i class="icon-question-sign"></i> Create Poll</button>
	<a href="#myModal1" role="button" class="btn yellow" id="preview" data-toggle="modal">Preview</a>
	<!--preview-------->
	<div id="myModal1" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true" style="display: none;">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
			<span style="color:#3B6B96;font-size: 16px;font-weight: bold;"><i class="icon-question-sign"></i> <span id="get_question"></span></span><br/>
			<span style="font-size: 12px;" id="get_description">नजीब जंग हाल ही में समाचारों में रहे| वह हैः नजीब जंग हाल ही में समाचारों में रहे| वह हैः नजीब जंग हाल ही में समाचारों में रहे| वह हैः नजीब जंग हाल ही में समाचारों में रहे| वह हैः नजीब जंग हाल ही में समाचारों में रहे| वह हैः नजीब जंग हाल ही में समाचारों में रहे| वह हैः नजीब जंग हाल ही में समाचारों में रहे| वह हैः नजीब जंग हाल ही में समाचारों में रहे| वह हैः नजीब जंग हाल ही में समाचारों में रहे| वह हैः नजीब जंग हाल ही में समाचारों में रहे| वह हैः </span>
		</div>
		<div class="modal-body">
			<div id="get_choice"></div>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
		</div>
	</div>
	<!--preview-------->
</div>
</form>
</div>

<script>
$(document).ready(function(){
  $("#all_day").click(function(){
    $(".time_toggle").toggle();
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
$(document).ready(function() {
	var inc=2;
	 $("#add").live('click',function(){
		inc++;
		$("#choice_text_box").val(inc);
		$("#choice_div").append('<div class="controls" id=tax'+inc+'><input name=choice'+inc+' type="text" class="span10 m-wrap" placeholder='+inc+'></div>');
	 });
	 
	 $("#remove").live('click',function(){
		$("#tax"+inc).remove();
		if(inc>2)
		{
		inc--;
		$("#choice_text_box").val(inc);
		}
	 });
});
</script>

<script>
$(document).ready(function() {
	 $("#preview").live('click',function(){
	 var question=$("#question").val();
	 $("#get_question").text(question);
	 
	 var des=$("#description").val();
	 $("#get_description").text(des);
	 
	 var no_of_choice=$("#choice_text_box").val();
	 
		$("#get_choice").html('');
		var alphabet = new Array("A","B","C","D","E","F","G","H","I","J");
		var ol=0;
		 for(e=1;e<=no_of_choice;e++)
		 {
		 var c=$("input[name=choice"+e+"]").val();
		 $("#get_choice").append('<span ><span style="font-weight:bold;">['+alphabet[ol]+']</span>&nbsp;&nbsp;&nbsp;'+c+'</span><br/>');
		 ol=ol+1;
		 }
		 //$("#get_choice").append('</ol>');
		 
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
            //remote: "content_check_des"
        },
		  password: {
	        required: true,
	      },

	    },
		messages: {
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
