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
<div style="border-bottom:solid 2px #4cae4c; color:white; background-color: #5cb85c; padding:4px; font-size:20px;" ><i class="icon-envelope-alt"></i> Minutes</div>
<div style="padding:10px;background-color:#FFF;">
<form method="post" id="contact-form" name="myform" enctype="multipart/form-data" >
<div id="output"></div>

<!-------------------------->
<div class="row-fluid">

<div class="span6 responsive">
<label style="font-size:14px; font-weight:bold;">Meeting ID</label>
<div class="controls">
 <select name="meeting_id" id="meeting_id" class="chosen span12">
 <option></option>
 <?php
		foreach($result_governance_invite as $data)
		{
		   $gov_invite_id=$data['governance_invite']['governance_invite_id'];
		    $subject=$data['governance_invite']['subject'];
			$date=$data['governance_invite']['date'];
			$time=$data['governance_invite']['time'];
			$location=$data['governance_invite']['location'];
	 
 ?>
 <option value="<?php echo $gov_invite_id ; ?>"<?php if($gov_invite_id2==$gov_invite_id){?> selected="selected" <?php } ?>> <?php echo $gov_invite_id ; ?> , <?php echo $subject ; ?></option>
 <?php } ?>
 </select>
 <label report="subject" class="remove_report"></label>
</div>

</div>

<div class="span6 responsive">
<label style="font-size:14px; font-weight:bold;"><span>Date </span> <span style="margin-left:50px;"> Time </span> <span style="margin-left:50px;"> Location </span></label> 
<span> <?php echo @$date ; ?> </span> <span style="margin-left:15px;"> <?php echo @$time ; ?> </span> <span style="margin-left:30px;"> <?php echo @$location ; ?> </span>
</div>
</div>
<!-------------------------->



<label style="font-size:14px; font-weight:bold;">Select attendees present </label>

<!------------------------->
<div class="control-group" id="d1" >
  <div class="controls">
   
<select data-placeholder="Select attendees user"  name="multi" id="multi" class="chosen span9" multiple="multiple" tabindex="6">
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
<option value="<?php echo $user_id; ?>"><?php echo $user_name; ?>&nbsp;&nbsp;<?php echo $flat; ?></option>
<?php } ?>           
		  
	 </select>
	 
  </div>
  <label report="multi" class="remove_report"></label>
</div>

<!------------------------->

<!-------------------------->


<!--------------------------->

<!-------------------------->


<!--------------------------->



<div class="row-fluid">
<table border="0" width="100%" id="count_table">
<thead>
<tr>
<td width="70%"><b> Agenda </b></td><td> <b> Minutes </b></td></tr>

</thead>
<tbody>
 <?php
 $z=0;
		foreach($result_governance_invite as $data){
		   $gov_invite_id=$data['governance_invite']['governance_invite_id'];
		   $message=$data['governance_invite']['message'];

		  foreach($message as $data){
			  $z++;
			  
			  $data[1];
			  ?>
			  <tr>
			  <td>
			  <?php echo $z; ?> <?php echo urldecode($data[0]); ?><br/> <?php echo urldecode($data[1]); ?>
			  </td>
			  <td>
			  <textarea name="min_<?php echo $z; ?>"></textarea>
			  </td>
			  </tr>
			 <?php 
		  }
		}		   
 ?>
 </tbody>
 </table>
 
		  
 


</div>





<!--<label style="font-size:14px; font-weight:bold;">Minutes</label>
<div id="url_main">
<div >
<input type="text" class="m-wrap span4"  id="nu" name='comm_1' placeholder='Agenda' style="height: 50px!important;">
<textarea class="span4" name="comment_1" placeholder="description" ></textarea>
<a href="#" role="button" id="add_row" class="btn  mini"><i class="icon-plus-sign"></i></a>
</div>
</div>-->


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
var meeting_id=$('select[name=meeting_id]').val();
$("#show_id").load("governance_minute_ajax?con="+r+"&con1="+meeting_id);
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
	var count1 = $("table#count_table tbody tr").length;
	var minute = [];
	for(var j=1;j<=count1;j++)
	{
		var min=encodeURIComponent($('textarea[name=min_'+j+']').val());
		minute.push([min]);
	}
	m_data.append('minute_agenda',minute);
	//var count = $("#url_main div").length;
	
	//var comm = []; var comments = []; 
	//for(var i=1;i<=count;i++)
	//{
	//	var c=encodeURIComponent($('input[name=comm_'+i+']').val());
	//	var d=encodeURIComponent($('textarea[name=comment_'+i+']').val());
	//	comm.push([c]);
	//	comments.push([d]);
	//}
	//m_data.append('meeting_agenda_input',comm );
//	m_data.append('meeting_agenda_textarea',comments);
	$.ajax({
			url: "governance_minute_submit",
			data: m_data,
			processData: false,
			contentType: false,
			type: 'POST',
			dataType:'json',
			}).done(function(response) { 
			
			//$("#output").html(response);
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
