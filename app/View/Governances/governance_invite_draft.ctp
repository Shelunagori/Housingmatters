
<style>
a.tip {
    //border-bottom: 1px dashed;
    text-decoration: none;
	
}
a.tip:hover {
    //cursor: help;
    position: relative
	
}
a.tip span {
    display: none;
	
}
a.tip:hover span {
	border: #c0c0c0 1px dotted;
    padding: 5px 20px 5px 5px;
    display: block;
    z-index: 100;
	color:blue;
    background: url(../images/status-info.png) #f0f0f0 no-repeat 100% 5%;
    left: 0px;
    margin: 12px;
    width:50px;
    position: absolute;
    top: 10px;
    text-decoration: none
}

</style>

<?php 

foreach($result_gov_invite as $data){
	$governance_invite_id= (int)$data['governance_invite']['governance_invite_id'];
	$message= $data['governance_invite']['message'];
	$date= $data['governance_invite']['date'];
	$time= $data['governance_invite']['time'];
	$subject= $data['governance_invite']['subject'];
	$location= $data['governance_invite']['location'];
	$meeting_type= $data['governance_invite']['meeting_type'];
	$covering_note= $data['governance_invite']['covering_note'];
	$any_other_note= $data['governance_invite']['any_other_note'];
	$file= $data['governance_invite']['file'];

}

?>

<div style="border:solid 2px #4cae4c; width:90%; margin:auto;" class='portal'>
<div style="border-bottom:solid 2px #4cae4c; color:white; background-color: #5cb85c; padding:4px; font-size:20px;" ><i class="icon-envelope-alt"></i> Meeting Invitations Draft</div>
<div style="padding:10px;background-color:#FFF;">
<form method="post" id="contact-form" name="myform" enctype="multipart/form-data" >
<div id="output"></div>

<div class="row-fluid">

<div class="span6 responsive">

<div class="control-group">
		<label style="font-size:14px; font-weight:bold;">Type of Meeting</label>
		<div class="controls">
		<label class="radio">
		<div class="radio" id="uniform-undefined"><span class="checked"><input type="radio" name="type_mettings" value="1" style="opacity: 0;" <?php if($meeting_type==1){?> checked <?php } ?> ></span></div>
		Managing Committee
		</label>
		<label class="radio">
		<div class="radio" id="uniform-undefined"><span ><input type="radio" name="type_mettings" value="2"  style="opacity: 0;" <?php if($meeting_type==2){?> checked <?php } ?>></span></div>
		General Body
		</label>  
		<label class="radio">
		<div class="radio" id="uniform-undefined"><span ><input type="radio" name="type_mettings" value="3"  style="opacity: 0;" <?php if($meeting_type==3){?> checked <?php } ?> ></span></div>
		Special General Body
		</label>  
		 
		</div>
</div>
</div>
<div class="span6 responsive">
 <label style="font-size:14px; font-weight:bold;">Meeting Title</label>
<div class="controls">
 <input type="text" name="subject" id="subject" class="span12 m-wrap" value="<?php echo $subject; ?>">
 <label report="subject" class="remove_report"></label>
</div>
</div>

</div>

<!-------------------------->





<div class="row-fluid">

<div class="span6 responsive">


<label style="font-size:14px; font-weight:bold;">Meeting Date</label>
<div class="control-group" id="single_date">
  <div class="controls">
	<input type="text" name="date" data-date-format="dd-mm-yyyy" class="span6 m-wrap date-picker" placeholder="Date" value="<?php echo $date; ?>">
  </div>
  <label report="date" class="remove_report"></label>
</div>

</div>
<div class="span6 responsive">

<div class="control-group">
  <label class="control-label" style="font-size:14px; font-weight:bold;">Meeting Time</label>
  <div class="controls">
	 <div class="input-append bootstrap-timepicker-component">
		<input class="m-wrap m-ctrl-small timepicker-default" type="text" name="time" value="<?php echo $time; ?>">
		<span class="add-on"><i class="icon-time"></i></span>
		<label report="time" class="remove_report"></label>
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
	 <textarea name="location" rows="3" id="alloptions" class="span6 m-wrap" placeholder="Location" ><?php echo $location;?></textarea>
	 <label report="location" class="remove_report"></label>
  </div>
</div>


</div>
<div class="span6 responsive">


<div class="control-group" >
  <label class="control-label" style="font-size:14px; font-weight:bold;">Meeting Covering Note:</label>
  <div class="controls">
	 <textarea name="covering_note" rows="3" id="alloptions" class="span12 m-wrap" placeholder="Description"><?php echo $covering_note; ?></textarea>
	 <label report="" class="remove_report"></label>
  </div>
</div>


</div>
</div>




<label style="font-size:14px; font-weight:bold;">Content for Meeting agenda</label>
<div id="url_main">
<?php $z=0; foreach($message as $data2){ $z++;   ?>
<div>
<input type="text" class="m-wrap span2"  id="num" name='time_<?php echo $z; ?>' placeholder="Time" style="height: 50px!important;" value="<?php echo urldecode($data2[2]);?>">
<input type="text" class="m-wrap span5"  id="nu" name='comm_<?php echo $z; ?>' placeholder='Agenda1'style="height: 50px!important;" value="<?php echo urldecode($data2[0]);?>">
<textarea class=" m-wrap span5" name="comment_<?php echo $z; ?>" placeholder="description" style="resize:none;" ><?php echo urldecode($data2[1]);?></textarea>
<?php if($z==1){?>
<a href="#" role="button" id="add_row" class="btn mini tip" > <span> add-items</span> <i class="icon-plus-sign"></i></a> <?php } ?>
</div>

<?php } ?>
</div>

<div class="control-group" >
  <label class="control-label" style="font-size:14px; font-weight:bold;">Meeting Any Other Note:</label>
  <div class="controls">
	 <textarea name="any_other" rows="3" id="alloptions" class="span12 m-wrap" placeholder="Description"><?php echo $any_other_note; ?></textarea>
	 <label report="" class="remove_report"></label>
  </div>
</div>


<div class="control-group">
  <label class="control-label">Attachment <i class=" icon-info-sign tooltips" data-placement="right" data-original-title="Limit 2MB"> </i> </label>
  <div class="controls">
	 <div class="<?php if(!empty($file)){ ?>fileupload fileupload-exists <?php } else{ ?> fileupload fileupload-new   <?php } ?>" data-provides="fileupload">
		<div class="input-append">
		   <div class="uneditable-input">
			  <i class="icon-file fileupload-exists"></i> 
			  <span class="fileupload-preview"><?php echo $file; ?></span>
		   </div>
		   <span class="btn btn-file">
		   <span class="fileupload-new">Select file</span>
		   <span class="fileupload-exists">Change</span>
		   <input type="file" name="file" id="file" class="default">
		   </span>
		   <a href="#" class="btn fileupload-exists new_add_data" data-dismiss="fileupload">Remove</a>
		</div>
	 </div>
  </div>
</div>
<label style="color: #696969;font-size: 12px;">
Note: File size must be less than 2 MB and All extension are allowed.
</label>
<label id="file"></label>				   

<input type="hidden" id="edit_att" value="">

	<button type="submit" name="send" class="btn blue test" value="<?php echo $governance_invite_id; ?>"><i class=" icon-envelope-alt "></i> Approved</button>
	
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
	$("#url_main").append('<div class="content_'+count+'"><input type="text" class="m-wrap span2" placeholder="Time" id="nu" name="time_'+count+'" style="height: 50px!important;"> <input type="text" class="m-wrap span5"  id="nu" name="comm_'+count+'" placeholder='+agenda+count+' style="height: 50px!important;"> <textarea class="m-wrap span5" style="resize:none;" name="comment_'+count+'" placeholder="description" ></textarea> <a href="#" role="button" id='+count+' class="btn black mini delete_btn tip"><span> Delete</span><i class="icon-remove-sign"></i></a></div>');


});
$(".delete_btn").live("click",function(){
var id = $(this).attr("id");
$('.content_'+id).remove();
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
	$(".test").live('click', function(e){
	$(this).addClass("e-clicked");
	});
	
	
	$(".new_add_data").live('click',function(){
	$('#file').attr('name','file');
	$('.input-append').parents('div').find('input[type=hidden]').attr('name','');
	$("#edit_att").val(1);
 });
	
$('form#contact-form').submit( function(ev){
	ev.preventDefault();	
	var m_data = new FormData(); 
	var sub=$(this).find(".e-clicked").attr("value");
	$(".e-clicked").removeClass("e-clicked");
	m_data.append('id',sub);
	/*var Invitations =$('input:radio[name=radio]:checked').val();
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
			
		}
		if(visible==1 || visible==4 || visible==5){
			m_data.append( 'sub_visible', 0);
		}
		
		
	}
	*/
			
	
	var type_mettings =$('input:radio[name=type_mettings]:checked').val();
	m_data.append( 'type_mettings',type_mettings );
	var count = $("#url_main div").length;
	
	var comm = []; var comments = []; var time_ag = []; 
	for(var i=1;i<=count;i++)
	{
		var e=encodeURIComponent($('input[name=time_'+i+']').val());
		var c=encodeURIComponent($('input[name=comm_'+i+']').val());
		var d=encodeURIComponent($('textarea[name=comment_'+i+']').val());
		time_ag.push([e]);
		comm.push([c]);
		comments.push([d]);
	}
	
	m_data.append('meeting_agenda_time',time_ag);
	m_data.append('meeting_agenda_input',comm );
	m_data.append('meeting_agenda_textarea',comments);
	var subject=$('input[name=subject]').val();
	var date=$('input[name=date]').val();
	var time=$('input[name=time]').val();
	var location=$('textarea[name=location]').val();
	var covering_note=$('textarea[name=covering_note]').val();
	var any_other=$('textarea[name=any_other]').val();
	m_data.append( 'subject',subject );
	m_data.append( 'date',date );
	m_data.append( 'time',time );
	m_data.append( 'location',location );
	m_data.append( 'covering_note',covering_note );
	m_data.append( 'any_other',any_other );
	m_data.append( 'file', $('input[name=file]')[0].files[0]);
	m_data.append( 'edit_attachment', $('#edit_att').val());
	
	$.ajax({
			url: "<?php echo $webroot_path ; ?>Governances/governance_invite_submit_draft",
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