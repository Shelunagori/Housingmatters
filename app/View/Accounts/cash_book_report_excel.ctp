<?php 
$filename=$socc_namm.'Cash_Book_Report';
//$filename = str_replace(' ', '_', $filename);
//$filename = str_replace(' ', '-', $filename);
header ("Expires: 0");
header ("border: 1");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=".$filename.".xls");
header ("Content-Description: Generated Report" );
?>
<table border="1">
<tr>
<th colspan="7" style="text-align:center; background-color:white;"><?php echo $society_name; ?> Cash Book Report Register From: <?php echo $from; ?> To: <?php echo $to; ?></th>
</tr>
<tr>
<th>Date</th>
<th>Particulars</th>
<th>Voucher/Receipt No.</th>
<th>Narration</th>
<th>Receipts</th>
<th>Payments</th>
<th>Balance</th>

</tr>
<?php
$total_balance = 0;
$balance = 0;
$total_payment = 0;
$total_receipt = 0;
foreach($cursor2 as $dataaa)
{
$transaction_date = $dataaa['new_cash_bank']['transaction_date'];	
$transaction_date2 = date('d-m-Y',($transaction_date));	
$receipt_id = $dataaa['new_cash_bank']['receipt_id'];	
$receipt_source = (int)$dataaa['new_cash_bank']['receipt_source'];
$narration = $dataaa['new_cash_bank']['narration'];

if($receipt_source == 3)
{
$account_id = (int)$dataaa['new_cash_bank']['user_id'];
$account_type = (int)$dataaa['new_cash_bank']['account_type'];
$receipt_amount = $dataaa['new_cash_bank']['amount'];
$payment_amount = "";
$payment_amount2 = "";
if($account_type == 1)
{
	$subleddger_detaill=$this->requestAction(array('controller' => 'Hms', 'action' => 'ledger_sub_account_fetch'), array('pass' => array($account_id)));
	foreach($subleddger_detaill as $subledger_datttaa)
	{
	$user_name = $subledger_datttaa['ledger_sub_account']['name'];
	$flat_id = (int)$subledger_datttaa['ledger_sub_account']['flat_id'];
	}	

$subleddger_detaill=$this->requestAction(array('controller' => 'Bookkeepings', 'action' => 'fetch_wing_id_via_flat_id'), array('pass' => array($flat_id)));
foreach($subleddger_detaill as $subledger_datttaa)
{
$wing_id = (int)$subledger_datttaa['flat']['wing_id'];
}					
					
$wing_flat =$this->requestAction(array('controller' => 'Bookkeepings', 'action' => 'wing_flat_new'),
array('pass' => array($wing_id,$flat_id)));	

	}
else
{
	
	    $wing_flat = "";
        $ledger_detailll=$this->requestAction(array('controller' => 'Hms', 'action' => 'ledger_account_fetch2'), 
		array('pass' => array($account_id)));
		foreach($ledger_detailll as $ledger_detailllll)
		{
		$user_name = $ledger_detailllll['ledger_account']['ledger_name'];
		}		
}

}
else
{
	$wing_flat = "";
$payment_amount = $dataaa['new_cash_bank']['amount'];	
$account_type = (int)$dataaa['new_cash_bank']['account_type'];
$account_id = (int)$dataaa['new_cash_bank']['user_id'];
$receipt_amount = "";
$receipt_amount2 = "";

if($account_type == 1){
	
$subleddger_detaill=$this->requestAction(array('controller' => 'Hms', 'action' => 'ledger_sub_account_fetch'),
array('pass' => array($account_id)));
foreach($subleddger_detaill as $subledger_datttaa)
{
$user_name = $subledger_datttaa['ledger_sub_account']['name'];
}		
}
else{
	
	$ledger_detailll=$this->requestAction(array('controller' => 'Hms', 'action' => 'ledger_account_fetch2'), 
	array('pass' => array($account_id)));
	foreach($ledger_detailll as $ledger_detailllll)
	{
	$user_name = $ledger_detailllll['ledger_account']['ledger_name'];
	}		
	
	
}








}
$balance = $balance + $receipt_amount - $payment_amount; 
$total_payment = $total_payment + $payment_amount;
$total_receipt = $total_receipt + $receipt_amount;
$total_balance = $total_balance + $balance;
?>
<tr>
<td><?php echo $transaction_date2; ?></td>
<td><?php echo $user_name; ?>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $wing_flat; ?></td>
<td><?php echo $receipt_id; ?></td>
<td><?php echo $narration; ?></td>
<td style="text-align:right;"><?php if(!empty($receipt_amount)) { $receipt_amount2 = number_format($receipt_amount); } echo @$receipt_amount2; ?></td>
<td style="text-align:right;"><?php if(!empty($payment_amount)) { $payment_amount2 = number_format($payment_amount); } echo @$payment_amount2; ?></td>
<td style="text-align:right;"><?php if(!empty($balance)) { $balance2 = number_format($balance); } echo @$balance2; ?></td>

</tr>
<?php } ?>
<tr>
<td colspan="4" style="text-align:right;"><b>Total</b></td>
<td style="text-align:right;"><b><?php if(!empty($total_receipt)) { $total_receipt2 = number_format($total_receipt); }  echo @$total_receipt2; ?></b></td>
<td style="text-align:right;"><b><?php if(!empty($total_payment)) { $total_payment2 = number_format($total_payment); } echo @$total_payment2; ?></b></td>
<td style="text-align:right;"></td>
</tr>
</table>