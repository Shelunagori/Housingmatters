<div class="container-fluid" style="padding:0px; background-color:##EFEFEF; overflow:auto;" >
			<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				
				<div style=" background-color:#EFEFEF; overflow:auto; padding-top:2px;">
            <div style="float:left; font-size:24px; padding-top:8px; padding-left:5px; color:#666;">Classified Ads</div>
			<div style="float:right;">
            <a href="classified" class="btn "><b>View</b></a>
            <a href="classified_draft" class="btn"><b>Draft</b></a>
            <a href="classified_my_post" class="btn"><b>My Post</b></a>
            <a href="classified_select_category" class="btn green"><b>Post Classified</b></a>
            </div>
            </div>
				
				<br/>
				<div class="row-fluid">
					<div style="width:70%; margin-left:15%;">
                        <div class="row-fluid"  >
              			 <div class="span12">
                  <!-- BEGIN VALIDATION STATES-->
				 
				  
                 		 <div class="portlet box green">
                    
                    
                    
                     <div class="portlet-title">
                        <h4><i class="icon-reorder"></i>Create New Classified</h4>
                        
                     </div>
                     <div class="portlet-body form">
                        <h3 class="block"></h3>
                        <!-- BEGIN FORM-->
						
                        <form id="contact-form" method="POST" class="form-horizontal" enctype="multipart/form-data">
                        
                           <div class="control-group">
                              <div class="controls">
                               <label class="" style="font-size:14px;">Title*<span style="font-size:12px; color:#999;">(Maximum 30 characters.)</span></label>
                                 <input type="text" class="span6 m-wrap" id="inputWarning" name="title">
							</div>
                               </div>							
							 <div class="control-group">
                              <div class="controls">	 
								 
                                <label class="" style="font-size:14px;">Upload Photo</label>
						<div class="fileupload fileupload-new" data-provides="fileupload"><input type="hidden" value="" name="">
                                    <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                       <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="">
                                    </div>
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                    <div>
                                       <span class="btn blue btn-file"><span class="fileupload-new"><i class=" icon-camera"></i> Select Image</span>
                                       <span class="fileupload-exists"><i class="  icon-camera-retro"></i>  Change</span>
                                       <input type="file" class="default" name="photo_upload"></span>
                                       <a href="#" class="btn red fileupload-exists" data-dismiss="fileupload"><i class="icon-remove-circle"></i> Remove</a>
                                    </div>
                                 </div>
							</div>
                               </div>
                            <div class="control-group">
                              <div class="controls">
                              <label class="" style="font-size:14px;">Price </label>
							  <input type="text" class="span6 m-wrap popovers" data-trigger="click "  data-content="Please enter full price like 10000, 25000000 etc.Do not enter characters or abbreviations like 10k, 2.5cr or 10,000" data-original-title="Information" id="" name="price">
							  </div>
							  </div>
							   <div class="control-group">
                                       
                                       <div class="controls">
                                          <label class="radio" style="font-size:14px;">
                                          <div class="radio" id="uniform-undefined"><span><input type="radio" name="optionsRadios1" value="1" style="opacity: 0;"></span></div>
                                         Negotiable 
                                          </label>
                                          <label class="radio" style="font-size:14px;">
                                          <div class="radio" id="uniform-undefined"><span class="checked"><input type="radio" name="optionsRadios1" value="2" checked="" style="opacity: 0;"></span></div>
                                          Fixed
                                          </label>  
                                         </div>
                                    </div>

 <div class="control-group">
                                       
                                       <div class="controls">
                                       <label> Type of Ad* </label>
                                          <label class="radio" style="font-size:14px;">
                                          <div class="radio" id="uniform-undefined"><span><input type="radio" name="sell" value="1" style="opacity: 0;"></span></div>
                                        I want to sell
                                          </label>
                                          <label class="radio" style="font-size:14px;">
                                          <div class="radio" id="uniform-undefined"><span class="checked"><input type="radio" name="sell" value="2" checked="" style="opacity: 0;"></span></div>
                                          I want to buy
                                          </label>  
                                         </div>
                                    </div>
							 
							 
							
							 
 <div class="control-group">
                                       
                                       <div class="controls">
                                       <label> Condition* </label>
                                          <label class="radio" style="font-size:14px;">
                                          <div class="radio" id="uniform-undefined"><span><input type="radio" name="condition" value="1" style="opacity: 0;"></span></div>
                                        Used
                                          </label>
                                          <label class="radio" style="font-size:14px;">
                                          <div class="radio" id="uniform-undefined"><span class="checked"><input type="radio" name="condition" value="2" checked="" style="opacity: 0;"></span></div>
                                          New
                                          </label>  
                                         </div>
                                    </div>
							 
									<center>
									<hr><p style="color:red;">By Default,Classified Ads will be Published for 30 Days,</p>
<p style="color:red;">User can Delete/Extend the Ad Time peried.</p><hr> 
									
									</center>
									
							   <div class="control-group">
                              <div class="controls">
							  <label class="" style="font-size:14px;">Offer Up To</label>
							  <input type="text" class="span6 m-wrap date-picker" data-date-format="dd-mm-yyyy" name="offer">
							  </div>
							  </div>
                             
							<div class="control-group">
                              <div class="controls">							   
						    <label class="" style="font-size:14px;">Description</label>
							<textarea  class="span8 m-wrap" style="resize:none;" rows="5" name="description"></textarea>
							
							</div>
							</div>
                             
                           <div class="form-actions">
                              <button type="submit" class="btn green" name="pub" value="xyz">Publish it</button>
                               <button type="submit" class="btn green" name="draft" value="xyz">Save as Draft</button>
                           </div>
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
		   price: {
	        number: true,
	        required: true,
			maxlength:10
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