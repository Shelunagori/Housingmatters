<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>

<script>
$(document).ready(function() {
$("#fix<?php echo @$id_current_page; ?>").removeClass("blue");
$("#fix<?php echo @$id_current_page; ?>").addClass("red");
});
</script>

<?php
if(sizeof($result_poll)==0)
{
echo '<div align="center"><h4>No record found</h4></div>';
}
foreach($result_poll as $data)
{
$poll_id=$data["poll"]["poll_id"];
$d_user_id=$data["poll"]["user_id"];

$created=$data["poll"]["created"];

//////////////////////////user info////////////////
$result_user=$this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'), array('pass' => array($d_user_id)));
foreach($result_user as $data_user)
{
$user_name=$data_user['user']['user_name'];
$wing=$data_user['user']['wing'];
$flat=$data_user['user']['flat'];
}

$flat_info=$this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'), array('pass' => array($wing,$flat)));
//////////////////////////user info////////////////
$question=$data["poll"]["question"];
$des=$data["poll"]["des"];
$choice=$data["poll"]["choice"];
$file=$data["poll"]["file"];
$close_date=@$data["poll"]["close_date"];
$private=@$data["poll"]["private"];
$type=(int)$data["poll"]["type"];
if($type==1) { $inputtype='radio';}
if($type==2) { $inputtype='checkbox';}

$results=@$data["poll"]["result"];
////////////check user voted or not//////////////
if(sizeof($results)>0) {
$voted=0;
foreach ($results as $result) 
{
	if ($s_user_id==$result[0]) { $voted=1; }
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

$current_date = date('Y-m-d');
$current_date = new MongoDate(strtotime($current_date));


?>
<!-------------LINE------------------------->
<div style="width: 80%;margin-left: 10%;" >
	<div class="portlet solid bordered light-grey" style="border:solid 1px #ccc;min-height: 100px;">
		<div style="border-bottom: 1px solid #eee;">
			<div style="margin-bottom: 5px;margin-top: 5px;">
			<span style="color:#3B6B96;font-size: 16px;font-weight: bold;"><i class="icon-question-sign"></i> <?php echo $question; ?></span><br/>
			<span style="font-size: 12px;"><?php echo $des; ?></span>
			</div>
		</div>
	
<div style="padding:3px;">

<table width="100%" id="poll<?php echo $poll_id; ?>" >

	
	
	

		
		<?php 
		$ol='A';
		
		foreach($choice as $key => $value)
		{ 
		$count_vote=0;
	
		if(sizeof($results)>0)
		{
		foreach ($results as $result) 
		{
			if ($key==$result[1]) { $count_vote++; }
		}
		}
		?>
		<tr>
			<td width="50%">
			
			
				<div style="font-size:14px;">
				<span style="font-weight:bold;"><?php echo $ol; ?>.</span>&nbsp;&nbsp; 
				<span><?php echo $value[0]; ?></span>
				</div>
			
			
			</td>
			<?php if($private==0) { ?>
			<td width="48%">
				<?php 
				@$perctg=(($count_vote*100)/$total_vote).'%';
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
		
	
	
	
	

</table>

</div>

<div style="color: #404040;">
<span style="font-weight: 200;">created on: </span><span style="font-weight: 600;"><?php echo date('d-m-Y',$created->sec); ?></span>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<span style="font-weight: 200;">closed on: </span><span style="font-weight: 600;"><?php echo date('d-m-Y',$close_date->sec); ?></span>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<span style="font-weight: 200;">created by: </span><span style="font-weight: 600;"><?php echo $user_name.' '.$flat_info; ?></span>
</div>
	
	</div>
</div>


<?php
}
?>



