<?php
$from2 = date('Y-m-d',strtotime($from));
$to2 = date('Y-m-d',strtotime($to));

$fromm = strtotime($from2);
$tomm = strtotime($to2);


?>

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

<div style="width:100%;" class="hide_at_print">
<span style="margin-left:80%;">
<a href="tds_report_excel?f=<?php echo $from; ?>&t=<?php echo $to; ?>" class="btn blue mini"><i class="icon-download"></i></a>
<a type="button" class=" printt btn green mini" onclick="window.print()"><i class="icon-print"></i></a></span>
</div>

<div style="width:100%; overflow:auto; margin-top:10px;" class="hide_at_print">
<label class="m-wrap pull-right"><input type="text" id="search" class="m-wrap medium" style="background-color:#FFF !important;" placeholder="Search"></label>	
</div>	

<table  width="100%" style=" background-color:white;" id="report_tb">
<thead>
<tr>
<th colspan="12"><?php echo $society_name; ?> TDS Payment Report Register From : <?php echo $from; ?> &nbsp;&nbsp; To : <?php echo $to; ?></th>
</tr>
<tr id="bg_color">
<th style="width:10%;">Date of Payment</th>
<th style="width:30%;">Name of Party</th>
<th>PAN Number</th>
<th>Cheque/NEFT/PG Ref</th>
<th>Net Paid</th>
<th>TDS Amount</th>
<th>Total Bill</th>
</tr>
</thead>
<tbody id="table">
<?php 
$total = 0;
$total_tds = 0;
$net_amt = 0;
foreach($cursor1 as $dataaa)
{
$transaction_date = $dataaa['new_cash_bank']['transaction_date'];	
$payment_date = date('d-m-Y',($transaction_date));
//$cheque_number = $dataaa['new_cash_bank'][''];
$user_id = (int)$dataaa['new_cash_bank']['user_id'];
$account_type = (int)$dataaa['new_cash_bank']['account_type'];
$amount = $dataaa['new_cash_bank']['amount'];
$instrument_utr = $dataaa['new_cash_bank']['receipt_instruction'];
$tds_id = (int)@$dataaa['new_cash_bank']['tds_id']; 

	foreach($tds_arr as $tds_ddd)
	{
		$tdsss_taxxx = (int)$tds_ddd[0];  
		$tds_iddd = (int)$tds_ddd[1];  
		if($tds_iddd == $tds_id) 
		{
		$tds_tax = $tdsss_taxxx;   
		}
	}
	
	$tds_amount = (round(($tds_tax/100)*$amount));
	$total_tds_amount = ($amount - $tds_amount);
	
	
	if($account_type == 1)
	{
		$result_lsa = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch')
		,array('pass'=>array($user_id)));  
		foreach ($result_lsa as $collection) 
		{
		$user_name = $collection['ledger_sub_account']['name']; 
        $service_provider_id = (int)$collection['ledger_sub_account']['sp_id'];  
		}	


$service_provider_dataa = $this->requestAction(array('controller' => 'hms', 'action' => 'service_provider_detail')
		,array('pass'=>array($service_provider_id)));  
		foreach ($service_provider_dataa as $collection) 
		{
		$pan_number = @$collection['service_provider']['pan_number']; 
       	}	

		
	}
	

else
{
	$pan_number = "";
	
	$result_lsa = $this->requestAction(array('controller' => 'hms', 'action' => 'expense_head')
	,array('pass'=>array($user_id)));  
	foreach ($result_lsa as $collection) 
	{
	$user_name = $collection['ledger_account']['ledger_name'];  
	}		
}

$total = $total+$amount;
$total_tds = $total_tds + $tds_amount;
$net_amt = $net_amt + $total_tds_amount;



?>
<tr>
<td><?php echo $payment_date; ?></td>
<td><?php echo $user_name; ?></td>
<td><?php echo @$pan_number; ?></td>
<td><?php echo $instrument_utr; ?></td>
<td style="text-align:right;"><?php $total_tds_amount2 = number_format($total_tds_amount); echo $total_tds_amount2; ?></td>
<td style="text-align:right;"><?php $tds_amount2 = number_format($tds_amount);  echo $tds_amount2; ?></td>
<td style="text-align:right;"><?php $amount2 = number_format($amount); echo $amount2; ?></td>
</tr>
<?php } ?>
<td colspan="4" style="text-align:right;"><b>Total</b></td>
<td style="text-align:right;"><b><?php $net_amt2 = number_format($net_amt); echo $net_amt2; ?></b></td>
<td style="text-align:right;"><b><?php $total_tds2 = number_format($total_tds); echo $total_tds2; ?></b></td>
<td style="text-align:right;"><b><?php $total2=number_format($total); echo $total2; ?></b></td>
</tr>
</tbody>

</table>

											
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




