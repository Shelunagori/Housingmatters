<?php
if($value1 == 1)
{
?>
<select class="m-wrap span12 chosen">
<option value="" style="display:none;">Select</option>
<?php
foreach ($cursor1 as $collection) 
{
$auto_id = (int)$collection['ledger_sub_account']['auto_id'];
$name = $collection['ledger_sub_account']['name'];
?>
<option value="<?php echo $auto_id; ?>" <?php if(!empty($ussidd) && $ussidd != 0) { if($ussidd == $auto_id) { ?> selected="selected" <?php } } ?> ><?php echo $name; ?></option>
<?php } ?>
</select>
<?php
}
else if($value1 == 2)
{
?>
<select class="m-wrap span12 chosen">
<option value="" style="display:none;">Select</option>
<?php
foreach($cursor2 as $collection)
{
$auto_id1 = (int)$collection['accounts_group']['auto_id'];
$result_ledger_account = $this->requestAction(array('controller' => 'hms', 'action' => 'expense_tracker_fetch2'),array('pass'=>array($auto_id1)));
foreach($result_ledger_account as $collection2)
{
$sub_id = (int)$collection2['ledger_account']['auto_id'];
$name = $collection2['ledger_account']['ledger_name'];
?>
<option value="<?php echo $sub_id; ?>" <?php if(!empty($ussidd) && $ussidd != 0) { if(@$ussidd == $auto_id) { ?> selected="selected" <?php } } ?> ><?php echo $name; ?></option>
<?php } } ?>
</select>
<?php
}
else
{
?>	
<select name="user_id" class="m-wrap span9">	
<option value=""><?php echo $value1; ?></option>	
</select>	
<?php	
}
?>