<div class="portlet-body" style="padding-left:20px;padding-right:20px;">
<div style="border:solid 2px #4cae4c;">
<table class="table table-striped table-hover hide_at_print">
	<thead>
		<tr style="background-color: #5cb85c;border-bottom: solid 2px #4cae4c; color:#fff;">
			<th width="80%"><a class="btn mini" style="border: solid 2px #fff;background-color: #4cae4c;color:#fff;" id="back"><i class=" icon-chevron-left"></i> All Emails</a></th>
			<th width="20%"></th>
		</tr>
	</thead>
</table>
	
<?php
foreach ($result_eamilview as $collection) 
{
$email_id=$collection["email_communication"]["email_id"];
$user_id=$collection["email_communication"]["user_id"];
$groups_id=@$collection["email_communication"]["groups_id"];
$type=$collection["email_communication"]["type"];
$subject=$collection["email_communication"]["subject"];
$message_web=$collection["email_communication"]["message_web"];
$date=$collection["email_communication"]["date"];
$time=$collection["email_communication"]["time"];
}

if($type==1) { $count_user='sent to: '.sizeof($user_id).'&nbsp;users'; }
if($type==2) { $count_user='sent to: '.sizeof($groups_id).'&nbsp;groups';}
?>

<!----------------------------content------------------------------->
<div style="padding:5px;">
<!------------->
<div class="pull-right">
<span class="label">Date: <?php echo $date; ?></span>
<span class="label">Time: <?php echo $time; ?></span><br/>
<span style="font-size:14px;"><?php echo $count_user;?></span><br/>
<a href="email_view_pdf?con=<?php echo $email_id; ?>" class="btn red mini hide_at_print ">pdf</i></a> 
<a class="btn blue mini hide_at_print" onclick="window.print()">print</a>
<a href="email_delete?id=<?php echo $email_id; ?>" class="btn red mini hide_at_print ">Delete</i></a> 
</div>
<!------------->
<span class="label label-info">To:</span>
<table class="table table-bordered table-striped ">
<?php
if($type==1)
{ ?>
<?php
foreach($user_id as $user)
{

	echo $user=(int)$user;
	$result_user = $this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'),array('pass'=>array($user)));
	foreach($result_user as $data2)
	{
	$user_name=$data2["user"]["user_name"];
	$wing=(int)$data2["user"]["wing"];
	$flat=(int)$data2["user"]["flat"];
	}
	
	$flat_info = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'),array('pass'=>array($wing,$flat)));
	?>
	<tr><td><?php echo $user_name; ?>&nbsp;&nbsp;<?php echo $flat_info; ?></td></tr>
<?php } ?>
<?php } ?>
<?php
if($type==2)
{ ?>

<?php
foreach($groups_id as $group)
{

	$group=(int)$group;
	$result_user = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_group_name_from_gruop_id'),array('pass'=>array($group)));
	?>
	<tr><td><?php echo $result_user; ?></td></tr>
<?php } ?>

<?php } ?>
</table>
<!------------->
<br/>
<span class="label label-info">Subject:</span>
<div style="font-size: 14px;"><?php echo $subject; ?></div>	
<!------------->
<br/>
<span class="label label-info">Message:</span>
<div style="font-size: 14px; overflow-x: scroll;border: solid 1px #ccc;">
<?php echo $message_web; ?>
</div>	

</div>
<!----------------------------content------------------------------->
</div>
</div>