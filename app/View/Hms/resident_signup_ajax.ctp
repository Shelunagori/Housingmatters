<script>
$( document ).ready(function() {
$(".chosen").chosen();
$(".chosen-with-diselect").chosen({
allow_single_deselect: true
});
});

</script>


<div class="control-group" >
          <div class="controls">
              <select style="width:100%; font-size:16px;" id="wi_flat" onChange="wing_flat()" class="chosen m-wrap" name="wing"  data-placeholder="Choose a Category"   tabindex="1">
                 <option value="">--Wing(Block)--</option>
                  <?php
										
										foreach ($result3 as $db) 
										{
 										 echo $wing_id=$db['wing']["wing_id"];
										 echo $wing_name=$db['wing']["wing_name"];
										 ?>
                 <option value="<?php echo $wing_id; ?>"><?php echo $wing_name; ?></option>
                 <?php } ?>
             </select>
          </div>
      </div>