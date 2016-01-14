<style>
#report_tb th{
	font-size: 10px !important;background-color:#C8EFCE;padding:2px;border:solid 1px #55965F;
}
#report_tb td{
	padding:2px;
	font-size: 12px;border:solid 1px #55965F;background-color:#FFF;
}
</style>
<?php /////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<?php
$bbb = 55;

           if($wise == 3)
		   {
		   $cursor = $cursor2;   
		   }
		   else
		   {
		   $cursor = $cursor1;   
		   }

			foreach($cursor as $data3){
			$auto_id=$data3["new_regular_bill"]["auto_id"];
			$flat_id=$data3["new_regular_bill"]["flat_id"];
			$bill_no=(int)$data3["new_regular_bill"]["bill_no"];
			$income_head_array=$data3["new_regular_bill"]["income_head_array"];
			$noc_charges=$data3["new_regular_bill"]["noc_charges"];
			$other_charges_array=$data3["new_regular_bill"]["other_charges_array"];
			$total=$data3["new_regular_bill"]["total"];
			$arrear_maintenance=$data3["new_regular_bill"]["arrear_maintenance"];
			$arrear_intrest=$data3["new_regular_bill"]["arrear_intrest"];
			$intrest_on_arrears=$data3["new_regular_bill"]["intrest_on_arrears"];
			$due_for_payment=$data3["new_regular_bill"]["due_for_payment"];
			$bill_start_date = $data3['new_regular_bill']['bill_start_date'];
		
			//wing_id via flat_id//
			$result_flat_info=$this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($flat_id)));
			foreach($result_flat_info as $flat_info){
			$wing_id=$flat_info["flat"]["wing_id"];
			}
			
			$wing_flat=$this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat_with_brackets'), array('pass' => array($wing_id,$flat_id))); 
			
			//user info via flat_id//
			$result_user_info=$this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_user_info_via_flat_id'),array('pass'=>array($wing_id,$flat_id)));
			foreach($result_user_info as $user_info){
				$user_name=$user_info["user"]["user_name"];
				$bill_for_user = $user_info["user"]["user_id"];
			}
		
		$result_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'flat_fetch2'),array('pass'=>array(@$flat_id,$wing_id))); 
		foreach($result_flat as $data2){
		$flat_type_id = (int)$data2['flat']['flat_type_id'];
		$noc_ch_id = (int)@$data2['flat']['noc_ch_tp'];
		$sq_feet = (int)$data2['flat']['flat_area'];
		}

if($wise == 2)
{									
if($flat_id == $user_id)
{
$bbb = 555;
}
}
else if($wise == 1)
{
if($wing_id == $wing)
{	

$bbb = 555;

}
}
}
if($wise == 3)
{
//////////////
foreach($cursor2 as $data3)
{
$bbb = 555;	
}
}
?>
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<?php 
if($bbb == 555)
{
?>
<div style="width:100%;" class="hide_at_print">
<span style="margin-left:80%;">
<?php
if($wise == 1)
{
?>
<a href="regular_bill_excel?w=<?php echo $wise; ?>&u=<?php echo $wing; ?>" class="btn blue mini"><i class="icon-download"></i></a>
<?php
}
if($wise == 2)
{
?>
<a href="regular_bill_excel?w=<?php echo $wise; ?>&u=<?php echo $user_id; ?>" class="btn blue mini"><i class="icon-download"></i></a>
<?php	
}
?>
<a type="button" class=" printt btn green mini" onclick="window.print()"><i class="icon-print"></i></a></span>
</div>

<div style="width:100%; overflow:auto; margin-top:10px;" class="hide_at_print">
<label class="m-wrap pull-right"><input type="text" id="search" class="m-wrap medium" style="background-color:#FFF !important;" placeholder="Search"></label>	
</div>

<table id="report_tb">
<thead>
<tr>
<th>Unit Number</th>
<th>Name</th>
<th>Area <?php if($valllll == 0){ ?>(sq. feet)<?php } else { ?>(sq. mtr)<?php } ?></th>
<th>Bill No.</th>
<?php 


	if(!empty($income_head_array)){
	
$tttt = array();
foreach(@$income_head_array as $income_head=>$value){ 
			$result_income_head = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_account_fetch2'),array('pass'=>array($income_head)));	
			foreach($result_income_head as $data2){
				$income_head_name = $data2['ledger_account']['ledger_name'];
			} 
			$tttt[] = 0;
			?>
            
			<th><?php echo $income_head_name; ?></th>	
<?php } } ?>
<th>Non Occupancy charges</th>

<?php 
			if(sizeof(@$other_charges_ids)>0){
				foreach($other_charges_ids as $other_charges_id){
					$result_income_head = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_account_fetch2'),array('pass'=>array($other_charges_id)));	
						foreach($result_income_head as $data2){
							$income_head_name = $data2['ledger_account']['ledger_name'];
						}
					?>
					<th><?php echo $income_head_name; ?></th>
					<?php
				} 
			}
			?>

<th>Total</th>
<th>Arrears-Principal</th>
<th>Arrears-Interest</th>
<th>Interest on Arrears</th>
<th>Credit/Rebates</th>
<th>Due For Payment</th>
<th>View|Pdf</th>
</tr>
</thead>
<tbody id="table">
<?php
$noc_tt = 0;
$total_tt = 0;
$Arrears_Principal = 0;
$Arrears_Interest = 0;
$Interest_on_Arrears = 0;
$Credit_Rebates = 0;
$Due_for_Payment = 0;
foreach($cursor1 as $data3){
			$auto_id=$data3["new_regular_bill"]["auto_id"];
			$flat_id=$data3["new_regular_bill"]["flat_id"];
			$bill_no = $data3["new_regular_bill"]["bill_no"];
			$income_head_array=$data3["new_regular_bill"]["income_head_array"];
			$noc_charges=$data3["new_regular_bill"]["noc_charges"];
			$other_charges_array=$data3["new_regular_bill"]["other_charges_array"];
			$total=$data3["new_regular_bill"]["total"];
			$arrear_maintenance=$data3["new_regular_bill"]["arrear_maintenance"];
			$arrear_intrest=$data3["new_regular_bill"]["arrear_intrest"];
			$intrest_on_arrears=$data3["new_regular_bill"]["intrest_on_arrears"];
			$due_for_payment=$data3["new_regular_bill"]["due_for_payment"];
			$bill_start_date = $data3['new_regular_bill']['bill_start_date'];
		    $credit_stock=$data3["new_regular_bill"]["credit_stock"];
			//wing_id via flat_id//
			$result_flat_info=$this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($flat_id)));
			foreach($result_flat_info as $flat_info){
				$wing_id=$flat_info["flat"]["wing_id"];
			}
			
			$wing_flat=$this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat_new'), array('pass' => array($wing_id,$flat_id))); 
			
			//user info via flat_id//
			$result_user_info=$this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_user_info_via_flat_id'),array('pass'=>array($wing_id,$flat_id)));
			foreach($result_user_info as $user_info){
				$user_name=$user_info["user"]["user_name"];
				$bill_for_user = $user_info["user"]["user_id"];
			}
		
		$result_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'flat_fetch2'),array('pass'=>array(@$flat_id,$wing_id))); 
		foreach($result_flat as $data2){
		$flat_type_id = (int)$data2['flat']['flat_type_id'];
		$noc_ch_id = (int)@$data2['flat']['noc_ch_tp'];
		$sq_feet = (int)$data2['flat']['flat_area'];
		}


if($wise == 2)
{	
if($flat_id == $user_id)
{
?>
<tr>
<td><?php echo $wing_flat; ?></td>
<td><?php echo $user_name; ?></td>
<td><?php echo $sq_feet; ?></td>
<td><?php echo $bill_no; ?></td>
<?php 
$nn=0;
foreach($income_head_array as $income_head=>$value){ 
			 ?>
			<td style="text-align:right;"><?php 
			$tttt[$nn] = $tttt[$nn] +@$value;
			echo @$value; ?></td>	
			<?php 
			$nn++;
			} ?>
<td><?php echo $noc_charges; ?></td>

<?php 
			if(sizeof(@$other_charges_ids)>0){
				foreach(@$other_charges_ids as $other_charges_id){
					?>
					<td style="text-align:right;"><?php echo @(int)$other_charges_array[$other_charges_id]; ?></td>
					<?php
				} 
			}?>
			

<td style="text-align:right;"><?php echo $total; ?></td>
<td style="text-align:right;"><?php echo $arrear_maintenance; ?></td>
<td style="text-align:right;"><?php echo $arrear_intrest; ?></td>
<td style="text-align:right;"><?php echo $intrest_on_arrears; ?></td>
<td style="text-align:right;"><?php echo $credit_stock; ?></td>
<td style="text-align:right;"><?php echo $due_for_payment; ?></td>
<td>
<div class="btn-group">
<a class="btn blue mini" href="#" data-toggle="dropdown">
<i class="icon-chevron-down"></i>	
</a><ul class="dropdown-menu" style="min-width:80px !important;">
<li>
<a href="regular_bill_view/<?php echo $auto_id; ?>" target="_blank"><i class="icon-search"></i> View</a>
</li>
</ul>
</div>

<!--<a href="regular_bill_pdf/<?php //echo $auto_id; ?>" class="btn mini blue"><i class="icon-edit"></i></a>-->

</td>
</tr>
<?php 
$noc_tt = $noc_tt + $noc_charges;
$total_tt = $total_tt + $total; 
$Arrears_Principal = $Arrears_Principal + $arrear_maintenance;
$Arrears_Interest = $Arrears_Interest + $arrear_intrest;
$Interest_on_Arrears = $Interest_on_Arrears + $intrest_on_arrears;
$Credit_Rebates = $Credit_Rebates + $credit_stock; 
$Due_for_Payment = $Due_for_Payment + $due_for_payment;
}
}
else if($wise == 1)
{
if($wing_id == $wing)
{	
?>	
<tr>
<td><?php echo $wing_flat; ?></td>
<td><?php echo $user_name; ?></td>
<td><?php echo $sq_feet; ?></td>
<td><?php echo $bill_no; ?></td>
<?php 
$nn = 0;
foreach($income_head_array as $income_head=>$value){ 
			 ?>
			<td style="text-align:right;"><?php
			$tttt[$nn] = $tttt[$nn] +@$value;
			 echo @$value; ?></td>	
			<?php 
			$nn++;
			} ?>
<td style="text-align:right;"><?php echo $noc_charges; ?></td>
<td style="text-align:right;"><?php echo $total; ?></td>
<td style="text-align:right;"><?php echo $arrear_maintenance; ?></td>
<td style="text-align:right;"><?php echo $arrear_intrest; ?></td>
<td style="text-align:right;"><?php echo $intrest_on_arrears; ?></td>
<td style="text-align:right;"><?php echo $credit_stock; ?></td>
<td style="text-align:right;"><?php echo $due_for_payment; ?></td>
<td>
<div class="btn-group">
<a class="btn blue mini" href="#" data-toggle="dropdown">
<i class="icon-chevron-down"></i>	
</a><ul class="dropdown-menu" style="min-width:80px !important;">
<li><a href="regular_bill_view/<?php echo $auto_id; ?>" target="_blank"><i class="icon-search"></i> View</a></li>
</ul>
</div>
</td>
</td>
</tr>	
<?php 	
$noc_tt = $noc_tt + $noc_charges;
$total_tt = $total_tt + $total; 
$Arrears_Principal = $Arrears_Principal + $arrear_maintenance;
$Arrears_Interest = $Arrears_Interest + $arrear_intrest;
$Interest_on_Arrears = $Interest_on_Arrears + $intrest_on_arrears;
$Credit_Rebates = $Credit_Rebates + $credit_stock; 
$Due_for_Payment = $Due_for_Payment + $due_for_payment;

}
}

}
if($wise == 3)
{
////////////////////////////////////

foreach($cursor2 as $data3){
$auto_id=$data3["new_regular_bill"]["auto_id"];
$flat_id=$data3["new_regular_bill"]["flat_id"];
$bill_no=$data3["new_regular_bill"]["bill_no"];
$income_head_array=$data3["new_regular_bill"]["income_head_array"];
$noc_charges=$data3["new_regular_bill"]["noc_charges"];
$total=$data3["new_regular_bill"]["total"];
$arrear_maintenance=$data3["new_regular_bill"]["arrear_maintenance"];
$arrear_intrest=$data3["new_regular_bill"]["arrear_intrest"];
$intrest_on_arrears=$data3["new_regular_bill"]["intrest_on_arrears"];
$due_for_payment=$data3["new_regular_bill"]["due_for_payment"];
$bill_start_date = $data3['new_regular_bill']['bill_start_date'];
 $credit_stock=$data3["new_regular_bill"]["credit_stock"];
//wing_id via flat_id//
$result_flat_info=$this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($flat_id)));
foreach($result_flat_info as $flat_info){
$wing_id=$flat_info["flat"]["wing_id"];
}
$wing_flat=$this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat_new'), array('pass' => array($wing_id,$flat_id))); 

//user info via flat_id//
$result_user_info=$this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_user_info_via_flat_id'),array('pass'=>array($wing_id,$flat_id)));
foreach($result_user_info as $user_info){
$user_name=$user_info["user"]["user_name"];
$bill_for_user = $user_info["user"]["user_id"];
}

$result_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'flat_fetch2'),array('pass'=>array(@$flat_id,$wing_id))); 
foreach($result_flat as $data2){
$flat_type_id = (int)$data2['flat']['flat_type_id'];
$noc_ch_id = (int)@$data2['flat']['noc_ch_tp'];
$sq_feet = (int)$data2['flat']['flat_area'];
}
	
?>
<tr>
<td><?php echo $wing_flat; ?></td>
<td><?php echo $user_name; ?></td>
<td><?php echo $sq_feet; ?></td>
<td><?php echo $bill_no; ?></td>
<?php
$nn = 0;
foreach($income_head_array as $income_head=>$value){ 
?>
<td style="text-align:right;"><?php
$tttt[$nn] = $tttt[$nn] +@$value;
 echo @$value; ?></td>	
<?php $nn++; } ?>
<td style="text-align:right;"><?php echo $noc_charges; ?></td>
<td style="text-align:right;"><?php echo $total; ?></td>
<td style="text-align:right;"><?php echo $arrear_maintenance; ?></td>
<td style="text-align:right;"><?php echo $arrear_intrest; ?></td>
<td style="text-align:right;"><?php echo $intrest_on_arrears; ?></td>
<td style="text-align:right;"><?php echo $credit_stock; ?></td>
<td style="text-align:right;"><?php echo $due_for_payment; ?></td>
<td>

<div class="btn-group">
<a class="btn blue mini" href="#" data-toggle="dropdown">
<i class="icon-chevron-down"></i>	
</a><ul class="dropdown-menu" style="min-width:80px !important;">
<li>
<a href="regular_bill_view/<?php echo $auto_id; ?>" target="_blank"><i class="icon-search"></i> View</a>
</li>
</ul>
</div>


<!--<a href="regular_bill_pdf/<?php echo $auto_id; ?>" target="_blank"  class="btn mini blue"><i class="icon-edit"></i></a>-->

</td>
</tr>
<?php
$noc_tt = $noc_tt + $noc_charges;
$total_tt = $total_tt + $total; 
$Arrears_Principal = $Arrears_Principal + $arrear_maintenance;
$Arrears_Interest = $Arrears_Interest + $arrear_intrest;
$Interest_on_Arrears = $Interest_on_Arrears + $intrest_on_arrears;
$Credit_Rebates = $Credit_Rebates + $credit_stock; 
$Due_for_Payment = $Due_for_Payment + $due_for_payment;
}
}

?>
<tr>
<td colspan="4" style="text-align:right;"><b>Grand Total</b></td>
<?php
foreach($tttt as $dataaaaa)
{
?>
<td style="text-align:right;">
<b>
<?php echo $dataaaaa; ?>
</b>
</td>
<?php } ?>
<td style="text-align:right;">
<b>
<?php echo $noc_tt; ?>
</b>
</td>
<td style="text-align:right;">
<b>
<?php echo $total_tt; ?>
</b>
</td>
<td class="hide_at_print">
<b>
<?php echo $Arrears_Principal; ?>
</b>
</td>
<td style="text-align:right;">
<b>
<?php echo $Arrears_Interest; ?>
</b>
</td>
<td style="text-align:right;">
<b>
<?php echo $Interest_on_Arrears; ?>
</b>
</td>
<td style="text-align:right;">
<b>
<?php echo $Credit_Rebates; ?>
</b>
</td>
<td style="text-align:right;"><b>
<?php echo $Due_for_Payment; ?></b>
</td>
<td style="text-align:right;"></td>

</tr>
</tbody>
</table>
<?php 
}
if($bbb == 55)
{
?>
<br /><br />
<center>
<h3>No bills raised.</h3>
</center>
<br /><br />
<?php
}
?>

<script>
		 var $rows = $('#table tr');
		 $('#search').keyup(function() {
			var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
			
			$rows.show().filter(function() {
				var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
				return !~text.indexOf(val);
			}).hide();
		});
 </script>	