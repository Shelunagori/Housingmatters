<style>
#report_tb th{
	font-size: 14px !important;background-color:#C8EFCE;padding:5px;border:solid 1px #55965F;
}
#report_tb td{
	padding:5px;
	font-size: 14px;border:solid 1px #55965F;background-color:#FFF;
}
table#report_tb tr:hover td {
background-color: #E6ECE7;
}
</style>
<?php
$nnn = 55;
foreach($cursor2 as $data)
{
$nnn = 5555;	
}
?>



<?php if($nnn == 5555) { ?>
<div class="hide_at_print">
<span style="margin-left:80%;">
<a href="cash_book_report_excel?f=<?php echo $from; ?>&t=<?php echo $to; ?>" class="btn blue mini" target="_blank"><i class="icon-download"></i></a>
<a type="button" class=" printt btn green mini" onclick="window.print()"><i class="icon-print"></i></a>
</span>
</div>
<br>


<table id="report_tb" border="1" style="width:100%;">
<tr>
<th style="text-align:center; background-color:white;" colspan="7"><?php echo $society_name; ?> Cash Book Report Register From: <?php echo $from; ?> To: <?php echo $to; ?></th>
</tr>
<tr>
<th style="width:10%;">Date</th>
<th>Particulars</th>
<th style="width:15%;">Voucher/Receipt No.</th>
<th>Narration</th>
<th style="width:10%;">Receipts</th>
<th style="width:10%;">Payments</th>
<th style="width:10%;">Balance</th>

<tr>
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


if($receipt_source == 3)
{
$narration = $dataaa['new_cash_bank']['narration'];	
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
$narration = $dataaa['new_cash_bank']['narration'];	
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

<td></td>
</tr>
</table>

<?php } else { ?>

<div align="center" style="width:100%; overflow:auto;" id="result">
		<br/><br/><h3>Not Found any Receipt or Voucher</h3>
	</div>


<?php } ?>