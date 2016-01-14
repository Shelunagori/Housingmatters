<?php

foreach ($cursor1 as $collection) 
{
$auto_id = (int)$collection['journal']['auto_id'];
$receipt_no = $collection['journal']['receipt_id']; 
$user_id = (int)$collection['journal']['user_id'];
$date = $collection['journal']['transaction_date'];
$amount = $collection['journal']['amount'];
$amount_category_id = (int)$collection['journal']['amount_category_id'];
$remark = $collection['journal']['remark'];                                     
$account_type = (int)$collection['journal']['account_type']; 
$ledger_type_id = (int)$collection['journal']['ledger_type_id'];

$date = date('d-m-Y',$date->sec);

if($account_type == 1)
{ 
$result_lsa = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($user_id)));
foreach ($result_lsa as $collection) 
{
$user_name = $collection['ledger_sub_account']['name']; 
}								 
}	

if($account_type == 2)
{
$result_la = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_amount'),array('pass'=>array($ledger_type_id)));
foreach ($result_la as $collection) 
{
$user_name = $collection['ledger_account']['ledger_name']; 
}
}															
}

foreach($cursor2 as $collection)
{
$society_name = $collection['society']['society_name'];
}


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
<td align="center"><p style="font-size:18px;">JOURNAL</p>

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
<td width="80%"><p style="font-size:10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Received with thanks from : '.$user_name.' &nbsp;&nbsp;&nbsp;&nbsp;</p></td>
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
<td><p style="font-size:10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Narration : '.$remark.'</p></td>
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







echo $tcpdf->Output('Journal.pdf', 'D'); 






?>