<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>


<div style="padding:5px;" align="center">
<a href="email_view" class="btn blue">Email History</a>
<a href="email" class="btn red">Send Email</a>
</div>

<div style="border:solid 2px #4cae4c; width:80%; margin-left:10%;">
<div style="border-bottom:solid 2px #4cae4c; color:white; background-color: #5cb85c; padding:4px; font-size:20px;" ><i class="icon-envelope-alt"></i> Send Email</div>
<div style="padding:10px;background-color:#FFF;">
<!----------------------------------------------->
<form method="post" id="contact-form" name="myform" enctype="multipart/form-data" >
<div class="controls">
 <label class="radio">
 <div class="radio" id="uniform-undefined"><input type="radio"  id="r1" checked name="radio" value="1" style="opacity: 0;"></div>
 <span style="font-size:16px;" >Send Email to Individual</span>
 </label>
 <label class="radio">
 <div class="radio" id="uniform-undefined"><input type="radio"  id="r3"  name="radio" value="3" style="opacity: 0;"></div>
 <span style="font-size:16px;" >Send Email to Default Groups</span>
 </label>
 <label class="radio">
 <div class="radio" id="uniform-undefined"><input type="radio" id="r2" name="radio" value="2"  style="opacity: 0;"></div>
 <span style="font-size:16px;" >Send Email to Custom Groups</span>
 </label>  
</div>
<label style="font-size:14px; font-weight:bold;">To <i class=" icon-info-sign tooltips" data-placement="right" data-original-title="email will be sent to only those users whose valid emails are registered with HousingMatters"> </i></label>
<!------------------------->
<div class="control-group" id="d1" >
  <div class="controls">
   
	 <select data-placeholder="Type or select name"  name="multi[]" id="multi" class="chosen span9" multiple="multiple" tabindex="6">
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
<option value="<?php echo $user_id; ?>,<?php echo $email; ?>"><?php echo $user_name; ?>&nbsp;&nbsp;<?php echo $flat; ?>,<?php echo $email; ?></option>
<?php } ?>           
		  
	 </select>
	 <label id="multi"></label>
  </div>
</div>
<!------------------------->

<!-------------------------->

<div style="display:none; padding:5px;" id="d2" >
<?php
foreach ($result_group as $collection) 
{
$group_name=$collection["group"]["group_name"];
$group_id=$collection["group"]["group_id"];
?>
<label class="checkbox">
<input type="checkbox" class="requirecheck3" id="requirecheck1234" name="grp<?php echo $group_id; ?>" value="<?php echo $group_id; ?>"> <?php echo $group_name; ?>
</label>
<?php } ?> 
<label id="requirecheck1234"></label>
</div>
<!--------------------------->

<!-------------------------->

<div style="display:none; padding:5px;" id="d3" >
<!---------------start visible-------------------------------->
			
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
</div>
<!--------------------------->

<!-------------------------->
<label style="font-size:14px; font-weight:bold;">Subject</label>
<div class="controls">
 <input type="text" name="subject" id="subject" class="span9 m-wrap">
 <label id="subject"></label>
</div>
<!-------------------------->

<!-------------------------->
<label style="font-size:14px; font-weight:bold;">Email</label>
<div class="control-group">
  <div class="controls">
	 <textarea class="span12 wysihtml5 m-wrap" name="email" title="message" id="email" rows="6"></textarea>
  </div>
</div>
<label id="email"></label>
<!-------------------------->

<a href="#myModal3" role="button" class="btn blue pull-right" data-toggle="modal" style="">  Templates</a>
 <div id="myModal3" style="margin-top:-5%;" class="modal hide " tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
		<h3 id="myModalLabel3">Select Template</h3>
	</div>
	
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab_1_1" data-toggle="tab">Events</a></li>
			<li class=""><a href="#tab_1_2" data-toggle="tab">Finance</a></li>
			<li class=""><a href="#tab_1_3" data-toggle="tab">Maintenance</a></li>
			<li class=""><a href="#tab_1_4" data-toggle="tab">Meetings</a></li>
			<li class=""><a href="#tab_1_5" data-toggle="tab">Notice</a></li>
			<li class=""><a href="#tab_1_6" data-toggle="tab">Updates</a></li>
			<li class=""><a href="#tab_1_7" data-toggle="tab">Vendors</a></li>
		</ul>
		<div class="scroller" data-height="400px">
		<!---------content---------------------->
		<div class="tab-content">
			<div class="tab-pane active" id="tab_1_1">
			<?php
			foreach ($result_template1 as $cat1) 
			{
			$template=$cat1["template"]["template"];
			?>                                 
			<div class="tmplt t_hov" onClick="templt('<?php echo $template; ?>')" data-dismiss="modal">
			<?php echo $template; ?>
			</div>
			<?php } ?>
			</div>
			
			<div class="tab-pane" id="tab_1_2">
			<?php
			foreach ($result_template2 as $cat2) 
			{
			$template=$cat2["template"]["template"];
			?>                                 
			<div class="tmplt t_hov" onClick="templt('<?php echo $template; ?>')" data-dismiss="modal">
			<?php echo $template; ?>
			</div>
			<?php } ?>
			</div>
			
			<div class="tab-pane" id="tab_1_3">
			<?php
			foreach ($result_template3 as $cat3) 
			{
			$template=$cat3["template"]["template"];
			?>                                 
			<div class="tmplt t_hov" onClick="templt('<?php echo $template; ?>')" data-dismiss="modal">
			<?php echo $template; ?>
			</div>
			<?php } ?>
			</div>
			
			<div class="tab-pane" id="tab_1_4">
			<?php
			foreach ($result_template4 as $cat4) 
			{
			$template=$cat4["template"]["template"];
			?>                                 
			<div class="tmplt t_hov" onClick="templt('<?php echo $template; ?>')" data-dismiss="modal">
			<?php echo $template; ?>
			</div>
			<?php } ?>
			</div>
			
			<div class="tab-pane" id="tab_1_5">
			<?php
			foreach ($result_template5 as $cat5) 
			{
			$template=$cat5["template"]["template"];
			?>                                 
			<div class="tmplt t_hov" onClick="templt('<?php echo $template; ?>')" data-dismiss="modal">
			<?php echo $template; ?>
			</div>
			<?php } ?>
			</div>
			
			<div class="tab-pane" id="tab_1_6">
			<?php
			foreach ($result_template6 as $cat6) 
			{
			$template=$cat6["template"]["template"];
			?>                                 
			<div class="tmplt t_hov" onClick="templt('<?php echo $template; ?>')" data-dismiss="modal">
			<?php echo $template; ?>
			</div>
			<?php } ?>
			</div>
			
			<div class="tab-pane" id="tab_1_7">
			<?php
			foreach ($result_template7 as $cat7) 
			{
			$template=$cat7["template"]["template"];
			?>                                 
			<div class="tmplt t_hov" onClick="templt('<?php echo $template; ?>')" data-dismiss="modal">
			<?php echo $template; ?>
			</div>
			<?php } ?>
			</div>
		</div>
		<!---------content---------------------->								
		</div>


	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
	</div>
</div>





<div class="control-group">
  <label class="control-label">Attachment <i class=" icon-info-sign tooltips" data-placement="right" data-original-title="Limit 2MB"> </i> </label>
  <div class="controls">
	 <div class="fileupload fileupload-new" data-provides="fileupload"><input type="hidden" value="" name="">
		<div class="input-append">
		   <div class="uneditable-input">
			  <i class="icon-file fileupload-exists"></i> 
			  <span class="fileupload-preview"></span>
		   </div>
		   <span class="btn btn-file">
		   <span class="fileupload-new">Select file</span>
		   <span class="fileupload-exists">Change</span>
		   <input type="file" name="file" id="file" class="default" >
		   </span>
		   <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
		</div>
	 </div>
  </div>
</div>
<label style="color: #696969;font-size: 12px;">
Note: File size must be less than 1 MB and only jpg,png extension are allowed.
</label>
<label id="file"></label>				   
						   

</div>

<div class="form-actions" style="margin-bottom:0px !important;">
	<button type="submit" name="send" class="btn blue"><i class=" icon-envelope-alt"></i> Send</button>
</div>
</form>
</div>





<!------------------------------------------->

<script>


$.validator.addMethod('requirecheck1', function (value, element) {
	 return $('.requirecheck1:checked').size() > 0;
}, 'Please check at least one role.');

$.validator.addMethod('requirecheck2', function (value, element) {
	 return $('.requirecheck2:checked').size() > 0;
}, 'Please check at least one wing.');

$.validator.addMethod('requirecheck3', function (value, element) {
	 return $('.requirecheck3:checked').size() > 0;
}, 'Please check at least one group.');

$.validator.addMethod('filesize', function(value, element, param) {
    // param = size (en bytes) 
    // element = element to validate (<input>)
    // value = value of the element (file name)
    return this.optional(element) || (element.files[0].size <= param) 
});





$(document).ready(function(){

			var checkboxes = $('.requirecheck1');
			var checkbox_names = $.map(checkboxes, function(e, i) {
				return $(e).attr("name")
			}).join(" ");
			
			
			var checkboxes2 = $('.requirecheck2');
			var checkbox_names2 = $.map(checkboxes2, function(e, i) {
				return $(e).attr("name")
			}).join(" ");
			
			var checkboxes3 = $('.requirecheck3');
			var checkbox_names3 = $.map(checkboxes3, function(e, i) {
				return $(e).attr("name")
			}).join(" ");

$.validator.setDefaults({ ignore: ":hidden:not(select)" });
$('#contact-form').validate({

			errorElement: "label",
                    //place all errors in a <div id="errors"> element
                    errorPlacement: function(error, element) {
                        //error.appendTo("label#errors");
						error.appendTo('label#' + element.attr('id'));
                    }, 
	    groups: {
            asdfg: checkbox_names,
			qwerty: checkbox_names2,
			qwerty2: checkbox_names3
        },
	

rules: {
  subject: {
	required: true
  },
   "multi[]": {
	required: true,
  },
   email: {
	required: true
  },
  notice_visible_to: {
   
	required: true
  },
 file: {
		accept: "png,jpg",
		filesize: 1048576
	  },
  
  

},

messages: {
			"multi[]": {
				required: "Please select at-least one recipient."
			},
			file: {
					accept: "File extension must be png or jpg",
					filesize: "File size must be less than 1MB."
				},
		},
	highlight: function(element) {
		$(element).closest('.control-group').removeClass('success').addClass('error');
	},
	success: function(element) {
		element
		.text('OK!').addClass('valid')
		.closest('.control-group').removeClass('error').addClass('success');
	},
	
});

}); 
</script>


<script>
$(document).ready(function(){
  $("#r1").click(function(){
    $("#d2").hide();
    $("#d1").show();
	$("#d3").hide();
	
  });
  $("#r2").click(function(){
    $("#d1").hide();
    $("#d2").show();
	$("#d3").hide();
  });
  $("#r3").click(function(){
    $("#d1").hide();
    $("#d3").show();
	$("#d2").hide();
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

<style>
.tmplt{
border-bottom:solid 2px #ccc; padding:15px; font-size:16px; cursor:pointer;	
}
.t_hov:hover{
background-color:rgba(207, 202, 255, 0.32);	
}
</style>

<script>
function templt(t)
{
$('iframe').contents().find('html').html("<h4>"+t+"</h4>");
}
</script>