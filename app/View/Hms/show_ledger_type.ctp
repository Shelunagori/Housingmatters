<?php
if($value == 34 || $value == 15 || $value == 33 || $value == 35)
{
?>
<div class="control-group">
<div class="controls">
<select class="span12 m-wrap" name="l_type_name<?php echo $t; ?>" id="sul<?php echo $t; ?>">
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