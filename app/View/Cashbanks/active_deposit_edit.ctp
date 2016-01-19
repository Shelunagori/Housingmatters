
<?php 
$tt_amt = 0;
foreach($cursor1 as $data)
{
$tran_id = (int)$data['fix_deposit']['transaction_id'];
$receipt_id = (int)$data['fix_deposit']['receipt_id'];
$start_date = $data['fix_deposit']['start_date'];	
$bank_name = $data['fix_deposit']['bank_name'];	
$branch = $data['fix_deposit']['bank_branch'];	
$rate = $data['fix_deposit']['interest_rate'];	
$mat_date = $data['fix_deposit']['maturity_date'];	
$remarks = $data['fix_deposit']['purpose'];		
$reference = $data['fix_deposit']['account_reference'];		
$amt = $data['fix_deposit']['principal_amount'];
$file_name = $data['fix_deposit']['file_name'];
$tt_amt = $tt_amt + $amt;
$start_date	= date('d-m-Y',($start_date));	
$mat_date	= date('d-m-Y',($mat_date));
}

?>
<form method="post" enctype="multipart/form-data" id="contact-form">
<div class="portlet box blue">
<div class="portlet-title">
<h4 class="block">Active deposit Edit</h4>
</div>
<div class="portlet-body form">


<input type="hidden" value="<?php echo $receipt_id; ?>" name="rriddd" />
<input type="hidden" value="<?php echo $tran_id; ?>" name="ttrcidd" />
<div class="row-fluid">
<div class="span6">
<label style="font-size:14px;">Bank Name</label>
<div class="controls">
<input type="text" class="m-wrap span7" data-provide="typeahead" data-source="[<?php if(!empty($kendo_implode)) { echo $kendo_implode; } ?>]" value="<?php echo $bank_name; ?>" name="bank_name" id="bank_naaamm">
<label id="bank_naaamm"></label>
</div>
<br />	        
           

<label style="font-size:14px;">Branch</label>
<div class="controls">
<input type="text" class="m-wrap span7" value="<?php echo $branch; ?>" name="branch" id="branchhhh" data-provide="typeahead" 
			   data-source="[<?php if(!empty($kendo_implode2)) { echo $kendo_implode2; } ?>]">
<label id="branchhhh"></label>
</div>
<br />	  


<label style="font-size:14px;">Account Reference</label>
<div class="controls">
<input type="text" class="m-wrap span7" value="<?php echo $reference; ?>" name="reference" id="refffncc">
<label id="refffncc"></label>
</div>
<br />

<label style="font-size:14px;">Principal Amount</label>
<div class="controls">
<input type="text" class="m-wrap span7" style="text-align:right;" maxlength="10" onkeyup="numeric_vali(this.value,2)" id="amttt2" value="<?php echo $amt; ?>" name="amount">
<label id="amttt2"></label>
</div>
<br />

<label style="font-size:14px;">Purpose</label>
<div class="controls">
<select class="m-wrap span7 chosen" id="purpose" name="purpose">
<option value="" style="display:none;">Select</option>
<option value="General Fund" <?php if($remarks == "General Fund") { ?>selected="selected" <?php } ?>>General Fund</option>
<option value="Reserve Fund" <?php if($remarks == "Reserve Fund") { ?>selected="selected" <?php } ?>>Reserve Fund</option>
<option value="Repairs and Maintenance Fund" <?php if($remarks == "Repairs and Maintenance Fund") { ?>selected="selected" <?php } ?>>Repairs and Maintenance Fund</option>
<option value="Sinking Fund" <?php if($remarks == "Sinking Fund") { ?>selected="selected" <?php } ?>>Sinking Fund</option>
<option value="Major Repair Fund" <?php if($remarks == "Major Repair Fund") { ?>selected="selected" <?php } ?>>Major Repair Fund</option>
<option value="Education and Training Fund" <?php if($remarks == "Education and Training Fund") { ?>selected="selected" <?php } ?>>Education and Training Fund</option>
</select>
<label id="purpose"></label>
</div>






</div>
<div class="span6">
<label style="font-size:14px;">Start Date</label>
<div class="controls">
<input type="text" class="date-picker m-wrap span7" data-date-format="dd-mm-yyyy" value="<?php echo $start_date; ?>" name="start_date" id="stdatt">
<label id="stdatt"></label>
</div>
<br />

<label style="font-size:14px;">Maturity Date</label>
<div class="controls">
<input type="text" class="date-picker m-wrap span7" data-date-format="dd-mm-yyyy" value="<?php echo $mat_date; ?>" name="maturity_date" id="mttdatt">
<label id="mttdatt"></label>
</div>
<br />            
            
<label style="font-size:14px;">Interest Rate%</label>
<div class="controls">            
<input type="text"  class="m-wrap span7" maxlength="5" onkeyup="intrest_vali(this.value,2)" id="intrate2"value="<?php echo $rate; ?>" name="rate">
<label id="intrate2"></label> 
</div>
<br />

<label style="font-size:14px;">Attachment</label>
<div class="controls">         
        <span class="btn btn-file">
        <i class="icon-upload-alt"></i>
        <input type="file" class="default" name="file2">
        </span>
</div>
<br />               
</div>              
</div>
<div class="form-actions">
<a href="fix_deposit_view" class="btn green" style="margin-left:70%;"><i class="icon-arrow-left"></i> Back</a>
<button type="submit" class="btn green" name="subbb">Submit</button>
</div>
                       

</div>
</div>
</form>


<script>
$(document).ready(function(){
	
	 jQuery.validator.addMethod("notEqual", function(value, element, param) {
  return this.optional(element) || value !== param;
}, "Please choose Other value!");
	
//$.validator.setDefaults({ ignore: ":hidden:not()" });

$('#contact-form').validate({
ignore: ".ignore",

errorElement: "label",
//place all errors in a <div id="errors"> element
errorPlacement: function(error, element) {
//error.appendTo("label#errors");
error.appendTo('label#' + element.attr('id'));
},
					
	    rules: {
			
			bank_name:{
				required: true
			},
		  
			branch: {
			required: true  
			},
		
			reference : {
			required: true  	
			},

			amount : {
			required: true,  
			number: true	
			},

			start_date : {
			required: true  	
			},
			
			maturity_date: {
			required: true  	
			},
							
			rate : {
			required: true,
			number: true
			},
	        purpose : {
				required: true
				
			}
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















