
<table class="table table-bordered table-hover">
<tr>
    <th>Sr. No.</th>
    <th>Modules</th>
    
</tr>

<?php
$i=0;

foreach ($result_hm_modules_assign as $collection) 
{
	$i++;	
	$module_id=(int)$collection["hm_modules_assign"]["module_id"];
	
$result_data=$this->requestAction(array('controller' => 'hms', 'action' => 'fetch_main_module_name'), array('pass' => array($module_id)));
foreach ($result_data as $collection) 
{	
	$module_name=$collection["main_module"]["module_name"];
}
	?>
<tr>
<td><?php echo $i; ?></td>
    <td colspan="2"><?php echo $module_name; ?></td>
</tr>
<tr>
<td></td><td colspan="2">
<table border="0">
<?php
$result_sub_module=$this->requestAction(array('controller' => 'hms', 'action' => 'fetch_sub_module'), array('pass' => array($module_id)));
foreach ($result_sub_module as $collection) 
{	
	$sub_module_id=$collection["sub_modules"]["auto_id"];
	$sub_module_name=$collection["sub_modules"]["sub_module_name"];
	
$n=$this->requestAction(array('controller' => 'hms', 'action' => 'fetch_role_privileges'), array('pass' => array($sub_module_id)));

	?>
    <tr><td><?php echo $sub_module_name; ?></td><td><input type="checkbox" <?php if($n>0) { ?>checked="checked" <?php } ?> name="ch<?php echo $sub_module_id; ?>" value="1" /></td></tr>
    <?php
} ?>
</table>
</td></tr>
<?php

	
}
?>
<tr>
<td colspan="3">
<span style="float:right;">
<button type="submit" name="add_role"  class="btn blue">Assign Modules</button>
</span>
</td>		

</tr>
</table>
</form>