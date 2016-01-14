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
               Assign Modules To Role
</div>-->
<div class="tabbable tabbable-custom">
<ul class="nav nav-tabs">
	
</ul>
<div class="tab-content" style="min-height:300px;>
<div class="tab-pane active" >
<div >
<div class="portlet-body" >

<form method="post">

<label style="margin-left:40%;">Select a Role</label>                                                            
<span style="margin-left:20%;">
<select class="span6 chosen" name="r_name"  data-placeholder="Choose A Role" tabindex="1" onchange="role_fetch_privilages(this.value)">
<option value="" style="display:none;"></option>
<?php
foreach ($result_role as $collection) 
{
$role_name12 = $collection['role']['role_name'];
$role_id1=$collection['role']['role_id'];
?>
<option value="<?php echo $role_id1; ?>"><?php echo $role_name12; ?></option>
<?php } ?>
</select>
</span>
<br/>
<div id="ajax_contant" ></div>
</form>
</div>
</div>
</div>    
</div>
</div>

<script>
function role_fetch_privilages(c)
{
$(document).ready(function() {

	$("#ajax_contant").html('<div align="center"><img src="<?php echo $this->webroot ; ?>/as/windows.gif"/></div>').load('assign_modules_to_role_ajax?con=' + c);				
});
}
</script>