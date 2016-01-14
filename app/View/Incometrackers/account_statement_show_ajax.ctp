<style>
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
}
</style>
<?php
$m_from = date("Y-m-d",strtotime($from));
$m_to = date("Y-m-d",strtotime($to));
$m_from = strtotime($m_from);
$m_to = strtotime($m_to);
?>
<?php ////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<?php 
$nnn = 55;
$result2 = $this->requestAction(array('controller' => 'hms', 'action' => 'regular_bill_fetch33'),array('pass'=>array($value)));	
foreach($result2 as $collection)
{
$bill_no = (int)$collection['new_regular_bill']['bill_no'];
$date_from = $collection['new_regular_bill']['bill_start_date'];
$date_to = $collection['new_regular_bill']['bill_end_date'];
$last_date = $collection['new_regular_bill']['due_date'];
$total_amount = (int)$collection['new_regular_bill']['due_for_payment'];
if($date_from >= $m_from && $date_from <= $m_to)
{
$nnn = 555;	
}
}

?>
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<?php 
if($nnn == 555)
{
?>
<div style="width:100%;" class="hide_at_print">
<span style="margin-left:80%;">
<a href="account_statement_excel?u=<?php echo $value; ?>&f=<?php echo $from; ?>&t=<?php echo $to; ?>" class="btn blue mini"><i class="icon-download"></i></a>
<a class=" printt btn green mini" onclick="window.print()"><i class="icon-print"></i></a></span>
</div>
<div style="width:100%; overflow:auto; margin-top:10px;" class="hide_at_print">
<label class="m-wrap pull-right"><input type="text" id="search" class="m-wrap medium" style="background-color:#FFF !important;" placeholder="Search"></label>	
</div>	
<table style="width:100%; background-color:white;" id="report_tb"> 
<thead>
<tr>
<th colspan="7" style="text-align:center;"><?php echo $society_name; ?> Account Statement Register from: <?php echo$from; ?> To: <?php echo $to; ?></th>
</tr>
<tr id="bg_color">
<th style="text-align:center;">Bill No.</th>
<th style="text-align:center;">User Name</th>
<th style="text-align:center;">Period of Bill</th>
<th style="text-align:center;">Due Date</th>
<th style="text-align:center;">Total Amount of Bill</th>
<th style="text-align:center;">Due Amount of Bill</th>
<th style="text-align:center;" class="hide_at_print">Bill View</th>
</tr>
</thead>
<tbody id="table">
<?php
$nn = 0;
$grand_total_amount=0;
$total_due_amount=0;
$result2 = $this->requestAction(array('controller' => 'hms', 'action' => 'regular_bill_fetch33'),array('pass'=>array($value)));	
foreach($result2 as $collection)
{
$nn++;
$auto_id = $collection['new_regular_bill']['auto_id'];
$bill_no = (int)$collection['new_regular_bill']['bill_no'];
$date_from = $collection['new_regular_bill']['bill_start_date'];
$date_to = $collection['new_regular_bill']['bill_end_date'];
$due_date = $collection['new_regular_bill']['due_date'];
$total_amount = (int)$collection['new_regular_bill']['due_for_payment'];
$new_total = @$collection['new_regular_bill']['new_total'];
$new_interest_on_arrears = @$collection['new_regular_bill']['new_interest_on_arrears'];
$new_arrear_maintenance = @$collection['new_regular_bill']['new_arrear_maintenance'];
$new_arrear_interest = @$collection['new_regular_bill']['new_arrear_interest'];

$due_amount = $new_total+$new_interest_on_arrears+$new_arrear_maintenance+$new_arrear_interest;


$dateff = date('d-m-Y',($date_from));
$datett = date('d-m-Y',($date_to));
$due_date = date('d-m-Y',($due_date));
 
$ledd_subb_detailll = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_subLedger_detail_via_flat_id'),array('pass'=>array($value)));
foreach($ledd_subb_detailll as $dataaa)
{
$user_name = $dataaa['ledger_sub_account']['name'];	 
}
      
$flat_detaill = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($value)));	
foreach($flat_detaill as $dattttaa)
{
$wing_id = (int)$dattttaa['flat']['wing_id'];	
}

$wing_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'),array('pass'=>array(@$wing_id,@$value)));	

if($m_from <= $date_from && $m_to >= $date_from)
{
$grand_total_amount = ($grand_total_amount)+ ($total_amount);
$total_due_amount = ($total_due_amount) + ($due_amount);

$total_amount2 = number_format($total_amount);
$due_amount2 = number_format($due_amount);
if($due_amount < 0)
{
$due_amount2 ="-".$due_amount2;	
}

?>
<tr>
<td style="text-align:center;"><?php echo @$bill_no; ?></td>
<td style="text-align:center;"><?php echo @$user_name; ?>&nbsp;&nbsp;<?php echo $wing_flat; ?></td>
<td style="text-align:center;"><?php echo @$dateff; ?>&nbsp;&nbsp;To&nbsp;&nbsp;<?php echo @$datett; ?></td>
<td style="text-align:center;"><?php echo @$due_date; ?></td>
<td style="text-align:right;"><?php echo @$total_amount2; ?></td>
<td style="text-align:right;"><?php echo @$due_amount2; ?></td>
<td><a href="regular_bill_view/<?php echo $auto_id; ?>" target="_blank" class="btn mini yellow"><i class="icon-search"></i></a></td>
</tr>
<?php
}}

$grand_total_amount = number_format($grand_total_amount);
$total_due_amount = number_format($total_due_amount);

?>
<tr>
<td colspan="4" style="text-align:right;"><b>Total</b></td>
<td style="text-align:right;"><b><?php echo $grand_total_amount; ?></b></td>
<td style="text-align:right;"><b><?php echo $total_due_amount; ?></b></td>
<td></td>
</tr>
</tbody>
</table>
<?php 
}
if($nnn == 55)
{
?>
<br /><br />
<center>
<h3 style="color:red;"><b>No Records Found in Selected Period</b></h3>
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