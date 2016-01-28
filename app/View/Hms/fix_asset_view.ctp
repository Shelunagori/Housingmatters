<?php
$current_date = date('d-m-Y');
?>

<div class="hide_at_print">
<center>
<a href="<?php echo $webroot_path; ?>Hms/fix_asset_add" class="btn blue" rel='tab'>Add</a>
<a href="<?php echo $webroot_path; ?>Hms/fix_asset_view" class="btn red" rel='tab'>View</a>
</center>
</div>

<style>
#tbb th{
	font-size: 10px !important;background-color:#C8EFCE;padding:2px;border:solid 1px #55965F;white-space: nowrap !important; 
}
#tbb td{
	padding:2px;
	font-size: 12px;border:solid 1px #55965F;background-color:#FFF;white-space: nowrap !important; 
}
.text_bx{
	width: 50px;
	height: 15px !important;
	margin-bottom: 0px !important;
	font-size: 12px;
}
.text_rdoff{
	width: 50px;
	height: 15px !important;
	border: none !important;
	margin-bottom: 0px !important;
	font-size: 12px;
}
</style>




<div style="">

<div align="right" class="hide_at_print">
<a href="fix_asset_excel" class="btn blue mini"><i class="icon-download"></i></a>
<a  class="btn green mini" onclick="window.print()" ><i class="icon-print"></i></a>

</div>
</div>
<div style="width:100%; overflow:auto; margin-top:10px;" class="hide_at_print">
<label class="m-wrap pull-right"><input type="text" id="search" class="m-wrap medium" style="background-color:#FFF !important;" placeholder="Search"></label>	
</div>	


<table class="" style="" id="tbb" width="100%" style=" background-color:white;">
<thead>
<tr>
<td colspan="11" align="center"><span style="font-size:14px;"><b><?php echo $society_name; ?> Fixed Assets Register on <?php echo $current_date; ?></b></span></td>
</tr>
<tr>
<th >Sr.No.</th>
<th>Asset Category</th>
<th>Asset Name</th>
<th>Narration</th>
<th width="5%">Date of Purchase</th>
<th>Cost of Purchase</th>
<th>Supplier</th>
<th>Warranty From</th>
<th>Warranty To</th>
<th>Maintanance Schedule</th>
<th>Action</th>
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
	$file = @$data['fix_asset']['file_name'];
	$amount=$data['fix_asset']['cost_of_purchase'];
	$warranty_period_to=$data['fix_asset']['warranty_period_to'];
	$warranty_period_from=$data['fix_asset']['warranty_period_from'];
	$maintanance_schedule=$data['fix_asset']['maintanance_schedule'];
	$prepaired_by_id = (int)$data['fix_asset']['user_id'];
	$current_date22 = $data['fix_asset']['current_date'];
	$user_detaill = $this->requestAction(array('controller' => 'hms', 'action' => 'user_fetch'),array('pass'=>array($prepaired_by_id)));
foreach($user_detaill as $data)
{
$prepaired_by = $data['user']['user_name'];
}
	
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

<td align="right"><?php echo $amount; ?><?php $total_amount+=$amount; ?></td>

<td><?php echo @$asset_supplier_name; ?></td>
<td><?php echo $warranty_period_from; ?></td>
<td><?php echo $warranty_period_to; ?></td>
<td><?php echo $maintanance_schedule; ?></td>
<td><?php if(!empty($file)){ ?><a href="<?php echo $webroot_path ; ?>/fix_assets/<?php echo $file; ?>" target="_blank" class=""  download="download"> <i class=" icon-download-alt"></i> </a> <?php } ?>
<i class="icon-info-sign tooltips" data-placement="left" data-original-title="Created by: <?php echo $prepaired_by; ?> on: <?php echo $current_date22; ?>">
  </i>
</td>
</tr>
<?php } ?>
<tr>
<td colspan="5" align="right"> <b>Total</b> </td>
<td align="right"><b><?php echo $total_amount; ?></b></td><td></td><td></td><td></td><td></td><td></td>
</tr>
</tbody>
</table>

<script>
		 var $rows = $('#count_row tr');
		 $('#search').keyup(function() {
			var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
			
			$rows.show().filter(function() {
				var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
				return !~text.indexOf(val);
			}).hide();
		});
 </script>		
 
 
 
 <script>
$(document).ready(function() {
<?php	
$status5=(int)$this->Session->read('fix_assset');
if($status5==1)
{
?>
$.gritter.add({
title: 'Fixed Assets',
text: '<p>Thank you.</p><p>Fixed Assets Generated successfully</p>',
sticky: false,
time: '10000',
});
<?php
$this->requestAction(array('controller' => 'hms', 'action' => 'griter_notification'), array('pass' => array(1701)));
} ?>
});
</script>  
 
 
 
 <script>
$(document).ready(function() {
<?php	
$status5=(int)$this->Session->read('fix_asst');
if($status5==1)
{
?>
$.gritter.add({
title: 'Fixed Assets',
text: '<p>Thank you.</p><p>The Fixed Assets generated successfully.</p>',
sticky: false,
time: '10000',
});
<?php
$this->requestAction(array('controller' => 'hms', 'action' => 'griter_notification'), array('pass' => array(5514)));
} ?>
});
</script>
 
 
 
 
 