<a href="flat_type" class="btn green"><i class="icon-arrow-left"></i>Back</a>

<br /><Br />
<center>
<form method="post" onsubmit="return validat()">
<div style="width:90%; background-color:white;">
<br />
<h3><b>Flat Type Edit</b></h3>
<Br />
<?php
$fl_tp = $this->requestAction(array('controller' => 'hms', 'action' => 'flat_type_name_fetch'),array('pass'=>array($fl_tp_id)));		
foreach($fl_tp as $collection)
{
//$auto_id1 = (int)$collection['flat_type_name']['auto_id'];	
$flat_type = $collection['flat_type_name']['flat_name'];
}
?>

Flat Type : <b><?php echo $flat_type; ?></b>

<input type="hidden" value="<?php echo $fl_tp_id; ?>" name="tp" />


<table border="0">
<tr>
<th>Flat Areas in square feet</th>
</tr>
<?php
$n =  0;
foreach($cursor2 as $collection)
{
$n++;
$auto_id2 = (int)$collection['flat']['flat_id'];
$area = $collection['flat']['flat_area'];
?>
<tr>
<td>
<input type="text" name="area<?php echo $auto_id2; ?>" class="medium m-wrap" value="<?php echo $area; ?>" id="ar<?php echo $n; ?>"/>
</td>
</tr>
<?php
}
?>
</table>
<input type="hidden" name="" id="cnt" value="<?php echo $n; ?>" />
<br />
<div style="color:red;" id="validate_result"> <?php echo @$vali; ?> </div>
<div>
<button type="submit" class="btn green" name="update">Update</button>
</div>
</div>
</form>
</center>




<?php ////////////////////////////////////////////////////////////////////////////////////////////////////// ?>

<script>
function validat()
{

var count = document.getElementById("cnt").value;
for(var i=1; i<=count; i++)
{
	
var value = '';
value = document.getElementById("ar" + i).value;
if(isNaN(value))
{
$('#validate_result').html('<div style="color:red; padding:5px;">Please Insert Numeric Value</div>'); return false;
}
if(value=== '') { $('#validate_result').html('<div style="color:red; padding:5px;">Please Fill All Fields</div>'); return false; }
}

}
</script>

