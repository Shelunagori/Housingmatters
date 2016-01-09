<?php 

				foreach($result_resource as $collection) 
				{
					$title=$collection['resource']["resource_title"];
					$name=$collection['resource']["resource_attachment"]; 
					$category_id=(int)$collection['resource']['resource_category'];
					$v_id = (int)@$collection['resource']['r_visible_id'];
					$wing_notice_id = (int)@$collection['resource']['r_sub_visible_id'];
$category = $this->requestAction(array('controller' => 'hms', 'action' => 'resource_category_name_edit'),array('pass'=>array($category_id)));
			
					foreach($category as $collection1) 
					{
					 $category_id=(int)$collection1['resource_category']['resource_cat_id'];
					 $resource_cat_name=$collection1['resource_category']['resource_cat_name'];
					}
				
				}

?>



<div class="row-fluid">
					<div style="width:70%; margin-left:15%;">
                        <div class="row-fluid"  >
              			 <div class="span12">
                  <!-- BEGIN VALIDATION STATES-->
                 		 <div class="portlet box green">
                     <div class="portlet-title">
                        <h4><i class="icon-reorder"></i> Resources Add</h4>
                        
                     </div>
                     <div class="portlet-body form">
                        <h3 class="block"></h3>
                        <!-- BEGIN FORM-->
                        <form  id="contact-form" class="form-horizontal" method="post" enctype="multipart/form-data">
                         <fieldset>
                           <div class="control-group ">
                              <div class="controls">
                               <label class="" style="font-size:14px;" >Title <span style="color:red;">*</span> <span style="font-size:12px; color:#999;">(Maximum 30 characters.)</span></label>
                                 <input type="text" class="span8 m-wrap" id="inputWarning" name="title" value="<?php echo $title ?> ">
                              </div>
                           </div>
                          
                           <div class="control-group ">
                              <div class="controls">
                               <label class="" style="font-size:14px;">Category <span style="color:red;">*</span>  </label>
                                 <select name="sel" class="span8 m-wrap chosen"  >
                            <option value="">--Please select any category--*</option>
                                                 
                            <?php
                    
				foreach ($result_cat as $collection) 
				{
					 $resource_cat_id=$collection['resource_category']["resource_cat_id"];
					 $resource_cat_name=$collection['resource_category']["resource_cat_name"];
				
				?>
                           <option <?php if($resource_cat_id==$category_id) { ?>selected="selected" <?php } ?> value="<?php echo $resource_cat_id ?> "><?php echo $resource_cat_name ?></option>
                            <?php } ?>
                            </select> 
                                                         
                              </div>
                           </div>
                           <div class="control-group ">
                              <div class="controls">
                              <label class="" style="font-size:14px;">Attachment  <span style="font-size:12px; color:#999; margin:2%">(Limit 2MB)</span></label>
                                 <div class="fileupload fileupload-new" data-provides="fileupload"><input type="hidden">
                                    <div class="input-append">
                                       <div class="uneditable-input">
                                          <i class="icon-file fileupload-exists"></i> 
                                          <span class="fileupload-preview"><?php if(empty($name)) { ?>Select <?php }  echo $name; ?></span>
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
                           
                   
                                  
                                  
                           
                           
                           <div class="form-actions">
                              <input type="submit" class="btn green" value="Publish" name="sub">
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
$(document).ready(function(){
		$('#contact-form').validate({
	    rules: {
	      title: {
	       
	        required: true,
			maxlength:30
	      },
		 
		   sel: {
	       
	        required: true
	      },
		  
	    },
		messages: {
	                title: {
	                    maxlength: "Please Maximum 30 characters."
	                }
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