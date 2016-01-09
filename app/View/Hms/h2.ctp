
<table class="table table-bordered table-hover">
<tr>
<th>Sr. No.</th>
<th>Designation</th>
<th>Status</th>
</tr>
<?php
foreach ($result_main_module as $collection) 
{		  
 $module_id = $collection['main_module']['auto_id'];
 $module_name = $collection['main_module']['module_name']; 
  $c=$this->requestAction(array('controller' => 'hms', 'action' => 'count'),array('pass'=>array($module_id,$society_id)));            
?>
<tr>
<td><?php echo $module_id; ?></td>
<td><?php echo $module_name; ?></td>
<td>
<label class="">
<input type="checkbox" name="<?php echo $module_id; ?>" value="1" <?php if($c>0) { ?> checked <?php }  ?> <?php if($module_id==18) { ?> checked <?php } ?>>
</label>
</td>
</tr>
<?php  } ?>
<tr>
<td colspan="3">
<span style="float:right;">
<button type="submit" name="sub" value="xyz" class="btn blue">Assign Modules</button>
</span>
</td>		
</table>
