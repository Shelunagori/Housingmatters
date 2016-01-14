<table class="table table-bordered table-hover">
<thead>
    <tr>
        <th>Role Name</th>
        <th>Status</th>
    </tr>
</thead>
<tbody>
									                     
<?php

foreach ($result_role as $collection) 
{					
	$role_id=(int)$collection['role']["role_id"];
	$role_name=$collection['role']["role_name"];
	 $c_n=$this->requestAction(array('controller' => 'hms', 'action' => 'user_role'),array('pass'=>array($role_id,$user_id)));
	
	?>
    <tr>
        <td ><?php echo $role_name; ?></td>
        <td><input type="checkbox" <?php if($c_n>0) { ?>checked="checked" <?php } ?> name="role<?php echo $role_id; ?>" value="1" /></td>
    </tr>
    <?php
}
?>
<tr>
                                <td colspan="3">
                                <span style="float:right;">
                                <button type="submit" name="sub" value="xyz" class="btn blue">Assign Designation</button>
                                </span>
                                </td>		
								</tr>
	
    </tbody>
</table>  
