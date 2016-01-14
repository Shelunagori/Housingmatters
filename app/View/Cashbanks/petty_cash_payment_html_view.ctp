<?php 
foreach ($cursor1 as $collection) 
{
$receipt_no = (int)$collection['new_cash_bank']['receipt_id'];
$d_date = $collection['new_cash_bank']['transaction_date'];
$today = date("d-M-Y");
$amount = $collection['new_cash_bank']['amount'];
$society_id = (int)$collection['new_cash_bank']['society_id'];
$narration = @$collection['new_cash_bank']['narration'];
$user_id = (int)@$collection['new_cash_bank']['user_id'];
$account_type = (int)@$collection['new_cash_bank']['account_type'];
$sub_account = (int)$collection['new_cash_bank']['account_head'];
$prepaired_by = (int)$collection['new_cash_bank']['prepaired_by'];
}
$amount = str_replace( ',', '', $amount );
$am_in_words=ucwords($this->requestAction(array('controller' => 'hms', 'action' => 'convert_number_to_words'), array('pass' => array($amount))));
foreach ($cursor2 as $collection) 
{
$society_name = $collection['society']['society_name'];
$society_reg_no = $collection['society']['society_reg_num'];
$society_address = $collection['society']['society_address'];
$sig_title = $collection['society']['sig_title'];
}
$ussrr_dataa=$this->requestAction(array('controller' => 'hms', 'action' => 'user_fetch'), array('pass' => array($prepaired_by)));
foreach ($ussrr_dataa as $usssrr) 
{
$user_naammm = $usssrr['user']['user_name'];
}

if($account_type == 1)
{
$subleddger_result = $this->requestAction(array('controller' => 'hms', 'action' => 'subledger_fetch_by_auto_id'),array('pass'=>array($user_id)));
foreach ($subleddger_result as $collection) 
{
$user_name = $collection['ledger_sub_account']['name'];	  
}
}
else
{
$ledger_resullt = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_account_fetch2'),array('pass'=>array($user_id)));
foreach ($ledger_resullt as $collection) 
{
$user_name = $collection['ledger_account']['ledger_name'];	  
}	
}
	
$acc_headd = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_account_fetch2'),array('pass'=>array($sub_account)));
foreach ($acc_headd as $resull_acc) 
{
$account_head_name = $resull_acc['ledger_account']['ledger_name'];	  
}		

 
				
				
				//user info via flat_id//
				

                                    

$date=date("d-m-Y",($d_date));
?>
<div style="width:100%;" class="hide_at_print">
           <span style="margin-left:90%;"><button type="button" class=" printt btn green" onclick="window.print()"><i class="icon-print"></i> Print</button></span>
            </div>
<?php 
echo '<div style="width:70%;margin:auto;border:solid 1px;background-color:#FFF;" class="bill_on_screen">';
echo '<div align="center" style="background-color: rgb(0, 141, 210);padding: 5px;font-size: 16px;font-weight: bold;color: #fff;">'.strtoupper($society_name).'</div>
<div align="center" style="border-bottom:solid 1px;">
<span style="font-size:12px;color:rgb(100, 100, 99);">Regn# '.$society_reg_no.'</span><br/>
<span style="font-size:12px;color:rgb(100, 100, 99);">'.$society_address.'</span><br>
<span style="font-size:15px;color:rgb(100, 100, 99); font-weight:400;">Petty Cash Payment Voucher</span>
</div>
<table width="100%" >
<tr>
<td>
		<table width="100%" cellpadding="5px">
			<tr>
				<td>PCPV : #'.$receipt_no.'</td>
				<td align="right">Date: '.$date.'</td>
			</tr>
			<tr>
				<td>
				Debit To:  <b>'.$user_name.'</b>
				<br/>
				Rupees '.$am_in_words.' Only
				<br/>';
				
				
				echo '<br/>
					</td>
				<td align="right">
				<br>
				<span style="font-size:16px;"> <b>Rs '.$amount.'</b></span><br/>';
				
			echo'</td>
			</tr>
		</table>
		<div style="border-bottom:solid 1px;"></div>
		<table width="100%" cellpadding="5px">
			<tr>
				<td>
				Narration :'.$narration.'
				';
				echo '</td>
			</tr>
		</table>
		<br><br>
		<table width="100%" cellpadding="5px">
			<tr>
			<td align="center" width="33%;">Prepaired By</td>
			<td align="center" width="33%;">Approved By</td>
			<td align="center" width="33%;">Received By</td>
			</tr>
			<tr>
			<td align="center" width="33%;">
			'.$user_naammm.'
			</td>
			<td align="center" width="33%;">
			<br>
			<div style="border-top:solid 1px #333; overflow:auto; width:60%;"></div>
			</td>
			<td align="center" width="33%;">
			<br>
		   <div style="border-top:solid 1px #333; overflow:auto; width:60%;"></div>
			</td>
			</tr>
			
		</table>
		<br>
</td>
</tr>
</table>';
echo '</div>';
?>

<style>
@media screen {
    .bill_on_screen {
       width:70%;
    }
}

@media print {
    .bill_on_screen {
       width:96% !important;
    }
}
</style>