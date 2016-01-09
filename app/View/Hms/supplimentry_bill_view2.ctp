<a href="it_supplimentry_bill" class="btn green"><i class="icon-arrow-left"></i>  Back</a>
<?php
$date = date('d-M-Y');
//$tem2 = explode(',',$tem);
if($type == 2)
{
$ih3 = explode('/',$ih);
}
?>

<center>
<div style="width:90%; background-color:white; overflow:auto;">
<br><Br><br>
<div style="width:90%; border:solid 1px;;">
<table border="0">
<tr>
<th style="text-align:center;">
<p style="font-size:22px;"><?php echo $society_name; ?></p>
</th>
</tr>
<td style="text-align:center;">
<?php echo $society_reg_no; ?>
</td>
</tr>
<tr>
<td style="text-align:center;">
<?php echo $society_address; ?>
</td>
</tr>
</table>
</div>
<div style="width:90%; border:solid 1px;  border-bottom:none; border-top:none; overflow:auto;">
<table border="0" style="width:65%; float:left;">
<tr>
<th colspan="2" style="text-align:left;"><p style="font-size:14px;">Bill for the date :<?php echo $from; ?></p></th>
</tr>
<?php
if($type == 2)
{
$result1 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($res_id)));	
foreach($result1 as $collection)
{	
$user_id = (int)$collection['ledger_sub_account']['user_id'];
}
$result2 = $this->requestAction(array('controller' => 'hms', 'action' => 'user_fetch'),array('pass'=>array($user_id)));	
foreach($result2 as $collection)
{
$residing = (int)$collection['user']['residing'];
$user_name = $collection['user']['user_name'];
$wing = (int)$collection['user']['wing'];
$flat =(int)$collection['user']['flat'];
}
/*
$flat1 = $this->requestAction(array('controller' => 'hms', 'action' => 'flat_fetch2'),array('pass'=>array($flat,$wing)));
foreach($flat1 as $collection)
{
$flat_type_id = (int)$collection['flat']['flat_type_id'];
$flat_master_id = (int)$collection['flat']['flat_master_id'];
}
$flat2 = $this->requestAction(array('controller' => 'hms', 'action' => 'flat_type_fetch'),array('pass'=>array($flat_type_id)));
foreach($flat2 as $collection)
{
$charge = $collection['flat_type']['charge'];	
$noc_ch = $collection['flat_type']['noc_charge'];
}
$flat3 = $this->requestAction(array('controller' => 'hms', 'action' => 'flat_master_fetch'),array('pass'=>array($flat_master_id)));
foreach($flat3 as $collection)
{
$sq_feet = (int)$collection['flat_master']['flat_area'];
}
*/
$wing_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'),array('pass'=>array($wing,$flat)));	
?>
<tr>
<td style="text-align:left; width:30%;">
Name:
</td>
<td style="text-align:left;"><?php echo $user_name; ?></td>
</tr>
<tr>
<td style="text-align:left;">Flat No.</td>
<td style="text-align:left;"><?php echo $wing_flat; ?></td>
</tr>
<?php
}
else if($type == 1)
{
?>
<tr>
<td style="text-align:left; width:30%;">
Company Name:
</td>
<td style="text-align:left;"><?php echo $com_name; ?></td>
</tr>
<tr>
<td style="text-align:left;">Person Name:</td>
<td style="text-align:left;"><?php echo $person_name; ?></td>
</tr>
<?php
}
?>
</table>
<table border="0" style="width:30%; float:right;">
<tr>
<td style="text-align:left;">Bill No.:</td>
<td style="text-align:left;"><?php echo $bill_no; ?></td>
</tr>
<tr>
<td style="text-align:left;">Bill Creation Date:</td>
<td style="text-align:left;"><?php echo $date; ?></td>
</tr>
<tr>
<td style="text-align:left;">Due Date:</td>
<td style="text-align:left;"><?php echo $due_date; ?></td>
</tr>
<tr>
<td style="text-align:left;">AREA:</td>
<td style="text-align:left;">1120</td>
</tr>
</table>
</div>
<div style="width:90.25%;">
<table border="1" style="width:100%;">
<tr>
<td style="width:80%; text-align:center;">Particulars</td>
<td style="text-align:center;">Amount(in Rs.)</td>
<tr>
<tr>
<td valign="top" style="height:200px;">
<?php
if($type == 2)
{
?>
<table border="0" style="width:100%;">
<?php
for($l=0; $l<sizeof($ih3); $l++)
{
$ih_id3 = $ih3[$l];
$ih_id4 = explode(",",$ih_id3);
$ihd = (int)$ih_id4[0];

$result3 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_account_fetch2'),array('pass'=>array($ihd)));		
foreach($result3 as $collection)
{
$income_head_name = $collection['ledger_account']['ledger_name'];
//$income_head_id1 = (int)$collection['income_head']['auto_id'];
}

?>
<tr>
<td style="text-align:left;"><?php echo $income_head_name; ?></td>
</tr>
<?php
}
?>
</table>
</td>
<td valign="top">
<table border="0" style="width:100%;">
<?php
$total_amount2 = 0;
for($p=0; $p<sizeof($ih3); $p++)
{
$ih_id5 = $ih3[$p];
$ih_id6 = explode(",",$ih_id5);
$amt = $ih_id6[1];

?>
<tr>
<td style="text-align:center;"><?php 
$amt2 = number_format($amt);
echo $amt2; ?></td>
</tr>
<?php
$total_amount2 = $total_amount2 + $amt;
}

$gt = $total_amount2;
?>
</table>
<?php
}
else
{
?>
<table border="0" style="width:100%;">
<tr>
<td style="text-align:left;">Amount Applied</td>
</tr>
</table>
<?php
?>
<td valign="top">
<table border="0" style="width:100%;">
<tr>
<td style="text-align:center;"><?php 
$amt6 = number_format($amt5);
echo $amt6; ?></td>
</tr>
<?php
$gt = $amt5;
?>
</table>
<?php
}
?>
</td>
</tr>
<tr>
<td valign="top">
<table border="0" style="width:100%;">
<tr>
<th style="text-align:right;">Grand Total:</th>
</tr>
</table>
</td>
<td valign="top">
<table border="0" style="width:100%;">
<tr>
<th style="text-align:center;"><?php 
$gt = number_format($gt);
echo $gt; ?></th>
</tr>
</table>
</td>
</tr>
</table>
</div>
<div style="width:90%; border:solid 1px; border-top:none;">
<table border="0" style="width:100%;">
<tr>
<th style="text-align:left;">
Terms And Conditions:
</th>
</tr>
<?php
foreach($cursorr as $collection)
{
$tems_name = $collection['terms_condition']['terms_conditions'];
?>
<tr>
<td style="text-align:left;"><?php echo $tems_name; ?></td>
</tr>
<?php
}
?>
</table> 
</div>
<br><br><br><br>
</div>

<form method="post">
<input type="hidden" name="from" value="<?php echo $from; ?>" />
<input type="hidden" name="to" value="<?php echo $to; ?>" />
<input type="hidden" name="due_date" value="<?php echo $due_date; ?>" />

<input type="hidden" name="tax1" value="<?php echo $tax1; ?>" />
<input type="hidden" name="desc" value="<?php echo $desc; ?>" />
<input type="hidden" name="tem" value="<?php echo $tem; ?>" />
<input type="hidden" name="type" value="<?php echo $type; ?>" />
<?php
if($type == 1)
{
?>
<input type="hidden" name="person_name" value="<?php echo $person_name; ?>" />
<input type="hidden" name="com_name" value="<?php echo $com_name; ?>" />
<input type="hidden" name="amt5" value="<?php echo $amt5; ?>" />
<?php
}
else
{
?>
<input type="hidden" name="ih" value="<?php echo $ih; ?>" />
<input type="hidden" name="res_id" value="<?php echo $res_id; ?>" />
<?php
}
?>
<br />
<div style="width:100%;">
<button type="submit" name="sub_sup" class="btn green" style="margin-left:68%;" value="sada">Submit</button>
</div>
</form>












