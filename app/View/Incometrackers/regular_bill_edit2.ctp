<style>
.textbx{
	margin-bottom: 0px !important;
	height: 15px !important;width: 100px;
}
</style>
<a href="<?php echo $webroot_path; ?>Incometrackers/in_head_report" role="button" rel="tab" class="btn"><i class="icon-arrow-left"></i> Back</a>
<?php 
foreach($result_society as $data){
	$income_heads=$data["society"]["income_head"];
}
foreach($result_new_regular_bill as $regular_bill){
	$flat_id=$regular_bill["new_regular_bill"]["flat_id"];
	$bill_no=$regular_bill["new_regular_bill"]["bill_no"];
	$bill_start_date=$regular_bill["new_regular_bill"]["bill_start_date"];
	$due_date=$regular_bill["new_regular_bill"]["due_date"];
	$income_head_array=$regular_bill["new_regular_bill"]["income_head_array"];
	$total=$regular_bill["new_regular_bill"]["total"];
	$intrest_on_arrears=$regular_bill["new_regular_bill"]["intrest_on_arrears"];
	$arrear_maintenance=$regular_bill["new_regular_bill"]["arrear_maintenance"];
	$arrear_intrest=$regular_bill["new_regular_bill"]["arrear_intrest"];
	$due_for_payment=$regular_bill["new_regular_bill"]["due_for_payment"];
	$credit_stock=$regular_bill["new_regular_bill"]["credit_stock"];
	$income_head_array=$regular_bill["new_regular_bill"]["income_head_array"];
	$other_charges_array=$regular_bill["new_regular_bill"]["other_charges_array"];
	$noc_charges=$regular_bill["new_regular_bill"]["noc_charges"];
	
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
}; ?>
<div class="portlet box blue">
	<div class="portlet-title">
		<h4><i class="icon-edit"></i> Edit Bill -<?php echo $bill_no; ?></h4>
	</div>
	<div class="portlet-body" style="overflow:auto;">
		<table style="width:100%; float:left;" >
			<tr>
				<td width="10%">Name: </td>
				<td><?php echo $user_name; ?></td>
				<td width="10%">Flat/Shop No.: </td>
				<td><?php echo $wing_flat; ?></td>
			</tr>
			<tr>
				<td width="10%">Bill Date:</td>
				<td><?php echo date("d-M-Y",$bill_start_date); ?></td>
				<td width="10%">Due Date:</td>
				<td><?php echo date("d-M-Y",$due_date); ?></td>
			</tr>
		</table>
		<form method="post">
		<div class="portlet-body span6">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th>Particulars of charges</th>
						<th>Amount (Rs.)</th>
					</tr>
				</thead>
				<tbody>
					<?php $i=0; foreach($income_head_array as $income_head_id=>$income_head_amount){ $i++;
					$result_income_head = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_account_fetch2'),array('pass'=>array($income_head_id)));	
					foreach($result_income_head as $data2){
						$income_head_name = $data2['ledger_account']['ledger_name'];
					} ?>
					<tr>
						<td><?php echo $income_head_name; ?></td>
						<td><input type="text" class="m-wrap textbx call_calculation" value="<?php echo $income_head_amount; ?>" name="income_head<?php echo $income_head_id; ?>" id="income_head<?php echo $i; ?>" /></td>
					</tr>
					<?php } ?>
					
					<tr>
						<td >Non Occupancy charges</td>
						<td><input type="text" class="m-wrap textbx call_calculation" value="<?php echo $noc_charges; ?>" name="non_occupancy_charges" /></td>
					</tr>
					
					<?php $j=0; foreach($other_charges_array as $other_charge_id=>$other_charge_amount){ $j++;
					$result_income_head = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_account_fetch2'),array('pass'=>array($other_charge_id)));	
					foreach($result_income_head as $data2){
						$income_head_name = $data2['ledger_account']['ledger_name'];
					} ?>
					<tr>
						<td><?php echo $income_head_name; ?></td>
						<td><input type="text" class="m-wrap textbx call_calculation" value="<?php echo $other_charge_amount; ?>" name="other_charges<?php echo $other_charge_id; ?>" id="other_charges<?php echo $j; ?>" /></td>
					</tr>
					<?php } ?>
					
					<tr>
						<td style="text-align: right;">Total</td>
						<td><input type="text" class="m-wrap textbx" value="<?php echo $total; ?>" name="total" readonly="" /></td>
					</tr>
					<tr>
						<td style="text-align: right;">Interest on arrears</td>
						<td><input type="text" class="m-wrap textbx call_calculation" value="<?php echo $intrest_on_arrears; ?>" name="interest_on_arrears" /></td>
					</tr>
					<tr>
						<td style="text-align: right;">Arrears   (Maint.)</td>
						<td><input type="text" class="m-wrap textbx call_calculation" value="<?php echo $arrear_maintenance; ?>" name="arrear_maintenance" /></td>
					</tr>
					<tr>
						<td style="text-align: right;">Arrears   (Int.)</td>
						<td><input type="text" class="m-wrap textbx call_calculation" value="<?php echo $arrear_intrest; ?>" name="arrear_intrest" /></td>
					</tr>
					<tr>
						<td style="text-align: right;">Credit/Adjustment</td>
						<td><input type="text" class="m-wrap textbx call_calculation" value="<?php echo $credit_stock; ?>" name="credit_stock" /></td>
					</tr>
					<tr>
						<td style="text-align: right;"><b>Due For Payment</b></td>
						<td><input type="text" class="m-wrap textbx" value="<?php echo $due_for_payment; ?>" name="due_for_payment" readonly="" /></td>
					</tr>
				</tbody>
			</table>
			<a href="#" role="button" class="btn green submit_button">UPDATE BILL</a>
			<!--<button type="submit" name="edit_bill" class="btn green">UPDATE BILL</button>-->
		</div>
		
		<div class="confirm_div" style="display: none;">
			<div class="modal-backdrop fade in"></div>
			<div class="modal" id="poll_edit_content">
			<div class="modal-body">
				Are you sure to edit this bill?				   			   
			</div>
			<div class="modal-footer">
				<button type="button" class="btn" id="close_button">CLOSE</button>
				<button type="submit" name="edit_bill" class="btn red">UPDATE BILL</button>
			</div>
			</div>
		</div>
		
		</form>
		
		
	</div>
</div>
<input type="hidden" value="<?php echo sizeof($income_head_array); ?>" id="income_head_count"/>
<input type="hidden" value="<?php echo sizeof($other_charges_array); ?>" id="other_charges_count"/>
<input type="hidden" value="0" id="confirm"/>






<script>
$(document).ready(function() {
	$('.call_calculation').live('keyup',function(){
		bill_calculation();
	});
	 
	$('.submit_button').live('click',function(){
		$('.confirm_div').show();
	});
	$('#close_button').live('click',function(){
		$('.confirm_div').hide();
	});
});

function bill_calculation(){
	$(document).ready(function() {
		var total=0; var due_for_payment=0;
		var income_head_count=$('#income_head_count').val();
		var other_charges_count=$('#other_charges_count').val();
		
		for(var iqq=1;iqq<=income_head_count;iqq++){
			var income_head_vlaue=parseInt($('#income_head'+iqq).val());
			if($.isNumeric(income_head_vlaue)==false){ income_head_vlaue=0; }
			total=total+income_head_vlaue;
		}
		
		
		var noc_charges=parseInt($('input[name=non_occupancy_charges]').val());
		if($.isNumeric(noc_charges)==false){ noc_charges=0; }
		total=total+noc_charges;
		
		for(var iq2=1;iq2<=other_charges_count;iq2++){
			var other_charges_vlaue=parseInt($('#other_charges'+iq2).val());
			if($.isNumeric(other_charges_vlaue)==false){ other_charges_vlaue=0; }
			total=total+other_charges_vlaue;
		}
		$('input[name=total]').val(total);
		
		var arrear_maintenance=parseInt($('input[name=arrear_maintenance]').val());
		if($.isNumeric(arrear_maintenance)==false){ arrear_maintenance=0; }
		due_for_payment=due_for_payment+total;
		due_for_payment=due_for_payment+arrear_maintenance;
		
		var arrear_intrest=parseInt($('input[name=arrear_intrest]').val());
		if($.isNumeric(arrear_intrest)==false){ arrear_intrest=0; }
		due_for_payment=due_for_payment+arrear_intrest;
		
		var interest_on_arrears=parseInt($('input[name=interest_on_arrears]').val());
		if($.isNumeric(interest_on_arrears)==false){ interest_on_arrears=0; }
		due_for_payment=due_for_payment+interest_on_arrears;
		
		var credit_stock=parseInt($('input[name=credit_stock]').val());
		if($.isNumeric(credit_stock)==false){ credit_stock=0; }
		due_for_payment=due_for_payment+credit_stock;
		
		due_for_payment=Math.round(due_for_payment);
		$('input[name=due_for_payment]').val(due_for_payment);
		
	});
}
</script>