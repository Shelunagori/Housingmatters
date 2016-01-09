		<style>
		
			#report_tb th{
			padding:2px;
			font-size: 12px;border:solid 1px #000;background-color:#FFF;
			}
			#report_tb td{
			padding:2px;
			font-size: 12px;border:solid 1px #000;background-color:#FFF;
			}
		</style>
<a href="bank_receipt_deposit_slip" class="btn green hide_at_print">Back</a>
<center>
<br /><br />

<button type="button" class=" printt btn green hide_at_print" onclick="window.print()" style="margin-left:80%;"><i class="icon-print"></i> Print</button></span>
<br /><br />
<div style="width:84%; background-color:#FFF; overflow:hidden;">
<br />
<table style="background-color:#FFF;" width="94%" align="center">
<tr>
<th colspan="4" style="text-align:left;">Cheque Deposit Slip: Annexure
<br /><br /> 
</th>
</tr>
<tr>
<td style="text-align:left;"><b>Account No. :</b> &nbsp; <?php echo $bank_account; ?></td>

<th style="text-align:right;">Date</th><th style="width:15%; text-align:left;">..................................</th>
</tr>
</table>
<br />
<table style="background-color:#FFF;" width="94%" align="center">
<tr>
<td style="text-align:left;"><b>Name of Account Holder :</b>&nbsp;	
<?php echo $society_name; ?></td><th style="text-align:right;">Mobile</th><th style="width:15%; text-align:left;">..................................</th>
</tr>
</table>
<br />
<table style="background-color:#FFF;" id="report_tb" width="94%" align="center">	
<tr>
<th width="5%;">Sr#</th>	
<th width="20%;">Bank</th>
<th width="20%;">Branch</th>
<th width="15%;">Cheque/Draft #</th>
<th width="10%;">Date</th>
<th width="15%;">Reference</th>
<th width="15%;">Amount (Rs)</th>
</tr>

<?php 
$arrrrr = explode(',',$arrr);
$tt_amt = 0;
$sr=0;
for($v=0; $v<sizeof($arrrrr); $v++)
{
$value = (int)$arrrrr[$v];	
	
	$new_cash_bank_result = $this->requestAction(array('controller' => 'hms', 'action' => 'new_cash_bank_detail_via_transaction_id'),array('pass'=>array($value)));			
	foreach($new_cash_bank_result as $dataa)
	{
    $amount = $dataa['new_cash_bank']['amount'];
	$bank_id = (int)$dataa['new_cash_bank']['deposited_bank_id'];	
	$cheque_no = (int)$dataa['new_cash_bank']['cheque_number'];
	$date = @$dataa['new_cash_bank']['cheque_date'];
	$type = (int)$dataa['new_cash_bank']['member_type'];
	$drawn_bank_name = $dataa['new_cash_bank']['drawn_on_which_bank'];
	$branch = @$dataa['new_cash_bank']['bank_branch'];
	
			if($type == 1)
			{
			$flat_id = (int)$dataa['new_cash_bank']['flat_id'];
					
		$flatt_datta = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($flat_id)));
		foreach ($flatt_datta as $fltt_datttaa) 
		{
		$wnngg_idddd = (int)$fltt_datttaa['flat']['wing_id'];
		}	
		$wing_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat_new'),array('pass'=>array($wnngg_idddd,$flat_id)));			
			
			}
			else
			{
			$wing_flat = "";	
			}
	}		
if(!empty($date))
{	
$date1 = date('d-m-Y',strtotime($date));	
}
$ledgrr_sub_acc = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array(@$bank_id)));			
foreach($ledgrr_sub_acc as $leddrr_subb)
{
$bank_name = $leddrr_subb['ledger_sub_account']['name'];	
}		
	
$tt_amt = $tt_amt + @$amount;
	
if(!empty($bank_name))
{
$sr++;	
?>	
<tr>
<td><?php echo @$sr; ?></td>
<td><?php echo @$drawn_bank_name; ?></td>
<td><?php echo @$branch; ?></td>
<td style="text-align:right;"><?php echo @$cheque_no; ?></td>
<td><?php echo @$date1; ?></td>
<td><?php echo @$wing_flat; ?></td>
<td style="text-align:right;"><?php $amount2 = number_format($amount); echo @$amount2; ?></td>
</tr>	
<?php	
}
}
$amount_tt = str_replace( ',', '', $tt_amt);
$am_in_words=ucwords($this->requestAction(array('controller' => 'hms', 'action' => 'convert_number_to_words'), array('pass' => array($amount_tt))));

?>
<tr>
<th colspan="6" style="text-align:left;">Rupees <?php echo $am_in_words; ?> only</th>
<th style="text-align:right;"><?php $tt_amt2 = number_format($tt_amt); echo $tt_amt2; ?></th>
</tr>
</table>
<br />	
</div>
</center>