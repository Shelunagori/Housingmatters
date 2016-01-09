<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>
<script>
$(document).ready(function() {
$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>



<!--<div style="background-color:#EFEFEF; border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6; padding:10px; box-shadow:5px; font-size:16px; color:#006;">
Master Parking Managment System
</div>-->
<br>
<div class="container-fluid" >
				<!-- BEGIN PAGE HEADER-->
				<div class="row-fluid">
					
				</div>
                     
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid" >
					<div>
                        <div class="row-fluid"  >
              			 <div class="span6" style="width: 80%; margin-left: auto;">
                  <!-- BEGIN VALIDATION STATES-->
				  
                 		 <div class="portlet box blue " style="width: 80%; margin-left: auto;">
                     <div class="portlet-title" style="background-color: #7490BE;"  >
                        <h4>Master Parking Managment System </h4>
                     </div>
                     <div class="portlet-body form " >
                        <h3 class="block"></h3>
                        <!-- BEGIN FORM-->
                        <form  id="contact-form"  method="post" name="form" enctype="multipart/form-data" >
                         <fieldset>
						 
						<div class="control-group ">
                              <div class="controls">
                               <label class="" style="font-size:14px;"> Select Parking area </label>
							  <select name="sel_parking" class="span6 chosen"  >
							   <option> Select Parking area  </option>
							  <?php 
							  foreach($result_parking as $data)
							  {
								$parking_area_cat=$data['parking_area']['parking_area_cat'];
							    $parking_area_id=$data['parking_area']['parking_area_id'];
							  ?>
							 <option value="<?php echo $parking_area_id ; ?>"><?php echo $parking_area_cat ; ?> </option>
							  <?php } ?>
							  </select>
                              </div>
                           </div>
						  
                           <div class="control-group ">
                              <div class="controls">
                               <label class="" style="font-size:14px;">Number of two wheeler slot  </label>
							   
							  <input type="text" name="two_slot" class="span6" value="<?php echo @$num2 ; ?>" >
                              </div>
                           </div>
						   
						   <div class="control-group ">
                              <div class="controls">
                               <label class="" style="font-size:14px;"> Range start From </label>
							   
							  <input type="text" name="two_start" class="span6" value="<?php echo @$start2 ; ?>" >
                              </div>
                           </div>
						   
						   <div class="control-group ">
                              <div class="controls">
                               <label class="" style="font-size:14px;">Number of four wheeler slot</label>
							   
							  <input type="text" name="four_slot" class="span6" value="<?php echo @$num4 ; ?>" >
                              </div>
                           </div>
						   
						   <div class="control-group ">
                              <div class="controls">
                               <label class="" style="font-size:14px;"> Range start From </label>
							   <input type="text" name="four_start" class="span6" value="<?php echo @$start4 ; ?>" >
                              </div>
                           </div>
						   
                          <div class=""  >
						<input type="submit" style="background-color: #7490BE;"  class="btn blue" value="Submit" name="sub"> 
						
						</div>
                           </fieldset>
                        </form>
                        <!-- END FORM-->
                        <!-- END FORM-->
                     </div>
                  </div>
                  <!-- END VALIDATION STATES-->
               </div>
            </div>
            </div>
	</div>
				<!-- END PAGE CONTENT-->
			</div>