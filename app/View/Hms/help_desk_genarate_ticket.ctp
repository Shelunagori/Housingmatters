<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>
<script>
$(document).ready(function() {
$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>
<script type="text/javascript">
//Edit the counter/limiter value as your wish
var count = "500";   //Example: var count = "175";
function limiter(){
var tex = document.myform.description.value;
var len = tex.length;
if(len > count){
        tex = tex.substring(0,count);
        document.myform.description.value =tex;
        return false;
}
document.myform.limit.value = count-len;
}
</script>
<br/>

<div class="row-fluid">
					<div style="width:70%; margin-left:15%;">
                        <div class="row-fluid"  >
              			 <div class="span12">
                  <!-- BEGIN VALIDATION STATES-->
                 		 <div class="portlet box green">
                     <div class="portlet-title">
                        <h4><i class="icon-reorder"></i> Generate Help Desk Ticket</h4>
                        
                     </div>
                     <div class="portlet-body form">
                        <h3 class="block"></h3>
                        <!-- BEGIN FORM-->
                        <form  id="contact-form" name="myform" enctype="multipart/form-data" class="form-horizontal" method="post" >
                         <fieldset>
                          
                          
                          
                           
                           <div class="control-group ">
                              <div class="controls">
                               <label class="" style="font-size:14px;">Category</label>
                                 <select name="category" class="span6 m-wrap" >
                            <option value="" style="display:none;">Select Category</option>
                            <?php 
                            
							foreach ($result_help_desk_category as $collection) 
							{
							$help_desk_category_id=$collection['help_desk_category']["help_desk_category_id"];
							$help_desk_category_name=$collection['help_desk_category']["help_desk_category_name"];
							?>
                            <option value="<?php echo $help_desk_category_id ?> "><?php echo $help_desk_category_name ?></option>
                            <?php  }  ?>
                            </select> 
                              </div>
                           </div>
                           
                           
                           
                           
                           <div class="control-group ">
                              <div class="controls">
                               <label class="" style="font-size:14px;">Description</label>
                                  <textarea name=description wrap=physical rows=7 cols=40 onkeyup=limiter() style="resize:none; width:63%"></textarea>
                              </div>
                           </div>
                           <div class="control-group ">
                              <div class="controls">
                               <span>Text Limit</span><br/>
								<script type="text/javascript">
								document.write("<input type=text  name=limit size=4 readonly value="+count+">");
								</script>
                              </div>
                           </div>
                           
						   
						   <div class="controls">
							<label class="" style="font-size:14px;">Image</label>
							<div class="fileupload fileupload-new" data-provides="fileupload">
							<div class="fileupload-new thumbnail" style="width: 150px; height: 75px;">
							<img src="http://www.placehold.it/150x75/EFEFEF/AAAAAA&amp;text=no+image" alt="">
							</div>
							<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 75px; line-height: 10px;"></div>
							<div>
							<span class="btn blue btn-file" ><span class="fileupload-new" ><i class="icon-camera"></i> Select image</span>
							<span class="fileupload-exists">Change</span>
							<input type="file" name="file" class="default"></span>
							<a href="#" class="btn red fileupload-exists" data-dismiss="fileupload" >Remove</a>
							</div>
							</div>
							</div>
							
							
							
						
                          <div class="control-group">
                             
                              <div class="controls">
                               <label class="">Ticket Priority</label>
                                 <label class="radio">
                                 <div class="radio" id="uniform-undefined"><span class=""><input type="radio" name="priority" value="1" style="opacity: 0;"></span></div>
                                Urgent
                                 </label>
                                 <label class="radio">
                                 <div class="radio" id="uniform-undefined"><span><input type="radio" name="priority" value="2" checked="checked" style="opacity: 0;"></span></div>
                               Normal
                                 </label>  
                                
                              </div>
                           </div>
                         
                           
                           <div class="form-actions">
                              <input type="submit" name="sub" class="btn blue" value="Publish It" >
                              <input type="submit" name="draft" class="btn blue" value="Save as Draft" >
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
				
				  <script>
$(document).ready(function(){
		$('#contact-form').validate({
	    rules: {
	      category: {
	       
	        required: true
	      },
		  description: {
			//required: true,
	        remote: "content_check_des"
	      },
		  
	    },
			messages: {
	                 description: {
	                    remote: "You have enter wrong word."
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