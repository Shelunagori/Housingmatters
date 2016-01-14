<div style="background-color:#EFEFEF; border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6; padding:10px; box-shadow:5px; font-size:16px; color:#006;">
              View
</div>

<div id="div_com"> </div>
<div class="tab-content">

<div class="tab-pane active" id="tab_1_2">


<div class="portlet box ">

<div class="portlet-body">
<table class="table table-striped table-bordered" id="sample_2">
<thead>
<tr>
<th>Sr No.</th>
<th>Date</th>
<th width="40%">Comment</th>
<th>Mark User Name</th>
<th>Action</th>
</tr>
</thead>
<tbody>

<?php
$i=0;
foreach($result_discussion_comment as $data)
{
$i++;

 $date=$data['discussion_comment']['date'];
 $discussion_comment_id=$data['discussion_comment']['discussion_comment_id'];
 $comment=$data['discussion_comment']['comment'];
 $offensive_user=$data['discussion_comment']['offensive_user'];

 ?>
<tr class="odd gradeX" >
<td><?php echo $i; ?></td>
<td><?php echo $date ; ?> </td>
<td><?php echo $comment ; ?></td>
<td><div class="btn-group">
                            <a class="btn mini" href="#" role='button' data-toggle="dropdown">
                            View user name
                            </a>
                <ul class="dropdown-menu">
				<?php  foreach($offensive_user as $da) { 
				
$result_offensive = $this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'),array('pass'=>array($da)));
				
				foreach($result_offensive as $data)
				{
				$offensive_user_name=$data['user']['user_name'];
				
				?> 

<li><a data-toggle="modal"> <i class="icon-user"></i> <?php echo $offensive_user_name ; ?></a></li> 

				<?php } }   ?>
 
                        						
                						
                                </ul>
                </div>
		
</td>
<td><a href="discussion_offensive_delete_ajax1?con=<?php echo $discussion_comment_id ?> " class="btn mini green" >Delete</a> </td>

</tr>
<?php } ?>
</tbody>
</table>
</div>
</div>
</div>
</div>
