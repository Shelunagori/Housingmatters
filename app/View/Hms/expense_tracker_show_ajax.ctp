<script>
$(document).ready(function(){
jQuery('.tooltips').tooltip();
});
</script>

<?php
$m_from = date("Y-m-d", strtotime($from));
$m_from = new MongoDate(strtotime($m_from));
$m_to = date("Y-m-d", strtotime($to));
$m_to = new MongoDate(strtotime($m_to));

$from_s = date('d-M-Y',strtotime($from));
$to_s = date('d-M-Y',strtotime($to));

?>

	<div style="width:100%;" class="hide_at_print">
   <span style="float:right;"> <a href="expense_tracker_excel?f=<?php echo $from; ?>&t=<?php echo $to; ?>" class="btn blue">Export in Excel</a></span>
		<span style="float:right; margin-right:1%;"><button type="button" class=" printt btn green" onclick="window.print()"><i class="icon-print"></i> Print</button></span>
		</div>
<br /><br />			
<table class="table table-bordered" style=" background-color:#FDFDEE;">

<tr>
<th colspan="9" style="text-align:center;">
<p style="font-size:16px;">
Expense Tracker Report  (<?php echo $society_name; ?>)
</p>
</th>
</tr>


<tr>

<th colspan="9" style="text-align:center;">
From: <?php echo $from_s; ?> To: <?php echo $to_s; ?>
</th>
</tr>

<tr>
<th>Posting Date</th>
<th>Expense Head</th>
<th>Vendor</th>
<th>Invoice Reference</th>
<th>Invoice Date</th>
<th>Due Date</th>
<th>Description</th>
<th>Rs</th>
<th class="hide_at_print">Action</th>
</tr>

<?php
$total_amount = 0;
foreach($cursor1 as $collection)
{
$auto_id = (int)$collection['expense_tracker']['auto_id'];
$receipt_id = (int)$collection['expense_tracker']['receipt_id'];
$society_id_d = (int)$collection['expense_tracker']['society_id'];
$current_date = $collection['expense_tracker']['current_date'];
$approver_id = (int)$collection['expense_tracker']['approver'];
$expense_head = (int)$collection['expense_tracker']['expense_head'];
$invoice_date = $collection['expense_tracker']['invoice_date'];
$due_date =  $collection['expense_tracker']['due_date'];
$party_head = (int)$collection['expense_tracker']['party_head'];
$description = $collection['expense_tracker']['description'];
$posting_date = $collection['expense_tracker']['posting_date'];
$amount = (int)$collection['expense_tracker']['amount'];
$amount_cat_id = (int)$collection['expense_tracker']['amount_category_id'];
$invoice_ref = $collection['expense_tracker']['invoice_reference'];

if($posting_date >= $m_from && $posting_date <= $m_to)
{


$result23 = $this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'),array('pass'=>array($approver_id)));
foreach($result23 as $collection)
{
$prepaired_by_name = $collection['user']['user_name'];
}



$current_date = date('d-m-Y',$current_date->sec);
$invoice_date = date('d-m-Y',$invoice_date->sec);
$due_date = date('d-m-Y',$due_date->sec);
$posting_date = date('d-m-Y',$posting_date->sec);

$result1 = $this->requestAction(array('controller' => 'hms', 'action' => 'expense_head'),array('pass'=>array($expense_head)));
foreach($result1 as $collection)
{
$expense_name = $collection['ledger_account']['ledger_name'];
}


$result2 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($party_head)));
foreach($result2 as $collection)
{
$vendor_name = $collection['ledger_sub_account']['name'];
}

$total_amount = $total_amount + $amount;
?>
<tr>
<td><?php echo $posting_date; ?></td>
<td><?php echo $expense_name; ?></td>
<td><?php echo $vendor_name; ?></td>
<td><?php echo $invoice_ref; ?></td>
<td><?php echo $invoice_date; ?></td>
<td><?php echo $due_date;  ?></td>
<td><?php echo $description; ?></td>
<td><?php echo $amount; ?></td>
<td class="hide_at_print">
<a href="expense_history_pdf?a=<?php echo $auto_id; ?>" class="btn mini purple tooltips" target="_blank" data-placement="bottom" data-original-title="Download Pdf">pdf</a>
<a class="btn mini black tooltips" data-placement="bottom" data-original-title="Created By:<?php echo $prepaired_by_name; ?>
										     Creation Date : <?php echo $current_date; ?>">!</a>
</td>
</tr>

<?php }} ?>
<tr>
<th colspan="7">Total Amount</th>
<th><?php echo $total_amount; ?></th>
<th class="hide_at_print"></th>
</tr>


</table>



























