<?php 
foreach ($cursor1 as $collection) 
{
$receipt_no = (int)$collection['bank_receipt']['receipt_id'];
$d_date = $collection['bank_receipt']['transaction_date'];
$today = date("d-M-Y");
$user_id_d = $collection['bank_receipt']['user_id'];
$amount = $collection['bank_receipt']['amount'];
$society_id = (int)$collection['bank_receipt']['society_id'];
$bill_reference = $collection['bank_receipt']['bill_reference'];
$narration = $collection['bank_receipt']['narration'];
$member = (int)$collection['bank_receipt']['member'];
$receiver_name = @$collection['bank_receipt']['receiver_name'];
$receipt_mode = $collection['bank_receipt']['receipt_mode'];
$sub_account = (int)$collection['bank_receipt']['sub_account_id'];
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
$tcpdf->writeHTML('<table border="0" width="100%">
<tr>
<td>
<br><br>
<table width="100%" border="0">
<tr>
<td align="left"><p style="font-size:10px;">Receipt No:'.$receipt_no.'</p></td>
<td align="center"><p style="font-size:18px;">RECEIPT</p></td>
<td align="right"><p style="font-size:10px;">Date:'.$date.'</p></td>
</tr>
<tr>
<td colspan="3" align="center"><p style="font-size:12px;">for Previous Bill</p></td>
</tr>
<tr>
<td colspan="3" align="center"><p style="font-size:10px;"></p></td>
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
<table width="100%" border="0">
<tr>
<td width="80%"><p style="font-size:10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Received with thanks from:'.$user_name.'</p></td>
<td rowspan="6">
&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;
&nbsp;&nbsp;&nbsp;
<table border="0" width="30%">
<tr>
<td>
<br><bR><BR>
<table border="1" width="100%">
<tr>
<td>
<p style="font-size:11px;">'.$wing_flat.'</p>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td>
<br><br><br><br><br>
<table border="1" width="100%">
<tr>
<td>
<p style="font-size:11px;">'.$amount.'</p>
</td>
</tr>
</table>
</td>
</tr>
</table>
</center>
</td>
</tr>
<tr>
<td></td>
</tr>
<tr>
<td><p style="font-size:10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rs.&nbsp;&nbsp;(words)&nbsp; only</p></td>
</tr>
<tr>
<td></td>
</tr>
<tr>
<td><p style="font-size:10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Via'.$receipt_mode.'&nbsp;&nbsp;&nbsp;'.$bank_name.'Bank&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rs.</p>


</td>
</tr>
<tr>
<td></td>
</tr>
<tr>
<td colspan="2"><p style="font-size:10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Payment for Bill No:'.$receipt_no.' dated '.$date.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Subject to Realization of Cheque</p></td>
</tr>
</table>



<br><Br><Br>





<table width="100%" border="0">
<tr>
<td></td>
<td><p style="font-size:10px;">&nbsp;&nbsp;&nbsp;&nbsp;For:'.$society_name.'</p></td>
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







// ... 
// etc. 
// see the TCPDF examples  

echo $tcpdf->Output('Bank Receipt.pdf', 'D'); 

?>