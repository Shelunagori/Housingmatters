<div style="background-color:#EFEFEF; border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6; padding:10px; box-shadow:5px; font-size:16px; color:#006;">
Deactive User
</div>
<br>
<form method="post" >
<table style='margin-left:30%;'>
<tr>
<td>	
<div class="control-group" >
<div class="controls">
<label>Select User</label>                                                            

<select class="  chosen" name="u_name"  data-placeholder="Select User " tabindex="1" onchange="role_fetch_privilages(this.value)">
<option value="" style="display:none;"></option>
<?php
foreach ($result_user as $collection) 
{
$user_name = $collection['user']['user_name'];
$user_id=$collection['user']['user_id'];
$wing_id=$collection['user']['wing'];
$flat_id=$collection['user']['flat'];
$wing_flat=$this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'),array('pass'=>array($wing_id,$flat_id)));
?>
<option value="<?php echo $user_id; ?>" /><?php echo $user_name; ?> <?php echo $wing_flat ; ?> </option>
<?php } ?>
</select>

</div>
</div> </td>
<td>
<div  style='margin-top: 15px;'>
<input type="submit" class="btn blue "value="Deactive" name="sub">
</div>
</td>
</tr>
</table>
</form>