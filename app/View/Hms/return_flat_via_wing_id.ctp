<div class="control-group" >
          <div class="controls">
              <select style="width:100%;"  class="m-wrap" name="flat<?php echo $i; ?>" id="flat<?php echo $i; ?>"  data-placeholder="Choose a Category"   tabindex="1">
                 <option value="">--Flat--</option>
                  <?php
										
										foreach ($result3 as $db) 
										{
 										 echo $flat_id=$db['flat']["flat_id"];
										 echo $flat_name=$db['flat']["flat_name"];
										$aa = 0;
$user_fetch = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_user_info_via_flat_id'),array('pass'=>array($flat_id)));			
foreach($user_fetch as $data)										
{
$aa = 5;	
}

if($aa == 0)
{
?>
<option value="<?php echo $flat_id; ?>"><?php echo $flat_name; ?></option>
<?php }} ?>
</select>
          </div>
      </div>