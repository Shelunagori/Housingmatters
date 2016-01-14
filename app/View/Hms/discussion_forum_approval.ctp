<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));?>
<script>
$(document).ready(function() {
$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>
<div class="portlet box light-grey">
    <div style="background-color:#EFEFEF; border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6; padding:10px; box-shadow:5px; font-size:16px; color:#006;">
            Discussion Forum for  Approval &nbsp; <span>
        </div>
<div id="delete_topic_result"></div>	
		<div class="portlet-body">
		<table class="table table-striped table-bordered" id="sample_2">
									<thead>
										<tr >
											<th>Sr No.</th>
                                            <th>Topic</th>
                                            <th>Posted on</th>
                                            <th>Recipients</th>
											<th class="hidden-phone">Status</th>
											<th>Description</th>

                         					</tr>
									</thead>
									<tbody>
                                    <?php 
									$i=0; $to='';
										foreach ($result_discussion as $data) 
 										{ 
											$i++;
											$discussion_post_id=$data['discussion_post']['discussion_post_id'];
											$user_id=$data['discussion_post']['user_id'];
											
											$topic=$data['discussion_post']['topic'];
											$description=$data['discussion_post']['description'];
											$date=$data['discussion_post']['date'];
											$visible=(int)$data['discussion_post']['visible'];
											
											if($visible==1)
											{
											 $to='All Users';
											}
											if($visible==4)
											{
											 $to='All Owners';
											}
											if($visible==5)
											{
											 $to='All Tenants';
											}
											if($visible==2)
											{
											  $to='Roll Wise';
											}
											if($visible==3)
											{
											  $to='Wing Wise';
											}
$result_user = $this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'),array('pass'=>array($user_id)));
foreach($result_user as $data)
{
$user_name=$data['user']['user_name'];
$wing=$data['user']['wing'];
$flat=$data['user']['flat'];
}
$wing_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'),array('pass'=>array($wing,$flat)));	
											
										?>
										<tr class="odd gradeX" >
											<td><?php echo $i; ?></td>
                                            <td><?php echo $topic; ?></td>
                                            <td><?php echo $user_name; ?> &nbsp <?php echo $wing_flat ; ?></td>
                                            <td><?php echo $to; ?></td>
										<td><span class='label label-info'>Pending for Approval </span></td>
                                       <td> <a href="discussion_forum_app_view?con=<?php echo $discussion_post_id; ?>" rel='tab' class="btn mini yellow " ><i class="icon-search"></i> View </a>
											 </td>                                          
									       
                                             
										</tr>
                                        
                                     
                                        
                                        
							<?php  }  ?>
                                        
									</tbody>
								</table>
								
							
								 </div>
								 
								 
								  </div>