
<input type="hidden" id="fi" value="<?php echo $datef1; ?>" />
<input type="hidden" id="ti" value="<?php echo $datet1; ?>" />
<input type="hidden" id="cn" value="<?php echo $count; ?>" />


<?php //////////////////////////////////////////////////////////////////////////////////////////////// ?>            
			<?php if($s_role_id == 2) { ?> 
            <table width="100%" border="1" bordercolor="#FFFFFF" cellpadding="0">
            <tr>
            <?php
			if($tenant_c == 1)
			{
			?>
			<td style="width:25%">
            <a href="bank_receipt_view" class="btn blue btn-block"  style="font-size:16px;">Bank Receipt</a>
            </td>
			<?php } ?>
            <td style="width:25%">
            <a href="bank_payment_view" class="btn blue btn-block"   style="font-size:16px;">Bank Payment</a>
            </td>
            <td style="width:25%">
            <a href="petty_cash_receipt_view" class="btn blue btn-block"  style="font-size:16px;">Petty Cash Receipt</a>
            </td>
            <td style="width:25%">
            <a href="petty_cash_payment_view" class="btn red btn-block"  style="font-size:16px;">Petty Cash Payment</a>
            </td>
            </tr>
            </table>     
           <?php } if($s_role_id == 3) { ?>
           
            <table width="100%" border="1" bordercolor="#FFFFFF" cellpadding="0">
            <tr>
            <td style="width:20%">
            <a href="bank_receipt_view" class="btn blue btn-block"  style="font-size:16px;">Bank Receipt</a>
            </td>
            <td style="width:20%">
            <a href="bank_payment_view" class="btn blue btn-block"   style="font-size:16px;">Bank Payment</a>
            </td>
            <td style="width:20%">
            <a href="petty_cash_receipt_view" class="btn blue btn-block"  style="font-size:16px;">Petty Cash Receipt</a>
            </td>
            <td style="width:20%">
            <a href="petty_cash_payment_view" class="btn red btn-block"  style="font-size:16px;">Petty Cash Payment</a>
            </td>
            <td style="width:20%">
            <a href="fix_deposit_view" class="btn blue btn-block"  style="font-size:16px;">Fixed Deposit</a>
            </td>
            </tr>
            </table> 
           <?php } ?>
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
								<?php
								if($zz == 0)
								{
								?>

								<div class="alert">
								<button class="close" data-dismiss="alert"></button>
								<center>
								No Previous Voucher
								</center>
								</div> 
								<?php
								}
								else
								{
								?>

								<div class="alert">
								<button class="close" data-dismiss="alert"></button>
								<center>
								The Last Voucher Number is : <?php echo $zz; ?>
								</center>
								</div> 

								<?php } ?>
<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
			<center>
			<a href="petty_cash_payment" class="btn red">Create</a>
			<a href="petty_cash_payment_view" class="btn blue">View</a>
			</center>	   

<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>		   
		   
		   

									<div class="portlet box grey" style="width:60%; margin-left:20%; margin-right:20%;">
									<div class="portlet-title">
									<h4><i class="icon-reorder"></i>Petty Cash Payment</h4>
									</div>
									<div class="portlet-body form">  

									<form id="contact-form" method="POST" class="form-horizontal" enctype="multipart/form-data">
									<center>
									<table border="0" style="width:80%;">                  

									<tr>
									<td align="left" valign="top">
									<br>
									<label class="" style="font-size:14px;">Transaction Date</label></td>
									<td valign="top">
									<br>
									<input type="text" class="date-picker m-wrap medium" data-date-format="dd-mm-yyyy" name="date" id="date">
									<label id="date"></label>
                                    <div id="result11"></div>
									</td>
									</tr>




									<tr>
									<td valign="top">
									<Br>
									<label class="" style="font-size:14px;">A/c Group</label></td>
									<td valign="top">
									<br>
									<select name="type" id="go" class="m-wrap medium chosen">
									<option value="" style="display:none;">Select</option>
									<option value="1">Sundry Creditors Control A/c</option>
									<option value="2">All Expenditure A/cs</option>
									</select>
									<label id="go"></label>
									</td>
									</tr>



									<tr>
									<td valign="top">
									<br>
									<label class="" style="font-size:14px;">Expense/Party A/c</label></td>
									<td id="show_user" valign="top">
									<br>
									<select   name="user_id" class="m-wrap medium chosen" id="usr">
									<option value="" style="display:none;">Select</option>
									</select>
									<label id="usr"></label>
									</td>
									</tr>    



									<tr>
									<td valign="top">
									<Br>
									<label class="" style="font-size:14px;">Amount</label></td>
									<td valign="top">
									<br>
									<input type="text"  name="ammount" id="amount" class="m-wrap medium">
									<label id="amount"></label>
									</td>
									</tr>   




									<tr>
									<td valign="top">
									<br>
									<label class="" style="font-size:14px;">Narration</label></td>
									<td valign="top">
									<br>
									<textarea   rows="4" name="narration" style="resize:none;" class="m-wrap medium" id="nr"></textarea>
									<label id="nr"></label>
									</td>
									</tr>



									<tr>
									<td valign="top">
									<Br>
									<label class="" style="font-size:14px;">Paid From</label></td>
									<td valign="top">
									<br>
									<select   name="account_head" class="m-wrap medium chosen" id="ach">
									<option value="" style="display:none;">Select</option>
									<option value="32">Cash-in-hand</option>
									</select> 
									<label id="ach"></label>
									</td>
									</tr>




									

																		</table>

									<br><Br>

									<div class="form-actions" style="background-color:#999;">
									<button type="submit" class="btn green" name="ptp_add" value="xyz" id="vali">Submit</button>
									<a href="petty_cash_payment" class="btn">Reset</a>
									</div>



									</center>
									</form>



									</div>
									</div>

<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>

<script>
$(document).ready(function() {
	$("#go").live('change',function(){
		
		var value1 = document.getElementById('go').value;
		$("#show_user").load("petty_cash_payment_ajax?value1=" +value1 + "");
	});
	
});
</script>	


<script>
$(document).ready(function() {
	$("#data_tds").live('change',function(){
		
		var data_tds = document.getElementById('data_tds').value;
		var amount = document.getElementById('amount').value;
		
		$("#total_am").load("amount_cal_p?data=" + data_tds + "&amount="+ amount +"");
	});
	});
</script>	

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
	      date: {
	       
	        required: true
	      },
		  
		  
		  type: {
	       
	        required: true
	      },
		  
		   user_id: {
	       
	        required: true
	      },
		  
		  
		  
		   ammount: {
	       
	        required: true,
			number: true
	      },
		 
		  
		 
		 
		    narration: {
	       
	        required: true
	      },

	     account_head: {
	       
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
		   
		   
<script>
		$(document).ready(function() {
		$("#vali").live('click',function(){
        
		var fi = document.getElementById("fi").value;
		var ti = document.getElementById("ti").value;
		var cn = document.getElementById("cn").value;
		var fe = fi.split(",");
		var te = ti.split(",");
		var date1 = document.getElementById("date").value;
		
		var date = date1.split("-").reverse().join("-");
				
		var nnn = 55;
		for(var i=0; i<cn; i++)
		{
		var fd = fe[i];
		var td = te[i]
		
		    if(date == "")
			{
				nnn = 555;
			break;	
			}
			else if(Date.parse(fd) <= Date.parse(date))
		     {
			 if(Date.parse(td) >= Date.parse(date))
			 {
				 nnn = 5;
				 break;
			 }
			 else
			 {
				 
			 }
        	 } 
			 }
			 
		
		if(nnn == 55)
		{
		$("#result11").load("cash_bank_vali?ss=" + 2 + "");
        return false;	
		}
		else if(nnn == 555)
		{
			
		}
		else
		{
		$("#result11").load("cash_bank_vali?ss=" + 12 + "");		
		}
		
		
		
		});
		});
		</script>		
		   
		   
		   
		   
		   
		   
		   
		   
		   
		   
		   
		   
		   
		   
		   
		   
		   
		   
		   