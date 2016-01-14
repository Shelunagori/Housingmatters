<?php
$n=1;
foreach($cursor1 as $collection)
{
if($n == 1)
{
$from_dm = $collection['regular_bill']['bill_daterange_from'];
$to_dm = $collection['regular_bill']['bill_daterange_to'];
$curr_dm = $collection['regular_bill']['date'];
$due_dm = $collection['regular_bill']['due_date'];
$ih_arr = $collection['regular_bill']['ih_detail'];
}
$n++;
}

$from = date('d-M-Y',$from_dm->sec);
$to = date('d-M-Y',$to_dm->sec);
$cur_date11 = date('d-M-Y',$curr_dm->sec);
$due_date11 = date('d-M-Y',$due_dm->sec);
?>

<div style="width:100%;" class="hide_at_print">
<span style="margin-left:80%;">
<a href="in_head_excel?f=<?php echo $un; ?>" class="btn blue">Export in Excel</a>
<button type="button" class=" printt btn green" onclick="window.print()"><i class="icon-print"></i> Print</button></span>
</div>
<br />


<div style="width:100%; overflow:auto; background-color:white;">
<br /><br />
<table Border="0" style="width:100%;">
<tr>
<th style="text-align:center;" colspan="2">
<p style="font-size:36px;"><?php echo $society_name; ?></p>
</th>
</tr>
<tr>
<td colspan="2" style="text-align:center;">
<p style="font-size:18px;">
<?php echo $society_reg_nu; ?>
</p>
</td>
</tr>
<tr>
<td colspan="2" style="text-align:center;">
<p style="font-size:18px;"><?php echo $society_address; ?></p>
</td>
</tr>
<tr>
<th style="text-align:center;">
<p style="font-size:18px;">
Bill for date From :<?php echo $from; ?> To : <?php echo $to; ?>    
</p>
</th>
<td>
<table border="0">
<tr>
<td>Bill Date:</td><td><?php echo $cur_date11; ?></td>
</tr>
<tr>
<td>Due date:</td><td><?php echo $due_date11; ?></td>
</tr>
</table>
</td>
</tr>
</table>
<br /><br />
<table border="2" style="width:100%;">
<tr>
<th>Sr.No.</th>
<th>Bill No.</th>
<th>Name of Resident</th>
<?php
for($k=0; $k<sizeof($ih_arr); $k++)
{
$sub_arr = $ih_arr[$k];
$ih_id1 = (int)$sub_arr[0];

$result = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_account_fetch2'),array('pass'=>array($ih_id1)));
foreach($result as $collection)
{
$in_name = $collection['ledger_account']['ledger_name'];	
}
if($ih_id1 != 43)
{
$ih_tt_amt[] = 0;
?>
<th><?php echo $in_name; ?></th>
<?php }} ?>
<th>Non Occupancy charges</th>
<th>Current Amount</th>
<th>Over Due Amount</th>
<th>Penalty Amount</th>
<th>Grand Total Amount</th>
</tr>

<?php

$m=0;
$tt_current_amt = 0;
$tt_over_due_amt = 0;
$total_penalty_amt = 0;
$tt_gt_amt = 0;
$tt_noc_amt = 0;
foreach($cursor1 as $collection)
{
$bill_no = (int)$collection['regular_bill']['receipt_id'];	
$user_id = (int)$collection['regular_bill']['bill_for_user'];
$current_amt = $collection['regular_bill']['total_amount'];
$over_due_amt = $collection['regular_bill']['due_amount'];
$penalty_amt = $collection['regular_bill']['due_amount_tax'];
$gt_amt = $collection['regular_bill']['g_total'];
$ih_det = $collection['regular_bill']['ih_detail'];
$result2 = $this->requestAction(array('controller' => 'hms', 'action' => 'user_fetch'),array('pass'=>array($user_id)));
foreach($result2 as $collection)
{
$user_name = $collection['user']['user_name'];
}
$tt_current_amt = $tt_current_amt + $current_amt;
$tt_over_due_amt = $tt_over_due_amt + $over_due_amt;
$total_penalty_amt = $total_penalty_amt + $penalty_amt;
$tt_gt_amt = $tt_gt_amt + $gt_amt;
$m++;
?>
<tr>
<td style="text-align:center;"><?php echo $m; ?></td>
<td style="text-align:center;"><?php echo $bill_no; ?></td>
<td style="text-align:center;"><?php echo $user_name; ?></td>
<?php
for($x=0; $x<sizeof($ih_det); $x++)
{
$charge3 = $ih_det[$x];
$ih_id5 = (int)$charge3[0];
if($ih_id5 != 43)
{	
$amt = $charge3[1];
$ih_tt_amt[$x] = $ih_tt_amt[$x] + $amt;
?>
<td style="text-align:center;"><?php 
$amt = number_format($amt);
echo $amt; ?></td>
<?php
}
}
$n=5;
for($y=0; $y<sizeof($ih_det); $y++)
{
$charge4 = $ih_det[$y];
$ih_id6 = (int)$charge4[0];
if($ih_id6 == 43)
{
$n=55;
$amt2 = $charge4[1];
$tt_noc_amt = $tt_noc_amt + $amt2;
?>
<td style="text-align:center;"><?php 
$amt2 = number_format($amt2);
echo $amt2; ?></td>	
<?php
}
}
if($n == 5)
{
?>
<td style="text-align:center;"><?php echo "0"; ?></td>	
<?php
}
?>
<td style="text-align:center;"><?php 
$current_amt = number_format($current_amt);
echo $current_amt; ?></td>
<td style="text-align:center;"><?php if(!empty($over_due_amt)) { 
$over_due_amt = number_format($over_due_amt);
echo $over_due_amt; } else { echo "0"; } ?></td>
<td style="text-align:center;"><?php if(!empty($over_due_amt)) { 
$penalty_amt = number_format($penalty_amt);
echo $penalty_amt; } else { echo "0"; } ?></td>
<td style="text-align:center;"><?php 
$gt_amt = number_format($gt_amt);
echo $gt_amt; ?></td>
</tr>
<?php } ?>
<tr>
<th colspan="3">Total</th>
<?php
for($v=0; $v<sizeof($ih_tt_amt); $v++)
{
$tt_amt = $ih_tt_amt[$v];	
?>
<th><?php 
$tt_amt = number_format($tt_amt);
echo $tt_amt; ?></th>
<?php } ?>
<th><?php 
$tt_noc_amt = number_format($tt_noc_amt);
echo $tt_noc_amt; ?></th>

<th><?php 
$tt_current_amt = number_format($tt_current_amt);
echo $tt_current_amt; ?></th>
<th><?php 
$tt_over_due_amt = number_format($tt_over_due_amt);
echo $tt_over_due_amt; ?></th>
<th><?php 
$total_penalty_amt = number_format($total_penalty_amt);
echo $total_penalty_amt; ?></th>
<th><?php 
$tt_gt_amt = number_format($tt_gt_amt);
echo $tt_gt_amt; ?></th>
</tr>
</table>
</div>
</center>



