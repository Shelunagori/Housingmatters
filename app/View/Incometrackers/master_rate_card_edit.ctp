<?php
if($nnn == 5)
{
?>

<a href="master_rate_card_view" class="btn green"><i class="icon-arrow-left"></i>Back</a>
<br />
<br />
<center>
<div style="width:90%; background-color:white;">
<br />
<h3><b>Rate Card Edit</b></h3>
<form method="post" onsubmit="return vali()">
<?php
foreach($cursor1 as $collection)
{
$fl_tp_id  = (int)$collection['flat_type']['flat_type_id'];
$charge = $collection['flat_type']['charge'];

$fl_tp = $this->requestAction(array('controller' => 'hms', 'action' => 'flat_type_name_fetch'),array('pass'=>array($fl_tp_id)));		
foreach($fl_tp as $collection)
{
//$auto_id1 = (int)$collection['flat_type_name']['auto_id'];	
$flat_type = $collection['flat_type_name']['flat_name'];
}
}
?>
<input type="hidden" value="<?php echo $auto_id; ?>" name="au" />
<h4><b>Flat Type : <?php echo $flat_type; ?></b></h4>
<div id="validate_result"></div>
<table class="table table-bordered">
<?php

foreach($cursor3 as $collection2)
{
$income_head_arr = $collection2['society']['income_head'];	
}
$nn = 0;
for($n=0; $n<sizeof($income_head_arr); $n++)
{
$nn++;
$income_head_arr_id = (int)$income_head_arr[$n];
$auto_id3 = $income_head_arr_id;	
$result1 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_account_fetch2'),array('pass'=>array($income_head_arr_id)));	
foreach($result1 as $collection)
{
$ih_name = $collection['ledger_account']['ledger_name'];
}

?>
<tr>
<th style="text-align:center;"><?php echo $ih_name; ?></th>
<?php
for($i=0; $i<sizeof($charge); $i++)
{
$charge2 = $charge[$i];
$auto_id2 = (int)$charge2[0];
$type = (int)$charge2[1];
$amount = $charge2[2];
if($auto_id2 == $auto_id3)
{
?>
<td>
<select name="tp<?php echo $auto_id3; ?>" class="m-wrap small" id="tp<?php echo $nn; ?>">
<option value="1" <?php if($type == 1) { ?> selected="selected" <?php } ?>>Lump Sum</option>
<option value="2" <?php if($type == 2) { ?> selected="selected" <?php } ?>>Per Square Feet</option>
<option value="3" <?php if($type == 3) { ?> selected="selected" <?php } ?>>Flat Type</option>
</select>

<input type="text" name="amt<?php echo $auto_id3; ?>" class="m-wrap small" value="<?php echo $amount; ?>" id="amt<?php echo $nn; ?>"/>
</td>
<?php	
}
}
?>
</tr>
<?php
}

?>
<input type="hidden" value="<?php echo $nn; ?>" id="count" />
</table>	

<div>
<button type="submit" class="btn green" name="sub">Update</button>
</div>
</form>
</div>
</center>
<?php
}
else if($nnn == 55)
{
?>

<form method="post">
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-header">
<center>
<h3 id="myModalLabel3" style="color:#999;"><b>Rate Card Update</b></h3>
</center>
</div>
<div class="modal-body">
<input type="hidden" name="auto_id" value="<?php echo $au; ?>" />
<input type="hidden" name="val" value="<?php echo $ch4; ?>" />
<center>
<h3><b>Are You Sure</b></h3>
</center>
</div>
<div class="modal-footer">
<a href="master_rate_card_edit?a=<?php echo $au; ?>" class="btn">Cancel</a>
<button type="submit" name="sub2" class="btn blue">Confirm</button>
</div>
</div>


</form>


<?php
}
?>
<?php /////////////////////////////////////////////////////////////////////////////////// ?>

<script>
function vali()
{
var count = document.getElementById("count").value;
for(var i=1; i<=count; i++)
{
var amt = document.getElementById("amt" + i).value;
if(amt=== '') { $('#validate_result').html('<div style="background-color:white; color:red; padding:5px;">Please Fill All Fields</div>'); return false; }	
}



}
</script>
