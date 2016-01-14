<form method="post">
<select name='user' id="user">
<option value=''> Select user </option>
<?php

foreach($result_user as $data)
{
$user_id=$data['user']['user_id'];
$user_name=$data['user']['user_name'];
?>
<option value='<?php echo $user_id ; ?>'><?php echo $user_name ; ?> </option>

<?php
} ?>
</select>

<select name='wing' id="wing">
<option value=''> Select wing </option>
<?php

foreach($result_wing as $data)
{
$wing_id=$data['wing']['wing_id'];
$wing_name=$data['wing']['wing_name'];
?>
<option value='<?php echo $wing_id ; ?>'><?php echo $wing_name ; ?> </option>

<?php
} ?>
</select>

<div id="flat"></div>
<input type="submit" name="update" />
</form>
<script>
$(document).ready(function() { 
	 $("#wing").live('change',function(){
		var w=$(this).val();
		$("#flat").load('update_wing_flat_ajax?w='+w);
	 });
});
</script>