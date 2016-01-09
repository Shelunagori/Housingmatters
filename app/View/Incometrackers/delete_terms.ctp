<?php if($delete==0) { ?>

<div class="modal-header" >
<h4 id="myModalLabel1">Delete Terms and Condition</h4>
</div>
<div class="modal-body">
Are you sure to delete this terms and condition			   			   
</div>
<div class="modal-footer">
<button class="btn" id="close_edit">Close</button>
<button class="btn red delete_tems_btn" tems_id="<?php echo $t_id; ?>">Delete</button>
</div>
<?php } ?>









<?php if($delete==1) { ?>
<div class="modal-body">Terms and Condition Deleted Successfully</div>
<div class="modal-footer"><button class="btn blue" id="close_edit">Ok</button></div>
<?php } ?>