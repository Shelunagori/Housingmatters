<?php

$from1 = date("Y-m-d", strtotime($from));
$from1 = strtotime($from1);
$to1 = date("Y-m-d", strtotime($to));
$to1 = strtotime($to1);  ?>
<style>

<!--
#bg_color th{
font-size: 10px !important;background-color:#C8EFCE;padding:2px;border:solid 1px #55965F;
}
#report_tb td{
padding:2px;
font-size: 12px;border:solid 1px #55965F;background-color:#FFF;
}
.text_bx{
width: 50px;
height: 15px !important;
margin-bottom: 0px !important;
font-size: 12px;
}
.text_rdoff{
width: 50px;
height: 15px !important;
border: none !important;
margin-bottom: 0px !important;
font-size: 12px;
}-->
</style>
<?php
 /////////////////////////////////////////////////////////////////////////////////////////////// ?>
<?php 
$nnn = 55;
?>
<?php 
if($wise == 2)
{
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
	
	$flat_detailll = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($flat_id)));				
	foreach ($flat_detailll as $collection2) 
	{
	$wing_id = (int)$collection2['flat']['wing_id'];  
	}	

if($wise == 2)
{
if($user_id == $flat_id)
{
if($date_from >= $from1 && $date_from <= $to1)
{
	if($due_amt > 0)
	{
	$nnn = 555;
	}
}
}
}
}}
else
{
foreach($result_flat as $data)	
{
	$due_amt=0;
$total_amt=0;
$new_arrear_intrest = 0;
$new_intrest_on_arrears = 0;
$new_total = 0;
$new_arrear_maintenance = 0;
$flat_id = (int)$data['flat']['flat_id'];	
$regular_data = $this->requestAction(array('controller' => 'hms', 'action' => 'new_regular_bill_detail_via_flat_id'),array('pass'=>array($flat_id)));				
foreach ($regular_data as $collection) 
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
}	
if(empty($new_total) && empty($new_intrest_on_arrears) && empty($new_arrear_maintenance) && empty($new_arrear_intrest))
{
$due_amt = $total_amt;	
}
else
{
$due_amt = (($new_arrear_intrest)+($new_arrear_maintenance)+($new_intrest_on_arrears)+($new_total));
}

$flat_detailll = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($flat_id)));				
foreach ($flat_detailll as $collection2) 
{
$wing_id = (int)$collection2['flat']['wing_id'];  
}		
if(@$date_from >= $from1 && @$date_from <= $to1)
{
if($due_amt > 0)
{
$nnn = 555;	
}
}	
}
}
?>
<?php //////////////////////////////////////////////////////////////////////////////////////////////// ?>
<?php  if($nnn == 555) { ?>

<div style="width:100%;" class="hide_at_print">
<?php
if($wise == 1)
{
?>
<span style="float:right;"> <a href="overdue_excel?f=<?php echo $from; ?>&t=<?php echo $to; ?>&w=<?php echo $wise; ?>&wi=<?php echo $wing; ?>" class="btn blue mini"><i class="icon-download"></i></a></span>
<?php
}
else if($wise == 2)
{
?>
<span style="float:right;"> <a href="overdue_excel?f=<?php echo $from; ?>&t=<?php echo $to; ?>&w=<?php echo $wise; ?>&u=<?php echo $user_id; ?>" class="btn blue mini"><i class="icon-download"></i></a></span>
<?php 
}
?>
<span style="float:right; margin-right:1%;"><a type="button" class=" printt btn green mini" onclick="window.print()"><i class="icon-print"></i></a></span>
</div>
<br /><br />
<div style="width:100%; overflow:auto; margin-top:10px;" class="hide_at_print">
<label class="m-wrap pull-right"><input type="text" id="search" class="m-wrap medium" style="background-color:#FFF !important;" placeholder="Search"></label>	
</div>
<?php
if($wise == 2)
{
?>
<table class="table table-bordered table-striped table-hover" style="width:100%; background-color:white;">
<thead>
<tr>
<th colspan="8" style="text-align:center;">
Over Due Report  (<?php echo $society_name; ?> Society)
</th>
</tr>
<tr>
<th style="text-align:center;">Bill No</th>
<th style="text-align:center;">Name of Owner</th>
<th style="text-align:center;">Bill Date</th>
<th style="text-align:center;">Due date</th>
<th style="text-align:center;">Bill Amount</th>
<th style="text-align:center;">Due Amount</th>
<th style="text-align:center;" class="hide_at_print">Bill View</th>
</tr>
</thead>
<tbody id="table">
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
<td style="text-align:center;"><?php echo $bill_no; ?></td>
<td style="text-align:center;"><?php echo $user_name; ?> &nbsp;&nbsp; <?php echo $wing_flat; ?></td>
<td style="text-align:center;"><?php echo $bill_start_date; ?></td>
<td style="text-align:center;"><?php echo $due_date2; ?></td>
<td style="text-align:right;"><?php echo $total_amt; ?></td>
<td style="text-align:right;"><?php echo $due_amt2; ?></td>
<td style="text-align:left;" class="hide_at_print">
    <div class="btn-group">
	<a class="btn blue mini" href="#" data-toggle="dropdown">
	<i class="icon-chevron-down"></i>	
	</a><ul class="dropdown-menu" style="min-width:80px !important;">
	<li><a href="regular_bill_view/<?php echo $auto_id; ?>" target="_blank"><i class="icon-search"></i> View</a></li>
	</ul>
	</div>
</td>
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
<td style="text-align:center;"><?php echo $bill_no; ?></td>
<td style="text-align:center;"><?php echo $user_name; ?> &nbsp;&nbsp; <?php echo $wing_flat; ?></td>
<td style="text-align:center;"><?php echo $bill_start_date; ?></td>
<td style="text-align:center;"><?php echo $due_date2; ?></td>
<td style="text-align:right;"><?php echo $total_amt; ?></td>
<td style="text-align:right;"><?php echo $due_amt2; ?></td>
<td style="text-align:left;" class="hide_at_print">

 <div class="btn-group">
	<a class="btn blue mini" href="#" data-toggle="dropdown">
	<i class="icon-chevron-down"></i>	
	</a><ul class="dropdown-menu" style="min-width:80px !important;">
	<li><a href="regular_bill_view/<?php echo $auto_id; ?>" target="_blank"><i class="icon-search"></i> View</a></li>
	</ul>
	</div>
</td>
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
<td style="text-align:right;" class="hide_at_print"></td>
</tr>
</tbody>
</table>
<?php }else 
{ ?>
<table class="table table-bordered table-striped table-hover" style="width:100%; background-color:white;">
<thead>
<tr>
<th colspan="8" style="text-align:center;">
Over Due Report  (<?php echo $society_name; ?> Society)
</th>
</tr>
<tr>
<th style="text-align:center;">Bill No</th>
<th style="text-align:center;">Name of Owner</th>
<th style="text-align:center;">Bill Date</th>
<th style="text-align:center;">Due date</th>
<th style="text-align:center;">Bill Amount</th>
<th style="text-align:center;">Due Amount</th>
<th style="text-align:center;" class="hide_at_print">Bill View</th>
</tr>
</thead>
<tbody id="table">	
<?php
$c=0;
$total_due_amt = 0;
$total_bill_amt = 0;	
foreach($result_flat as $data)	
{
$flat_id = (int)$data['flat']['flat_id'];	
$due_amt=0;
$total_amt=0;
$new_arrear_intrest = 0;
$new_intrest_on_arrears = 0;
$new_total = 0;
$new_arrear_maintenance = 0;
$regular_data = $this->requestAction(array('controller' => 'hms', 'action' => 'new_regular_bill_detail_via_flat_id'),array('pass'=>array($flat_id)));				
foreach ($regular_data as $collection) 
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
}
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
<td style="text-align:center;"><?php echo $bill_no; ?></td>
<td style="text-align:center;"><?php echo $user_name; ?> &nbsp;&nbsp; <?php echo $wing_flat; ?></td>
<td style="text-align:center;"><?php echo $bill_start_date; ?></td>
<td style="text-align:center;"><?php echo $due_date2; ?></td>
<td style="text-align:right;"><?php echo $total_amt; ?></td>
<td style="text-align:right;"><?php echo $due_amt2; ?></td>
<td style="text-align:left;" class="hide_at_print">

 <div class="btn-group">
	<a class="btn blue mini" href="#" data-toggle="dropdown">
	<i class="icon-chevron-down"></i>	
	</a><ul class="dropdown-menu" style="min-width:80px !important;">
	<li><a href="regular_bill_view/<?php echo $auto_id; ?>" target="_blank"><i class="icon-search"></i> View</a></li>
	</ul>
	</div>
</td>
</tr>
<?php
}
}
}

$total_due_amt = number_format($total_due_amt);
$total_bill_amt = number_format($total_bill_amt);
?>
<tr>
<td style="text-align:right;" colspan="4"><b>Total</b></td>
<td style="text-align:right;"><b><?php echo $total_bill_amt; ?></b></td>
<td style="text-align:right;"><b><?php echo $total_due_amt; ?></b></td>
<td style="text-align:right;" class="hide_at_print"></td>
</tr>
</tbody>
</table>
<?php

	
} ?>
<?php } 
else if($nnn == 55)
{
?>
<br /><br />											
<center>
<h3 style="color:red;">
<b>No Records Found in Selected Period</b>
</h3>
</center>
<br /><br />
<?php 
}
?>

<script>
var $rows = $('#table tr');
$('#search').keyup(function() {
var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
$rows.show().filter(function() {
var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
return !~text.indexOf(val);
}).hide();
});
</script>