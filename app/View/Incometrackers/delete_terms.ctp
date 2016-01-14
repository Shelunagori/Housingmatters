<?php if($delete==0) { ?>


<div class="modal-body">
Are you sure to delete this terms and condition			   			   
</div>
<div class="modal-footer">
<button class="btn" id="close_edit">Close</button>
<button class="btn red delete_tems_btn" tems_id="<?php echo $t_id; ?>">Delete</button>
</div>
<?php } ?>









<?php if($delete==1) { ?>
<div class="modal-body">
<h4><b>Thank You!</b></h4>
Terms and Condition Deleted Successfully</div>
<div class="modal-footer"><button class="btn red" id="close_edit">Ok</button></div>
<?php } ?>