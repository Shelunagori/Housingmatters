<?php
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
$tcpdf->SetFont($textfont,12); 
$tcpdf->SetLineWidth(0.1);

foreach($cursor1 as $collection)
{
//$bill_html = $collection['regular_bill']['bill_html'];
$user_id = (int)$collection['regular_bill']['bill_for_user'];
$bill_no = (int)$collection['regular_bill']['regular_bill_id'];
$date_from = $collection['regular_bill']['bill_daterange_from'];
$date_to = $collection['regular_bill']['bill_daterange_to'];
//$ih_id1 = $collection['regular_bill']["ih_id"];
$ih_detail2 = $collection['regular_bill']['ih_detail'];
//$tax_id=(int)$collection['regular_bill']["tax_id"]; 
$date=$collection['regular_bill']["date"];
//$terms_conditions_id=$collection['regular_bill']["terms_conditions_id"];
$regular_bill_id=$collection['regular_bill']["regular_bill_id"];
//$rent2 = (int)$collection['regular_bill']['rent'];	
//$tax_amount = (int)$collection['regular_bill']['tax_amount'];
$grand_total = (int)$collection['regular_bill']['g_total'];
$late_amt2 = (int)$collection['regular_bill']['due_amount_tax'];
$due_amt2 = (int)$collection['regular_bill']['total_due_amount'];
$due_date2 = @$collection['regular_bill']['due_date'];
}

$date_from = date("d-M-Y", $date_from->sec);
$date_to = date("d-M-Y", $date_to->sec);
$date_to2 = date('Y-m-d',strtotime($date_to));
$due_date21 = date('d-M-Y',@$due_date2->sec);
$newDate = date("d-M-Y", $date->sec);	

$result1 = $this->requestAction(array('controller' => 'hms', 'action' => 'user_fetch'),array('pass'=>array($user_id)));
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
$date = date('d-M-Y',$date->sec);


$q='<table border="1" style="width:100%;">';
$q.='<tr>
<td colspan="2" align="center">
<span style="font-size:14px;">Mangalam</span><br/>
<span style="font-size:10px;">Society Detail and Address</span></td></tr>';


$q.='<tr>
<td colspan="2">
<table>
<tr>
<td>Name:</td>
<td style="text-align:left;">'.$user_name.'</td>
<td style="text-align:left;">Flat/Shop No.:</td>
<td style="text-align:left;">'.$wing_flat.'</td>
</tr>
<tr>
<td>Bill No.:</td>
<td>'.$bill_no.'</td>
<td style="text-align:left;">Area:</td>
<td style="text-align:left;">'.$area.'</td>
</tr>
<tr>
<td>Bill Date:</td>
<td>'.$date.'</td>
<td></td>
<td></td>
</tr>
<tr>
<td>Due Date:</td>
<td>'.$due_date21.'</td>
<td></td>
<td></td>
</tr>
</table>
</td>
</tr>';




$q.='<tr>
<td align="center">Particulars</td>
<td align="center">Amount(Rs.)</td>
</tr>';

$q.='<tr>
<td>';
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
$sub_total = $sub_total+
$q.='
<tr>
<td>'.$ih_name.'</td>
</tr>';
}
$q.='
</table>
';

$q.='
<br><br>
</td>
<td style="text-align:left;">
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
<td>Sub-Total:</td>
</tr>
<tr>
<td>Over Due Amount:</td>
</tr>
<tr>
<td>Over Due Interest:</td>
</tr>
<tr>
<td>Grand Total:</td>
</tr>
</table>
</td>

<td align="center">
<table>
<tr>
<td>'.$sub_total.'</td>
</tr>
<tr>
<td>'.$due_amt2.'</td>
</tr>
<tr>
<td>'.$late_amt2.'</td>
</tr>
<tr>
<td>'.$grand_total.'</td>
</tr>
</table>
</td>
</tr>';


$q.='<tr>
<td colspan="2">
<b>Terms And Conditions:</b>
<br>
Late Payment will attract penalty interest @1% p.m.
</td>
</tr>';


$q.='</table>';

$tcpdf->writeHTML($q);

echo $tcpdf->Output('filename.pdf', 'D'); 

?>