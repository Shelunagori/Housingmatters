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
$tcpdf->SetFont($textfont,'N',10); 
//$tcpdf->writeHTML('<h1>hello</h1>', '', 0, 'L', true, 0, false, false, 0);

$q='<table border="1">';
$q.='<tr>
<td colspan="2" align="center">
<span style="font-size:14px;">Mangalam</span><br/>
<span style="font-size:10px;">Society Detail and Address</span></td></tr>';
$q.='<tr><td colspan="2"><table><tr><td>hello</td><td>hello</td></tr></table></td></tr>';
$q.='<tr><td align="center">Particulars</td><td align="center">Amount(in Rs.)</td></tr>';
$q.='<tr><td>Non Occupancy charges</td><td>45456<br/><br/><br/><br/><br/><br/></td></tr>';
$q.='<tr><td align="right">Sub-Total:<br/>Over Due Amount:<br/>Over Due Interest:<br/>Grand Total:</td><td align="center">12<br/>45<br/>45455<br/>45454</td></tr>';
$q.='<tr><td colspan="2"><b>Terms And Conditions:</b><br/>Late Payment will attract penalty interest @1% p.m.</td></tr>';
$q.='</table>';
$tcpdf->writeHTML($q);

echo $tcpdf->Output('filename.pdf', 'D'); 

?>