<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>				   
<script>
$(document).ready(function() {
$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>


<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>            
		<!--	<table width="100%" border="1" bordercolor="#FFFFFF" cellpadding="0">
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
            </table> -->
            
           <table  align="center" border="1" bordercolor="#FFFFFF" cellpadding="0">
            <tr>
            <td><a href="<?php echo $webroot_path; ?>Incometrackers/select_income_heads" class="btn" rel='tab'>Selection of Income Heads</a>
			<!--<td>
            <a href="it_due_tax" class="btn" style="font-size:16px;">Due tax</a>
            </td>-->
            <td>
            <a href="<?php echo $webroot_path; ?>Incometrackers/it_setup" class="btn " style="font-size:16px;" rel='tab'>Terms & Condition</a>
            </td>
            <td>
            <a href="<?php echo $webroot_path; ?>Incometrackers/master_rate_card" class="btn yellow" style="font-size:16px;" rel='tab'>Rate Card</a>
            </td>
			<td>
            <a href="<?php echo $webroot_path; ?>Incometrackers/master_noc" class="btn" style="font-size:16px;" rel='tab'>Non Occupancy Charges</a>
            </td>
			<td>
            <a href="<?php echo $webroot_path; ?>Incometrackers/it_penalty" class="btn" style="font-size:16px;" rel='tab'>Penalty Option</a>
            </td>
			</tr>
			</table> 
            
<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<br />
<center>
       <a href="<?php echo $webroot_path; ?>Incometrackers/master_rate_card" class="btn yellow" rel='tab'>Rate Card Add</a>     
       <a href="<?php echo $webroot_path; ?>Incometrackers/master_rate_card_view" class="btn purple" rel='tab'>Rate Card View / Update</a> 
       </center>    
       <br />
<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////// ?>

<table class="table table-bordered" style="background-color:white;"> 
<tr>
<th style="text-align:center;">Flat Type</th>
<?php
$l=0;
foreach($cursor4 as $collection)
{
$l++;
$income_head_arr = $collection['society']['income_head'];
}
for($r=0; $r<sizeof($income_head_arr); $r++)
{
$income_head_arr_id = (int)$income_head_arr[$r];

$result1 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_account_fetch2'),array('pass'=>array($income_head_arr_id)));	
foreach($result1 as $collection)
{
$ih_name = $collection['ledger_account']['ledger_name'];
}
?>
<th style="text-align:center;"><?php echo $ih_name; ?></th>
<?php } ?>
<th style="text-align:center;">Action</th>
</tr>

<?php
foreach($cursor2 as $collection)
{
$charge = "";
$tp_id = (int)$collection['flat_type']['flat_type_id'];
$auto_id11 = (int)$collection['flat_type']['auto_id'];
$charge = @$collection['flat_type']['charge'];
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

if(!empty($charge))
{
for($s=0; $s<sizeof($income_head_arr); $s++)
{
$m=5;
$auto_id1 = (int)$income_head_arr[$s];
for($i=0; $i<sizeof($charge); $i++)
{
$charge2 = $charge[$i];	
$auto_id3 = (int)$charge2[0];
$tp = $charge2[1];
$amount = $charge2[2];
if($tp == 1)
{
$type="Lump Sum";
}
else if($tp == 2)
{
$type="Per Square Feet";	
}
else if($tp == 3)
{
$type="Flat Type";	
}
if($auto_id1 == $auto_id3)
{ 
$m = 55;
?>
<td style="text-align:center;">
<?php echo $type; ?> : <?php 
$amount = number_format($amount);
echo $amount; ?>
</td>

<?php
}}
if($m == 5)
{
?>
<th style="text-align:center;" colspan="<?php echo $l; ?>">Empty</th>
<?php
break;
}
}
}
else
{
$m = 555;
?>
<th colspan="<?php echo $l; ?>" style="text-align:center;">Empty</th>
<?php 	
}
?>
<td style="text-align:center;">
<?php
if(!empty($charge) && $m !=5)
{
?>
<a href="master_rate_card_edit/<?php echo $auto_id11; ?>" class="mini btn purple">Edit</a>
<?php } ?>
</td>
</tr>
<?php } ?>
</table>











