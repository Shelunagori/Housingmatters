<?php 

$filename=$society_name.'_Expense_Tracker_'.$from1.'_'.$to1;
$filename = str_replace(' ', '_', $filename);
$filename = str_replace(' ', '-', $filename);
header ("Expires: 0");
header ("border: 1");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=".$filename.".xls");
header ("Content-Description: Generated Report" );

?>
<div align="center"> 
<span style="font-size:16px;"><?php echo $society_name; ?><span>
<br/>
<span>Expense Tracker: <?php echo $from1; ?> to <?php echo $to1; ?> <span>
</div>

<table class="" style="" id="tbb" width="100%" border="1">
<thead>
<tr>
<th >Voucher Id</th>
<th >Posting date</th>
<th >Date of Invoice</th>
<th >Due Date</th>
<th >Party Account Head </th>
<th >Invoice Reference</th>
<th >Expense Head</th>
<th width="20%">Description</th>
<th >Amount</th>
</tr>
</thead>
<tbody id="count_row">
<?php 
//pr($result_expense_tracker);
$total=0;
foreach($result_expense_tracker as $data){
	$expense_tracker_id=$data['expense_tracker']['expense_tracker_id'];
	$voucher_id=$data['expense_tracker']['expense_id'];
	$posting_date=$data['expense_tracker']['posting_date'];
	$posting_date=date('d-m-Y',$posting_date);
	$due_date=$data['expense_tracker']['due_date'];
	if(!empty($due_date)){
	$due_date=date('d-m-Y',$due_date);
	}
	$date_of_invoice=$data['expense_tracker']['date_of_invoice'];
	$date_of_invoice=date('d-m-Y',$date_of_invoice);
	$expense_head=$data['expense_tracker']['expense_head'];
	$invoice_reference=$data['expense_tracker']['invoice_reference'];
	$party_ac_head=$data['expense_tracker']['party_ac_head'];
	$ammount_of_invoice=$data['expense_tracker']['ammount_of_invoice'];
	$description=$data['expense_tracker']['description'];
	$file=$data['expense_tracker']['file'];
	$result_ledger_account = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_account_fetch2'),array('pass'=>array($expense_head)));
	foreach($result_ledger_account as $collection)
	{
	$ledger_name = $collection['ledger_account']['ledger_name'];
	}

	$result_ledger_sub_account = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($party_ac_head)));
	foreach($result_ledger_sub_account as $collection)
	{
	$party_name = $collection['ledger_sub_account']['name'];
	}
	


?>
<tr>
<td><?php echo $voucher_id; ?></td>
<td><?php echo $posting_date; ?></td>
<td><?php echo $date_of_invoice; ?></td>
<td><?php echo $due_date; ?></td>
<td><?php echo $party_name; ?></td>
<td align="right"><?php echo $invoice_reference; ?></td>
<td><?php echo $ledger_name; ?></td>
<td><?php echo $description; ?></td>
<td align="right"><?php echo $ammount_of_invoice; ?> <?php $total+=$ammount_of_invoice ; ?></td>
</tr>
<?php } ?>

<tr>
<td colspan="8" style="text-align:right;"> <b> Total </b> </td>
<td style="text-align:right;" > <b><?php echo $total; ?></b> </td>
</tr>

</tbody>
</table>