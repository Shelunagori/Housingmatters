<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>				   
<script>
$(document).ready(function() {
$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>

<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>     
<table  align="center" border="1" bordercolor="#FFFFFF" cellpadding="0">
<tr>
<td><a href="<?php echo $webroot_path; ?>Incometrackers/select_income_heads" class="btn" rel='tab'>Selection of Income Heads</a>
</td>
<td>
<a href="<?php echo $webroot_path; ?>Incometrackers/master_rate_card" class="btn" style="font-size:16px;"  rel='tab'>Rate Card</a>
</td>
<td>
<a href="<?php echo $webroot_path; ?>Incometrackers/master_noc" class="btn" style="font-size:16px;"  rel='tab'>Non Occupancy Charges</a>
</td>
<td>
<a href="<?php echo $webroot_path; ?>Incometrackers/it_penalty" class="btn" style="font-size:16px;"  rel='tab'>Penalty Option</a>
</td>
<td>
<a href="<?php echo $webroot_path; ?>Incometrackers/neft_add" class="btn" style="font-size:16px;" rel='tab'>Add NEFT</a>
</td>
<td>
<a href="<?php echo $webroot_path; ?>Incometrackers/it_setup" class="btn yellow" style="font-size:16px;" rel='tab'>Remarks</a>
</td>
<td><a href="<?php echo $webroot_path; ?>Incometrackers/other_charges" class="btn" rel='tab'>Other Charges</a>
</td>
</tr>
</table> 
<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<div style="background-color:#fff;padding:5px;width:96%;margin:auto; overflow:auto;" class="form_div">
<h4 style="color: #09F;font-weight: 500;border-bottom: solid 1px #DAD9D9;padding-bottom: 10px;"><i class="icon-money"></i>Add New Remarks</h4>

<div class="row-fluid">
<div class="span5">
<form  method="post" id="contact-form">
<label style="font-size:14px;" >Remarks<span style="color:red;">*</span></label>
<div class="controls">
<textarea class="span9 m-wrap" name="terms" style="resize:none;" rows="4" id="tem" placeholder="Please Type Remarks"></textarea>
<label id="tem"></label>
</div>
<br />
<input type="submit" class="btn green" value="Submit" name="sub">
</form>
</div>
<div class="span7">




<table class="table table-bordered table-hover">
<tr>
<th>#</th>
<th>Terms & Conditions</th>
<th>Edit</th>
<th>Delete</th>
</tr>
<?php
foreach ($cursor2 as $collection) 
{
$terms_con = @$collection['society']['terms_conditions'];
}
$w=0;
for($i=0; $i<sizeof($terms_con); $i++)
{
$w++;
$terms_name = $terms_con[$i];
?>
<tr id="tem<?php echo $w; ?>">
<td style="text-align:right;"><?php echo $w; ?></td>
<td style="text-align:left;" id="tt<?php echo $w; ?>"><?php echo $terms_name; ?></td>
<td style="text-align:right;">
<a href="#" role='button' edit_id="<?php echo $w; ?>" class="btn mini blue edit_tems"><i class="icon-pencil"></i> Edit</a>
</td>
<td style="text-align:right;">
<a href="#" role='button' edit_id="<?php echo $w; ?>"  class="btn mini red delete_tems"><i class="icon-trash"></i> Delete</a></td>
</tr>
<?php } ?>
</table>


</div>
</div>
</div>

<?php ///////////////////////////////////////////////////////////////////////////////////////////////// ?>
<script>
$(document).ready(function() {
 $(".delete_tems").live('click',function(){

		$(".edit_div").show();
		var t_id=$(this).attr("edit_id");
		
		$("#tems_edit_content").html('<div align="center" style="padding:20px;"><img src="<?php echo $this->webroot ; ?>/as/indicator_blue_small.gif" /><br/><h5>Please Wait</h5></div>').load('<?php echo $this->webroot; ?>Incometrackers/delete_terms?t_id='+t_id+'&delete=0');
	 });
	 

$("#close_edit").live('click',function(){
$(".edit_div").hide();
});	 
	 
$(".delete_tems_btn").live('click',function(){
		var t_id=$(this).attr("tems_id");
		$("#tems_edit_content").load('<?php echo $this->webroot; ?>Incometrackers/delete_terms?t_id='+t_id+'&delete=1', function() {
			$("#tem"+t_id).remove();
		});	 
	 
	 });	
	 
	 
	 
$(".edit_tems").live('click',function(){
    
	 $(".edit_div").show();
     var t_id=$(this).attr("edit_id");

  $("#tems_edit_content").html('<div align="center" style="padding:20px;"><img src="<?php echo $this->webroot ; ?>/as/indicator_blue_small.gif" /><br/><h5>Please Wait</h5></div>').load('<?php echo $this->webroot; ?>Incometrackers/edit_terms?t_id='+t_id+'&edit=0');
});	 
	 



 $(".save_edited_terms").live('click',function(){
	
		var t_id=$(this).attr("tems_id");
		 
		var tems_name=$("#description").val();
		var temnam=encodeURIComponent(tems_name);
		
		//var des=encodeURIComponent(des1);
		//var close_date1=$("#close_date").val();
		//var close_date=encodeURIComponent(close_date1);
		
		$("#tt"+t_id).html(tems_name);
		//$("#close_date"+p_id).html(close_date1);
			
		$("#tems_edit_content").load('<?php echo $this->webroot; ?>Incometrackers/edit_terms?t_id='+t_id+'&tem='+temnam+'&edit=1', function() {
			
		});
			
		
		
	 });
	 
	 
});
</script>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<script>
$(document).ready(function(){
$.validator.setDefaults({ ignore: ":hidden:not(select)" });
$('#contact-form').validate({
errorElement: "label",
errorPlacement: function(error, element) {
error.appendTo('label#' + element.attr('id'));
},
rules: {
terms: {
required: true
},
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

<?php ////////////////////////////////////////////////////////////////////////////////////////////////////// ?>

<div class="edit_div"  style="display:none;">
<div class="modal-backdrop fade in"></div>
<div class="modal"  id="tems_edit_content">
	
</div>
</div>






