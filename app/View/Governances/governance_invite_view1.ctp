<div style="float:left;">
<a href="<?php echo $this->webroot; ?>Governances/governance_invite_view" rel="tab" class="btn  green hide_at_print"><i class="icon-caret-left"></i> Back</a>
</div>
<div style="float:right;">
<a class="btn green hide_at_print" onclick="window.print();">Print </a>
<a class="btn purple  hide_at_print" href="<?php echo $this->webroot; ?>Governances/governace_invite_pdf?con=<?php echo $invite_id ?>">Pdf </a>
</div>
<br/><br/>
<?php
$i=0;
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
 if($meeting_type==1)
 {
	$moc="Managing Committee";
 
 }
 if($meeting_type==2)
 {
	$moc="General Body";
 
 }
	if($meeting_type==3)
	{
	 $moc="Special General Body";

	}

}

?>

<div style="background-color:#fff; border:solid 1px;" class="print_margin">
<div class="bg_co" align="center" style="background-color: rgb(0, 141, 210);padding: 5px;font-size: 16px;font-weight: bold;color: #fff;">
<?php echo $society_name; ?>
</div>
<div  align="center" style="padding: 2px;">
<span style="font-size:14px;"> <b> Meeting Agenda </b> </span>
</div>
<div  align="" style="padding: 5px;" >
<table  cellpadding='5' width='100%;' border="1">
<tr class='tr_heading'>
<td width="30%" ><span  style="font-size:14px;"><b> Type : </b></span><br/> <span><?php echo @$moc; ?></span></td>
<td width="20%" ><span  style="font-size:14px;"><b> ID : </b></span> <br/><span><?php echo $gov_id; ?></span></td>
<td width="20%"><span  style="font-size:14px;"><b> Date of Notice  : </b></span> <br/><span><?php echo $notice_of_date; ?></span></td>
</tr>
<tr class='tr_heading'>
<td ><span  style="font-size:14px;"><b> Location : </b></span> <br/><span><?php echo $location; ?></span></td>
<td ><span  style="font-size:14px;"><b> Date of Meeting : </b></span><br/> <span><?php echo $date; ?></span></td>
<td><span  style="font-size:14px;"><b> Time : </b></span> <br/><span><?php echo $time; ?></span></td>
</tr>
</table>
<br/>
<table cellpadding='5' width='100%;'>
<tr>
<td><span  style="font-size:14px;"><b>Title : </b></span> <span><?php echo $subject; ?></span></td>
</tr>
</table>
</div>

<div  align="" style="padding: 10px;">
<span style="font-size:14px;"><b>Invitees : </b></span>
<?php

if($type==1){
foreach($user as $id){
	$result_user=$this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'), array('pass' => array((int)$id)));
	foreach($result_user as $data){
		$to=$data['user']['user_name'];
		
		$wing=$data['user']['wing'];
		$flat=$data['user']['flat'];
		$flat_n=$this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'), array('pass' => array($wing,$flat)));
		if(!empty($flat_n))
		{
			$flat_name=" (".$flat_n.")";
		}
		if(!empty($to))
		{
		$to.=@$flat_name.',';
		
		}
		?>
		
		<span><?php echo $to; ?></span>
		
		<?php
	}
 }
}
if($type==2){
	
	$group_id=$data['governance_invite']['group_id'];
	foreach($group_id as $data){
     $group_name=$this->requestAction(array('controller' => 'hms', 'action' => 'fetch_group_name_from_gruop_id'), array('pass' => array((int)$data)));
	?>
	
	<span><?php echo $group_name; ?>,</span>	
	
	<?php
	
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
		?>
		<span><?php echo $show_visible; ?></span>
		<?php
		
}


?>


</div>


<div  align="" style="padding: 10px;">
<span  style="font-size:14px;"><b> Meeting Covering Note: </b></span><br/><span><?php echo $covering_note; ?></span>
</div>

<div  align="" style="padding: 5px;">
<table  cellpadding='5' width='100%;' border='1'>
<tr class='tr_heading' style=''>
<td><span  style="font-size:14px;"><b> Time </b></span></td>
<td><span  style="font-size:14px;"><b>Meeting Agenda : </b></span></td>
</tr>
<?php
$z=0;
foreach($message_web as $data)
{ $z++;?>
	
	<tr style=''>
	<td width="15%" style="" valign="top"><span style="font-size:12px;"><?php  echo urldecode(@$data[2]); ?> </span> </td>
	<td style=""><p><span style="font-size:14px;"> <?php echo $z; ?>. <?php  echo urldecode($data[0]); ?>  </span><br/><span><?php echo urldecode($data[1]); ?></span></p></td>
	</tr>
<?php	
} ?>
</table>
</div>

<div  align="" style="padding: 10px;">
<span  style="font-size:14px;"><b> Meeting Any Other Note: </b></span><br/><span><?php echo $any_other_note; ?></span>
</div>



<?php if(!empty($file)) { ?>
<br/>
<div class="hide_at_print" style="font-size:14px; padding:5px;">
<p><b>Attachment</b></p>
<div>
<a href="<?php echo $webroot_path ; ?>/governances_file/<?php echo $file; ?>" target="_blank" class="btn mini green tooltips" data-placement="bottom" data-original-title="<?php echo $file; ?>" download="download"><i class=" icon-download-alt"></i></a>
</div>
</div>
<?php } ?>

<div align="center" style="background-color: rgb(0, 141, 210);padding: 5px;font-size: 12px;font-weight: bold;color: #fff;vertical-align: middle;">
<span>Your Society is empowered by HousingMatters - 
<i>"Making Life Simpler"</i></span><br>
<span style="color:#FFF;">Email: support@housingmatters.in</span> &nbsp;|&nbsp; <span>Phone : 022-41235568</span> &nbsp;|&nbsp; <span style="color:#FFF;">www.housingmatters.co.in</span></div>

</div>