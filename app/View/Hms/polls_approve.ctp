


<?php
foreach($result_poll as $data)
{
$poll_id=$data["poll"]["poll_id"];
$d_user_id=$data["poll"]["user_id"];
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
$des=$data["poll"]["des"];
$choice=$data["poll"]["choice"];
$file=$data["poll"]["file"];
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

<table width="100%" id="poll<?php echo $poll_id; ?>">

	<?php if(@$voted!=1) { ?>
	<tr>
		<td width="50%">
		<ol TYPE="A" style="font-weight:bold;">
		
		<?php foreach($choice as $key => $value)
		{ ?>
			<li><label><?php echo $value[0]; ?></label></li>
		<?php } ?>
		</ol>
		
		<?php if($type==1) { echo '<strong>Single Choice</strong>'; }?>
		<?php if($type==2) { echo '<strong>Multiple Choice</strong>'; }?>
		</td>
		<td width="50%" >
			<?php if($result[0]==$s_user_id) { ?>
			Vote Submited.
			<?php } ?>
		</td>
	</tr>
	<?php } ?>
	<tr>
		
	</tr>

</table>

<div id="result_action<?php echo $poll_id; ?>">
<div align="right">
	<a href="#" class="btn green" onclick="poll_approve_reject(<?php echo $poll_id; ?>,1)"><i class=" icon-ok"></i> Approve</a>

	<a class="accordion-toggle collapsed btn red"  data-toggle="collapse" data-parent="#accordion1" href="#collapse<?php echo $poll_id; ?>">
		<i class="icon-remove"></i>
		Reject
	</a>
</div>


<div id="collapse<?php echo $poll_id; ?>" class="accordion-body collapse">
<table width="100%">
<tr>
<td width="50%">

	
		<h5>Reject Comment</h5>
		<textarea class="m-wrap span12" id="comment<?php echo $poll_id; ?>" style="resize:none;  height:80px;margin-bottom: 0px;"></textarea>


</td>
<td width="50%" valign="bottom">
	<a href="#" class="btn red" onclick="poll_approve_reject(<?php echo $poll_id; ?>,2)"><i class=" icon-remove"></i> Reject this poll</a>
	<a class="accordion-toggle collapsed btn" data-toggle="collapse" data-parent="#accordion1" href="#collapse<?php echo $poll_id; ?>">
		Cancel
	</a>
</td>
</tr>
</table>
</div>

</div>

</div>

	
	</div>
</div>


<?php
}
?>

<script>
function poll_approve_reject(p_id,a_r)
{
$(document).ready(function() {

var comm=encodeURIComponent($( "#comment"+p_id ).val());

    if(a_r==1)
	{
	$( "#result_action"+p_id ).html('Please wait...').load( 'poll_approve_reject_submit?p_id=' + p_id + '&a_r=' + a_r, function() {
	  $("#result_action"+p_id).html('<div class="alert alert-success"><strong>Success!</strong> Poll has approved successfully.</div>');
	});
	}
	
	if(a_r==2)
	{
	$( "#result_action"+p_id ).html('Please wait...').load( 'poll_approve_reject_submit?p_id=' + p_id + '&a_r=' + a_r + '&comm=' + comm, function() {
	  $("#result_action"+p_id).html('<div class="alert alert-error"><strong>Success!</strong> Poll has rejected successfully.</div>');
	});
	}
			
		
});
}
</script>

