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
var tex = document.myform.comment.value;
var len = tex.length;
if(len > count){
        tex = tex.substring(0,count);
        document.myform.comment.value =tex;
        return false;
}
document.myform.limit.value = count-len;
}
</script>




<br/>
<?php

foreach($result_help_desk_draft as $data)
{

$category=$data['help_desk']['help_desk_complain_type_id'];
$help_desk_description=$data['help_desk']['help_desk_description'];
$help_desk_file1=$data['help_desk']['help_desk_file'];
$ticket_priority=$data['help_desk']['ticket_priority'];
}

?>
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
                            <option value="<?php echo $help_desk_category_id ?> " <?php if($category==$help_desk_category_id) { ?> selected <?php } ?>><?php echo $help_desk_category_name ?></option>
                            <?php  }  ?>
                            </select> 
                              </div>
                           </div>
                           
                           
                          
                           
                           <div class="control-group ">
                              <div class="controls">
                               <label class="" style="font-size:14px;">Description</label>
                                  <textarea name=comment wrap=physical rows=7 cols=40 onkeyup=limiter() style="resize:none; width:63%"><?php echo $help_desk_description ; ?></textarea>
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
							<?php if(!empty($help_desk_file1))
							{ ?>
							<img src="<?php echo $this->webroot ; ?>/help_desk_file/<?php echo $help_desk_file1 ; ?>" alt="" >
							<?php } else { ?>
							
							<img src="http://www.placehold.it/150x75/EFEFEF/AAAAAA&amp;text=no+image" alt="" >
							<?php } ?>
							</div>
							<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 75px; line-height: 10px;"></div>
							<div>
							<span class="btn blue btn-file" ><span class="fileupload-new" ><i class="icon-camera"></i> Select image</span>
							<span class="fileupload-exists">Change</span>
							<input type="file" name="file" class="default" ></span>
							<a href="#" class="btn red fileupload-exists" data-dismiss="fileupload" >Remove</a>
							</div>
							</div>
							</div>
					
                          <div class="control-group">
                             <div class="controls">
                               <label class="">Ticket Priority</label>
                                 <label class="radio">
                                 <div class="radio" id="uniform-undefined"><span class=""><input type="radio" name="priority" value="1" style="opacity: 0;" <?php if($ticket_priority==1) { ?> checked="checked" <?php } ?> ></span></div>
                                Urgent
                                 </label>
                                 <label class="radio">
                                 <div class="radio" id="uniform-undefined"><span><input type="radio" name="priority" value="2" style="opacity: 0;" <?php if($ticket_priority==2) { ?> checked="checked" <?php } ?>></span></div>
                               Normal
                                 </label>  
                                
                              </div>
                           </div>
                         
                           
                           <div class="form-actions">
                              <input type="submit" name="sub" class="btn blue" value="Publish It" >
                             
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
				
				limiter();
				 });
				</script>
				
				
				
				  <script>
$(document).ready(function(){
		$('#contact-form').validate({
	    rules: {
	      category: {
	       
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