
<input type="hidden" id="fi" value="<?php echo $datef1; ?>" />
<input type="hidden" id="ti" value="<?php echo $datet1; ?>" />
<input type="hidden" id="cn" value="<?php echo $count; ?>" />




<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<center>
<h3><b>Expense Tracker Add</b>
</center>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
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


<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>

<center>
<a href="expense_tracker_add" class="btn red">Add</a>
<!-- <a href="expense_tracker_edit" class="btn blue">Edit</a> -->
<a href="expense_tracker_view" class="btn blue">View</a>
<a href="expense_tracker_pie_chart" class="btn blue">Pie Chart</a>
</center>	
<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<br>

		<div class="portlet box grey" style="width:60%; margin-left:20%; margin-right:20%;">
		<div class="portlet-title">
		<h4><i class="icon-reorder"></i>Expense Tracker</h4>
		</div>
		<div class="portlet-body form">


		<form id="contact-form" method="POST" class="form-horizontal" enctype="multipart/form-data">
		<center>
		<table border="0" style="width:80%;">



							<tr>
							<td valign="top"><br>
							<label class="" style="font-size:14px;">Expense Head</label>
							</td>
							<td valign="top"><br>
							<select name="ex_head" class="m-wrap medium chosen" id="ex">
							<option value=""></option>

							<?php
							foreach ($cursor1 as $collection)
							{
							$c_id =  (int)$collection['accounts_group']['auto_id'];
							$c_name = $collection['accounts_group']['category_name'];

							$result = $this->requestAction(array('controller' => 'hms', 'action' => 'expense_tracker_fetch2'),array('pass'=>array($c_id)));
							foreach ($result as $db)
							{
							$g_id =  (int)$db['ledger_account']['auto_id'];
							$name = $db['ledger_account']['ledger_name'];

							?>
							<option value="<?php echo $g_id; ?>"><?php echo $name; ?></option>
							<?php }} ?>
							</select>
							<label id="ex"></label>
							</td>
							</tr>



							
							<tr>
							<td valign="top"><br>
							<label class="" style="font-size:14px;">Date of Invoice</label>
							</td>
							<td valign="top"><br>
							<input type="text" class="date-picker m-wrap medium" data-date-format="dd-mm-yyyy" name="invoice_date" id="date">
							<label id="date"></label>
							</td>
							</tr>	
		
		
							<tr>
							<td valign="top"><br>
							<label class="" style="font-size:14px;">Invoice Reference</label>
							</td>
							<td valign="top"><br>
							<input type="text" class="m-wrap medium"  name="invoice_reference" id="ref">
							<label id="ref"></label>
							</td>
							</tr>

		
							
							<tr>
							<td valign="top"><br>
							<label class="" style="font-size:14px;">Payment Due Date </label>
							</td>
							<td valign="top"><br>
							<input type="text" class="date-picker m-wrap medium" data-date-format="dd-mm-yyyy" name="due_date" id="due">
							<label id="due"></label>
							</td>
							</tr>
		
		
		

							<tr>
							<td valign="top"><br>
							<label class="" style="font-size:14px;">Party Account Head</label>
							</td>
							<td valign="top"><br>
							<select name="party_head" class="m-wrap medium chosen" id="ph">
							<option value=""></option>
							<?php
							foreach ($cursor2 as $collection)
							{
							$id = $collection['ledger_sub_account']['auto_id'];
							$name = $collection['ledger_sub_account']['name']; 
							?>                             
							<option value="<?php echo $id; ?>"><?php echo $name; ?></option>
							<?php } ?>
							</select>
							<label id="ph"></label>
							</td>
							</tr>

		
		

							<tr>
							<td valign="top"><br>
							<label class="" style="font-size:14px;">Posting Date</label>
							</td>
							<td valign="top"><br>
							<input type="text" class="date-picker m-wrap medium" data-date-format="dd-mm-yyyy" name="posting_date" id="pd">
							<label id="pd"></label>
                            <div id="result11"></div>
							</td>
							</tr>

							
							<tr>
							<td valign="top"><br>
							<label class="" style="font-size:14px;">Amount of Invoice</label>
							</td>
							<td valign="top"><br>
							<input type="text" class="m-wrap medium"   name="invoice_amount" id="ia">
							<label id="ia"></label>
							</td>
							</tr>
							
							
							<tr>
							<td valign="top"><br>
							<label class="" style="font-size:14px;">Description</label>
							</td>
							<td valign="top"><br>
							<textarea  rows="4" name="description" class="m-wrap medium" style="resize:none;" id="des"></textarea>
							<label id="des"></label>
							</td>
							</tr>
							
							


							<tr>
							<td><br>
							<label class="" style="font-size:14px;">Attachment</label>
							</td>
							<td><br>

							<div class="fileupload fileupload-new" data-provides="fileupload"><input type="hidden" value="" name="">
							<span class="btn btn-file">
							<span class="fileupload-new">Select file</span>
							<span class="fileupload-exists">Change</span>
							<input type="file" class="default" name="uploaded">
							</span>
							<span class="fileupload-preview"></span>
							<a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none"></a>
							</div>

							</td>
							</tr>

							
		
		
		</table>
		<br><Br>
		<div class="form-actions" style="background-color:#CCC;">
		<button type="submit" class="btn green" name="ext_add" value="xyz" id="vali">Submit</button>
	    <a href="expense_tracker_add" class="btn">Reset</a>
		</div>
		</center>
		</form>



		</div>
		</div>


<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
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
	      ex_head: {
	       
	        required: true
	      },
		  
		  
		  invoice_date: {
	       
	        required: true
	      },
		  
		   invoice_reference: {
	       
	        required: true
	      },
		  
		  
		  
		   due_date: {
	       
	        required: true
	      },
		 
		    party_head: {
	       
	        required: true
	      },

	     posting_date: {
	       
	        required: true
	      },
		
		 invoice_amount: {
	       
	        required: true
	      },
		  
		   description: {
	       
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
		var date1 = document.getElementById("pd").value;
		
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
		   

















