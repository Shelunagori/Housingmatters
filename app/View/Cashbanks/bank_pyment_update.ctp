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
<form method="post" id="contact-form">
<div class="portlet box blue">
<div class="portlet-title">
<h4 class="block">Update Bank Payment</h4>
</div>
<div class="portlet-body form">
<div class="row-fluid">                       
<div class="span6">                       
  
<label style="font-size:14px;">Transaction Date<span style="color:red;">*</span></label>
<div class="controls">
<input type="text" class="date-picker m-wrap span7" data-date-format="dd-mm-yyyy" name="date" id="date" value="<?php echo $transaction_date; ?>">
<label id="date"></label>
</div>
<br />

<label style="font-size:14px;">Ledger Account<span style="color:red;">*</span></label>
<div class="controls">
<select class="m-wrap span9 chosen" id="led" name="ledger">
<option value="">--SELECT--</option>
<?php
foreach($cursor11 as $collection)
{
$auto_id = $collection['ledger_sub_account']['auto_id'];
$name = $collection['ledger_sub_account']['name'];
?>
<option value="<?php echo $auto_id; ?>,1" <?php if($account_type == 1 && $user_id == $auto_id) { ?> selected="selected" <?php } ?>><?php echo $name; ?></option>
<?php } ?>
<?php
foreach($cursor12 as $collection)
{
$auto_id_a = (int)$collection['accounts_group']['auto_id'];
$result33 = $this->requestAction(array('controller' => 'hms', 'action' => 'expense_tracker_fetch2'),array('pass'=>array($auto_id_a)));
foreach($result33 as $collection)
{
$auto_id = (int)$collection['ledger_account']['auto_id'];
$name = $collection['ledger_account']['ledger_name'];
if($auto_id == 15)
continue;
?>
<option value="<?php echo $auto_id; ?>,2" <?php if($account_type == 2 && $user_id == $auto_id) { ?> selected="selected" <?php } ?>><?php echo $name; ?></option>
<?php }} ?>
<?php
foreach($cursor13 as $collection)
{
$auto_id_b = (int)$collection['accounts_group']['auto_id'];

$result33 = $this->requestAction(array('controller' => 'hms', 'action' => 'expense_tracker_fetch2'),array('pass'=>array($auto_id_b)));
foreach($result33 as $collection)
{
$auto_id = (int)$collection['ledger_account']['auto_id'];
$name = $collection['ledger_account']['ledger_name'];
?>
<option value="<?php echo $auto_id; ?>,2" <?php if($account_type == 1 && $user_id == $auto_id) { ?> selected="selected" <?php } ?> ><?php echo $name; ?></option>
<?php }} ?>
</select>
<label id="led"></label>
</div>
<br />



<label style="font-size:14px;">Amount<span style="color:red;">*</span></label></td>
<div class="controls">
<input type="text"   name="ammount" class="m-wrap span9" id="amount" value="<?php echo $amount; ?>" style="text-align:right;">
<label id="amount"></label>
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
<option value= "<?php echo $tds_id2; ?>" <?php if($tds_id == $tds_id2) { $tax=$tds_tax; ?> selected="selected" <?php } ?>><?php echo $tds_tax; ?></option>
<?php } ?>                           
</select>
<label report="tds" class="remove_report"></label>
</div>
<br />
<?php
$tax_amt = round(($tax/100)*$amount);
$net_amt = $amount - $tax_amt;

?>
<label style="font-size:14px;">Net Amount</label>
<div class="controls" id="result">

<input type="text" readonly class="m-wrap span9" value="<?php echo $net_amt; ?>" style="text-align:right;">

</div>

</div>                          
<div class="span6">

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
<label id="mode"></label>
</div>
<br />                         

 
<label style="font-size:14px;">Instrument/UTR<span style="color:red;">*</span></label></td>
<div class="controls">
<input type="text"   name="instruction" class="m-wrap span9" id="inst" value="<?php echo $receipt_instruction; ?>">
<label id="inst"></label>
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
<label id="acb"></label>
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
</div>                          
<div class="form-actions">
<button type="submit" class="btn blue">Save</button>
<button type="button" class="btn">Cancel</button>
</div>
</div>
</div>

</form>



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
$(document).ready(function(){
	
jQuery.validator.addMethod("notEqual", function(value, element, param) {
return this.optional(element) || value !== param;
}, "Please choose Other value!");
	
$.validator.setDefaults({ ignore: ":hidden:not()" });

$('#contact-form').validate({
ignore: ".ignore",

errorElement: "label",
//place all errors in a <div id="errors"> element
errorPlacement: function(error, element) {
//error.appendTo("label#errors");
error.appendTo('label#' + element.attr('id'));
},
					
	    rules: {

			date:{
				required: true
			},
		  
			ledger: {
			required: true  
			},
	
	
			ammount : {
			required: true,
            number: true,
            notEqual: "0"				
			},

			mode : {
			required: true
			
			},

			instruction : {
			required: true  	
			},
			
			bank_account: {
			required: true
           	},
							

		
		},
		highlight: function(element) {
		$(element).closest('.control-group').removeClass('success').addClass('error');
		},
		success: function(element) {
		element
		.text('OK!').addClass('valid')
		.closest('.control-group').removeClass('error').addClass('success');
		}
		});

}); 
</script>











