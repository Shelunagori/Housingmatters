<input type="hidden" id="from" value="<?php echo $datefrom; ?>" />
<input type="hidden" id="to" value="<?php echo $datetto; ?>" />
<input type="hidden" id="count" value="<?php echo $count; ?>" />

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
$auto_iddddd = (int)$data['new_cash_bank']['transaction_id'];
}
$trnsaction_date = date('d-m-Y',$d_date);
?>

<form method="post" id="contact-form">
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
<label id="date"></label>
<span style="font-size:14px; color:red" id="validation"></span>
</div>
<br />


<label style="font-size:14px;">A/c Group<span style="color:red;">*</span></label>
<div class="controls">
<select name="type" class="m-wrap span9 chosen" onchange="show_party(this.value)" id="type">
<option value="" style="display:none;">Select</option>
<option value="1" selected="selected">Sundry Debtors Control A/c</option>
<option value="2">Other Income</option>
</select>
<label id="type"></label>
</div>
<br />

<div id="one">
<label style="font-size:14px;">Income/Party A/c<span style="color:red;">*</span></label>
<?php
$this->requestAction(array('controller' => 'Hms', 'action' => 'resident_drop_down'));    
?>
<label id="resident"></label>
<script>
$(document).ready(function() { 
$(".resident_drop_down").attr('id', 'resident');
});
</script>
</div>
	
<div class="hide" id="two">
<label style="font-size:14px;">Income/Party A/c<span style="color:red;">*</span></label>
<select name="party" class="m-wrap chosen large ignore" id="party">
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
<label id="party"></label>
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
<label id="acn"></label>
</div>
<br />

<label style="font-size:14px;">Amount<span style="color:red;">*</span></label>
<div class="controls">
<input type="text" class="m-wrap span9"  name="amount" id="amt" value="<?php echo $amount; ?>">
<label id="amt"></label>
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
<button type="submit" class="btn blue" name="petty_receipt_update" id="petty_receipt">Save</button>

</div>
</div>
</div>
<input type="hidden" value="<?php echo $auto_iddddd; ?>" name="iddd"/>
</form>

<script>
$(document).ready(function() {
$("#petty_receipt").bind('click',function(){

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
function show_party(tt)
{
if(tt == 1)
{
$("#one").show();
$("#two").hide();
$("#resident").removeClass("ignore");
$("#party").addClass("ignore");
}	
if(tt == 2)	
{
$("#one").hide();
$("#two").show();
$("#resident").addClass("ignore");
$("#party").removeClass("ignore");	
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
		
			resident : {
			required: true  	
			},

			party : {
			required: true
			
			},

			account_head : {
			required: true  	
			},
			
			amount: {
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







