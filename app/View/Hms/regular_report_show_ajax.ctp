<?php
$m_from = date("Y-m-d", strtotime($from));
$m_from = new MongoDate(strtotime($m_from));

$m_to = date("Y-m-d", strtotime($to));
$m_to = new MongoDate(strtotime($m_to));
?>

<div style="width:100%;" class="hide_at_print">
<span style="margin-left:80%;">
<?php
if($wise == 1)
{
?>
<a href="regular_bill_excel?f=<?php echo $from; ?>&t=<?php echo $to; ?>&w=<?php echo $wise; ?>&wi=<?php echo $wing; ?>" class="btn blue">Export in Excel</a>
<?php
}
else if($wise == 2)
{
?>
<a href="regular_bill_excel?f=<?php echo $from; ?>&t=<?php echo $to; ?>&w=<?php echo $wise; ?>&u=<?php echo $user_id; ?>" class="btn blue">Export in Excel</a>
<?php	
}
?>
<button type="button" class=" printt btn green" onclick="window.print()"><i class="icon-print"></i> Print</button></span>
</div>
<br />
<table class="table table-bordered" style="background-color:white;">
<tr>
<th colspan="8" style="text-align:center;">
<p style="font-size:16px;">
Regular Bill Report  (<?php echo $society_name; ?>)
</p>
</th>
</tr>
<tr>
<th>#</th>
<th>Generated on</th>
<th>Flat</th>
<th>Member Name</th>
<th>Period From</th>
<th>Period To</th>
<th>Bill Amount</th>
<th class="hide_at_print">Details</th>
</tr>
<?php
$grand_total = 0;
$i=0; 
foreach ($cursor1 as $collection) 
{
$i++;
$one_time_id =(int)$collection['regular_bill']["one_time_id"];
$regular_bill_id=(int)$collection['regular_bill']["regular_bill_id"];
$bill_daterange_from=$collection['regular_bill']["bill_daterange_from"];
$bill_daterange_from2= date('d-m-Y', $bill_daterange_from->sec);
$bill_daterange_to=$collection['regular_bill']["bill_daterange_to"];
$bill_daterange_to2= date('d-m-Y', $bill_daterange_to->sec);
$bill_for_user=(int)$collection['regular_bill']["bill_for_user"];
$bill_html=$collection['regular_bill']["bill_html"];
$g_total=$collection['regular_bill']["g_total"];
$date=$collection['regular_bill']["date"]; 
$pay_status=(int)@$collection['regular_bill']["pay_status"];

$result = $this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'),array('pass'=>array($bill_for_user)));				
foreach ($result as $collection) 
{
$user_name = $collection['user']['user_name'];
$wing_id = $collection['user']['wing'];  
$flat_id = (int)$collection['user']['flat'];
$tenant = (int)$collection['user']['tenant'];
}	
$wing_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'),array('pass'=>array($wing_id,$flat_id)));
if($wise == 2)
{									
if($bill_for_user == $user_id)
{
if($m_from <= $date && $m_to >= $date)
{
$date = date('d-m-Y', $date->sec);						
$grand_total = $grand_total + $g_total;
?>

<tr>
<td><?php echo $i; ?></td>
<td><?php echo $date; ?></td>
<td><?php echo $wing_flat; ?></td>
<td><?php echo $user_name; ?></td>
<td><?php echo $bill_daterange_from2; ?></td>
<td><?php echo $bill_daterange_to2; ?></td>
<td><?php 
$g_total = number_format($g_total);
echo $g_total; ?></td>
<td class="hide_at_print"><a href="regular_bill_view?bill=<?php echo $regular_bill_id; ?>" class="btn mini yellow" target="_blank">View</a>
<a href="regular_bill_pdf?p=<?php echo $regular_bill_id; ?>" class="btn mini purple" target="_blank">Pdf</a>
</td>			
</tr>
									
<?php }}}
else if($wise == 1)
{
if($wing_id == $wing)
{	
if($m_from <= $date && $m_to >= $date)
{
$date = date('d-m-Y', $date->sec);						
$grand_total = $grand_total + $g_total;	
	
?>	
<tr>
<td><?php echo $i; ?></td>
<td><?php echo $date; ?></td>
<td><?php echo $wing_flat; ?></td>
<td><?php echo $user_name; ?></td>
<td><?php echo $bill_daterange_from2; ?></td>
<td><?php echo $bill_daterange_to2; ?></td>
<td><?php 
$g_total = number_format($g_total);
echo $g_total; ?></td>
<td class="hide_at_print"><a href="regular_bill_view?bill=<?php echo $regular_bill_id; ?>" class="btn mini yellow" target="_blank">View</a>
<a href="regular_bill_pdf?p=<?php echo $regular_bill_id; ?>" class="btn mini purple" target="_blank">Pdf</a>
</td>			
</tr>	
<?php 	
}
}
}
}
 ?>
<tr>
<th colspan="6">Grand Total</th>
<th><?php 
$grand_total = number_format($grand_total);
echo $grand_total; ?></th>
<th class="hide_at_print"></th>
</tr>
</table>
































