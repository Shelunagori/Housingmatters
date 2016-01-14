
<?php
$from1 = date("Y-m-d", strtotime($from));
$from1 = strtotime($from1);
$to1 = date("Y-m-d", strtotime($to));
$to1 = strtotime($to1);  

$fdddd = date('d-M-Y',strtotime($from));
$tdddd = date('d-M-Y',strtotime($to));

$socc_namm = str_replace(' ', '_', $society_name);
	
	$filename="".$socc_namm."OverDue_Report".$fdddd."_".$tdddd."";
	header ("Expires: 0");
	header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
	header ("Cache-Control: no-cache, must-revalidate");
	header ("Pragma: no-cache");
	header ("Content-type: application/vnd.ms-excel");
	header ("Content-Disposition: attachment; filename=".$filename.".xls");
	header ("Content-Description: Generated Report" );
	
	
	
	?>
<table style="width:100%; background-color:white;" border="1">
<tr>
<th colspan="6" style="text-align:center;">
<p style="font-size:14px;">
Over Due Report  (<?php echo $society_name; ?> Society)</p>
</th>
</tr>
<tr>
<th style="text-align:left;">Bill No</th>
<th style="text-align:left;">Name of Owner</th>
<th style="text-align:left;">Bill Date</th>
<th style="text-align:left;">Due date</th>
<th style="text-align:left;">Bill Amount</th>
<th style="text-align:left;">Due Amount</th>
</tr>
<?php 
$c=0;
$total_due_amt = 0;
$total_bill_amt = 0;
foreach($cursor1 as $collection)
{
$auto_id = (int)@$collection['new_regular_bill']['auto_id'];
$bill_no = @$collection['new_regular_bill']['bill_no'];	
$date_from = @$collection['new_regular_bill']['bill_start_date'];	
$date_to = @$collection['new_regular_bill']['bill_daterange_to'];	
$due_date = @$collection['new_regular_bill']['due_date'];	
$total_amt = (int)@$collection['new_regular_bill']['due_for_payment'];
$flat_id = (int)@$collection['new_regular_bill']['flat_id'];
$date = @$collection['new_regular_bill']['date'];
$new_arrear_intrest = @$collection['new_regular_bill']['new_arrear_intrest'];
$new_arrear_maintenance = @$collection['new_regular_bill']['new_arrear_maintenance'];
$new_intrest_on_arrears = @$collection['new_regular_bill']['new_intrest_on_arrears'];
$new_total = @$collection['new_regular_bill']['new_total'];

if(empty($new_total) && empty($new_intrest_on_arrears) && empty($new_arrear_maintenance) && empty($new_arrear_intrest))
{
$due_amt = $total_amt;	
}
else
{
$due_amt = (($new_arrear_intrest)+($new_arrear_maintenance)+($new_intrest_on_arrears)+($new_total));
}

$total_amount = $total_amt;
$bill_start_date = date('d-M-Y',($date_from));
$due_date2 = date('d-M-Y',($due_date));

$flat_detailll = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($flat_id)));				
foreach ($flat_detailll as $collection2) 
{
$wing_id = (int)$collection2['flat']['wing_id']; 
}				

$ledger_sub_accc = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_subLedger_detail_via_flat_id'),array('pass'=>array($flat_id)));				
foreach ($ledger_sub_accc as $dataaaa) 
{
$user_name = $dataaaa['ledger_sub_account']['name']; 
}	
$wing_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat_new'),array('pass'=>array($wing_id,$flat_id)));				


if($wise == 2)
{
if($user_id == $flat_id)
{
if($date_from >= $from1 && $date_from <= $to1)
{
if($due_amt > 0)
{
	$total_bill_amt = $total_bill_amt+$total_amt;
	$total_due_amt=$total_due_amt+$due_amt;
	
	$total_amt = number_format($total_amt);
	$due_amt2 = number_format($due_amt);
	
	
?>
<tr>
<td style="text-align:right;"><?php echo $bill_no; ?></td>
<td style="text-align:left;"><?php echo $user_name; ?> &nbsp;&nbsp; <?php echo $wing_flat; ?></td>
<td style="text-align:left;"><?php echo $bill_start_date; ?></td>
<td style="text-align:left;"><?php echo $due_date2; ?></td>
<td style="text-align:right;"><?php echo $total_amt; ?></td>
<td style="text-align:right;"><?php echo $due_amt2; ?></td>
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
if($date_from >= $from1 && $date_from <= $to1)
{
if($due_amt > 0)
{
$total_bill_amt = $total_bill_amt+$total_amt;
$total_due_amt=$total_due_amt+$due_amt;

$total_amt = number_format($total_amt);
$due_amt2 = number_format($due_amt);

?>
<tr>
<td style="text-align:right;"><?php echo $bill_no; ?></td>
<td style="text-align:left;"><?php echo $user_name; ?> &nbsp;&nbsp; <?php echo $wing_flat; ?></td>
<td style="text-align:left;"><?php echo $bill_start_date; ?></td>
<td style="text-align:left;"><?php echo $due_date2; ?></td>
<td style="text-align:right;"><?php echo $total_amt; ?></td>
<td style="text-align:right;"><?php echo $due_amt2; ?></td>
</tr>
<?php
}
}
}
}
}
?>
<?php 

$total_due_amt = number_format($total_due_amt);
$total_bill_amt = number_format($total_bill_amt);
?>
<tr>
<td style="text-align:right;" colspan="4"><b>Total</b></td>
<td style="text-align:right;"><b><?php echo $total_bill_amt; ?></b></td>
<td style="text-align:right;"><b><?php echo $total_due_amt; ?></b></td>
</tr>
</table>