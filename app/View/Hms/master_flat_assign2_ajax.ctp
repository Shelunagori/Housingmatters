<?php
if($value == 1)
{
?>
<table style="width:100%; background-color:#FDFDEE;" class="table table-bordered">
<tr>
<th>Flat Name</th>
<th>Assign Square Feet</th>
</tr>

<?php
foreach($cursor1 as $collection)
{
$flat_id = (int)$collection['flat']['flat_id'];
$flat_name = $collection['flat']['flat_name'];
?>
<tr>
<td><?php echo $flat_name; ?></td>
<td> 
<input type="text" name="sq_feet<?php echo $flat_id; ?>" class="m-wrap medium" style="background-color:white !important;">
</td>
</tr>
<?php } ?>
<tr>
<td style="text-align:center;" colspan="2">
<button type="submit" class="btn green" name="sub">Submit</button>
</td>
</tr>
</table>

<?php } 
else if($value == 2)
{
?>
<table style="width:100%; background-color:#FDFDEE;" class="table table-bordered">
<tr>
<th>Flat Name</th>
<th>Assign BHK</th>
</tr>
<?php
foreach($cursor2 as $collection)
{
$flat_id = (int)$collection['flat']['flat_id'];
$flat_name = $collection['flat']['flat_name'];
?>
<tr>
<td><?php echo $flat_name; ?></td>
<td> 
<select class="medium m-wrap" tabindex="1" name="bhk<?php echo $flat_id; ?>">
<option value="">Select</option>
<?php
foreach($cursor3 as $collection)
{

$auto_id = (int)$collection['flat_rent']['auto_id'];
$name = $collection['flat_rent']['name'];
if($auto_id != 0)
{
?>
<option value="<?php echo $auto_id; ?>"><?php echo $name; ?></option>
<?php }} ?>
</select>
</td>
</tr>
<?php } ?>
<tr>
<td style="text-align:center;" colspan="2">
<button type="submit" class="btn green" name="sub">Submit</button>
</td>
</tr>
</table>
<?php } ?>






























