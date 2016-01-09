<?php 
App::import('Vendor','xtcpdf');  
$tcpdf = new XTCPDF(); 
$textfont = 'times'; // looks better, finer, and more condensed than 'dejavusans' 

$tcpdf->SetAuthor("KBS Homes & Properties at http://kbs-properties.com"); 
$tcpdf->SetAutoPageBreak( true ); 
//$tcpdf->setHeaderFont(array($textfont,'',40)); 
$tcpdf->xheadercolor = array(255,255,255); 
$tcpdf->xheadertext = ''; 
$tcpdf->xfootertext = 'HousingMatters'; 

// add a page (required with recent versions of tcpdf) 
$tcpdf->AddPage(); 

// Now you position and print your page content 
// example:  
$tcpdf->SetTextColor(0, 0, 0); 
$tcpdf->SetFont($textfont,12); 
$tcpdf->SetLineWidth(0.1);


foreach ($cursor1 as $collection) 
{
$receipt_no = (int)$collection['new_cash_bank']['receipt_id'];
$d_date = $collection['new_cash_bank']['transaction_date'];
$today = date("d-M-Y");
$receipt_mode = $collection['new_cash_bank']['receipt_mode'];
$user_id = $collection['new_cash_bank']['user_id']; 
$amount = (int)$collection['new_cash_bank']['amount'];
$society_id = (int)$collection['new_cash_bank']['society_id'];
$account_type = (int)$collection['new_cash_bank']['account_type'];
$narration = @$collection['new_cash_bank']['narration'];
$sub_account = (int)$collection['new_cash_bank']['account_head'];
$invoice_ref = $collection['new_cash_bank']['invoice_reference'];
$instrument_utr = $collection['new_cash_bank']['receipt_instruction']; 
$prepaired_by_id = (int)$collection['new_cash_bank']['prepaired_by']; 
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









}
$tds_amount = str_replace( ',', '', $tds_amount);
$total_tds_amount = str_replace( ',', '', $total_tds_amount );
$am_in_words=ucwords($this->requestAction(array('controller' => 'hms', 'action' => 'convert_number_to_words'), array('pass' =>array($total_tds_amount))));
foreach ($cursor2 as $collection) 
{
$society_name = $collection['society']['society_name'];
$society_reg_no = $collection['society']['society_reg_num'];
$society_address = $collection['society']['society_address'];
$sig_title = $collection['society']['sig_title'];
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

$subleddger_result2 = $this->requestAction(array('controller' => 'hms', 'action' => 'subledger_fetch_by_auto_id'),array('pass'=>array($sub_account)));
foreach ($subleddger_result2 as $collection) 
{
$bank_name = $collection['ledger_sub_account']['name'];	  
}



$userr_dattaa = $this->requestAction(array('controller' => 'hms', 'action' => 'user_fetch'),array('pass'=>array($prepaired_by_id)));
foreach ($userr_dattaa as $user_detail) 
{
$user_naammm = $user_detail['user']['user_name'];	  
}











	
$date=date("d-m-Y",($d_date));
?>
<?php 
$q='<table border="1" style="width:100%;"> <tr><td>';
$q.='<div align="center" style="background-color: rgb(0, 141, 210);padding: 5px;font-size: 16px;font-weight: bold;color: #fff;">'.strtoupper($society_name).'</div>
<div align="center">
<span style="font-size:12px;color:rgb(100, 100, 99);">Regn# '.$society_reg_no.'</span><br/>
<span style="font-size:12px;color:rgb(100, 100, 99);">'.$society_address.'</span><br>
<span style="font-size:15px;color:rgb(100, 100, 99); font-weight:400;">Bank Payment Voucher</span>
</div></td></tr><tr><td>

		<table width="100%" cellpadding="5px">
			<tr>
				<td>BPV : #'.$receipt_no.'</td>
				<td align="right">Date: '.$date.'</td>
			</tr>
			<tr>
				<td>
				Debit To:  <b>'.$user_name.'</b>
				<br/>
				Rupees '.$am_in_words.' Only
				<br/>';
				
				if($receipt_mode=="Cheque"){
					$q.='Via '.$receipt_mode.' &nbsp;&nbsp;  '.$instrument_utr.'   &nbsp;&nbsp;&nbsp;          Drawn on '.$bank_name.' Bank';
				}
				else{
					$q.='Via '.$receipt_mode.' &nbsp;&nbsp;  '.$instrument_utr.'';
				}
				
				
				$q.='<br/>
					</td>
				<td align="right">
				<br>
				<span style="font-size:16px;"> <b>Rs '.$total_tds_amount.'</b></span><br/>';
				if($receipt_mode=="Cheque"){
					$q.='Subject to realization of Cheque(s)<br/>';
				}
				
			$q.='</td>
			</tr>
		</table></td></tr><tr><td>';
		
$q.='<table width="100%" cellpadding="5px">
			<tr>
				<td>
				Narration :'.$narration.'';
				
				
				$q.='</td>
				<td style="text-align:right;">
			<b> Rs '.$tds_amount.'</b> Tds payable
				</td>
				
			</tr>
		</table>
		<br><br>
		<table width="100%" cellpadding="5px">
			<tr>
			<td align="center" width="33%;">Prepared By</td>
			<td align="center" width="33%;">Approved By</td>
			<td align="center" width="33%;">Received By</td>
			</tr>
			<tr>
			<td align="center" width="33%;">
			'.$user_naammm.'<br>
			<div style="border-top:solid 1px #333; overflow:auto; width:60%;"></div>
			</td>
			<td align="center" width="33%;">
			<br><br>
			<div style="border-top:solid 1px #333; overflow:auto; width:60%;"></div>
			</td>
			<td align="center" width="33%;">
			<br><br>
		   <div style="border-top:solid 1px #333; overflow:auto; width:60%;"></div>
			</td>
			</tr>
			
		</table>
		<br>';
$q.='</td></tr></table>'; 
?>
<?php
$tcpdf->writeHTML($q);

echo $tcpdf->Output('bank_payment.pdf', 'D'); 
?>