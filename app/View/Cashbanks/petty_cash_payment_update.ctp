<?php 
foreach ($cursor1 as $collection) 
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
<body onload="loaddajjax(<?php echo $account_type; ?>,<?php echo $user_id;  ?>)" style="overflow:hidden">
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


<label style="font-size:14px;">Expense/Party A/c<span style="color:red;">*</span> <i class=" icon-info-sign tooltips" data-placement="right" data-original-title="Please select Expense/Party A/c"> </i></label></td>
<div class="controls" id="show_user">
<select   name="user_id" class="m-wrap span9 chosen" id="usr">
<option value="" style="display:none;">Select</option>
</select>
<label id="usr"></label>
</div>

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
</body>



<script>
$(document).ready(function() {
	$("#go").bind('change',function(){
	var value1 = document.getElementById('go').value;
	$("#show_user").load("<?php echo $webroot_path; ?>Cashbanks/petty_cash_payment_ajax?value1=" +value1 + "");
});
});
</script>	


<script>
function loaddajjax(acttpp,ussiddd)
{
$("#show_user").load("<?php echo $webroot_path; ?>Cashbanks/petty_cash_payment_ajax?value1=" +acttpp + "&usdd=" +ussiddd+ "");	
}
</script>





