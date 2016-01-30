<?php
$society_result=$this->requestAction(array('controller' => 'Hms', 'action' => 'society_name'),array('pass'=>array($s_society_id)));
$society_name=$society_result[0]["society"]["society_name"];
?>
<div align="center">
<span style="font-size: 14px;"><?php echo $society_name; ?></span><br/>
<span >Trail-Balance Report</span><br/>
From: <?php echo $from; ?> To: <?php echo $to; ?>
</div>

<!-------------------new code --------------------------------------->
<?php if($ledger_account_id == 34)
{
 ?>

<table border="1" width="100%">
	<thead>
		<tr><?php if($ledger_account_id == 34) { ?>
			<th></th>
		    <?php } ?>
			<th></th>
			<th style="text-align: center;" colspan="2">Opening Balance</th>
            <th style="text-align: center;" colspan="2">Transactions</th>
			<th style="text-align: center;" colspan="2">Closing Balance</th>
		</tr>
		<tr>
		    <?php if($ledger_account_id == 34) { ?>
			<th>Unit Number</th>
			<?php } ?> 
			<th>Ledger Accounts</th>
			<th style="text-align: right;width: 10%;">Debit</th>
			<th style="text-align: right;width: 10%;">Credit</th>
            <th style="text-align: right;width: 10%;">Debit</th>
            <th style="text-align: right;width: 10%;">Credit</th>
			<th style="text-align: right;width: 10%;">Debit</th>
			<th style="text-align: right;width: 10%;">Credit</th>
		</tr>
	</thead>
	<tbody id="table">
	<?php  
	$total_ob_debit=0; $total_ob_credit=0; $total_debit=0; $total_credit=0; $total_cb_debit=0; $total_cb_credit=0;
	foreach($new_flats_for_bill as $rrr)
	{
	$flll_iddd = (int)$rrr;	
	$ledger_sub_account_id=null;	
	
	
	
	$ledger_sub_account_data=$this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_subLedger_detail_via_flat_id'),array('pass'=>array($flll_iddd)));
	foreach($ledger_sub_account_data as $ledger_sub_account){ 
	$ledger_sub_account_id=$ledger_sub_account["ledger_sub_account"]["auto_id"];
	$ledger_sub_account_name=$ledger_sub_account["ledger_sub_account"]["name"];
	}
		if($ledger_account_id==34){
			$flat=$ledger_sub_account["ledger_sub_account"]["flat_id"];
			
			//wing_id via flat_id//
			$result_flat_info=$this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($flat)));
			foreach($result_flat_info as $flat_info){
				$wing=$flat_info["flat"]["wing_id"];
			} 
			
			$wing_flat=$this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'), array('pass' => array($wing,$flat)));
			
			$ledger_extra_info=$wing_flat;
		}
		
		
			$trail_balance=$this->requestAction(array('controller' => 'Accounts', 'action' => 'calculate_opening_balance_for_trail_balance_for_sub_account'),array('pass'=>array($from,$to,$ledger_account_id,$ledger_sub_account_id)));
			
			if($trail_balance["opening_balance"][0]==0 && $trail_balance["debit"]==0 && $trail_balance["credit"]==0 && $trail_balance["closing_balance"][0]==0){ continue; }
			?>
			<tr>
			<?php if($ledger_account_id == 34) { ?>
			<td><?php echo $wing_flat; ?></td>
			<?php } ?>
				<td><?php echo $ledger_sub_account_name; ?> <span style="padding-left: 10px;font-weight: 100;"></span></td>
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
		 <?php if($ledger_account_id == 34) { ?>
		 <th></th>
		 <?php } ?>
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








<?php } else { ?>
<!--------------------End new code ----------------------------------->

<table border="1" width="100%">
	<thead>
		<tr>
		<?php if($ledger_account_id == 34)
		{ ?>
	<th></th>
		<?php } ?>
			<th></th>
			<th style="text-align: center;" colspan="2">Opening Balance</th>
            <th style="text-align: center;" colspan="2">Transactions</th>
			<th style="text-align: center;" colspan="2">Closing Balance</th>
		</tr>
		<tr><?php if($ledger_account_id == 34)
		{ ?>
	     <th>Unit Number</th>
		<?php } ?>
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
	foreach($result_ledger_sub_account as $ledger_sub_account){ 
		$ledger_sub_account_id=$ledger_sub_account["ledger_sub_account"]["auto_id"];
		$ledger_sub_account_name=$ledger_sub_account["ledger_sub_account"]["name"];
		if($ledger_account_id==34){
			$flat=$ledger_sub_account["ledger_sub_account"]["flat_id"];
			
			//wing_id via flat_id//
			$result_flat_info=$this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($flat)));
			foreach($result_flat_info as $flat_info){
				$wing=$flat_info["flat"]["wing_id"];
			} 
			
			$wing_flat=$this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'), array('pass' => array($wing,$flat)));
			
			$ledger_extra_info=$wing_flat;
		}
		if($ledger_account_id==33){
			$bank_account=$ledger_sub_account["ledger_sub_account"]["bank_account"];
			$ledger_extra_info=$bank_account;
		}
		if($ledger_account_id==15){
			$ledger_extra_info="";
		}
			
			$trail_balance=$this->requestAction(array('controller' => 'Accounts', 'action' => 'calculate_opening_balance_for_trail_balance_for_sub_account'),array('pass'=>array($from,$to,$ledger_account_id,$ledger_sub_account_id)));
			
			if($trail_balance["opening_balance"][0]==0 && $trail_balance["debit"]==0 && $trail_balance["credit"]==0 && $trail_balance["closing_balance"][0]==0){ continue; }
			?>
			<tr><?php if($ledger_account_id == 34)
		{ ?>
	    <td><?php echo $wing_flat; ?></td>
		<?php } ?> 
				<td><?php echo $ledger_sub_account_name; ?> <span style="padding-left: 10px;font-weight: 100;"><?php echo $ledger_extra_info; ?></span></td>
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
		
		<tr><?php if($ledger_account_id == 34)
		{ ?>
        <th></th>
		<?php } ?>
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

<?php } ?>
