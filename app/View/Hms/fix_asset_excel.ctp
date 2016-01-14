<?php 
$current_date = date('d-m-Y');

$filename=$society_name.'_Fix_asset';
//$filename=$society_name.'_Fixed_asset_';
$filename = str_replace(' ', '_', $filename);
$filename = str_replace(' ', '-', $filename);
header ("Expires: 0");
header ("border: 1");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=".$filename.".xls");
header ("Content-Description: Generated Report" );
?>

<table class="" style="" id="tbb" width="100%" style=" background-color:white;" border="1">
<thead>
<tr>
<td colspan="11" align="center"><span style="font-size:14px;"><b><?php echo $society_name; ?> Fixed Assets Register on <?php echo $current_date; ?></b></span></td>
</tr>
<tr>
<th >Sr.No.</th>
<th>Asset Category</th>
<th>Asset Name</th>
<th>Narration</th>
<th>Date of Purchase</th>
<th width="5%">Date of Purchase</th>
<th>Cost of Purchase</th>
<th>Supplier</th>
<th>Warranty From</th>
<th>Warranty To</th>
<th>Maintanance Schedule</th>
</tr>
</thead>
<tbody id="count_row">
<?php 
$total_amount=0;
foreach($result_fix_asset as $data){
	$fix_asset_id=$data['fix_asset']['fix_asset_id'];
	$fix_receipt_id=(int)$data['fix_asset']['fix_receipt_id'];
	$asset_category_id=$data['fix_asset']['asset_category_id'];
	$asset_supplier_id=$data['fix_asset']['asset_supplier_id'];
	$asset_name=$data['fix_asset']['asset_name'];
	$purchase_date=$data['fix_asset']['purchase_date'];
	$purchase_date=date('d-m-Y',$purchase_date);
	$description=$data['fix_asset']['description'];
	
$ammount=$data['fix_asset']['cost_of_purchase'];

	$amount=$data['fix_asset']['cost_of_purchase'];
	$warranty_period_to=$data['fix_asset']['warranty_period_to'];
	$warranty_period_from=$data['fix_asset']['warranty_period_from'];
	$maintanance_schedule=$data['fix_asset']['maintanance_schedule'];
	
	$result_ledger_account = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_account_fetch2'),array('pass'=>array($asset_category_id)));
	foreach($result_ledger_account as $collection)
	{
	$asset_category_name = $collection['ledger_account']['ledger_name'];
	}
	$result_ledger_sub_account = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($asset_supplier_id)));
	foreach($result_ledger_sub_account as $collection)
	{
	$asset_supplier_name = $collection['ledger_sub_account']['name'];
	}
	
?>
<tr>
<td><?php echo $fix_receipt_id; ?></td>
<td><?php echo $asset_category_name; ?></td>
<td><?php echo $asset_name; ?></td>
<td><?php echo $description; ?></td>
<td><?php echo $purchase_date; ?></td>
<td><?php echo $ammount; ?></td>
<td align="right"><?php echo $amount; ?><?php $total_amount+=$amount; ?></td>
<td><?php echo $asset_supplier_name; ?></td>
<td><?php echo $warranty_period_from; ?></td>
<td><?php echo $warranty_period_to; ?></td>
<td><?php echo $maintanance_schedule; ?></td>
</tr>
<?php } ?>
<tr>
<td colspan="5" align="right"> <b>Total</b> </td>
<td align="right"><b><?php echo $total_amount; ?></b></td><td></td><td></td><td></td><td></td>
</tr>
</tbody>
</table>

