

<?php
foreach($cursor1 as $dataaa)
{
$transaction_id = (int)$dataaa['my_flat_receipt_update']['auto_id'];	
$transaction_date = $dataaa['my_flat_receipt_update']['receipt_date'];	
$deposited_in = (int)$dataaa['my_flat_receipt_update']['deposited_bank_id'];	
$receipt_mode = $dataaa['my_flat_receipt_update']['receipt_mode'];
if($receipt_mode == "Cheque")
{
$cheque_number = $dataaa['my_flat_receipt_update']['cheque_number'];	
$cheque_date = $dataaa['my_flat_receipt_update']['cheque_date'];
$drawn_bank_name = $dataaa['my_flat_receipt_update']['drawn_on_which_bank'];
$branch = $dataaa['my_flat_receipt_update']['bank_branch'];
}
else
{
$cheque_number = $dataaa['my_flat_receipt_update']['reference_utr'];	
$cheque_date = $dataaa['my_flat_receipt_update']['cheque_date'];	
}	
$flat_id = (int)$dataaa['my_flat_receipt_update']['flat_id'];
$amount = $dataaa['my_flat_receipt_update']['amount'];
$narration = $dataaa['my_flat_receipt_update']['narration'];
}
?>

<form method="POST">
<div class="portlet box blue">
<div class="portlet-title">
<h4 class="block">Update Bank Receipt</h4>
</div>
<div class="portlet-body form">
<div id="validdn"></div>                 
<table class="table table-hover" style="background-color:#CDE9FE;" id="main_table">
<tr>
<td style="border:solid 1px blue;">                    
                        
                        
<table class="table table-bordered" id="sub_table">
					 <tr style="background-color:#E8EAE8;">
							<th style="width:13%;">Transaction Date</th>
							<th style="width:17%;">Deposited In</th>
							<th style="width:20%;">Receipt Mode</th>
							<th style="width:15%;">Cheque/UTR Ref</th>
							<th style="width:15%;">Date</th>
							<th style="width:20%;">Drawn on which bank</th>
					 </tr>
	  <tr style="background-color:#E8F3FF;">
					  
					  <td>
					  <input type="text" class="date-picker m-wrap span12" 
					  data-date-format="dd-mm-yyyy" style="background-color:white !important; margin-top:3px;" 
					  value="<?php echo $transaction_date; ?>">
					  </td>
							  
							  
						<td>
						<select class="span12 m-wrap chosen">
						<option value="" style="display:none;">Select Bank</option>    
						<?php
						foreach ($bank_detail as $db) 
						{
						$bank_id = (int)$db['ledger_sub_account']["auto_id"];
						$bank_ac = $db['ledger_sub_account']["name"];
						$bank_account_number = $db['ledger_sub_account']["bank_account"];
						?>
						<option value="<?php echo $bank_id; ?>" <?php if($deposited_in == $bank_id){?> selected="selected" <?php } ?>><?php echo $bank_ac; ?> &nbsp;(<?php echo $bank_account_number; ?>)</option>
						<?php } ?>
						</select>
						</td>
						
						
						<td>
						<select class="span12 m-wrap chosen" onchange="receipt_mode(this.value)">
						<option value="" style="display:none;">receipt mode</option>    
						<option value="Cheque" <?php if($receipt_mode == "Cheque") { ?> selected="selected" <?php } ?>>Cheque</option>
						<option value="NEFT" <?php if($receipt_mode == "NEFT") { ?> selected="selected" <?php } ?>>NEFT</option>
						<option value="PG" <?php if($receipt_mode == "PG") { ?> selected="selected" <?php } ?>>PG</option>
						</select>
						</td>
	
						  
		<td>
		<input type="text" placeholder="Cheque No." class="m-wrap span12" 
		id="chhno1" style="background-color:#FFF !important; margin-top:3px;" value="<?php echo $cheque_number; ?>">
		</td>
						
			
				
		<td>
		<input type="text" class="date-picker m-wrap span12" data-date-format="dd-mm-yyyy" 
		placeholder="Date" style="background-color:#FFF !important; margin-top:3px;" value="<?php echo $cheque_date; ?>"/>
		</td>

				
			

  			  
	<td>
	<input type="text" class="m-wrap span12" placeholder="Drawn on which bank?" 
	style="background-color:#FFF !important; margin-top:3px;" data-provide="typeahead" 
	data-source="[<?php if(!empty($kendo_implode)) { echo $kendo_implode; } ?>]" id="bnkkk" value="<?php echo @$drawn_bank_name; ?>" <?php if($receipt_mode != "Cheque") { ?> readonly="readonly" <?php } ?>>
	</td>
				 </tr>
				 
				 <tr style="background-color:#E8EAE8;">
				    <th>Branch</th>
                    <th>Received From</th>
		            <th>Select Resident</th>
		            <th>Receipt Type</th>
		            <th>Amount (Rupees)</th>
                    <th>Narration</th>
				 </tr>
				
				 <tr style="background-color:#E8F3FF;">
					
<td>
<input type="text" class="m-wrap span12" placeholder="Branch of Bank" 
style="background-color:#FFF !important; margin-top:3px;" data-provide="typeahead" 
data-source="[<?php if(!empty($kendo_implode2)) { echo $kendo_implode2; } ?>]" id="branchh" value="<?php echo @$branch; ?>" <?php if($receipt_mode != "Cheque") { ?> readonly="readonly" <?php } ?>>
</td>
					
					<td>
					<select class="span12 m-wrap" disabled="disabled">
					<option value="" style="display:none;">received from</option>    
					<option value="1" selected="selected">Residential</option>
					<option value="2">Non-Residential</option>
					</select>
				    </td>
										 
					<td>
					
					<select class="m-wrap span12" disabled="disabled">
					<option value="" style="display:none;">Select</option>
					<?php
					foreach($ledger_sub_account_data as $data)
					{
					 $flatt_iddd = "";
									 
						
					$flat_iddd = (int)$data['ledger_sub_account']['flat_id'];	
					$resident_name = $data['ledger_sub_account']['name'];
                    $user_id = (int)$data['ledger_sub_account']['user_id'];
					
					$wing_detailll = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($flat_iddd)));
					foreach($wing_detailll as $wing_dataaa)
					{
					$wing_idddd = (int)$wing_dataaa['flat']['wing_id'];	
					}
					$wing_flat= $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat_new'),array('pass'=>array($wing_idddd,$flat_iddd)));
					
					?>
					<option value="<?php echo $flat_iddd; ?>" <?php if($flat_id == $flat_iddd) { ?> selected="selected"<?php } ?>><?php echo $resident_name; ?> <?php echo $wing_flat; ?></option>
					<?php
					
					}
					?>
					</select>
							
				</td>
								 
				<td>
				<select class="m-wrap span12" disabled="disabled">
				<option value="" style="display:none;">Select Receipt Type</option>
				<option value="1" selected="selected">Maintanace Receipt</option>
				<option value="2">Other Receipt</option>
				</select>
				</td>
								 
				 <td>
				 <input type="text" class="m-wrap span12"  
				 style="text-align:right; background-color:#FFF !important; margin-top:3px;"
				 maxlength="10" value="<?php echo $amount; ?>"/>
				 </td>
								 
				 <td>
				 <input type="text" class="m-wrap span12" style="background-color:#FFF !important; margin-top:3px;" value="<?php echo @$narration; ?>"/>
				 </td>
				 
				 </tr>
			</table>
						
						
</td>
</tr>						
</table>
<input type="hidden" value="<?php echo $transaction_id; ?>" id="trans_id">
<div class="form-actions">
<a href="bank_receipt_approve" class="btn green"><i class="icon-arrow-left"></i> back</a>
<button type="submit" class="btn green">Update Receipt</button>
</div>
</div>
</div>

</form>


<script>
$(document).ready(function() { 
	$('form').submit(function(ev){
	ev.preventDefault();
	
	 var ar = [];
	 
	 var transaction_id = $('#trans_id').val();
	
		var transaction_date = $("#main_table tr:nth-child(1) td:nth-child(1) #sub_table tr:nth-child(2) td:nth-child(1) input").val();
	  	var bank_id = $("#main_table tr:nth-child(1) td:nth-child(1) #sub_table tr:nth-child(2) td:nth-child(2) select").val();
		var mode = $("#main_table tr:nth-child(1) td:nth-child(1) #sub_table tr:nth-child(2) td:nth-child(3) select").val();
			
			if(mode == "Cheque")
			{
	var cheque_no = $("#main_table tr:nth-child(1) td:nth-child(1) #sub_table tr:nth-child(2) td:nth-child(4) input").val();
	var cheque_date = $("#main_table tr:nth-child(1) td:nth-child(1) #sub_table tr:nth-child(2) td:nth-child(5) input").val();
	var drawn_bank = $("#main_table tr:nth-child(1) td:nth-child(1) #sub_table tr:nth-child(2) td:nth-child(6) input").val();
	var branch = $("#main_table tr:nth-child(1) td:nth-child(1) #sub_table tr:nth-child(4) td:nth-child(1) input").val();
			}
			else
			{
			var utr = $("#main_table tr:nth-child(1) td:nth-child(1) #sub_table tr:nth-child(2) td:nth-child(4) input").val();	
			var date = $("#main_table tr:nth-child(1) td:nth-child(1) #sub_table tr:nth-child(2) td:nth-child(5) input").val();
			}
	var flat_id = $("#main_table tr:nth-child(1) td:nth-child(1) #sub_table tr:nth-child(4) td:nth-child(3) select").val();
	var amount = $("#main_table tr:nth-child(1) td:nth-child(1) #sub_table tr:nth-child(4) td:nth-child(5) input").val();
	var narration = $("#main_table tr:nth-child(1) td:nth-child(1) #sub_table tr:nth-child(4) td:nth-child(6) input").val();
	
ar.push([transaction_date,mode,cheque_no,cheque_date,drawn_bank,branch,date,utr,amount,narration,bank_id,flat_id,transaction_id]);	
	
	var myJsonString = JSON.stringify(ar);
			$.ajax({
			url: "approve_receipt_update_json?q="+myJsonString,
			dataType:'json',
			}).done(function(response){
		if(response.type == 'error'){
		$("#validdn").html('<div class="alert alert-error" style="color:red;">'+response.text+'</div>');
		}
		if(response.type == 'success'){
		$("#shwd").show();

		}
	
	});
	});
});
/*
$(document).ready(function() { 
	$('form').submit(function(ev){
	alert();
	ev.preventDefault();
		
		var ar = [];
		var transaction_date = $("#main_table tr:nth-child(1) td:nth-child(1) #sub_table tr:nth-child(2) td:nth-child(1) input").val();
	  	var bank_id = $("#main_table tr:nth-child(1) td:nth-child(1) #sub_table tr:nth-child(2) td:nth-child(2) select").val();
		var mode = $("#main_table tr:nth-child(1) td:nth-child(1) #sub_table tr:nth-child(2) td:nth-child(3) select").val();
			
			if(mode == "Cheque")
			{
	var cheque_no = $("#main_table tr:nth-child(1) td:nth-child(1) #sub_table tr:nth-child(2) td:nth-child(4) input").val();
	var cheque_date = $("#main_table tr:nth-child(1) td:nth-child(1) #sub_table tr:nth-child(2) td:nth-child(5) input").val();
	var drawn_bank = $("#main_table tr:nth-child(1) td:nth-child(1) #sub_table tr:nth-child(2) td:nth-child(6) input").val();
	var branch = $("#main_table tr:nth-child(1) td:nth-child(1) #sub_table tr:nth-child(4) td:nth-child(1) input").val();
			}
			else
			{
			var utr = $("#main_table tr:nth-child(1) td:nth-child(1) #sub_table tr:nth-child(2) td:nth-child(4) input").val();	
			var date = $("#main_table tr:nth-child(1) td:nth-child(1) #sub_table tr:nth-child(2) td:nth-child(5) input").val();
			}
	var flat_id = $("#main_table tr:nth-child(1) td:nth-child(1) #sub_table tr:nth-child(4) td:nth-child(3) select").val();
	var amount = $("#main_table tr:nth-child(1) td:nth-child(1) #sub_table tr:nth-child(4) td:nth-child(5) input").val();
	var narration = $("#main_table tr:nth-child(1) td:nth-child(1) #sub_table tr:nth-child(4) td:nth-child(6) input").val();
		
ar.push([transaction_date,mode,cheque_no,cheque_date,drawn_bank,branch,date,utr,amount,narration,bank_id,flat_id]);
		
		
		
		var myJsonString = JSON.stringify(ar);
			$.ajax({
			url: "<?php echo $webroot_path; ?>Cashbanks/approve_receipt_update_json?q="+myJsonString,
			dataType:'json',
			}).done(function(response){
				//alert(response);
				if(response.type == 'error'){
			
			 $("#validdn").html('<div class="alert alert-error" style="color:red;">'+response.text+'</div>');
			}
		    if(response.type == 'success'){
			  $("#shwd").show();
			 
			}
});			
});
});
*/
</script>	

<script>
function receipt_mode(value)
{
	
		if(value == "Cheque")	
		{
		$("#bnkkk").removeAttr("readonly","readonly");
		$("#branchh").removeAttr("readonly","readonly");		
		}
		else
		{
		$("#bnkkk").attr("readonly","readonly");
		$("#branchh").attr("readonly","readonly");	
		$("#bnkkk").val("");
		$("#branchh").val("");
		}	
}

</script>

<div id="shwd" class="hide">
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body">
<h4><b>Thank You!</b></h4>
<p>The Rceipt is Updated Successfully</p>
</div>
<div class="modal-footer">
<a href="bank_receipt_approve" class="btn red" rel='tab'>OK</a>
</div>
</div>
</div> 




