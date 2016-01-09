    
<input type="hidden" id="fi" value="<?php echo $datef1; ?>" />
<input type="hidden" id="ti" value="<?php echo $datet1; ?>" />
<input type="hidden" id="cn" value="<?php echo $count; ?>" />

<?php //////////////////////////////////////////////////////////////////////////////////////////
	
		   if($s_role_id == 3)
           { ?>
            <table width="100%" border="1" bordercolor="#FFFFFF" cellpadding="0">
            <tr>
            <td style="width:20%">
            <a href="bank_receipt_view" class="btn red btn-block"  style="font-size:16px;">Bank Receipt</a>
            </td>
            <td style="width:20%">
            <a href="bank_payment_view" class="btn blue btn-block"   style="font-size:16px;">Bank Payment</a>
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
           <?php }
		   if($s_role_id == 2)
		   {
		   ?>
            <table width="100%" border="1" bordercolor="#FFFFFF" cellpadding="0">
            <tr>            
			<?php
			if($tenant_c == 1)
			{
			?>
			
			
            <td style="width:25%">
            <a href="bank_receipt_view" class="btn red btn-block"  style="font-size:16px;">Bank Receipt</a>
            </td>
            <?php } ?>
			<td style="width:25%">
            <a href="bank_payment_view" class="btn blue btn-block"   style="font-size:16px;">Bank Payment</a>
            </td>
            <td style="width:25%">
            <a href="petty_cash_receipt_view" class="btn blue btn-block"  style="font-size:16px;">Petty Cash Receipt</a>
            </td>
            <td style="width:25%">
            <a href="petty_cash_payment_view" class="btn blue btn-block"  style="font-size:16px;">Petty Cash Payment</a>
            </td>
            </tr>
            </table>   
           <?php } ?>
<?php //////////////////////////////////////////////////////////////////////////////////////// ?>
<?php

			if($zz == 0)
			{
			?>
                    <div class="alert">
				    <button class="close" data-dismiss="alert"></button>
					<center>
                    No Previous Receipt
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
                    The Last Receipt Number is : <?php echo $zz; ?>
					</center>
                    </div> 

            <?php } ?>
<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>			
<center>
<a href="bank_receipt" class="btn red">Create</a>
<a href="bank_receipt_view" class="btn blue">View</a>
</center>	
<?php /////////////////////////////////////////////////////////////////////////////////////////?>
     
	 <br>	
              <div class="portlet box grey" style="width:98%; margin-left:1%; margin-right:1%;">
              <div class="portlet-title">
              <h4><i class="icon-reorder"></i>Bank Receipt</h4>
              </div>
              <div class="portlet-body form" style="background-color:rgb(245, 245, 209);"> 

			   <form id="contact-form" method="POST" class="form-horizontal" enctype="multipart/form-data">         
               <center>
			  
<?php ////////////////////////////////////////////////////////////////////////////////////// ?>

<div style="width:90%; background-color:rgb(245, 245, 209); border:solid 1px;">
                          <br />
                  <table class="table table-bordered" style="width:100%;">        
                   <tr>
				   <td style="text-align:center;">
                   <label>Transaction date</label>
				   <input type="text" class="date-picker m-wrap medium" data-date-format="dd-mm-yyyy" name="date" placeholder="Transaction Date" style="background-color:white !important;" id="date">
				   </td>
				  
                  
                   <td style="text-align:center;">
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
				  
				   </td>

				  <td style="text-align:center;">
                  <label>Instrument/UTR</label>
				  <input type="text"  name="instruction" class="m-wrap medium" placeholder="Instrument/UTR" style="background-color:white !important;" id="ins">
				   </td>
				   
				 <td style="text-align:center;">
				 <label>Deposited In</label>
                 <select name="bank_account" class="medium m-wrap chosen" id="bank">
				<option value="" style="display:none;">Deposited In</option>    
				<?php
				foreach ($cursor3 as $db) 
				{
				$bank_id = (int)$db['ledger_sub_account']["auto_id"];
				$bank_ac = $db['ledger_sub_account']["name"];
				?>
				<option value="<?php echo $bank_id; ?>"><?php echo $bank_ac; ?></option>
				<?php } ?>
				</select>
				   </td>
				   
				  
					</tr>
					<tr>
					<td style="text-align:center;"><label id="date"></label><div id="result11"></div></td>
					<td style="text-align:center;"><label id="ins"></label></td>
					<td style="text-align:center;"><label id="bank"></label></td>
					<td style="text-align:center;"><label id="mode"></label></td>
					</tr>
					</table>
					
				<table class="table table-bordered">
				<tr style="height:60px; border:#000 !important;">
                         
                          
                         
                         
					<td style="width:52.3%; text-align:center;">
                    <label>Received from</label>
					<label class="radio">
					<div class="radio" id="uniform-undefined"><span><input type="radio" name="member" class="go5" value="1" style="opacity: 0;" id="mem"></span></div>
					Member
					</label>
					<label class="radio">
					<div class="radio" id="uniform-undefined"><span><input type="radio" name="member" class="go6" value="2" style="opacity: 0;" onclick="hidediv('div12')" id="mem"></span></div>
					Non-Member
					</label>
					</td>

					
                          
					<td id="div11" style="width:47.7%; text-align:center;">
										  
				    </td>
                          
						  
						<!--<td id="div22" class="hide" style="width:50%; text-align:center;">
						
						</td>-->
                          
                          
                          </tr>
						  <tr>
						  <td style="text-align:center;"> <label id="mem"></label></td>
						  <td style="text-align:center;">
						  <label id="go"></label>
						  <label id="re"></label>
						  </td>
						  
						  </tr>
                          </table>
                          <br />
                          <br />
                          <center>
                          <div id="div12">
                          <div id="result" style="width:80%;" >
                         
                          </div>
                          </div>
                          <div id="div13" class="hide">
                          <table border="0">
                          <tr>
                          <td>
                          <input type="text" class="m-wrap large" name="refn" placeholder="Bill Reference" style="background-color:white !important;" id="refn"/>
                          </td>
                          <td>
                          <input type="text" name="amountn" class="m-wrap small" placeholder="Amount" style="background-color:white !important;" id="amt"/>
                          </td>
                          </tr>
						  <tr>
						  <td style="text-align:center;"><label id="refn"></label></td>
						  <td style="text-align:center;"><label id="amt"></label></td>
						  </tr>
                          </table>
                          </div>

 <label style="margin-right:70%;">Narration</label>
<textarea   rows="4" name="description" class="medium m-wrap" placeholder="Narration" style="background-color:white !important; resize:none; margin-right:70%;"  id="nar"></textarea>       
 <label id="nar" style="margin-right:70%;"></label>                        
                          
<?php ///////////////////////////////////////////////////////////////?>                          
				   
							 
                       <br><br>
                        </div>
                         
                          </center>
                           <div class="form-actions" style="background-color:#CCC;">
                              <button type="submit" class="btn green" name="bank_receipt_add" value="xyz" id="vali">Submit</button>
                             <a href="bank_receipt" class="btn">Reset</a>
                              </div>
</form>							  
                          </div>
                          </div>          
                        

<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>

		<script>
		$(document).ready(function() {
		$("#go").live('change',function(){

		var value1 = document.getElementById('go').value;
		//var date2=document.getElementById('date2').value;


		$("#result").load("bank_receipt_reference_ajax?value1=" +value1 + "");


		});

		$("#i_head").live('change',function(){

		var ss = $("[id=i_head]").val();

		$("#result2").html('Loding...').load("bank_receipt_amount_ajax?ss=" +ss + "");	

		});

		});
		</script>	  
		  
		
		
	
<script>
function hidediv(id)
{
	document.getElementById('div13').style.display='block';
	document.getElementById(id).style.display='none';
}
$(document).ready(function() {
	$(".go5").live('click',function(){
		document.getElementById('div12').style.display='block';
		document.getElementById('div13').style.display='none';
		$("#div1").show();
		$("#div2").hide();
		//$("#div11").show();
		//$("#div22").hide();
	
	$("#div11").html('Loding...').load("bank_receipt_ajax?ff=" + 5 + "");
	
	
	});
	
	$(".go6").live('click',function(){
		$("#div2").show();
		$("#div1").hide();
		//$("#div22").show();
		//$("#div11").hide();
		$("div13").show();
	
	$("#div11").html('Loding...').load("bank_receipt_ajax?ff=" + 8 + "");
	
	});
	
});
</script>		
























<?php /////////////// ?>

 <?php ////////////////////////////////////// ?>


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
		  
		  
		  instruction: {
	       
	        required: true
	      },
		  
		   bank_account: {
	       
	        required: true
	      },
		  
		  description: {
	       
	        required: true
	      },
		 
	         mode: {
                required: true
	      },

	     member: {
	       
	        required: true
	      },
		
		recieved_from2: {
	       
	        required: true
	      },
		
		
		
		recieved_from: {
	       
	        required: true
	      },
		
		 refn: {
	       
	        required: true
	      },
		 
		 amountn: {
	       
	        required: true,
			number: true
	      },
		amount : {
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
		


















