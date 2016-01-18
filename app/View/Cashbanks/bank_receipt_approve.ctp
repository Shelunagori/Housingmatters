
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
<a href="<?php echo $webroot_path; ?>Cashbanks/bank_receipt_deposit_slip" class="btn" rel='tab'>Deposit Slip</a>
<a href="<?php echo $webroot_path; ?>Cashbanks/bank_receipt_approve" class="btn yellow" rel='tab'>Approve Receipts</a>
<?php } ?>
</div>
</center>
<br>
<style>
<?php	
$nnn=55;
foreach ($cursor1 as $collection) 
{
$nnn = 555;
}
?>








 #bg_color th{
	font-size: 10px !important;background-color:#C8EFCE;padding:2px;border:solid 1px #55965F;
}
#report_tb td{
	padding:2px;
	font-size: 12px;border:solid 1px #55965F;
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


<?php if($nnn == 555)
{
	?>
<table  width="100%" style=" background-color:white;" id="report_tb">
<thead>
<tr id="bg_color">
<th>Sr#</th>
<th>Receipt Date </th>
<th>Receipt Type</th>
<th>Party Name</th>
<th>Payment Mode</th>
<th>Instrument/UTR</th>
<th>Deposit Bank</th>
<th>Narration</th>
<th>Amount</th>
<th class="hide_at_print">Action</th> 
</tr>
</thead>
<tbody id="table">

		<?php
        	$total_credit = 0;
        	$total_debit = 0;
       		 $n=0;
        	foreach ($cursor1 as $collection) 
        	{
       	 	$n++;
        	
        	$receipt_mode = $collection['my_flat_receipt_update']['receipt_mode'];
        	$TransactionDate = $collection['my_flat_receipt_update']['receipt_date'];
			$transaction_id = $collection['my_flat_receipt_update']['auto_id'];
			$bill_one_time_id = @$collection['my_flat_receipt_update']['bill_one_time_id'];
			$deposit_status = (int)@$collection['my_flat_receipt_update']['deposit_status']; 			
            $current_date = $collection['my_flat_receipt_update']['current_date']; 			
            $current_datttt = date('d-m-Y',strtotime($current_date));
            $creater_user_id =(int)@$collection['my_flat_receipt_update']['prepaired_by'];
			
$user_dataaaa = $this->requestAction(array('controller' => 'hms', 'action' => 'user_fetch'),array('pass'=>array($creater_user_id)));
foreach ($user_dataaaa as $user_detailll) 
{
$creater_name = $user_detailll['user']['user_name'];
}	
			
			if($receipt_mode == "Cheque")
					{
						$reference_utr = $collection['my_flat_receipt_update']['cheque_number'];
						$cheque_date = $collection['my_flat_receipt_update']['cheque_date'];
						$drawn_on_which_bank = $collection['my_flat_receipt_update']['drawn_on_which_bank'];
					}
					else
					{
						$reference_utr = $collection['my_flat_receipt_update']['reference_utr'];
						$cheque_date = $collection['my_flat_receipt_update']['cheque_date'];
					}
						$member_type = $collection['my_flat_receipt_update']['member_type'];
						$narration = @$collection['my_flat_receipt_update']['narration'];
				if($member_type == 1)
   				{
					$party_name_id = (int)$collection['my_flat_receipt_update']['flat_id'];
					$receipt_type = $collection['my_flat_receipt_update']['receipt_type'];
			
			    if($receipt_type == 1)
				{
				$receipt_tppp = "Maintenance";	
				}
				else
				{
				$receipt_tppp = "Other";	
				}
			
			
			
$flatt_datta = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($party_name_id)));
foreach ($flatt_datta as $fltt_datttaa) 
{
$wnngg_idddd = (int)$fltt_datttaa['flat']['wing_id'];
}			
		
$user_fetch = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_user_info_via_flat_id'),array('pass'=>array($wnngg_idddd,$party_name_id)));	
			foreach($user_fetch as $rrr)
			{
				$party_name = $rrr['user']['user_name'];	
				$wing_id = $rrr['user']['wing'];
			}
			
		$wing_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat_new'),array('pass'=>array($wing_id,$party_name_id)));
		}
				else
				{
				$receipt_tppp = "Non-Residential";	
				$wing_flat = "";
				$party_name_id = (int)$collection['new_cash_bank']['party_name_id'];
				
$ledger_subaccc = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($party_name_id)));
foreach ($ledger_subaccc as $dataaa) 
{
$party_name = $dataaa['ledger_sub_account']['name'];
}	
				
				
				$bill_reference = @$collection['my_flat_receipt_update']['bill_reference'];	
				}
				$amount=$collection['my_flat_receipt_update']['amount'];
				$flat_id = $collection['my_flat_receipt_update']['flat_id'];
				$deposited_bank_id = (int)$collection['my_flat_receipt_update']['deposited_bank_id'];
				$current_date = $collection['my_flat_receipt_update']['current_date'];
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
			
		if($s_role_id == 3)
		{
			$TransactionDate = date('d-m-Y',strtotime($TransactionDate));
			$total_debit =  $total_debit + $amount; 
		if(empty($reference_utr))
		{
			$reference_utr = $reference_utr;
		}
?>
<tr <?php if($deposit_status == 1) { ?> style="background-color:#E8EAE8;"  <?php } ?> >
<td><?php echo $n; ?> </td>
<td><?php echo $TransactionDate; ?></td>
<td><?php echo $receipt_tppp; ?></td>
<td><?php echo $party_name; ?>&nbsp;(<?php echo $wing_flat; ?>)</td>
<td><?php echo $receipt_mode; ?> - <?php echo @$drawn_on_which_bank; ?></td>
<td><?php echo @$reference_utr; ?> </td>
<td><?php echo $deposited_bank_name; ?>&nbsp;(<?php echo $bank_account; ?>)</td>
<td><?php echo $narration; ?> </td>
<td align='right'>
<?php 
if(!empty($amount))
{
$amount = number_format($amount);
}
echo $amount; ?></td>
<td class="hide_at_print">
<a href="bank_receipt_approve?aa=<?php echo $transaction_id; ?>" class="btn mini red">Approve</a>
<a href="aprrove_bank_receipt_update?bb=<?php echo $transaction_id; ?>" class="btn mini blue">Edit</a>
</td>
</tr>
<?php	
}		 
}

?>
<tr>
<td colspan="8" style="text-align:right;"><b>Total</b></td>
<td align="right"><b><?php 
$total_debit = number_format($total_debit);
echo $total_debit; ?> <?php //echo "  dr"; ?></b></td>
<td class="hide_at_print"></td>
</tr>
</tbody>										 
</table> 

<?php } else {
	?>
	<center>
	<br><br>
<h3>No Receipt Found for Approval</h4>
</center>
	<?php
	
}






