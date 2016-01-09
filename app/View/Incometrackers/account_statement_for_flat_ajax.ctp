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
</table>