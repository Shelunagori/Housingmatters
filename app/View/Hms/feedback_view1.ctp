<div style="border:solid 2px #269abc; width:80%; margin-left:10%;overflow: auto;">
<div style="border-bottom:solid 2px #269abc; color:white; background-color: #39b3d7; padding:4px; font-size:20px; " align="center">Feedback View </div>
<?php
$i=0;
foreach ($result_feedback as $collection) 
{ 
$i++;
$feedback_sub=$collection['feedback']['feedback_subject'];
$feedback_date=$collection['feedback']['feedback_date'];
$feedback_time=$collection['feedback']['feedback_time'];
$feedback_category=(int)$collection['feedback']['feedback_category'];
$da_user_id=(int)$collection['feedback']['user_id'];
$feedback_id=(int)$collection['feedback']['feedback_id'];
$da_society_id=(int)$collection['feedback']['society_id'];
$feedback_des=@$collection['feedback']['feedback_des'];
$feedback_cat_name= $this->requestAction(array('controller' => 'hms', 'action' => 'feedback_category_name'),array('pass'=>array($feedback_category)));
$result_user= $this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'),array('pass'=>array($da_user_id)));
$result_society= $this->requestAction(array('controller' => 'hms', 'action' => 'society_name'),array('pass'=>array($da_society_id)));
foreach ($result_society as $collection) 
{ 
$society_name=$collection['society']["society_name"];
}
foreach($result_user as $collection) 
{ 
$user_name=$collection['user']["user_name"];
$wing=$collection['user']["wing"];
$flat=$collection['user']["flat"];
$email=$collection['user']["email"];
$mobile=$collection['user']["mobile"];
}
$wing_flat= $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'),array('pass'=>array($wing,$flat)));

}
?>
<div id="delete_topic_result"></div>


<div style="padding:10px;overflow:auto;">

<div class="pull-right">
<span style="font-size:14px;"><?php echo $feedback_date ; ?> &nbsp;&nbsp;<?php echo $feedback_time ; ?></span>
</div><br>
<div class="pull-right">
<span style="font-size:14px;"> Society Name:- &nbsp;&nbsp;<?php echo $society_name ; ?>  </span>

</div>

<form method="post" >
<span style="font-size:16px;"><b> From:- </b> <?php  echo $user_name; ?> &nbsp;(<?php echo $wing_flat ; ?>)</span><br><br>
<span style="font-size:16px;"><b> Email:- </b>  <?php  echo $email; ?></span><br><br>
<span style="font-size:16px;"><b> subject :- </b> <?php  echo $feedback_sub; ?></span><br><br>
<span style="font-size:16px;"><p> <b> Message :- </b> <?php echo $feedback_des ; ?> </p></span><br><br>
<span style="font-size:16px;"><textarea rows="5" cols="10" style="width:60%; resize:none;" placeholder="Reply" name="feedback_reply" ></textarea> </span><br>
<button class="btn green" type="submit">Reply</button>   <button  type="button" idd="<?php echo $feedback_id ; ?>" class="btn red del"><i class="icon-trash"></i> Delete</button>
<hr>
</form>

</div>
</div>


<script>
$( document ).ready(function() {

$(".del").live("click",function() {
var dt=$(this).attr("idd");
$('#delete_topic_result').html('<div id="pp"><div class="modal-backdrop fade in"></div><div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true"><div class="modal-body" style="font-size:14px;"><i class="icon-warning-sign" style="color:#d84a38;"></i> <b>Are you sure you want to delete this feedback ?</b> </div><div class="modal-footer"><a href="feedback_delete?con='+dt+'" class="btn blue" id="yes">Yes</a><a href="#"  role="button" id="can" class="btn">No</a></div></div></div>');

$("#can").live('click',function(){
   $('#pp').hide();
});

});
});
</script>