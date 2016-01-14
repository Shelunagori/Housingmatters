

<tr class="content_<?php echo $count; ?>" id="tr<?php echo $count; ?>">
<td style="text-align:center;">
<select name="ex_head" class="m-wrap span12" id="ex">
<option value="">Select</option>
<?php
foreach ($cursor1 as $collection)
{
$c_id =  (int)$collection['accounts_group']['auto_id'];
//$c_name = $collection['accounts_group']['category_name'];
$result = $this->requestAction(array('controller' => 'hms', 'action' => 'expense_tracker_fetch2'),array('pass'=>array($c_id)));
foreach ($result as $db)
{
$g_id =  (int)$db['ledger_account']['auto_id'];
$name = $db['ledger_account']['ledger_name'];
?>
<option value="<?php echo $g_id; ?>"><?php echo $name; ?></option>
<?php }} ?>
</select>
</td>
<td style="text-align:center;">
<input type="text" class="m-wrap span9" name="invoice_reference" id="ref">
</td>
<td style="text-align:center;">
<select name="party_head" class="m-wrap span9" id="ph">
<option value="">Select</option>
<?php
foreach ($cursor2 as $collection)
{
$id = $collection['ledger_sub_account']['auto_id'];
$name = $collection['ledger_sub_account']['name']; 
?>                             
<option value="<?php echo $id; ?>"><?php echo $name; ?></option>
<?php } ?>
</select>
</td>
<td style="text-align:center;">
<input type="text" class="m-wrap span9 amt<?php echo $count; ?>" name="invoice_amount" id="ia" onkeyup="amt_val()">
</td>
<td style="text-align:center;">
<a href="#" role="button" id='<?php echo $count; ?>' class="btn black mini delete"><i class="icon-remove-sign"></i></a>
</td>
</tr>