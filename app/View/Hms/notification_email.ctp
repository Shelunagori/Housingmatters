<div style="background-color:#EFEFEF; border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6; padding:10px; box-shadow:5px; font-size:16px; color:#006;">
              Notification User Setting
                 </div>
<br/>
<br/>
 <form method="post">
             <div id="show_edit">
                       <table class="table table-bordered " style="width:600px; margin-left:20%;">
									<thead>
										<tr>
											<th>#</th>
											<th>Module Name</th>
											<th>Email</th>
											<!--<th>Sms</th>-->
										</tr>
									</thead>
									<tbody>
                                    <?php
									$i=0;
									foreach ($result_email as $collection) 
           		                    {
									 $i++;		  
			    	                 $auto_id = (int)$collection['email']['auto_id'];
					                 $module_name = $collection['email']['module_name']; 
				 $c = $this->requestAction(array('controller' => 'hms', 'action' => 'notification_count_email'),array('pass'=>array($auto_id,$s_user_id)));
				 $r = $this->requestAction(array('controller' => 'hms', 'action' => 'notification_count_sms'),array('pass'=>array($auto_id,$s_user_id)));
									?>
                                   	<tr>
										<td><?php echo $i; ?></td>
											<td><?php echo $module_name; ?></td>
											<td><div class="basic-toggle-button"><input type="checkbox"  <?php if($c>0){ ?> checked="checked"  <?php } ?> name="check_email<?php echo $auto_id ;?>" value="1" class="toggle" >
											</div>
											
                                            </td>
											<!--<td><label><input type="checkbox"  <?php if($r>0){ ?> checked  <?php } ?>  name="check_sms<?php echo $auto_id ;?>" value="1"></label>
                                         </td>-->
									</tr>
                              <?php }  ?>
                                    
                                      <tr>
                                    <td colspan="4">
                                   
                                    
                                    <div class="input-append" style="margin-left:23%;">                      
										
										 <button class="btn blue" type="submit" name="sub" value="">Submit</button>
								    </div>
                                   </tbody>
								</table>
                         </div>   
                   </form>    
                
                