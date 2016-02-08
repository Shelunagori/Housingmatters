<?php
if($value == 33 || $value == 34 || $value == 35 || $value == 15 || $value == 112)
{
?>	
<select class="m-wrap medium chosen" field="sub" record_id="<?php echo $csv_id; ?>" typpp="2">
<option value="" style="display:none;">Select</option>
<?php foreach($cursor1 as $dataa)
{
$auto_id = (int)$dataa['ledger_sub_account']['auto_id'];
$name = $dataa['ledger_sub_account']['name'];
?>
<option value="<?php echo $auto_id; ?>"><?php echo $name; ?></option>
<?php	
}
?>
</select>
<?php	
}
else{
?>	
<select class="m-wrap medium chosen" field="group" record_id="<?php echo $csv_id; ?>" typpp="1">
<option value="" style="display:none;">Select</option>
<?php foreach($cursor2 as $dataa)
{
$auto_id = (int)$dataa['ledger_account']['auto_id'];
$name = $dataa['ledger_account']['ledger_name'];
?>
<option value="<?php echo $auto_id; ?>"><?php echo $name; ?></option>
<?php	
}
?>
</select>
<?php	
}
?>