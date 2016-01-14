<input type="hidden" id="fi" value="<?php echo $datef1; ?>" />
<input type="hidden" id="ti" value="<?php echo $datet1; ?>" />
<input type="hidden" id="cn" value="<?php echo $count; ?>" />



<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
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
            <a href="bank_payment_view" class="btn red btn-block"   style="font-size:16px;">Bank Payment</a>
            </td>
            <td style="width:25%">
            <a href="petty_cash_receipt_view" class="btn blue btn-block"  style="font-size:16px;">Petty Cash Receipt</a>
            </td>
            <td style="width:25%">
            <a href="petty_cash_payment_view" class="btn blue btn-block"  style="font-size:16px;">Petty Cash Payment</a>
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
            <a href="bank_payment_view" class="btn red btn-block"   style="font-size:16px;">Bank Payment</a>
            </td>
            <td style="width:20%">
            <a href="petty_cash_receipt_view" class="btn blue btn-block"  style="font-size:16px;">Petty Cash Receipt</a>
            </td>
            <td style="width:20%">
            <a href="petty_cash_payment_view" class="btn blue btn-block"  style="font-size:16px;">Petty Cash Payment</a>
            </td>
            <td style="width:20%">
            <a href="fix_deposit_view" class="btn blue btn-block"  style="font-size:16px;">Fixed Deposit</a>
            </td>
            </tr>
            </table>     
           <?php } ?> 
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>     
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
<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<center>
<a href="bank_payment" class="btn red">Create</a>
<a href="bank_payment_view" class="btn blue">View</a>
<!-- <a href="bank_payment_list" class="btn blue">List</a> -->
</center>	


<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<br>
                      
               <div class="portlet box grey" style="width:60%; margin-left:20%; margin-right:20%;">
               <div class="portlet-title">
               <h4><i class="icon-reorder"></i>Bank Payment</h4>
               </div>
               <div class="portlet-body form">
              
                           <form id="contact-form" method="POST" class="form-horizontal" enctype="multipart/form-data">
                           <center>
                           <table class="" style="width:80%;">


							<tr>
							<td align="left">
							<br>
							<label class="" style="font-size:14px;">Transaction Date </label>
							</td>
							<td>
							<br>
							<input type="text" class="date-picker m-wrap medium" data-date-format="dd-mm-yyyy" name="date" id="date">
							<label id="date"></label>
                            <div id="result11"></div>
							</td>
							</tr>

							
							<tr>
							<td align="left" valign="top">
							<br>
							<label class="" style="font-size:14px;">A/c Group</label>
							</td>
							<td valign="top">
							<br>
                            <select name="ac_type" class="m-wrap medium" id="type">
                            <option value="">--SELECT--</option>							 
                            <option value="1">Sundry Creditors Control A/c</option>
							<option value="2">Liability</option>
							<option value="3">Expenditure</option>
                            </select>
							<label id="type"></label>
							</td>
							</tr>
							
							
							
							
							
							<tr>
							<td valign="top">
							<br>
							<label class="" style="font-size:14px;">Expense Party A/c</label></td>
							<td id="result2" valign="top">
							<br>
							<select name="expense_ac" class="m-wrap medium chosen" id="exp">
							<option value="">--SELECT--</option>
							</select>
							<label id="exp"></label>
							</td>
							</tr>

							
							
                           <tr>					   
						   <td valign="top">
                           <br>
                           <label class="" style="font-size:14px;">Invoice Reference</label>
                           </td>
						   <td valign="top">
                           <br>
                           <input type="text"   name="invoice_reference" class="m-wrap medium" id="ref">
						   <label id="ref"></label>
						   </td>
						   </tr>
							
						   <tr>
                           <td valign="top">
                           <br>
                           <label class="" style="font-size:14px;">Amount</label></td>
                           <td valign="top">
                           <br>
                           <input type="text"   name="ammount" class="m-wrap medium" id="amount">
						    <label id="amount"></label>
						   </td>
                           </tr>
							
						   <tr>
                           <td valign="top">
                           <br>
                           <label class="" style="font-size:14px;">Narration</label></td>
						   <td valign="top">
                           <br>
                           <textarea   rows="4" name="description" class="m-wrap medium" style="resize:none;" id="des"></textarea>
						   <label id="des"></label>
						   </td>
                           </tr>
						   
							
						   <tr>
                           <td valign="top">
                           <br>
                           <label class="" style="font-size:14px;">Mode of Payment</label></td>
                           <td valign="top">
                           <br>
						   <label class="radio">
                           <div class="radio" id="uniform-undefined"><span><input type="radio" name="mode" value="Cheque" style="opacity: 0;" id="mode"></span></div>
                           Cheque
                           </label>
                           <label class="radio">
                           <div class="radio" id="uniform-undefined"><span><input type="radio" name="mode" value="NEFT" style="opacity: 0;" id="mode"></span></div>
                           NEFT
                           </label>
                           <label class="radio">
                           <div class="radio" id="uniform-undefined"><span><input type="radio" name="mode" value="PG" style="opacity: 0;" id="mode"></span></div>
                           PG
                           </label>
						   <label id="mode"></label>
                           </td>
                           </tr>
							
						   <tr>
                           <td valign="top">
                           <br>
                           <label class="" style="font-size:14px;">Instrument/UTR</label></td>
						   <td valign="top">
                           <br>
                           <input type="text"   name="instruction" class="m-wrap medium" id="inst">
						   <label id="inst"></label>
						   </td>
                           </tr> 
							
						   
							<tr>
							<td valign="top">
							<br>
							<label class="" style="font-size:14px;">Bank Account</label></td>
							<td valign="top">
							<br>
							<select name="bank_account" onchange="get_value(this.value)" class="m-wrap medium chosen" id="acb">
							<option value="" style="display:none;">Select</option>    
							<?php
							foreach ($cursor2 as $db) 
							{
							$sub_account_id =(int)$db['ledger_sub_account']['auto_id'];
							$sub_account_name =$db['ledger_sub_account']['name'];
							?>
							<option value="<?php echo $sub_account_id; ?>"><?php echo $sub_account_name; ?></option>
							<?php } ?>
							</select>
							<label id="acb"></label>
							</td>
							</tr> 
						  
						  
							<tr>
							<td valign="top">
							<br>
							<label class="" style="font-size:14px;">TDS in Percentage</label></td>
							<td valign="top">
							<br>
							<select name="tds_p" id="go" class="m-wrap medium chosen">
							<option value="" style="display:none;">Select</option>
							<?php
							for($k=0; $k<sizeof($tds_arr); $k++)
							{
							$tds_sub_arr = $tds_arr[$k];	
							$tds_id = (int)$tds_sub_arr[1];
							$tds_tax = $tds_sub_arr[0];	
							
							?>
							<option value= "<?php echo $tds_id; ?>"><?php echo $tds_tax; ?></option>
							<?php } ?>                           
							<select>
                            <label id="go"></label>
							</td>
							</tr> 
						  
						    </td>
                            </tr> 
                            <tr>
                            <td valign="top"><br><label class="" style="font-size:14px;">Total Amount</label></td>
                            <td id="result" valign="top"><br><span id="total_am"><input type="text" readonly class="m-wrap medium" id="amt"></span>
							
							</td>
                            </tr>
						  
						  
						  
						  
						  
						  
						  
						  
						  
						  
						  
							
							
							</table>
							</center>
<br>
							<div class="form-actions" style="background-color:#CCC;">
							<button type="submit" class="btn green" name="bank_payment_add" value="xyz" id="vali">Submit</button>
							<a href="bank_payment" class="btn">Reset</a>
							</div>


							</form>
							</div>
							</div>


















<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<script>
$(document).ready(function() {
	$("#go").live('change',function(){
		
		var tds = document.getElementById('go').value;
		var amount=document.getElementById('amount').value;
		
		$("#result").load('bank_payment_tds_ajax?tds='+tds+'&amount='+amount+'');
		
		
	
	});
	
});
</script>	
	
	
<script>
$(document).ready(function() {
	$("#type").live('change',function(){
		
		var type = document.getElementById('type').value;
		
		$("#result2").load('bank_payment_type_ajax?type='+type+'');
	
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
		  
		  
		  ac_type: {
	       
	        required: true
	      },
		  
		   expense_ac: {
	       
	        required: true
	      },
		  
		  
		  
		   invoice_reference: {
	       
	        required: true
	      },
		 
		  
		 
		 
		    ammount: {
	       
	        required: true,
			number: true
	      },

	     description: {
	       
	        required: true
	      },
		
		 mode: {
	       
	        required: true
	      },
		  
		   instruction: {
	       
	        required: true
	      },
		
		 bank_account: {
	       
	        required: true
	      },
		 
		 tds_p: {
	       
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
	
	
	
	
	
	
		  
		  
		 








