<?php 
foreach($result_comment_ref as $collection2)
{
$discussion_comment_id=$collection2["discussion_comment"]["discussion_comment_id"];
$comment=$collection2["discussion_comment"]["comment"];
$comment_user_id=$collection2["discussion_comment"]["user_id"];
@$offensive_user=$collection2["discussion_comment"]["offensive_user"];
$color=$collection2["discussion_comment"]["color"];
$date=$collection2["discussion_comment"]["date"];
$time=$collection2["discussion_comment"]["time"];

$result_user_info_c=$this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'), array('pass' => array($comment_user_id)));
foreach($result_user_info_c as $collection_c)
{
$user_name=$collection_c["user"]["user_name"];
$profile_pic=$collection_c["user"]["profile_pic"];
$wing=$collection_c["user"]["wing"];
$flat=$collection_c["user"]["flat"];

}

$flat_info_c=$this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'), array('pass' => array($wing,$flat)));
?>
<div
<?php if(@in_array($s_user_id,@$offensive_user))
{ ?> style="background-color: #FFE0DF;border-top: solid 2px #f1f3fa; " 
<?php } else { ?>  style="background-color: #fafafa;border-top: solid 2px #f1f3fa;" 
<?php } ?> id="comm<?php echo $discussion_comment_id; ?>" class="showhim"><table width="100%">
<tr>
<td width="15%" valign="top" style="padding:10px;"><img src="<?php echo $webroot_path ; ?>/profile/<?php echo $profile_pic; ?>" style="height:50px; width:50px;"/></td>
<td width="85%" valign="top" style="padding-left:5px;">


<!---   Delete and offensive  code  -------->
<?php if(!@in_array($s_user_id,$offensive_user))
{ ?>
<div class="btn-group " style="float:right;">

	<a  class="badge ok_t  dropdown-toggle" data-toggle="dropdown" ><i class="icon-angle-down" style='font-size: 16px;
  color: rgb(175, 173, 173);'></i></a>
				
				<ul class="dropdown-menu">
<?php if($s_user_id==$comment_user_id) { ?>	<li><a href="#" role='button' onclick="delete_comment(<?php echo $discussion_comment_id; ?>)">
<i class="icon-trash"></i> Delete</a></li>
<?php } ?>
<?php if($s_user_id !=$comment_user_id) { ?>	<li><a href="#"    role='button' onclick="offensive_delete(<?php echo $discussion_comment_id; ?>,<?php echo $s_user_id; ?>)"><i class="icon-ban-circle"> </i> offensive</a></li> <?php } ?>
				</ul>
</div>
<?php } ?>
<!------------------------------------------------------->

<!--<a href="#" role='button' class="btn mini red pull-right showme" onclick="delete_comment(<?php echo $discussion_comment_id; ?>)"><i class="icon-trash"></i> </a>-->


<span style="font-size:14px;color:<?php echo $color; ?>"><?php echo $user_name; ?>&nbsp;&nbsp;<?php echo $flat_info_c; ?></span>
<span style="color:#ADABAB;font-size:12px;" class="pull-right"><?php echo $date; ?>&nbsp;&nbsp;<?php echo $time; ?> &nbsp; </span><br/>
<span style="color:#000;font-size:14px;"><?php echo $comment; ?></span>
</td>
</tr>
</table>
</div>
<?php } ?>