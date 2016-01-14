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
$tcpdf->SetMargins(15, 10, 10, true);
// add a page (required with recent versions of tcpdf) 
$tcpdf->AddPage(); 

// Now you position and print your page content 
// example:  
$tcpdf->SetTextColor(0, 0, 0); 
$tcpdf->SetFont($textfont,12); 
$tcpdf->SetLineWidth(0.1);


foreach($result_gov_invite as $data){
$gov_id=$data['governance_invite']['governance_invite_id'];
$subject=$data['governance_invite']['subject'];
$notice_of_date=@$data['governance_invite']['notice_of_date'];
$message_web=$data['governance_invite']['message'];
$date=$data['governance_invite']['date'];
$time=$data['governance_invite']['time'];
$file=$data['governance_invite']['file'];
$type=$data['governance_invite']['type'];
$location=$data['governance_invite']['location'];
$covering_note=$data['governance_invite']['covering_note'];
$any_other_note=$data['governance_invite']['any_other_note'];
 $meeting_type=(int)@$data['governance_invite']['meeting_type'];
 $user=$data['governance_invite']['user'];
 if($meeting_type==1){
	$moc="Managing Committee";
 
 }
 if($meeting_type==2){
	$moc="General Body";
 
 }
	if($meeting_type==3){
	 $moc="Special General Body";

	}

}


$html='<div style="background-color:#fff; width:100%;">
<div class="bg_co" align="center" style="background-color: rgb(0, 141, 210);padding: 5px;font-size: 16px;font-weight: bold;color: #fff;">'.$society_name.'</div>
<div  align="center" style="padding: 2px;">
<span style="font-size:12px;"> <b> Meeting Agenda </b> </span>
</div>
<div  align="" style="padding: 2px;">
<table  cellpadding="5" width="100%;" border="1" >
<tr>
<td width="50%" ><span  style="font-size:12px;"><b> Type : </b></span><br/> <span>'. @$moc.'</span></td>
<td width="25%" ><span  style="font-size:12px;"><b> ID : </b></span> <br/> <span>'.$gov_id.'</span></td>
<td width="25%" ><span  style="font-size:12px;"><b>Date of Notice: </b></span> <br/> <span>'. $notice_of_date.'</span></td>
</tr>
<tr>
<td><span  style="font-size:12px;"><b> Location : </b></span> <br/> <span>'. $location.'</span></td>
<td><span  style="font-size:12px;"><b> Date of Meeting : </b></span> <br/> <span>'.$date.'</span></td>
<td>
<span  style="font-size:12px;"><b> Time : </b></span> <br/> <span>'.$time.'</span>
</td>
</tr>
</table>
</div>';

$html.='<div  align="" style="padding: 2px;">
<span  style="font-size:12px;"> <b>Meeting Title : </b> </span> <span>'.$subject.'</span>
</div>';
$html.='<div  align="" style="padding: 2px;">
<span style="font-size:12px;"> <b>Invitees : </b> </span>';
if($type==1){
foreach($user as $id){
	$result_user=$this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'), array('pass' => array((int)$id)));
	foreach($result_user as $data){
		$to=$data['user']['user_name'];
		
		$wing=$data['user']['wing'];
		$flat=$data['user']['flat'];
		$flat_n=$this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'), array('pass' => array($wing,$flat)));
		if(!empty($flat_n)){
			$flat_name=" (".$flat_n.")";
		}
		if(!empty($to)){
		$to.=@$flat_name.',';
		
		}
		
		
		$html.='<span>'.$to.'</span>';
		
		
	}
 }
}

if($type==2){
	
	$group_id=$data['governance_invite']['group_id'];
	foreach($group_id as $data){
    $group_name=$this->requestAction(array('controller' => 'hms', 'action' => 'fetch_group_name_from_gruop_id'), array('pass' => array((int)$data)));
	 
	 $html.='<span>'.$group_name.',</span>';
	}
}	

if($type==3){
		$visible=$data['governance_invite']['visible'];
		$sub_visible=$data['governance_invite']['sub_visible'];
		if($visible==1){
			$show_visible="All Users";
		}
		if($visible==2){
			$show_visible="Role Wise";
		}
		if($visible==3){
			$show_visible="Wing Wise";
		}
		if($visible==4){
			$show_visible="All Owners";
		}
		if($visible==5){
			$show_visible="All Tenant";
		}
		
		$html.='<span>'.$show_visible.'</span>';
		
}



$html.='</div><div  align="" style="padding: 2px;">
<span  style="font-size:12px;"><b> Meeting Covering Note: </b></span><br/> <span style="font-size:12px;"> '.$covering_note.' </span>
</div>';
$html.='<div style="padding: 2px;">
<table  cellpadding="5" width="100%;" border="1">
<tr>
<td width="20%"><span  style="font-size:12px;"><b> Time </b></span></td>
<td width="80%"><span  style="font-size:12px;"><b>Meeting Agenda : </b></span></td>
</tr>';
$z=0;
foreach($message_web as $data){ $z++; 
$html.='<tr>
<td  style="" valign="top"><span style="font-size:12px;">'.urldecode(@$data[2]).'</span> </td>
	<td style=""><span style="font-size:12px;text-align:justify;"> '. $z.' '. urldecode($data[0]).' </span><br/><span style="font-size:12px;text-align:justify;"> '.urldecode($data[1]).'</span></td>
	</tr>';
}
$html.='</table>
</div>
<div  style="padding: 2px;">
<span  style="font-size:12px;"><b> Meeting Any Other Note: </b></span><br/> <span style="font-size:12px;"> '.$any_other_note.' </span>
</div>
<div align="center" style="background-color: rgb(0, 141, 210);padding: 5px;font-size: 12px;font-weight: bold;color: #fff;vertical-align: middle;">
<span>Your Society is empowered by HousingMatters - 
<i>"Making Life Simpler"</i></span><br>
<span style="color:#FFF;">Email: support@housingmatters.in</span> &nbsp;|&nbsp; <span>Phone : 022-41235568</span> &nbsp;|&nbsp; <span style="color:#FFF;">www.housingmatters.co.in</span></div>
</div>';
$tcpdf->writeHTML($html);
echo $tcpdf->Output('governance_agenda.pdf', 'D'); 

?>