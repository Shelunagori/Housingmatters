<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////// ?>            
            
            <table width="100%" border="1" bordercolor="#FFFFFF" cellpadding="0">
            <tr>
            <td style="width:25%">
            <a href="it_regular_bill" class="btn blue btn-block"   style="font-size:16px;"> Regular Bill</a>
            </td>
            <td style="width:25%">
             <a href="it_supplimentry_bill" class="btn blue btn-block"  style="font-size:16px;">Supplementary Bill</a>
            </td>
            <td style="width:25%">
            <a href="in_head_report" class="btn blue btn-block"  style="font-size:16px;">Reports</a>
            </td>
            <td style="width:25%">
            <a href="select_income_heads" class="btn red btn-block"  style="font-size:16px;">Accounting Setup</a>
            </td>
            </tr>
            </table>
            
           <table  align="center" border="1" bordercolor="#FFFFFF" cellpadding="0">
            <tr>
			<td><a href="select_income_heads" class="btn">Selection of Income Heads</a>
			</td>
			<!--<td>
            <a href="it_due_tax" class="btn" style="font-size:16px;">Due tax</a>
            </td>-->
            <td>
            <a href="it_setup" class="btn" style="font-size:16px;">Terms & Condition</a>
            </td>
            <td>
            <a href="master_rate_card" class="btn" style="font-size:16px;">Rate Card</a>
            </td>
            <td>
            <a href="master_noc" class="btn yellow" style="font-size:16px;">Non Occupancy Charges</a>
            </td>
            <td>
            <a href="it_penalty" class="btn" style="font-size:16px;">Penalty Option</a>
            </td>
			</tr>
			</table> 
            
<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////// ?> 

<br />
<center>
<a href="master_noc" class="btn yellow">Non Occupancy Charges Add</a>
<a href="master_noc_view" class="btn purple">Non Occupancy Charges View / Update</a>
</center>
<br />


<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>



<table class="table table-bordered" style="background-color:white;">
<tr>
<th style="text-align:center;">
Flat Type
</th>
<th style="text-align:center;">
Non Occupancy Charges (Leased)
</th>
<th style="text-align:center;">
Action
</th>
</tr>
<?php
foreach($cursor1 as $collection)
{
$noc_ch = "";
$auto_id = (int)$collection['flat_type']['auto_id'];
//$flat_type = $collection['flat_type']['flat_name'];
$no_of_flat = $collection['flat_type']['number_of_flat'];
$fl_tp_id = (int)$collection['flat_type']['flat_type_id'];
$noc_ch = @$collection['flat_type']['noc_charge'];
$fl_tp = $this->requestAction(array('controller' => 'hms', 'action' => 'flat_type_name_fetch'),array('pass'=>array($fl_tp_id)));		
foreach($fl_tp as $collection)
{
//$auto_id1 = (int)$collection['flat_type_name']['auto_id'];	
$flat_type = $collection['flat_type_name']['flat_name'];
}
?>
<tr>
<th style="text-align:center;"><?php echo $flat_type; ?></th>
<?php	
$tp = (int)$noc_ch[0];
if($tp == 1)
{
$type = "Lump Sum";	
$amount = $noc_ch[1];
}
else if($tp == 2)
{
$type = "Per Square Feet";	
$amount = $noc_ch[1];
}
else if($tp == 3)
{
$type = "Flat Type";	
$amount = $noc_ch[1];
}
else if($tp == 4)
{
$type = "10% of Maintanance Charge";	
$amount = "";
}
?>
<td style="text-align:center;">
<?php
if(empty($noc_ch))
{
echo "<b>Empty</b>";	
}
else
{
if($tp == 4)
{
echo $type;
}
else
{
echo $type; ?> : <?php 
$amount = number_format($amount);
echo $amount; 
}
}
?>
</td>
<td style="text-align:center;">
<?php
if(empty($noc_ch))
{
}
else
{
?>
<a href="noc_edit?a=<?php echo $auto_id; ?>" class="mini btn purple">Edit</a>
<?php } ?>
</td>
</tr>
<?php
}


?>




</table>

















