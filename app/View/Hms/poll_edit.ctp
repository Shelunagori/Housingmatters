
<?php if($edit==0) { ?>
<?php 
$poll_id=$poll_result[0]["poll"]["poll_id"];
$des=$poll_result[0]["poll"]["des"];
$close_date=$poll_result[0]["poll"]["close_date"];
$close_date = date('d-m-Y',$close_date->sec);
 ?>

<div class="modal-header" >
	<h4 id="myModalLabel1">Edit poll</h4>
</div>
<div class="modal-body">
	
	
	<div class="control-group">
	  <label class="control-label">Description</label>
	  <div class="controls">
		<textarea class="m-wrap span12" id="description"><?php echo $des; ?></textarea>
	  </div>
   </div>
   
   <div class="control-group">
	  <label class="control-label">Poll will be close after</label>
	  <div class="controls">
		<input class="m-wrap date-picker" data-date-format="dd-mm-yyyy" id="close_date"  type="text" value="<?php echo $close_date; ?>">
	  </div>
   </div>
					   
					   
</div>
<div class="modal-footer">
	<button class="btn" id="close_edit">Close</button>
	<button class="btn blue save_edited_poll" poll_id="<?php echo $poll_id; ?>">Save</button>
</div>

<?php } ?>









<?php if($edit==1) { ?>
<div class="modal-body">Poll updated successfully.</div>
<div class="modal-footer"><button class="btn blue" id="close_edit">Ok</button></div>
<?php } ?>



<script>
$('.date-picker').datepicker().on('changeDate', function(){
			
			
         $(this).blur();
		// var d=$(this).val();
		 
		 //var dd = new Date(d);
		 //alert(d);
		// date1 = new Date().setHours('','','','');
		//alert(date1);
		
        }); 
</script>