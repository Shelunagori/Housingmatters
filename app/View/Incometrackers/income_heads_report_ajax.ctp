<?php
$date1 = date("Y-m-d", strtotime($from));
//$date1 = new MongoDate(strtotime($date1));

$date2 = date("Y-m-d", strtotime($to));
//$date2 = new MongoDate(strtotime($date2)); 
?>
<?php /////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<?php
foreach($cursor9 as $collection) 
{
$charge = $collection['flat_type']['charge'];	
$income_heade_charge[] = $charge[0];
}
for($i=0; $i<sizeof($charge); $i++)
{
$inc_id = $charge[$i];
$income_head_charge[] = $inc_id[0];
}
$cnt=0;
for($y=0; $y<sizeof($income_head_charge); $y++)
{
$total[]="";	
$cnt++;	
}
$cnt = $cnt+5;
?>
<?php /////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<div style="width:100%;" class="hide_at_print">
<span style="margin-left:80%;">
<a href="income_head_report_excel?f=<?php echo $from; ?>&t=<?php echo $to; ?>" class="btn blue">Export in Excel</a>
<button type="button" class=" printt btn green" onclick="window.print()"><i class="icon-print"></i> Print</button></span>
</div>
<br />

<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<table class="table table-bordered" style="background-color:white; width:100%;">
<thead>
<tr>
<th colspan="<?php echo $cnt; ?>" style="text-align:center;"><?php echo $society_name; ?> Society</th>
</tr>
<tr>
<th style="text-align:left;">Bill No.</th>
<th style="text-align:left;">Unit Number</th>
<th style="text-align:left;">Name of Resident</th>
<th style="text-align:left;">Area (Sq.Ft.)</th>
<?php 
for($r=0; $r<sizeof($income_head_charge); $r++)
{
$abc = (int)$income_head_charge[$r];	
$ledgerac = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_account_fetch2'),array('pass'=>array($abc)));			
foreach($ledgerac as $collection2)
{
$ac_name = $collection2['ledger_account']['ledger_name'];
}
?>
<th style="text-align:left;"><?php echo $ac_name; ?></th>
<?php
}
?>
<th style="text-align:left;">Non Occupancy Charges</th>
<th style="text-align:left;">Total</th>
</tr>
<?php
$total_noc_amt = 0;
foreach($cursor2 as $collection)
{
$bill_id = $collection['regular_bill']['receipt_id'];
$user_id = (int)$collection['regular_bill']['bill_for_user'];
$ih_detail2 = $collection['regular_bill']['ih_detail'];
$noc_amt = $collection['regular_bill']['noc_charge'];
$date = $collection['regular_bill']['date'];

$result = $this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'),array('pass'=>array($user_id)));
foreach ($result as $collection) 
{
$wing_id = $collection['user']['wing'];  
$flat_id = (int)$collection['user']['flat'];
$user_name = $collection['user']['user_name'];
}

$result5 = $this->requestAction(array('controller' => 'hms', 'action' => 'flat_fetch2'),array('pass'=>array($flat_id,$wing_id)));	
foreach($result5 as $collection)
{
$area = $collection['flat']['flat_area'];
$unit_number = $collection['flat']['flat_name'];
}


	
$wing_flat = $this->requestAction(array('controller' => 'hms', 'action'=>'wing_flat'),array('pass'=>array($wing_id,$flat_id)));
if($date1 <= $date && $date2 >= $date)
{
?>
<tr>
<td style="text-align:right;"><?php echo $bill_id; ?></td>
<td style="text-align:left;"><?php echo $wing_flat; ?></td>
<td style="text-align:left;"><?php echo $user_name; ?></td>
<td style="text-align:left;"><?php echo $area; ?> Sq.Ft.</td>
<?php
$total_amt = 0;
for($y=0; $y<sizeof($income_head_charge); $y++)
{
$income_head_arr_id = $income_head_charge[$y];	
$nnn = 55;
for($r=0; $r<sizeof($ih_detail2); $r++)
{
$ih_detail1 = $ih_detail2[$r];	
$ih_id1 = $ih_detail1[0];
$amount = $ih_detail1[1];
if($income_head_arr_id == $ih_id1)
{
$total[$y] = $total[$y] + $amount;
?>
<td style="text-align:right;"><?php 
$amount2 = number_format($amount);
echo $amount2; ?></td>
<?php
$total_amt=$total_amt+$amount;
$nnn = 555;
break;
}
}
if($nnn == 55)
{
?>
<td style="text-align:right;"><?php echo "0"; ?></td>
<?php	
}
}
$total_noc_amt = $total_noc_amt + $noc_amt;
$total_amt=$total_amt+$noc_amt;
?>
<td style="text-align:right;"><?php 
$noc_amt2 = number_format($noc_amt);
echo $noc_amt2; ?></td>
<td style="text-align:right;"><?php 
$total_amt2 = number_format($total_amt);
echo $total_amt2; ?></td>
</tr>
<?php 
}
}
?>
<tr>
<th colspan="4" style="text-align:right;">Grand Total</th>
<?php 
$grand_total = 0;
for($h=0; $h<sizeof($total); $h++)
{  
?>
<th style="text-align:right;"><?php 
@$totalh2 = number_format($total[$h]);
echo @$totalh2; ?></th>
<?php 
$grand_total = $grand_total + $total[$h];
}
$grand_total = $grand_total + $total_noc_amt;
?>
<th style="text-align:right;"><?php 
$total_noc_amt2 = number_format($total_noc_amt);
echo $total_noc_amt2; ?></th>
<th style="text-align:right;"><?php 
$grand_total2 = number_format($grand_total);
echo $grand_total2; ?></th>
</tr>
</table>
















