<div style="background-color:#EFEFEF; border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6; padding:10px; box-shadow:5px; font-size:16px; color:#006;">
Feedback View
</div>



<div class="tab-content">

<div class="tab-pane active" id="tab_1_2">


<div class="portlet box ">

<div class="portlet-body">
<table class="table table-striped table-bordered" id="sample_2">
<thead>
<tr>
<th>Sr No.</th>
<th>Date</th>
<th>Category</th>
<th>From</th>
<th>Society_name</th>
<th>Email</th>
<th>Mobile</th>
<th class="">Subject</th>

<th>Message</th>

</tr>
</thead>
<tbody>

<?php

////connection//////

$i=0;
foreach ($result_feedback as $collection) 
{ 
$i++;
$feedback_sub=$collection['feedback']['feedback_subject'];
$feedback_date=$collection['feedback']['feedback_date'];
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


?>
<tr class="odd gradeX" >
<td><?php echo $i; ?></td>
<td><?php echo $feedback_date; ?></td>
<td><?php echo $feedback_cat_name; ?></a></td>
<td><?php echo $user_name; ?> &nbsp;(<?php echo $wing_flat ; ?>)</td>
<td><?php echo $society_name; ?> </td>
<td><?php echo $email; ?> </td>
<td><?php echo $mobile; ?> </td>
<td><?php echo $feedback_sub; ?></td>

                                               <td><a href="feedback_view1?con=<?php echo $feedback_id ; ?>"  class="btn mini green" >View</a>
                                            <!--POP UP BOX-->
                                           <!--  <div id="ap<?php echo $i; ?>" class="modal hide " tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true" style="display: none; " align="center">
									<div class="modal-header">
										
										<h3 id="myModalLabel2" style="border-bottom:solid 1px #ccc; padding:10px; font-size:16px; text-align:justify;"><b>Message</b></h3>
									</div>
									<div class="modal-body">
										<div style="border-bottom:solid 1px #ccc; padding:10px; font-size:16px; text-align:justify;" ><?php echo $feedback_des ; ?></div>
                                        
									</div>
									<div class="modal-footer">
								
										 <button class="btn red " data-dismiss="modal" aria-hidden="true"><i class="icon-trash"></i></button>
										  <button class="btn blue" data-dismiss="modal" aria-hidden="true">Reply</button>
                                       <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-white"></i></button>  
									</div>
								</div> -->
                                   <!--END OF POP UP BOX-->          
                                             </td>
                                             
</tr>
<?php } ?>
</tbody>
</table>

</div>
</div>
</div>
</div>