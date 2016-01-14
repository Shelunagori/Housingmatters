<div class="control-group" >
          <div class="controls">
              <select style="width:100%;"  class="m-wrap chosen" name="flat" id="flat"  data-placeholder="Choose a Category"   tabindex="1">
                 <option value="">--Flat--</option>
                  <?php
										
										foreach ($result3 as $db) 
										{
 										 echo $flat_id=$db['flat']["flat_id"];
										 echo $flat_name=$db['flat']["flat_name"];
										 ?>
                 <option value="<?php echo $flat_id; ?>"><?php echo $flat_name; ?></option>
                 <?php } ?>
             </select>
          </div>
      </div>