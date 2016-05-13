<?php
$m_from = date("Y-m-d", strtotime($from));
$m_to = date("Y-m-d", strtotime($to));

$m_from = strtotime($from);
$m_to = strtotime($to);

?>
<table  width="100%" border="1">
<thead>
<tr>
<th colspan="8" style="text-align:center;"><?php echo $society_name; ?> Bank Payment Register From : <?php echo $from; ?> &nbsp;&nbsp; To : <?php echo $to; ?></th>
</tr>
<tr>
<th>Transaction Date</th>
<th>Payment Voucher</th>
<th>Paid To</th>
<th>Invoice Ref</th>
<th>Paid By</th>
<th>Cheque/UTR</th>
<th>Bank Account </th>
<th>Gross Amount (Rs.)</th>
</tr>
</thead>
<tbody>								
<?php
$total_credit = 0;
$total_debit = 0;
foreach ($cursor2 as $collection) 
{
$tds_amount=0;
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
$tds_amount=$collection['new_cash_bank']['tds_tax_amount'];

$total_tds_amount= $amount-$tds_amount;
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
</tr>
<?php  }} ?>

        <tr>
        <td colspan="7" style="text-align:right;"><b>Total</b></td>
        <td style="text-align:right;"><b><?php 
        $total_debit = number_format($total_debit);
        echo $total_debit; ?> <?php //echo "  DR"; ?></b></td>
        </tr>
        </tbody>
        </table>