<div class="container-fluid">
				<!-- BEGIN PAGE HEADER-->
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN PAGE TITLE & BREADCRUMB-->		
						
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
                
                       
                <?php if($role_id==3) { ?>
  <div align="center">
                <a href="yellow_registration" class="btn red"> Registration</a>&nbsp;
                <a href="yellow_page" class="btn blue"> View Yellow Pages</a>
                 </div>
                <br>
<?php } ?>

				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid">
					<div>
                        <div class="row-fluid"  >
              			 <div class="span12">
                  <!-- BEGIN VALIDATION STATES-->
                 		 <div class="portlet box green " >
                     <div class="portlet-title" >
                        <h4><i class="icon-reorder"></i> Yellow Pages Registration</h4>
                        
                     </div>
                     <div class="portlet-body form " >
                        <h3 class="block"></h3>
                        <!-- BEGIN FORM-->
                        <form  id="contact-form"  method="post" name="form" enctype="multipart/form-data" onSubmit="return validate();">
                         <fieldset>
                           <div class="control-group ">
                              <div class="controls">
                               <label class="" style="font-size:14px;" >Name</label>
                                 <input type="text" class="span6 m-wrap"  name="name">
                              </div>
                           </div>
                           
                           
                            <div class="control-group ">
                              <div class="controls">
                               <label class="" style="font-size:14px;" >Mobile</label>
                                 <input type="text" class="span6 m-wrap" name="mobile">
                              </div>
                           </div>
                           
                          
                           
                            <div class="control-group ">
                              <div class="controls">
                               <label class="" style="font-size:14px;" >Email</label>
                                 <input type="text" class="span6 m-wrap" name="email">
                              </div>
                           </div>
                           
                            <div class="control-group ">
                              <div class="controls">
                               <label class="" style="font-size:14px;" >Address</label>
                                <textarea name="address" rows="5" class="span6 m-wrap" style=" resize:none;"></textarea>
                              </div>
                           </div>
                          
                          
                            <div class="control-group" >
                              <div class="controls">
                               <label class="" style="font-size:14px;" >Website Address</label>
                                 <input type="text" class="span6 m-wrap"  name="website">
                              </div>
                           </div>
                          
                          
                          
                          <div class="control-group">
                              <label style="font-size:14px;">Image</label>
                              <div class="controls">
                                 <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                       <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="">
                                    </div>
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                    <div>
                                       <span class="btn blue btn-file"><span class="fileupload-new"><i class="icon-camera"></i> Select image</span>
                                       <span class="fileupload-exists">Change</span>
                                       <input type="file" name="file" id="file" class="default"></span>
                                       <a href="#" class="btn red fileupload-exists" data-dismiss="fileupload">Remove</a>
                                    </div>
                                 </div>
                                 <span class="label label-important">NOTE!</span>
                                 <span>
                                 You must upload an image file with one of the following extensions: "jpg","jpeg","gif","png","bmp"
                                 </span>
                              </div>
                           </div>
						  
                          <br/>
                                
                       <div class="control-group " style="height:100px;">
                              <div class="controls">
                          
                              
                               <label class="" style="font-size:14px;" >Service </label>
               <?php
				foreach ($result_yellow_category as $collection)
				{ 
				$id=$collection['yellow_category']['yellow_cat_id'];
				$servies=$collection['yellow_category']['yellow_cat_name'];
				?>  
                <div style="width:33%; float:left;" class="check">        
                    <label><input type="checkbox" name="<?php echo $id; ?>" class="check_value" value="<?php echo $id; ?>" ><?php echo $servies; ?></label>
                </div>
                <?php } ?>
              
                              </div>
                           </div>
                            
                           <div class="form-actions">
                              <input type="submit" class="btn green" value="Submit" name="sub">
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
	      name: {
	       
	        required: true
	      },
		  mobile: {
	       
	        required: true,
			number:true,
			minlength:10,
			maxlength:10
	      },
		   email: {
	       
	        required: true,
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