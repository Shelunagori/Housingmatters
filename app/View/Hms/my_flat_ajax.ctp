<?php 
$m_from = date("Y-m-d", strtotime($from));
$m_from = new MongoDate(strtotime($m_from));

$m_to = date("Y-m-d", strtotime($to));
$m_to = new MongoDate(strtotime($m_to));

$opening_balance = 0;
$closing_balance = 0;

$nnn = 1;
$open_bal_import = $op_cred - $op_deb;
?>
<div class="hide_at_print">
<span style="margin-left:80%;">
<button type="button" class=" printt btn green" onclick="window.print()"><i class="icon-print"></i> Print</button>
</span>
</div>
<br />
<div class="hide_at_print">
<table style="width:100%; background-color:white;" border="0">
<tr>
<th style="text-align:right; width:20%;">Wing Name:</th><td style="text-align:left;"><?php echo $wing_name; ?></td>
<th style="text-align:right; width:20%;">Flat Name:</th><td style="text-align:left;"><?php echo $flat_name; ?></td>
</tr>
<tr>
<th style="text-align:right;">Flat Type:</th><td style="text-align:left;"><?php echo $flat_type; ?></td>
<th style="text-align:right;">Flat Area:</th><td style="text-align:left;"><?php echo $flat_area; ?>   sq feet</td>
</tr>
</table>
</div>
<br />
<?php ////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<?php
                                     foreach ($cursor1 as $collection) 
									 {
                                     $auto_id = (int)@$collection['ledger']['auto_id'];
									 $account_type = (int)@$collection['ledger']['account_type'];
									 $receipt_id = (int)@$collection['ledger']['receipt_id']; 
                                     $amount_o = @$collection['ledger']['amount'];
					                 $amount_category_id = (int)@$collection['ledger']['amount_category_id'];
									 $module_id = (int)@$collection['ledger']['module_id'];
									 $sub_account_id = (int)@$collection['ledger']['account_id']; 
									 $current_date = @$collection['ledger']['current_date'];
									 $society_id = (int)@$collection['ledger']['society_id'];
                                     if($receipt_id == 'O_B')
                                     continue;
									 
									 $module_fetch2 = $this->requestAction(array('controller' => 'hms', 'action' => 'module_fetch'),array('pass'=>array($module_id)));
                                    foreach ($module_fetch2 as $collection) 
									{
									$module_name = @$collection['account_category']['ac_category'];
									$module_name2 = @$collection['account_category']['module_name'];
									}
									
									$module_date_fetch2 = $this->requestAction(array('controller' => 'hms', 'action' => 'module_main_fetch'),array('pass'=>array($module_name,$receipt_id)));
									
									foreach ($module_date_fetch2 as $collection) 
									{
									$date = @$collection[$module_name]['transaction_date'];
									if(empty($date))
									{
									$date = @$collection[$module_name]['posting_date'];	
									}
									if(empty($date))
									{
									$date = @$collection[$module_name]['purchase_date'];	
									}
									if(empty($date))
									{
									$date = @$collection[$module_name]['date'];	
									}
									$narration = @$collection[$module_name]['narration'];
									$remark = @$collection[$module_name]['remark'];
									}
									 
									 
									if(@$date >= $m_from && @$date <= $m_to)
								         { 
									 
									 
									 
									 
									 
									 
									 
									 
									 $nnn = 5;
									 }}
									 
						 ?>
<?php ////////////////////////////////////////////////////////////////////////////////////// ?>									<?php 
if($nnn == 5)
{
?>




<table class="table table-bordered" style="width:100%; background-color:white;">
 <?php   
$result1 = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_amount'),array('pass'=>array($ledger_id)));
                                    foreach ($result1 as $collection) 
									{
								    $ledger_type_name = $collection['ledger_account']['ledger_name'];	
									}    
    ?>
    
    <tr>
    <th colspan = "6" style="text-align:center;">
    <?php echo $society_name; ?>
    </th>
    </tr>
<tr>
<th colspan = "6" style="text-align:center;">
Transaction for The Period <?php echo $from; ?> to <?php echo $to; ?>
</th>
</tr>								 
									 
<tr>
<th><?php echo @$name; ?>  A/c</th>
<th>Grouping :<?php echo @$ledger_type_name; ?></th>
<th colspan="4"></th>
</tr>									 
	
 <?php
                                   
                                     $opening_balance = 0;
									 foreach ($cursor1 as $collection) 
									 {
                                     $auto_id = (int)@$collection['ledger']['auto_id'];
									 $account_type = (int)@$collection['ledger']['account_type'];
									 $receipt_id = (int)@$collection['ledger']['receipt_id']; 
                                     $amount_o = @$collection['ledger']['amount'];
					                 $amount_category_id = (int)@$collection['ledger']['amount_category_id'];
									 $module_id = (int)@$collection['ledger']['module_id'];
									 $sub_account_id = (int)@$collection['ledger']['account_id']; 
									 $current_date = @$collection['ledger']['current_date'];
									 $society_id = (int)@$collection['ledger']['society_id'];
   
    
   $module_fetch=$this->requestAction(array('controller'=>'hms','action'=>'module_fetch'),array('pass'=>array($module_id)));										
										foreach ($module_fetch as $collection) 
										{
										$module_name = @$collection['account_category']['ac_category'];
										} 
    
    
 $module_date_fetch = $this->requestAction(array('controller' => 'hms', 'action' => 'module_main_fetch'),array('pass'=>array($module_name,$receipt_id)));

 		
										foreach ($module_date_fetch as $collection) 
										{
										$date1 = @$collection[$module_name]['transaction_date'];
										if(empty($date1))
										{
										$date1 = @$collection[$module_name]['posting_date'];	
										}
										if(empty($date1))
										{
										$date1 = @$collection[$module_name]['purchase_date'];	
										}
										if(empty($date1))
										{
										$date1 = @$collection[$module_name]['date'];	
										}
										$narration = @$collection[$module_name]['narration'];
										$remark = @$collection[$module_name]['remark'];
										}   
    
    
                                if(@$date1 < $m_from)
								{   
                                if($amount_category_id == 1)
								{
								$opening_balance = $opening_balance - $amount_o;
								}
								else if($amount_category_id == 2)
								{
								$opening_balance = $opening_balance + $amount_o;	
								}
								}
									 }
								
								
?>	
  <tr>
                                    <th colspan="3"></th>
                                    <th colspan="2">Opening Balance:</th>
                                    <th><?php
									$opening_balance = $opening_balance + ($open_bal_import);
                                   	if($opening_balance > 0)
									{
									$opening_balance = $opening_balance.'&nbsp;&nbsp;Cr';
									}
									else if($opening_balance < 0)
									{
									$opening_balance = abs($opening_balance);
									$opening_balance = $opening_balance.'&nbsp;&nbsp;Dr';
									}
									 
									echo $opening_balance; ?></th>
                                    </tr>

<?php
                                    $balance = $opening_balance;
									?>
									
									<tr>
									<th>Transaction Date</th>
									<th>Narration</th>
									<th>Source</th>
									<th>Reference #</th>
									<th>Debit</th>
									<th>Credit</th>
									
									</tr>
                                    <?php
									$total_debit = 0;
									$total_credit = 0;
									foreach ($cursor1 as $collection) 
									{
									
                                     $auto_id = (int)@$collection['ledger']['auto_id'];
									 $account_type = (int)@$collection['ledger']['account_type'];
									 $receipt_id = (int)@$collection['ledger']['receipt_id']; 
                                     $amount = @$collection['ledger']['amount'];
					                 $amount_category_id = (int)@$collection['ledger']['amount_category_id'];
									 $module_id = (int)@$collection['ledger']['module_id'];
									 $sub_account_id = (int)@$collection['ledger']['account_id']; 
									 $current_date = @$collection['ledger']['current_date'];
									 $society_id = (int)@$collection['ledger']['society_id'];
$module_fetch2 = $this->requestAction(array('controller' => 'hms', 'action' => 'module_fetch'),array('pass'=>array($module_id)));
                                    foreach ($module_fetch2 as $collection) 
									{
									$module_name = @$collection['account_category']['ac_category'];
									$module_name2 = @$collection['account_category']['module_name'];
									}

$module_date_fetch2 = $this->requestAction(array('controller' => 'hms', 'action' => 'module_main_fetch'),array('pass'=>array($module_name,$receipt_id)));
									
									foreach ($module_date_fetch2 as $collection) 
									{
									$date = @$collection[$module_name]['transaction_date'];
									if(empty($date))
									{
									$date = @$collection[$module_name]['posting_date'];	
									}
									if(empty($date))
									{
									$date = @$collection[$module_name]['purchase_date'];	
									}
									if(empty($date))
									{
									$date = @$collection[$module_name]['date'];	
									}
									$narration = @$collection[$module_name]['narration'];
									if(empty($narration))
									{
									$narration = @$collection[$module_name]['remark'];
									}
									if(empty($narration))
									{
									$narration = @$collection[$module_name]['description'];	
									}
									$remark = @$collection[$module_name]['remark'];
									}
                             if(@$date >= $m_from && @$date <= $m_to)
								         {
                                   $date = date('d-m-Y',$date->sec);
?>
									 <tr>
											<td><?php echo $date; ?></td>
                                            <td><?php echo $narration; ?></td>
											<td><?php echo $module_name2; ?></td>
											<td><?php echo $receipt_id; ?></td>
											
											<td><?php if($amount_category_id == 1) { $balance = $balance - $amount;   echo $amount; } else { echo "-"; } ?></td>
										    <td><?php if($amount_category_id == 2) { $balance = $balance + $amount;   echo $amount; } else { echo "-"; } ?></td>
										   
                                        </tr>
                                        
                                        <?php
										if($amount_category_id == 1)
										{
										$total_debit = $total_debit + $amount;
										}
										else if($amount_category_id == 2)
										{
										$total_credit = $total_credit + $amount;
										}
										$closing_balance = $opening_balance - $total_debit + $total_credit;
										?>
                                        <?php }}   ?>
                                        
	<tr>
										<th colspan="4" style="text-align:right;"><b> Total </b></th>

										<th><?php echo $total_debit; ?>  <?php //echo "    dr"; ?></th>
										<th><?php echo $total_credit; ?> <?php //echo "    cr"; ?></th>
										
										</tr>
										<tr>
										<th style="text-align:center;">Opening Balance</th>
										<th colspan="" style="text-align:center;">
										Total Debits
										</th>
										<th style="text-align:center;">Total credits</th>
										<th colspan="3" style="text-align:center;">
										Closing balance
										</th>
										</tr>

										<tr>
										<th style="text-align:center;"><?php 
										if($opening_balance > 0) 
										{ 
										$opening_balance = $opening_balance.'Cr';
										} 
									    else if($opening_balance < 0)
										{
										$opening_balance = abs($opening_balance);
										$opening_balance = $opening_balance.'Dr';
										}
										echo $opening_balance; ?></th>
										<th colspan="" style="text-align:center;"><?php echo $total_debit ?></th>
									
										<th style="text-align:center;"><?php echo $total_credit; ?></th>
										<th colspan="3" style="text-align:center;"><?php 
										if($closing_balance > 0) 
										{ 
										$closing_balance = $closing_balance.'&nbsp;&nbsp;Cr';  
										}
                                        else if($closing_balance < 0)
                                        { 										
										$closing_balance = abs($closing_balance);
										$closing_balance = $closing_balance.'&nbsp;&nbsp;Dr';
										}
										echo $closing_balance; ?></th>
										</tr>

    
    
    
    
    
    
    
    							 
</table>									 
									 
<?php									 
}
else 
{
?>	
<center>
<h2 style="color:red"><b>No Record Found In Selected Date</b></h2>
</center>
<?php	
}
?>
									 