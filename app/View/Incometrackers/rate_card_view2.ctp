<?php
//echo $show_arr;
//echo $ihe;



?>
<div style="width:100%;">
<a href="master_rate_card" class="btn green"><i class="icon-arrow-left"></i>Back</a>
</div>
<form method="post">
<br />
<center>
<h2 style="color:#999;"><b>Rate Card</b></h2>
</center>
<div style="width:100%; background-color:white; overflow:auto;">

<table class="table table-bordered" style="background-color:white;"> 
<tr>
<th style="text-align:center;">Flat Type</th>
<?php
foreach($cursor4 as $collection)
{
$income_head_arr = $collection['society']['income_head'];
}
for($p=0; $p<sizeof($income_head_arr); $p++)
{
$income_head_arr_id = (int)$income_head_arr[$p];
$result1 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_account_fetch2'),array('pass'=>array($income_head_arr_id)));	
foreach($result1 as $collection)
{
$ih_name = $collection['ledger_account']['ledger_name'];	
}
?>
<th style="text-align:center;"><?php echo $ih_name; ?></th>
<?php } ?>
</tr>
<?php
foreach($cursor2 as $collection)
{
$tp_id = (int)$collection['flat_type']['flat_type_id'];
$auto_id1 = (int)$collection['flat_type']['auto_id'];
$result = $this->requestAction(array('controller' => 'hms', 'action' => 'flat_type_name_fetch'),array('pass'=>array($tp_id)));	
foreach($result as $collection)
{
$flat_name = $collection['flat_type_name']['flat_name'];	
}
//$tp_name = $collection['flat_type']['flat_name'];
?>
<tr>
<th style="text-align:center;"><?php echo $flat_name; ?></th>
<?php
$sub_arr1 = explode(",",$show_arr);
for($x=0; $x<sizeof($sub_arr1); $x++)
{
$sub_arri2 = $sub_arr1[$x];
$sub_arr2 = explode("/",$sub_arri2);
for($y=0; $y<sizeof($sub_arr2); $y++)
{
$sub_arri3 = $sub_arr2[$y];	
$sub_arr3 = explode("-",$sub_arri3);
$auto_id3=(int)$sub_arr3[0];
$auto_id4=(int)$sub_arr3[1];
$ch_tp = (int)$sub_arr3[2];
$charge = $sub_arr3[3];

if($auto_id1 == $auto_id3)
{
if($ch_tp == 1)
{
$ch_tp_name = "Lump Sum";	
}
else if($ch_tp == 2)
{
$ch_tp_name = "Per Square Feet";	
}
else
{
$ch_tp_name = "Flat Type";	
}
?>

<td style="text-align:center;">
<?php echo $ch_tp_name; ?> : <?php echo $charge; ?>
</td>
<input type="hidden" name="tp<?php echo $auto_id3; ?><?php echo $auto_id4; ?>" value="<?php echo $ch_tp; ?>" />
<input type="hidden" name="chg<?php echo $auto_id3; ?><?php echo $auto_id4; ?>" value="<?php echo $charge; ?>" />


<?php	

}}}

?>	
<!-- <td style="text-align:center;">
Charge Type:<?php echo $type; ?><br />
Charge amount: <?php echo $charge; ?>
</td>
<input type="hidden" name="tp<?php echo $tp_id; ?><?php echo $ih_id; ?>" value="<?php echo $type_id; ?>" />
<input type="hidden" name="chg<?php echo $tp_id; ?><?php echo $ih_id; ?>" value="<?php echo $charge; ?>" />
-->
<?php
	

?>
</tr>
<?php } ?>
</table>


</div>
<br />
<div style="width:100%;">

<a href="#myModal3" role="button" class="btn green" data-toggle="modal" style="float:right; margin-right:20%;">Submit</a>
</div>

<?php /////////////////////////////////////////////////////////////////////// ?>
<div id="myModal3" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true" style="display: none;">
<div class="modal-header">
<center>
<h3 id="myModalLabel3" style="color:#999;"><b>Rate Card</b></h3>
</center>
</div>
<div class="modal-body">
<center>
<h3><b>Are You Sure</b></h3>
</center>
</div>
<div class="modal-footer">
<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
<button type="submit" name="sub" class="btn blue">Confirm</button>
</div>
</div>
<?php //////////////////////////////////////////////////////////////////////// ?>

</form>