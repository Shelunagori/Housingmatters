<?php /////////////////////////////////////////////////////////////////////////////////////////////// ?>            
			<table width="100%" border="1" bordercolor="#FFFFFF" cellpadding="0">
            <tr>
            <td style="width:25%">
            <a href="it_regular_bill" class="btn blue btn-block"   style="font-size:16px;"> Regular Bill</a>
            </td>
            <td style="width:25%">
             <a href="it_supplimentry_bill" class="btn blue btn-block"  style="font-size:16px;">Supplementary Bill</a>
            </td>
            <td style="width:25%">
            <a href="in_head_report" class="btn blue btn-block"  style="font-size:16px;">Reports</a>
            </td>
            <td style="width:25%">
            <a href="select_income_heads" class="btn red btn-block"  style="font-size:16px;">Accounting Setup</a>
            </td>
            </tr>
            </table>
            
           <table  align="center" border="1" bordercolor="#FFFFFF" cellpadding="0">
            <tr>
			<td><a href="select_income_heads" class="btn">Selection of Income Heads</a>
			</td>
			<!--<td>
            <a href="it_due_tax" class="btn" style="font-size:16px;">Due tax</a>
            </td>-->
            <td>
            <a href="it_setup" class="btn " style="font-size:16px;">Terms & Condition</a>
            </td>
            <td>
            <a href="master_rate_card" class="btn" style="font-size:16px;">Rate Card</a>
            </td>
            <td>
            <a href="master_noc" class="btn" style="font-size:16px;">Non Occupancy Charges</a>
            </td>
             <td>
            <a href="it_penalty" class="btn yellow" style="font-size:16px;">Penalty Option</a>
            </td>
			</tr>
			</table> 
<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////////?>
<form method="post" id="contact-form">
<center>
<div style="width:60%; border:solid 1px #F00; background-color:white;">
<h4 style="color:red;"><b>Penalty Option</b></h4>
<h5 style="color:red"><b>Enter Yearly Penalty Persentage</b></h5>
<table border="0">
<tr>
<td colspan="2">
<label class="radio">
<div class="radio" id="uniform-undefined"><span><input type="radio" name="type" value="1" style="opacity: 0;" id="type"></span></div>
From Due Date
</label>


<label class="radio">
<div class="radio" id="uniform-undefined"><span><input type="radio" name="type" value="2" style="opacity: 0;" id="type"></span></div>
From First day
</label>
<label id="type"></label>
<br />
</td>
</tr>
<tr>
<td>Persentage in Number:</td>
<td><input type="text" name="tax" class="m-wrap small" style="background-color:white !important;" id="tax"/></td>
</tr>
<tr>
<td colspan="2">
<label id="tax"></label>
</td>
</tr>
</table>
<div style="">
<button class="btn green" name="sub" style="margin-left:35%;">Submit</button>
</div>
<br />
</div>
</center>

</form>
<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<center>
<div style="width:60%; border:solid 1px #F00; background-color:white;">
<?php
if($tax_type == 1)
{
$tax_tp = "Due Date";	
}
else
{
$tax_tp = "First Day";	
}
?>
<table border="0">
<tr>
<th style="text-align:center;">From</th>
<th>:</th>
<td style="text-align:center;"><?php echo $tax_tp; ?></td>
</tr>
<tr>
<th style="text-align:center;">Tax (Percentage)</th>
<th>:</th>
<td style="text-align:center;"><?php echo $tax; ?>  %</td>
</tr>
</table>
</div>
</center>

<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<script>
$(document).ready(function(){
		$.validator.setDefaults({ ignore: ":hidden:not(select)" });
		
		$('#contact-form').validate({
		
		errorElement: "label",
                    //place all errors in a <div id="errors"> element
                    errorPlacement: function(error, element) {
                        //error.appendTo("label#errors");
						error.appendTo('label#' + element.attr('id'));
                    },
					
	    rules: {
	      tax: {
	           required: true,
			   number: true
	           },
		type: 
		    {  
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

















