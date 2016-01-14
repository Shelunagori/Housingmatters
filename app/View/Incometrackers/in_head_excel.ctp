<?php
$filename="".$socc_namm."_Bill_Report";
header ("Expires: 0");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=".$filename.".xls");
header ("Content-Description: Generated Report" );
?>

<?php
foreach($result_society as $data){
$income_heads=$data["society"]["income_head"];
$vallllll = (int)@$data["society"]["area_scale"];

}
foreach($result_new_regular_bill as $regular_bill){
$income_head_array=$regular_bill["new_regular_bill"]["income_head_array"];
}
?>




<table border="1">
	<thead>
		<tr>
			<th>Unit Number</th>
			<th>Name</th>
			<th>Area <?php if($vallllll == 0) { ?>(sq. feet)<?php } else {?> (sq. mtr) <?php } ?></th>
			<th>Bill No.</th>
			<?php foreach($income_head_array as $income_head=>$value){ 
			$result_income_head = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_account_fetch2'),array('pass'=>array($income_head)));	
			foreach($result_income_head as $data2){
				$income_head_name = $data2['ledger_account']['ledger_name'];
			} ?>
			<th><?php echo $income_head_name; ?></th>	
			<?php } ?>
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
			}?>
			<th>Total</th>
			<th>Arrears-Principal</th>
			<th>Arrears-Interest</th>
			<th>Interest on Arrears</th>
			<th>Credit/Rebates</th>
			<th>Due For Payment</th>
			</tr>
	</thead>
	<tbody>
<?php
$total_noc_charges=0; $total_total=0; $total_arrear_maintenance=0; $total_arrear_intrest=0; $total_intrest_on_arrears=0; $total_credit_stock=0; $total_due_for_payment=0;
foreach($result_new_regular_bill as $regular_bill){
	$id=$regular_bill["new_regular_bill"]["id"];
	$auto_id=$regular_bill["new_regular_bill"]["auto_id"];
	$one_time_id=$regular_bill["new_regular_bill"]["one_time_id"];
	$bill_start_date=$regular_bill["new_regular_bill"]["bill_start_date"];
	$bill_end_date=$regular_bill["new_regular_bill"]["bill_end_date"];
	$flat_id=$regular_bill["new_regular_bill"]["flat_id"];
	$bill_no = $regular_bill["new_regular_bill"]["bill_no"];
	$income_head_array=$regular_bill["new_regular_bill"]["income_head_array"];
	$other_charges_array=$regular_bill["new_regular_bill"]["other_charges_array"];
	$noc_charges=$regular_bill["new_regular_bill"]["noc_charges"];
	$total=$regular_bill["new_regular_bill"]["total"];
	$arrear_maintenance=$regular_bill["new_regular_bill"]["arrear_maintenance"];
	$arrear_intrest=$regular_bill["new_regular_bill"]["arrear_intrest"];
	$intrest_on_arrears=$regular_bill["new_regular_bill"]["intrest_on_arrears"];
	$due_for_payment=$regular_bill["new_regular_bill"]["due_for_payment"];
	$credit_stock=$regular_bill["new_regular_bill"]["credit_stock"];
	
	
	
	//wing_id via flat_id//
	$result_flat_info=$this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($flat_id)));
	foreach($result_flat_info as $flat_info){
		$wing_id=$flat_info["flat"]["wing_id"];
	}
	
	$wing_flat=$this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'), array('pass' => array($wing_id,$flat_id)));
	
	//user info via flat_id//
	$result_user_info=$this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_user_info_via_flat_id'),array('pass'=>array($wing_id,$flat_id)));
	foreach($result_user_info as $user_info){
		$user_name=$user_info["user"]["user_name"];
	}
	
	$result_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'flat_fetch2'),array('pass'=>array(@$flat_id,$wing_id))); 
	foreach($result_flat as $data2){
		$flat_type_id = (int)$data2['flat']['flat_type_id'];
		$noc_ch_id = (int)@$data2['flat']['noc_ch_tp'];
		$sq_feet = (int)$data2['flat']['flat_area'];
	}
	
	
	$bill_no_ex = explode("-", $bill_no);
	if(sizeof($bill_no_ex)>1){
		$edit_by=@$regular_bill["new_regular_bill"]["edit_by"];
		
		//fetch edit_by info//
		$result_edit_by=$this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'), array('pass' => array($edit_by)));
		foreach ($result_edit_by as $edit_by_info){
			$edit_by_user_name=@$edit_by_info["user"]["user_name"];
			$edit_by_wing=@$edit_by_info["user"]["wing"];
			$edit_by_flat=@$edit_by_info["user"]["flat"];
		}
		$edit_by_wing_flat=$this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'), array('pass' => array(@$edit_by_wing,@$edit_by_flat))); 
	}
	
	?>
	<tr>
		<td><?php echo $wing_flat; ?></td>
		<td><?php echo $user_name; ?></td>
		<td><?php echo $sq_feet; ?></td>
		<td>
			<?php echo $bill_no; 
			if(sizeof($bill_no_ex)>1){
				echo'<br/><a href="#" role="button" class="tooltips" data-placement="right" data-original-title="'.@$edit_by_user_name.@$edit_by_wing_flat.'">Edited By</a>';
			}?>
		</td>
		<?php  foreach($income_head_array as $income_head=>$value){ 
			$total_income_heads[$income_head][]=$value;
		 ?>
		<td><?php echo $value; ?></td>	
		<?php } ?>
		<td><?php echo $noc_charges; $total_noc_charges+=$noc_charges; ?></td>
		<?php 
			if(sizeof(@$other_charges_ids)>0){
				foreach(@$other_charges_ids as $other_charges_id){
					$total_other_charges[$other_charges_id][]=@(int)$other_charges_array[$other_charges_id];
					?>
					<td><?php echo @(int)$other_charges_array[$other_charges_id]; ?></td>
					<?php
				} 
			} ?>
		<td><?php echo $total; $total_total+=$total; ?></td>
		<td><?php echo $arrear_maintenance; $total_arrear_maintenance+=$arrear_maintenance; ?></td>
		<td><?php echo $arrear_intrest; $total_arrear_intrest+=$arrear_intrest; ?></td>
		<td><?php echo $intrest_on_arrears; $total_intrest_on_arrears+=$intrest_on_arrears; ?></td>
		<td><?php echo $credit_stock; $total_credit_stock+=$credit_stock; ?></td>
		<td><?php echo $due_for_payment; $total_due_for_payment+=$due_for_payment; ?></td>
	</tr>
		
	<?php
}
?>
	</tbody>
	<tr>
			<td colspan="4" align="right"><b>Total<b/></td>
			
			<?php foreach($income_head_array as $income_head=>$value){ $total_income_heads_am=0;
				foreach($total_income_heads[$income_head] as $data5){
					$total_income_heads_am+=$data5;
				}
			 ?>
			<td><b><?php echo $total_income_heads_am; ?></b></td>	
			<?php }   ?>
			<td><b><?php echo $total_noc_charges; ?></b></td>
			
			<?php 
			if(sizeof(@$other_charges_ids)>0){
				foreach($other_charges_ids as $other_charges_id){ $total_other_charges_am=0;
					foreach($total_other_charges[$other_charges_id] as $data6){
						$total_other_charges_am+=$data6;
					}
					?>
					<td><b><?php echo $total_other_charges_am; ?></b></td>
					<?php
				} 
			}?>
			<td><b><?php echo $total_total; ?></b></td>
			<td><b><?php echo $total_arrear_maintenance; ?></b></td>
			<td><b><?php echo $total_arrear_intrest; ?></b></td>
			<td><b><?php echo $total_intrest_on_arrears; ?></b></td>
			<td><b><?php echo $total_credit_stock; ?></b></td>
			<td><b><?php echo $total_due_for_payment; ?></b></td>
			</tr>
</table>