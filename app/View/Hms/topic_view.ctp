
<?php 
foreach($result_topic_view as $collection)
{
$topic=$collection["discussion_post"]["topic"];
$description=$collection["discussion_post"]["description"];
$file=$collection["discussion_post"]["file"];
$d_user_id=(int)$collection["discussion_post"]["user_id"];
$post_date=$collection["discussion_post"]["date"];
$post_time=$collection["discussion_post"]["time"];
$description=$collection["discussion_post"]["description"];
$discussion_post_id=(int)$collection["discussion_post"]["discussion_post_id"];
$visible=$collection["discussion_post"]["visible"];
$sub_visible=$collection["discussion_post"]["sub_visible"];
}

$visible_detail='';
if($visible==1 ) 
{
	$visible_show="All Users";
	$visible_detail="All Users";
}

if($visible==4 ) 
{
	$visible_show="All Owners";
	$visible_detail="All Owners";
}

if($visible==5) 
{
	$visible_show="All Tenant";
	$visible_detail="All Tenant";
}

if($visible==2) 
{ 
$visible_show="Role wise";
	foreach ($sub_visible as $role_id) 
	{
	$role_name[]=$this->requestAction(array('controller' => 'hms', 'action' => 'fetch_rolename_via_roleid'), array('pass' => array($role_id)));
	}
	$visible_detail=implode(" , ",$role_name);
}

if($visible==3) 
{ 
$visible_show="Wing wise"; 
	foreach ($sub_visible as $wing_id) 
	{
	$wing_name[]="wing-".$this->requestAction(array('controller' => 'hms', 'action' => 'fetch_wingname_via_wingid'), array('pass' => array($wing_id)));
	}
	$visible_detail=implode(" , ",$wing_name);
}

$result_user_info=$this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'), array('pass' => array($d_user_id)));
foreach($result_user_info as $collection2)
{
$user_name=$collection2["user"]["user_name"];
$profile_pic=$collection2["user"]["profile_pic"];
$wing=$collection2["user"]["wing"];
$flat=$collection2["user"]["flat"];

}

$flat_info=$this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'), array('pass' => array($wing,$flat)));

?>

<!---------------------------------------------->
<div style="margin-left:10%; width:80%;">
<div style="background-color:#269abc; text-align:center; color:white; font-size:18px; font-weight:bold; padding:5px;"><?php echo $topic; ?>
</div>
<!--<div class="pull-right">
<a href="discussion_pdf?con=<?php echo $t; ?>" class="btn red mini hide_at_print ">pdf</i></a>
<a class="btn blue mini hide_at_print" onclick="window.print()">print</a>
</div>-->
<!---------------------------------------------->


<!---------------------------------------------->
<div style="margin-top:2px;background-color: #fafafa;" >
<table>
<tr>
<td width="15%"><img src="<?php echo $this->webroot ; ?>/profile/<?php echo $profile_pic; ?>" style="height:50px; width:50px;"/></td>
<td width="85%" valign="top" style="padding-left:5px;">
<span style="font-size:16px;"><?php echo $user_name; ?>&nbsp;&nbsp;<?php echo $flat_info; ?></span>

<span style="font-size:16px;cursor: default;"><span class="tooltips" data-placement="bottom" data-original-title="This discussion is visible to :- <?php echo @$visible_detail; ?>"><?php //echo $visible_show; ?><i class=" icon-info-sign"></i></span></span>
<br/>
<span style="color:#ADABAB;"><?php echo $post_date; ?>&nbsp;&nbsp;<?php echo $post_time; ?></span>
</td>
</tr>
</table>
<div>
<!---------------------------------------------->


<!---------------------------------------------->
<div style="margin-top:2px;font-size:14px;color: #007091;" ><?php echo $description; ?></div>
<!---------------------------------------------->


<!---------------------------------------------->
<?php if(!empty($file)) { ?>
<div style="margin-top:2px;" >
<img src="<?php echo $this->webroot ; ?>/discussion_file/<?php echo $file; ?>" style="width:100%; height:160px;">
<div>


<?php } ?>
<!---------------------------------------------->



<!---------------------------------------------->
<div id="comments_container" >
<?php 
foreach($result_comment as $collection2)
{
$discussion_comment_id=$collection2["discussion_comment"]["discussion_comment_id"];
$comment=$collection2["discussion_comment"]["comment"];
@$offensive_user=$collection2["discussion_comment"]["offensive_user"];
$comment_user_id=$collection2["discussion_comment"]["user_id"];
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
<?php if(@in_array($s_user_id,$offensive_user))
{ ?> style="background-color: #FFE0DF;border-top: solid 2px #f1f3fa; " <?php } else { ?>  style="background-color: #fafafa;border-top: solid 2px #f1f3fa;" <?php } ?> id="comm<?php echo $discussion_comment_id; ?>" class="showhim">
<table width="100%">
<tr>
<td width="15%" valign="top" style="padding:10px;"><img src="<?php echo $this->webroot ; ?>/profile/<?php echo $profile_pic; ?>" style="height:50px; width:50px;"/></td>
<td width="85%" valign="top" style="padding-left:5px;">

<!---   Delete and offensive  code  -------->
<?php 

if(!@in_array($s_user_id,$offensive_user))
{ ?>
<div class="btn-group " style="float:right;">
				<button class="  dropdown-toggle" data-toggle="dropdown"> <i class="icon-angle-down"></i>
				</button>
				<ul class="dropdown-menu">
<?php if($s_user_id==$comment_user_id) { ?>	<li><a href="#" role="button" onclick="delete_comment(<?php echo $discussion_comment_id; ?>)">
<i class="icon-trash"></i> Delete</a></li>
<?php } ?>
<?php if($s_user_id !=$comment_user_id) {  ?>	<li><a href="#" role="button" onclick="offensive_delete(<?php echo $discussion_comment_id; ?>,<?php echo $s_user_id; ?>)" 
{><i class="icon-ban-circle"> </i> offensive</a></li> <?php } ?>
</ul>
</div>
<?php } ?>
<!------------------------------------------------------->
<span style="font-size:14px;color:<?php echo $color; ?>"><?php echo $user_name; ?>&nbsp;&nbsp;<?php echo $flat_info_c; ?></span>
<span style="color:#ADABAB;font-size:12px;" class="pull-right"><?php echo $date; ?>&nbsp;&nbsp;<?php echo $time; ?> &nbsp; </span><br/>
<span style="color:#000;font-size:14px;"><?php echo $comment; ?></span>
</td>
</tr>
</table>
</div>
<?php } ?>
</div>
<!---------------------------------------------->


<!---------------------------------------------->
<div class="chat-form hide_at_print">
	<textarea class="span12 m-wrap animated"  type="text" id="posttext" placeholder="Type a message here..." style="background-color:#FFF !important; resize:none;" ></textarea>
	<div align="right">
	<div class="pull-left" id="save_comment" style="color:#007091;font-size: 16px;"></div>
	<button type="button" id="post_comment" style="margin-top:-10px;" onclick="comment(<?php echo $discussion_post_id; ?>)" class="btn blue icn-only tooltips" data-placement="bottom" data-original-title="Tab + Enter for post comment">POST</button>
	</div>
</div>
<!---------------------------------------------->
<div>
</div>
<script>
$(document).ready(function() {
 jQuery('.tooltips').tooltip();
//$("#topic_detail").addClass('animated zoomIn');
$("#topic_detail").addClass('fadeleftsome');
});
</script>
<script>
$(document).ready(function() {
	jQuery(".fancybox-button").fancybox();
});
</script>