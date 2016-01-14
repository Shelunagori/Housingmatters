<?php
$m_from = date("Y-m-d", strtotime($from));
$m_from = new MongoDate(strtotime($m_from));

$m_to = date("Y-m-d", strtotime($to));
$m_to = new MongoDate(strtotime($m_to));
?>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<?php 
$nnn = 55;
$result2 = $this->requestAction(array('controller' => 'hms', 'action' => 'regular_bill_fetch2'),array('pass'=>array($value)));	
foreach($result2 as $collection)
{
$bill_no = (int)$collection['regular_bill']['receipt_id'];
$date_from = $collection['regular_bill']['bill_daterange_from'];
$date_to = $collection['regular_bill']['bill_daterange_to'];
$last_date = $collection['regular_bill']['due_date'];
$total_amount = (int)$collection['regular_bill']['g_total'];
$due_amount = (int)$collection['regular_bill']['remaining_amount'];
$user_id = (int)$collection['regular_bill']['bill_for_user'];
$date = $collection['regular_bill']['date'];
$date_from1 = date('d-M-Y',$date_from->sec);
$date_to1 = date('d-M-Y',$date_to->sec);
$due_date = date('d-M-Y',$last_date->sec); 
$bill_html = $collection['regular_bill']['bill_html'];
$receipt_id = (int)$collection['regular_bill']['receipt_id']; 
$result3 = $this->requestAction(array('controller' => 'hms', 'action' => 'user_fetch'),array('pass'=>array($user_id)));	
foreach($result3 as $collection)
{
$user_name = $collection['user']['user_name'];
$wing = (int)$collection['user']['wing'];
$flat =(int)$collection['user']['flat'];
}
$wing_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'),array('pass'=>array(@$wing,@$flat)));	
if($m_from <= $date && $m_to >= $date)
{
$nnn = 555;
}
}
?>
<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<?php 
if($nnn == 555)
{
?>
<div style="width:100%;" class="hide_at_print">
<span style="margin-left:80%;">
<a href="account_statement_excel?u=<?php echo $value; ?>&f=<?php echo $from; ?>&t=<?php echo $to; ?>" class="btn blue">Export in Excel</a>
<button type="button" class=" printt btn green" onclick="window.print()"><i class="icon-print"></i> Print</button></span>
</div>
<br />
<table class="table table-bordered" style="width:100%; background-color:white;"> 
<tr>
<th colspan="8" style="text-align:center;">
<p style="font-size:16px;">
Account Statement (<?php echo $society_name; ?>)
</p>
</th>
</tr>
<tr>
<th style="text-align:center;">Sr. No.</th>
<th style="text-align:center;">User Name</th>
<th style="text-align:center;">Bill No.</th>
<th style="text-align:center;">Bill for Date</th>
<th style="text-align:center;">Last Date</th>
<th style="text-align:center;">Total Amount</th>
<th style="text-align:center;">Due Amount</th>
<th style="text-align:center;" class="hide_at_print">Detail</th>
</tr>
<?php
$nn = 0;
$grand_total_amount=0;
$total_due_amount=0;
$result2 = $this->requestAction(array('controller' => 'hms', 'action' => 'regular_bill_fetch2'),array('pass'=>array($value)));	
foreach($result2 as $collection)
{
$nn++;
$bill_no = (int)$collection['regular_bill']['receipt_id'];
$date_from = $collection['regular_bill']['bill_daterange_from'];
$date_to = $collection['regular_bill']['bill_daterange_to'];
$last_date = $collection['regular_bill']['due_date'];
$total_amount = (int)$collection['regular_bill']['g_total'];
$due_amount = (int)$collection['regular_bill']['remaining_amount'];
$user_id = (int)$collection['regular_bill']['bill_for_user'];
$date = $collection['regular_bill']['date'];
$date_from1 = date('d-M-Y',$date_from->sec);
$date_to1 = date('d-M-Y',$date_to->sec);
$due_date = date('d-M-Y',$last_date->sec); 
       	
$bill_html = $collection['regular_bill']['bill_html'];
$receipt_id = (int)$collection['regular_bill']['receipt_id']; 
$result3 = $this->requestAction(array('controller' => 'hms', 'action' => 'user_fetch'),array('pass'=>array($user_id)));	
foreach($result3 as $collection)
{
$user_name = $collection['user']['user_name'];
$wing = (int)$collection['user']['wing'];
$flat =(int)$collection['user']['flat'];
}
$wing_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'),array('pass'=>array(@$wing,@$flat)));	

if($m_from <= $date && $m_to >= $date)
{
$total_due_amount = $total_due_amount + $due_amount;
$grand_total_amount = $grand_total_amount + $total_amount;

$total_amount = number_format($total_amount);
$due_amount = number_format($due_amount);
?>
<tr>
<td style="text-align:center;"><?php echo $nn; ?></td>
<td style="text-align:center;"><?php echo $user_name; ?>&nbsp;&nbsp;<?php echo $wing_flat; ?></td>
<td style="text-align:center;"><?php echo $bill_no; ?></td>
<td style="text-align:center;"><?php echo $date_from1; ?>&nbsp;&nbsp;To&nbsp;&nbsp;<?php echo $date_to1; ?></td>
<td style="text-align:center;"><?php echo $due_date; ?></td>
<td style="text-align:center;"><?php echo $total_amount; ?></td>
<td style="text-align:center;"><?php echo $due_amount; ?></td>
<td style="text-align:center;" class="hide_at_print"><a href="ac_statement_bill_view?bill=<?php echo $receipt_id; ?>" class="btn mini yellow" target="_blank">View Bill</a></td>
</tr>
<?php
}}
$grand_total_amount = number_format($grand_total_amount);
$total_due_amount = number_format($total_due_amount);
?>
<tr>
<th colspan="5" style="text-align:center;">Total</th>
<th style="text-align:center;"><?php echo $grand_total_amount; ?></th>
<th style="text-align:center;"><?php echo $total_due_amount; ?></th>
<th style="text-align:center;" class="hide_at_print"></th>
</tr>
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