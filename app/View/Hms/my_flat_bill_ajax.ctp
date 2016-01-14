<?php
$m_from = date("Y-m-d", strtotime($from));
$m_from = new MongoDate(strtotime($m_from));

$m_to = date("Y-m-d", strtotime($to));
$m_to = new MongoDate(strtotime($m_to));


?>

<div style="width:100%;" class="hide_at_print">
<span style="margin-left:80%;">
<a href="my_flat_bill_excel?f=<?php echo $from; ?>&t=<?php echo $to; ?>&tp=<?php echo $value; ?>" class="btn blue">Export in Excel</a>
<button type="button" class=" printt btn green" onclick="window.print()"><i class="icon-print"></i> Print</button></span>
</div>
<br />
<?php
if($value == 1)
{
?>
<table class="table table-bordered" style="width:100%; background-color:white;">
<tr>
<th colspan="7" style="text-align:center;">
<p style="font-size:16px;">
Bill Detail  (<?php echo $society_name; ?>)
</p>
</th>
</tr>
<tr>
<th style="text-align:center;">#</th>
<th style="text-align:center;">Bill No.</th>
<th style="text-align:center;">Bill Date</th>
<th style="text-align:center;">Due Date</th>
<th style="text-align:center;">Total Amount</th>
<th style="text-align:center;">Pay Amount</th>
<th style="text-align:center;" class="hide_at_print">Action</th>
</tr>
<?php
$nn=0;
$gt_amt = 0;
$gt_pay_amt = 0;
foreach($cursor1 as $collection)
{

$bill_no = (int)$collection['regular_bill']['receipt_id'];	
$from2 = $collection['regular_bill']['bill_daterange_from'];
$to2 = $collection['regular_bill']['bill_daterange_to'];
$due_date = $collection['regular_bill']['due_date'];
$total_amount = (int)$collection['regular_bill']['g_total'];
$remaining_amt = (int)$collection['regular_bill']['remaining_amount'];
$fromm = date('d-M-Y',$from2->sec);
$tom = date('d-M-Y',$to2->sec);
$due = date('d-M-Y',$due_date->sec);
$pay_amt = $total_amount - $remaining_amt; 
if($m_from <= $from2 && $m_to >= $to2)
{
$nn++;
$gt_amt = $gt_amt + $total_amount;
$gt_pay_amt = $gt_pay_amt + $pay_amt;
?>
<tr>
<td style="text-align:center;"><?php echo $nn; ?></td>
<td style="text-align:center;"><?php echo $bill_no; ?></td>
<td style="text-align:center;"><?php echo $fromm; ?>-<?php echo $tom; ?></td>
<td style="text-align:center;"><?php echo $due; ?></td>
<td style="text-align:center;"><?php echo $total_amount; ?></td>
<td style="text-align:center;"><?php echo $pay_amt; ?></td>
<td style="text-align:center;" class="hide_at_print">
<a href="regular_bill_view?bill=<?php echo $bill_no; ?>" class="btn mini yellow" target="_blank">View Bill</a>

</td>
</tr>
<?php
}}
?>
<tr>
<th colspan="4">Grand Total</th>
<th style="text-align:center;"><?php echo $gt_amt; ?></th>
<th style="text-align:center;"><?php echo $gt_pay_amt; ?></th>
<th class="hide_at_print"></th>
</table>
<?php
}
?>
<?php
if($value == 2)
{
?>
<table class="table table-bordered" style="width:100%; background-color:white;">
<tr>
<th colspan="7" style="text-align:center;">
<p style="font-size:16px;">
Bill Detail  (<?php echo $society_name; ?>)
</p>
</th>
</tr>
<tr>
<th style="text-align:center;">#</th>
<th style="text-align:center;">Bill No.</th>
<th style="text-align:center;">Bill Date</th>
<th style="text-align:center;">Due Date</th>
<th style="text-align:center;">Total Amount</th>
<th style="text-align:center;">Pay Amount</th>
<th style="text-align:center;" class="hide_at_print">Action</th>
</tr>
<?php
$nn=0;
$gt_amt = 0;
$gt_pay_amt = 0;
foreach($cursor2 as $collection)
{

$bill_no = (int)$collection['regular_bill']['receipt_id'];	
$from2 = $collection['regular_bill']['bill_daterange_from'];
$to2 = $collection['regular_bill']['bill_daterange_to'];
$due_date = $collection['regular_bill']['due_date'];
$total_amount = (int)$collection['regular_bill']['g_total'];
$remaining_amt = (int)$collection['regular_bill']['remaining_amount'];
$fromm = date('d-M-Y',$from2->sec);
$tom = date('d-M-Y',$to2->sec);
$due = date('d-M-Y',$due_date->sec);
$pay_amt = $total_amount - $remaining_amt; 
if($m_from <= $from2 && $m_to >= $to2)
{
$nn++;
$gt_amt = $gt_amt + $total_amount;
$gt_pay_amt = $gt_pay_amt + $pay_amt;
?>
<tr>
<td style="text-align:center;"><?php echo $nn; ?></td>
<td style="text-align:center;"><?php echo $bill_no; ?></td>
<td style="text-align:center;"><?php echo $fromm; ?>-<?php echo $tom; ?></td>
<td style="text-align:center;"><?php echo $due; ?></td>
<td style="text-align:center;"><?php echo $total_amount; ?></td>
<td style="text-align:center;"><?php echo $pay_amt; ?></td>
<td style="text-align:center;" class="hide_at_print">
<a href="regular_bill_view?bill=<?php echo $bill_no; ?>" class="btn mini yellow" target="_blank">View Bill</a>
</td>
</tr>
<?php
}}
?>
<tr>
<th colspan="4">Grand Total</th>
<th style="text-align:center;"><?php echo $gt_amt; ?></th>
<th style="text-align:center;"><?php echo $gt_pay_amt; ?></th>
<th class="hide_at_print"></th>
</tr>
</table>
<?php
}
?>
<?php
if($value == 3)
{
?>
<table class="table table-bordered" style="width:100%; background-color:white;">
<tr>
<th colspan="7" style="text-align:center;">
<p style="font-size:16px;">
Bill Detail  (<?php echo $society_name; ?>)
</p>
</th>
</tr>
<tr>
<th style="text-align:center;">#</th>
<th style="text-align:center;">Bill No.</th>
<th style="text-align:center;">Bill Date</th>
<th style="text-align:center;">Due Date</th>
<th style="text-align:center;">Total Amount</th>
<th style="text-align:center;">Pay Amount</th>
<th style="text-align:center;" class="hide_at_print">Action</th>
</tr>
<?php
$nn=0;
$gt_amt = 0;
$gt_pay_amt = 0;
foreach($cursor3 as $collection)
{

$bill_no = (int)$collection['regular_bill']['receipt_id'];	
$from2 = $collection['regular_bill']['bill_daterange_from'];
$to2 = $collection['regular_bill']['bill_daterange_to'];
$due_date = $collection['regular_bill']['due_date'];
$total_amount = (int)$collection['regular_bill']['g_total'];
$remaining_amt = (int)$collection['regular_bill']['remaining_amount'];
$fromm = date('d-M-Y',$from2->sec);
$tom = date('d-M-Y',$to2->sec);
$due = date('d-M-Y',$due_date->sec);
$pay_amt = $total_amount - $remaining_amt; 
if($m_from <= $from2 && $m_to >= $to2)
{
$nn++;
$gt_amt = $gt_amt + $total_amount;
$gt_pay_amt = $gt_pay_amt + $pay_amt;
?>
<tr>
<td style="text-align:center;"><?php echo $nn; ?></td>
<td style="text-align:center;"><?php echo $bill_no; ?></td>
<td style="text-align:center;"><?php echo $fromm; ?>-<?php echo $tom; ?></td>
<td style="text-align:center;"><?php echo $due; ?></td>
<td style="text-align:center;"><?php echo $total_amount; ?></td>
<td style="text-align:center;"><?php echo $pay_amt; ?></td>
<td style="text-align:center;" class="hide_at_print">
<a href="regular_bill_view?bill=<?php echo $bill_no; ?>" class="btn mini yellow" target="_blank">View Bill</a>
</td>
</tr>
<?php
}}
?>
<tr>
<th colspan="4">Grand Total</th>
<th style="text-align:center;"><?php echo $gt_amt; ?></th>
<th style="text-align:center;"><?php echo $gt_pay_amt; ?></th>
<th class="hide_at_print"></th>
</tr>
</table>
<?php
}
?>


