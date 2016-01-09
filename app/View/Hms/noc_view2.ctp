<a href="master_noc" class="btn green"><i class="icon-arrow-left"></i>Back</a>

<?php
//echo $show_arr2;
$show_arr = explode("/",$show_arr2);
?>
<form method="post">
<center>
<h2 style="color:#999;"><b>Non Occupancy Charges</b></h2>
</center>
<br />
<center>
<table class="table table-bordered" style="width:60%; background-color:white;">
<tr>
<th style="text-align:center;">Flat Type</th>
<th style="text-align:center;">Non Occupancy Charges (Leased) </th>
</tr>
<?php
foreach($cursor1 as $collection)
{
$tp_id = (int)$collection['flat_type']['flat_type_id'];
$auto_id1 = (int)$collection['flat_type']['auto_id'];
$result = $this->requestAction(array('controller' => 'hms', 'action' => 'flat_type_name_fetch'),array('pass'=>array($tp_id)));	
foreach($result as $collection)
{
$flat_name = $collection['flat_type_name']['flat_name'];	
}	
?>
<tr>
<th style="text-align:center;"><?php echo $flat_name; ?></th>

<?php
for($j=0; $j<sizeof($show_arr); $j++)
{
$arr = $show_arr[$j];
$arr2 = explode(",",$arr);
$fltp = (int)$arr2[1];
if($fltp == $tp_id)
{
$ch_tp = (int)$arr2[0];
if($ch_tp == 1)
{
$ch_tp_name = "Lump Sum";
$amt = $arr2[2];
}
else if($ch_tp == 2)
{
$ch_tp_name = "Per Square Feet";
$amt = $arr2[2];	
}
else if($ch_tp == 3)
{
$ch_tp_name = "Flat Type";
$amt = $arr2[2];	
}
else if($ch_tp == 4)
{
$ch_tp_name = "10% of Maintanance Charge";
$amt = "";	
}
?>
<td style="text-align:center;">
<?php if($ch_tp == 4)
{
echo $ch_tp_name;
?>
<input type="hidden" name="tp<?php echo $auto_id1; ?>" value="<?php echo $ch_tp; ?>" />
<?php	
}
else
{
echo $ch_tp_name; ?> : <?php echo $amt;
?>
<input type="hidden" name="tp<?php echo $auto_id1; ?>" value="<?php echo $ch_tp; ?>" />
<input type="hidden" name="amt<?php echo $auto_id1; ?>" value="<?php echo $amt; ?>" />
<?php 	
}
?>
</td>

<?php
}
}
?>
</tr>
<?php
}
?>
</table>
</center>

<div style="width:100%;">
<a href="#myModal3" role="button" class="btn green" data-toggle="modal" style="float:right; margin-right:20%;">Submit</a>
</div>


<div id="myModal3" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true" style="display: none;">
<div class="modal-header">
<center>
<h3 id="myModalLabel3" style="color:#999;"><b>Non Occupancy Charges</b></h3>
</center>
</div>
<div class="modal-body">
<center>
<h3><b>Are You Sure</b></h3>
</center>
</div>
<div class="modal-footer">
<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
<button type="submit" class="btn blue" name="sub">Confirm</button>
</div>
</div>












</form>
