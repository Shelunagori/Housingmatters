<?php 
foreach($result_new_regular_bill as $regular_bill){
	$bill_html=$regular_bill["new_regular_bill"]["bill_html"];
} ?>
<style>
@media screen {
    .bill_on_screen {
       width:70%;
    }
}

@media print {
    .bill_on_screen {
       width:90% !important;
    }
}
.main_table{
	background-color: #F1F3FA !important;
}
.hmlogobox{
	display:none;
}
</style>
<a href="#" class="btn green pull-right hide_at_print" role="button" onclick="window.print()">Print</a>
<?php echo $bill_html; ?>

<?php
echo $size;
if($size > 0)
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
$result_lsa = $this->requestAction(array('controller' => 'hms', 'action' => 'user_fetch2'),array('pass'=>array($flat_id)));
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
echo '<div style="width:540px;margin:auto;border:solid 1px;background-color:#FFF;margin-top:2px;" class="">';
echo '<div align="center" style="padding: 2px;font-size: 14px;font-weight: bold;color: #fff; border-bottom: solid 1px; background-color: rgb(0, 141, 210);">RECEIPT</div>

<table width="100%" >
<tr>
<td>
		<table width="100%" cellpadding="5px">
			<tr>
				<td>Receipt No: '.$receipt_no.'</td>
				<td align="right">Date: '.$date.'</td>
			</tr>
			<tr>
				<td>
				Received with thanks from:  <b>'.$user_name.' '.$wing_flat.'</b>
				<br/>
				Rupees '.$am_in_words.' Only
				<br/>';
				if($receipt_mode=="Cheque"){
					echo 'Via '.$receipt_mode.'-'.$cheque_number.' drawn on '.$which_bank.' dated '.$cheque_date;
				}
				else{
					echo 'Via '.$receipt_mode.'-'.$reference_number.' dated '.$cheque_date;
				}
				
				
				echo '<br/>
				Payment of previous bill
				</td>
				<td></td>
			</tr>
		</table>
		<div style="border-bottom:solid 1px;"></div>
		<table width="100%" cellpadding="5px">
			<tr>
				<td width="50%"><span style="font-size:16px;"> <b>Rs '.$amount.'</b></span><br/>';
				if($receipt_mode=="Cheque"){
					echo 'Subject to realization of Cheque(s)';
				}
				echo '</td>
				<td>
				<div align="center">
				For '.$society_name.'<br/><br/><br/>'.$sig_title.'
				</div>
				</td>
				</tr>
		        
		</table>
		
</td>
</tr>
<tr><td>
 <table style="background-color:#008dd2;font-size:11px;color:#fff;border:solid 1px #767575;border-top:none" width="100%" cellspacing="0">
                                 <tbody>
								 
									<tr>
                                        <td align="center" colspan="7"><b>
										Your Society is empowered by HousingMatters - <b> <i>"Making Life Simpler"</i>
										</b></b></td>
                                    </tr>
									<tr>
                                        <td width="50" align="right" style="font-size: 10px;"><b>Email :</b></td>
                                        <td width="120" style="color:#fff!important;font-size: 10px;"> 
										<a href="mailto:support@housingmatters.in" style="color:#fff!important" target="_blank"><b>support@housingmatters.in</b></a>
                                        </td>
										<td align="center" style="font-size: 10px;"></td>
                                        <td align="right" style="font-size: 10px;"></td>
                                        <td width="84" style="color:#fff!important;text-decoration:none;font-size:10px;"><b><a href="intent://send/+919869157561#Intent;scheme=smsto;package=com.whatsapp;action=android.intent.action.SENDTO;end"><img src="'.$ip.$this->webroot.'/as/hm/whatsup.png"  width="18px" /></a>91-9869157561</b></td>
										<td align="center" style="font-size: 10px;"></td>
                                        <td width="100" style="padding-right:10px;text-decoration:none"> <a href="http://www.housingmatters.in" style="color:#fff!important" target="_blank"><b>www.housingmatters.in</b></a></td>
                                    </tr>
                                    
                                    
                                </tbody>
							</table></td>
</tr>
</table>';
echo '</div>';
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
</style>	












