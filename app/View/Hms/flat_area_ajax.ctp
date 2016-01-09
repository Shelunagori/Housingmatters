<?php
foreach($cursor1 as $collection)
{
$no_of_flat = (int)$collection['flat_type']['number_of_flat'];
$flat_type = $collection['flat_type']['flat_name'];
}

?>
<input type="hidden" name="count" value="<?php echo $no_of_flat; ?>" />
<h4 style="color:red;">You have <?php echo $no_of_flat; ?> Flats of <?php echo $flat_type ?>,Please Insert Area:</h4>
<center>
<table border="0" style="width:100%; background-color:white;">
<tr>
<th>Insert area</th>
</tr>
<?php
for($j=1; $j<=$no_of_flat; $j++)
{
?>
<tr>
<td style="text-align:center;">
<input type="text" name="area<?php echo $j; ?>" class="m-wrap medium"/>
</td>
</tr>
<?php } ?>
<tr>
<td>
<button type="submit" name="sub" class="btn green" style="margin-left:55%;">Submit</button>
</td>
</tr>
</table>
</center>



