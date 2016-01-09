
<select name="subl" id="subl" class="m-wrap medium chosen" style="margin-top:8px;">
<option value="">Select Subledger</option>
<?php
foreach($cursor1 as $collection)
{
$auto_id2 = (int)$collection['ledger_sub_account']['auto_id'];
$name = $collection['ledger_sub_account']['name'];
?>
<option value="<?php echo $auto_id2; ?>"><?php echo $name; ?></option>	
<?php	
}

?>
</select>