<?php
$filename="".$socc_namm."_Supplimentry_Report_Register_".$fdddd."_".$tdddd."";
header ("Expires: 0");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=".$filename.".xls");
header ("Content-Description: Generated Report" );

$m_from = date("Y-m-d", strtotime($from));
$m_to = date("Y-m-d", strtotime($to));

$frommm = strtotime($m_from);
$tooo = strtotime($m_to);
?>

<?php

if($tp == 1)
{
?>
<table border="1">
<tr>
<th colspan="8" style="text-align:center;">
<?php echo $society_name; ?> Supplimentry Bill Register From : <?php echo $from; ?> &nbsp;&nbsp; To : <?php echo $to; ?>
</th>
</tr>
<tr>
<th>Sr No.</th>
<th>Bill No</th>
<th>Generated on</th>
<th>Bill Type</th>
<th>Member Name</th>
<th>Bill Date</th>
<th>Bill Amount</th>
<th>Narration</th>
</tr>
<?php
$grand_total = 0;
$i=0;
foreach ($cursor1 as $collection) 
{
$adhoc_bill= (int)$collection['adhoc_bill']["adhoc_bill_id"];
$receipt_id = $collection['adhoc_bill']['receipt_id'];
$date=$collection['adhoc_bill']["date"];
$residential=$collection['adhoc_bill']["residential"];
$g_total=$collection['adhoc_bill']["g_total"];
$html_bill = $collection['adhoc_bill']['html_bill'];
$bill_date_from = $collection['adhoc_bill']['bill_daterange_from'];
$description = $collection['adhoc_bill']['description'];
$bill_date_from2 = date('d-m-Y',($bill_date_from));
if($residential=="y")
{
$flat_id = (int)$collection['adhoc_bill']['person_name'];	
	
$flat_detailll = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($flat_id)));
foreach ($flat_detailll as $data) 
{
$wing_id = (int)$data['flat']['wing_id'];  
}

$ledger_subacc_detaill = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_subLedger_detail_via_flat_id'),array('pass'=>array($flat_id)));
foreach ($ledger_subacc_detaill as $dataaa) 
{
$user_name = $dataaa['ledger_sub_account']['name'];  
}
	
$wing_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat_new'),array('pass'=>array($wing_id,$flat_id)));									
$bill_for = $wing_flat;
$bill_type = "Residential";
}

if($residential=="n")
{
$flat_id = (int)$collection['adhoc_bill']['person_name'];	
$ledger_subacc_detaill = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($flat_id)));
foreach ($ledger_subacc_detaill as $dataaa) 
{
$user_name = $dataaa['ledger_sub_account']['name'];  
}	

$bill_type = "Non-residential";
$wing_flat = "";
}

if($frommm <= $bill_date_from && $tooo >= $bill_date_from)
{
$i++;
$date = date('d-m-Y',strtotime($date));
$grand_total = $grand_total + $g_total;
?>									

<tr>
<td><?php echo $i; ?></td>
<td><?php echo $receipt_id; ?></td>
<td><?php echo $date; ?></td>
<td><?php echo $bill_type; ?></td>
<td><?php echo $user_name; ?>&nbsp;&nbsp;<?php echo $wing_flat; ?> </td>
<td><?php echo $bill_date_from2; ?></td>
<td style="text-align:right;"><?php 
$g_total = number_format($g_total);
echo $g_total; ?></td>
<td><?php echo $description; ?></td>
</tr>
<?php 
}} 
?>
<tr>
<td colspan="6" style="text-align:right;"><b>Total</b></td>
<td style="text-align:right;"><b><?php 
$grand_total = number_format($grand_total);
echo $grand_total; ?></b></td>
<td></td>
</tr>
</table>
<?php
}
?>
<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<?php
if($tp == 2)
{
?>
<table border="1">
<tr>
<th colspan="7" style="text-align:center;">
<?php echo $society_name; ?> Supplimentry Bill Register From : <?php echo $from; ?> &nbsp;&nbsp; To : <?php echo $to; ?>
</th>
</tr>
<tr>
<th>Sr No.</th>
<th>Bill No</th>
<th>Generated on</th>
<th>Member Name</th>
<th>Bill Date</th>
<th>Bill Amount</th>
<th>Narration</th>
</tr>
<?php
$grand_total = 0;
$i=0;
foreach ($cursor1 as $collection) 
{
$adhoc_bill= (int)$collection['adhoc_bill']["adhoc_bill_id"];
$receipt_id = $collection['adhoc_bill']['receipt_id'];
$pay_status=$collection['adhoc_bill']["pay_status"];
$date=$collection['adhoc_bill']["date"];
$residential=$collection['adhoc_bill']["residential"];
$g_total=$collection['adhoc_bill']["g_total"];
$html_bill = $collection['adhoc_bill']['html_bill'];
$bill_date_from = $collection['adhoc_bill']['bill_daterange_from'];
$bill_date_from2 = date('d-m-Y',($bill_date_from));
$description = $collection['adhoc_bill']['description'];
if($residential=="y")
{
$flat_id = (int)$collection['adhoc_bill']['person_name'];	
	
$flat_detailll = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($flat_id)));
foreach ($flat_detailll as $data) 
{
$wing_id = (int)$data['flat']['wing_id'];  
}

$ledger_subacc_detaill = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_subLedger_detail_via_flat_id'),array('pass'=>array($flat_id)));
foreach ($ledger_subacc_detaill as $dataaa) 
{
$user_name = $dataaa['ledger_sub_account']['name'];  
}
	
$wing_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat_new'),array('pass'=>array($wing_id,$flat_id)));									
$bill_for = $wing_flat;
$bill_type = "Residential";

if($frommm <= $bill_date_from && $tooo >= $bill_date_from)
{
$i++;
$date = date('d-m-Y',strtotime($date));
$grand_total = $grand_total + $g_total;
?>
<tr>
<td><?php echo $i; ?></td>
<td><?php echo $receipt_id; ?></td>
<td><?php echo $date; ?></td>
<td><?php echo $user_name; ?>&nbsp;&nbsp;<?php echo $wing_flat; ?> </td>
<td><?php echo $bill_date_from2; ?></td>
<td style="text-align:right;"><?php
$g_total = number_format($g_total);
 echo $g_total; ?></td>
 <td><?php echo $description; ?></td>
</tr>
<?php }}} ?>
<tr>
<td colspan="5" style="text-align:right;"><b>Total</b></td>
<td style="text-align:right;"><b><?php 
$grand_total = number_format($grand_total);
echo $grand_total; ?></b></td>
<td></td>
</tr>
</table>

<?php
}
?>

<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>

<?php
if($tp == 3)
{
?>	
<table border="1">

<tr>
<th colspan="7" style="text-align:center;">
<?php echo $society_name; ?> Supplimentry Bill Register From : <?php echo $from; ?> &nbsp;&nbsp; To : <?php echo $to; ?>
</th>
</tr>
<tr>
<th>Sr No.</th>
<th>Bill No</th>
<th>Generated on</th>
<th>Member Name</th>
<th>Bill Date</th>
<th>Bill Amount</th>
<th>Narration</th>
</tr>	
<?php
$grand_total = 0;
$i=0;
foreach ($cursor1 as $collection) 
{
$adhoc_bill= (int)$collection['adhoc_bill']["adhoc_bill_id"];
$receipt_id = $collection['adhoc_bill']['receipt_id'];
$pay_status=$collection['adhoc_bill']["pay_status"];
$date=$collection['adhoc_bill']["date"];
$residential=$collection['adhoc_bill']["residential"];
$g_total=$collection['adhoc_bill']["g_total"];
$html_bill = $collection['adhoc_bill']['html_bill'];
$bill_date_from = $collection['adhoc_bill']['bill_daterange_from'];
$description = $collection['adhoc_bill']['description'];
$bill_date_from2 = date('d-m-Y',($bill_date_from));
if($residential=="n")
{
$flat_id = (int)$collection['adhoc_bill']['person_name'];	
$ledger_subacc_detaill = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($flat_id)));
foreach ($ledger_subacc_detaill as $dataaa) 
{
$user_name = $dataaa['ledger_sub_account']['name'];  
}	

$bill_type = "Non-residential";
$wing_flat = "";
if($frommm <= $bill_date_from && $tooo >= $bill_date_from)
{
$i++;
$date = date('d-m-Y',strtotime($date));
$grand_total = $grand_total + $g_total;

?>
<tr>
<td><?php echo $i; ?></td>
<td><?php echo $receipt_id; ?></td>
<td><?php echo $date; ?></td>
<td><?php echo $user_name; ?>&nbsp;&nbsp;<?php echo $wing_flat; ?> </td>
<td><?php echo $bill_date_from2; ?></td>
<td style="text-align:right;"><?php 
$g_total = number_format($g_total);
echo $g_total; ?></td>
<td><?php echo $description; ?></td>
</tr>
<?php }}} ?>
<tr>
<td colspan="5" style="text-align:right;"><b>Total</b></td>
<td style="text-align:right;"><b><?php 
$grand_total = number_format($grand_total);
echo $grand_total; ?></b></td>
<td></td>
</tr>
</table>
<?php
}
?>