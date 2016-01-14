<?php
$fromm = date("Y-m-d", strtotime($from));
$fromm = new MongoDate(strtotime($fromm));

$tom = date("Y-m-d", strtotime($to));
$tom = new MongoDate(strtotime($tom));
?>

<table class="table table-bordered" style="background-color:white;">
<tr>
<th style="text-align:center;">Sr #</th>
<th style="text-align:center;">SO/PO Date</th>
<th style="text-align:center;">Required Date</th>
<th style="text-align:center;">Quatation</th>
<th style="text-align:center;">Vandor name</th>
<th style="text-align:center;">Unit of Measurement</th>
<th style="text-align:center;">Rate</th>
<th style="text-align:center;">Total</th>
<th style="text-align:center;">Action</th>
</tr>
<?php
$s=0;
foreach($cursor1 as $collection)
{
$datep = $collection['purchase_order']['purchase_order_date'];
$dater = $collection['purchase_order']['required_date'];
$quatation_id = $collection['purchase_order']['quatation_id'];
$vendor_name = $collection['purchase_order']['sent_to'];
$unit_id = $collection['purchase_order']['unit_of_measurement'];

if($datep >= $fromm && $datep <= $tom)
{
$s++;
$datep2 = date('d-m-Y',$datep->sec);	
$dater2 = date('d-m-Y',$dater->sec);	
?>
<tr>
<td style="text-align:center;"><?php echo $s; ?></td>
<td style="text-align:center;"><?php echo $datep2; ?></td>
<td style="text-align:center;"><?php echo $dater2; ?></td>
<td style="text-align:center;">Quatation <?php echo $quatation_id; ?></td>
<td style="text-align:center;">Vendor <?php echo $vendor_name; ?></td>
<td style="text-align:center;">Unit<?php echo $unit_id; ?></td>
<td style="text-align:center;">10</td>
<td style="text-align:center;">100</td>
<td style="text-align:center;"></td>
</tr>
<?php 
}
}
?>









</table>










</table>