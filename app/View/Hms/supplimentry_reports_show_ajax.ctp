<?php
$m_from = date("Y-m-d", strtotime($from));
$m_from = new MongoDate(strtotime($m_from));

$m_to = date("Y-m-d", strtotime($to));
$m_to = new MongoDate(strtotime($m_to));
?>


<div style="width:100%;" class="hide_at_print">
<span style="margin-left:80%;">
<a href="supplimentry_bill_excel?f=<?php echo $from; ?>&t=<?php echo $to; ?>&tp=<?php echo $tp; ?>" class="btn blue">Export in Excel</a>
<button type="button" class=" printt btn green" onclick="window.print()"><i class="icon-print"></i> Print</button></span>
</div>
<br />

<?php
if($tp == 1)
{
?>
<table class="table table-bordered" style="background-color:white;">
<tr>
<th colspan="8" style="text-align:center;">
<p style="font-size:16px;">
Supplimentry Bill Report (<?php echo $society_name; ?>)
</p>
</th>
</tr>
<tr>
<th>Sr No.</th>
<th>Bill No</th>
<th>Generated on</th>
<th>Bill Type</th>
<th>Member Name</th>
<th>Bill Date</th>
<!--<th>Period To</th> -->
<th>Bill Amount</th>
<th class="hide_at_print">View</th>
</tr>
<?php

$grand_total = 0;
$i=0;
foreach ($cursor1 as $collection) 
{

$adhoc_bill= (int)$collection['adhoc_bill']["adhoc_bill_id"];
$pay_status=$collection['adhoc_bill']["pay_status"];
$date=$collection['adhoc_bill']["date"];
$residential=$collection['adhoc_bill']["residential"];
$g_total=$collection['adhoc_bill']["g_total"];
$html_bill = $collection['adhoc_bill']['bill_html'];
$bill_date_from = $collection['adhoc_bill']['bill_daterange_from'];
//$bill_date_to = $collection['adhoc_bill']['bill_daterange_to'];
$bill_date_from2 = date('d-m-Y',$bill_date_from->sec);
//$bill_date_to2 = date('d-m-Y',$bill_date_to->sec);

if($residential=="y")
{
$d_user_id=(int)$collection['adhoc_bill']["person_name"];
$result_user55 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($d_user_id)));
foreach($result_user55 as $collection)
{
$d_user_id2 = (int)$collection['ledger_sub_account']['user_id'];	
}
$result_user = $this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'),array('pass'=>array($d_user_id2)));
foreach ($result_user as $collection) 
{
$wing_id = (int)$collection['user']['wing'];  
$flat_id = (int)$collection['user']['flat'];
$user_name = $collection['user']['user_name'];
}	
$wing_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'),array('pass'=>array($wing_id,$flat_id)));									
$bill_for = $wing_flat;

$bill_type = "Residential";
}



if($residential=="n")
{
$user_name=$collection['adhoc_bill']["person_name"];
//$bill_for="Non-residential";
$bill_type = "Non-residential";
$wing_flat = "";
}

if($m_from <= $date && $m_to >= $date)
{
$i++;
$date = date('d-m-Y',$date->sec);
$grand_total = $grand_total + $g_total;
?>									

<tr>
<td><?php echo $i; ?></td>
<td><?php echo $adhoc_bill; ?></td>
<td><?php echo $date; ?></td>
<td><?php echo $bill_type; ?></td>
<td><?php echo $user_name; ?>&nbsp;&nbsp;<?php echo $wing_flat; ?> </td>
<td><?php echo $bill_date_from2; ?></td>
<!--<td><?php echo $bill_date_to2; ?></td> -->
<td><?php 
$g_total = number_format($g_total);
echo $g_total; ?></td>
<td class="hide_at_print"><a href="supplimentry_bill_view?bill=<?php echo $adhoc_bill; ?>" class="btn mini yellow" target="_blank">View</a>
<a href="supplimentry_bill_pdf?p=<?php echo $adhoc_bill; ?>" class="btn mini purple" target="_blank">Pdf</a>
</td>
</tr>
<?php }} ?>
<tr>
<th colspan="6">Total</th>
<th><?php 
$grand_total = number_format($grand_total);
echo $grand_total; ?></th>
<th class="hide_at_print"></th>
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
<table class="table table-bordered" style="background-color:white;">

<tr>
<th colspan="8" style="text-align:center;">
<p style="font-size:16px;">
Supplimentry Bill Report (<?php echo $society_name; ?>)
</p>
</th>
</tr>

<tr>
<th>Sr No.</th>
<th>Bill No</th>
<th>Generated on</th>
<th>Member Name</th>
<th>Bill Date</th>
<!--<th>Period To</th> -->
<th>Bill Amount</th>
<th class="hide_at_print">View</th>
</tr>
<?php
$grand_total = 0;
$i=0;
foreach ($cursor1 as $collection) 
{

$adhoc_bill= (int)$collection['adhoc_bill']["adhoc_bill_id"];
$pay_status=$collection['adhoc_bill']["pay_status"];
$date=$collection['adhoc_bill']["date"];
$residential=$collection['adhoc_bill']["residential"];
$g_total=$collection['adhoc_bill']["g_total"];
$html_bill = $collection['adhoc_bill']['bill_html'];
$bill_date_from = $collection['adhoc_bill']['bill_daterange_from'];
//$bill_date_to = $collection['adhoc_bill']['bill_daterange_to'];
$bill_date_from2 = date('d-m-Y',$bill_date_from->sec);
//$bill_date_to2 = date('d-m-Y',$bill_date_to->sec);


if($residential=="y")
{
$d_user_id=(int)$collection['adhoc_bill']["person_name"];
$result_user55 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($d_user_id)));
foreach($result_user55 as $collection)
{
$d_user_id2 = (int)$collection['ledger_sub_account']['user_id'];	
}
$result_user = $this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'),array('pass'=>array($d_user_id2)));
foreach ($result_user as $collection) 
{
$wing_id = (int)$collection['user']['wing'];  
$flat_id = (int)$collection['user']['flat'];
$user_name = $collection['user']['user_name'];
}	
$wing_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'),array('pass'=>array($wing_id,$flat_id)));									
$bill_for = $wing_flat;

$bill_type = "Residential";

if($m_from <= $date && $m_to >= $date)
{
	$i++;
$date = date('d-m-Y',$date->sec);
$grand_total = $grand_total + $g_total;
?>
<tr>
<td><?php echo $i; ?></td>
<td><?php echo $adhoc_bill; ?></td>
<td><?php echo $date; ?></td>
<td><?php echo $user_name; ?>&nbsp;&nbsp;<?php echo $wing_flat; ?> </td>
<td><?php echo $bill_date_from2; ?></td>
<!--<td><?php echo $bill_date_to2; ?></td>-->
<td><?php
$g_total = number_format($g_total);
 echo $g_total; ?></td>
<td class="hide_at_print"><a href="supplimentry_bill_view?bill=<?php echo $adhoc_bill; ?>" class="btn mini yellow" target="_blank">View</a>
<a href="supplimentry_bill_pdf?p=<?php echo $adhoc_bill; ?>" class="btn mini purple" target="_blank">Pdf</a>
</td>
</tr>
<?php }}} ?>
<tr>
<th colspan="5">Total</th>
<th><?php 
$grand_total = number_format($grand_total);
echo $grand_total; ?></th>
<th class="hide_at_print"></th>
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
<table class="table table-bordered" style="background-color:white;">

<tr>
<th colspan="8" style="text-align:center;">
<p style="font-size:16px;">
Supplimentry Bill Report (<?php echo $society_name; ?>)
</p>
</th>
</tr>

<tr>
<th>Sr No.</th>
<th>Bill No</th>
<th>Generated on</th>
<th>Member Name</th>
<th>Bill Date</th>
<!--<th>Period To</th> -->
<th>Bill Amount</th>
<th class="hide_at_print">View</th>
</tr>	
<?php
$grand_total = 0;
$i=0;
foreach ($cursor1 as $collection) 
{

$adhoc_bill= (int)$collection['adhoc_bill']["adhoc_bill_id"];
$pay_status=$collection['adhoc_bill']["pay_status"];
$date=$collection['adhoc_bill']["date"];
$residential=$collection['adhoc_bill']["residential"];
$g_total=$collection['adhoc_bill']["g_total"];
$html_bill = $collection['adhoc_bill']['bill_html'];
$bill_date_from = $collection['adhoc_bill']['bill_daterange_from'];
//$bill_date_to = $collection['adhoc_bill']['bill_daterange_to'];
$bill_date_from2 = date('d-m-Y',$bill_date_from->sec);
//$bill_date_to2 = date('d-m-Y',$bill_date_to->sec);	
if($residential=="n")
{
$user_name=$collection['adhoc_bill']["person_name"];
//$bill_for="Non-residential";
$bill_type = "Non-residential";
$wing_flat = "";

if($m_from <= $date && $m_to >= $date)
{
$i++;
$date = date('d-m-Y',$date->sec);
$grand_total = $grand_total + $g_total;

?>
<tr>
<td><?php echo $i; ?></td>
<td><?php echo $adhoc_bill; ?></td>
<td><?php echo $date; ?></td>
<td><?php echo $user_name; ?>&nbsp;&nbsp;<?php echo $wing_flat; ?> </td>
<td><?php echo $bill_date_from2; ?></td>
<!--<td><?php echo $bill_date_to2; ?></td> -->
<td><?php 
$g_total = number_format($g_total);
echo $g_total; ?></td>
<td class="hide_at_print"><a href="supplimentry_bill_view?bill=<?php echo $adhoc_bill; ?>" class="btn mini yellow" target="_blank">View</a>
<a href="supplimentry_bill_pdf?p=<?php echo $adhoc_bill; ?>" class="btn mini purple" target="_blank">Pdf</a>
</td>
</tr>
<?php }}} ?>
<tr>
<th colspan="5">Total</th>
<th><?php 
$grand_total = number_format($grand_total);
echo $grand_total; ?></th>
<th class="hide_at_print"></th>
</tr>
</table>
<?php
}
?>
