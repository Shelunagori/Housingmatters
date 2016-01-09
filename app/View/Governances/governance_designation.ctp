<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>
<script>
$(document).ready(function() {
$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>

<div align="center">
<a href="governance_designation" rel="tab" class="btn red">Add Designation</a>
<a href="governance_assign_user" rel="tab" class="btn blue" >Assign Designation</a>
</div>




<div style="background-color:#EFEFEF; border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6; padding:10px; box-shadow:5px; font-size:16px; color:#006;">
Designation
</div>

<div></div>
<div class="tabbable tabbable-custom">
<div class="tab-content" style="min-height:300px;">
<div class="tab-pane active" id="tab_1_1">
<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<div style="background-color:#fff;padding:5px;width:96%;margin:auto; overflow:auto;" class="form_div">


<div class="row-fluid">
<div class="span5">
<form method="post" id="sucess">

<label >Designation Name <span style="font-size:12px; color:#999;"></span></label>
<div class="controls">
<input type="text" class="m-wrap span7" name="wing_name"  id="designation">
<button type="submit" class="btn form_post" style="background-color: #09F; color:#fff;" value="xyz">Add Designation</button>
<label report="win" class="remove_report"></label>

</div>
</form>
</div>
<div class="span7">



<table class="table table-striped table-bordered" id="sample_2" style="width:100%;">
<thead>
<tr>
<th>Sr No.</th>
<th>Designation-Name</th>
<th>Action</th>
</tr>
</thead>
<tbody>

<?php
$i=0;
foreach($result_governance_designation as $data)
{
	$i++;
	$governance_designation_id=$data['governance_designation']['governance_designation_id'];
	$designation_name=$data['governance_designation']['designation_name'];


?>
<tr class="odd gradeX" >
<td><?php echo $i; ?></td>
<td id="gov_des_id<?php echo $governance_designation_id; ?>" ><?php echo $designation_name; ?></td>
<td>
<a href="#" role="button" idd="<?php echo $governance_designation_id; ?>" des_n="<?php echo $designation_name; ?>" class="btn mini blue des_edit"><i class="icon-pencil"></i> Edit</a>

</td>
</tr>
<?php } ?>
</tbody>
</table>


</div>
</div>
</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////// ?>   
</div>
</div>
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>	
<div class="edit_div" style="display: none;">
<div class="modal-backdrop fade in"></div>
<div class="modal"  id="poll_edit_content">
	
</div>
</div>
  <script>
$(document).ready(function() { 
	$('form').submit( function(ev){
	ev.preventDefault();
	var m_data = new FormData();
	m_data.append( 'designation', $("#designation").val());
	
	$.ajax({
			url: "governance_designation_ajax",
			data: m_data,
			processData: false,
			contentType: false,
			type: 'POST',
			dataType:'json',
			}).done(function(response) {
			
			if(response.report_type=='error'){
					$(".remove_report").html('');
						jQuery.each(response.report, function(i, val) {
						$("label[report="+val.label+"]").html('<span style="color:red;">'+val.text+'</span>');
					});
				}
				if(response.report_type=='publish'){
				$("#sucess").show().html('<div class="alert alert-block alert-success fade in"><h4 class="alert-heading">Success!</h4><p>'+response.report+'</p><p><a class="btn green" href="<?php echo $webroot_path; ?>Governances/governance_designation" rel="tab">OK</a></p></div>');
				}
			});
	
	
	});
	
	$('.des_edit').live('click',function(){
		var x=$(this).attr('idd');
		$(".edit_div").show();
		$("#poll_edit_content").html('<div align="center" style="padding:20px;"><img src="<?php echo $this->webroot ; ?>/as/indicator_blue_small.gif" /><br/><h5>Please Wait</h5></div>').load('<?php echo $this->webroot; ?>Governances/designation_edit?d_id='+x+'&edit=0');
		
		
	});
	
	$("#close_edit").live('click',function(){
		$(".edit_div").hide();
	 });
		
	$('.save_edited_des').live('click',function(){
	var des_id=$(this).attr('des_id');
	var des_name=$("#des_name").val();
	if(!des_name)
	{
		$("#test_error").html("<span style='color:red;'>This field is required.</span>");
		return false;
	}
	$("#gov_des_id"+ des_id).html(des_name);
	var des=encodeURIComponent(des_name);
	$("#poll_edit_content").load('<?php echo $this->webroot; ?>Governances/designation_edit?d_id='+des_id+'&des='+des+'&edit=1', function() {
			
		});
	
	
	
	});	
});
</script>	

