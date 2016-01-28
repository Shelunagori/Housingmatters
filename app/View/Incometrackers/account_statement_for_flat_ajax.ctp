
<?php /*
<div style="overflow: auto;">
<a href="<?php echo $webroot_path; ?>Incometrackers/account_statement_for_flat_excel/<?php echo $ledger_sub_account_id; ?>/<?php echo $from; ?>/<?php echo $to; ?>" class="btn mini blue pull-right hide_at_print" style="margin-left: 2px;"><i class="icon-download"></i></a>

<a href="#" role="button" class="btn mini purple pull-right hide_at_print" style="margin-left: 2px;" onclick="window.print();"><i class="fa fa-print"></i></a>
</div>
<?php
foreach($result_society as $data){
	$society_name=$data["society"]["society_name"];
	$society_reg_num=$data["society"]["society_reg_num"];
	$society_address=$data["society"]["society_address"];
	$society_email=$data["society"]["society_email"];
	$society_phone=$data["society"]["society_phone"];
}
?>
<div style="color:#606060;" align="center">
	<h4 style="color:#5D9B5D;"><b><?php echo $society_name; ?></b></h4>
	Regn # <?php echo $society_reg_num; ?><br>
	<?php echo $society_address; ?><br>
	Email: <?php echo $society_email; ?> | Phone : <?php echo $society_phone; ?>	
</div>
<div class="row-fluid" style="font-size:14px;">
	<div class="span6">
	<?php 
	//wing_id via flat_id//
	$result_flat_info=$this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($flat_id)));
	foreach($result_flat_info as $flat_info){
		$wing=$flat_info["flat"]["wing_id"];
	} 
	$wing_flat=$this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'), array('pass' => array($wing,$flat_id)));
	?>
		For : <?php echo $name; ?> (<?php echo $wing_flat; ?>)
	</div>
	<div class="span6" align="right">
		<span style="font-size:16px;">Statement of Account</span><br>
		<span style="font-size:12px;">From <?php echo date("d-m-Y",strtotime($from)); ?> to <?php echo date("d-m-Y",strtotime($to)); ?></span>
	</div>
</div>


<table id="report_tb" width="100%">
	<tr>
		<th>Date</th>
		<th>Reference</th>
		<th>Description</th>
		<th>Debit</th>
		<th>Credit</th>
		<th>Account Balance</th>
	</tr>
	<?php $account_balance=0;
	foreach($result_ledger_sub_account as $ledger_sub_account_data){
		$transaction_date=$ledger_sub_account_data["ledger"]["transaction_date"];
		$arrear_int_type=@$ledger_sub_account_data["ledger"]["arrear_int_type"];
		$table_name=$ledger_sub_account_data["ledger"]["table_name"];
		$element_id=$ledger_sub_account_data["ledger"]["element_id"];
		$debit=$ledger_sub_account_data["ledger"]["debit"];
		$credit=$ledger_sub_account_data["ledger"]["credit"];
		if(empty($debit)){ $debit=null; }
		if(empty($credit)){ $credit=null; }
		$account_balance=$account_balance+($debit-$credit);
		
		$description=""; $refrence_no="";
		if($table_name=="opening_balance"){
				$description="Opening Balance/Arrears";
				$refrence_no="";
				if($arrear_int_type=="YES"){
						$description="Opening Balance/Arrears Interest";
					}
					
					?>
					 <tr>
						<td><?php echo date("d-m-Y",$transaction_date); ?></td>
						<td><?php echo $refrence_no; ?></td>
						<td><?php echo $description; ?></td>
						<td align="right"><?php echo $debit; ?></td>
						<td align="right"><?php echo $credit; ?></td>
						<td align="right"><?php echo $account_balance; ?></td>
					</tr>
					
		<?php }
	 } ?>
	
	<?php $account_balance=0;
	foreach($result_ledger_sub_account as $ledger_sub_account_data){
		$transaction_date=$ledger_sub_account_data["ledger"]["transaction_date"];
		$arrear_int_type=@$ledger_sub_account_data["ledger"]["arrear_int_type"];
		$table_name=$ledger_sub_account_data["ledger"]["table_name"];
		$element_id=$ledger_sub_account_data["ledger"]["element_id"];
		$debit=$ledger_sub_account_data["ledger"]["debit"];
		$credit=$ledger_sub_account_data["ledger"]["credit"];
		if(empty($debit)){ $debit=null; }
		if(empty($credit)){ $credit=null; }
		$account_balance=$account_balance+($debit-$credit);
		
		$description=""; $refrence_no="";
		if($table_name!="opening_balance"){
				
		if($table_name=="new_regular_bill"){
				$result_regular_bill=$this->requestAction(array('controller' => 'Bookkeepings', 'action' => 'regular_bill_info_via_auto_id'), array('pass' => array($element_id)));
				if(sizeof($result_regular_bill)>0){
					$bill_approved="yes";
					$refrence_no = $result_regular_bill[0]["new_regular_bill"]["bill_no"];
					$bill_auto_id = $result_regular_bill[0]["new_regular_bill"]["auto_id"];
					$description = "Regular Bill";
					$refrence_no_path=$webroot_path."Incometrackers/regular_bill_view/".$bill_auto_id;
				}
				
			}
		if($table_name=="new_cash_bank"){
					$result_cash_bank=$this->requestAction(array('controller' => 'Bookkeepings', 'action' => 'receipt_info_via_auto_id'), array('pass' => array((int)$element_id)));
					$refrence_no=@$result_cash_bank[0]["new_cash_bank"]["receipt_id"]; 
					$transaction_id=@$result_cash_bank[0]["new_cash_bank"]["transaction_id"]; 
					$flat_id = (int)@$result_cash_bank[0]["new_cash_bank"]["party_name_id"];
					$description = "Receipt";
					$refrence_no_path=$webroot_path."Cashbanks/bank_receipt_html_view/".$transaction_id;
					
				} 
		 ?>
		 <tr>
			<td><?php echo date("d-m-Y",$transaction_date); ?></td>
			<td><a href="<?php echo $refrence_no_path; ?>" target="_blank"><?php echo $refrence_no; ?></a></td>
			<td><?php echo $description; ?></td>
			<td align="right"><?php echo $debit; ?></td>
			<td align="right"><?php echo $credit; ?></td>
			<td align="right"><?php echo $account_balance; ?></td>
		</tr>
	<?php } }?>
	<?php 
	$account_balance = 0;
	foreach($adhoc_detaill as $dataaaa)
	{
	 $transaction_date = $dataaaa['adhoc_bill']['bill_daterange_from'];	
	 $receipt_number = $dataaaa['adhoc_bill']['receipt_id'];	
	 $description = $dataaaa['adhoc_bill']['description'];	
	 $amount = $dataaaa['adhoc_bill']['g_total'];
     $account_balance=$account_balance+$amount;	 
	?>
	 <tr>
			<td><?php echo date("d-m-Y",$transaction_date); ?></td>
			<td><?php echo $receipt_number; ?></a></td>
			<td><?php echo $description; ?></td>
			<td align="right"><?php echo $amount; ?></td>
			<td align="right"></td>
			<td align="right"><?php echo $account_balance; ?></td>
		</tr>
	<?php
	}
    ?>	
	
	
	
	
	
	
	<tr>
		<td colspan="5" style="color:#33773E;" align="right"><b>Closing Balance</b></td>
		<td style="color:#33773E;" align="right"><b><?php echo $account_balance; ?></b></td>
	</tr>
</table> */ ?>

<?php 
foreach($result_society as $data){
	$society_name=$data["society"]["society_name"];
	$society_reg_num=$data["society"]["society_reg_num"];
	$society_address=$data["society"]["society_address"];
	$society_email=$data["society"]["society_email"];
	$society_phone=$data["society"]["society_phone"];
}


foreach($result_ledger as $ledger_data){
	$table_name=$ledger_data["ledger"]["table_name"];
	$debit=$ledger_data["ledger"]["debit"];
	$credit=$ledger_data["ledger"]["credit"];
	$credit=$ledger_data["ledger"]["credit"];
	$arrear_int_type=@$ledger_data["ledger"]["arrear_int_type"];
	if($table_name=="opening_balance"){
		if($arrear_int_type=="YES"){
			$opening_balance_int=$debit+$credit;
		}else{
			$opening_balance=$debit+$credit;
		}
	}
	
}
?>
<div style="overflow: auto;">
<a href="<?php echo $webroot_path; ?>Incometrackers/account_statement_for_flat_excel/<?php echo $flat_id; ?>/<?php echo $from; ?>/<?php echo $to; ?>" class="btn mini blue pull-right hide_at_print" style="margin-left: 2px;"><i class="icon-download"></i></a>
<a href="#" role="button" class="btn mini purple pull-right hide_at_print" style="margin-left: 2px;" onclick="window.print();"><i class="fa fa-print"></i></a>
</div>


	<div align="center" style="color:#606060;">
		<h4 style="color:#5D9B5D;"><b><?php echo strtoupper($society_name); ?></b></h4>
		Regn # <?php echo $society_reg_num; ?><br/>
		
		Email: <?php echo $society_email; ?> | Phone : <?php echo $society_phone; ?>
	</div>
	<div class="row-fluid" style="font-size:14px;">
		<div class="span6">
			For : <?php echo $user_name; ?> (<?php echo $wing_flat; ?>)
		</div>
		<div class="span6" align="right">
			<span style="font-size:16px;">Statement of Account</span><br/>
			<span style="font-size:12px;">From <?php echo date("d-m-Y",strtotime($from)); ?> to <?php echo date("d-m-Y",strtotime($to)); ?></span>
		</div>
	</div>
	<div>
		<table id="report_tb" width="100%">
			<thead>
            <tr>
				<th>Date</th>
				<th>Reference</th>
				<th>Type</th>
				<th>Description</th>
				<th>Maint. Charges</th>
				<th>Interest</th>
				<th>Credits</th>
				<th>Account Balance</th>
				<th></th>
			</tr>
			<?php 
			if(sizeof($result_ledger)==0){
				?>
				<tr>
					<td colspan="8" align="center">No Record Found for above selected period.</td>
				</tr>
               
				<?php
			}
			?>
			 </thead>
                <tbody id="table">
		<?php	$account_balance=0; $total_maint_charges=0; $total_interest=0; $total_credits=0;  $total_account_balance=0; 
			foreach($result_ledger as $ledger_data){ 
			$credits = "";
			$creater_name = "";
			$prepaired_by = "";
				$transaction_date=$ledger_data["ledger"]["transaction_date"];
				$table_name=$ledger_data["ledger"]["table_name"];
				$element_id=$ledger_data["ledger"]["element_id"];
				$debit=$ledger_data["ledger"]["debit"];
				$credit=$ledger_data["ledger"]["credit"];
				$credit=$ledger_data["ledger"]["credit"];
				$arrear_int_type=@$ledger_data["ledger"]["arrear_int_type"];
				$intrest_on_arrears=@$ledger_data["ledger"]["intrest_on_arrears"];
				if($table_name=="opening_balance"){
					$description="Opening Balance/Arrears";
					$refrence_no="";
					if($arrear_int_type=="YES"){
						$maint_charges="";
						$interest=$debit+$credit;
						$account_balance=$account_balance+(int)$interest;
					}else{
						$interest="";
						$maint_charges=$debit+$credit;
						$account_balance=$account_balance+(int)$maint_charges;
					}
					$credits="";
					
					
				}
				if($table_name=="new_regular_bill"){
					$result_regular_bill=$this->requestAction(array('controller' => 'Bookkeepings', 'action' => 'regular_bill_info_via_auto_id'), array('pass' => array($element_id)));
					if(sizeof($result_regular_bill)>0){
						$bill_approved="yes";
						$refrence_no = $result_regular_bill[0]["new_regular_bill"]["bill_no"];
						$description = $result_regular_bill[0]["new_regular_bill"]["description"];
						$prepaired_by = (int)$result_regular_bill[0]["new_regular_bill"]["created_by"]; 
						$current_date = $result_regular_bill[0]["new_regular_bill"]["current_date"];
	
				$date = date('d-m-Y',($current_date));
					
				$user_dataaaa = $this->requestAction(array('controller' => 'hms', 'action' => 'user_fetch'),array('pass'=>array($prepaired_by)));
				foreach ($user_dataaaa as $user_detailll) 
				{
				$creater_name = @$user_detailll['user']['user_name'];
				}	
					
					}
					
					
					if($intrest_on_arrears=="YES"){
						$maint_charges="";
						$interest=$debit+$credit;
						$account_balance=$account_balance+(int)$interest;
					}else{
						$interest="";
						$maint_charges=$debit+$credit;
						$account_balance=$account_balance+(int)$maint_charges;
					}
					$credits="";
				}
				if($table_name=="new_cash_bank"){
					
					$element_id=$element_id;
					
					$result_cash_bank=$this->requestAction(array('controller' => 'Bookkeepings', 'action' => 'receipt_info_via_auto_id'), array('pass' => array($element_id)));
					$refrence_no=@$result_cash_bank[0]["new_cash_bank"]["receipt_id"]; 
					$flat_id = (int)@$result_cash_bank[0]["new_cash_bank"]["party_name_id"];
					$description = @$result_cash_bank[0]["new_cash_bank"]["narration"];
					$date = $result_cash_bank[0]["new_cash_bank"]["current_date"];	
					$prepaired_by = (int)$result_cash_bank[0]["new_cash_bank"]["prepaired_by"];	
							
					$interest="";
					$maint_charges="";
					$credits=$debit+$credit;
					$account_balance=$account_balance-(int)$credits;
				} 
				if($table_name=='adhoc_bill')
				{
				$element_id=(int)$element_id;	
				$result_adhoc=$this->requestAction(array('controller' => 'Bookkeepings', 'action' => 'adhoc_info_via_auto_id'), array('pass' => array($element_id)));
			$refrence_no=@$result_adhoc[0]["adhoc_bill"]["receipt_id"]; 
			$flat_id = (int)@$result_adhoc[0]["adhoc_bill"]["person_name"];
			$description = @$result_adhoc[0]["adhoc_bill"]["description"];
			$date = $result_adhoc[0]["adhoc_bill"]["date"];	
			$prepaired_by = (int)$result_adhoc[0]["adhoc_bill"]["created_by"];		
				
				
               $maint_charges=$debit+$credit;
			   $interest="";
			   $account_balance=$account_balance+(int)$maint_charges;
				}				
				
	$user_dataaaa = $this->requestAction(array('controller' => 'hms', 'action' => 'user_fetch'),array('pass'=>array(@$prepaired_by)));
	foreach ($user_dataaaa as $user_detailll) 
	{
	@$creater_name = @$user_detailll['user']['user_name'];
	}	
	@$dattt = date('d-m-Y',strtotime(@$date));			
				
				$total_maint_charges=$total_maint_charges+(int)$maint_charges;
				$total_interest=$total_interest+(int)$interest;
				$total_credits=$total_credits+(int)$credits;
				?>
					<tr>
						<td><?php echo date("d-m-Y",$transaction_date); ?></td>
						<td>
						<?php if($table_name=="new_regular_bill"){
							echo '<a class="tooltips" data-original-title="Click for view Source" data-placement="bottom" href="'.$this->webroot.'Incometrackers/regular_bill_view/'.$element_id.'" target="_blank">'.$refrence_no.'</a>';
						}
						if($table_name=="new_cash_bank"){
							echo '<a class="tooltips" data-original-title="Click for view Source" data-placement="bottom" href="'.$this->webroot.'Cashbanks/bank_receipt_html_view/'.$element_id.'" target="_blank">'.$refrence_no.'</a>';
						}
                        if($table_name=="adhoc_bill")
						{
						echo '<a class="tooltips" data-original-title="Click for view Source" data-placement="bottom" href="'.$this->webroot.'Incometrackers/supplimentry_view/'.$element_id.'" target="_blank">'.$refrence_no.'</a>';	
						}
						?>
						</td>
						<td>
						<?php if($table_name=="new_regular_bill"){
						echo "Regular Bill";
						}
						if($table_name=="new_cash_bank"){
							echo "Bank Receipt";
						}
						if($table_name=="adhoc_bill")
						{
							echo "Supplimentry Bill";
						}
						?>
						</td>
						<td><?php echo $description; ?></td>
						<td style="text-align:right;"><?php echo $maint_charges; ?></td>
						<td style="text-align:right;"><?php echo $interest; ?></td>
						<td style="text-align:right;"><?php echo $credits; ?></td>
						<td style="text-align:right;"><?php echo $account_balance; ?></td>
					    <td>
						<?php if(!empty($creater_name))
						{
							?>
						<i class="icon-info-sign tooltips" data-placement="left" data-original-title="Created by: 
						<?php echo $creater_name; ?> on: <?php echo $dattt; ?>"></i>
						 <?php } ?>
						
						
						
						
						
						</td>              
					</tr>
				
			<?php } ?>
					<tr>
						<td colspan="4" align="right"><b>Total</b></td>
						<td style="text-align:right;"><b><?php echo $total_maint_charges; ?></b></td>
						<td style="text-align:right;"><b><?php echo $total_interest; ?></b></td>
						<td style="text-align:right;"><b><?php echo $total_credits; ?></b></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td colspan="7" align="right" style="color:#33773E;"><b>Closing Balance</b></td>
						<td style="color:#33773E; text-align:right;"><b><?php echo $account_balance; ?></b></td>
						<td></td>
					</tr>
                    </tbody>
		</table>
	</div>
	



	
<script>
		/* var $rows = $('#table tr');
		 $('#search').keyup(function() {
			var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
			
			$rows.show().filter(function() {
				var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
				return !~text.indexOf(val);
			}).hide();
		}); */
 </script>