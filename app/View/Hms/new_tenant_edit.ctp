

<?php
foreach ($result_tenant as $collection) 

			{
			 	$t_address=$collection['tenant']['t_address'];
				$name=$collection['tenant']['name'];
				$verification=$collection['tenant']['verification'];
				$t_start_date=$collection['tenant']['t_start_date'];
				$t_end_date=$collection['tenant']['t_end_date'];
				 $t_agreement=$collection['tenant']['t_agreement'];
				$t_police=$collection['tenant']['t_police'];
			} 
			
		
 
 ?>

<div class="portlet-body" style="padding:10px;";>
									<!--BEGIN TABS-->
									<div class="tabbable tabbable-custom">
										<ul class="nav nav-tabs">
											
										</ul>
										<div class="tab-content" style="min-height:500px;">
											<div class="tab-pane active" id="tab_1_1">
					
					
					
					<form  id="contact-form" class="form-horizontal" method="post" enctype="multipart/form-data" style='center'>
                         <fieldset>
                         
                         
                           
						
                        
						 
						 <div class="control-group ">
                            <div class="controls">
                               <label class="" style="font-size:14px;" >Name </label>
                                 <input type="text" class="span5 m-wrap" id="inputWarning" name="name_tenant" value="<?php echo $name ; ?>" readonly>
                              </div>
                           </div>
						    
						
						 
                         <div class="control-group ">
                              <div class="controls">
                               <label class="" style="font-size:14px;" > Permanent address </label>
                                <textarea cols="" rows="5" name="address" class="span5 m-wrap" style="resize:none" ><?php echo $t_address ; ?></textarea>
                              </div>
                           </div>
                          
                           <div class="control-group ">
                            <div class="controls">
                               <label class="" style="font-size:14px;" >Tenancy start date </label>
                                 <input type="text" class="span5 m-wrap  date-picker"  data-date-format="dd-mm-yyyy" name="start_date"  value="<?php echo $t_start_date ; ?>">
                              </div>
                           </div>
                           <div class="control-group ">
                           <div class="controls">
                               <label class="" style="font-size:14px;" >Tenancy end date </label>
                                 <input type="text" class="span5 m-wrap  date-picker" data-date-format="dd-mm-yyyy"  name="end_date"  value="<?php echo $t_end_date ; ?>">
                              </div>
                           </div>
                         
                            <div class="control-group ">
                            <div class="controls">
                               <label class="" style="font-size:14px;" >Verification </label>
                                 <input type="text" class="span5 m-wrap" id="inputWarning" name="verification" value="<?php echo $verification ; ?>">
                              </div>
                           </div>
                           
                           <div class="control-group">
                              <div class="controls">
                                 <label class="">
                                <input type="checkbox" value="1" name="ten_agr" <?php if(@$t_agreement==1) { ?> checked="checked" <?php } ?>> Tenancy agreement 
                                 </label>
                                 <label class="">
                                <input type="checkbox" value="1" name="pol_ver" <?php if(@$t_police==1) { ?> checked="checked" <?php } ?> >Police verification
                                 </label>
                              </div>
                           </div>
                           
                           <div class="form-actions">
                              <input type="submit" class="btn green " value="Update" name="sub" </div>
                           
                           </fieldset>
                        </form>
					
					
					
					
											</div>
											
										</div>
									</div>
									<!--END TABS-->
</div>

