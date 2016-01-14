<div style="float:left;">
<a href="<?php echo $this->webroot; ?>Governances/governance_invite_view" rel="tab" class="btn  green hide_at_print"><i class="icon-caret-left"></i> Back</a>
</div>
<div style="float:right;">
<a class="btn green hide_at_print" onclick="window.print();">Print </a>
</div>
<br/><br/>
<?php
$i=0;
foreach($result_gov_invite as $data){
$gov_id=$data['governance_invite']['governance_invite_id'];
$subject=$data['governance_invite']['subject'];
$message_web=$data['governance_invite']['message'];
$date=$data['governance_invite']['date'];
$time=$data['governance_invite']['time'];
$file=$data['governance_invite']['file'];
$type=$data['governance_invite']['type'];
$location=$data['governance_invite']['location'];
$covering_note=$data['governance_invite']['covering_note'];
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
if($type==3)
{
$visible=$data['governance_invite']['visible'];
$sub_visible=$data['governance_invite']['sub_visible'];

}

	



}

?>

<div style="background-color:#fff; border:solid 1px;">
<div align="center" style="background-color: rgb(0, 141, 210);padding: 5px;font-size: 16px;font-weight: bold;color: #fff;">
<?php echo $society_name; ?>
</div>

<div  align="" style="padding: 5px;">
<table  cellpadding='5' width='100%;' >
<tr class='tr_heading'>
<td ><span  style="font-size:14px;"><b>Meeting type : </b></span> <span><?php echo @$moc; ?></span></td>
<td colspan="3"><span  style="font-size:14px;"><b>Meeting Title : </b></span> <span><?php echo $subject; ?></span></td>

</tr>
<tr>
<td ><span  style="font-size:14px;"><b> Meeting Location : </b></span> <span><?php echo $location; ?></span></td>
<td ><span  style="font-size:14px;"><b> Date : </b></span> <span><?php echo $date; ?></span></td>
<td ><span  style="font-size:14px;"><b> Time : </b></span> <span><?php echo $time; ?></span></td>
<td ><span  style="font-size:14px;"><b>Meeting ID : </b></span> <span><?php echo $gov_id; ?></span></td>
</tr>
</table>
</div>
<br/>

<div  align="" style="padding: 10px;">
<span style="font-size:14px;"><b>Invitees : </b></span>
<?php

foreach($user as $id)
{
	$result_user=$this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'), array('pass' => array((int)$id)));
	foreach($result_user as $data)
	{
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


?>


</div>


<div  align="" style="padding: 10px;">
<span  style="font-size:14px;"><b> Meeting Covering Note: </b></span><br/><span><?php echo $covering_note; ?></span>
</div>

<div  align="" style="padding: 5px;">
<table  cellpadding='5' width='100%;'>
<tr class='tr_heading' style=''>
<td><span  style="font-size:14px;"><b> Time </b></span></td>
<td><span  style="font-size:14px;"><b>Meeting Agenda : </b></span></td>

</tr>
<?php
$z=0;
foreach($message_web as $data)
{ $z++;?>
	
	<tr style=''>
	<td width="10%" style="border-top: solid 1px;" valign="top"><span style="font-size:14px;"><?php  echo urldecode($data[2]); ?> </span> </td>
	<td style="border-top: solid 1px;"><p><span style="font-size:16px;"> <?php echo $z; ?>. <?php  echo urldecode($data[0]); ?>  </span><br/><span><?php echo urldecode($data[1]); ?></span></p></td>
	</tr>
<?php	
} ?>
</table>
</div>

<br/>




<?php if(!empty($file)) { ?>
<br/>
<p style="font-size:14px; padding:5px;"><b>Attachment</b></p>
<div >
<a href="<?php echo $webroot_path ; ?>/governances_file/<?php echo $file; ?>" target="_blank" class="btn mini green tooltips" data-placement="bottom" data-original-title="<?php echo $file; ?>" download="download"><i class=" icon-download-alt"></i></a>
</div>
<?php } ?>

<div align="center" style="background-color: rgb(0, 141, 210);padding: 5px;font-size: 12px;font-weight: bold;color: #fff;vertical-align: middle;">
<span>Your Society is empowered by HousingMatters - 
<i>"Making Life Simpler"</i></span><br>
<span style="color:#FFF;">Email: support@housingmatters.in</span> &nbsp;|&nbsp; <span>Phone : 022-41235568</span> &nbsp;|&nbsp; <span style="color:#FFF;">www.housingmatters.co.in</span></div>


</div>