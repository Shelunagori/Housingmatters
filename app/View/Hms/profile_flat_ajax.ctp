
              <select  name="flat_profile">
                 <option value="">--Flat--</option>
                  <?php
										
										foreach ($result3 as $db) 
										{
 										  $flat_id=$db['flat']["flat_id"];
										  $flat_name=$db['flat']["flat_name"];
										 ?>
                 <option value="<?php echo $flat_id; ?>"><?php echo $flat_name; ?></option>
                 <?php } ?>
             </select>
       