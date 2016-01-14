<?php 

foreach ($result_smsview as $collection) 
{
$sms_id=$collection["sms"]["sms_id"];
$user_id=$collection["sms"]["user_id"];
$groups_id=@$collection["sms"]["groups_id"];
$type=$collection["sms"]["type"];
$text=$collection["sms"]["text"];
$date=$collection["sms"]["date"];
$time=$collection["sms"]["time"];
}

if($type==1) { $count_user='Massage sent to: '.sizeof($user_id).'&nbsp;users'; }
if($type==2) { $count_user='Massage sent to: '.sizeof($groups_id).'&nbsp;groups';}


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
$tcpdf->SetFont($textfont,'N',12); 
//$tcpdf->writeHTML('<h1>hello</h1>', '', 0, 'L', true, 0, false, false, 0);


$tcpdf->writeHTML('<div><strong>Date: </strong>'.$date.'&nbsp;&nbsp;'.$time.'</div>');
$tcpdf->writeHTML('<br/>');

$tcpdf->writeHTML('<strong>To:</strong>');
if($type==1) {
foreach($user_id as $user)
{

	$user=(int)$user;
	$result_user = $this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'),array('pass'=>array($user)));
	foreach($result_user as $data2)
	{
	$user_name=$data2["user"]["user_name"];
	$wing=$data2["user"]["wing"];
	$flat=$data2["user"]["flat"];
	}
	
	$flat_info = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'),array('pass'=>array($wing,$flat)));
	$tcpdf->writeHTML('<div>'.$user_name.'&nbsp;&nbsp;'.$flat_info.'</div>');
	
}
}

if($type==2){ 
foreach($groups_id as $group)
{

	$group=(int)$group;
	$result_user = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_group_name_from_gruop_id'),array('pass'=>array($group)));
	$tcpdf->writeHTML('<div>'.$result_user.'</div>');
	
}
}



$tcpdf->writeHTML('<br/><br/><strong>Message:</strong>');
$tcpdf->writeHTML('<div style="font-size: 14px;">'.$text.'</div>	');

// ... 
// etc. 
// see the TCPDF examples  

echo $tcpdf->Output('filename.pdf', 'D'); 

?>