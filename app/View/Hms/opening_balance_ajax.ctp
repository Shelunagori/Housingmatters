<?php
if($value1 == 15 || $value1 == 33 || $value1 == 34 || $value1 == 35)
{	
?>	
<select name="su_le_ac" class="m-wrap medium chosen">	
<option value="">Select Subledger</option>
<?php
$result2 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch2'),array('pass'=>array($value1)));
foreach($result2 as $collection)
{
$auto_id2 = (int)$collection['ledger_sub_account']['auto_id'];
$name = $collection['ledger_sub_account']['name'];
?>
<option value="<?php echo $auto_id2; ?>"><?php echo $name; ?></option>
<?php } ?>

<?php
}
else
{
	
?>
<select class="m-wrap medium">
<option value="">Select Subledger</option>
</select>
<?php
}
?>