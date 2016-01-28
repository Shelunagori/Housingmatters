<?php $webroot_path=$this->requestAction(array('controller' => 'Hms', 'action' => 'webroot_path')); ?>
<link type="text/css" rel="stylesheet" media="all" href="<?php echo $webroot_path; ?>fixed-table-rows-cols/jquery/jquery-ui.css" />
<link type="text/css" rel="stylesheet" media="all" href="<?php echo $webroot_path; ?>fixed-table-rows-cols/css/styles.css" />
<link type="text/css" rel="stylesheet" media="all" href="<?php echo $webroot_path; ?>fixed-table-rows-cols/css/fixed_table_rc.css" />
<script src="<?php echo $webroot_path; ?>assets/js/jquery-1.8.3.min.js"></script>
<script src="<?php echo $webroot_path; ?>fixed-table-rows-cols/js/fixed_table_rc.js" type="text/javascript"></script>


	
<style>
	.dwrapper #fixed_hdr1 { width: 1500px; }
	#fixed_hdr1 th { font-weight: bold; }
	#fixed_hdr1 th, td { border-width: 1px; border-style: solid; padding: 2px 4px; }
	
	.dwrapper { padding: 2px; overflow: hidden; vertical-align: top; }
	.dwrapper div.tblWrapper { height: 300px; overflow: auto; margin-top: 10px;}
	.dwrapper div.ft_container { width: 100%; margin-top: 10px; }		
	
	body { line-height: 1.5em; }
</style>
<style>
td{
	background-color:#FFF;
	color:#000;
}
th{
	background-color: #4682B4;
}
.text_bx{
	width: 60px;
	height: 25px !important;
	margin-bottom: 0px !important;
	font-size: 10px;
}
.text_rdoff{
	width: 60px;
	height: 25px !important;
	border: none !important;
	margin-bottom: 0px !important;
	font-size: 10px;
	background-color: transparent;
}
table#fixed_hdr1 tr:hover td {
background-color: #E6ECE7 !important;
}
</style>
<script>
	$(function () {
			$('#fixed_hdr1').fxdHdrCol({
				fixedCols: 2,
				width:     '100%',
				height:    600,
				colModal: [
				<?php for($i=1; $i<=100; $i++)
				{
					if($i==1){
						?>
						{ width: 100, align: 'left' },
						<?php
					}elseif($i==2){
						?>
						{ width: 200, align: 'left' },
						<?php
					}else{
						?>
						{ width: 150, align: 'center' },
						<?php
					}
					
				}
					
				?>
				   
				  
				]					
			});
			
		
		
	});
	
</script>
<?php
if($period_id==1){ $multiply=1; } 
if($period_id==2){ $multiply=2; } 
if($period_id==3){ $multiply=3; } 
if($period_id==4){ $multiply=6; } 
if($period_id==5){ $multiply=12; } 
$webroot_path=$this->requestAction(array('controller' => 'Hms', 'action' => 'webroot_path'));
$space='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
foreach($result_society as $data){
	$income_heads=$data["society"]["income_head"];
	$society_name=$data["society"]["society_name"];
	$society_reg_num=$data["society"]["society_reg_num"];
	$society_address=$data["society"]["society_address"];
	$society_email=$data["society"]["society_email"];
	$society_phone=$data["society"]["society_phone"];
	$tax=(float)$data["society"]["tax"];
	$penalty=$tax/100;
}
?>
<div align="center"><span style="font-size:20px;">Bill Preview</h4></div>

<form method="Post">
<div class="dwrapper">
	<table id="fixed_hdr1">
			<thead>
				<tr>
					<th>Unit Number</th>
					<th width="200px;">Name<?php echo $space; ?></th>
					<th>Area (sq. feet)<?php echo $space; ?></th>
					<th>Bill No.</th>
					<?php foreach($income_heads as $income_head){ 
					$result_income_head = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_account_fetch2'),array('pass'=>array($income_head)));	
					foreach($result_income_head as $data2){
						$income_head_name = $data2['ledger_account']['ledger_name'];
					} ?>
					<th ><?php echo $income_head_name; ?><?php echo $space; ?></th>	
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
					<?php } 
					} ?>
					
					<th>Total<?php echo $space; ?></th>
					<th>Arrears-Principal</th>
					<th>Arrears-Interest</th>
					<th>Interest on Arrears </th>
					<th>Credit/Adjustment</th>
					<th>Due For Payment</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$inc=0;
				 $bill_number = $this->requestAction(array('controller' => 'Hms', 'action' => 'autoincrement_with_society_ticket'),array('pass'=>array('new_regular_bill','bill_no')));  $bill_number--;
				
				foreach($new_flats_for_bill as $flat){ $inc++;  $total=0; $due_for_payment=0;
				
				//wing_id via flat_id//
				$result_flat_info=$this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($flat)));
				foreach($result_flat_info as $flat_info){
					$wing=$flat_info["flat"]["wing_id"];
				} 
				
				
				//user info via flat_id//
				$result_user_info=$this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_user_info_via_flat_id'),array('pass'=>array($wing,$flat)));
				foreach($result_user_info as $user_info){
					$user_id=(int)$user_info["user"]["user_id"];
					$user_name=$user_info["user"]["user_name"];
				} 
					
					if(($bill_for==1 && in_array($wing,$wing_array)) || $bill_for==2){  $bill_number++;
						
					$wing_flat=$this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'), array('pass' => array($wing,$flat))); 
					$result_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'flat_fetch2'),array('pass'=>array(@$flat,$wing))); 
					foreach($result_flat as $data2){
						$flat_type_id = (int)@$data2['flat']['flat_type_id'];
						$noc_ch_id = (int)@$data2['flat']['noc_ch_tp'];
						$sq_feet = @$data2['flat']['flat_area'];
					} 
					$result_flat_type = $this->requestAction(array('controller' => 'hms', 'action' => 'flat_type_fetch'),array('pass'=>array(@$flat_type_id)));
					foreach($result_flat_type as $data3){
						$charge = @$data3['flat_type']['charge'];
						$noc_charge = @$data3['flat_type']['noc_charge'];
					}
					
					
					////last bill info////////
					$result_new_regular_bill = $this->requestAction(array('controller' => 'Incometrackers', 'action' => 'fetch_last_bill_info_via_flat_id'),array('pass'=>array($flat)));
					
					$credit_adjustment=0;
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
							$credit_adjustment=(int)@$last_bill["credit_stock"];
							
						}
					}else{
						$result_opening_balance= $this->requestAction(array('controller' => 'Incometrackers', 'action' => 'fetch_opening_balance_via_user_id'),array('pass'=>array($flat)));
						
						if(sizeof($result_opening_balance)>0){
							$opening_balance_arrear_intrest=0;
							$opening_balance_arrear_maintenance=0;
							foreach($result_opening_balance as $opening_balance_info){
								$arrear_int_type=@$opening_balance_info["ledger"]["arrear_int_type"];
								$debit=$opening_balance_info["ledger"]["debit"];
								$credit=$opening_balance_info["ledger"]["credit"];
								
								if($arrear_int_type=="YES"){
									if(!empty($debit)){
										$opening_balance_arrear_intrest=$debit;
									}else{
										$opening_balance_arrear_intrest=-($credit);
									}
								}else{
									if(!empty($debit)){
										$opening_balance_arrear_maintenance=$debit;
									}else{
										$opening_balance_arrear_maintenance=-($credit);
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
						
						$advance_receipt=0;
						$result_last_receipts_info_no_bill= $this->requestAction(array('controller' => 'Incometrackers', 'action' => 'fetch_last_receipts_info_via_flat_id_for_no_bill'),array('pass'=>array($flat)));
						if(sizeof($result_last_receipts_info_no_bill)>0){
							foreach($result_last_receipts_info_no_bill as $last_receipts_info_no_bill){
								$advance_receipt+=$last_receipts_info_no_bill["new_cash_bank"]["amount"];
							}
							
						}
						
					}
					////reciept info/////
					$result_new_cash_bank = $this->requestAction(array('controller' => 'Incometrackers', 'action' => 'fetch_last_receipt_info_via_flat_id'),array('pass'=>array($flat,$last_bill_one_time_id)));
					
					
					
					if(sizeof($result_new_cash_bank)>=1){
						foreach($result_new_cash_bank as $last_receipt){
							$receipt_date=@$last_receipt["new_cash_bank"]["receipt_date"]; 
							$receipt_amount=$last_receipt["new_cash_bank"]["amount"];
						}
						
						$last_total=@$last_bill["new_total"];
						$last_arrear_maintenance=@$last_bill["new_arrear_maintenance"];
					}
					
					
					
					$column_id=0;
					?>
					<tr>
						<td>
							<?php echo $wing_flat; $column_id++; ?>
							<input type="hidden" name="flat_id<?php echo $inc; ?>" value="<?php echo $flat; ?>" />
						</td>
						<td><?php echo $user_name;  $column_id++; ?></td>
						<td><?php echo $sq_feet; $column_id++; ?></td>
						<td>
						<?php echo $bill_number; $column_id++; ?>
						<input type="hidden" name="bill_number<?php echo $inc; ?>" value="<?php echo $bill_number; ?>"/>
						</td>
						
						<?php $column_id++; $in_count=0; $maintanence_charges=0;$noc_percent_amt = 0;
						foreach($income_heads as $income_head){ $in_count++;?>
							<td>
							<?php foreach($charge as $data4){
							
							     $in_head_id = @$noc_charge[2];
														
								if($data4[0]==$income_head){
									$ih_charges = $data4[2];
									
									if($data4[1]==1){
										
										$ih_charges=round($ih_charges*$multiply);
										echo '<input type="text" class="text_bx call_calculation" name="income_head'.$income_head.$inc.'" value='.$ih_charges.' row_id="'.$inc.'" column_id="'.$column_id.'" id="income_head'.$in_count.'_'.$inc.'" />';
										
									if(sizeof($in_head_id)>0){	
									foreach($in_head_id as $dddd)
									{
									$in_head_id2 = (int)$dddd;	
									
									if($data4[0] == $in_head_id2)
									{
                                    $noc_percent_amt+=$ih_charges;
									}	
									}									
									}	
									
									
									
									}
									if($data4[1]==2){
										$ih_charges=$sq_feet*$data4[2];
										$ih_charges=round($ih_charges*$multiply);
										echo '<input type="text" class="text_bx call_calculation" name="income_head'.$income_head.$inc.'" value='.$ih_charges.' row_id="'.$inc.'" column_id="'.$column_id.'" id="income_head'.$in_count.'_'.$inc.'" />';
									
									if(sizeof($in_head_id)>0){	
									foreach($in_head_id as $dddd)
									{
									$in_head_id2 = (int)$dddd;	
									
									if($data4[0] == $in_head_id2)
									{
                                    $noc_percent_amt+=$ih_charges;
									}	
									}	
									}
									
									
									}
									if($data4[1]==3){
										$ih_charges=$data4[2];
										$ih_charges=round($ih_charges*$multiply);
										echo '<input type="text" class="text_bx call_calculation" name="income_head'.$income_head.$inc.'" value='.$ih_charges.' row_id="'.$inc.'" column_id="'.$column_id.'" id="income_head'.$in_count.'_'.$inc.'" />';
									
									if(sizeof($in_head_id)>0){
									foreach($in_head_id as $dddd)
									{
									$in_head_id2 = (int)$dddd;	
									
									if($data4[0] == $in_head_id2)
									{
                                    $noc_percent_amt+=$ih_charges;
									}	
									}	
									}
									
									}
									$total+=$ih_charges;
									
									if(in_array(42,$income_heads) && $income_head==42){
										$maintanence_charges=$ih_charges;
									}
								}
								
								
							} ?>
							</td>	
						<?php } ?>
						
						<td>
						<?php $column_id++; if($noc_ch_id==2){
							if($noc_charge[0]==1){
								
								$noc_charges=$noc_charge[1];
								$noc_charges=round($noc_charges*$multiply);
								echo '<input type="text" class="text_bx call_calculation" name="noc_charges'.$inc.'" value='.$noc_charges.' column_id="'.$column_id.'"  row_id="'.$inc.'" />';
								$total+=$noc_charges;
							}
							if($noc_charge[0]==2){
								$noc_charges=$sq_feet*$noc_charge[1]; 
								$noc_charges=round($noc_charges*$multiply);
								echo '<input type="text" class="text_bx call_calculation" name="noc_charges'.$inc.'" value='.$noc_charges.' column_id="'.$column_id.'"  row_id="'.$inc.'" />';
								$total+=$noc_charges;
							}
							if($noc_charge[0]==3){
								$noc_charges=$noc_charge[1];
								$noc_charges=round($noc_charges*$multiply);
								echo '<input type="text" class="text_bx call_calculation" name="noc_charges'.$inc.'" value='.$noc_charges.' column_id="'.$column_id.'"  row_id="'.$inc.'" />';
								$total+=$noc_charges;
							}
							if($noc_charge[0]==4){
								$percent = $noc_charge[1]; 
								
								$noc_charges=round($noc_percent_amt*((10)/100));
								//$noc_charges=$noc_charges*$multiply;
								echo '<input type="text" class="text_bx call_calculation" name="noc_charges'.$inc.'" value="'.$noc_charges.'" column_id="'.$column_id.'"  row_id="'.$inc.'" />';
								$total+=$noc_charges;
							}
							if($noc_charge[0]==5){
								echo 'N/A';
							}
						}else { echo 'N/A'; }
						?>
						</td>
						
						<?php  $column_id++;
						if(sizeof(@$other_charges_ids)>0){
							$qwe=0;
						foreach(@$other_charges_ids as $other_charges_id){
							$qwe++;
							$flat_other_charges=@$other_charges_array[$flat];
							if(sizeof($flat_other_charges)>0){
								$otheramount=@$flat_other_charges[$other_charges_id];
								$otheramount2 = $otheramount[0];
								$other_charges_type = (int)$otheramount[1];
								if($other_charges_type == 2)
								{
								$otheramount3=round($otheramount2*$multiply);
								}
								else
								{
								$otheramount3 = $otheramount2;	
								}
								$total+=$otheramount3;
								?>
								<td><?php echo '<input type="text" class="text_bx call_calculation" name="other_charges'.$other_charges_id.'_'.$inc.'" column_id="'.$column_id.'"  value="'.$otheramount3.'" row_id="'.$inc.'" id="other_charges'.$qwe.'_'.$inc.'" />'; ?></td>
								<?php
							}else{
								?>
								<td><?php echo '<input type="text" class="text_bx call_calculation" name="other_charges'.$other_charges_id.'_'.$inc.'" column_id="'.$column_id.'"  value=0 row_id="'.$inc.'" id="other_charges'.$qwe.'_'.$inc.'" />'; ?></td>
								<?php
							}
						} }?>
						
						
						
						<td style="background-color:#FBF1C8;">
						<?php $column_id++; echo '<input type="text" class="m-wrap text_rdoff" name="total'.$inc.'" column_id="'.$column_id.'"  value='.$total.' readonly/>'; ?></td>
						<?php $due_for_payment+=$total; ?>
						<td style="background-color:#DEE6FF;">
						<?php $column_id++;
						$arrear_maintenance=$last_arrear_maintenance+$last_total;
						$arrear_maintenance-=@$advance_receipt;
						$arrear_maintenance+=@$credit_adjustment;
						
						$due_for_payment+=$arrear_maintenance; 
						
						echo '<input type="text" class="text_rdoff call_calculation" name="arrear_maintenance'.$inc.'" value='.$arrear_maintenance.' column_id="'.$column_id.'"  row_id="'.$inc.'" readonly />'; ?>
						</td>
						<td style="background-color:#DEE6FF;">
						<?php  $column_id++;
						if(sizeof($result_new_cash_bank)>=1){
							$arrear_intrest=$last_new_arrear_intrest+$last_new_intrest_on_arrears;
						}else{
							$arrear_intrest=$last_arrear_intrest+$last_intrest_on_arrears;
						}
						
						$due_for_payment+=$arrear_intrest;
						echo '<input type="text" class="text_rdoff call_calculation" name="arrear_intrest'.$inc.'" value='.$arrear_intrest.' column_id="'.$column_id.'" row_id="'.$inc.'" readonly />'; ?>
						</td>
						<td>
						<?php $column_id++;
						//INTRST COMPUTATION START//
						$intrest_on_arrears=0;
						//case-1
						if((($arrear_maintenance<=0) && (@$receipt_date < @$last_due_date)) || (sizeof($result_new_regular_bill)==0)){
							$intrest_on_arrears+=0;
						  }else{
							//case-2
							if($arrear_maintenance>$last_total){
								$difference=strtotime($bill_start_date)-$last_due_date;
								$days_difference=floor($difference/(60*60*24)); 
								$x=($last_total*$penalty)*($days_difference/365);
								$difference2=strtotime($bill_start_date)-$last_bill_start_date;
								$days_difference2=floor($difference2/(60*60*24)); 
								$y=(($arrear_maintenance-$last_total)*$penalty)*($days_difference2/365);
							$intrest_on_arrears+=round($x+$y);
							}
							//case-3
							if($arrear_maintenance<=$last_total){
								$difference3=strtotime($bill_start_date)-$last_due_date;
								$days_difference3=floor($difference3/(60*60*24));
								$intrest_on_arrears+=round(($arrear_maintenance*$penalty)*($days_difference3/365));
							
							
							}
							//case-4
							if(sizeof($result_new_cash_bank)==1){
								if($receipt_date > $last_due_date){ 
									$difference4=$receipt_date-$last_due_date;
									$days_difference4=floor($difference4/(60*60*24));
									$intrest_on_arrears+=round(($receipt_amount*$penalty)*($days_difference4/365));
								}
							}
							
						}
						//INTRST COMPUTATION END//
						
					
						if($is_penalty==2){
							$intrest_on_arrears=0;
						}
						if($intrest_on_arrears<0){
							$intrest_on_arrears=0;
						}
						
						$due_for_payment+=$intrest_on_arrears;
						echo '<input type="text" class="text_bx call_calculation" name="intrest_on_arrears'.$inc.'" value='.$intrest_on_arrears.' column_id="'.$column_id.'" row_id="'.$inc.'" />'; ?>
						</td>
						<td style="background-color:#F8D5D5;">
						<?php $column_id++; ?>
						<input type="text" class="text_bx call_calculation" name="credit_stock<?php echo $inc; ?>" column_id="<?php echo $column_id; ?>" value="0" row_id="<?php echo $inc; ?>" /></td>
						<td style="background-color:#DEE6FF;">
						<?php $column_id++;
						echo '<input type="text" class="m-wrap text_rdoff" name="due_for_payment'.$inc.'" column_id="'.$column_id.'" value="'.$due_for_payment.'" readonly/>';
						?>
						</td>
					</tr>
				<?php } } ?>
				<tr>
					<td></td>
					<td width="200px;"><b>Total</b></td>
					<td></td>
					<td></td>
					<?php $in_count=0; foreach($income_heads as $income_head){ $in_count++;
					$result_income_head = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_account_fetch2'),array('pass'=>array($income_head)));	
					foreach($result_income_head as $data2){
						$income_head_name = $data2['ledger_account']['ledger_name'];
					} ?>
					<td id="total<?php echo $in_count; ?>"><?php echo $income_head_name; ?></td>	
					<?php } ?>
					<td id="total_noc">Non Occupancy charges</td>
					<?php $in_count=0;
					if(sizeof(@$other_charges_ids)>0){ 
						foreach($other_charges_ids as $other_charges_id){ $in_count++;
						$result_income_head = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_account_fetch2'),array('pass'=>array($other_charges_id)));	
						foreach($result_income_head as $data2){
							$income_head_name = $data2['ledger_account']['ledger_name'];
						}
						?>
						<td id="total_oth<?php echo $in_count; ?>"><?php echo $income_head_name; ?></td>
					<?php } 
					} ?>
					
					<td id="total_total">Total<?php echo $space; ?></td>
					<td id="total_arrear_maintenance">Arrears-Principal</td>
					<td id="total_arrear_intrest">Arrears-Interest</td>
					<td id="total_intrest_on_arrears">Interest on Arrears </td>
					<td id="total_credit_stock">Credit/Rebates</td>
					<td id="total_due_for_payment">Due For Payment</td>
				</tr>
			</tbody>
			
		</table>
	
</div>

<div style="padding-right:20%">
	<a href="it_regular_bill" class="btn pull-right" style="background-color: rgb(204, 204, 204);color: rgb(0, 0, 0);padding: 5px;margin-left: 10px;"><i class="icon-arrow-left"></i> Back</a>
	<button type="submit" name="generate_bill" id="generate_bill" class="btn blue pull-right" style="padding: 2px;background-color: #D40101;color: #FFF;margin-left: 5px;">Generate Bill</button>
</div>

</form>
<input type="hidden" value="<?php echo sizeof($income_heads); ?>" id="income_head_count"/>
<input type="hidden" value="<?php echo sizeof(@$other_charges_ids); ?>" id="other_charges_count"/>
<input type="hidden" value="<?php echo $inc; ?>" id="number_of_rows"/>

<script>
$(document).ready(function() {
	total_calculation();
	
	$('.call_calculation').live('keyup',function(){
		var row_id=$(this).attr('row_id');
		calculation(row_id);
	 });
	 
	 $('.call_calculation').live('blur',function(){
		var row_id=$(this).attr('row_id');
		var column_id=$(this).attr('column_id');
		total_calculation();
	 });
	 
	$('#generate_bill').live('click',function(){
		
		$(this).hide();
		$("#submiting_div").show();
	});
	 
});



	function make_full_page(){
		$(document).ready(function() {
			$(".page-sidebar").css("display","none");
			$(".page-content").css("margin-left","0px");
			
			$('html, body').css({
				'overflow': 'hidden',
				'height': '100%'
			});

		});
	}
	//make_full_page();



function calculation(row_id){
	$(document).ready(function() {
		var total=0; var due_for_payment=0;
		var income_head_count=$('#income_head_count').val();
		var other_charges_count=$('#other_charges_count').val();
		
		for(var iqq=1;iqq<=income_head_count;iqq++){
			var income_head_vlaue=parseInt($('#income_head'+iqq+'_'+row_id).val());
			if($.isNumeric(income_head_vlaue)==false){ income_head_vlaue=0; }
			total=total+income_head_vlaue;
		}
		
		var noc_charges=parseInt($('input[name=noc_charges'+row_id+']').val());
		if($.isNumeric(noc_charges)==false){ noc_charges=0; }
		total=total+noc_charges;
		
		for(var iq2=1;iq2<=other_charges_count;iq2++){
			var other_charges_vlaue=parseInt($('#other_charges'+iq2+'_'+row_id).val());
			if($.isNumeric(other_charges_vlaue)==false){ other_charges_vlaue=0; }
			total=total+other_charges_vlaue;
		}
		
		$('input[name=total'+row_id+']').val(total);
		
		
		var arrear_maintenance=parseInt($('input[name=arrear_maintenance'+row_id+']').val());
		if($.isNumeric(arrear_maintenance)==false){ arrear_maintenance=0; }
		due_for_payment=due_for_payment+total;
		due_for_payment=due_for_payment+arrear_maintenance;
		
		var arrear_intrest=parseInt($('input[name=arrear_intrest'+row_id+']').val());
		if($.isNumeric(arrear_intrest)==false){ arrear_intrest=0; }
		due_for_payment=due_for_payment+arrear_intrest;
		
		var intrest_on_arrears=parseInt($('input[name=intrest_on_arrears'+row_id+']').val());
		if($.isNumeric(intrest_on_arrears)==false){ intrest_on_arrears=0; }
		due_for_payment=due_for_payment+intrest_on_arrears;
		
		var credit_stock=parseInt($('input[name=credit_stock'+row_id+']').val());
		if($.isNumeric(credit_stock)==false){ credit_stock=0; }
		due_for_payment=due_for_payment+credit_stock;
		
		due_for_payment=Math.round(due_for_payment);
		$('input[name=due_for_payment'+row_id+']').val(due_for_payment);
		
		
	});
}

function total_calculation(){
	var income_head_count=$('#income_head_count').val();
	var other_charges_count=$('#other_charges_count').val();
	var number_of_rows=$('#number_of_rows').val();
	
	for(var iqq=1;iqq<=income_head_count;iqq++){
		var income_head_vlaue=0; var vlaue=0;
		for(var r=1;r<=number_of_rows;r++){
			vlaue=parseInt($('#income_head'+iqq+'_'+r).val());
			if($.isNumeric(vlaue)==false){ vlaue=0; }
			income_head_vlaue+=vlaue;
		}
		$('#total'+iqq).html(income_head_vlaue);
	}
	
	var noc_charges_vlaue=0;
	for(var r=1;r<=number_of_rows;r++){
		vlaue=parseInt($('input[name=noc_charges'+r+']').val());
		if($.isNumeric(vlaue)==false){ vlaue=0; }
		noc_charges_vlaue+=vlaue;
	}
	$('#total_noc').html(noc_charges_vlaue);
	
	for(var iq2=1;iq2<=other_charges_count;iq2++){
		var other_charges_vlaue=0;
		for(var r=1;r<=number_of_rows;r++){
			vlaue=parseInt($('#other_charges'+iq2+'_'+r).val());
			if($.isNumeric(vlaue)==false){ vlaue=0; }
			other_charges_vlaue+=vlaue;
		}
		$('#total_oth'+iq2).html(other_charges_vlaue);
	}
	
	
	var total_value=0;
	for(var r=1;r<=number_of_rows;r++){
		vlaue=parseInt($('input[name=total'+r+']').val());
		if($.isNumeric(vlaue)==false){ vlaue=0; }
		total_value+=vlaue;
	}
	$('#total_total').html(total_value);
	
	var total_arrear_maintenance=0;
	for(var r=1;r<=number_of_rows;r++){
		vlaue=parseInt($('input[name=arrear_maintenance'+r+']').val());
		if($.isNumeric(vlaue)==false){ vlaue=0; }
		total_arrear_maintenance+=vlaue;
	}
	$('#total_arrear_maintenance').html(total_arrear_maintenance);
	
	var total_arrear_intrest=0;
	for(var r=1;r<=number_of_rows;r++){
		vlaue=parseInt($('input[name=arrear_intrest'+r+']').val());
		if($.isNumeric(vlaue)==false){ vlaue=0; }
		total_arrear_intrest+=vlaue;
	}
	$('#total_arrear_intrest').html(total_arrear_intrest);
	
	var total_intrest_on_arrears=0;
	for(var r=1;r<=number_of_rows;r++){
		vlaue=parseInt($('input[name=intrest_on_arrears'+r+']').val());
		if($.isNumeric(vlaue)==false){ vlaue=0; }
		total_intrest_on_arrears+=vlaue;
	}
	$('#total_intrest_on_arrears').html(total_intrest_on_arrears);
	
	var total_credit_stock=0;
	for(var r=1;r<=number_of_rows;r++){
		vlaue=parseInt($('input[name=credit_stock'+r+']').val());
		if($.isNumeric(vlaue)==false){ vlaue=0; }
		total_credit_stock+=vlaue;
	}
	$('#total_credit_stock').html(total_credit_stock);
	
	var total_due_for_payment=0;
	for(var r=1;r<=number_of_rows;r++){
		vlaue=parseInt($('input[name=due_for_payment'+r+']').val());
		if($.isNumeric(vlaue)==false){ vlaue=0; }
		total_due_for_payment+=vlaue;
	}
	$('#total_due_for_payment').html(total_due_for_payment);
}
</script>

<div id="submiting_div" style="display:none;position: absolute;top: 100;z-index: 99999;left: 45%;background-color: #FFE2E2;padding: 10px;">
	<div class="modal-backdrop fade in"></div>
	<div class="modal" id="poll_edit_content">
		<div class="modal-body">
		<div align="center">
		<img src="<?php echo $webroot_path; ?>as/fb_loading.gif" style="height: 15px;" />
		<h4>Please Wait</h4>
		<h5>Your data is submiting to database.</h5>
		</div>
        </div>
	</div>
</div>