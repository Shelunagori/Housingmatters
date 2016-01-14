
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
$remarks = $data['fix_deposit']['remarks'];		
$reference = $data['fix_deposit']['account_reference'];		
$amt = $data['fix_deposit']['principal_amount'];
$file_name = $data['fix_deposit']['file_name'];
$tt_amt = $tt_amt + $amt;
$start_date	= date('d-m-Y',($start_date));	
$mat_date	= date('d-m-Y',($mat_date));
}

?>
<div style="background-color:#FFF; overflow:auto; border:1px solid #CCC;">
<h4 style="color: #03F;font-weight: 500;border-bottom: solid 1px #DAD9D9;padding-bottom:18px;">&nbsp;&nbsp;&nbsp;<i class="icon-money"></i>  Active deposit Edit</h4>

<form method="post" enctype="multipart/form-data" id="contact-form">
<input type="hidden" value="<?php echo $receipt_id; ?>" name="rriddd" />
<input type="hidden" value="<?php echo $tran_id; ?>" name="ttrcidd" />

<div style="background-color:#FFF; width:48%; float:left; margin-left:1%;">
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
</div>
<div style="background-color:#FFF; width:50%; float:right;">
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
               
<label style="font-size:14px;">Remarks</label>
<div class="controls">               
<textarea class="m-wrap span7" rows="4" name="remarks"><?php echo $remarks; ?></textarea>
</div>
<br />          

<div style="overflow:auto;">
<a href="fix_deposit_view" class="btn green"><i class="icon-arrow-left"></i> Back</a>
<button type="submit" class="btn green" name="subbb">Submit</button>
</div>
<br /><br />

</form>
</div>



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















