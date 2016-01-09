<?php
	 $s_user_id=$this->Session->read('user_id');
	 foreach($result_reply as $data1)
	{
	$date=$data1['notice_board_reply']['date'];
	$time=$data1['notice_board_reply']['time'];
	$class=$data1['notice_board_reply']['class'];
	$reply=$data1['notice_board_reply']['reply'];
	$d_user=$data1['notice_board_reply']['user_id'];
	
	$result=$this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'), array('pass' => array($d_user)));
	foreach($result as $data1)
	{
	$user_name=$data1['user']['user_name'];
	$profile_pic=$data1['user']['profile_pic'];
	$wing=$data1['user']['wing'];
	$flat=$data1['user']['flat'];
	}
	
	$wing_flat=$this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'), array('pass' => array($wing,$flat)));
	 ?>
	 <ul class="chats" >
		<li <?php if($d_user==$s_user_id) { ?> class="out" <?php }  if($d_user!=$s_user_id) { ?> class="in" <?php } ?>><img class="avatar" alt="" src="<?php echo $this->webroot ; ?>/as/profile_pic/<?php echo $profile_pic ;?> ">
		<div class="message" style="min-height:65px;">
		<span class="arrow"></span>
		<a href="#" class="name"><?php echo $user_name ; ?>&nbsp; <?php echo $wing_flat;?></a><br>
		<span class="datetime" style="color:#666;">at <?php echo $date; ?>&nbsp&nbsp<?php echo $time; ?></span>
		<span class="body" >
		<?php echo $reply; ?>
		</span>
		</div>
		</li> 
	</ul>
	 <?php } ?>