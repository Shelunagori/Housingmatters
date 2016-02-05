
<table class="table table-bordered table-striped" style="width:100%; background-color:white;" id="open_bal">
<tr>
<th>Account Group</th>
<th>Account Name</th>
<th>Debit</th>
<th>Credit</th>
<th>Penalty</th>
<th>Delete</th>
</tr>
<?php $j=0;
$tt_debit = 0;
$tt_credit = 0; ?>
			
<?php foreach($opening_balance_csv_converted as $data)
{ 
 $csv_id = (int)$data['opening_balance_csv_converted']['auto_id']; 
 $group_id2 = (int)$data['opening_balance_csv_converted']['group_id'];
 $ledger_id = (int)$data['opening_balance_csv_converted']['ledger_id'];
 $ledger_type = (int)$data['opening_balance_csv_converted']['ledger_type'];
 $wing_id = (int)$data['opening_balance_csv_converted']['wing_id'];
 $flat_id = (int)$data['opening_balance_csv_converted']['flat_id'];
 $type = $data['opening_balance_csv_converted']['type'];
 $amount = $data['opening_balance_csv_converted']['amount'];
 $penalty = $data['opening_balance_csv_converted']['penalty'];
	
?>
<tr>

<td>
<select class="m-wrap span10" disabled="disabled">
<option value="">Select Group Account</option>
<?php
foreach($cursor3 as $collection)
{
$group_id5 = (int)$collection['accounts_group']['auto_id'];
$group_name1= $collection['accounts_group']['group_name'];
if($group_id == 15 || $group_id == 34 || $group_id == 33 || $group_id == 35 || $group_id == 112)
{
?>
<option value="15" <?php if($group_id == 15) { ?> selected="selected" <?php } ?>>Sundry Creditors Control A/c</option>
<option value="112" <?php if($group_id == 112) { ?> selected="selected" <?php } ?>>Sundry Debtors Control A/c </option>
<option value="33" <?php if($group_id == 33) { ?> selected="selected" <?php } ?>>Bank Accounts</option>
<option value="35" <?php if($group_id == 35) { ?> selected="selected" <?php } ?>>Tax deducted at source (TDS receivable)</option>
<option value="34" <?php if($group_id == 34) { ?> selected="selected" <?php } ?>>Members Control Account</option>
<?php } else { ?>
<option value="<?php echo $group_id; ?>" <?php if($group_id2 == $group_id) { ?> selected="selected" <?php } ?>><?php echo $group_name1; ?></option>
<?php }} ?>
</select>
</td>
            
            
<td>
<?php
if($ledger_type == 1)
{
?>	
<select class="m-wrap medium" disabled="disabled">
<option value="" style="display:none;">Select</option>
<?php foreach($cursor1 as $dataa)
{
$auto_id = (int)$dataa['ledger_sub_account']['auto_id'];
$name = $dataa['ledger_sub_account']['name'];
?>
<option value="<?php echo $auto_id; ?>" <?php if($auto_id == $ledger_id) { ?> selected="selected" <?php } ?>><?php echo $name; ?></option>
<?php	
}
?>
</select>
<?php	
}
else{
?>	
<select class="m-wrap medium" disabled="disabled">
<option value="" style="display:none;">Select</option>
<?php foreach($cursor2 as $dataa)
{
$auto_id = (int)$dataa['ledger_account']['auto_id'];
$name = $dataa['ledger_account']['ledger_name'];
?>
<option value="<?php echo $auto_id; ?>" <?php if($auto_id == $ledger_id) { ?> selected="selected" <?php } ?>><?php echo $name; ?></option>
<?php	
}
?>
</select>
<?php	
}
?>
</td>

<td>
<input type="text" class="m-wrap span10" style="background-color:white !important;"
<?php if($type == 1){ ?> value="<?php echo $amount; ?>"  <?php } ?>/>
</td>

<td>
<input type="text" class="m-wrap span10" style="background-color:white !important;"
<?php if($type == 2){ ?> value="<?php echo $amount; ?>"  <?php } ?>/>
</td>

<td>
<input type="text" class="m-wrap span10" style="background-color:white !important;"
<?php if($type == 2 && !empty($penalty)){ ?> value="<?php echo $penalty; ?>"  <?php } ?>/>                       
</td>                      

<td>
<a href="#" role="button" class="btn mini red delete" del="<?php echo $j; ?>"><i class="icon-remove icon-white"></i></a>
</td>

	
</tr>
<?php } ?>
<tr>
<th colspan="2" style="text-align:right;">Total</th>
<th></th>
<th></th>
<th></th>
<th></th>
</tr>
</table>



















