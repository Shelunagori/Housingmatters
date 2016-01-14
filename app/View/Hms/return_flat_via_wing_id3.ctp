
              <select style=""  class="m-wrap medium chosen" name="flat<?php echo $i; ?>" id="flat<?php echo $i; ?>"  data-placeholder="Choose a Category"   tabindex="1">
                 <option value="">--UNIT--</option>
                  <?php
										
										foreach ($result3 as $db) 
										{
 										  $flat_id=$db['flat']["flat_id"];
										  $flat_name=$db['flat']["flat_name"];
										  $flat_area = (int)$db['flat']['flat_area'];	
									if($flat_area == 0)
									{	
										 ?>
                 <option value="<?php echo $flat_id; ?>"><?php echo $flat_name; ?></option>
                 <?php  }} ?>
             </select>
