<?php
if($value == 15 || $value == 33 || $value == 35 || $value == 112)
{
?>
<div class="control-group">
<div class="controls">
<select class="span12 m-wrap chosen" name="l_type_name<?php echo $t; ?>" id="sul<?php echo $t; ?>">
<option value="">--SELECT--</option>
<?php

foreach ($cursor1 as $collection) 
{
$auto_id = (int)$collection['ledger_sub_account']['auto_id'];
$name = $collection['ledger_sub_account']['name'];
?>	
<option value="<?php echo $auto_id; ?>"><?php echo $name; ?></option>
<?php } ?>
</select>
</div>
</div>

<?php
}
else
{
?>
	


<?php	
}
?>

<?php if($value == 34) {

$this->requestAction(array('controller' => 'Hms', 'action' => 'resident_drop_down')); ?>   

<?php } ?>