<?php
 
foreach ($result_classified as $collection) 
{
  $view_title = $collection['classified']['classified_title'];
  $view_price = $collection['classified']['classified_price'];
 $view_price_type = (int)$collection['classified']['classified_price_type'];
 $condition = (int)$collection['classified']['classified_condition'];
 $sell = (int)$collection['classified']['classified_type_ad'];
 $view_description = $collection['classified']['classified_description'];
 $view_attachment = $collection['classified']['classified_attachment'];
 $cll_offer_date=$collection['classified']['classified_offer_up_to_date'];
 $classified_cat=$collection['classified']['classified_post_category_id'];
 $classified_cat_sub=$collection['classified']['classified_post_sub_category_id'];

}
 
 ?> 
 
 
 
 	
	 <script type="text/javascript">
   var xobj;
   //modern browers
   if(window.XMLHttpRequest)
    {
	  xobj=new XMLHttpRequest();
	  }
	  //for ie
	  else if(window.ActiveXObject)
	   {
	    xobj=new ActiveXObject("Microsoft.XMLHTTP");
		}
		else
		{
		  alert("Your broweser doesnot support ajax");
		  }
		   function classified_cat()
		  {		
		 	 
		    if(xobj)
			 {
				 var c1=document.getElementById("catee").value;
			 var query="?con1=" + c1;
			
			 xobj.open("GET","classified_cat_subcategory_ajax" +query,true);
			 xobj.onreadystatechange=function()
			  {
			  if(xobj.readyState==4 && xobj.status==200)
			   {	   
			   document.getElementById("echo_cate").innerHTML=xobj.responseText;
			   }
			  }
			 
			 }
			 xobj.send(null);
		  }
		  
		  </script>

	
	
 		
		<div style=" background-color:#EFEFEF; overflow:auto; padding-top:2px;">
            <div style="float:left; font-size:24px; padding-top:8px; padding-left:5px; color:#666;">Classified Ads</div>
			<div style="float:right;">
            <a href="classified" class="btn "><b>View</b></a>
            <a href="classified_draft" class="btn green"><b>Draft</b></a>
            <a href="classified_my_post" class="btn"><b>My Post</b></a>
            <a href="classified_select_category" class="btn"><b>Post Classified</b></a>
            </div>
            </div>
            <br/>
            
				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid">
             
					<div style="width:70%; margin-left:15%;">
                        <div class="row-fluid"  >
              			 <div class="span12">
                  <!-- BEGIN VALIDATION STATES-->
				
				  
                 		 <div class="portlet box green">
                    
                    
                    
                     <div class="portlet-title">
                        <h4><i class="icon-reorder"></i>Validation States</h4>
                        
                     </div>
                     <div class="portlet-body form">
                        <h3 class="block"></h3>
                        <!-- BEGIN FORM-->
						
                        <form id="contact-form" method="POST" class="form-horizontal" enctype="multipart/form-data">
                        
                      <div class="control-group">
          						<div class="controls">
								 <label class="" style="font-size:14px;">Classified Category</label>
             						 <select id="catee" onchange="classified_cat()" class=" span6 m-wrap" name="class_main"  data-placeholder="Choose a Category"   tabindex="1">
                						<option value="">--Category--</option>
										 <?php								
										
										foreach ($result1 as $db) 
										{
 										 $category_id=$db['master_classified_category']["category_id"];
										 $category_name=$db['master_classified_category']["category_name"];
										 ?>
                                         <option <?php if($classified_cat == $category_id) { ?> selected="selected" <?php } ?> value="<?php echo $category_id; ?>"><?php echo $category_name; ?> </option>
                                         <?php
										}
										?>
 
            						 </select>
         						 </div>
     						 </div>
                          
                          <div id="echo_cate">
                          
                          <div class="control-group">
          						<div class="controls">
								 <label class="" style="font-size:14px;">Classified Sub Category</label>
             						 <select   class=" span6 m-wrap" name="class_sub"  data-placeholder="Choose a Category"   tabindex="1">
                						<option value="">--Sub Category--</option>
                                 <?php
										
					$result = $this->requestAction(array('controller' => 'hms', 'action' => 'master_classified_subcategory'),array('pass'=>array($classified_cat)));					
										foreach ($result as $db) 
										{
 										 $subcategory_id=$db['master_classified_subcategory']["subcategory_id"];
										 $subcategory_name=$db['master_classified_subcategory']["subcategory_name"];
										 ?>
                                         <option <?php if($classified_cat_sub == $subcategory_id) { ?> selected="selected" <?php } ?> value="<?php echo $subcategory_id; ?>"><?php echo $subcategory_name; ?> </option>
                                         <?php
										}
										?>
            						 </select>
         						 </div>
     						 </div>
                          
                          </div>
                           
      
                           <div class="control-group">
                              <div class="controls">
                               <label class="" style="font-size:14px;">Title* <span style="font-size:12px; color:#999;">(Maximum 30 characters.)</span></label>
                                 <input type="text" class="span6 m-wrap" id="inputWarning" name="title" value="<?php echo $view_title; ?>">
							</div>
                               </div>							
							 <div class="control-group">
                              <div class="controls">	 
								 
                                <label class="" style="font-size:14px;">Photos</label>
						<div class="fileupload fileupload-new" data-provides="fileupload"><input type="hidden" value="" name="">
                                    <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                       <img src="<?php echo $this->webroot ; ?>/classified_photos/<?php echo $view_attachment; ?>" alt="">
                                    </div>
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                    <div>
                                       <span class="btn btn-file"><span class="fileupload-new">Select image</span>
                                       <span class="fileupload-exists">Change</span>
                                       <input type="file" class="default" name="photo_upload"></span>
                                       <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                    </div>
                                 </div>
							</div>
                               </div>
                            <div class="control-group">
                              <div class="controls">
                              <label class="" style="font-size:14px;">Price</label>
							  <input type="text" class="span6 m-wrap popovers" id="" data-trigger="click "  data-content="Please enter full price like 10000, 25000000 etc.Do not enter characters or abbreviations like 10k, 2.5cr or 10,000" data-original-title="Information" name="price" value="<?php echo $view_price; ?>">
							  </div>
							  </div>
							   <div class="control-group">
                                       
                                       <div class="controls">
                                          <label class="radio" style="font-size:14px;">
                                          <div class="radio" id="uniform-undefined"><span><input type="radio" name="optionsRadios1" value="1" style="opacity: 0;" <?php if($view_price_type == 1) { ?> checked="checked" <?php } ?>></span></div>
                                         Negotiable 
                                          </label>
                                          <label class="radio" style="font-size:14px;">
                                          <div class="radio" id="uniform-undefined"><span class="checked"><input type="radio" name="optionsRadios1" value="2"  style="opacity: 0;" <?php if($view_price_type == 2) { ?> checked="checked" <?php } ?>></span></div>
                                          Fixed
                                          </label>  
                                         </div>
                                    </div>




 <div class="control-group">
                                       
                                       <div class="controls">
                                       <label> Type of Ad* </label>
                                          <label class="radio" style="font-size:14px;">
                                          <div class="radio" id="uniform-undefined"><span><input type="radio" name="sell" value="1" style="opacity: 0;" <?php if($sell == 1) { ?> checked="checked" <?php } ?>></span></div>
                                        I want to sell
                                          </label>
                                          <label class="radio" style="font-size:14px;">
                                          <div class="radio" id="uniform-undefined"><span class="checked"><input type="radio" name="sell" value="2"  style="opacity: 0;"  <?php if($sell == 2) { ?> checked="checked" <?php } ?> ></span></div>
                                          I want to buy
                                          </label>  
                                         </div>
                                    </div>
							 
 <div class="control-group">
                                       
                                       <div class="controls">
                                       <label> Condition* </label>
                                          <label class="radio" style="font-size:14px;">
                                          <div class="radio" id="uniform-undefined"><span><input type="radio" name="condition" value="1" style="opacity: 0;" <?php if($condition == 1) { ?> checked="checked" <?php } ?>></span></div>
                                        Used
                                          </label>
                                          <label class="radio" style="font-size:14px;">
                                          <div class="radio" id="uniform-undefined"><span class="checked"><input type="radio" name="condition" value="2" style="opacity: 0;" <?php if($condition == 2) { ?> checked="checked" <?php } ?>></span></div>
                                          New
                                          </label>  
                                         </div>
                                    </div>
							 
									<hr>
									<center>
									<p style="color:red;">By Default,Classified Ads will be Published for 30 Days,</p>
<p style="color:red;">User can Delete/Extend the Ad Time peried.</b></p><hr>
									
									</center>
									
							   <div class="control-group">
                              <div class="controls">
							  <label class="" style="font-size:14px;">Offer Up To</label>
							  <input type="text" class="span6 m-wrap date-picker" data-date-format="dd-mm-yyyy" name="offer" id="" value="<?php echo $cll_offer_date ; ?>">
							  </div>
							  </div>
                              
                              
							<div class="control-group">
                              <div class="controls">							   
						    <label class="" style="font-size:14px;">Description</label>
							<textarea  class="span8 m-wrap" style="resize:none;" rows="5" name="description"><?php echo $view_description; ?></textarea>
							
							</div>
							</div>
                            
                           <div class="form-actions">
                           <button type="submit" class="btn green" name="pub" value="xyz">Publish it</button>
                              <button type="submit" class="btn green" name="sub" value="xyz">Save as Draft</button>
                              
                              
                             
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