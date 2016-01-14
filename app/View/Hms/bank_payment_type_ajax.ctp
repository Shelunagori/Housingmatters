<?php
if($type == 1)
{
?>
<br>
<select name="expense_ac" class="m-wrap medium">
<option value="">--SELECT--</option>
<?php
foreach($cursor1 as $collection)
{
$auto_id = $collection['ledger_sub_account']['auto_id'];
$name = $collection['ledger_sub_account']['name'];
?>
<option value="<?php echo $auto_id; ?>"><?php echo $name; ?></option>
<?php } ?>
</select>
<?php 
} 
else if($type == 2)
{
?>
<br>
<select name="expense_ac" class="m-wrap medium">
<option value="">--SELECT--</option>
<?php
foreach($cursor2 as $collection)
{
$auto_id_a = (int)$collection['accounts_group']['auto_id'];

$result33 = $this->requestAction(array('controller' => 'hms', 'action' => 'expense_tracker_fetch2'),array('pass'=>array($auto_id_a)));
foreach($result33 as $collection)
{
$auto_id = (int)$collection['ledger_account']['auto_id'];
$name = $collection['ledger_account']['ledger_name'];
if($auto_id == 15)
continue;

?>
<option value="<?php echo $auto_id; ?>"><?php echo $name; ?></option>
<?php }} ?>
</select>
<?php }
else if($type == 3)
{
?>
<br>
<select name="expense_ac" class="m-wrap medium">
<option value="">--SELECT--</option>
<?php
foreach($cursor3 as $collection)
{
$auto_id_b = (int)$collection['accounts_group']['auto_id'];

$result33 = $this->requestAction(array('controller' => 'hms', 'action' => 'expense_tracker_fetch2'),array('pass'=>array($auto_id_b)));
foreach($result33 as $collection)
{
$auto_id = (int)$collection['ledger_account']['auto_id'];
$name = $collection['ledger_account']['ledger_name'];
?>
<option value="<?php echo $auto_id; ?>"><?php echo $name; ?></option>
<?php }} ?>
</select>
<?php }
else
{
?>

<br>
<select name="expense_ac" class="m-wrap medium">
<option value="">--SELECT--</option>
</select>
<?php } ?>



