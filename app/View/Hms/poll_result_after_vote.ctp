<?php
foreach($poll_vote as $data)
{
$poll_id=$data["poll"]["poll_id"];
$d_user_id=$data["poll"]["user_id"];
$private=@$data["poll"]["private"];
//////////////////////////user info////////////////
$result_user=$this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'), array('pass' => array($d_user_id)));
foreach($result_user as $data_user)
{
$user_name=$data_user['user']['user_name'];
$wing=$data_user['user']['wing'];
$flat=$data_user['user']['flat'];
}
//////////////////////////user info////////////////
$question=$data["poll"]["question"];
$choice=$data["poll"]["choice"];
$file=$data["poll"]["file"];
$type=(int)$data["poll"]["type"];
if($type==1) { $inputtype='radio';}
if($type==2) { $inputtype='checkbox';}

$results=@$data["poll"]["result"];
////////////check user voted or not//////////////
if(sizeof($results)>0) {
foreach ($results as $result) 
{
	if (in_array($s_user_id, $result) ) { $voted=1; }
	$user_voted[]=$result[0];
}
}
else { $voted=0; }
$total_vote=sizeof($results);
if(sizeof(@$user_voted)>0)
{
$total_vote_users=sizeof($user_voted_unique = array_unique(@$user_voted));
}
else{
$total_vote_users=0;
}
////////////check user voted or not//////////////


}

?>


<?php 
$ol='A';
foreach($choice as $key => $value)
{ 
$count_vote=0;
foreach ($results as $result) 
{
	if ($key==$result[1]) { $count_vote++; }
}
?>
<tr>
	<td width="50%">
	
	<?php if (@in_array(array($s_user_id, $key), $results)) { ?>
		<div style="font-size:14px;">
		<span style="font-weight:bold;"><?php echo $ol; ?>.</span>&nbsp;&nbsp; 
		<span style="color:green;"><i class=" icon-ok-sign"></i> 
		<?php echo $value[0]; ?></span>
		</div>
	<?php } 
	else
	{ ?>
		<div style="font-size:14px;">
		<span style="font-weight:bold;"><?php echo $ol; ?>.</span>&nbsp;&nbsp; 
		<span style="color:#6B6B6B;"><i class=" icon-remove-sign"></i> 
		<?php echo $value[0]; ?></span>
		</div>
	<?php } ?>
	
	</td>
	<?php if($private==0) { ?>
	<td width="48%">
		<?php 
		$perctg=(($count_vote*100)/$total_vote).'%';
		$perctg = (sprintf ("%.2f", $perctg)+0);
		?>
		<div style="border:solid 1px #ccc;height:15px;">
		<div style="background-color: <?php echo $value[1]; ?>;width:<?php echo $perctg; ?>%;height: 15px;"></div>
		</div>
	</td>
	
	<td width="2%">
	<span style="color:#797979"><?php echo $perctg.'%'; ?></span>
	</td>
	<?php } ?>
</tr>
<?php $ol++; } ?> 
<?php if($private==0) { ?>
<tr><td width="50%"></td><td colspan="2" width="50%" style="font-size:14px;" align="right">Total Vote : <span class="label label-info"><?php echo $total_vote_users; ?></span></td></tr>
<?php } ?>

