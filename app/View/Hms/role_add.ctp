<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>

<script>
$(document).ready(function() {

$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>
<!--<div style="background-color:#EFEFEF; border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6; padding:10px; box-shadow:5px; font-size:16px; color:#006;">
               Manage Roles
</div>-->

<div class="tabbable tabbable-custom">
<ul class="nav nav-tabs">
	
</ul>
        <div class="tab-content">
        <div class="tab-pane active" >
        <div class="span6" style="margin-left:25%;  ">
        <div class="portlet-body" >
        <table class="table table-hover table-bordered" id="tb">
        <tr>
        <th>Sr.no.</th>
        <th>Role Name</th>
        </tr>
		<?php 
		$r=0;
		foreach ($result_role as $collection) 
		{ 
		$r++;
		$role_name = $collection['role']['role_name'];
		?>
		<tr>
        <th><?php echo $r; ?></th>
        <td><?php echo $role_name; ?></td>
        </tr>
		<?php } ?>
        </table>
        <form method="post">
        <div class="input-append" style="margin-left:23%;">                      
        <input class="m-wrap" size="16" type="text" placeholder="Role name" id="role_name" name="role_name">
        <button class="btn blue" type="submit" name="add_role" >Add New Role</button>
        </div>
        </form>
        
        
        </div>
        </div>
        </div>
        
        </div>
        </div>