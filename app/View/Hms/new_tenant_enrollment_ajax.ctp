
<?php
foreach ($result_tenant as $collection) 
			{
			 	$t_address=$collection['tenant']['t_address'];
				$verification=$collection['tenant']['verification'];
				$t_start_date=$collection['tenant']['t_start_date'];
				$t_end_date=$collection['tenant']['t_end_date'];
				 $t_agreement=$collection['tenant']['t_agreement'];
				$t_police=$collection['tenant']['t_police'];
			} 
			
			
			foreach ($result_user as $collection) 
			{
				$user_name=$collection['user']['user_name'];
				$wing=(int)$collection['user']['wing'];
				$flat=(int)$collection['user']['flat'];
			}
 
 ?>
  <!--<div class="control-group ">
                            <div class="controls">
                               <label class="" style="font-size:14px;" >Name</label>
                                 <input type="text" class="span5 m-wrap" id="inputWarning" name="name_tenant" value="<?php echo $user_name ; ?>">
                              </div>
                           </div>
 <div class="control-group" >
						<div class="controls">
						<select id="wi_flat" onChange="wing_flat()" class=" span5 m-wrap" name="wing"  data-placeholder="Choose a Category"   tabindex="1">
						<option value="">--Wing(Block)--</option>
						<?php

						foreach ($result_wing as $db) 
						{
						$c_wing_id=(int)$db['wing']["wing_id"];
						$c_wing_name=$db['wing']["wing_name"];
						?>
						<option value="<?php echo $c_wing_id; ?>" <?php if($c_wing_id==$wing) { ?> selected="selected" <?php } ?>><?php echo $c_wing_name; ?></option>
						<?php } ?>
						</select>
						</div>
						</div>
						<div class="control-group" id="echo_flat">
						<div class="controls">
						<select class=" span5 m-wrap" name="flat"  data-placeholder="Choose a Category"   tabindex="1">
						<option value="" style="">--Flat--
						     <?php
$result3 = $this->requestAction(array('controller' => 'hms', 'action' => 'flat'),array('pass'=>array($wing)));				  
                                           
                                                   foreach ($result3 as $collection) 
				                                      {
				                                        $flat_id_edit = (int)$collection['flat']['flat_id'];
				                                      $flat_name_edit = $collection['flat']['flat_name'];	
				                                  ?>
				                                  <option value="<?php echo $flat_id_edit; ?>" <?php if($flat_id_edit == $flat) { ?> selected="selected" <?php } ?> ><?php  echo $flat_name_edit; ?></option>				
					                              <?php }	?>
						
						
						
						</option>
						</select>
						</div>
						</div> -->
 
 <div class="control-group ">
                              <div class="controls">
                               <label class="" style="font-size:14px;" > Permanent address </label>
                                <textarea cols="" rows="5" name="address" class="span5 m-wrap" style="resize:none"  ><?php echo @$t_address; ?></textarea>
                              </div>
                           </div>
                           <div class="control-group ">
                            <div class="controls">
                               <label class="" style="font-size:14px;" >Tenancy start date </label>
                                 <input type="text" class="span5 m-wrap  date-picker"  data-date-format="dd-mm-yyyy" name="start_date"  onmouseover="datepicker();" value="<?php echo @$t_start_date; ?>">
                              </div>
                           </div>
                           <div class="control-group ">
                           <div class="controls">
                               <label class="" style="font-size:14px;" >Tenancy end date </label>
                                 <input type="text" class="span5 m-wrap  date-picker" data-date-format="dd-mm-yyyy"  name="end_date" onmouseover="datepicker();" value="<?php echo @$t_end_date; ?>"> </div>
                           </div>
                         
                            <div class="control-group ">
                            <div class="controls">
                               <label class="" style="font-size:14px;" >Verification </label>
                                 <input type="text" class="span5 m-wrap" id="inputWarning" name="verification" value="<?php echo @$verification; ?>">
                              </div>
  <div class="control-group">
                              <div class="control-group">
                              <div class="controls">
                                 <label class="">
                                <input type="checkbox" value="1" <?php if(@$t_agreement==1) { ?> checked="checked" <?php } ?> name="ten_agr" > Tenancy agreement 
                                 </label>
                                 <label class="">
                                <input type="checkbox" value="1" name="pol_ver" <?php if(@$t_police==1) { ?> checked="checked" <?php } ?> >Police verification
                                 </label>
                              </div>
                           </div>
                            