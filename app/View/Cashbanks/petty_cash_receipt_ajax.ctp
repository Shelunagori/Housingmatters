<?php if($value == 1) { 

$this->requestAction(array('controller' => 'Hms', 'action' => 'resident_drop_down'));    
} else if($value == 2) { ?>	
<select name="user_id" class="m-wrap chosen span12">
<option value="" style="display:none;">Select</option>
<?php

foreach ($cursor2 as $collection) 
{
$auto_id = (int)$collection['ledger_account']['auto_id'];
$name = $collection['ledger_account']['ledger_name'];
?>
<option value="<?php echo $auto_id; ?>" <?php if($ussidd == $auto_id) { ?> selected="selected"  <?php } ?>><?php echo $name; ?></option>
<?php } ?>
</select>
<?php
}
else
{
?>
<select name="user_id" class="m-wrap span12 chosen" id="usr">
<option value="">Select</option>
</select>
<?php
}
?>