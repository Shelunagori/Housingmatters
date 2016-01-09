<?php 
foreach ($result_sp as $collection) 
                {
                $name=$collection['service_provider']['sp_name'];
                $attachment=$collection['service_provider']['sp_attachment'];
                $mobile=$collection['service_provider']['sp_mobile'];
                $Contract_start=$collection['service_provider']['sp_cont_start'];
                $Contract_end=$collection['service_provider']['sp_cont_end'];
                $contrect_person=$collection['service_provider']['sp_person'];
                $email=$collection['service_provider']['sp_email'];
                $Contract_type=$collection['service_provider']['sp_contract_type'];
                }
?>


<div class="container-fluid">
				<!-- BEGIN PAGE HEADER-->
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN PAGE TITLE & BREADCRUMB-->		
						
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid">
					<div style="width:70%; margin-left:15%;">
                        <div class="row-fluid"  >
              			 <div class="span12">
                  <!-- BEGIN VALIDATION STATES-->
                 		 <div class="portlet box green">
                     <div class="portlet-title">
                        <h4><i class="icon-reorder"></i> Vendor Registration Form</h4>
                        
                     </div>
                     <div class="portlet-body form">
                        <h3 class="block"></h3>
                        <!-- BEGIN FORM-->
                        <form  id="contact-form" class="form-horizontal" method="post" enctype="multipart/form-data">
                         <fieldset>
                           <div class="control-group ">
                              <div class="controls">
                               <label class="" style="font-size:14px;" >Vendor Name</label>
                                 <input type="text" class="span8 m-wrap"  name="name" value="<?php echo $name ;?>" >
                              </div>
                           </div>
                           
                            <div class="control-group ">
                              <div class="controls">
                               <label class="" style="font-size:14px;" >Name of Person </label>
                                <input type="text" class="span8 m-wrap"  name="person" value="<?php echo $contrect_person ; ?>">
                              </div>
                           </div>
                          
                           
                            <div class="control-group ">
                              <div class="controls">
                               <label class="" style="font-size:14px;" >Mobile</label>
                                 <input type="text" class="span8 m-wrap" name="mobile" value="<?php echo $mobile ;?>">
                              </div>
                           </div>
                           
                          
                           
                            <div class="control-group ">
                              <div class="controls">
                               <label class="" style="font-size:14px;" >Email</label>
                                 <input type="text" class="span8 m-wrap" name="email" value="<?php echo $email ; ?>">
                              </div>
                           </div>
                           
                           
                           <div class="control-group ">
                              <div class="controls">
                              <label class="" style="font-size:14px;">Attachment</label>
                                 <div class="fileupload fileupload-new" data-provides="fileupload"><input type="hidden" >
                                    <div class="input-append">
                                       <div class="uneditable-input">
                                                                        

                                          <i class="icon-file fileupload-exists"></i> 
                                          <span class="fileupload-preview"> <?php echo $attachment ; ?></span>
                                         
                                       </div>
                                       <span class="btn btn-file">
                                       <span class="fileupload-new">Select file</span>
                                       <span class="fileupload-exists">Change</span>
                                       <input type="file"  class="span8 m-wrap" name="file" multiple >
                                       </span>
                                       <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                          
                          
                          <div class="control-group">
                           <div class="controls">
                              <label class="" style="font-size:14px;" >Contract Type</label>
                             
                                 <label class="radio">
                                 <div class="radio" ><span><input type="radio" id="amc"  name="amc" value="1"  <?php if($Contract_type == "AMC") { ?> checked= "checked" <?php } ?> ></span></div>
                                 AMC
                                 </label>
                                 <label class="radio">
                                 <div class="radio" id="uniform-undefined"><span><input type="radio" id="adhoc" name="amc"  value="2"  <?php if($Contract_type == "Adhoc") { ?> checked= "checked" <?php } ?> ></span></div>
                                 Adhoc
                                 </label>  
                               
                              </div>
                           </div >
                           <div >
                           
                           <div class="control-group text_box" style="display:none;">
                              <div class="controls">
                               <label class="" style="font-size:14px;" >Contract start Period</label>
                                 <input type="text" class="span8 m-wrap date-picker" data-date-format="dd-mm-yyyy"  name="cont_start" value="<?php echo $Contract_start; ?>">
                              </div>
                           </div>
                           
                            <div class="control-group text_box " style="display:none;">
                              <div class="controls">
                               <label class="" style="font-size:14px;" >Contract end Period</label>
                                 <input type="text" class="span8 m-wrap date-picker" data-date-format="dd-mm-yyyy"  name="cont_end"  value="<?php echo $Contract_end ;?>">
                              </div>
                           </div>
                           
                           </div>
                       
                           <div class="form-actions">
                              <input type="submit" class="btn green" value="Update" name="sub">
                           </div>
                           </fieldset>
                        </form>
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
 $("#amc").live('click',function(){
   $('.text_box').show();
});
$("#adhoc").live('click',function(){
   $('.text_box').hide();
});
});
 </script>