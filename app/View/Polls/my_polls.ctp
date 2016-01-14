<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>
<script>
$(document).ready(function() {
$("#fix<?php echo @$id_current_page; ?>").removeClass("blue");
$("#fix<?php echo @$id_current_page; ?>").addClass("red");
});
</script>

<style>
.datepicker { 
  z-index: 9999;
}
</style>

<?php
if(sizeof($result_poll)==0)
{
echo '<div align="center"><h4>No record found</h4></div>';
}
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
$close_date=@$data["poll"]["close_date"];
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
else { $results=array(); $voted=0; }
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
	<div class="portlet solid bordered light-grey" style="border:solid 1px #ccc;min-height: 100px;" id="poll<?php echo $poll_id; ?>">
		<div style="border-bottom: 1px solid #eee;">
			<div style="margin-bottom: 5px;margin-top: 5px;">
			
			<span style="color:#3B6B96;font-size: 16px;font-weight: bold;" ><i class="icon-question-sign"></i> <?php echo $question; ?></span><br/>
			<span style="font-size: 12px;" id="des<?php echo $poll_id; ?>"><?php echo $des; ?></span>
			
			</div>
		</div>

<div style="padding:3px;">

<table width="100%" id="poll<?php echo $poll_id; ?>">

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
			
			
				<div style="font-size:14px;">
				<span style="font-weight:bold;"><?php echo $ol; ?>.</span>&nbsp;&nbsp; 
				<span style=""> <?php echo $value[0]; ?></span>
				</div>
			
			
			</td>
			
			<td width="48%">
				<?php 
				if(!empty($total_vote))
				{
				$perctg=(($count_vote*100)/$total_vote).'%';
				$perctg = (sprintf ("%.2f", $perctg)+0);
				}
				else
				{
				$perctg = 0;
				}
				?>
				<div style="border:solid 1px #ccc;height:15px;">
				<div style="background-color: <?php echo $value[1]; ?>;width:<?php echo $perctg; ?>%;height: 15px;"></div>
				</div>
			</td>
			
			<td width="2%">
			<span style="color:#797979"><?php echo $perctg.'%'; ?></span>
			</td>
		</tr>
		<?php $ol++; } ?> 
		
		<tr><td width="50%"></td><td colspan="2" width="50%" style="font-size:14px;" align="right">Total Vote : <span class="label label-info"><?php echo $total_vote_users; ?></span></td></tr>
		
		<tr>
		<td >
		<div >
			<a href="#" role='button' edit_id="<?php echo $poll_id; ?>" class="btn mini blue edit_poll"><i class="icon-pencil"></i> Edit</a>
			<a href="#" role='button' edit_id="<?php echo $poll_id; ?>"  class="btn mini red delete_poll"><i class="icon-trash"></i> Delete</a>
				
		</div>
		</td>
		
		<td align="right">
		<?php
		$now = time();
		$close_date1 = date('Y-m-d',$close_date->sec);
		$close_date2=date('d-m-Y',$close_date->sec);
		?>
		<strong>close date : <span id="close_date<?php echo $poll_id; ?>" ><?php echo $close_date2; ?></span></strong>
			
		
		
		</td>
		
		
		</tr>



</table>

</div>
	
	</div>
</div>


<?php
}
?>

<script>
$(document).ready(function() {
	 $(".edit_poll").live('click',function(){
		$(".edit_div").show();
		var p_id=$(this).attr("edit_id");
		
		$("#poll_edit_content").html('<div align="center" style="padding:20px;"><img src="<?php echo $this->webroot ; ?>/as/indicator_blue_small.gif" /><br/><h5>Please Wait</h5></div>').load('<?php echo $this->webroot; ?>Polls/poll_edit?p_id='+p_id+'&edit=0');
	 });
	 
	 $("#close_edit").live('click',function(){
		$(".edit_div").hide();
	 });
	 
	 $(".save_edited_poll").live('click',function(){
	 
		var p_id=$(this).attr("poll_id");
		var des1=$("#description").val();
		var des=encodeURIComponent(des1);
		var close_date1=$("#close_date").val();
		var close_date=encodeURIComponent(close_date1);
		
		$("#des"+p_id).html(des1);
		$("#close_date"+p_id).html(close_date1);
			
		$("#poll_edit_content").load('<?php echo $this->webroot; ?>Polls/poll_edit?p_id='+p_id+'&des='+des+'&c_date='+close_date+'&edit=1', function() {
			
		});
		
	 });
	 
	 
	 
	 $(".delete_poll").live('click',function(){

		$(".edit_div").show();
		var p_id=$(this).attr("edit_id");
		
		$("#poll_edit_content").html('<div align="center" style="padding:20px;"><img src="<?php echo $this->webroot ; ?>/as/indicator_blue_small.gif" /><br/><h5>Please Wait</h5></div>').load('<?php echo $this->webroot; ?>Polls/poll_delete?p_id='+p_id+'&delete=0');
	 });
	 
	 $(".delete_poll_btn").live('click',function(){
		var p_id=$(this).attr("poll_id");
		$("#poll_edit_content").load('<?php echo $this->webroot; ?>Polls/poll_delete?p_id='+p_id+'&delete=1', function() {
			$("#poll"+p_id).remove();
		});
		
	 });
});
</script>

<div class="edit_div" style="display: none;">
<div class="modal-backdrop fade in"></div>
<div class="modal"  id="poll_edit_content">
	
</div>
</div>