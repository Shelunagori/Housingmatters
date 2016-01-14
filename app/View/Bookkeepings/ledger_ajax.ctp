<?php if($ledger_account_id == 15 || $ledger_account_id == 33 || $ledger_account_id == 35 || $ledger_account_id == 112) { ?>
			
			<select class="medium m-wrap chosen" tabindex="1" id="sub_id" style="margin-top:7px;">
			<option value="">Sub Ledger A/c</option>
			<?php foreach ($cursor1 as $collection) {
			   $auto_id = (int)$collection['ledger_sub_account']['auto_id'];
			   $name = $collection['ledger_sub_account']['name'];
			   $user_id = (int)$collection['ledger_sub_account']['user_id'];
               $account_number = ""; 
			   if($get_id == 33){
			   $account_number = $collection['ledger_sub_account']['bank_account']; } ?>
		       <option value="<?php echo $auto_id; ?>"><?php echo $name; ?>&nbsp;&nbsp;<b> <?php echo $account_number; ?></b></option> 
		       <?php } ?>
		       </select>
		
<?php } else if($ledger_account_id == 34) { 
 
$this->requestAction(array('controller' => 'Hms', 'action' => 'resident_drop_down')); ?>        

<script>
$(document).ready(function(){
$('select').addClass('medium');

});
</script>
<?php } else {  } ?>

