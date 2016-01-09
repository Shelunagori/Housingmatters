
<div align="center" style="font-size:16px; padding:2px;">Search Results</div>

<?php
foreach($result_all_topic as $collection)
{
$discussion_post_id=(int)$collection["discussion_post"]["discussion_post_id"];
$discussion_post_id=$this->requestAction(array('controller' => 'hms', 'action' => 'encode'), array('pass' => array($discussion_post_id,'housingmatters')));
$topic=$collection["discussion_post"]["topic"];
$d_user_id=(int)$collection["discussion_post"]["user_id"];
$date=$collection["discussion_post"]["date"];
$time=$collection["discussion_post"]["time"];

$n_comments=$this->requestAction(array('controller' => 'hms', 'action' => 'count_comment_of_topic'), array('pass' => array($discussion_post_id)));
?>
<a href="<?php echo $webroot_path;?>Discussions/index/<?php echo $discussion_post_id; ?>/0" role='button' rel="tab" style="text-decoration:none;">
<div style="padding:2px;">
<div  style="background-color:#F4F8FF; cursor:pointer; color:#06F; padding:5px; border:solid 2px #D9E8FF;" class="topic sel" id="t1" >

<div align="center" style="font-size:18px;" ><?php echo $topic; ?></div>
<div align="center" ><span>(<?php echo $n_comments; ?> Comments )</span>&nbsp;&nbsp;<?php echo $date; ?>&nbsp;&nbsp; <?php echo $time; ?></div>

</div>
</div>

</a>
<?php }?>

<?php
if(sizeof($result_all_topic)==0)
{
?>
<div align="center"><h4>No Record found.</h4></div>
<?php
}
?>