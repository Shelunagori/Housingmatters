<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>
<script>
$(document).ready(function() {
$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>

<div style="border:solid 2px #4cae4c; width:90%; margin:auto;" class='portal'>
<div style="border-bottom:solid 2px #4cae4c; color:white; background-color: #5cb85c; padding:4px; font-size:20px;" ><i class="icon-envelope-alt"></i> Meeting Invitations</div>
<div style="padding:10px;background-color:#FFF;">
<form method="post" id="contact-form" name="myform" enctype="multipart/form-data" >
<div id="output"></div>
<div class="controls">
 <label class="radio">
 <div class="radio" id="uniform-undefined"><input type="radio"  id="r1" checked name="radio" value="1" style="opacity: 0;"></div>
 <span style="font-size:16px;" >Send Invitations to Individual</span>
 </label>
 <label class="radio">
 <div class="radio" id="uniform-undefined"><input type="radio"  id="r3"  name="radio" value="3" style="opacity: 0;"></div>
 <span style="font-size:16px;" >Send Invitations to Default Groups</span>
 </label>
 <label class="radio">
 <div class="radio" id="uniform-undefined"><input type="radio" id="r2" name="radio" value="2"  style="opacity: 0;"></div>
 <span style="font-size:16px;" >Send Invitations to any others</span>
 </label>  
 
 
</div>
<label style="font-size:14px; font-weight:bold;">To <i class=" icon-info-sign tooltips" data-placement="right" data-original-title="email will be sent to only those users whose valid emails are registered with HousingMatters"> </i></label>

<!------------------------->
<div class="control-group" id="d1" >
  <div class="controls">
   
<select data-placeholder="Type or select name"  name="multi" id="multi" class="chosen span9" multiple="multiple" tabindex="6">
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
<option value="<?php echo $user_id; ?>"><?php echo $user_name; ?>&nbsp;&nbsp;<?php echo $flat; ?>,<?php echo $email; ?></option>
<?php } ?>           
		  
	 </select>
	 <label id="multi"></label>
  </div>
</div>
<!------------------------->

<!-------------------------->

<div style="display:none;" id="d2" >


<!--<div class="controls">
 <input type="text" name="other_user" id="other_user" class="span5 m-wrap">
 <label id="other_user"></label>
</div>-->



<?php
foreach ($result_group as $collection) 
{
$group_name=$collection["group"]["group_name"];
$group_id=$collection["group"]["group_id"];
?>
<label class="checkbox">
<input type="checkbox" class="requirecheck3 ignore group_name" id="requirecheck1234" name="grp<?php echo $group_id; ?>" value="<?php echo $group_id; ?>"> <?php echo $group_name; ?>
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
			<div class="checker"><span><input type="checkbox"  value="<?php echo $role_id; ?>" name="role<?php echo $role_id; ?>" class="v2 requirecheck1 ignore" id="requirecheck1"></span></div> <?php echo $role_name; ?>
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
			<div class="checker"><span><input type="checkbox"  value="<?php echo $wing_id; ?>" name="wing<?php echo $wing_id; ?>" class="v3 requirecheck2 ignore" id="requirecheck2" ></span></div> <?php echo $wing_name; ?>
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




<div class="control-group">
		<label style="font-size:14px; font-weight:bold;">Type of Meetings</label>
		<div class="controls">
		<label class="radio">
		<div class="radio" id="uniform-undefined"><span class="checked"><input type="radio" name="type_mettings" value="1" style="opacity: 0;" checked=""></span></div>
		Managing Committee
		</label>
		<label class="radio">
		<div class="radio" id="uniform-undefined"><span ><input type="radio" name="type_mettings" value="2"  style="opacity: 0;"></span></div>
		General Body
		</label>  
		<label class="radio">
		<div class="radio" id="uniform-undefined"><span ><input type="radio" name="type_mettings" value="3"  style="opacity: 0;"></span></div>
		Special General Body
		</label>  
		 
		</div>
</div>

<label style="font-size:14px; font-weight:bold;">Meeting Title</label>
<div class="controls">
 <input type="text" name="subject" id="subject" class="span5 m-wrap">
 <label id="subject"></label>
</div>
<!-------------------------->





<div class="row-fluid">

<div class="span6 responsive">


<label style="font-size:14px; font-weight:bold;">Meeting Date</label>
<div class="control-group" id="single_date">
  <div class="controls">
	<input type="text" name="date" data-date-format="dd-mm-yyyy" class="span6 m-wrap date-picker" placeholder="Date">
  </div>
</div>

</div>
<div class="span6 responsive">

<div class="control-group">
  <label class="control-label" style="font-size:14px; font-weight:bold;">Meeting Time</label>
  <div class="controls">
	 <div class="input-append bootstrap-timepicker-component">
		<input class="m-wrap m-ctrl-small timepicker-default" type="text" name="time">
		<span class="add-on"><i class="icon-time"></i></span>
		<label report="e_time" class="remove_report"></label>
	 </div>
  </div>
</div>


</div>
</div>

<div class="row-fluid">
<div class="span6 responsive">


<div class="control-group" >
  <label class="control-label" style="font-size:14px; font-weight:bold;">Meeting Location</label>
  <div class="controls">
	 <textarea name="location" rows="3" id="alloptions" class="span6 m-wrap" placeholder="Location"></textarea>
	 <label report="location" class="remove_report"></label>
  </div>
</div>


</div>
<div class="span6 responsive">


<div class="control-group" >
  <label class="control-label" style="font-size:14px; font-weight:bold;">Meeting Covering Note:</label>
  <div class="controls">
	 <textarea name="covering_note" rows="3" id="alloptions" class="span12 m-wrap" placeholder="Description"></textarea>
	 <label report="location" class="remove_report"></label>
  </div>
</div>


</div>
</div>




<label style="font-size:14px; font-weight:bold;">Content for Meeting agenda</label>
<div id="url_main">
<div >
<input type="text" class="m-wrap span4"  id="nu" name='comm_1' placeholder='1.'>
<textarea class="span4" name="comment_1" placeholder="description" ></textarea>
<a href="#" role="button" id="add_row" class="btn  mini"><i class="icon-plus-sign"></i> Add row</a>
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
Note: File size must be less than 2 MB and only jpg,png extension are allowed.
</label>
<label id="file"></label>				   



	<button type="submit" name="send" class="btn blue"><i class=" icon-envelope-alt "></i> Send</button>
</form>

</div>
</div>

<div class="alert alert-block alert-success fade in" style="display:none;">
	<h4 class="alert-heading">Success!</h4>
</div>

<script>
$(document).ready(function(){
$("#add_row").bind('click',function(){
	var count = $("#url_main div").length;
	count++;
	$("#hid_v").val(count);
	$("#url_main").append('<div class="content_'+count+'"><input type="text" class="m-wrap span4"  id="nu" name="comm_'+count+'" placeholder='+count+'> <textarea class="span4" name="comment_'+count+'" placeholder="description" ></textarea> <a href="#" role="button" id='+count+' class="btn black mini delete_btn"><i class="icon-remove-sign"></i></a></div>');


});
$(".delete_btn").live("click",function(){
var id = $(this).attr("id");
$('.content_'+id).remove();
});
});
</script>




<!--<script>


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

$('#contact-form').validate({
ignore: ".ignore",
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
		filesize: 2097152
	  },
  
  

},

messages: {
			"multi[]": {
				required: "Please select at-least one recipient."
			},
			file: {
					accept: "File extension must be png or jpg",
					filesize: "File size must be less than 2MB."
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
</script>-->



<script>
$(document).ready(function(){
 	
  $("#r1").click(function(){
    $("#d2").hide();
    $("#d1").show();
	$("#d3").hide();
	 $("#d4").hide();
	 $("#d5").hide();
	$(".chosen").removeClass("ignore");
	$(".requirecheck2").addClass("ignore");
	$(".requirecheck1").addClass("ignore");
	$(".requirecheck3").addClass("ignore");
  });
  $("#r2").click(function(){
    $("#d1").hide();
    $("#d2").show();
	$("#d3").hide();
	 $("#d4").hide();
	 $("#d5").hide();$("#d6").hide();
	$(".chosen").addClass("ignore");
	$(".requirecheck2").addClass("ignore");
	$(".requirecheck1").addClass("ignore");
	$(".requirecheck3").removeClass("ignore");
  });
  $("#r3").click(function(){
    $("#d1").hide();
    $("#d3").show();
	$("#d2").hide();
	 $("#d4").hide();
	 $("#d5").hide();
	 $("#d6").hide();
	$(".chosen").addClass("ignore");
	$(".requirecheck2").addClass("ignore");
	$(".requirecheck1").addClass("ignore");
	$(".requirecheck3").addClass("ignore");
  });
  $("#r4").click(function(){
	  
	 value = +$('#r4').is( ':checked' );
	 alert(value);
	$("#d1").hide();
	$("#d3").hide();
	$("#d4").show();
	$("#d2").hide();
	$("#d5").hide();
	$("#d6").show();
	$(".chosen").removeClass("ignore");
	$(".requirecheck2").addClass("ignore");
	$(".requirecheck1").addClass("ignore");
	$(".requirecheck3").addClass("ignore");
  });
  
   $("#r5").click(function(){
	   
	  var r=$(this).val();
	$("#d1").hide();
	$("#d3").hide();
	$("#d4").hide();
	$("#d2").hide();
	$("#d5").show();
	$("#d6").show();
	$(".chosen").removeClass("ignore");
	$(".requirecheck2").addClass("ignore");
	$(".requirecheck1").addClass("ignore");
	$(".requirecheck3").addClass("ignore");
  });
   
  
});
</script>

<script>
$(document).ready(function() { 
	 $("#v3").live('click',function(){
		$("#show_3").slideDown('fast');
		$("#show_2").slideUp('fast');
		$("#show_1").slideUp('fast');
		$(".requirecheck2").removeClass("ignore");
		$(".requirecheck1").addClass("ignore");
	 });
	 
	 $("#v2").live('click',function(){
		$("#show_2").slideDown('fast');
		$("#show_3").slideUp('fast');
		$("#show_1").slideUp('fast');
		$(".requirecheck1").removeClass("ignore");
		$(".requirecheck2").addClass("ignore");
	 });
	 
	 $("#v1").live('click',function(){
		$("#show_1").slideDown('fast');
		$("#show_2").slideUp('fast');
		$("#show_3").slideUp('fast');
	 });
	
	 
	
	});
</script>
<script>
$(document).ready(function(){
$('form#contact-form').submit( function(ev){
	ev.preventDefault();	
var m_data = new FormData(); 
var Invitations =$('input:radio[name=radio]:checked').val();
	m_data.append( 'Invitations_type',Invitations );
	if(Invitations==1)
	{
		
		var invite=$('select[name=multi]').val();
		m_data.append( 'Invite_user1',invite );
		
	}
	if(Invitations==2)
	{
		var other=$('input[name=other_user]').val();
		var group_n = [];
		$('.group_name:checked').each(function() {
		group_n.push($(this).val());
		});
		
		
		
		
		m_data.append( 'Invite_user2',other );
		m_data.append( 'Invite_group',group_n );
	}
	if(Invitations==3)
	{
		var visible=$('input:radio[name=visible]:checked').val();
		m_data.append( 'visible',visible );
	
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
			alert(allVals);
		}
		if(visible==1 || visible==4 || visible==5){
			m_data.append( 'sub_visible', 0);
		}
		
		
	}
	
			
	
	var type_mettings =$('input:radio[name=type_mettings]:checked').val();
	m_data.append( 'type_mettings',type_mettings );
	var count = $("#url_main div").length;
	var comm = []; var comments = []; 
	for(var i=1;i<=count;i++)
	{
		var c=encodeURIComponent($('input[name=comm_'+i+']').val());
		var d=encodeURIComponent($('textarea[name=comment_'+i+']').val());
		comm.push([c]);
		comments.push([d]);
	}
	
	m_data.append('meeting_agenda_input',comm );
	m_data.append('meeting_agenda_textarea',comments);
	var subject=$('input[name=subject]').val();
	var date=$('input[name=date]').val();
	var time=$('input[name=time]').val();
	var location=$('textarea[name=location]').val();
	var covering_note=$('textarea[name=covering_note]').val();
	m_data.append( 'subject',subject );
	m_data.append( 'date',date );
	m_data.append( 'time',time );
	m_data.append( 'location',location );
	m_data.append( 'covering_note',covering_note );
	m_data.append( 'file', $('input[name=file]')[0].files[0]);
	$.ajax({
			url: "governance_invite_submit",
			data: m_data,
			processData: false,
			contentType: false,
			type: 'POST',
			dataType:'json',
			}).done(function(response) { 
			//$("#output").html(response);
				if(response.type=='created'){
					$(".portal").remove();
				$(".alert-success").show().append("<p>"+response.text+"</p><p><a class='btn green' href='<?php echo $webroot_path; ?>Governances/governance_invite_view' rel='tab' >ok</a></p>");
				$("#output").remove();
				}
				if(response.type=='error'){
				$("#output").html('<div class="alert alert-error">'+response.text+'</div>');
				}
				$("html, body").animate({
				scrollTop:0
				},"slow");
				
				});
	
	
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