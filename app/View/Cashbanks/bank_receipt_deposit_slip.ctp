<style>
#tbb th{
	font-size: 10px !important;background-color:#C8EFCE;padding:2px;border:solid 1px #55965F; 
}
#tbb td{
	
	font-size: 10px;border:solid 1px #55965F; 
}
.text_bx{
	width: 50px;
	height: 15px !important;
	margin-bottom: 0px !important;
	font-size: 12px;
}
.text_rdoff{
	width: 50px;
	height: 15px !important;
	border: none !important;
	margin-bottom: 0px !important;
	font-size: 12px;
}
</style>

<div class="hide_at_print">
<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>				   
<script>
$(document).ready(function() {
$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script> 
</div>
<center>  
<div class="hide_at_print">            
<?php
if($s_role_id == 3)
{
?>              
<a href="<?php echo $webroot_path; ?>Cashbanks/new_bank_receipt" class="btn" rel='tab'>Create</a>
<a href="<?php echo $webroot_path; ?>Cashbanks/bank_receipt_view" class="btn" rel='tab'>View</a>
<a href="<?php echo $webroot_path; ?>Cashbanks/bank_receipt_deposit_slip" class="btn yellow" rel='tab'>Deposit Slip</a>
<a href="<?php echo $webroot_path; ?>Cashbanks/bank_receipt_approve" class="btn" rel='tab'>Approve Receipts</a>
<?php } ?>
</div>
</center>
<?php
$nnn = 55;
foreach($cursor1 as $collection)
{
$receipt_mode = $collection['new_cash_bank']['receipt_mode'];
if($receipt_mode == "Cheque")
{	
$nnn = 555;
}		
}	

?>
                  

<?php
if($nnn == 555)
{
?>
<form method="post">
<div class="portlet box blue">
<div class="portlet-title">
<h4 class="block">Generate Deposit Slip</h4>
</div>
<div class="portlet-body form">

<table id="tbb" style="width:100%;">
<tr>
<th>Receipt Date</th>
<th>Receipt No.</th>
<th>Party Name</th>
<th>Deposited In</th>
<th>Cheque Number</th>
<th>Cheque Date</th>
<th>Drawn Bank Name</th>
<th>Amount</th>
<th>
<label class="checkbox">
<div class="checker" id="uniform-undefined"><span><input type="checkbox" value="" style="opacity: 0;" onclick="allchkk()" id="chhkk"></span></div>
</label>
</th>
</tr>
<?php
		$total_credit = 0;
		$total_debit = 0;
		$n=0;
		foreach($cursor1 as $collection)
		{
      	 	$n++;
        	$receipt_no = $collection['new_cash_bank']['receipt_id'];
        	$receipt_mode = $collection['new_cash_bank']['receipt_mode'];
        	$TransactionDate = $collection['new_cash_bank']['receipt_date'];
			$transaction_id = (int)$collection['new_cash_bank']['transaction_id'];
			$bill_one_time_id = @$collection['new_cash_bank']['bill_one_time_id'];
			$receipt_date = $collection['new_cash_bank']['receipt_date'];
			$deposit_status = (int)@$collection['new_cash_bank']['deposit_status'];	
					
				if($receipt_mode == "Cheque")
				{
				$cheque_number = $collection['new_cash_bank']['cheque_number'];
				$cheque_date = $collection['new_cash_bank']['cheque_date'];
				$drawn_on_which_bank = $collection['new_cash_bank']['drawn_on_which_bank'];
				}
				else
				{
				$reference_utr = $collection['new_cash_bank']['reference_utr'];
				$cheque_date = $collection['new_cash_bank']['cheque_date'];
				}
					$member_type = $collection['new_cash_bank']['member_type'];
					$narration = @$collection['new_cash_bank']['narration'];
					if($member_type == 1)
					{
					$party_name_id = (int)$collection['new_cash_bank']['flat_id'];
					$receipt_type = $collection['new_cash_bank']['receipt_type'];
			
			
				$flatt_datta = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($party_name_id)));
				foreach ($flatt_datta as $fltt_datttaa) 
				{
				$wnngg_idddd = (int)$fltt_datttaa['flat']['wing_id'];
				}			
		
			$user_fetch = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_user_info_via_flat_id'),array(				'pass'=>array($wnngg_idddd,$party_name_id)));	
			foreach($user_fetch as $rrr)
			{
			$party_name = $rrr['user']['user_name'];	
			$wing_id = $rrr['user']['wing'];
			}
			
$wing_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat_new'),array('pass'=>array($wing_id,$party_name_id)));
}
		else
		{
			$wing_flat = "";
			$party_name = $collection['new_cash_bank']['party_name_id'];
			$bill_reference = @$collection['new_cash_bank']['bill_reference'];	
		}
			$amount=$collection['new_cash_bank']['amount'];
			$flat_id = $collection['new_cash_bank']['flat_id'];
			$deposited_bank_id = (int)$collection['new_cash_bank']['deposited_bank_id'];
			$current_date = $collection['new_cash_bank']['current_date'];
		if($receipt_mode == "Cheque")
		{
		$receipt_mode = $receipt_mode;
		}
			
			
			$ledger_sub_account_fetch_result = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($deposited_bank_id)));			
			foreach($ledger_sub_account_fetch_result as $rrrr)
			{
				$deposited_bank_name = $rrrr['ledger_sub_account']['name'];
                $bank_account = $rrrr['ledger_sub_account']['bank_account'];				
			}			
			
		
			$TransactionDate = date('d-m-Y',$TransactionDate);
			//$total_debit =  $total_debit + $amount; 
$receipt_date = date('d-m-Y',($receipt_date));		
if($receipt_mode == "Cheque")
{
$total_debit =  $total_debit + $amount; 

if($deposit_status != 1)
{
?>
<tr>
<td><?php echo $receipt_date; ?></td>
<td><?php echo $receipt_no; ?></td>
<td><?php echo $party_name; ?> &nbsp;&nbsp; <?php echo $wing_flat; ?></td>
<td><?php echo $deposited_bank_name; ?>&nbsp;(<?php echo $bank_account; ?>)</td>
<td><?php echo $cheque_number; ?></td>
<td><?php echo $cheque_date; ?></td>
<td><?php echo $drawn_on_which_bank; ?></td>
<td style="text-align:right;"><?php $amount2 = number_format($amount); echo $amount2; ?></td>
<td style="text-align:center;">
<label class="checkbox">
<div class="checker" id="uniform-undefined"><span>
<input type="checkbox" value="<?php echo $transaction_id; ?>" style="opacity: 0;" class="dep" name="dd<?php echo $transaction_id; ?>"></span></div>
</label>
</td>
</tr>
<?php
}
}
}
?>
<?php 
foreach($cursor2 as $collection)
		{
      	 	$n++;
        	$receipt_no = $collection['new_cash_bank']['receipt_id'];
        	$receipt_mode = $collection['new_cash_bank']['receipt_mode'];
        	$TransactionDate = $collection['new_cash_bank']['receipt_date'];
			$transaction_id = (int)$collection['new_cash_bank']['transaction_id'];
			$bill_one_time_id = @$collection['new_cash_bank']['bill_one_time_id'];
			$receipt_date = $collection['new_cash_bank']['receipt_date'];
			$deposit_status = (int)@$collection['new_cash_bank']['deposit_status'];	
					
				if($receipt_mode == "Cheque")
				{
				$cheque_number = $collection['new_cash_bank']['cheque_number'];
				$cheque_date = $collection['new_cash_bank']['cheque_date'];
				$drawn_on_which_bank = $collection['new_cash_bank']['drawn_on_which_bank'];
				}
				else
				{
				$reference_utr = $collection['new_cash_bank']['reference_utr'];
				$cheque_date = $collection['new_cash_bank']['cheque_date'];
				}
					$member_type = $collection['new_cash_bank']['member_type'];
					$narration = @$collection['new_cash_bank']['narration'];
					if($member_type == 1)
					{
					$party_name_id = (int)$collection['new_cash_bank']['flat_id'];
					$receipt_type = $collection['new_cash_bank']['receipt_type'];
			
			
				$flatt_datta = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($party_name_id)));
				foreach ($flatt_datta as $fltt_datttaa) 
				{
				$wnngg_idddd = (int)$fltt_datttaa['flat']['wing_id'];
				}			
		
			$user_fetch = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_user_info_via_flat_id'),array(				'pass'=>array($wnngg_idddd,$party_name_id)));	
			foreach($user_fetch as $rrr)
			{
			$party_name = $rrr['user']['user_name'];	
			$wing_id = $rrr['user']['wing'];
			}
			
$wing_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat_new'),array('pass'=>array($wing_id,$party_name_id)));
}
		else
		{
			$wing_flat = "";
			$party_name = $collection['new_cash_bank']['party_name_id'];
			$bill_reference = @$collection['new_cash_bank']['bill_reference'];	
		}
			$amount=$collection['new_cash_bank']['amount'];
			$flat_id = $collection['new_cash_bank']['flat_id'];
			$deposited_bank_id = (int)$collection['new_cash_bank']['deposited_bank_id'];
			$current_date = $collection['new_cash_bank']['current_date'];
		if($receipt_mode == "Cheque")
		{
		$receipt_mode = $receipt_mode;
		}
			
			
			$ledger_sub_account_fetch_result = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($deposited_bank_id)));			
			foreach($ledger_sub_account_fetch_result as $rrrr)
			{
				$deposited_bank_name = $rrrr['ledger_sub_account']['name'];
                $bank_account = $rrrr['ledger_sub_account']['bank_account'];				
			}			
			
		
			$TransactionDate = date('d-m-Y',$TransactionDate);
			//$total_debit =  $total_debit + $amount; 
$receipt_date = date('d-m-Y',($receipt_date));		
if($receipt_mode == "Cheque")
{
$total_debit =  $total_debit + $amount; 

if($deposit_status == 1)
{
?>
<tr  style="background-color:#E8EAE8;">
<td><?php echo $receipt_date; ?></td>
<td><?php echo $receipt_no; ?></td>
<td><?php echo $party_name; ?> &nbsp;&nbsp; <?php echo $wing_flat; ?></td>
<td><?php echo $deposited_bank_name; ?>&nbsp;(<?php echo $bank_account; ?>)</td>
<td><?php echo $cheque_number; ?></td>
<td><?php echo $cheque_date; ?></td>
<td><?php echo $drawn_on_which_bank; ?></td>
<td style="text-align:right;"><?php $amount2 = number_format($amount); echo $amount2; ?></td>
<td style="text-align:center;">
<label class="checkbox">
<div class="checker" id="uniform-undefined"><span>
<input type="checkbox" value="<?php echo $transaction_id; ?>" style="opacity: 0;" class="dep" name="dd<?php echo $transaction_id; ?>"></span></div>
</label>
</td>
</tr>
<?php
}
}
}
?>
<tr>
<td style="text-align:right;" colspan="7"><b>Total</b></td>
<td style="text-align:right;"><b><?php $total2 = number_format($total_debit); echo $total2; ?></b></td>
<td></td>
</tr>

</table>


<br />


<div class="form-actions">
<button type="submit" name="dep_slip" class="btn green" style="margin-left:75%;">Generate Deposit Slip</button>
</div>
                        
                        
	</div>
	</div>
<?php } else { ?>
<center>
<br><br>
<h3>No Receipt Found for Deposit Slip</h3>
</center>
<?php } ?>
<script>
function allchkk()
{
if($("#chhkk").is(":checked")==true){
			$(".dep").parent('span').addClass('checked');
			$(".dep").prop('checked',true);
		}else{
			$(".dep").parent('span').removeClass('checked');
			$(".dep").prop('checked',false);
		}
		
}
</script>


