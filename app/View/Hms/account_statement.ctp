<?php //////////////////////////////////////////////////////////////////////////////////////?>
<center>
<h3><b>Account Statement</b></h3>
</center>
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<center>
<div class="hide_at_print">
<table border="0">
<tr>
<td>
<select name="usr_id" class="m-wrap medium chosen" id="abc">
<option value="" style="display:none;">Select Resident Name</option>
<?php
foreach($cursor2 as $collection)
{
$user_id1 = (int)$collection['user']['user_id'];
$user_name1 = $collection['user']['user_name'];
?>
<option value="<?php echo $user_id1; ?>"><?php echo $user_name1; ?></option>
<?php
}
?>
</select>
</td>
<td>
<input type="text" class="medium m-wrap date-picker" name="from" id="from" style="background-color:white !important; margin-top:8px;" data-date-format="dd-mm-yyyy" />
</td>
<td>
<input type="text" class="medium m-wrap date-picker" name="to" id="to" style="background-color:white !important; margin-top:8px;" data-date-format="dd-mm-yyyy" />
</td>
<td>
<button type="button" name="" id="go" class="btn yellow" style="">Go</button>
</td>
</tr>
</table>
</div>
</center>
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<center>
<div id="show" style="width:94%;">
</div>
</center>
<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?> 


<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////?>

<script>
$(document).ready(function() {
	$("#go").live('click',function(){
	var usid = document.getElementById('abc').value;	
	var from = document.getElementById('from').value;	
	var to = document.getElementById('to').value;	
	$("#show").html('Loading...').load("account_statement_show_ajax?ff=" + usid + "&f=" + from +"&t=" + to +"");
	
	
	});
});
</script>




























