<?php 
foreach ($cursor4 as $collection) 
{
$receipt_no = (int)$collection['new_cash_bank']['receipt_id'];
$d_date = $collection['new_cash_bank']['transaction_date'];
$today = date("d-M-Y");
$amount = $collection['new_cash_bank']['amount'];
$society_id = (int)$collection['new_cash_bank']['society_id'];
$narration = @$collection['new_cash_bank']['narration'];
$user_id = (int)@$collection['new_cash_bank']['user_id'];
$account_type = (int)@$collection['new_cash_bank']['account_type'];
$sub_account = (int)$collection['new_cash_bank']['account_head'];
$transaction_date = date('d-m-Y');
}
?>

<form method="post">
<div class="portlet box blue">
<div class="portlet-title">
<h4 class="block">Update Petty Cash Payment</h4>
</div>
<div class="portlet-body form">

<div class="row-fluid">
<div class="span6">

<label style="font-size:14px;">Transaction Date<span style="color:red;">*</span></label>
<div class="controls">
<input type="text" class="date-picker m-wrap span7" data-date-format="dd-mm-yyyy" name="date" id="date" value="<?php echo $transaction_date; ?>">
<label id="date"></label>
<div id="result11"></div>
</div>
<br />


<label style="font-size:14px;">A/c Group<span style="color:red;">*</span> <i class=" icon-info-sign tooltips" data-placement="right" data-original-title="Please select account group"> </i></label>
<div class="controls">
<select name="type" id="go" class="m-wrap span9 chosen">
<option value="" style="display:none;">Select</option>
<option value="1" <?php if($account_type == 1) { ?> selected="selected" <?php } ?>>Sundry Creditors Control A/c</option>
<option value="2" <?php if($account_type == 2) { ?> selected="selected" <?php } ?>>All Expenditure A/cs</option>
</select>
<label id="go"></label>
</div>
<br />

<div id="one">
<label style="font-size:14px;">Expense/Party A/c<span style="color:red;">*</span></label>
<select name="party1" class="m-wrap large chosen">
<option value="" style="display:none;">Select</option>
<?php 
foreach($cursor1 as $data)
{
$auto_id = (int)$data['ledger_sub_account']['auto_id'];
$name = $data['ledger_sub_account']['name'];	
?>
<option value="<?php echo $auto_id; ?>"><?php echo $name; ?></option>
<?php	
}
?>
</select>
</div>


<div id="two" class="hide">
<label style="font-size:14px;">Expense/Party A/c<span style="color:red;">*</span></label>
<select name="party2" class="m-wrap large chosen ignore">
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
<option value="<?php echo $auto_id; ?>"><?php echo $name; ?></option>
<?php	
}}
?>
</select>
</div>
<br>


</div>
<div class="span6">
<label style="font-size:14px;">Paid From<span style="color:red;">*</span> </label>
<div class="controls">
<select   name="account_head" class="m-wrap span9 chosen" id="ach">
<option value="" style="display:none;">Select</option>
<option value="32" selected="selected">Cash-in-hand</option>
</select> 
<label id="ach"></label>
</div>
<br />


<label style="font-size:14px;">Amount<span style="color:red;">*</span></label>
<div class="controls">
<input type="text"  name="ammount" id="amount" class="m-wrap span9" value="<?php echo $amount; ?>">
<label id="amount"></label>
</div>
<br />



<label style="font-size:14px;">Narration<span style="color:red;">*</span></label>
<div class="controls">
<textarea   rows="4" name="narration" style="resize:none;" class="m-wrap span9" id="nr"><?php echo $narration; ?></textarea>
<label id="nr"></label>
</div>
</div>
</div>
<div class="form-actions">
<button type="submit" class="btn blue">Save</button>
<button type="button" class="btn">Cancel</button>
</div>
</div>
</div>
</form>









