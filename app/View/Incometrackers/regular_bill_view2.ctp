<?php 
$bill_start_date=date("Y-m-d", strtotime($bill_start_date));

foreach($result_society as $data){
	$income_heads=$data["society"]["income_head"];
	$tax=(float)$data["society"]["tax"];
	$penalty=$tax/100;
}
?>
<style>
th{
	font-size: 10px !important;background-color:#F5F5F5;
}
th,td{
	padding:2px;
	font-size: 12px;border:1px solid #C2C2C2;
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
<form method="Post" >
<div class="portlet-body" style="background-color: #fff; overflow-x: auto;" align="center">
	<table border="1">
		<thead>
			<tr>
				<th>Unit Number</th>
				<th>Name</th>
				<th>Area</th>
				<th>Bill No.</th>
				<?php foreach($income_heads as $income_head){ 
				$result_income_head = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_account_fetch2'),array('pass'=>array($income_head)));	
				foreach($result_income_head as $data2){
					$income_head_name = $data2['ledger_account']['ledger_name'];
				} ?>
				<th><?php echo $income_head_name; ?></th>	
				<?php } ?>
				<th>Non Occupancy charges</th>
				<th>Total</th>
				<th>Arrears (Maint.)</th>
				<th>Arrears (Int.)</th>
				<th>Interest on Arrears </th>
				<th>Due For Payment</th>
			</tr>
		</thead>
		<tbody>
		<?php 
		$inc=0; $bill_number=1000;
		foreach($result_user as $user){ $inc++; $bill_number++; $total=0; $due_for_payment=0;
			$user_id=(int)$user["user"]["user_id"];
			$user_name=$user["user"]["user_name"];
			$wing=$user["user"]["wing"];
			$flat=$user["user"]["flat"];
			$wing_flat=$this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'), array('pass' => array($wing,$flat))); 
			$result_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'flat_fetch2'),array('pass'=>array(@$flat,$wing))); 
			foreach($result_flat as $data2){
				$flat_type_id = (int)$data2['flat']['flat_type_id'];
				$noc_ch_id = (int)@$data2['flat']['noc_ch_tp'];
				$sq_feet = (int)$data2['flat']['flat_area'];
			} 
			$result_flat_type = $this->requestAction(array('controller' => 'hms', 'action' => 'flat_type_fetch'),array('pass'=>array(@$flat_type_id)));
			foreach($result_flat_type as $data3){
				$charge = @$data3['flat_type']['charge'];
				$noc_charge = @$data3['flat_type']['noc_charge'];
			}
			
			
			////last bill info////////
			$result_new_regular_bill = $this->requestAction(array('controller' => 'Incometrackers', 'action' => 'fetch_last_bill_info_via_flat_id'),array('pass'=>array($flat)));
			if(sizeof($result_new_regular_bill)==1){
				foreach($result_new_regular_bill as $last_bill){
					$last_arrear_intrest=$last_bill["arrear_intrest"];
					$last_intrest_on_arrears=$last_bill["intrest_on_arrears"];
					$last_total=$last_bill["total"];
					$last_arrear_maintenance=(int)@$last_bill["arrear_maintenance"];
					
					$last_due_date=@$last_bill["due_date"];
					$last_bill_start_date=@$last_bill["bill_start_date"];
					$last_bill_one_time_id=@$last_bill["one_time_id"];
					
					$last_new_arrear_intrest=(int)@$last_bill["new_arrear_intrest"];
					$last_new_intrest_on_arrears=(int)@$last_bill["new_intrest_on_arrears"];
				}
			}else{
				$result_opening_balance= $this->requestAction(array('controller' => 'Incometrackers', 'action' => 'fetch_opening_balance_via_user_id'),array('pass'=>array($user_id)));
				if(sizeof($result_opening_balance)>0){
					$opening_balance_arrear_intrest=0;
					$opening_balance_arrear_maintenance=0;
					foreach($result_opening_balance as $opening_balance_info){
						$penalty=@$opening_balance_info["ledger"]["penalty"];
						$amount_category_id=$opening_balance_info["ledger"]["amount_category_id"];
						if($penalty=="YES"){
							if($amount_category_id==1){
								$opening_balance_arrear_intrest=$opening_balance_info["ledger"]["amount"];
							}else{
								$opening_balance_arrear_intrest=-($opening_balance_info["ledger"]["amount"]);
							}
						}else{
							if($amount_category_id==1){
								$opening_balance_arrear_maintenance=$opening_balance_info["ledger"]["amount"];
							}else{
								$opening_balance_arrear_maintenance=-($opening_balance_info["ledger"]["amount"]);
							}
						}
					}
				
					
					$last_arrear_intrest=$opening_balance_arrear_intrest;//opening balance import
					$last_arrear_maintenance=$opening_balance_arrear_maintenance;//opening balance import 
				}else{
					$last_arrear_intrest=0;
					$last_arrear_maintenance=0;
				}
				$last_intrest_on_arrears=0;
				$last_total=0;
				$last_bill_one_time_id=0;
			}
			////reciept info/////
			
			$result_new_cash_bank = $this->requestAction(array('controller' => 'Incometrackers', 'action' => 'fetch_last_receipt_info_via_flat_id'),array('pass'=>array($flat,$last_bill_one_time_id)));
			if(sizeof($result_new_cash_bank)>=1){
				foreach($result_new_cash_bank as $last_receipt){
					$receipt_date=@$last_receipt["new_cash_bank"]["receipt_date"];
					$receipt_amount=$last_receipt["new_cash_bank"]["amount"];
				}
				
				$last_total=$last_bill["new_total"];
				$last_arrear_maintenance=$last_bill["new_arrear_maintenance"];
			}
			
			?>
			<tr>
				<td>
					<?php echo $wing_flat.$flat_type_id; ?>
					<input type="hidden" name="flat_id<?php echo $inc; ?>" value="<?php echo $flat; ?>"/>
				</td>
				<td><?php echo $user_name; ?></td>
				<td><?php echo $sq_feet; ?></td>
				<td>
				<?php echo $bill_number; ?>
				<input type="hidden" name="bill_number<?php echo $inc; ?>" value="<?php echo $bill_number; ?>"/>
				</td>
				
				<?php foreach($income_heads as $income_head){ ?>
					<td>
					<?php foreach($charge as $data4){
						if($data4[0]==$income_head){
							if($data4[1]==1){
								$ih_charges=$data4[2];
								echo '<input type="text" class="text_bx" name="income_head'.$income_head.$inc.'" value='.$ih_charges.' />';
							}
							if($data4[1]==2){
								$ih_charges=$sq_feet*$data4[2];
								echo '<input type="text" class="text_bx" name="income_head'.$income_head.$inc.'" value='.$ih_charges.' />';
							}
							if($data4[1]==3){
								$ih_charges=$data4[2];
								echo '<input type="text" class="text_bx" name="income_head'.$income_head.$inc.'" value='.$ih_charges.' />';
							}
							$total+=$ih_charges;
						}
						if($income_head==42){
							$maintanence_charges=$ih_charges;
						}else { $maintanence_charges=0; }
					} ?>
					</td>	
				<?php } ?>
				
				<td>
				<?php if($noc_ch_id==2){
					if($noc_charge[0]==1){
						$noc_charges=$noc_charge[1];
						echo '<input type="text" class="text_bx" name="noc_charges'.$inc.'" value='.$noc_charges.' />';
						$total+=$noc_charges;
					}
					if($noc_charge[0]==2){
						$noc_charges=$sq_feet*$noc_charge[1];
						echo '<input type="text" class="text_bx" name="noc_charges'.$inc.'" value='.$noc_charges.' />';
						$total+=$noc_charges;
					}
					if($noc_charge[0]==3){
						$noc_charges=$noc_charge[1];
						echo '<input type="text" class="text_bx" name="noc_charges'.$inc.'" value='.$noc_charges.' />';
						$total+=$noc_charges;
					}
					if($noc_charge[0]==4){
						$noc_charges=$maintanence_charges*(0.1);
						echo '<input type="text" class="text_bx" name="noc_charges'.$inc.'" value='.$noc_charges.' />';
						$total+=$noc_charges;
					}
					if($noc_charge[0]==5){
						echo 'N/A';
					}
				}else { echo 'N/A'; }
				?>
				</td>
				<td><?php echo '<input type="text" class="m-wrap text_rdoff" name="total'.$inc.'" value='.$total.' readonly/>'; ?></td>
				<?php $due_for_payment+=$total; ?>
				<td>
				<?php 
				$arrear_maintenance=$last_arrear_maintenance+$last_total;
				$due_for_payment+=$arrear_maintenance; 
				echo '<input type="text" class="text_bx" name="arrear_maintenance'.$inc.'" value='.$arrear_maintenance.' />'; ?>
				</td>
				<td>
				<?php 
				if(sizeof($result_new_cash_bank)>=1){
					$arrear_intrest=$last_new_arrear_intrest+$last_new_intrest_on_arrears;
				}else{
					$arrear_intrest=$last_arrear_intrest+$last_intrest_on_arrears;
				}
				
				$due_for_payment+=$arrear_intrest;
				echo '<input type="text" class="text_bx" name="arrear_intrest'.$inc.'" value='.$arrear_intrest.' />'; ?>
				</td>
				<td>
				<?php 
				//INTRST COMPUTATION START//
				$intrest_on_arrears=0;
				//case-1
				if(($arrear_maintenance<=0) || (sizeof($result_new_regular_bill)==0)){
					$intrest_on_arrears+=0;
				}else{
					//case-2
					if($arrear_maintenance>$last_total){
						$difference=strtotime($bill_start_date)-strtotime($last_due_date);
						$days_difference=floor($difference/(60*60*24)); 
						$x=($last_total*$penalty)*($days_difference/365);
						$difference2=strtotime($bill_start_date)-strtotime($last_bill_start_date);
						$days_difference2=floor($difference2/(60*60*24)); 
						$y=(($arrear_maintenance-$last_total)*$penalty)*($days_difference2/365);
						$intrest_on_arrears+=round($x+$y);
					}
					//case-3
					if($arrear_maintenance<=$last_total){
						$difference3=strtotime($bill_start_date)-strtotime($last_due_date);
						$days_difference3=floor($difference3/(60*60*24));
						$intrest_on_arrears+=round(($arrear_maintenance*$penalty)*($days_difference3/365));
					}
					//case-4
					if(sizeof($result_new_cash_bank)==1){
						if(strtotime($receipt_date) > strtotime($last_due_date)){
							$difference4=strtotime($receipt_date)-strtotime($last_due_date);
							$days_difference4=floor($difference4/(60*60*24));
							$intrest_on_arrears+=round(($receipt_amount*$penalty)*($days_difference4/365));
						}
					}
					
				}
				//INTRST COMPUTATION END//
				$due_for_payment+=$intrest_on_arrears;
				echo '<input type="text" class="text_bx" name="intrest_on_arrears'.$inc.'" value='.$intrest_on_arrears.' />'; ?>
				</td>
				<td>
				<?php 
				echo '<input type="text" class="m-wrap text_rdoff" name="due_for_payment'.$inc.'" value='.$due_for_payment.' readonly/>';
				?>
				</td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
</div>

<button type="submit" name="generate_bill" class="btn blue">Generate Bill</button>
</form>