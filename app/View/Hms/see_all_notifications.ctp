<h4 style="color:#02689b;"><i class=" icon-bell"></i> All Notifications</h4>
<div style=" background-color: #fff; padding: 5px; ">
<?php
if(sizeof($result_notification)==0) { echo '<div align="center"><h4>No notification for you.</h4></div>'; }
foreach($result_notification as $data)
{
$notification_id=$data['notification']['notification_id'];
$text=$data['notification']['text'];
$url=$data['notification']['url'];
$icon=$data['notification']['icon'];
$by_user=$data['notification']['by_user'];
$date=$data['notification']['date'];

$result_user_info=$this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'), array('pass' => array($by_user)));
foreach($result_user_info as $collection2)
{
$user_name=$collection2["user"]["user_name"];
$profile_pic=$collection2["user"]["profile_pic"];
$wing=$collection2["user"]["wing"];
$flat=$collection2["user"]["flat"];

}

$flat_info=$this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'), array('pass' => array(@$wing,@$flat)));


$now = time();
$your_date = strtotime($date);
$datediff = $now - $your_date;
$days=floor($datediff/(60*60*24));
if($days==0) { $before_days='Today'; }
if($days==1) { $before_days='Yesterday'; }
if($days>1) { $before_days=''.$days.' days ago'; }


?>
<a href="<?php echo $url; ?>" style="text-decoration:none;"><div class="ntfction_list"><?php echo $icon; ?> <?php echo $text; ?> <?php echo @$user_name; ?> <?php echo $flat_info; ?>.  <span style="color:#C0C7CC;"><?php echo $before_days; ?></span></div></a>
<?php } ?>
</div>						