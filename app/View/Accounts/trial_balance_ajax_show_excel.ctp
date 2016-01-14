
<?php
$society_result=$this->requestAction(array('controller' => 'Hms', 'action' => 'society_name'),array('pass'=>array($s_society_id)));
$society_name=$society_result[0]["society"]["society_name"];
?>
<div align="center">
	
<span style="font-size: 14px;"><?php echo $society_name; ?></span><br/>
<span >Trial-Balance Report</span><br/>
From: <?php echo $from; ?> To: <?php echo $to; ?>
</div>
<div style="background-color:#FFF;">
<table border="1" width="100%">
	<thead>
		<tr>
			<th></th>
			<th style="text-align: center;" colspan="2">Opening Balance</th>
            <th style="text-align: center;" colspan="2">Transactions</th>
			<th style="text-align: center;" colspan="2">Closing Balance</th>
		</tr>
		<tr>
			<th>Ledger Accounts</th>
			<th style="text-align: right;width: 10%;">Debit</th>
			<th style="text-align: right;width: 10%;">Credit</th>
            <th style="text-align: right;width: 10%;">Debit</th>
            <th style="text-align: right;width: 10%;">Credit</th>
			<th style="text-align: right;width: 10%;">Debit</th>
			<th style="text-align: right;width: 10%;">Credit</th>
		</tr>
	</thead>
	<tbody>
	<?php  
	$total_ob_debit=0; $total_ob_credit=0; $total_debit=0; $total_credit=0; $total_cb_debit=0; $total_cb_credit=0;
	foreach($result_ledger_account as $ledger_account){ 
		$ledger_account_id=$ledger_account["ledger_account"]["auto_id"];
		$ledger_account_name=$ledger_account["ledger_account"]["ledger_name"];
			
			$trail_balance=$this->requestAction(array('controller' => 'Accounts', 'action' => 'calculate_opening_balance_for_trail_balance'),array('pass'=>array($from,$to,$ledger_account_id)));
			
		
		
		if($trail_balance["opening_balance"][0]==0 && $trail_balance["debit"]==0 && $trail_balance["credit"]==0 && $trail_balance["closing_balance"][0]==0){ continue; }
			?>
			<tr>
				<td><?php echo $ledger_account_name; ?></td>
				<?php if($trail_balance["opening_balance"][1]=="Dr"){
					?>
					<td style="text-align: right;">
						<?php echo $trail_balance["opening_balance"][0]; 
						$total_ob_debit+=$trail_balance["opening_balance"][0]; ?>
					</td>
					<td style="text-align: right;">0</td>
				<?php } 
				if($trail_balance["opening_balance"][1]=="Cr"){
					?>
					<td style="text-align: right;">0</td>
					<td style="text-align: right;">
						<?php echo $trail_balance["opening_balance"][0]; 
						$total_ob_credit+=$trail_balance["opening_balance"][0]; ?>
					</td>
					<?php
				}
				if($trail_balance["opening_balance"][1]==null){
					?>
					<td style="text-align: right;">0</td>
					<td style="text-align: right;">0</td>
					<?php
				}
				?>
				
				<td style="text-align: right;"><?php echo $trail_balance["debit"]; 
				$total_debit+=$trail_balance["debit"];
				?></td>
				<td style="text-align: right;"><?php echo $trail_balance["credit"]; 
				$total_credit+=$trail_balance["credit"];
				?></td>
				
				<?php if($trail_balance["closing_balance"][1]=="Dr"){
					?>
					<td style="text-align: right;">
						<?php echo $trail_balance["closing_balance"][0]; 
						$total_cb_debit+=$trail_balance["closing_balance"][0]; ?>
					</td>
					<td style="text-align: right;">0</td>
				<?php } 
				if($trail_balance["closing_balance"][1]=="Cr"){
					?>
					<td style="text-align: right;">0</td>
					<td style="text-align: right;">
						<?php echo $trail_balance["closing_balance"][0]; 
						$total_cb_credit+=$trail_balance["closing_balance"][0]; ?>
					</td>
					<?php
				}
				if($trail_balance["closing_balance"][1]==null){
					?>
					<td style="text-align: right;">0</td>
					<td style="text-align: right;">0</td>
					<?php
				}
				?>
				
				
			</tr>
			<?php
		  } ?>
		
		<tr>
			<th><b>TOTAL</b></th>
			<th style="text-align: right;"><?php echo $total_ob_debit; ?></th>
			<th style="text-align: right;"><?php echo $total_ob_credit; ?></th>
            <th style="text-align: right;"><?php echo $total_debit; ?></th>
            <th style="text-align: right;"><?php echo $total_credit; ?></th>
			<th style="text-align: right;"><?php echo $total_cb_debit; ?></th>
			<th style="text-align: right;"><?php echo $total_cb_credit; ?></th>
		</tr>
	</tbody>
</table>
</div>