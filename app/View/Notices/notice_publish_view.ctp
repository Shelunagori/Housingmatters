
<input type="hidden" id="notice_id" value="<?php echo $n_id; ?>" >
<a href="<?php echo $webroot_path ; ?>Notices/notice_publish" rel='tab' class="btn green"><i class="icon-circle-arrow-left" ></i> Back</a>
<br>
<?php


foreach($result_view as $data)
{
$n_draft_id=$data['notice']['n_draft_id'];
$n_subject=$data['notice']['n_subject'];
$n_message=$data['notice']['n_message'];
$n_attachment=$data['notice']['n_attachment'];
$n_date=$data['notice']['n_date'];
$n_time=$data['notice']['n_time'];
@$allowed=@$data['notice']['allowed'];
}
?>

<div style="background-color:#F3F3F3; border:solid 2px #fcb322; padding:10px;">
<div align="center" style="background-color:#CCC;"><h3><b><?php echo $n_subject; ?></b></h3></div>
<div align="right"><span ><?php echo $n_date; ?>&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $n_time; ?></span></div>
<div align="justify"><p style='font-size:15px;'><?php echo $n_message; ?></div>


<?php if(!empty($n_attachment)) { ?>
<br/>
<p style="font-size:14px;"><b>Attachment</b></p>
<div >
<a href="<?php echo $webroot_path ; ?>/notice_file/<?php echo $n_attachment; ?>" target="_blank" class="btn mini green tooltips" data-placement="bottom" data-original-title="<?php echo $n_attachment; ?>"><i class=" icon-download-alt"></i></a>
</div>
<?php } ?>


</div>


<?php if($allowed==1) { ?>
<div style="border:solid 2px #d58512;">
<div style="border-bottom:solid 2px #d58512; color:white; background-color: #ed9c28; padding:4px; font-size:20px;" align="center">Conversation History</div>

<div style="padding:10px;overflow: auto;">
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
}

$flat=$this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'), array('pass' => array($wing,$flat)));
?>

<div <?php if($d_user==$s_user_id) { ?> class="outt" <?php }  if($d_user!=$s_user_id) { ?> class="inn" <?php } ?>>
<?php if($d_user!=$s_user_id) { ?>
<div <?php if($d_user==$s_user_id) { ?> class="outt_im" <?php }  if($d_user!=$s_user_id) { ?> class="inn_im" <?php } ?>>
<img  src="<?php echo $webroot_path; ?>/profile/<?php echo $profile_pic; ?>">
</div>
<?php } ?>
<div <?php if ($class=="in") { ?>style="padding-left: 60px;" <?php } ?>>
<?php if($d_user!=$s_user_id) { ?>
<span style="font-size:14px; color:#3590c1;"><?php echo $user_name; ?> <?php echo $flat; ?></span>
<?php } ?>
<span class="pull-right" style="font-size:12px; color:#A5A5A5;">at <?php echo $date; ?> &nbsp; <?php echo $time; ?></span>
<br/>
&nbsp;
<?php echo $reply; ?>
</div>
</div>

<?php } ?>
</div>
<div id="save_reply"></div>
<?php if($n_draft_id!=2)
{ ?>
<div class="controls">
<textarea class="" id="msg_reply" style="resize:none; width:98%; height:80px; "></textarea>
</div>
<div class="modal-footer">
<button type="button" id="reply123" class="btn yellow"><i class=" icon-share"></i> Reply</button>
</div>
<?php } ?>    
</div>
</div>
<?php }

if($allowed==0){
	echo '<div class="alert alert-info">
			<strong>Info!</strong> Comments are not allowed on this notice.
		</div>';
} ?>
<br>
<?php if($n_draft_id==2)
{ ?>
<center><div > <p style='font-size:15px;'> This notice has been archived; no more comments are allowed. </p> </div>
<input type="hidden" id="notice_id" value="<?php echo $n_id; ?>"></center>
<?php } ?>
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
<link href="<?php echo $webroot_path ; ?>/as/reply.css" rel="stylesheet" />
<?php $a=1; ?>
<script>
	

$(document).ready(function() {
	$("#reply123").live('click',function(){
	
			var r=$("#msg_reply").val();
			var n_id=$("#notice_id").val();
			if(r!="")
			{
				//$("#reply_post").append('<div class="outt"><div><span class="pull-right" style="font-size:12px; color:#A5A5A5;">Few minutes ago</span><br>'+ r +'</div></div>');
				r=encodeURIComponent(r);
				$("#reply_post").load('<?php echo $this->webroot; ?>Notices/notice_save_reply?reply=' + r + '&n_id=' + n_id);
				$("#msg_reply").val('');
		}	
				
	});
});

</script>


