<script>
$(document).ready(function(){
jQuery('.tooltips').tooltip();
});
</script>
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
$nnn = 55;
$m_from = date("Y-m-d", strtotime($from));
$m_to = date("Y-m-d", strtotime($to));

$m_from = strtotime($from);
$m_to = strtotime($to);


?>
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<?php
foreach ($cursor2 as $collection) 
{
$receipt_no = $collection['new_cash_bank']['receipt_id'];
$transaction_id = (int)$collection['new_cash_bank']['transaction_id'];	
$date = $collection['new_cash_bank']['transaction_date'];
$prepaired_by_id = (int)$collection['new_cash_bank']['prepaired_by'];
$user_id = (int)$collection['new_cash_bank']['user_id'];   
$invoice_reference = $collection['new_cash_bank']['invoice_reference'];
$description = $collection['new_cash_bank']['narration'];
$receipt_mode = $collection['new_cash_bank']['receipt_mode'];
$receipt_instruction = $collection['new_cash_bank']['receipt_instruction'];
$account_id = (int)$collection['new_cash_bank']['account_head'];
$amount = $collection['new_cash_bank']['amount'];
$current_date = $collection['new_cash_bank']['current_date'];		
$ac_type = $collection['new_cash_bank']['account_type'];
										
$creation_date = date('d-m-Y',strtotime($current_date));											
if($ac_type == 1)
{						
$result_lsa = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($user_id)));  
foreach ($result_lsa as $collection) 
{
$user_name = $collection['ledger_sub_account']['name'];  
}	
}											
else if($ac_type == 2)
{
$result_lsa = $this->requestAction(array('controller' => 'hms', 'action' => 'expense_head'),array('pass'=>array($user_id)));  
foreach ($result_lsa as $collection) 
{
$user_name = $collection['ledger_account']['ledger_name'];  
}	
}											
$result55 = $this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'),array('pass'=>array($prepaired_by_id)));
foreach ($result55 as $collection) 										
{
$prepaired_by_name = $collection['user']['user_name'];
}									 
									
$result_lsa2 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($account_id))); 					   
foreach ($result_lsa2 as $collection) 
{
$account_no = $collection['ledger_sub_account']['bank_account'];  
}    		
if($date >= $m_from && $date <= $m_to)
{
if($user_id == $s_user_id)
{
$nnn = 555;
}
else if($s_role_id == 3)
{
$nnn = 555;	
}
}
}
?>
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>

<?php
if($nnn == 555)
{
?>
<div style="width:100%;" class="hide_at_print">
<span style="margin-left:80%;">
<a href="bank_payment_excel?f=<?php echo $from; ?>&t=<?php echo $to; ?>" class="btn blue mini"><i class="icon-download"></i></a>
<a  class=" printt btn green mini" onclick="window.print()"><i class="icon-print"></i> </a></span>
</div>

<div style="width:100%; overflow:auto; margin-top:10px;" class="hide_at_print">
<label class="m-wrap pull-right"><input type="text" id="search" class="m-wrap medium" style="background-color:#FFF !important;" placeholder="Search"></label>	
</div>			
<table  width="100%" style=" background-color:white;" id="report_tb">
<thead>
<tr>
<th colspan="9" ><?php echo $society_name; ?> Bank Payment Register From : <?php echo $from; ?> &nbsp;&nbsp; To : <?php echo $to; ?></th>
</tr>
<tr id="bg_color">
<th>Transaction Date</th>
<th>Payment Voucher</th>
<th>Paid To</th>
<th>Invoice Ref</th>
<th>Paid By</th>
<th>Cheque/UTR</th>
<th>Bank Account </th>
<th>Gross Amount (Rs.)</th>
<th class="hide_at_print">Action</th>
</tr>
</thead>
<tbody id="table">								
<?php
$total_credit = 0;
$total_debit = 0;
foreach ($cursor2 as $collection) 
{
$receipt_no = $collection['new_cash_bank']['receipt_id'];
$transaction_id = (int)$collection['new_cash_bank']['transaction_id'];	
$date = $collection['new_cash_bank']['transaction_date'];
$prepaired_by_id = (int)$collection['new_cash_bank']['prepaired_by'];
$user_id = (int)$collection['new_cash_bank']['user_id'];   
$invoice_reference = $collection['new_cash_bank']['invoice_reference'];
$description = $collection['new_cash_bank']['narration'];
$receipt_mode = $collection['new_cash_bank']['receipt_mode'];
$receipt_instruction = $collection['new_cash_bank']['receipt_instruction'];
$account_id = (int)$collection['new_cash_bank']['account_head'];
$amount = $collection['new_cash_bank']['amount'];
$current_date = $collection['new_cash_bank']['current_date'];		
$ac_type = (int)$collection['new_cash_bank']['account_type'];
$tds_id = (int)$collection['new_cash_bank']['tds_id']; 

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


$creation_date = date('d-m-Y',strtotime($current_date));											
$ussr_dataa = $this->requestAction(array('controller' => 'hms', 'action' => 'user_fetch'),array('pass'=>array($prepaired_by_id)));  
foreach ($ussr_dataa as $ussrrr) 
{
$creater_name = $ussrrr['user']['user_name'];  
}	


if($ac_type == 1)
{
	$result_lsaaaa = $this->requestAction(array('controller' => 'Hms', 'action' => 'ledger_sub_account_fetch')
	,array('pass'=>array($user_id))); 

	foreach ($result_lsaaaa as $dataaaa) 
	{
	$user_name = $dataaaa['ledger_sub_account']['name'];  
    }

}											
else if($ac_type == 2)
{
$result_lsa = $this->requestAction(array('controller' => 'hms', 'action' => 'expense_head'),array('pass'=>array($user_id)));  
foreach ($result_lsa as $collection) 
{
$user_name = $collection['ledger_account']['ledger_name'];  
}	
}	

$result55 = $this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'),array('pass'=>array($prepaired_by_id)));
foreach ($result55 as $collection) 										
{
$prepaired_by_name = $collection['user']['user_name'];
}									 
									
$result_lsa2 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($account_id))); 					   
foreach ($result_lsa2 as $collection) 
{
$account_no = $collection['ledger_sub_account']['name'];  
}    		
if($date >= $m_from && $date <= $m_to)
{
if($s_role_id == 3)
{
$date = date('d-m-Y',($date));
$total_debit =  $total_debit + $total_tds_amount; 
$total_tds_amount = number_format($total_tds_amount);
?>
<tr>
<td><?php echo $date; ?> </td>
<td><?php echo $receipt_no; ?> </td>
<td><?php echo $user_name; ?></td>
<td><?php echo $invoice_reference; ?> </td>
<td><?php echo $receipt_mode; ?> </td>
<td><?php echo $receipt_instruction; ?> </td>
<td><?php echo $account_no; ?> </td>
<td style="text-align:right;"><?php echo $total_tds_amount; ?> </td>
<td class="hide_at_print">
<div class="btn-group">
<a class="btn blue mini" href="#" data-toggle="dropdown">
<i class="icon-chevron-down"></i>	
</a>
<ul class="dropdown-menu" style="min-width:80px !important;">
<li><a href="bank_payment_html_view/<?php echo $transaction_id; ?>" target="_blank"><i class="icon-search"></i>View</a></li>
<li><a href="bank_payment_pdf/<?php echo $transaction_id; ?>" target="_blank"><i class="icon-file"></i>Pdf</a></li>
<li><a href="bank_pyment_update/<?php echo $transaction_id; ?>"><i class="icon-edit"></i>Edit</a></li>
</ul>
</div> 

<i class="icon-info-sign tooltips" data-placement="left" data-original-title="Created by: <?php echo $creater_name; ?> 
on: <?php echo $creation_date; ?>"></i>
</td>
</tr>
<?php  }}} ?>

        <tr>
        <td colspan="7" style="text-align:right;"><b>Total</b></td>
        <td style="text-align:right;"><b><?php 
        $total_debit = number_format($total_debit);
        echo $total_debit; ?> <?php //echo "  DR"; ?></b></td>
        <td class="hide_at_print"></td>
        </tr>
        </tbody>
        </table>
											
											
											
											
											
<?php } 
if($nnn == 55)
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
											
											
											
											
											
											
											
											
											
											
											