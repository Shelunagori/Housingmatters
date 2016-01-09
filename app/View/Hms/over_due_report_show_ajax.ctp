<?php

$from1 = date("Y-m-d", strtotime($from));
$from1 = new MongoDate(strtotime($from1));

$to1 = date("Y-m-d", strtotime($to));
$to1 = new MongoDate(strtotime($to1));

$result1 = $this->requestAction(array('controller' => 'hms', 'action' => 'user_fetch2'),array('pass'=>array($flat)));
foreach($result1 as $collection)
{
$user_id = $collection['user']['user_id'];
$user_name = $collection['user']['user_name'];
}


?>

<div style="width:100%;" class="hide_at_print">
<?php
if($wise == 1)
{
?>
<span style="float:right;"> <a href="overdue_excel?f=<?php echo $from; ?>&t=<?php echo $to; ?>&w=<?php echo $wise; ?>&wi=<?php echo $wing; ?>" class="btn blue">Export in Excel</a></span>
<?php
}
else if($wise == 2)
{
?>
<span style="float:right;"> <a href="overdue_excel?f=<?php echo $from; ?>&t=<?php echo $to; ?>&w=<?php echo $wise; ?>&u=<?php echo $user_id; ?>" class="btn blue">Export in Excel</a></span>
<?php 
}
?>
<span style="float:right; margin-right:1%;"><button type="button" class=" printt btn green" onclick="window.print()"><i class="icon-print"></i> Print</button></span>
</div>
<br />	<br />









<table class="table table-bordered" style="width:100%; background-color:white;">
<tr>
<th colspan="8" style="text-align:center;">
<p style="font-size:16px;">
Over Due Report  (<?php echo $soc_name; ?>)</p>
</th>
</tr>
<tr>
<th style="text-align:center;">#</th>
<th style="text-align:center;">Bill No</th>
<th style="text-align:center;">Owner Name</th>
<th style="text-align:center;">Bill Date</th>
<th style="text-align:center;">Due date</th>
<th style="text-align:center;">Total Amount</th>
<th style="text-align:center;">Due Amount</th>
<th style="text-align:center;">Bill Amount</th>
<th style="text-align:center;" class="hide_at_print">Bill View</th>
</tr>
<?php 
$c=0;
foreach($cursor1 as $collection)
{
$bill_no = (int)$collection['regular_bill']['receipt_id'];	
$date_from = $collection['regular_bill']['bill_daterange_from'];	
$date_to = $collection['regular_bill']['bill_daterange_to'];	
$due_date = $collection['regular_bill']['due_date'];	
$total_amt = (int)$collection['regular_bill']['total_amount'];
//$tax_amt = (int)$collection['regular_bill']['tax_amount'];	
$due_amt = (int)$collection['regular_bill']['total_due_amount'];	
$bill_amt = (int)$collection['regular_bill']['g_total'];	
$bill_for_user = (int)$collection['regular_bill']['bill_for_user'];
$total_amount = $total_amt;


$result11 = $this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'),array('pass'=>array($bill_for_user)));				
foreach ($result11 as $collection2) 
{
$user_name = $collection2['user']['user_name'];
$wing_id = (int)$collection2['user']['wing'];  
$flat_id = (int)$collection2['user']['flat'];
$tenant = (int)$collection2['user']['tenant'];
}	





if($wise == 2)
{
if($user_id == $bill_for_user)
{
if($date_from >= $from1 && $date_to <= $to1)
{
if($due_amt > 0)
{
$fromd = date('d-M-Y',$date_from->sec);	
$tod = date('d-M-Y',$date_to->sec);	
$dued = date('d-M-Y',$due_date->sec);	
$c++;
$total_amount = number_format($total_amount);
$due_amt = number_format($due_amt);
$bill_amt = number_format($bill_amt);
?>
<tr>
<td style="text-align:center;"><?php echo $c; ?></td>
<td style="text-align:center;"><?php echo $bill_no; ?></td>
<td style="text-align:center;"><?php echo $user_name; ?></td>
<td style="text-align:center;"><?php echo $fromd; ?>  -  <?php echo $tod; ?></td>
<td style="text-align:center;"><?php echo $dued; ?></td>
<td style="text-align:center;"><?php echo $total_amount; ?></td>
<td style="text-align:center;"><?php echo $due_amt; ?></td>
<td style="text-align:center;"><?php echo $bill_amt; ?></td>
<td style="text-align:center;" class="hide_at_print"><a href="regular_bill_view?bill=<?php echo $bill_no; ?>" class="btn mini yellow" target="_blank">Bill View</a></td>
</tr>

<?php
}
}
}
}
else if($wise == 1)
{
if($wing == $wing_id)
{
if($date_from >= $from1 && $date_to <= $to1)
{
if($due_amt > 0)
{
$fromd = date('d-M-Y',$date_from->sec);	
$tod = date('d-M-Y',$date_to->sec);	
$dued = date('d-M-Y',$due_date->sec);	
$c++;
$total_amount = number_format($total_amount);
$due_amt = number_format($due_amt);
$bill_amt = number_format($bill_amt);


?>
<tr>
<td style="text-align:center;"><?php echo $c; ?></td>
<td style="text-align:center;"><?php echo $bill_no; ?></td>
<td style="text-align:center;"><?php echo $user_name; ?></td>
<td style="text-align:center;"><?php echo $fromd; ?>  -  <?php echo $tod; ?></td>
<td style="text-align:center;"><?php echo $dued; ?></td>
<td style="text-align:center;"><?php echo $total_amount; ?></td>
<td style="text-align:center;"><?php echo $due_amt; ?></td>
<td style="text-align:center;"><?php echo $bill_amt; ?></td>
<td style="text-align:center;" class="hide_at_print"><a href="regular_bill_view?bill=<?php echo $bill_no; ?>" class="btn mini yellow" target="_blank">Bill View</a></td>
</tr>

<?php
}}}
}
}
?>

</table>

