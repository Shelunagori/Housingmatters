<?php if($type == 2) { ?>
			
			<select class="m-wrap chosen span12" id="ppttnam<?php echo $kkk; ?>">
			<option value="" style="display:none;">Select</option>
			<?php 
			foreach($cursor1 as $dataa)
			{
			$name = $dataa['ledger_sub_account']['name'];	
			$auto_id = $dataa['ledger_sub_account']['auto_id'];	
			?>
			<option value="<?php echo $auto_id; ?>"><?php echo $name; ?></option>
			<?php	
			}
			?>
			</select>
			
<?php } else {
	
$this->requestAction(array('controller' => 'Hms', 'action' => 'resident_drop_down')); ?>
	
<?php } ?>