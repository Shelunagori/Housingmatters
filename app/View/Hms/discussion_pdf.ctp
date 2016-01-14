<?php 
foreach($result_topic_view as $collection)
{
$topic=$collection["discussion_post"]["topic"];
$description=$collection["discussion_post"]["description"];
$file=$collection["discussion_post"]["file"];
$d_user_id=(int)$collection["discussion_post"]["user_id"];
$post_date=$collection["discussion_post"]["date"];
$post_time=$collection["discussion_post"]["time"];
$description=$collection["discussion_post"]["description"];
$discussion_post_id=(int)$collection["discussion_post"]["discussion_post_id"];
$visible=$collection["discussion_post"]["visible"];
$sub_visible=$collection["discussion_post"]["sub_visible"];
}

$visible_detail='';
if($visible==1 ) 
{
	$visible_show="All Users";
	$visible_detail="All Users";
}

if($visible==4 ) 
{
	$visible_show="All Owners";
	$visible_detail="All Owners";
}

if($visible==5) 
{
	$visible_show="All Tenant";
	$visible_detail="All Tenant";
}

if($visible==2) 
{ 
$visible_show="Role wise";
	foreach ($sub_visible as $role_id) 
	{
	$role_name[]=$this->requestAction(array('controller' => 'hms', 'action' => 'fetch_rolename_via_roleid'), array('pass' => array($role_id)));
	}
	$visible_detail=implode(" , ",$role_name);
}

if($visible==3) 
{ 
$visible_show="Wing wise"; 
	foreach ($sub_visible as $wing_id) 
	{
	$wing_name[]="wing-".$this->requestAction(array('controller' => 'hms', 'action' => 'fetch_wingname_via_wingid'), array('pass' => array($wing_id)));
	}
	$visible_detail=implode(" , ",$wing_name);
}

$result_user_info=$this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'), array('pass' => array($d_user_id)));
foreach($result_user_info as $collection2)
{
$user_name=$collection2["user"]["user_name"];
$wing=$collection2["user"]["wing"];
$flat=$collection2["user"]["flat"];

}

$flat_info=$this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'), array('pass' => array($wing,$flat)));

?>
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
$tcpdf->SetFont($textfont,'B',2); 
//$tcpdf->writeHTML(0, '<h1>hello</h1>', '', 0, 'L', true, 0, false, false, 0);
$tcpdf->writeHTML('<div style="margin-left:10%; width:80%;"><div style="background-color:#269abc; text-align:center; color:white; font-size:18px; font-weight:bold; padding:5px;">'.$topic.'</div></div>'); 

$tcpdf->writeHTML('<div style="margin-top:2px;" >
<table>
<tr>
<td width="15%"><img src="as/blank.jpg" width="100px"></td>
<td width="85%" valign="top" style="padding-left:5px;">
<span style="font-size:16px;">'.$user_name.'&nbsp;&nbsp'.$flat_info.'</span>
<span style="font-size:14px; color:#A39A9A;">with</span>
<span style="font-size:16px;cursor: default;"><a class="tooltips" data-placement="bottom" data-original-title="">'.$visible_show.'</a></span>
<br/>
<span style="color:#ADABAB;">'.$post_date.'&nbsp;&nbsp;'.$post_time.'</span>
</td>
</tr>
</table>
<div>'); 


$tcpdf->writeHTML('<div style="margin-top:2px;font-size:14px;" >'.$description.'<div>'); 

if(!empty($file)) { 
$tcpdf->writeHTML('<img src="discussion_file/'.$file.'" style="width:1000px; height:160px;">'); 
}


foreach($result_comment as $collection2)
{
$discussion_comment_id=$collection2["discussion_comment"]["discussion_comment_id"];
$comment=$collection2["discussion_comment"]["comment"];
$comment_user_id=$collection2["discussion_comment"]["user_id"];
$color=$collection2["discussion_comment"]["color"];
$date=$collection2["discussion_comment"]["date"];
$time=$collection2["discussion_comment"]["time"];

$result_user_info_c=$this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'), array('pass' => array($comment_user_id)));
foreach($result_user_info_c as $collection_c)
{
$user_name=$collection_c["user"]["user_name"];
$wing=$collection_c["user"]["wing"];
$flat=$collection_c["user"]["flat"];

}

$flat_info_c=$this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'), array('pass' => array($wing,$flat)));

$tcpdf->writeHTML('<div style="margin-top:2px; background-color:#F4F8FF;" id="comm9" class="showhim">
<table>
<tbody><tr>
<td width="15%" valign="top" style="padding:4px;"><img src="as/blank.jpg" width="100px"></td>
<td width="85%" valign="top" style="padding-left:5px;">



<span style="font-size:14px;color:green">'.$user_name.'&nbsp;&nbsp'.$flat_info.'</span><br>
<span style="color:#ADABAB;font-size:10px;" >'.$date.'&nbsp;&nbsp;'.$time.'</span><br>
<span style="font-size:12px;">'.$comment.'</span>
</td>
</tr>
</tbody></table>
</div>');
} 

// ... 
// etc. 
// see the TCPDF examples  

echo $tcpdf->Output('filename.pdf', 'D'); 

?>