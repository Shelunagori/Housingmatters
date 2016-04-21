<?php
foreach($bank_receipt_detail as $bank_receipt_dataaa)
{
$transaction_id = (int)$bank_receipt_dataaa['new_cash_bank']['transaction_id'];
$transaction_date = $bank_receipt_dataaa['new_cash_bank']['receipt_date'];
$deposited_bank_id = (int)$bank_receipt_dataaa['new_cash_bank']['deposited_bank_id'];	
$receipt_mode = $bank_receipt_dataaa['new_cash_bank']['receipt_mode'];	
if($receipt_mode == "Cheque" || $receipt_mode == "cheque")
{
$cheque_number = $bank_receipt_dataaa['new_cash_bank']['cheque_number'];
$cheque_date = $bank_receipt_dataaa['new_cash_bank']['cheque_date'];
$drawn_bank_name = $bank_receipt_dataaa['new_cash_bank']['drawn_on_which_bank'];
$branch = $bank_receipt_dataaa['new_cash_bank']['bank_branch'];
}
else
{
$cheque_number = $bank_receipt_dataaa['new_cash_bank']['reference_utr'];	
$cheque_date = $bank_receipt_dataaa['new_cash_bank']['cheque_date'];
}
$flat_id = (int)$bank_receipt_dataaa['new_cash_bank']['flat_id'];
$receipt_type = (int)$bank_receipt_dataaa['new_cash_bank']['receipt_type'];
$amount = $bank_receipt_dataaa['new_cash_bank']['amount'];
$narration = $bank_receipt_dataaa['new_cash_bank']['narration'];

}
@$transaction_date = date('d-m-Y',$transaction_date);
?>
<a href="" rel="tab" class="btn green"><i class="icon-arrow-left"></i> Back</a>
<br>
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
						<select class="span12 m-wrap" disabled="disabled">
						<option value="" style="display:none;">Select Bank</option>    
						<?php
						foreach ($bank_detail as $db) 
						{
						$bank_id = (int)$db['ledger_sub_account']["auto_id"];
						$bank_ac = $db['ledger_sub_account']["name"];
						$bank_account_number = $db['ledger_sub_account']["bank_account"];
						?>
						<option value="<?php echo $bank_id; ?>" <?php if($bank_id == $deposited_bank_id) { ?> selected="selected" <?php } ?>><?php echo $bank_ac; ?> &nbsp;(<?php echo $bank_account_number; ?>)</option>
						<?php } ?>
						</select>
						</td>
						
						
						<td>
						<select class="span12 m-wrap chosen">
						<option value="" style="display:none;">receipt mode</option>    
						<option value="Cheque" <?php if($receipt_mode =="Cheque" || $receipt_mode =="cheque") { ?> selected="selected" <?php } ?>>Cheque</option>
						<option value="NEFT" <?php if($receipt_mode =="NEFT") { ?> selected="selected" <?php } ?>>NEFT</option>
						<option value="PG" <?php if($receipt_mode =="PG") { ?> selected="selected" <?php } ?>>PG</option>
						</select>
						</td>
	
			  
						  
		<td>
		<input type="text" placeholder="Cheque No." class="m-wrap span12" 
		id="chhno1" style="background-color:#FFF !important; margin-top:3px;" value="<?php echo $cheque_number; ?>">
		</td>
						
			
				
					<td>
					<input type="text" class="date-picker m-wrap span12" data-date-format="dd-mm-yyyy" 
					placeholder="Date" id="dtt1" style="background-color:#FFF !important; margin-top:3px;" value="<?php echo $cheque_date; ?>"/>
					</td>
							  
							  
					<td>
					<input type="text" class="m-wrap span12" placeholder="Drawn on which bank?" id="bnkkk1" 
					style="background-color:#FFF !important; margin-top:3px;" data-provide="typeahead" 
			   data-source="[<?php if(!empty($kendo_implode)) { echo $kendo_implode; } ?>]" value="<?php echo @$drawn_bank_name; ?>">
					</td>
				 </tr>
				 
				 <tr style="background-color:#E8EAE8;">
				    <th>Branch</th>
                    <th>Received From</th>
		            <th><span id="sel_resdnt1">Select Resident</span><span id="prt_nam1" class="hide">Party Name 
					<a class="btn mini green" style="float:right;" onclick="add_member()"><i class="icon-plus"></i></a></span></th>
		            <th><span id="recet_typp1">Receipt Type</span><span id="refrnc1" class="hide">Bill Reference</span></th>
		            <th>Amount Applied</th>
                    <th>Narration</th>
				 </tr>
				
				 <tr style="background-color:#E8F3FF;">
					
<td>
<input type="text" class="m-wrap span12" placeholder="Branch of Bank" 
id="branchh1" style="background-color:#FFF !important; margin-top:3px;" data-provide="typeahead" 
			   data-source="[<?php if(!empty($kendo_implode2)) { echo $kendo_implode2; } ?>]" value="<?php echo @$branch; ?>">
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
					<?php
					foreach($ledger_sub_account_data as $data)
					{
					$flat_iddd = (int)$data['ledger_sub_account']['flat_id'];	
					$resident_name = $data['ledger_sub_account']['name'];

					$wing_detailll = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($flat_iddd)));
					foreach($wing_detailll as $wing_dataaa)
					{
					$wing_idddd = (int)$wing_dataaa['flat']['wing_id'];	
					}
					$wing_flat= $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat_new'),array('pass'=>array($wing_idddd,$flat_iddd)));
					?>
					<option value="<?php echo $flat_iddd; ?>" <?php if($flat_iddd == $flat_id) { ?> selected="selected" <?php } ?>><?php echo $resident_name; ?> <?php echo $wing_flat; ?></option>
					<?php
					}
					?>
					</select>
							
				</td>
								 
				<td id="bill_refe_type1">
				<select class="m-wrap span12" disabled="disabled">
				<option value="" style="display:none;">Select Receipt Type</option>
				<option value="1" <?php if($receipt_type == 1){ ?> selected="selected" <?php } ?>>Maintanace Receipt</option>
				<option value="2" <?php if($receipt_type == 2){ ?> selected="selected" <?php } ?>>Other Receipt</option>
				</select>
				</td>
								 
				 <td>
				 <input type="text" class="m-wrap span12"  value="<?php echo $amount; ?>"
				 style="text-align:right; background-color:#FFF !important; margin-top:3px;"
				 maxlength="10" />
				 </td>
								 
				 <td>
				 <input type="text" class="m-wrap span12" style="background-color:#FFF !important; margin-top:3px;"  value="<?php echo @$narration; ?>"/>
				 </td>
				 
				 </tr>
			</table>
						
						
</td>
</tr>						
</table>
<div class="form-actions">
<button type="submit" class="btn green" name="my_flat_receipt_update">Update</button>
</div>
</div>
</div>
<input type="hidden" value="<?php echo $transaction_id; ?>" id="unic_id">
<input type="hidden" value="<?php echo $flat_id; ?>" id="flat_id">
</form>








<script>
$(document).ready(function() { 
	$('form').submit( function(ev){
	ev.preventDefault();
		
		var ar = [];
		var unic = $("#unic_id").val();
		var flat = $("#flat_id").val();
		var transaction_date = $("#main_table tr:nth-child(1) td:nth-child(1) #sub_table tr:nth-child(2) td:nth-child(1) input").val();
	  	
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
	var amount = $("#main_table tr:nth-child(1) td:nth-child(1) #sub_table tr:nth-child(4) td:nth-child(5) input").val();
	var narration = $("#main_table tr:nth-child(1) td:nth-child(1) #sub_table tr:nth-child(4) td:nth-child(6) input").val();
		
ar.push([transaction_date,mode,cheque_no,cheque_date,drawn_bank,branch,date,utr,amount,narration,unic,flat]);
		
		
		
		var myJsonString = JSON.stringify(ar);
			$.ajax({
			url: "<?php echo $webroot_path; ?>Accounts/my_flat_receipt_update_json?q="+myJsonString,
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

</script>	

<div id="shwd" class="hide">
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body">
<h4><b>Thank You!</b></h4>
<p>Your Receipt is gone for approval</p>

</div>
<div class="modal-footer">
<a href="<?php echo $webroot_path; ?>Accounts/my_flat_receipt_update" class="btn red" rel='tab'>OK</a>
</div>
</div>
</div> 