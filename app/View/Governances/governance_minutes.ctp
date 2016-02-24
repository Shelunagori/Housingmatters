<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>
<script>
$(document).ready(function() {
$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
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
<div style="border:solid 2px #4cae4c; width:90%; margin:auto;" class='portal'>
<div style="border-bottom:solid 2px #4cae4c; color:white; background-color: #5cb85c; padding:4px; font-size:20px;" ><i class="icon-envelope-alt"></i> Minutes</div>
<div style="padding:10px;background-color:#FFF;">
<form method="post" id="contact-form" name="myform" enctype="multipart/form-data" >
<div id="output"></div>

<!-------------------------->
<div class="row-fluid">

<div class="span6 responsive">
<label style="font-size:14px; font-weight:bold;">Meeting ID</label>
<div class="controls">
 <select name="meeting_id" id="meeting_id" class="chosen span12 change_ag">
 <option></option>
 <?php
		foreach($result_governance_invite as $data)
		{
		    $gov_invite_id=$data['governance_invite']['governance_invite_id'];
			$gov_invite_me_id=(int)$data['governance_invite']['gov_invite_me_id'];
		    $subject=$data['governance_invite']['subject'];
			$date=$data['governance_invite']['date'];
			//$time=$data['governance_invite']['time'];
			//$location=$data['governance_invite']['location'];
	 
 ?>
 <option value="<?php echo $gov_invite_id ; ?>"> <?php echo $gov_invite_me_id ; ?> - <?php echo $subject ; ?> - <?php echo $date ; ?></option>
 <?php } ?>
 </select>
 <label report="subject" class="remove_report"></label>
</div>

</div>


</div>
<!-------------------------->



<label style="font-size:14px; font-weight:bold;">Select attendees present </label>

<!------------------------->


<!------------------------->
<div id="display_meeting">
<select data-placeholder="Select attendees user"  name="multi" id="multi" class="chosen span9" multiple="multiple" tabindex="6">
<option>
</option>
</select>

</div>

<!------------------------->
<br/>

<label style="font-size:14px; font-weight:bold;">Any Other business </label>
<div class="control-group">
	<div class="controls">
	 <textarea name="any_other" class="span12" rows="5" id="any_other" ></textarea>
	</div>
</div>
<a href="#myModal345" role="button" class="btn blue pull-right" data-toggle="modal" style=""> Templates</a>



<div id="myModal345" style="margin-top:-5%;" class="modal hide " tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
		<h3 id="myModalLabel3">Select Template</h3>
	</div>
	
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab_1_1" data-toggle="tab">Agenda Items </a></li>
			<li class=""><a href="#tab_1_2" data-toggle="tab">Other Notes </a></li>
			
		</ul>
		<div class="scroller" data-height="400px">
		<!---------content---------------------->
		<div class="tab-content">
			<div class="tab-pane active" id="tab_1_1">
			<?php
			foreach ($template_result_agenda as $cat1) 
			{
			$template=$cat1["template"]["template"];
			?>                                 
			<div class="tmplt t_hov" onClick="templt_agenda('<?php echo $template; ?>')" data-dismiss="modal">
			<?php echo $template; ?>
			</div>
			<?php } ?>
			</div>
			
			<div class="tab-pane" id="tab_1_2">
			<?php
			foreach ($template_result_agenda_other as $cat2) 
			{
			$template=$cat2["template"]["template"];
			?>                                 
			<div class="tmplt t_hov" onClick="templt_agenda('<?php echo $template; ?>')" data-dismiss="modal">
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
Note: File size must be less than 2 MB and All extension are allowed.
</label>
<label id="file"></label><br/>				   

<div class="controls">
 <label class="radio">
 <div class="radio" id="uniform-undefined"><input type="radio"  id="r1" checked name="radio" value="1" style="opacity: 0;"></div>
 <span style="font-size:16px;" >Send <span style="color:red;">Draft </span> Minutes to Individuals</span>
 </label>
 <label class="radio">
 <div class="radio" id="uniform-undefined"><input type="radio"  id="r3"  name="radio" value="3" style="opacity: 0;"></div>
 <span style="font-size:16px;" >Send <span style="color:red;">Draft </span> Minutes to Default Groups</span>
 </label>
 <label class="radio">
 <div class="radio" id="uniform-undefined"><input type="radio" id="r2" name="radio" value="2"  style="opacity: 0;"></div>
 <span style="font-size:16px;" >Send <span style="color:red;">Draft </span> Minutes to Customized Group</span>
 </label>  

 
</div>
<label style="font-size:14px; font-weight:bold;">To <i class=" icon-info-sign tooltips" data-placement="right" data-original-title="email will be sent to only those users whose valid emails are registered with HousingMatters"> </i></label>

<!------------------------->
<div class="control-group" id="d1" >
  <div class="controls">
   
<select data-placeholder="Type or select name"  name="multi12" id="multi12" class="chosen span9" multiple="multiple" tabindex="6">
<?php
foreach ($result_users_new as $collection) 
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
	 
  </div>
  <label report="multi12" class="remove_report"></label>
</div>

<!------------------------->


<!-------------------------->

<div style="display:none;" id="d2" >

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
<label report="multi_check" class="remove_report"></label>



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
			<label report="role_check" class="remove_report"></label>

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
			<p><label report="wing_check" class="remove_report"></label></p>
			</div>
			<!---------------end visible-------------------------------->
</div>
<!--------------------------->
<!-------------------------->

<br/>
<br/>

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
	var agenda="Agenda";
	$("#hid_v").val(count);
	$("#url_main").append('<div class="content_'+count+'"><input type="text" class="m-wrap span4"  id="nu" name="comm_'+count+'" placeholder='+agenda+' style="height: 50px!important;"> <textarea class="span4" name="comment_'+count+'" placeholder="description" ></textarea> <a href="#" role="button" id='+count+' class="btn black mini delete_btn"><i class="icon-remove-sign"></i></a></div>');


});
$(".delete_btn").live("click",function(){
var id = $(this).attr("id");
$('.content_'+id).remove();
});
});
</script>

<script>
$(document).ready(function(){
$(".change_ag").change(function(){
	
var r=$(this).val();

//var meeting_id=$('select[name=meeting_id]').val();
$("#display_meeting").load("governance_minute_ajax?con="+r);
});	
	
});


</script>


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
	var present_user=$('select[name=multi]').val();
	var meeting_id=$('select[name=meeting_id]').val();
	m_data.append( 'present_user',present_user );
	m_data.append( 'meeting_id',meeting_id );
	m_data.append( 'file', $('input[name=file]')[0].files[0]);
	var any_other=encodeURIComponent($('textarea[name=any_other]').val());
	m_data.append('any_other',any_other);	
	var count1 = $("table#count_table tbody tr").length;
	var minute = [];
	for(var j=1;j<=count1;j++)
	{
		var min=encodeURIComponent($('textarea[name=min_'+j+']').val());
		minute.push([min]);
	}
	
	m_data.append('minute_agenda',minute);
	
	var Invitations =$('input:radio[name=radio]:checked').val();
	m_data.append( 'Invitations_type',Invitations );
	if(Invitations==1)
	{
		
		var invite=$('select[name=multi12]').val();
		m_data.append( 'Invite_user1',invite );
		
	}
	
	if(Invitations==2)
	{
		//var other=$('input[name=other_user]').val();
		var group_n = [];
		$('.group_name:checked').each(function() {
		group_n.push($(this).val());
		});
		
		//m_data.append( 'Invite_user2',other );
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
			
		}
		if(visible==1 || visible==4 || visible==5){
			m_data.append( 'sub_visible', 0);
		}
		
		
	}
	
	$.ajax({
			url: "governance_minute_submit",
			data: m_data,
			processData: false,
			contentType: false,
			type: 'POST',
			dataType:'json',
			}).done(function(response) { 
			
			$("#output").html(response);
				if(response.type=='created'){
					$(".portal").remove();
				$(".alert-success").show().append("<p>"+response.text+"</p><p><a class='btn green' href='<?php echo $webroot_path; ?>Governances/minute_view' rel='tab' >ok</a></p>");
				$("#output").remove();
				}
				if(response.type=='error'){
				$("#output").html('<div class="alert alert-error">'+response.text+'</div>');
				
				}
				if(response.report_type=='error'){
				
					$(".remove_report").html('');
						jQuery.each(response.report, function(i, val) {
						$("label[report="+val.label+"]").html('<span style="color:red;">'+val.text+'</span>');
					});
				}
				$("html, body").animate({
				scrollTop:0
				},"slow");
				
				});
	
	
});


});
</script> 
<script>

function templt_agenda(t){
$("#any_other").val(t);	
	
}
</script>
