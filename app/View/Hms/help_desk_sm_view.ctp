<link href="<?php echo $this->webroot ; ?>/as/reply.css" rel="stylesheet" />
<div style="border:solid 2px #269abc; width:80%; margin-left:10%;overflow: auto;">
<div style="border-bottom:solid 2px #269abc; color:white; background-color: #39b3d7; padding:4px; font-size:20px; " align="center">Ticket# <?php echo $ticket_id; ?>-<?php echo $help_desk_category_name; ?></div>

<div style="padding:10px;overflow:auto;">

<div class="pull-right">
<span style="color:#269abc;font-size:14px;">Date: <?php echo $help_desk_date; ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $help_desk_time; ?></span>

</div>


<?php
$result=$this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'), array('pass' => array($d_user_id)));
foreach ($result as $data) 
{
$user_name=$data["user"]["user_name"];
$wing=$data["user"]["wing"];
$flat=$data["user"]["flat"];
$email=$data["user"]["email"];
$mobile=$data["user"]["mobile"];
}

$flat=$this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'), array('pass' => array($wing,$flat)));
?>
<span style="color:#269abc;font-size:16px;">Ticket Raised By:-   <?php echo $user_name; ?> <?php echo $flat; ?></span>
<hr>

<?php if(!empty($help_desk_description)) { ?>
<p style="font-size:14px;"><b>Description</b></p>
<p style="font-size:14px;"><?php echo $help_desk_description; ?></p>
<hr/>
<?php } ?>


<?php if(!empty($help_desk_file)) { ?>
<br/>
<p style="font-size:14px;"><b>Attachment</b></p>
<div >
<img src="<?php echo $this->webroot ; ?>/help_desk_file/<?php echo $help_desk_file; ?>" style="height:150px; max-width:80%;" />
</div>
<hr/>
<?php } ?>



<?php if($hd_sp_id!=0) { ?>

<div style="color:green; font-size:16px;">	
<div class="pull-left" style="font-size:20px;"><i class="icon-ok"></i></div>

<div style="padding-left:20px;">
<strong></strong> Ticket Assigned on <?php echo $help_desk_assign_date; ?> to <?php echo $sp_name; ?> 
		
</div>
		
</div>
<br/>
<hr>
<?php } ?>



<?php if($status==1) { ?>
<div style="color:#ac2925; font-size:16px;">	
<div class="pull-left" style="font-size:20px;"><i class="icon-ban-circle"></i></div>

<div style="padding-left:20px;">
Ticket has been closed on <?php echo @$help_desk_close_date ;?><br>
<span><?php echo $help_desk_close_comment;?></span>
		
</div>
		
</div>
<?php } ?>
						  

<?php if($hd_sp_id==0 && $status==0) { ?>						  
<!----------Assign------->					  
<div class="accordion-group pull-left" style="width:49%;;">
<div class="accordion-heading">
	<a class="btn tooltips accordion-toggle collapsed" style=" border: solid 2px #269abc; color:#269abc; background-color: #fff;font-size:16px;" data-toggle="collapse" data-parent="#accordion1" href="#collapse_3">
		Assign Ticket to Service Provider 
		</a>
</div>
<div id="collapse_3" class="accordion-body collapse" style="height: 0px;">
	<div class="accordion-inner" style="border: solid 2px #269abc; border-top:none; ">
		<!----------------->
		<div class="portlet-body">
		<div class="accordion in collapse" id="accordion1" style="height: auto;">
		<?php
		foreach ($result_vendor as $collection)
		{
		$vendor_id = (int)$collection['vendor']['vendor_id'];

		$result_sp=$this->requestAction(array('controller' => 'hms', 'action' => 'fetch_service_provider_info_via_vendor_id'), array('pass' => array($vendor_id)));
		foreach ($result_sp as $collection2)
		{
		$sp_id=(int)$collection2['service_provider']['sp_id'];
		$sp_name=$collection2['service_provider']['sp_name'];
		$sp_email=$collection2['service_provider']['sp_email'];
		$mobile=$collection2['service_provider']['sp_mobile'];
		$sp_society_id=(int)$collection2['service_provider']['society_id'];
		}
		?>
			<div class="accordion-group">
				<div class="accordion-heading">
					<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion1" href="#myModal<?php echo $sp_id; ?>">
					<?php echo $sp_name; ?>
					</a>
				</div>
				<div id="myModal<?php echo $sp_id; ?>" class="accordion-body collapse">
					<div class="accordion-inner">
						<form method="post" >
						<input type="hidden" value="<?php echo $hd_id; ?>" id="hd_id" name="hd_id">
						<h5 id="myModalLabel1">Assign Ticket# [<?php echo $ticket_id; ?>] to [<?php echo $sp_name; ?>] Via email</h5>
						<table style="font-size:14px;" width="100%">
						<tbody><tr>
						<td valign="top">To:</td>
						<td>abhilashlohar01@gmail.com</td>
						</tr>
						<tr>
						<td valign="top">Subject:</td>
						<td>[Ticket# <?php echo $ticket_id; ?>]-<?php echo $user_name; ?></td>
						</tr>
						<tr>
						<td valign="top">Message:</td>
						<td><textarea class="m-wrap span12" id="asign_msg<?php echo $sp_id; ?>" style="resize:none;  height:80px;"></textarea></td>
						</tr>
						</tbody></table>
						<div class="pull-right"><button type="button" onclick=assign_ticket(<?php echo $sp_id; ?>) class="btn blue">Assign Ticket</button></div>
						</form>
					</div>
				</div>
			</div>
	<?php } ?>
		</div>
	</div>
	<!---------------------->
	</div>
</div>
</div>					  
<!----------Assign------->	
<?php } ?>



<?php if($help_desk_status===0) { ?>
<div class="accordion-group pull-right" style="width:49%;">
	<div class="accordion-heading">
		<a class="btn tooltips accordion-toggle collapsed" style=" border: solid 2px green; color:green; background-color: #fff;font-size:16px;" data-toggle="collapse" data-parent="#accordion1" href="#collapse_2" >
		Close Ticket
		</a>
	</div>
	<div id="collapse_2" class="accordion-body collapse">
		<div class="accordion-inner" style="border: solid 2px green; border-top:none;overflow: auto; ">
			<form method="post">
			<input type="hidden" value="<?php echo $hd_id; ?>" id="hd_id" name="hd_id">
			 <table style="font-size:14px;" width="100%">
				<tr>
				<td valign="top">To:</td>
				<td><?php echo $user_name ;?></td>
				</tr>
				<tr>
				<td valign="top">Subject:</td>
				<td>[Ticket# <?php echo $ticket_id; ?>]-<?php echo $user_name; ?></td>
				</tr>
				<tr>
				<td valign="top">Message:</td>
				<td><textarea class="m-wrap span12" name="close_msg" style="resize:none;  height:80px;" ></textarea></td>
				</tr>
			 </table>
			 <div class="pull-right"><button type="submit"   name="close"  class="btn blue">Close Ticket</button><br/></div>
			</form>
		</div>
		
	</div>
	
	

</div>
<?php } ?>
						  

</div>
</div>







<br/>
<div style="border:solid 2px #d58512; width:80%; margin-left:10%;">
<div style="border-bottom:solid 2px #d58512; color:white; background-color: #ed9c28; padding:4px; font-size:20px;" align="center">Conversation History</div>

<div style="padding:10px;overflow:auto;" >
<div id="reply_post">
<?php
$s_user_id=$this->Session->read('user_id');

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
<img  src="<?php echo $this->webroot ; ?>/profile/<?php echo $profile_pic; ?>" height="50px">
</div>
<?php } ?>
<div <?php if ($class=="in") { ?>style="padding-left: 60px;" <?php } ?>>
<?php if($d_user!=$s_user_id) { ?>
<span style="font-size:14px; color:#3590c1;"> <?php echo $user_name; ?> <?php echo $flat; ?> </span>
<?php } ?>
<span class="pull-right" style="font-size:12px; color:#A5A5A5;"> at <?php echo $date; ?> &nbsp; <?php echo $time; ?> </span>
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

function assign_ticket(sp_id)
{

	$(document).ready(function() {
		
				var msg=encodeURIComponent($("#asign_msg"+sp_id).val());
				var hd_id=$("#hd_id").val();
				window.location.href = "assign_ticket_to_sp?sp_id="+sp_id+"&msg="+msg+"&hd_id="+hd_id;
			
		
		
		});
	
}
</script>

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








