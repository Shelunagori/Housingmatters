<input type="hidden" value="<?php echo $hd_id; ?>" id="hd_id">
<link href="<?php echo $this->webroot ; ?>/as/reply.css" rel="stylesheet" />

<div style="border:solid 2px #269abc; width:80%; margin-left:10%;overflow:auto;">
<div style="border-bottom:solid 2px #269abc; color:white; background-color: #39b3d7; padding:4px; font-size:20px;" align="center">Ticket# <?php echo $ticket_id; ?>-<?php echo $help_desk_category_name; ?></div>

<div style="padding:10px;">

<div class="pull-right">
<span style="color:#269abc;font-size:14px;">Date: <?php echo $help_desk_date; ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $help_desk_time; ?></span>

</div>


<?php if(!empty($help_desk_description)) { ?>
<p style="font-size:14px;"><b>Description</b></p>
<p style="font-size:14px;"><?php echo $help_desk_description; ?></p>
<?php } ?>


<?php if(!empty($help_desk_file)) { ?>
<br/>
<p style="font-size:14px;"><b>Attachment</b></p>
<div >
<img src="<?php echo $this->webroot ; ?>/help_desk_file/<?php echo $help_desk_file; ?>" style="height:150px; max-width:80%;" />
</div>
<?php } ?>



<?php if($status===1) { ?>
<div style="color:#ac2925; font-size:16px;">	
<div class="pull-left" style="font-size:20px;"><i class="icon-ban-circle"></i></div>

<div style="padding-left:20px;">
<strong></strong> Ticket has been closed on <?php echo @$help_desk_close_date ;?><br><div><?php echo $help_desk_close_comment;?>
</div>
		
</div>
		
</div>
<?php } ?>
						  
                         

</div>
</div>







<br/>
<div style="border:solid 2px #d58512; width:80%; margin-left:10%;">
<div style="border-bottom:solid 2px #d58512; color:white; background-color: #ed9c28; padding:4px; font-size:20px;" align="center">Conversation History</div>

<div style="padding:10px; overflow: auto;">
<div id="reply_post">
<?php
$s_user_id=$this->Session->read('user_id');
if(sizeof($result_reply)==0) { ?> <h4>No Record Found.</h4> <?php };
foreach ($result_reply as $collection) 
{
$date=$collection['help_desk_reply']['date'];
$time=$collection['help_desk_reply']['time'];
$reply=$collection['help_desk_reply']['reply'];
$class=$collection['help_desk_reply']['class'];
$d_user=$collection['help_desk_reply']['user_id'];

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

<?php if($status==0) { ?>
<div class="controls">
<textarea class="m-wrap" id="msg_reply" style="resize:none; width:98%; height:80px;"></textarea>
</div>
<div class="modal-footer">
<button type="button" id="reply" class="btn yellow"><i class=" icon-share"></i> Reply</button>
</div>
<?php } ?>
      
</div>
</div>

<script>
	

$(document).ready(function() {
	$("#reply").live('click',function(){
	
			var r=$("#msg_reply").val();
			var a=$("#hd_id").val();
			if(r!="")
			{
			//$("#reply_post").append('<div class="outt"><div><span class="pull-right" style="font-size:12px; color:#A5A5A5;">Few minutes ago</span><br>'+ r +'</div></div>');
			r=encodeURIComponent(r);
			$("#reply_post").load('save_reply_resident?reply=' + r + '&id=' + a);
			$("#msg_reply").val('');
			}
			
				
	});
});

</script>
