<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu_as_per_role_privilage'), array('pass' => array()));
?>	
<script>
$(document).ready(function() {
$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>
<style>
th{
	font-size: 10px !important;background-color:#FCE4BF;
}
th,td{
	padding:2px;
	font-size: 12px;border:solid 1px #FFB848; height:20px;
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
<?php 
foreach($result_society as $data){
	$income_heads=$data["society"]["income_head"];
}

if(sizeof($result_new_regular_bill)==0){
		echo '<div align="center"><h4>No bill is pending for approval.</h4></div>'; exit;
	}
?>
<span class="label label-info pull-right" style="padding:2px; ">Bill Period: <?php echo $bill_start_d;?> to <?php echo $bill_end_date; ?> </span>
<div> </div>
<form method="post" >
<div class="portlet-body" style="background-color: #fff; overflow-x: auto;overflow-y:hidden;" align="center">

<table >
	<thead>
		<tr>
			<th width="100px">Unit Number</th>
			<th width="40px">Name</th>
			<th width="40px">Area (sq. feet)</th>
			<th width="70px">Bill No.</th>
			<?php foreach($income_heads as $income_head){ 
			$result_income_head = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_account_fetch2'),array('pass'=>array($income_head)));	
			foreach($result_income_head as $data2){
				$income_head_name = $data2['ledger_account']['ledger_name'];
			} ?>
			<th><?php echo $income_head_name; ?></th>	
			<?php } ?>
			<th width="170px">Non Occupancy charges</th>
			
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
			
			<th width="50px">Total</th>
			<th width="120px">Arrears-Principal</th>
			<th width="120px">Arrears-Interest</th>
			<th width="120px">Interest on Arrears </th>
			<th>Credit/Adjustment</th>
			<th width="120px">Due For Payment</th>
			<th><input style="opacity: 0;" value="" type="checkbox" id="select_all" onclick="select_all_check()"></th>
		</tr>
	</thead>
	<tbody>
	<?php 
	
	$total_noc_charges=0; $total_total=0; $total_arrear_maintenance=0; $total_arrear_intrest=0; $total_intrest_on_arrears=0; $total_credit_stock=0; $total_due_for_payment=0;
	if(sizeof($result_new_regular_bill)>0){
		foreach($result_new_regular_bill as $data3){
			$auto_id=$data3["new_regular_bill"]["auto_id"];
			$flat_id=$data3["new_regular_bill"]["flat_id"];
			$bill_no=$data3["new_regular_bill"]["bill_no"];
			$income_head_array=$data3["new_regular_bill"]["income_head_array"];
			$other_charges_array=$data3["new_regular_bill"]["other_charges_array"];
			$noc_charges=$data3["new_regular_bill"]["noc_charges"];
			$total=$data3["new_regular_bill"]["total"];
			$arrear_maintenance=$data3["new_regular_bill"]["arrear_maintenance"];
			$arrear_intrest=$data3["new_regular_bill"]["arrear_intrest"];
			$intrest_on_arrears=$data3["new_regular_bill"]["intrest_on_arrears"];
			$credit_stock=$data3["new_regular_bill"]["credit_stock"];
			$due_for_payment=$data3["new_regular_bill"]["due_for_payment"];
			
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
		?>
		<tr>
			<td><?php echo $wing_flat; ?></td>
			<td><?php echo $user_name; ?></td>
			<td><?php echo $sq_feet; ?></td>
			<td><?php echo $bill_no; ?></td>
			<?php foreach($income_heads as $income_head){ 
			$result_income_head = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_account_fetch2'),array('pass'=>array($income_head)));	
			foreach($result_income_head as $data2){
				$income_head_name = $data2['ledger_account']['ledger_name'];
				$income_head_id = $data2['ledger_account']['auto_id'];
			} 
			$total_income_heads[$income_head][]=$income_head_array[$income_head_id];
			?>
			<td><?php echo $income_head_array[$income_head_id]; ?></td>	
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
			}?>
			
			<td><?php echo $total; $total_total+=$total; ?></td>
			<td><?php echo $arrear_maintenance; $total_arrear_maintenance+=$arrear_maintenance; ?></td>
			<td><?php echo $arrear_intrest; $total_arrear_intrest+=$arrear_intrest; ?></td>
			<td><?php echo $intrest_on_arrears; $total_intrest_on_arrears+=$intrest_on_arrears; ?></td>
			<td><?php echo $credit_stock; $total_credit_stock+=$credit_stock; ?></td>
			<td><?php echo $due_for_payment; $total_due_for_payment+=$due_for_payment; ?></td>
			<td>
			<label class="checkbox">
					<span><input style="opacity: 0;" value="1" name="check<?php echo $auto_id; ?>" class="group_check1" type="checkbox" /></span>
				</label>
			</td>
		</tr>
		<?php
		}
	}
	?>
	</tbody>
	<tr>
			<td colspan="4" align="right"><b>Total<b/></td>
			
			<?php 
			if(sizeof(@$income_head_array)>0){
				foreach($income_head_array as $income_head=>$value){ $total_income_heads_am=0;
				foreach(@$total_income_heads[$income_head] as $data5){
					$total_income_heads_am+=$data5;
				}
			 ?>
			<td><b><?php echo $total_income_heads_am; ?></b></td>	
			<?php } }  ?>
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
			<td></td>
		</tr>
</table>
<button type="submit" name="approve" class="btn green">Approve Selected Bills</button>
</div> 
</form>

<script>
function select_all_check(){
	$(document).ready(function() {
		if($("#select_all").is(":checked")==true){
			$(".group_check1").parent('span').addClass('checked');
			$(".group_check1").prop('checked',true);
		}else{
			$(".group_check1").parent('span').removeClass('checked');
			$(".group_check1").prop('checked',false);
		}
	});
}
</script>
							
<script>
$(document).ready(function() {
<?php	
$status5=(int)$this->Session->read('incttt');
if($status5==1)
{
?>
$.gritter.add({
title: 'Regular Bill',
text: '<p>Thank you.</p><p>Bill is generated for approval</p>',
sticky: false,
time: '10000',
});
<?php 
$this->requestAction(array('controller' => 'hms', 'action' => 'griter_notification'), array('pass' => array(1901)));
}  ?>
});
</script> 