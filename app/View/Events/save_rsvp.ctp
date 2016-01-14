<?php
if($type==1){
?>
<h4 style="color:#000;">How many members from your family will join this event?</h4>
<div class="input-append hidden-phone">  
   <select class="span12 m-wrap" data-placeholder="Choose a Category" tabindex="1" id="members">
		<option value="">Select Member</option>
		<option value="1">1 Member</option>
		<option value="2">2 Members</option>
		<option value="3">3 Members</option>
		<option value="4">4 Members</option>
		<option value="5">5 Members</option>
		<option value="6">6 Members</option>
		<option value="7">7 Members</option>
		<option value="8">8 Members</option>
		<option value="9">9 Members</option>
		<option value="10">10 Members</option>
	</select>
   <button class="btn blue" id="send_member" element_id="<?php echo $e; ?>">Send</button>
</div>
<?php
}?>