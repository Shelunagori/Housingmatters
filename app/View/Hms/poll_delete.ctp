<?php if($delete==0) { ?>


<div class="modal-header" >
	<h4 id="myModalLabel1">Delete poll</h4>
</div>
<div class="modal-body">
	Are you sure to delete this poll ?				   			   
</div>
<div class="modal-footer">
	<button class="btn" id="close_edit">Close</button>
	<button class="btn red delete_poll_btn" poll_id="<?php echo $poll_id; ?>">Delete</button>
</div>

<?php } ?>









<?php if($delete==1) { ?>
<div class="modal-body">Poll deleted successfully.</div>
<div class="modal-footer"><button class="btn blue" id="close_edit">Ok</button></div>
<?php } ?>

