<a href="#" class="btn green pull-right hide_at_print" role="button" onclick="window.print()"><i class="icon-print"></i> Print All</a>
<?php 
foreach($result_new_regular_bill as $regular_bill){
	echo '<div style="height: 8px;"></div>';
	$one_time_id=(int)$regular_bill["new_regular_bill"]["one_time_id"];
	if($one_time_id==5){
		echo '<div>';
	}
	echo $bill_html=$regular_bill["new_regular_bill"]["bill_html"];
	$flat_id=$regular_bill["new_regular_bill"]["flat_id"];
	
	

$one_time_id--;	
$result_new_cash_bank = $this->requestAction(array('controller' => 'Incometrackers', 'action' => 'fetch_last_receipt_info_via_flat_id'),array('pass'=>array($flat_id,$one_time_id)));
$count = sizeof($result_new_cash_bank);
if($count > 0)
{
foreach($result_new_cash_bank as $collection)
{
$receipt_no = (int)$collection['new_cash_bank']['receipt_id'];
$d_date = $collection['new_cash_bank']['receipt_date'];
$today = date("d-M-Y");
$flat_id = $collection['new_cash_bank']['party_name_id'];
$amount = $collection['new_cash_bank']['amount'];
$society_id = (int)$collection['new_cash_bank']['society_id'];
$bill_reference = $collection['new_cash_bank']['reference_utr'];
$narration = @$collection['new_cash_bank']['narration'];
$member = (int)$collection['new_cash_bank']['member_type'];
$receiver_name = @$collection['new_cash_bank']['receiver_name'];
$receipt_mode = $collection['new_cash_bank']['receipt_mode'];
$cheque_number = @$collection['new_cash_bank']['cheque_number'];
$which_bank = @$collection['new_cash_bank']['drawn_on_which_bank'];
$reference_number = @$collection['new_cash_bank']['reference_number'];
$cheque_date = @$collection['new_cash_bank']['cheque_date'];
$sub_account = (int)$collection['new_cash_bank']['deposited_bank_id'];
}
$amount = str_replace( ',', '', $amount );
$am_in_words=ucwords($this->requestAction(array('controller' => 'hms', 'action' => 'convert_number_to_words'), array('pass' =>array($amount))));
foreach ($cursor2 as $collection) 
{
$society_name = $collection['society']['society_name'];
$society_reg_no = $collection['society']['society_reg_num'];
$society_address = $collection['society']['society_address'];
$sig_title = $collection['society']['sig_title'];
}
if($member == 2)
{
$user_name = $flat_id;
$wing_flat = "";
}
else
{
$result_lsa = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_user_info_via_flat_id'),array('pass'=>array(4,$flat_id)));
foreach($result_lsa as $collection)
{
$wing_id = $collection['user']['wing'];  
$flat_id = (int)$collection['user']['flat'];
$tenant = (int)$collection['user']['tenant'];
$user_name = $collection['user']['user_name'];
}	
$wing_flat = $this->requestAction(array('controller' => 'hms', 'action'=>'wing_flat'),array('pass'=>array($wing_id,$flat_id)));									
}  
$result2 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($sub_account))); 
foreach($result2 as $collection)
{
$bank_name = $collection['ledger_sub_account']['name'];
}

$date=date("d-m-Y",($d_date));
?>
<?php 
echo '<div style="width:540px;margin:auto;border:solid 1px;background-color:#FFF;margin-top:2px;font-size: 12px; line-height: 16px;" class="">';
echo '<div align="center" style="background-color:#fff;padding: 5px;font-size: 16px;font-weight: bold;color: #000;border-bottom: solid 1px;">Receipt</div>

<table width="100%" >
<tr>
<td>
		<table width="100%" cellpadding="5px">
			<tr>
				<td>Receipt No: '.$receipt_no.'</td>
				<td align="right">Date: '.$date.'</td>
			</tr>
			<tr>
				<td colspan="2">
				Received with thanks from:  <b>'.$user_name.' '.$wing_flat.'</b>
				<br/>
				Rupees '.$am_in_words.' Only
				<br/>';
				if($receipt_mode=="Cheque" || $receipt_mode == "cheque"){
					echo 'Via '.$receipt_mode.'-'.$cheque_number.' drawn on '.$which_bank.' dated '.$cheque_date;
				}
				else{
					echo 'Via '.$receipt_mode.'-'.$reference_number.' dated '.$cheque_date;
				}
				
				
				echo '<br/>
				Payment of previous bill
				</td>
				
			</tr>
		</table>
		<div style="border-bottom:solid 1px;"></div>
		<table width="100%" cellpadding="5px">
			<tr>
				<td><span style="font-size:16px;"> <b>Rs '.$amount.'</b></span><br/>';
				if($receipt_mode=="Cheque"){
					echo 'Subject to realization of Cheque(s)';
				}
				echo '</td>
				
				<td width="50%"><div align="center">For '.$society_name.'<br/><br/>'.$sig_title.'</div></td>
			</tr>
		</table>
		
</td>
</tr>
</table>';
echo '</div>';
}
echo '<DIV style="page-break-after:always"></DIV>';
}
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
.main_table{
	background-color: #F1F3FA !important;
}
.hmlogobox{
	display:none;
}
@media print {
    a:link:after,
    a:visited:after {
        content: "" !important;
    }
}
</style>

