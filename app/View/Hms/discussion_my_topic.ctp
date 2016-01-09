
<?php

if($q==1) {
?>
<div align="center" style="font-size:16px; padding:2px;">My Topics</div>
<?php

foreach($result_my_topic as $collection)
{
$discussion_post_id=(int)$collection["discussion_post"]["discussion_post_id"];
$topic=$collection["discussion_post"]["topic"];
$d_user_id=(int)$collection["discussion_post"]["user_id"];
$date=$collection["discussion_post"]["date"];
$time=$collection["discussion_post"]["time"];
$n_comments=$this->requestAction(array('controller' => 'hms', 'action' => 'count_comment_of_topic'), array('pass' => array($discussion_post_id)));
?>
<a  class="btn mini red pull-right" role='button' onclick="delete_topic(<?php echo $discussion_post_id; ?>)">Close Topic </a>
<a href="discussion_forum?t=<?php echo $discussion_post_id; ?>&list=1" role='button' rel="tab" style="text-decoration:none;">
<div style="padding:2px;">
<div  style="background-color:#F4F8FF; cursor:pointer; color:#06F; padding:5px; border:solid 2px #D9E8FF;" class="topic sel" id="t1" >

<div align="center" style="font-size:18px;" ><?php echo $topic; ?></div>
<div align="center" ><span>(<?php echo $n_comments; ?> Comments )</span>&nbsp;&nbsp;<?php echo $date; ?>&nbsp;&nbsp; <?php echo $time; ?></div>
</div>
</div>
</div>
</div>
</a>
<?php }
if(sizeof($result_my_topic)==0)
{
?>
<div align="center"><h4>No Record Found.</h4></div>
<?php
}
 } ?>






<?php
if($q==2) {
?>
<div align="center" style="font-size:16px; padding:2px;">All Topics</div>
<?php
foreach($result_all_topic as $collection)
{
$discussion_post_id=(int)$collection["discussion_post"]["discussion_post_id"];
$topic=$collection["discussion_post"]["topic"];
$d_user_id=(int)$collection["discussion_post"]["user_id"];
$date=$collection["discussion_post"]["date"];
$time=$collection["discussion_post"]["time"];

$n_comments=$this->requestAction(array('controller' => 'hms', 'action' => 'count_comment_of_topic'), array('pass' => array($discussion_post_id)));
?>
<div style="padding:2px;">
<div  style="background-color:#F4F8FF; cursor:pointer; color:#06F; padding:5px; border:solid 2px #D9E8FF;" class="topic sel" id="t1" onclick="details_topic(<?php echo $discussion_post_id; ?>)">

<div align="center" style="font-size:18px;" ><?php echo $topic; ?></div>
<div align="center" ><span>(<?php echo $n_comments; ?> Comments )</span>&nbsp;&nbsp;<?php echo $date; ?>&nbsp;&nbsp; <?php echo $time; ?></div>

</div>
</div>

</div>
</div>
<?php }
if(sizeof($result_all_topic)==0)
{
?>
<div align="center"><h4>No Record Found.</h4></div>
<?php
}
 } ?>


<?php
if($q==3) {
?>
<div align="center" style="font-size:16px; padding:2px;">Archived Discussions</div>
<?php

foreach($result_deleted_topic as $collection)
{
$discussion_post_id=(int)$collection["discussion_post"]["discussion_post_id"];
$topic=$collection["discussion_post"]["topic"];
$d_user_id=(int)$collection["discussion_post"]["user_id"];
$date=$collection["discussion_post"]["date"];
$time=$collection["discussion_post"]["time"];

$n_comments=$this->requestAction(array('controller' => 'hms', 'action' => 'count_comment_of_topic'), array('pass' => array($discussion_post_id)));
?>
<div style="padding:2px;">
<div  style="background-color:#F4F8FF; cursor:pointer; color:#06F; padding:5px; border:solid 2px #D9E8FF;" class="topic sel" id="t1" onclick="details_topic_deleted(<?php echo $discussion_post_id; ?>)">
<a href="#" class="btn mini red pull-right" role='button' onclick="delete_topic_archive(<?php echo $discussion_post_id; ?>)"> <i class='icon-remove'></i> </a>
<div align="center" style="font-size:18px;" ><?php echo $topic; ?></div>
<div align="center" ><span>(<?php echo $n_comments; ?> Comments )</span>&nbsp;&nbsp;<?php echo $date; ?>&nbsp;&nbsp; <?php echo $time; ?></div>

</div>
</div>

</div>
</div>
<?php }
if(sizeof($result_deleted_topic)==0)
{
?>
<div align="center"><h4>No Record Found.</h4></div>
<?php
}
 } ?>