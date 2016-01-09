<?php
foreach($result_discussion as $data)
{

$discussion_post_id=$data['discussion_post']['discussion_post_id'];
$topic=$data['discussion_post']['topic'];
$description=$data['discussion_post']['description'];
$date=$data['discussion_post']['date'];
$time=$data['discussion_post']['time'];
}


?>
<br>
<div id="show_data"></div>
<div style="background-color:#F3F3F3; border:solid 2px #fcb322; padding:10px; width:90%; margin:auto;">
<div align="center" style="background-color:#CCC;"><h3><b><?php echo $topic; ?></b></h3></div>
<div align="right"><span ><?php echo $date; ?>&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $time; ?></span></div>
<br>
<div align="justify"><p style='font-size:14px;'><?php echo $description; ?></p></div>
<br>
<br>
<a href='#' class='btn green app' role='button' ap_id='<?php echo $discussion_post_id ; ?>'> Approved </a>

<a href='#' class='btn red rej' role='button' ap_id='<?php echo $discussion_post_id ; ?>'> Reject </a>

</div>
<script>
$(document).ready(function(){
$(".app").live("click",function(){
var dc_id =$(this).attr("ap_id");
$('#show_data').html('<div id="pp"><div class="modal-backdrop fade in"></div><div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true"><div class="modal-body" style="font-size:14px;"> Discussion forums are Published. </div><div class="modal-footer"><a href="discussion_forum_app_ajax?con='+dc_id+'" class="btn blue" id="yes">Ok</a></div></div></div>');

});
});

$(document).ready(function(){
$(".rej").live("click",function(){
var dc_id =$(this).attr("ap_id");

$('#show_data').html('<div id="pp"><div class="modal-backdrop fade in"></div><div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true"><div class="modal-body" style="font-size:14px;"><i class="icon-warning-sign" style="color:#d84a38;"></i> Are you sure you want to reject discussion forum ? </div><div class="modal-footer"><a href="discussion_forum_app_reject?con='+dc_id+'" class="btn blue" id="yes">Yes</a><a href="#"  role="button" id="can" class="btn">No</a></div></div></div>');
$("#can").live("click",function(){
$('#pp').hide();
});
});
});
</script>