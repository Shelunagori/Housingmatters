<?php
foreach($cursor4 as $data){
$receipt_no = (int)$data['new_cash_bank']['receipt_id'];
$d_date = $data['new_cash_bank']['transaction_date'];
$today = date("d-M-Y");
$amount = $data['new_cash_bank']['amount'];
$society_id = (int)$data['new_cash_bank']['society_id'];
$narration = @$data['new_cash_bank']['narration'];
$user_id = (int)@$data['new_cash_bank']['user_id'];
$account_type = (int)@$data['new_cash_bank']['account_type'];
$sub_account = (int)$data['new_cash_bank']['account_head'];
$auto_id = (int)$data['new_cash_bank']['transaction_id'];
}
$trnsaction_date = date('d-m-Y',$d_date);
?>

<form method="post">
<div class="portlet box blue">
<div class="portlet-title">
<h4 class="block">Update Petty cash Receipt</h4>
</div>
<div class="portlet-body form">
<div class="row-fluid">   
<div class="span6">

<label style="font-size:14px;">Transaction Date<span style="color:red;">*</span></label>
<div class="controls">
<input type="text" class="date-picker m-wrap span7" data-date-format="dd-mm-yyyy" name="date" id="date" data-date-start-date="+0d" value="<?php echo $trnsaction_date; ?>">
<label report="dddd" class="remove_report"></label>
</div>
<br />


<label style="font-size:14px;">A/c Group<span style="color:red;">*</span></label>
<div class="controls">
<select name="type" class="m-wrap span9 chosen" onchange="show_party(this.value)">
<option value="" style="display:none;">Select</option>
<option value="1" <?php if($account_type == 1) { ?> selected="selected" <?php } ?>>Sundry Debtors Control A/c</option>
<option value="2" <?php if($account_type == 2) { ?> selected="selected" <?php } ?>>Other Income</option>
</select>
<label report="acggg" class="remove_report"></label>
</div>
<br />

<div <?php if($account_type == 2) {?>class="hide" <?php } ?> id="one">
<label style="font-size:14px;">Income/Party A/c<span style="color:red;">*</span></label>
<?php
$this->requestAction(array('controller' => 'Hms', 'action' => 'resident_drop_down'));    
?>
</div>
	
<div <?php if($account_type == 1) {?> class="hide" <?php } ?> id="two">
<label style="font-size:14px;">Income/Party A/c<span style="color:red;">*</span></label>
<select name="user_id" class="m-wrap chosen large">
<option value="" style="display:none;">Select</option>
<?php
foreach ($cursor2 as $collection) 
{
$auto_id = (int)$collection['ledger_account']['auto_id'];
$name = $collection['ledger_account']['ledger_name'];
?>
<option value="<?php echo $auto_id; ?>" <?php if($ussidd == $auto_id) { ?> selected="selected"  <?php } ?>><?php echo $name; ?></option>
<?php } ?>
</select>
</div>
<br />

</div>

<div class="span6">
<label style="font-size:14px;">Account Head<span style="color:red;">*</span></label>
<div class="controls">
<select   name="account_head" class="m-wrap span9 chosen" id="acn">
<option value="" style="display:none;">Select</option>
<option value="32" selected="selected">Cash-in-hand</option>
</select> 
<label report="achdd" class="remove_report"></label>
</div>
<br />

<label style="font-size:14px;">Amount<span style="color:red;">*</span></label>
<div class="controls">
<input type="text" class="m-wrap span9"  name="amount" id="amt" value="<?php echo $amount; ?>">
<label report="amttt" class="remove_report"></label>
</div>
<br />


<label style="font-size:14px;">Narration</label></td>
<div class="controls">
<textarea   rows="4" name="narration" class="m-wrap span9" style="resize:none;" id="narr"><?php echo $narration; ?></textarea>
</div>
<br />
</div>
   
</div>                         
<div class="form-actions">
<a href="<?php echo $webroot_path; ?>Cashbanks/petty_cash_receipt_view" class="btn green">
<i class="icon-arrow-left"></i> Back</a>
<button type="submit" class="btn blue">Save</button>

</div>
</div>
</div>
<input type="hidden" value="<?php echo $auto_id; ?>" id="elldd" />
</form>

<script>
function show_party(tt)
{
if(tt == 1)
{
$("#one").show();
$("#two").hide();	
}	
if(tt == 2)	
{
$("#one").hide();
$("#two").show();	
}	
}
</script>	


	







