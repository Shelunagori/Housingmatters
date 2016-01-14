
<?php
foreach($cursor1 as $collection)
{
$area_arr = $collection['flat_type']['area'];	
}
?>

<select name="area_id<?php echo $t; ?>" class="m-wrap medium" id="ar<?php echo $t; ?>">
<option value="">--SELECT AREA--</option>
<?php
for($i=0; $i<sizeof($area_arr); $i++)
{
$area_arr2 = $area_arr[$i]; 	
$area = $area_arr2[0];
$area_id = $area_arr2[1];
?>
<option value="<?php echo $area; ?>"><?php echo $area; ?></option>
<?php } ?>
</select>
