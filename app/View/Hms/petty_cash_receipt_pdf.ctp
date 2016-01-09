<?php
foreach($cursor1 as $collection)
{
$account_type = (int)$collection['petty_cash_receipt']['account_type'];
$receipt_no = (int)$collection['petty_cash_receipt']['receipt_id'];
$d_date = $collection['petty_cash_receipt']['transaction_date'];
$today = date("d-M-Y");
$user_id_d = (int)$collection['petty_cash_receipt']['user_id'];
$amount = $collection['petty_cash_receipt']['amount'];
$society_id = (int)$collection['petty_cash_receipt']['society_id'];
$narration = $collection['petty_cash_receipt']['narration'];
}
if($account_type == 1)
{
$result_lsa = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($user_id_d)));
foreach($result_lsa as $collection)
{
$user_id = (int)$collection['ledger_sub_account']['user_id'];
}

$result = $this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'),array('pass'=>array($user_id)));
											foreach ($result as $collection) 
											{
											$wing_id = $collection['user']['wing'];  
											$flat_id = (int)$collection['user']['flat'];
											$tenant = (int)$collection['user']['tenant'];
											$user_name = $collection['user']['user_name'];
											}	
$wing_flat = $this->requestAction(array('controller' => 'hms', 'action'=>'wing_flat'),array('pass'=>array($wing_id,$flat_id)));									
}
else if($account_type == 2)
{

$result_la = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_amount'),array('pass'=>array($user_id_d)));
foreach($result_la as $collection)
{
$user_name = $collection['ledger_account']['ledger_name'];
$wing_flat = "";
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
<td width="80%"><p style="font-size:10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Received with thanks from : '.$user_name.' &nbsp;&nbsp;&nbsp;&nbsp;('.$wing_flat.')</p></td>
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
<td><p style="font-size:10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Narration : '.$narration.'</p></td>
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

















echo $tcpdf->Output('Petty Cash Receipt.pdf', 'D'); 

?>