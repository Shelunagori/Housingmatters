<!--<div style="background-color:#EFEFEF; border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6; padding:10px; box-shadow:5px; font-size:16px; color:#006;">
Parking Managment System
</div>-->

<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>
<script>
$(document).ready(function() {
$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>




<br/>
<div class="container-fluid" >
				<!-- BEGIN PAGE HEADER-->
				<div class="row-fluid">
					
				</div>
                     
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid" >
					<div>
                        <div class="row-fluid"  >
              			 <div class="span8" style="width:80%;">
                  <!-- BEGIN VALIDATION STATES-->
				  
                 		 <div class="portlet box blue " style="  width: 80%;margin-left: auto;">
                     <div class="portlet-title" style="background-color: #7490BE;"  >
                        <h4>Parking Managment System </h4>
                     </div>
                     <div class="portlet-body form " >
                        <h3 class="block"></h3>
                        <!-- BEGIN FORM-->
                        <form  id="contact-form"  method="post" name="form" enctype="multipart/form-data" >
                         <fieldset>
                           <div class="control-group ">
                              <div class="controls">
                               <label class="" style="font-size:14px;"> Select user </label>
							  <select name="sel_user" class="span6 chosen"  >
							   <option> Select User  </option>
							  <?php 
							  foreach($result_user as $data)
							  {
							  $user_name=$data['user']['user_name'];
							  $user_id=$data['user']['user_id'];
							  ?>
							 <option value="<?php echo $user_id ; ?>"><?php echo $user_name ; ?> </option>
							  <?php } ?>
							  </select>
                              </div>
                           </div>
						  
						   
						   <div class="control-group" >
                              <label class="control-label">Type</label>
                              <div class="controls">
                                 <label class="radio">
                                 <div class="radio" id="uniform-undefined"><span class=""><input type="radio" name="wheeler" value="2" style="opacity: 0;" id="two_id"></span></div>
                                Two wheeler 
                                 </label>
                                 <label class="radio">
                                 <div class="radio" id="uniform-undefined"><span class="checked"><input type="radio" name="wheeler" value="4" style="opacity: 0;" id="four_id"> </span></div>
                                Four wheeler 
                                 </label>  
                                
                              </div>
                           </div>
						   
						   
						    <div class="control-group" id="show_id">
                              <div class="controls">
                               <label class="" style="font-size:14px;"> Select Slot </label>
							    <select name="sel_slot[]" class="span6 chosen" multiple="multiple" >
							   <option >   Select Slot Number  </option>
						  <?php 
							  foreach($result_parking as $data)
							  {
							  $slot_no=$data['parking']['slot_no'];
							  $parking_id=$data['parking']['parking_id'];
							  ?>
							 <option value="<?php echo $parking_id ; ?>"><?php echo $slot_no ; ?> </option>
							  <?php } ?>
							  </select>
							 </div>
						   </div>
						    								   
						    <div class="control-group" id="show_two" style="display:none;">
                              <div class="controls">
                               <label class="" style="font-size:14px;"> Select Slot </label>
							    <select name="sel_slot2" class=" span6 chosen" style="width:334px;" id="sel_value1" >
							   <option >   Select Slot Number  </option>
						  <?php 
							  foreach($result_parking2 as $data)
							  {
							  $slot_no=$data['parking']['slot_no'];
							  $parking_id=$data['parking']['parking_id'];
							  ?>
							 <option value="<?php echo $parking_id ; ?>"><?php echo $slot_no ; ?> </option>
							  <?php } ?>
							  </select>
							 </div>
						   </div>
						   
						    								   
						    <div class="control-group" id="show_four" style="display:none;">
                              <div class="controls">
                               <label class="" style="font-size:14px;"> Select Slot </label>
							    <select name="sel_slot4" class="span6 chosen"  style="width:334px;" id="sel_value">
							   <option >   Select Slot Number  </option>
						  <?php 
							  foreach($result_parking4 as $data)
							  {
							  $slot_no=$data['parking']['slot_no'];
							  $parking_id=$data['parking']['parking_id'];
							  ?>
							 <option value="<?php echo $parking_id ; ?>"><?php echo $slot_no ; ?> </option>
							  <?php } ?>
							  </select>
							 </div>
						   </div>
						   <div class="control-group ">
                              <div class="controls">
                               <label class="" style="font-size:14px;"> Vehicle Number </label>
							   <input type="text" name="vehicle" class="span6"  >
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

<script>
$(document).ready(function() {
$("#two_id").click(function(){
  $("#show_id").hide();
  $("#show_four").hide();
  
    $("#show_two").show();
	
});

$("#four_id").click(function(){
 $("#show_id").hide();
  $("#show_two").hide();
  
  $("#show_four").show();
 
});
});
</script>		
			
<script>

</script>	