<input type="hidden" id="from" value="<?php echo $datefrom; ?>" />
<input type="hidden" id="to" value="<?php echo $datetto; ?>" />
<input type="hidden" id="count" value="<?php echo $count; ?>" />
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
$transaction_date = date('d-m-Y',($d_date));
$petty_cash_payment_id = (int)$collection['new_cash_bank']['transaction_id'];
}
?>

<form method="post" id="contact-form">
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
<span style="font-size:14px; color:red" id="validation"></span>
</div>
<br />


<label style="font-size:14px;">A/c Group<span style="color:red;">*</span> <i class=" icon-info-sign tooltips" data-placement="right" data-original-title="Please select account group"> </i></label>
<div class="controls">
<select name="type" class="m-wrap span9 chosen" onchange="show_party(this.value)" id="type">
<option value="" style="display:none;">Select</option>
<option value="1" <?php if($account_type == 1){ ?>selected="selected" <?php } ?>>Sundry Creditors Control A/c</option>
<option value="2" <?php if($account_type == 2){ ?>selected="selected" <?php } ?>>All Expenditure A/cs</option>
</select>
<label id="type"></label>
</div>
<br />

<div <?php if($account_type == 2){ ?>class="hide"<?php } ?> id="one">
<label style="font-size:14px;">Expense/Party A/c<span style="color:red;">*</span></label>
<select name="party1" class="m-wrap large chosen" id="party1">
<option value="" style="display:none;">Select</option>
<?php 
foreach($cursor1 as $data)
{
$auto_id = (int)$data['ledger_sub_account']['auto_id'];
$name = $data['ledger_sub_account']['name'];	
?>
<option value="<?php echo $auto_id; ?>" <?php if($auto_id == $user_id){ ?> selected="selected"  <?php } ?>><?php echo $name; ?></option>
<?php	
}
?>
</select>
<label id="party1"></label>
</div>


<div id="two" <?php if($account_type == 1){ ?> class="hide" <?php } ?>>
<label style="font-size:14px;">Expense/Party A/c<span style="color:red;">*</span></label>
<select name="pppppp" class="m-wrap large chosen ignore" id="party2">
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
<option value="<?php echo $sub_id; ?>" <?php if($user_id == $sub_id){ ?> selected="selected"  <?php } ?>><?php echo $name; ?></option>
<?php	
}}
?>
</select>
<label id="party2"></label>
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
<textarea   rows="4" name="narration" style="resize:none;" class="m-wrap span9"><?php echo $narration; ?></textarea>

</div>
</div>
</div>
<div class="form-actions">
<a href="<?php echo $webroot_path; ?>Cashbanks/petty_cash_payment_view" class="btn green" rel="tab"><i class="icon-arrow-left"></i> Back</a>
<button type="submit" class="btn blue" name="petty_cash_payment" id="petty_payment">Save</button>

</div>
</div>
</div>
<input type="hidden" value="<?php echo $petty_cash_payment_id; ?>" name="petty_cash_id">
</form>
<script>
$(document).ready(function() {
$("#petty_payment").bind('click',function(){

var from_date = document.getElementById("from").value;
var to_date = document.getElementById("to").value;
var count = document.getElementById("count").value;
var fromm = from_date.split(",");
var tomm = to_date.split(",");
var transaction_date = $("#date").val();

var nnn = 55;
for(var i=0; i<count; i++)
{
var frmm = fromm[i]; 
var too	= tomm[i];
      if(frmm == ""){
			nnn = 555;
			break;	
	    }
 else if(Date.parse(transaction_date) >= Date.parse(frmm) && Date.parse(transaction_date) <= Date.parse(too))  
 {
 nnn = 5;
 break; 
 }
}

if(nnn == 55)
{
$("#validation").html('Transaction Date Should be in Open Financial Year');	
return false;	
}
else{
$("#validation").html('');		
	
}

});
});
</script>

<script>
function show_party(kk)
{
if(kk == 1)
{
$("#one").show();	
$("#two").hide();
$("#party1").removeClass("ignore");
$("#party2").addClass("ignore");
}
if(kk == 2)
{
$("#one").hide();	
$("#two").show();
$("#party1").addClass("ignore");
$("#party2").removeClass("ignore");		
}
}
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
		  
			type: {
			required: true  
			},
	



	
			party1 : {
			required: true  	
			},

			pppppp : {
			required: true
			
			},

			account_head : {
			required: true  	
			},
			
			ammount: {
			required: true,
            number: true,
            notEqual: "0"			
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
