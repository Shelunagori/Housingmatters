<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>

<script>
$(document).ready(function() {
$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>
 <div style="background-color:#EFEFEF; border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6; padding:10px; box-shadow:5px; font-size:16px; color:#006;">
            Polls for  Approval  <span>
        </div>
		<br>
<div id='load_d' style='width: 80%; margin-left: 10%;'>

</div>
<?php
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
?>
<div style="width: 80%;margin-left: 10%;" id="poll_h<?php echo $poll_id ; ?>" >
	<div class="portlet solid bordered light-grey" style="border:solid 1px #ccc;min-height: 100px;">
		<div style="border-bottom: 1px solid #eee;">
			<div style="margin-bottom: 5px;margin-top: 5px;">
			<span style="color:#3B6B96;font-size: 16px;font-weight: bold;"><i class="icon-question-sign"></i> <?php echo $question; ?></span><br/>
			<span style="font-size: 12px;"><?php echo $des; ?></span>
			</div>
		</div>
	
<div style="padding:3px;">

<table width="100%" id="poll<?php echo $poll_id; ?>" >

	
	<tr>
		<td width="50%">
		<ol TYPE="A" style="font-weight:bold;">
		<?php if($type==1) { ?>
		<?php foreach($choice as $key => $value)
		{ ?>
			<li><label><input type="radio" name="option<?php echo $poll_id; ?>" value="<?php echo $key; ?>"><?php echo $value[0]; ?></label></li>
		<?php } ?>
		<?php } ?>
		</ol>
		<?php if($type==2) { ?>
		<div id="checkdiv<?php echo $poll_id; ?>">
		<ol TYPE="A" style="font-weight:bold;">
		<?php foreach($choice as $key => $value)
		{ ?>
			<li><label><input type="checkbox" name="option<?php echo $poll_id; ?>" value="<?php echo $key; ?>"><?php echo $value[0]; ?></label></li>
		<?php } ?>
		</ol>
		</div>
		<?php } ?>
		</td>
		
	</tr>
	
	
	
	<tr>
		<td>
		
		
		<button type="button" e_id="<?php echo $poll_id; ?>"  class="btn blue app "></i> Approved</button>
		<button type="button" e_id="<?php echo $poll_id; ?>"  class="btn red rej "></i> Reject</button>
			
		</td>
	</tr>
	
	

</table>

</div>


<div style="color: #404040;">
<span style="font-weight: 200;">created on: </span><span style="font-weight: 600;"><?php echo date('d-m-Y',$created->sec); ?></span>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<span style="font-weight: 200;">close date: </span><span style="font-weight: 600;"><?php echo date('d-m-Y',$close_date->sec); ?></span>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<span style="font-weight: 200;">created by: </span><span style="font-weight: 600;"><?php echo $user_name.' '.$flat_info; ?></span>
</div>
	
	</div>
</div>
<?php
}
?>

<script>
$(document).ready(function() {
$('.app').live("click",function(){
var r=$(this).attr("e_id");
$( "#load_d" ).html("<h5><b>Loading.....</b></h5>").load("poll_approve_ajax?p_id=" + r);
 $( "#poll_h" + r ).slideUp( "slow" ).hide(2000);
 
 setTimeout(function() {
	     //$("#load_d").slideUp( "slow" ).hide();
	}, 5000);
$("#load_d").show();

});


$(".rej").live("click",function(){
var r=$(this).attr("e_id");
$('#load_d').html('<div id="pp"><div class="modal-backdrop fade in"></div><div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true"><div class="modal-body" style="font-size:16px;"><i class="icon-warning-sign" style="color:#d84a38;"></i> Are you sure you want to reject polls ? </div><div class="modal-footer"><a href="poll_approve_reject?con='+r+'" class="btn blue" id="yes" >Yes</a><a href="#" role="button" id="can" class="btn"> No </a>  </div></div></div>');
});
$("#can").live("click",function(){
$("#pp").hide();


});


});

</script>
