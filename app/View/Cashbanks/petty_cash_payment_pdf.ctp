<?php
foreach ($cursor1 as $collection) 
{
$receipt_no = (int)$collection['cash_bank']['receipt_id'];
$d_date = $collection['cash_bank']['transaction_date'];
$today = date("d-M-Y");
$user_id_d = (int)$collection['cash_bank']['user_id'];
$amount = $collection['cash_bank']['amount'];
$society_id = (int)$collection['cash_bank']['society_id'];
$narration = $collection['cash_bank']['narration'];
$account_type = (int)$collection['cash_bank']['account_type'];
}

if($account_type == 1)
{
$result_lsa = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($user_id_d)));
foreach($result_lsa as $collection)
{
$user_name = $collection['ledger_sub_account']['name'];
}
}
else if($account_type == 2)
{
$result_la = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_amount'),array('pass'=>array($user_id_d)));
foreach ($result_la as $collection) 
{
$user_name = $collection['ledger_account']['ledger_name'];
}
}

foreach($cursor2 as $collection)
{
$society_name = $collection['society']['society_name'];
}

$date = date("d-M-Y",$d_date->sec);
 // $words = convert_number_to_words($amount);









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
$tcpdf->SetFont($textfont,'B',2); 
$tcpdf->writeHTML('<table border="1" width="100%">
<tr>
<td>
<br><br>
<table width="100%">
<tr>
<td></td>
<td align="center"><p style="font-size:18px;">RECEIPT</p>

</td>
<td></td>
</tr>
<tr>
<td></td>
<td align="center"></td>
<td></td>
</tr>
<tr>
<td align="center"><p style="font-size:10px;">Receipt No : '.$receipt_no.'</p></td>
<td></td>
<td align="center"><p style="font-size:10px;">Receipt Date : '.$date.'</p></td>
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
<td width="80%"><p style="font-size:10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Received with thanks from : '.$user_name.'</p></td>
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
<td><p style="font-size:10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Narration :'.$narration.'</p></td>
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














echo $tcpdf->Output('Petty Cash Payment.pdf', 'D'); 

?>