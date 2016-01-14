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
//$tcpdf->writeHTML($bill_html);

foreach($cursor1 as $collection)
{
//$bill_html = $collection['regular_bill']['bill_html'];
$user_id = (int)$collection['adhoc_bill']['person_name'];
$bill_no = (int)$collection['adhoc_bill']['receipt_id'];
$date_from = $collection['adhoc_bill']['bill_daterange_from'];
$bill_type = $collection['adhoc_bill']['residential'];
//$date_to = $collection['regular_bill']['bill_daterange_to'];
//$ih_id1 = $collection['regular_bill']["ih_id"];
$ih_detail2 = @$collection['adhoc_bill']['ih_detail'];
//$tax_id=(int)$collection['regular_bill']["tax_id"]; 
$date=$collection['adhoc_bill']["date"];
//$terms_conditions_id=$collection['regular_bill']["terms_conditions_id"];
$regular_bill_id=$collection['adhoc_bill']["adhoc_bill_id"];
//$rent2 = (int)$collection['regular_bill']['rent'];	
//$tax_amount = (int)$collection['regular_bill']['tax_amount'];
$grand_total = (int)$collection['adhoc_bill']['g_total'];
//$late_amt2 = (int)$collection['regular_bill']['due_amount_tax'];
//$due_amt2 = (int)$collection['regular_bill']['total_due_amount'];
//$due_date2 = @$collection['regular_bill']['due_date'];
$cur_date = $collection['adhoc_bill']['date'];
if($bill_type == 'y')
{
$user_id = (int)$collection['adhoc_bill']['person_name'];	
}
else
{
$company_name = $collection['adhoc_bill']['company_name'];
$user_name = $collection['adhoc_bill']['person_name'];	
}
}

$result11 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($user_id)));
foreach($result11 as $collection)
{
$user_id2 = (int)$collection['ledger_sub_account']['user_id'];
}

if($bill_type == 'y')
{
$result1 = $this->requestAction(array('controller' => 'hms', 'action' => 'user_fetch'),array('pass'=>array($user_id2)));
foreach($result1 as $collection)
{
$user_name=$collection['user']["user_name"];	
$wing = (int)$collection['user']['wing'];
$flat = (int)$collection['user']['flat'];
}
$wing_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'),array('pass'=>array($wing,$flat)));

$result1 = $this->requestAction(array('controller' => 'hms', 'action' => 'flat_fetch'),array('pass'=>array($flat)));
foreach($result1 as $collection)
{
$area = $collection['flat']['flat_area'];
}

}

$date = date('d-M-Y',$date->sec);
$cur_date2 = date('d-M-Y',$cur_date->sec);


$q='<table border="1" style="width:100%;">';
$q.='<tr>
<td colspan="2" align="center">
<span style="font-size:14px;">Mangalam</span><br/>
<span style="font-size:10px;">Society Detail and Address</span></td></tr>';


$q.='<tr>
<td colspan="2">';
if($bill_type == 'n')
{
$q.='
<table>
<tr>
<td>Name:</td>
<td>'.$user_name.'</td>
<td>Creation Date:</td>
<td>'.$cur_date2.'</td>
</tr>
<tr>
<td>Bill No.:</td>
<td>'.$bill_no.'</td>
<td>Bill Date:</td>
<td>'.$date.'</td>
</tr>
</table>';
}
else
{
$q.='
<table>
<tr>
<td>Name:</td>
<td style="text-align:left;">'.$user_name.'</td>
<td style="text-align:left;">Flat/Shop No.:</td>
<td style="text-align:left;">'.$wing_flat.'</td>
</tr>
<tr>
<td>Bill No.:</td>
<td>5001</td>
<td style="text-align:left;">Area:</td>
<td style="text-align:left;">'.$area.'</td>
</tr>
<tr>
<td>Bill Date:</td>
<td>'.$date.'</td>
<td></td>
<td></td>
</tr>
</table>';
}
$q.='</td>
</tr>';

$q.='<tr>
<td align="center">Particulars</td>
<td align="center">Amount(Rs.)</td>
</tr>';

$q.='<tr>
<td>';
if($bill_type=='n')
{
$q.='
<table>
<tr>
<td>Amount Aplied</td>
</tr>
</table>
';	
}
else
{
$q.='
<table>';
for($p=0; $p<sizeof($ih_detail2); $p++)
{
$ih_arr = $ih_detail2[$p];	
$ih_id1 = (int)$ih_arr[0];
$result2 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_account_fetch2'),array('pass'=>array($ih_id1)));
foreach($result2 as $collection)
{
$ih_name = $collection['ledger_account']['ledger_name'];	
}
$q.='
<tr>
<td>'.$ih_name.'</td>
</tr>';
}
$q.='
</table>
';
}
$q.='
<br><br>
</td>
<td style="text-align:left;">';
if($bill_type == 'n')
{
$q.='<table>
<tr>
<td>'.$grand_total.'</td>
</tr>
</table>';

}
$q.='
<table>';
$sub_total = 0;
for($n=0; $n<sizeof($ih_detail2); $n++)
{
$ih_arr2 = $ih_detail2[$n];	
$amt = $ih_arr2[1];
$sub_total = $sub_total + $amt;
$q.='<tr>
<td align="center;">'.$amt.'</td>
</tr>';
}
$q.='</table>
</td>
</tr>';


$q.='<tr>
<td align="right">
<table>
<tr>
<th>Grand Total:</th>
</tr>
</table>
</td>

<td align="center">
<table>
<tr>
<td>'.$grand_total.'</td>
</tr>
</table>
</td>
</tr>';


$q.='<tr>
<td colspan="2">
<b>Terms And Conditions:</b>
<br>';
for($r=0; $r<sizeof($tems_arr); $r++)
{
$terms_name = $tems_arr[$r];
$q.=''.$terms_name.'
<br>';
}
$q.='
</td>
</tr>';


$q.='</table>';

$tcpdf->writeHTML($q);

echo $tcpdf->Output('filename.pdf', 'D'); 
?>