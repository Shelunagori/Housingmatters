<select name='flat' id="flat">
<option value=''> Select flat </option>
<?php

foreach($result_flat as $data)
{
$flat_id=$data['flat']['flat_id'];
$flat_name=$data['flat']['flat_name'];
?>
<option value='<?php echo $flat_id ; ?>'><?php echo $flat_name ; ?> </option>

<?php
} ?>
</select>

