<?php
if($value == 1)
{
?>
<br />
<select name="user_id" class="m-wrap medium">
<option value="" style="display:none;">Select</option>
<?php
	
							       
									foreach ($cursor1 as $db) 
									{
 									$auto_id = (int)$db['ledger_sub_account']['auto_id'];
									$user_id = (int)$db['ledger_sub_account']["user_id"];
									$user_name = $db['ledger_sub_account']["name"];
										
										
									
								

	$result = $this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'),array('pass'=>array($user_id)));
	foreach ($result as $collection) 
	{
	$wing_id = $collection['user']['wing'];  
	$flat_id = (int)$collection['user']['flat'];
	$tenant = (int)$collection['user']['tenant'];
	}	
	$wing_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'),array('pass'=>array($wing_id,$flat_id)));									
	if($tenant == 1)
	{
	?>
										
?>
<option value="<?php echo $auto_id; ?>"><?php echo $user_name; ?> &nbsp&nbsp&nbsp&nbsp(<?php echo $wing_flat; ?>) </option>
<?php }} ?>
</select>















<?php
}
else if($value == 2)
{
?>	
	<br />
<select name="user_id" class="m-wrap medium">
<option value="" style="display:none;">Select</option>
<?php

foreach ($cursor2 as $collection) 
{
$auto_id = (int)$collection['ledger_account']['auto_id'];
$name = $collection['ledger_account']['ledger_name'];
?>
<option value="<?php echo $auto_id; ?>"><?php echo $name; ?></option>
<?php } ?>
</select>
<?php

}
else
{
?>
<br />
<select name="user_id" class="m-wrap medium">
<option value="">Select</option>
</select>
<?php
}
?>