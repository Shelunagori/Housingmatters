<?php

		$total_debit = 0;
		$total_credit = 0;
		foreach ($cursor1 as $collection) 
		{
		$approver = (int)$collection['expense_tracker']['approver'];
		$party_head = (int)$collection['expense_tracker']['party_head'];
		$invoice_date = $collection['expense_tracker']['invoice_date'];
		$due_date = $collection['expense_tracker']['due_date'];
		$posting_date = $collection['expense_tracker']['posting_date'];
		$description = $collection['expense_tracker']['description'];
		$amount = $collection['expense_tracker']['amount'];
		$amount_category_id = (int)$collection['expense_tracker']['amount_category_id'];
		$income_head_id = (int)$collection['expense_tracker']['expense_head'];
		$voucher_no = (int)$collection['expense_tracker']['receipt_id'];
		$society_id = (int)$collection['expense_tracker']['society_id'];

		$posting_date = date('d-m-Y', $posting_date->sec);
		$due_date = date('d-m-Y',$due_date->sec);

		
$result_la = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_amount'),array('pass'=>array($income_head_id)));	
	foreach ($result_la as $collection) 
	{
	$income_head_name = $collection['ledger_account']['ledger_name'];	
	}

foreach($cursor2 as $collection)
{
$society_name = $collection['society']['society_name'];
}

$result1 = $this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'),array('pass'=>array($approver)));
foreach($result1 as $collection)
{
$aprover_name = $collection['user']['user_name'];
}

	
	
$result_lsa = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($party_head)));
	foreach ($result_lsa as $collection) 
	{
	$party_head_name = $collection['ledger_sub_account']['name'];
	}

	if($amount_category_id == 1) 
	{ 
	$total_debit = $total_debit + $amount;
	} 
	else if($amount_category_id == 2) 
	{ 
	$total_credit = $total_credit + $amount;
	} 

		}

 //$words = convert_number_to_words($amount);








App::import('Vendor','xtcpdf');  
$tcpdf = new XTCPDF(); 
$textfont = 'freesans'; // looks better, finer, and more condensed than 'dejavusans' 

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
$tcpdf->SetFont($textfont,'B',2); 
$tcpdf->writeHTML('<table border="1" width="100%">
<tr>
<td>
<br><br>
<table width="100%">
<tr>
<td></td>
<td align="center"><p style="font-size:18px;">EXPENSE VOUCHER</p>

</td>
<td></td>
</tr>
<tr>
<td></td>
<td align="center"></td>
<td></td>
</tr>
<tr>
<td align="center"><p style="font-size:10px;">Voucher No : '.$voucher_no.'</p></td>
<td></td>
<td align="center"><p style="font-size:10px;">Voucher Date : '.$posting_date.'</p></td>
</tr>
<tr>
<td></td>
<td></td>
<td></td>
</tr>
</table>
</td>
</tr>
<tr>
<td>
<br><Br>
<table width="100%">
<tr>
<td width="80%"><p style="font-size:10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Expense Head : '.$income_head_name.'</p></td>
<td></td>
</tr>
<tr>
<td></td>
<td></td>
</tr>
<tr>
<td><p style="font-size:10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a sum of Rs.'.$amount.' in words(only)</p></td>
<td></td>
</tr>
<tr>
<td></td>
<td></td>
</tr>
<tr>
<td><p style="font-size:10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Due Date : '.$due_date.'</p></td>
<td></td>
</tr>
<tr>
<td></td>
<td></td>
</tr>
<tr>
<td><p style="font-size:10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Narration : '.$description.'</p></td>
<td></td>
</tr>
</table>



<br><Br><Br>





<table width="100%">
<tr>
<td></td>
<td><p style="font-size:10px;">&nbsp;&nbsp;&nbsp;&nbsp;For : '.$society_name.'</p></td>
</tr>

<tr>
<td></td>
<td></td>
</tr>


<tr>
<td></td>
<td></td>
</tr>

<tr>
<td></td>
<td><p style="font-size:10px;">&nbsp;&nbsp;&nbsp;&nbsp;Secretary/Treasurer</p></td>
</tr>


</table>

<br><Br><br>
</td>
</tr>



</table>');








echo $tcpdf->Output('Expense Tracker.pdf', 'D'); 

?>