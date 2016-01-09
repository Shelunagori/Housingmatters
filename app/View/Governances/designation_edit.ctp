<?php 
if($edit==0) {
foreach($des_result as $data)
{
$governance_designation_id=$data['governance_designation']['governance_designation_id'];
$designation_name=$data['governance_designation']['designation_name'];
}

 ?>
<div class="modal-header" >
	<h4 id="myModalLabel1">Edit Designation</h4>
</div>
<div class="modal-body">
	
	
	<div class="control-group">
	  <label class="control-label">Designation Name</label>
	  <div class="controls">
		<input class="m-wrap "  id="des_name"  type="text" value="<?php echo $designation_name; ?>">
		<label id="test_error"></label>
	  </div>
   </div>
   
   
					   
					   
</div>
<div class="modal-footer">
	<button class="btn" id="close_edit">Close</button>
	<button class="btn blue save_edited_des" des_id="<?php echo $governance_designation_id; ?>">Save</button>
</div>

<?php } ?>

<?php if($edit==1) { ?>
<div class="modal-body">Designation updated successfully.</div>
<div class="modal-footer"><button class="btn blue" id="close_edit">Ok</button></div>
<?php } ?>