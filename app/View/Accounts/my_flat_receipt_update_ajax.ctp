<style>

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
<?php //////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<?php
$nnn = 55;
foreach ($bank_receipt_detail as $collection) 
{
$receipt_date = $collection['new_cash_bank']['receipt_date'];
$nnn = 555;

}			
?>
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<?php
if($nnn == 555)
{
?>

<div style="width:100%; overflow:auto; margin-top:10px;" class="hide_at_print">
<label class="m-wrap pull-right"><input type="text" id="search" class="m-wrap medium" style="background-color:#FFF !important;" placeholder="Search"></label>	
</div>	
<table  width="100%" style=" background-color:white;" id="report_tb">
<thead>
<tr>
</tr>
<tr id="bg_color">
<th>Receipt#</th>
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
        	foreach ($bank_receipt_detail as $collection) 
        	{
       	 	$n++;
        	$receipt_no = $collection['new_cash_bank']['receipt_id'];
        	$receipt_mode = $collection['new_cash_bank']['receipt_mode'];
        	$TransactionDate = $collection['new_cash_bank']['receipt_date'];
			$transaction_id = $collection['new_cash_bank']['transaction_id'];
			$bill_one_time_id = @$collection['new_cash_bank']['bill_one_time_id'];
			$deposit_status = (int)@$collection['new_cash_bank']['deposit_status']; 			
            $current_date = $collection['new_cash_bank']['current_date']; 			
            $current_datttt = date('d-m-Y',strtotime($current_date));
            $creater_user_id =(int)@$collection['new_cash_bank']['prepaired_by'];
			
$user_dataaaa = $this->requestAction(array('controller' => 'hms', 'action' => 'user_fetch'),array('pass'=>array($creater_user_id)));
foreach ($user_dataaaa as $user_detailll) 
{
$creater_name = $user_detailll['user']['user_name'];
}	
			
			if($receipt_mode == "Cheque")
					{
						$reference_utr = $collection['new_cash_bank']['cheque_number'];
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
				$user_id = (int)$rrr['user']['user_id'];
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
			
		if($s_user_id == $user_id)
		{
			$TransactionDate = date('d-m-Y',$TransactionDate);
			$total_debit =  $total_debit + $amount; 
		if(empty($reference_utr))
		{
			$reference_utr = $reference_utr;
		}
?>
<tr <?php if($deposit_status == 1) { ?> style="background-color:#E8EAE8;"  <?php } ?> >
<td><?php echo $receipt_no; ?> </td>
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
	
    <div class="btn-group">
	<a class="btn blue mini" href="#" data-toggle="dropdown">
	<i class="icon-chevron-down"></i>	
	</a><a class="btn tooltips mini black" data-placement="left" data-original-title="Created by: 
	<?php echo $creater_name; ?> on: <?php echo $current_datttt; ?>">!</a>
	<ul class="dropdown-menu" style="min-width:80px !important;">
	<li><a href="my_flat_receipt_update_form/<?php echo $transaction_id; ?>"><i class="icon-search"></i>Update</a></li>
	
	
	</ul>
	</div>
	
								
								
							








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
<?php 
}
if($nnn == 55)
{
?>					 
<br /><br />					 
<center>					 
<h3 style="color:red;"><b>No Record Found in Selected Period</b></h3>				 
</center>					 
<br /><br />					 
<?php
}
?>
			 
	<script>
    var $rows = $('#table tr');
    $('#search').keyup(function() {
    var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
    
    $rows.show().filter(function() {
    var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
    return !~text.indexOf(val);
    }).hide();
    });
    </script>	