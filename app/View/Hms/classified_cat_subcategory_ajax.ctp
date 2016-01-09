 <div class="control-group">
          						<div class="controls">
								 <label class="" style="font-size:14px;">Classified Sub Category</label>
             						 <select   class=" span6 m-wrap" name="class_sub"  data-placeholder="Choose a Category"   tabindex="1">
                						<option value="">--Sub Category--</option>
                                        <?php
										
$result = $this->requestAction(array('controller' => 'hms', 'action' => 'master_classified_subcategory'),array('pass'=>array($category_id)));	
	
										foreach ($result as $db) 
										{
 										 $subcategory_id=$db['master_classified_subcategory']["subcategory_id"];
										 $subcategory_name=$db['master_classified_subcategory']["subcategory_name"];
										 ?>
                                         <option value="<?php echo $subcategory_id; ?>"><?php echo $subcategory_name; ?> </option>
                                         <?php
										}
										?>
            						 </select>
         						 </div>
     						 </div>