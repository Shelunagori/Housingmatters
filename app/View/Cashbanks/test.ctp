<?php 
foreach ($cursor1 as $collection) 
{
$receipt_no = (int)$collection['cash_bank']['receipt_id'];
$d_date = $collection['cash_bank']['transaction_date'];
$today = date("d-M-Y");
$user_id_d = $collection['cash_bank']['user_id'];
$amount = $collection['cash_bank']['amount'];
$society_id = (int)$collection['cash_bank']['society_id'];
$bill_reference = $collection['cash_bank']['bill_reference'];
$narration = $collection['cash_bank']['narration'];
$member = (int)$collection['cash_bank']['member'];
$receiver_name = @$collection['cash_bank']['receiver_name'];
$receipt_mode = $collection['cash_bank']['receipt_mode'];
$sub_account = (int)$collection['cash_bank']['account_head'];
}
if($member == 2)
{
$user_name = $receiver_name;
$wing_flat = "";
}
else
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
$result2 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($sub_account))); 
foreach($result2 as $collection)
{
$bank_name = $collection['ledger_sub_account']['name'];
}
                                    
foreach ($cursor2 as $collection) 
{
$society_name = $collection['society']['society_name'];
}

$date = date("d-M-Y",$d_date->sec);
//$words = $this->requestAction(array('controller' => 'hms', 'action'=>'convert_number_to_words'),array('pass'=>array($amount)));	


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
$tcpdf->writeHTML('
<table border="1" width="100%">
<tr>
<td>
<br><br><br><br>
<table border="0" width="94%">
<tr>
<td align="center">
<p style="font-size:10px;">
Receipt No:'.$receipt_no.'</p>
</td>
<td align="center">
<p style="font-size:18px;">RECEIPT</p>
</td>
<td align="right">
<p style="font-size:10px;">
Date:'.$date.'
</p>
</td>
</tr>
<tr>
<td></td>
<td align="center">
<p style="font-size:12px;">
for Previous Bill 
</p>
</td>
<td></td>
</tr>
<tr>
<td colspan="2">
<br><br><br><br>
<p style="font-size:10px;">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Received with thanks from: '.$user_name.'<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rs. (words) only 
</p>
</td>
<td align="center">
<p style="font-size:10px;">
'.$wing_flat.'
</p>
</td>
</tr>
<tr>
<td colspan="2">
<p style="font-size:10px;">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Via '.$receipt_mode.'
</p>
</td>
<td align="center">
<p style="font-size:10px;">
Rs. &nbsp;&nbsp;
'.$amount.'
</p>
</td>
</tr>
<tr>
<td colspan="2">
<p style="font-size:10px;">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Payment for Bill No. '.$receipt_no.' Dated '.$date.'
</p>
</td>
<td align="center">
<p style="font-size:10px;">
Subject to realization of Cheque
</p>
</td>
</tr>
<tr>
<td colspan="2">
</td>
<td align="center">
<br><br><br><Br>
<p style="font-size:10px;">
For:'.$society_name.'<br>
Secretary/Treasurer
</p>
<br>
</td>
</tr>
</table>
</td>
</tr>
</table>
');







// ... 
// etc. 
// see the TCPDF examples  

echo $tcpdf->Output('Bank Receipt.pdf', 'D'); 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
</body>
</html>