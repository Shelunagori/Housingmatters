<?php
foreach($cursor1 as $data){
$receipt_id=$data["new_cash_bank"]["receipt_id"];
$transaction_date=$data["new_cash_bank"]["transaction_date"];
$transaction_date=date("d-m-Y",($transaction_date));
$user_id= (int)$data["new_cash_bank"]["user_id"];
$invoice_ref=@$data["new_cash_bank"]["invoice_reference"];
$narration=@$data["new_cash_bank"]["narration"];
$receipt_mode = @$data["new_cash_bank"]["receipt_mode"];
$receipt_instruction = @$data["new_cash_bank"]["receipt_instruction"];
$account_head = (int)@$data["new_cash_bank"]["account_head"];	
$amount = (int)@$data["new_cash_bank"]["amount"];
$tds_id = @$data["new_cash_bank"]["tds_id"];	
$account_type = (int)@$data["new_cash_bank"]["account_type"];	
}
if($account_type == 1)
{
$ledger_sub_dettt = $this->requestAction(array('controller' => 'hms', 'action' => 'subledger_fetch_by_auto_id'),array('pass'=>array($user_id)));
foreach ($ledger_sub_dettt as $sub_leddg_dataa) 
{
$account_name = $sub_leddg_dataa['ledger_sub_account']['name'];
}	
}
else
{
$ledggr_detaill = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_account_fetch2'),array('pass'=>array($user_id)));
foreach ($ledggr_detaill as $ledggr_dataaa) 
{
$account_name = (int)$ledggr_dataaa['ledger_account']['ledger_name'];
}	
}

$ledger_sub_dettt = $this->requestAction(array('controller' => 'hms', 'action' => 'subledger_fetch_by_auto_id'),array('pass'=>array($account_head)));
foreach ($ledger_sub_dettt as $sub_leddg_dataa) 
{
$ac_head_name = $sub_leddg_dataa['ledger_sub_account']['name'];
}	

?>
<body onload="loadddd(<?php echo $tds_id; ?>,<?php echo $account_type; ?>,<?php echo $amount; ?>,<?php echo $user_id; ?>)">
<div style="background-color:#FFF; overflow:hidden; border:1px solid #CCC;" id="bddd">
<h4 style="color: #03F;font-weight: 500;border-bottom: solid 1px #DAD9D9;padding-bottom:10px;"><i class="icon-money" style="margin-left:8px;"></i> Update Bank Payment</h4>
<form method="post">

<div style="background-color:#FFF; width:48%; float:left; margin-left:2%;">

<label style="font-size:14px;">Transaction Date<span style="color:red;">*</span></label>
<div class="controls">
<input type="text" class="date-picker m-wrap span7" data-date-format="dd-mm-yyyy" name="date" id="date" value="<?php echo $transaction_date; ?>">
<label report="tr_dat" class="remove_report"></label>
<div id="result11"></div>
</div>
<br />


<label style="font-size:14px;">A/c Group<span style="color:red;">*</span> <i class=" icon-info-sign tooltips" data-placement="right" data-original-title="Please select account group"> </i></label>
<div class="controls">
<select name="ac_type" class="m-wrap chosen span9" id="type">
<option value="" style="display:none;">--SELECT--</option>							 
<option value="1" <?php if($account_type == 1) { ?> selected="selected" <?php } ?> >Sundry Creditors Control A/c</option>
<option value="2" <?php if($account_type == 2) { ?> selected="selected" <?php } ?> >Liability</option>
<option value="3" <?php if($account_type == 3) { ?> selected="selected" <?php } ?> >Expenditure</option>
</select>
<label report="ac_gr" class="remove_report"></label>
</div>
<br />


<label style="font-size:14px;">Expense Party A/c<span style="color:red;">*</span></label></td>
<div class="controls" id="result2">
<select name="expense_ac" class="m-wrap chosen span9" id="ex_prt_ac">
<option value="">--SELECT--</option>
</select>
<label report="ex_prt" class="remove_report"></label>
</div>
<br />


<label style="font-size:14px;">Amount<span style="color:red;">*</span></label></td>
<div class="controls">
<input type="text"   name="ammount" class="m-wrap span9" id="amount" value="<?php echo $amount; ?>">
<label report="amt" class="remove_report"></label>
</div>
<br />

<label style="font-size:14px;">TDS in Percentage<span style="color:red;">*</span></label></td>
<div class="controls">
<select name="tds_p" id="go" class="m-wrap chosen span9">
<option value="" style="display:none;">Select</option>
<?php
for($k=0; $k<sizeof($tds_arr); $k++)
{
$tds_sub_arr = $tds_arr[$k];	
$tds_id2 = (int)$tds_sub_arr[1];
$tds_tax = $tds_sub_arr[0];	
?>
<option value= "<?php echo $tds_id2; ?>" <?php if($tds_id == $tds_id2) { ?> selected="selected" <?php } ?>><?php echo $tds_tax; ?></option>
<?php } ?>                           
</select>
<label report="tds" class="remove_report"></label>
</div>
<br />



<label style="font-size:14px;">Total Amount</label>
<div class="controls" id="result">
<span id="total_am">
<input type="text" readonly class="m-wrap span9" id="amt" id="tt">
</span>
</div>


</div>

<div style="background-color:#FFF; width:50%; float:right;">

<label style="font-size:14px;">Mode of Payment<span style="color:red;">*</span> <i class=" icon-info-sign tooltips" data-placement="right" data-original-title="Please choose payment mode"> </i></label>
<div class="controls">
<label class="radio">
<div class="radio" id="uniform-undefined"><span><input type="radio" name="mode" value="Cheque" style="opacity: 0;" id="mode" <?php if($receipt_mode == "Cheque") { ?> checked="checked"  <?php } ?> ></span></div>
Cheque
</label>
<label class="radio">
<div class="radio" id="uniform-undefined"><span><input type="radio" name="mode" value="NEFT" style="opacity: 0;" id="mode"<?php if($receipt_mode == "NEFT") { ?> checked="checked"  <?php } ?> ></span></div>
NEFT
</label>
<label class="radio">
<div class="radio" id="uniform-undefined"><span><input type="radio" name="mode" value="PG" style="opacity: 0;" id="mode" <?php if($receipt_mode == "PG") { ?> checked="checked"  <?php } ?>></span></div>
PG
</label>
<label report="mode" class="remove_report"></label>
</div>
<br />                         


 
<label style="font-size:14px;">Instrument/UTR<span style="color:red;">*</span></label></td>
<div class="controls">
<input type="text"   name="instruction" class="m-wrap span9" id="inst" value="<?php echo $receipt_instruction; ?>">
<label report="ins_utr" class="remove_report"></label>
</div>
<br />						  

<label style="font-size:14px;">Bank Account<span style="color:red;">*</span> <i class=" icon-info-sign tooltips" data-placement="right" data-original-title="Please select bank account"> </i></label></td>
<div class="controls">
<select name="bank_account" onchange="get_value(this.value)" class="m-wrap chosen span9" id="acb">
<option value="" style="display:none;">Select</option>    
<?php
foreach ($cursor3 as $db) 
{
$sub_account_id =(int)$db['ledger_sub_account']['auto_id'];
$sub_account_name =$db['ledger_sub_account']['name'];
?>
<option value="<?php echo $sub_account_id; ?>" <?php if($sub_account_id == $account_head) { ?> selected="selected" <?php } ?>><?php echo $sub_account_name; ?></option>
<?php } ?>
</select>
<label report="bank_ac" class="remove_report"></label>
</div>
<br />


<label style="font-size:14px;">Invoice Reference<span style="color:red;">*</span></label>
<div class="controls">
<input type="text"   name="invoice_reference" class="m-wrap span9" id="ref" value="<?php echo $invoice_ref; ?>">
<label report="inv_ref" class="remove_report"></label>
</div>
<br />						   
 
<label style="font-size:14px;">Narration</label></td>
<div class="controls">
<textarea   rows="4" name="description" class="m-wrap span9" style="resize:none;" id="des"><?php echo $narration; ?></textarea>
</div>
<br />

</div>
<br />

<div style="width:100%; overflow:auto;">
<hr />

<button type="submit" class="btn form_post" style="background-color: green; color:#fff; margin-left:70%;" value="xyz" id="vali">Submit</button>
<a href="<?php echo $webroot_path; ?>Cashbanks/bank_payment" class="btn" rel='tab'>Reset</a>
<div style="display:none;" id='wait'><img src="<?php echo $webroot_path; ?>as/fb_loading.gif" /> Please Wait...</div>

</div>
</form>

</div>
</body>

<script>
$(document).ready(function() {
$("#go").live('change',function(){
var tds = document.getElementById('go').value;
var amount=document.getElementById('amount').value;
$("#result").load('<?php echo $webroot_path; ?>Cashbanks/bank_payment_tds_ajax?tds='+tds+'&amount='+amount+'');
});
});
</script>	

	
<script>
$(document).ready(function() {
$("#type").bind('change',function(){
var type = document.getElementById('type').value;
$("#result2").load('<?php echo $webroot_path; ?>Cashbanks/bank_payment_type_ajax?type='+type+'');
});
});
</script>	

<script>
$(document).ready(function() {
$("#type").bind('change',function(){
var type = document.getElementById('type').value;
$("#result2").load('<?php echo $webroot_path; ?>Cashbanks/bank_payment_type_ajax?type='+type+'');
});
});
</script>	


<script>
function loadddd(tddss,acctt,amt,ussidd)
{
$("#result2").load('<?php echo $webroot_path; ?>Cashbanks/bank_payment_type_ajax?type='+acctt+'&ussidd='+ussidd+'');	
$("#result").load('<?php echo $webroot_path; ?>Cashbanks/bank_payment_tds_ajax?tds='+tddss+'&amount='+amt+'');	
}
</script>














