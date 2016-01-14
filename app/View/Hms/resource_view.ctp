<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));?>
<div class="portlet box light-grey">
    <div style="background-color:#EFEFEF; border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6; padding:10px; box-shadow:5px; font-size:16px; color:#006;">
            View  &nbsp; <span><i class=" icon-info-sign tooltips " data-placement="right" data-original-title="You could post frequently needed content like Society Rules & Regulations, Associations Policies, Standard Operating Procedures, Guidelines, News Letters etc. " ></i>
        </div>
						
							<div class="portlet-body">
								<table class="table table-striped table-bordered" id="sample_2">
									<thead>
										<tr >
											<th>Sr No.</th>
                                            <th>Title</th>
                                            <th>Category</th>
                                            <th>Uploaded on</th>
                                            <th>Uploaded By</th>
											<th>Recipients</th>
											<th class="hidden-phone">File Name</th>
                                          <?php if($role_id==3) {?> <th class="hidden-phone">Action</th> <?php } ?>
                         					</tr>
									</thead>
									<tbody>
                                    <?php 
									$i=0; $to='';
										foreach ($result_resource as $collection) 
 										{ 
											$i++;
											$title=$collection['resource']["resource_title"];
											$name=$collection['resource']["resource_attachment"];
											$ext = pathinfo($name, PATHINFO_EXTENSION);
											$category_id=(int)$collection['resource']['resource_category'];
											$date=$collection['resource']['resource_date'];
											$upload_id=$collection['resource']['user_id'];
											$id=$collection['resource']['resource_id'];
											 $visitor_notice_id=@(int)$collection['resource']['visible'];
											$wing_notice_id=@$collection['resource']['sub_visible'];
											$data='';
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
						$cursor = $this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'),array('pass'=>array($upload_id)));
						foreach ($cursor as $collection) 
						{
						$uploadby=$collection['user']['user_name'];
						}
						$category = $this->requestAction(array('controller' => 'hms', 'action' => 'resource_category_name'),array('pass'=>array($category_id)));
			

										?>
										<tr class="odd gradeX">
											<td><?php echo $i; ?></td>
                                            <td><?php echo $title; ?></td>
                                            <td><?php echo $category; ?></td>
                                            <td><?php echo $date; ?></td>
                                             <td><?php echo $uploadby; ?></td>
											 <td><?php echo @$to; ?></td>
											<td>
                                          <?php
										if(!empty($name))
										{
										if($ext=="jpg" ||$ext=="png"||$ext=="gif")
										{ ?>
                                        
                                         <a href="#portlet-configxx<?php echo $i; ?>" data-toggle="modal" class="config btn mini green tooltips" data-placement="bottom" data-original-title="<?php echo $name; ?>"><i class=" icon-download-alt"></i> </a> 
                                                                            
              
              <?php
										}
										else
										{
                                            ?>
            
              <a href="<?php echo $this->webroot ; ?>/resource_file/<?php echo $name; ?>" target="_blank" class="btn mini green tooltips"  data-placement="bottom" data-original-title="<?php echo $name; ?>"><i class=" icon-download-alt"></i></a>
              
                                           <?php
										} }
										?>
                       
                 <!-- View detail popup start -->
           <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->

			<div id="portlet-configxx<?php echo $i; ?>" class="popupcenter modal hide " >
				<div class="modal-header " >
					<!--<button data-dismiss="modal" class="close" type="button"></button>-->
					<h4><b><center></center></b></h4>
				</div>
				<div class="modal-body">
					
                   <img src="<?php echo $this->webroot ; ?>/resource_file/<?php echo $name; ?>" width="400px;" height="300px;">
                   
				</div>
               <div class="modal-footer"><button data-dismiss="modal"  class="btn purple" type="button">close</button></div> 
			</div>
            
<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
				 <!-- View detail popup end -->	
                                            
                                           
                     </td>                       
                                             
                        <?php if($role_id==3) {?>                      
                          <td>
                           
                <!---- action popup ----->
                
                <div class="btn-group">
                <a class="btn mini blue" href="#" data-toggle="dropdown">
                Action
                
                </a>
                <ul class="dropdown-menu">
                <li><a href="resource_edit?con=<?php echo $id ?>"  data-toggle="modal"><i class="icon-pencil"></i> Edit</a></li>
           
                <li><a href="#<?php echo $i; ?>"  data-toggle="modal"><i class="icon-trash"></i> Delete</a></li>
                </ul>
                </div>
                <!----- end action popup ------->
          
               
               </td>                   
                                             
                     <?php } ?>                        
                               
										</tr>
                                        
                                        <!--popup start -->
<div id="<?php echo $i; ?>" class="modal hide " tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true" style="display: none;">
									<div class="modal-header" >
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
										<h4 id="myModalLabel3"><b>Conformation </b></h4>
									</div>
									<div class="modal-body">
									<span style="color:red;"><i class="icon-warning-sign"></i></span>	<b style="font-size:16px; margin:1%; font-family:'Times New Roman', Times, serif;">Are you sure you want to delete the resource record ?</b>
									</div>
									<div class="modal-footer">
										
										
                                        <a href="resource_sm_delete?con=<?php echo $id; ?>" role="btn"  class="btn blue" >Yes</a>
                                        <button class="btn" data-dismiss="modal" aria-hidden="true">No</button>
									</div>
								</div>
		<!--popup end -->
                                        
                                        
										<?php  }  ?>
                                        
									</tbody>
								</table>
							</div>
						</div>