<?php
if($edit == 0) { 
foreach($cursor1 as $collection)
{
$trms_arr = $collection['society']['terms_conditions'];	
}
$hh = (int)$t_id-1;
$terms_name = $trms_arr[$hh];
?>

<div class="modal-header" >
	<h4 id="myModalLabel1">Edit Terms and Conditions</h4>
</div>
<div class="modal-body">
	
	
	<div class="control-group">
	  <label class="control-label">Terms and Condition</label>
	  <div class="controls">
		<textarea class="m-wrap span12" id="description"><?php echo $terms_name; ?></textarea>
	  </div>
   </div>
   
  				   
					   
</div>
<div class="modal-footer">
	<button class="btn" id="close_edit">Close</button>
	<button class="btn blue save_edited_terms" tems_id="<?php echo $t_id; ?>">Save</button>
</div>

<?php  } ?>


<?php if($edit == 1) { ?>
<div class="modal-body">Terms and Condition Updated Successfully</div>
<div class="modal-footer"><button class="btn blue" id="close_edit">Ok</button></div>
<?php } ?>













