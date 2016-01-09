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
            Notice for  Approval &nbsp; <span>
        </div>
<div id="delete_topic_result"></div>	
		<div class="portlet-body">
		<table class="table table-striped table-bordered" id="sample_2">
									<thead>
										<tr >
											<th>Sr No.</th>
                                            <th>Subject</th>
                                            <th>Posted on</th>
                                            <th>Valid Till</th>
                                            <th>Recipients</th>
											<th class="hidden-phone">Status</th>
											<th>View</th>

                         					</tr>
									</thead>
									<tbody>
                                    <?php 
									$i=0; $to='';
										foreach ($result_notice_publish as $data) 
 										{ 
											$i++;
											$notice_id=$data['notice']['notice_id'];
											$n_subject=$data['notice']['n_subject'];
											$n_date=$data['notice']['n_date'];
											$n_expire_date=$data['notice']['n_expire_date'];
											$n_expire_date= date('d-m-Y',$n_expire_date->sec);
											$visitor_notice_id=(int)$data['notice']['visible'];
											if($visitor_notice_id==1)
											{
											 $to='All Users';
											}
											if($visitor_notice_id==4)
											{
											 $to='All Owners';
											}
											if($visitor_notice_id==5)
											{
											 $to='All Tenants';
											}
											if($visitor_notice_id==2)
											{
											  $to='Roll Wise';
											}
											if($visitor_notice_id==3)
											{
											  $to='Wing Wise';
											}
											
											
										?>
										<tr class="odd gradeX" id='load_data<?php echo $notice_id ; ?>'>
											<td><?php echo $i; ?></td>
                                            <td><?php echo $n_subject; ?></td>
                                            <td><?php echo $n_date; ?></td>
                                            <td><?php echo $n_expire_date; ?></td>
                                             <td><?php echo $to; ?></td>
											 <td><span class='label label-info'>Pending for Approval </span></td>
											 <td><a href="notice_approval_view/<?php echo $notice_id; ?>" rel='tab' class="btn mini yellow " ><i class="icon-search"></i> View Notice</a></td>
											
									<!--<td><a href='#' class='btn mini green app' role='button' ap_id='<?php echo $notice_id ; ?>'>Approved</a> </td>-->                       
                                                                                 
									<!--<td><a href='#' class='btn mini red reject' role='button' ap_id='<?php echo $notice_id ; ?>' >Reject</a> </td> -->                 
                                             
										</tr>
                                        
                                     
                                        
                                        
							<?php  }  ?>
                                        
									</tbody>
								</table>
								
							
								 </div>
								 
								 
								  </div>
								  
								
<script>
$(document).ready(function() {
 $(".app").live('click',function(){
 var a_id=$(this).attr("ap_id");
 $("#load_data" + a_id).html("<td colspan='8'>loading......</td>").load('notice_approval_ajax?con=' + a_id);
 
  });
 
$(".reject").live('click',function(){
 var a_id=$(this).attr("ap_id");
alert(a_id);
 	
});
 });
 
 
 



</script>								  		