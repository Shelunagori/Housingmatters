<input type="hidden" id="notice_id" value="<?php echo $n_id; ?>" >
<a href="notice_board" rel='tab' style="font-size:20px; color:#fcb322;"><i class="icon-circle-arrow-left" ></i> All Notices</a>
<?php


foreach($result_view as $data)
{
$n_subject=$data['notice']['n_subject'];
$n_message=$data['notice']['n_message'];
$n_date=$data['notice']['n_date'];
$n_time=$data['notice']['n_time'];
}
?>
<div style="background-color:#F3F3F3; border:solid 2px #fcb322; padding:10px; width:80%; margin-left:10%;">
<div align="center" style="background-color:#CCC;"><h3><b><?php echo $n_subject; ?></b></h3></div>
<div align="right"><span ><?php echo $n_date; ?>&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $n_time; ?></span></div>

<div align="justify"><?php echo $n_message; ?></div>
</div>


<br/>
<div style="border:solid 2px #d58512; width:80%; margin-left:10%;">
<div style="border-bottom:solid 2px #d58512; color:white; background-color: #ed9c28; padding:4px; font-size:20px;" align="center">Conversation History</div>

<div style="padding:10px;">
<div id="reply_post">
<?php
$s_user_id=$this->Session->read('user_id');
foreach ($result_reply as $collection) 
{
$date=$collection['notice_board_reply']['date'];
$time=$collection['notice_board_reply']['time'];
$reply=$collection['notice_board_reply']['reply'];
$class=$collection['notice_board_reply']['class'];
$d_user=$collection['notice_board_reply']['user_id'];

$result=$this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'), array('pass' => array($d_user)));
foreach($result as $data)
{
$profile_pic=$data['user']['profile_pic'];
$user_name=$data['user']['user_name'];
$wing=$data['user']['wing'];
$flat=$data['user']['flat'];
$profile_pic=$data['user']['profile_pic'];
}

$flat=$this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'), array('pass' => array($wing,$flat)));
?>

<div <?php if($d_user==$s_user_id) { ?> class="outt" <?php }  if($d_user!=$s_user_id) { ?> class="inn" <?php } ?>>
<?php if($d_user!=$s_user_id) { ?>
<div <?php if($d_user==$s_user_id) { ?> class="outt_im" <?php }  if($d_user!=$s_user_id) { ?> class="inn_im" <?php } ?>>
<img  src="<?php echo $this->webroot ; ?>/profile/<?php echo $profile_pic; ?>">
</div>
<?php } ?>
<div <?php if ($class=="in") { ?>style="padding-left: 60px;" <?php } ?>>
<?php if($d_user!=$s_user_id) { ?>
<span style="font-size:14px; color:#3590c1;"><?php echo $user_name; ?><?php echo $flat; ?></span>
<?php } ?>
<span class="pull-right" style="font-size:12px; color:#A5A5A5;">at<?php echo $date; ?>&nbsp;<?php echo $time; ?></span>
<br/>

<?php echo $reply; ?>
</div>
</div>

<?php } ?>
</div>
<div id="save_reply"></div>
<div class="controls">
<textarea class="m-wrap" id="msg_reply" style="resize:none; width:98%; height:80px;"></textarea>
</div>
<div class="modal-footer">
<button type="button" id="reply" class="btn yellow"><i class=" icon-share"></i> Reply</button>
</div>
      
</div>
</div>

<input type="hidden" id="notice_id" value="<?php echo $n_id; ?>">

<script>
function submit_reply()
{
$(document).ready(function() {	
var m_reply=$("#msg_reply").val();	
var n_id=$("#notice_id").val();
$("#ajax_result").load('notice_board_view_reply?m_reply='+m_reply+'&con='+n_id);
$("#msg_reply").val("");

	
});

}
</script>

<!--------REPLY------------>
<link href="<?php echo $this->webroot ; ?>/as/reply.css" rel="stylesheet" />
<?php $a=1; ?>
<script>
	

$(document).ready(function() {
	$("#reply").live('click',function(){
	
			var r=$("#msg_reply").val();
			var n_id=$("#notice_id").val();
			$("#reply_post").append('<div class="outt"><div><span class="pull-right" style="font-size:12px; color:#A5A5A5;">Few minutes ago</span><br>'+ r +'</div></div>');
			r=encodeURIComponent(r);
			$("#save_reply").html('Saving reply...').load('notice_save_reply?reply=' + r + '&n_id=' + n_id);
			$("#msg_reply").val('');
			
				
	});
});

</script>

