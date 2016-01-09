<?php 

foreach ($result_contact_handbook as $collection){  
				$c_h_id=$collection['contact_handbook']["c_h_id"];
				$mobile=$collection['contact_handbook']["c_h_mobile"];
				$user_id=(int)$collection['contact_handbook']['user_id'];
				$name=$collection['contact_handbook']["c_h_name"];
				$email=$collection['contact_handbook']["c_h_email"];
				$web=$collection['contact_handbook']["c_h_web"];
				$service=$collection['contact_handbook']["c_h_service"];

			}
@$result_user=$this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'),array('pass'=>array($user_id)));			  
		foreach($result_user as $data)
		{
			 $user_name=$data['user']['user_name'];
			 $wing=(int)$data['user']['wing'];
			 $flat=(int)$data['user']['flat'];

		}	
$wing_flat=$this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'),array('pass'=>array($wing,$flat)));			
?>


<div style="float:right; " id="hide_dive">

<div class="container-fluid">
				<!-- BEGIN PAGE HEADER-->
				<div class="row-fluid">
					
				</div>
                
       
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid" >
					<div>
                        <div class="row-fluid"  >
              			 <div class="span12">
                  <!-- BEGIN VALIDATION STATES-->
				  
                 		 <div class="portlet box blue " style="">
                     <div class="portlet-title" style="background-color: #7490BE;" >
                        <h4><i class="icon-th-list" style='font-size:16px;'></i>Contact Handbook Registration</h4>
                        
                     </div>
                     <div class="portlet-body form " >
                        <h3 class="block"></h3>
                        <!-- BEGIN FORM-->
                        <form  id="contact-form1"  method="post" name="form" enctype="multipart/form-data" >
                         <fieldset>
						 
						  
						 
                           <div class="control-group ">
                              <div class="controls">
                               <label class="" style="font-size:14px;" >Name of service provider/vendor </label>
                                 <input type="text" class="span12 m-wrap"  name="name" id="na" value="<?php echo $name;?>">
                              </div>
                           </div>
                         
						 <div class="control-group ">
                              <div class="controls">
                               <label class="" style="font-size:14px;" >Services offered </label>
                              
								 
								  <select data-placeholder="Select services"  name="service[]"  class="span12 m-wrap chosen" multiple="multiple" >
									 <?php
									foreach($contact_handbook_service as $data){
										$contact_handbook_service_id=$data['contact_handbook_service']['contact_handbook_service_id'];
										$contact_handbook_service_name=$data['contact_handbook_service']['contact_handbook_service_name'];
										?> 
									<option value="<?php echo $contact_handbook_service_id; ?>"<?php if(@in_array($contact_handbook_service_id,$service)){?> selected <?php } ?>><?php echo $contact_handbook_service_name; ?>  </option>
									 
									 <?php } ?>
									 </select>
								 </div>
                           </div> 
								 
                                 <input type="hidden" class="span12 m-wrap"  name="text_id" id="hid_id" value="<?php echo $c_h_id; ?>">
                           
                           
                            <div class="control-group ">
                              <div class="controls">
                               <label class="" style="font-size:14px;" >Mobile</label>
                                 <input type="text" class="span12 m-wrap" name="mobile" maxlength="10" id="mob" value="<?php echo $mobile;?>">
                              </div>
                           </div>
						   
						     <div class="control-group ">
                              <div class="controls">
                               <label class="" style="font-size:14px;" >Email</label>
                                 <input type="text" class="span12 m-wrap" name="email" id="email_tex" value="<?php echo $email;?>">
                              </div>
                           </div>
						   
						    <div class="control-group ">
                              <div class="controls">
                               <label class="" style="font-size:14px;" >Website</label>
                                 <input type="text" class="span12 m-wrap" name="web" id="web_tex" value="<?php echo $web;?>">
                              </div>
                           </div>
						   
						   
                          <br/>
                                       <div class=""  >
                             <input type="submit" style="background-color: #7490BE;"  class="btn blue" value="Submit" name="sub"> 
							 <a  class=" btn cancel_form" >Cancel </a> </div>
                           
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
			

</div>

<script>
$(document).ready(function() {
$('#contact-form1').validate({
			
	    rules: {
	      name: {
	       
	        required: true
	      },
		  mobile: {
	       
	        //required: true,
			number:true,
			minlength:10,
			maxlength:10
	      },
		   email: {
	       
	        //required: true,
			email:true
	      },
		    address: {
	        required: true
	      },
		 
	    },
		
			highlight: function(element) {
				$(element).closest('.control-group').removeClass('success').addClass('error');
			},
			success: function(element) {
				element
				.text('OK!').addClass('valid')
				.closest('.control-group').removeClass('error').addClass('success');
			}
	  });
});	
</script>

