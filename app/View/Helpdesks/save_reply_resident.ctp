<link href="<?php echo $this->webroot ; ?>/as/reply.css" rel="stylesheet" />
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
<span style="font-size:14px; color:#3590c1;"><?php echo $user_name; ?><?php echo $flat; ?></span>
<?php } ?>
<span class="pull-right" style="font-size:12px; color:#A5A5A5;">at<?php echo $date; ?>&nbsp;<?php echo $time; ?></span>
<br/>

<?php echo $reply; ?>
</div>
</div>

<?php } ?>