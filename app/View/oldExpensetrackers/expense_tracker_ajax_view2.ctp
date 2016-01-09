<?php
$from = date("Y-m-d",strtotime($from));
$to = date("Y-m-d",strtotime($to));
?>

<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////// ?>


<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<div style="width:100%; overflow:auto;" class="hide_at_print">
<span style="float:right;">
<a href="expense_tracker_excel?f=<?php echo $from; ?>&t=<?php echo $to; ?>" class="btn blue" target="_blank">Export in Excel</a></span>
<span style="float:right; margin-right:1%;"><button type="button" class=" printt btn green" onclick="window.print()"><i class="icon-print"></i> Print</button></span>
</div>	
<br />	

<table class="table table-bordered" style="background-color:#FFF; width:100%;">
<tr>
<th style="text-align:center;" colspan="10"><?php echo $society_name; ?> Society</th>
</tr>
<tr>
<th style="text-align:left;">Voucher #</th>
<th style="text-align:left;">Posting Date</th>
<th style="text-align:left;">Due Date</th>
<th style="text-align:left;">Date of Invoice</th>
<th style="text-align:left;">Expense Head</th>
<th style="text-align:left;">Invoice Reference</th>
<th style="text-align:left;">Party Account Head</th>
<th style="text-align:left;">Amount</th>
<th style="text-align:left;" class="hide_at_print">Attachment</th>
<th style="text-align:left;" class="hide_at_print">Action</th>
</tr>
<?php
$total = 0;
foreach($cursor3 as $collection)
{
$receipt_id = $collection['expense_tracker']['receipt_id'];
$posting_date = $collection['expense_tracker']['posting_date'];
$due_date = $collection['expense_tracker']['due_date'];
$invoice_date = $collection['expense_tracker']['invoice_date'];
$expense_head = (int)$collection['expense_tracker']['expense_head'];
$invoice_reference = $collection['expense_tracker']['invoice_reference'];
$party_account_head = (int)$collection['expense_tracker']['party_head'];
$amount = $collection['expense_tracker']['amount'];
$file = $collection['expense_tracker']['attachment'];
$result5 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_account_fetch2'),array('pass'=>array($expense_head)));
foreach($result5 as $collection3)
{
$ledger_name = $collection3['ledger_account']['ledger_name'];
}

$result6 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($party_account_head)));
foreach($result6 as $collection4)
{
$party_name = $collection4['ledger_sub_account']['name'];
}




if($posting_date >= $from && $posting_date <= $to)
{
$total = $total+$amount;
?>
<tr>
<td style="text-align:right;"><?php echo $receipt_id; ?></td>
<td style="text-align:left;"><?php echo $posting_date; ?></td>
<td style="text-align:left;"><?php echo $due_date; ?></td>
<td style="text-align:left;"><?php echo $invoice_date; ?></td>
<td style="text-align:left;"><?php echo $ledger_name; ?></td>
<td style="text-align:left;"><?php echo $invoice_reference; ?></td>
<td style="text-align:left;"><?php echo $party_name; ?></td>
<td style="text-align:right;"><?php echo $amount; ?></td>
<td style="text-align:left;" class="hide_at_print"><a href="<?php echo $webroot_path; ?>expenset/<?php echo $file; ?>" class="hide_at_print">Download</a></td>
<td style="text-align:left;" class="hide_at_print"></td>
</tr>
<?php
}}
?>
<tr>
<th colspan="7" style="text-align:right;">Total</th>
<th style="text-align:right;"><?php echo $total; ?></th>
<th class="hide_at_print"></th>
<th class="hide_at_print"></th>
</tr>
</table>



























<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>