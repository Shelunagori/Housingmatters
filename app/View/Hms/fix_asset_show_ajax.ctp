<?php
$m_from = date("Y-m-d", strtotime($from));
$m_from = new MongoDate(strtotime($m_from));

$m_to = date("Y-m-d", strtotime($to));
$m_to = new MongoDate(strtotime($m_to));
?>
<?php /////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<?php
$bbb = 55;
foreach ($cursor1 as $collection) 
{
$auto_id = (int)$collection['fix_asset']['auto_id'];		
$asset_category_id = (int)$collection['fix_asset']['asset_category_id'];
$asset_name = $collection['fix_asset']['asset_name'];
$narration = $collection['fix_asset']['narration'];
$purchase_date = $collection['fix_asset']['purchase_date'];
$purchase_cost = $collection['fix_asset']['purchase_cost'];
$supplier = (int)$collection['fix_asset']['supplier'];
$warranty_period_from = $collection['fix_asset']['warranty_period_from'];
$warranty_period_to = $collection['fix_asset']['warranty_period_to'];
$schedule = $collection['fix_asset']['schedule'];
if(!empty($warranty_period_from) and !empty($warranty_period_to)) 
{
$warranty_period_from= date('d-m-Y', $warranty_period_from->sec);
$warranty_period_to= date('d-m-Y', $warranty_period_to->sec);
}
else
{
$warranty_period_from = "";
$warranty_period_to = "";	
}
$asset_category_fetch = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_amount'),array('pass'=>array($asset_category_id)));										
foreach ($asset_category_fetch as $collection) 
{
$asset_category = $collection['ledger_account']['ledger_name'];
}
$supply = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($supplier)));									
foreach ($supply as $collection) 
{
$supplier_name = $collection['ledger_sub_account']['name'];
}
if($purchase_date >= $m_from && $purchase_date <= $m_to)
{
$bbb = 555;
}
}
?>
<?php /////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<?php
if($bbb == 555)
{
?>
<table class="table table-bordered" style="width:100%; background-color:white;">
<tr>
<th>From : <?php echo $from; ?></th>
<th>To : <?php echo $to; ?></th>
<th colspan=""></th>
</tr>
<tr>
<th>Sr.No.</th>
<th>Asset Category</th>
<th>Asset Name</th>
<th>Narration</th>
<th>Date of Purchase</th>
<th>Cost of Purchase</th>
<th>Supplier</th>
<th>Warranty Period From</th>
<th>Warranty Period From</th>
<th>Maintanance Schedule</th>
<th width="10%">Action</th>
</tr>
<?php
foreach ($cursor1 as $collection) 
{
$auto_id = (int)$collection['fix_asset']['auto_id'];		
$asset_category_id = (int)$collection['fix_asset']['asset_category_id'];
$asset_name = $collection['fix_asset']['asset_name'];
$narration = $collection['fix_asset']['narration'];
$purchase_date = $collection['fix_asset']['purchase_date'];
$purchase_cost = $collection['fix_asset']['purchase_cost'];
$supplier = (int)$collection['fix_asset']['supplier'];
$warranty_period_from = $collection['fix_asset']['warranty_period_from'];
$warranty_period_to = $collection['fix_asset']['warranty_period_to'];
$schedule = $collection['fix_asset']['schedule'];
if(!empty($warranty_period_from) and !empty($warranty_period_to)) 
{
$warranty_period_from= date('d-m-Y', $warranty_period_from->sec);
$warranty_period_to= date('d-m-Y', $warranty_period_to->sec);
}
else
{
$warranty_period_from = "";
$warranty_period_to = "";	
}
$asset_category_fetch = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_amount'),array('pass'=>array($asset_category_id)));										
foreach ($asset_category_fetch as $collection) 
{
$asset_category = $collection['ledger_account']['ledger_name'];
}
$supply = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($supplier)));									
foreach ($supply as $collection) 
{
$supplier_name = $collection['ledger_sub_account']['name'];
}
if($purchase_date >= $m_from && $purchase_date <= $m_to)
{
$purchase_date = date('d-m-Y',$purchase_date->sec);	
?>
<tr>
<td><?php echo $auto_id; ?></td>	
<td><?php echo $asset_category; ?></td>	
<td><?php echo $asset_name; ?></td>	
<td><?php echo $narration; ?></td>	
<td><?php echo $purchase_date; ?></td>	
<td><?php echo $purchase_cost; ?></td>	
<td><?php echo $supplier_name; ?></td>	
<td><?php echo $warranty_period_from; ?></td>	
<td><?php echo $warranty_period_to; ?></td>	
<td><?php echo $schedule  ?></td>	
<td><a href="#myModal<?php echo $auto_id; ?>" class="btn mini blue" data-toggle="modal">Current Rs.</a></td>		
</tr>
<?php }} ?>
</table>
							
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>

<?php foreach ($cursor2 as $collection) 
{
$auto_id = (int)$collection['fix_asset']['auto_id'];		    
$asset_category_id = (int)$collection['fix_asset']['asset_category_id']; 
$purchase_cost = $collection['fix_asset']['purchase_cost'];
$purchase_date = $collection['fix_asset']['purchase_date'];
$current_date = date("Y-m-d");
$date1 = date('Y-m-d',$purchase_date->sec);
$date1 = date(strtotime($date1));
$date2 = date(strtotime($current_date));
$difference = $date2 - $date1;
$months = floor($difference / 86400 / 30 );
                    
									
$asset_category_fetch2 = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_amount'),array('pass'=>array($asset_category_id)));									
foreach ($asset_category_fetch2 as $collection) 
{
$rate = (int)$collection['ledger_account']['rate'];
}
$one_year_dep = round(($rate/100) * $purchase_cost);
$one_month_dep = round($one_year_dep/12);
$total_dep = round($one_month_dep * $months);
$current_rs = round($purchase_cost - $total_dep); 
?>
<!-------------------- Popup box ----------------->
<div id="myModal<?php echo $auto_id; ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="false">
<div class="modal-header">
<center>
<h3 id="myModalLabel2">Depriciation Rs.</h3>
</center>
</div>
<div class="modal-body">
<center>
<h4>Current Rs. : <?php echo $current_rs; ?></h4>
</center>	
</div>
<div class="modal-footer">
<button data-dismiss="modal" class="btn green">OK</button>
</div>
</div>
<?php } ?>                                
<!--------------------Popup-----------------------> 

<?php
}
if($bbb == 55)
{
?>
<br /><br />
<center>
<h3 style="color:red;"><b>No Record Found in Selected Period</b></h3>
</center>
<br /><br />

<?php 
}
?>