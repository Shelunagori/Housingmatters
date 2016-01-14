<?php
$m_from = date("Y-m-d", strtotime($date111));
$m_from = new MongoDate(strtotime($m_from));

$m_to = date("Y-m-d", strtotime($date222));
$m_to = new MongoDate(strtotime($m_to));

$opening_balance = 0;
$closing_balance = 0;
$nnn = 1;
//$open_bal_import = $op_cred - $op_deb;
?>

<?php

if($main_id == 34 || $main_id == 15 || $main_id == 33 || $main_id == 35)
{
?>

<?php
$cursor1 = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_amount'),array('pass'=>array($main_id)));
                                    foreach ($cursor1 as $collection) 
									{
								    $ledger_type_name = $collection['ledger_account']['ledger_name'];	
									}
$cursor2 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($sub_id)));	
                                    foreach ($cursor2 as $collection) 
									{
								    $user_name = $collection['ledger_sub_account']['name'];	
									}
									
					?>              
					
					
					             
					
					
                                   
							
									<?php
                                   
                                     $opening_balance = 0;
									 foreach ($cursor3 as $collection) 
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
                                     $module_name = @$collection['ledger']['module_name'];
									 $table_name = @$collection['ledger']['table_name'];
									 if($table_name == "cash_bank")
									 {
									 $module_id = (int)$collection['ledger']['module_id']; 	 
									 }
									 
									 if($receipt_id == 'O_B')
                                     continue;
									 
/*								 
$module_fetch=$this->requestAction(array('controller'=>'hms','action'=>'module_fetch'),array('pass'=>array($module_id)));										
										foreach ($module_fetch as $collection) 
										{
										$module_name = @$collection['account_category']['ac_category'];
										}
										
*/	
if($table_name == "cash_bank")
{
$module_date_fetch = $this->requestAction(array('controller' => 'hms', 'action' => 'module_main_fetch5'),array('pass'=>array($table_name,$receipt_id,$module_id)));	
}
else
{
$module_date_fetch = $this->requestAction(array('controller' => 'hms', 'action' => 'module_main_fetch'),array('pass'=>array($table_name,$receipt_id)));
}
 		
										foreach ($module_date_fetch as $collection) 
										{
										$date1 = @$collection[$table_name]['transaction_date'];
										if(empty($date1))
										{
										$date1 = @$collection[$table_name]['posting_date'];	
										}
										if(empty($date1))
										{
										$date1 = @$collection[$table_name]['purchase_date'];	
										}
										if(empty($date1))
										{
										$date1 = @$collection[$table_name]['date'];	
										}
										$narration = @$collection[$table_name]['narration'];
										$remark = @$collection[$table_name]['remark'];
										}


if($amount_category_id == 1)
{
$amount_category = "Debit";	
}
else if($amount_category_id == 2)
{
$amount_category = "Credit";
}
/*
$amount_category_fetch = $this->requestAction(array('controller' => 'hms', 'action' => 'amount_category'),array('pass'=>array($amount_category_id)));										
										foreach ($amount_category_fetch as $collection) 
										{
										$amount_category = @$collection['amount_category']['amount_category'];
										}
										
										*/
										
										if($sub_account_id == $sub_id)
								        {

								       if(@$date1 < $m_from)
								{
								if($account_type == 1)
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
								}
								}
								  ?>
                                  
                                    <?php
                                    $balance = $opening_balance;
									?>
									
									
                                    
									
									<?php
									$total_debit = 0;
									$total_credit = 0;
									foreach ($cursor3 as $collection) 
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
                                     $module_name = @$collection['ledger']['module_name'];
									 $table_name = @$collection['ledger']['table_name'];
									 if($table_name == "cash_bank")
									 {
									 $module_id = (int)@$collection['ledger']['module_id']; 	 
									 }
									 
									  
                                     if($receipt_id == 'O_B')
									 continue;
/*
$module_fetch2 = $this->requestAction(array('controller' => 'hms', 'action' => 'module_fetch'),array('pass'=>array($module_id)));
                                    foreach ($module_fetch2 as $collection) 
									{
									$module_name = @$collection['account_category']['ac_category'];
									$module_name2 = @$collection['account_category']['module_name'];
									}
									*/
if($table_name == "cash_bank")
{
$module_date_fetch2 = $this->requestAction(array('controller' => 'hms', 'action' => 'module_main_fetch5'),array('pass'=>array($table_name,$receipt_id,$module_id)));	
}
else
{
$module_date_fetch2 = $this->requestAction(array('controller' => 'hms', 'action' => 'module_main_fetch'),array('pass'=>array($table_name,$receipt_id)));
}
									foreach ($module_date_fetch2 as $collection) 
									{
									$date = @$collection[$table_name]['transaction_date'];
									if(empty($date))
									{
									$date = @$collection[$table_name]['posting_date'];	
									}
									if(empty($date))
									{
									$date = @$collection[$table_name]['purchase_date'];	
									}
									if(empty($date))
									{
									$date = @$collection[$table_name]['date'];	
									}
									$narration = @$collection[$table_name]['narration'];
									$remark = @$collection[$table_name]['remark'];
									}

if($amount_category_id == 1)
{
$amount_category = "Debit";
}
else if($amount_category_id == 2)
{
$amount_category = "Credit";	
}
/*
$amount_category_fetch2 = $this->requestAction(array('controller' => 'hms', 'action' => 'amount_category'),array('pass'=>array($amount_category_id)));
foreach ($amount_category_fetch2 as $collection) 
{
$amount_category = @$collection['amount_category']['amount_category'];
}
*/

									
									if($sub_account_id == $sub_id)
									     {
										if(@$date >= $m_from && @$date <= $m_to)
								         {
											 if($account_type == 1)
											 {
											 $nnn = 5;
											 $date = date('d-m-Y',$date->sec);	
      								?>
																			
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
										
										<?php }}}} ?>
										
										
<?php 
}
else
{
?>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>

 
									<?php
                                    
$ledger_account_fetch = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_amount'),array('pass'=>array($main_id)));
								    foreach ($ledger_account_fetch as $collection) 
									{
									$group_id = (int)$collection['ledger_account']['group_id'];
								    $user_name = $collection['ledger_account']['ledger_name'];	
									}

$accounts_group = $this->requestAction(array('controller' => 'hms', 'action' => 'accounts_group'),array('pass'=>array($group_id)));
                                    foreach ($accounts_group as $collection) 
									{
								    $ledger_type_name = $collection['accounts_group']['group_name'];	
									}
									
									
									?>

                                 

<?php 
 									
									$opening_balance = 0;
									foreach ($cursor3 as $collection) 
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
                                    $table_name = $collection['ledger']['table_name'];
									$module_name = $collection['ledger']['module_name'];
									if($table_name == "cash_bank")
									{
									$module_id = $collection['ledger']['module_id'];	
									}
									 if($receipt_id == 'O_B')
                                     continue;
                                     

/*
$account_category_fetch = $this->requestAction(array('controller' => 'hms', 'action' => 'module_fetch'),array('pass'=>array($module_id)));										
										foreach ($account_category_fetch as $collection) 
										{
										$module_name = @$collection['account_category']['ac_category'];
										}
										*/

if($table_name == "cash_bank")
{
$module_date_fetch3 = $this->requestAction(array('controller' => 'hms', 'action' => 'module_main_fetch5'),array('pass'=>array($table_name,$receipt_id,$module_id)));   	
}
else
{
$module_date_fetch3 = $this->requestAction(array('controller' => 'hms', 'action' => 'module_main_fetch'),array('pass'=>array($table_name,$receipt_id)));   
}

									foreach ($module_date_fetch3 as $collection) 
									{
									$date1 = @$collection[$table_name]['transaction_date'];
									if(empty($date1))
									{
									$date1 = @$collection[$table_name]['posting_date'];	
									}
									if(empty($date1))
									{
									$date1 = @$collection[$table_name]['purchase_date'];	
									}
									if(empty($date1))
									{
									$date1 = @$collection[$table_name]['date'];	
									}
									$narration = @$collection[$table_name]['narration'];
									$remark = @$collection[$table_name]['remark'];
									}

if($amount_category_id == 1)
{
$amount_category = "Debit";	
}
else if($amount_category_id == 2)
{
$amount_category = "Credit";		
}
/*									
$amount_category_fetch3 = $this->requestAction(array('controller' => 'hms', 'action' => 'amount_category'),array('pass'=>array($amount_category_id)));
									foreach ($amount_category_fetch3 as $collection) 
									{
									$amount_category = @$collection['amount_category']['amount_category'];
									} 
*/
									
									if($sub_account_id == $main_id)
	                                {
									
									if(@$date1 < $m_from)
									{
								   if($account_type == 2)
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
									}
									} 


 ?>
                                   
									
                                    <?php
                                    $balance = $opening_balance;
									?>
													
										
										
								<?php
									$total_debit = 0;
									$total_credit = 0;
									foreach ($cursor3 as $collection) 
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
                                     $table_name = @$collection['ledger']['table_name'];
									 $module_name = @$collection['ledger']['module_name'];
									 if($table_name == "cash_bank")
									 {
									 $module_id = (int)$collection['ledger']['module_id'];	 
									 }
									 
									 if($receipt_id == 'O_B')
									 continue;
/*									  
$account_category_fetch2 = $this->requestAction(array('controller' => 'hms', 'action' => 'module_fetch'),array('pass'=>array($module_id)));										
									foreach ($account_category_fetch2 as $collection) 
									{
									$module_name = @$collection['account_category']['ac_category'];
									$module_name2 = @$collection['account_category']['module_name'];
									}
									*/
if($table_name == "cash_bank")
{
$module_date_fetch4 = $this->requestAction(array('controller' => 'hms', 'action' => 'module_main_fetch5'),array('pass'=>array($table_name,$receipt_id,$module_id))); 	
}
else
{
$module_date_fetch4 = $this->requestAction(array('controller' => 'hms', 'action' => 'module_main_fetch'),array('pass'=>array($table_name,$receipt_id)));   
}
									
									foreach ($module_date_fetch4 as $collection) 
									{
									$date = @$collection[$table_name]['transaction_date'];
									if(empty($date))
									{
									$date = @$collection[$table_name]['posting_date'];	
									}
									if(empty($date))
									{
									$date = @$collection[$table_name]['purchase_date'];	
									}
									if(empty($date))
									{
									$date = @$collection[$table_name]['date'];	
									}
									$narration = @$collection[$table_name]['narration'];
									$remark = @$collection[$table_name]['remark'];
									}
	
if($amount_category_id == 1)
{
$amount_category = "Debit";	
}
else if($amount_category_id == 2)
{
$amount_category = "Credit";	
}
/*									
$amount_category_fetch4 = $this->requestAction(array('controller' => 'hms', 'action' => 'amount_category'),array('pass'=>array($amount_category_id)));
foreach ($amount_category_fetch4 as $collection) 
{
$amount_category = @$collection['amount_category']['amount_category'];
}  
*/
									
									if($sub_account_id == $main_id)
									{
										if(@$date >= $m_from && @$date <= $m_to)
								         {
											if($account_type == 2)
											{
										$nnn = 5;
											 $date = date('d-m-Y',$date->sec);	
									 
									 	?>
										
										
										
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
										
										 <?php }}}} ?>
							   
							   
								
								
								   
								
                                
                                
								
	<?php } ?>								 

<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////?>

<?php if($nnn == 5) { ?>

<?php
$m_from = date("Y-m-d", strtotime($date111));
$m_from = new MongoDate(strtotime($m_from));

$m_to = date("Y-m-d", strtotime($date222));
$m_to = new MongoDate(strtotime($m_to));

$opening_balance = 0;
$closing_balance = 0;
?>
<div style="width:100%;" class="hide_at_print">
<span style="margin-left:80%;">
<a href="ledger_excel?f=<?php echo $date111; ?>&t=<?php echo $date222; ?>&m=<?php echo $main_id; ?>&s=<?php echo $sub_id; ?>" class="btn blue">Export in Excel</a>
<button type="button" class=" printt btn green" onclick="window.print()"><i class="icon-print"></i> Print</button></span>
</div>
<br />
<?php

if($main_id == 34 || $main_id == 15 || $main_id == 33 || $main_id == 35)
{
?>
<table class="table table-bordered" style="width:100%; background-color:#FDFDEE;">
<?php
$cursor1 = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_amount'),array('pass'=>array($main_id)));
                                    foreach ($cursor1 as $collection) 
									{
								    $ledger_type_name = $collection['ledger_account']['ledger_name'];	
									}
$cursor2 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($sub_id)));	
                                    foreach ($cursor2 as $collection) 
									{
								    $user_name = $collection['ledger_sub_account']['name'];	
									}
					                ?>              
					
					
                                    <tr>
                                    <th colspan = "6" style="text-align:center;">
                                    <?php echo $society_name; ?>
                                    </th>
                                    </tr>
                                    <tr>
                                    <th colspan = "6" style="text-align:center;">
                                    Transaction for The Period <?php echo $date111; ?> to <?php echo $date222; ?>
                                    </th>
                                    </tr>
					
<tr>
<th><?php echo @$user_name; ?>  A/c</th>
<th>Grouping :<?php echo @$ledger_type_name; ?></th>
<th colspan="4"></th>
</tr>
							
									<?php
                                     $close = 0;
                                     $opening_balance = 0;
									 foreach ($cursor3 as $collection) 
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
                                     $op_date = @$collection['ledger']['op_date'];
									 $table_name = $collection['ledger']['table_name'];
									 $module_name = $collection['ledger']['module_name'];
									 if($table_name == "cash_bank")
									 {
									 $module_id = (int)$collection['ledger']['module_id'];	 
									 }
										$op_im_deb = 0;
										$op_im_cre = 0;
									
if($receipt_id == 'O_B')
{
if($sub_account_id == $sub_id)
{
if($account_type == 1)
{
									 if($amount_category_id == 1)
									 {
									 $op_im_deb = $amount_o; 
									 }
									 else
									 {
									 $op_im_cre = $amount_o; 	 
									 }
									 }
}}
/*
$module_fetch=$this->requestAction(array('controller'=>'hms','action'=>'module_fetch'),array('pass'=>array($module_id)));										
foreach ($module_fetch as $collection) 
{
$module_name = @$collection['account_category']['ac_category'];
}
*/
if($table_name == "cash_bank")
{
$module_date_fetch = $this->requestAction(array('controller' => 'hms', 'action' => 'module_main_fetch5'),array('pass'=>array($table_name,$receipt_id,$module_id)));	
}
else
{
$module_date_fetch = $this->requestAction(array('controller' => 'hms', 'action' => 'module_main_fetch'),array('pass'=>array($table_name,$receipt_id)));
}
 		
										foreach ($module_date_fetch as $collection) 
										{
										$date1 = @$collection[$table_name]['transaction_date'];
										if(empty($date1))
										{
										$date1 = @$collection[$table_name]['posting_date'];	
										}
										if(empty($date1))
										{
										$date1 = @$collection[$table_name]['purchase_date'];	
										}
										if(empty($date1))
										{
										$date1 = @$collection[$table_name]['date'];	
										}
										$narration = @$collection[$table_name]['narration'];
										$remark = @$collection[$table_name]['remark'];
										}
if($amount_category_id == 1)
{
$amount_category = "Debit";	
}
else if($amount_category_id == 2)
{
$amount_category = "Credit";		
}
/*
$amount_category_fetch = $this->requestAction(array('controller' => 'hms', 'action' => 'amount_category'),array('pass'=>array($amount_category_id)));										
foreach ($amount_category_fetch as $collection) 
{
$amount_category = @$collection['amount_category']['amount_category'];
}
*/
								if($sub_account_id == $sub_id)
								{
								if(@$date1 < $m_from)
								{
								if($account_type == 1)
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
								}
								if($op_date < $m_from)
								{
								$opening_balance = $opening_balance + $op_im_cre - $op_im_deb;
								}
								else
								{
								$close	= $close + $op_im_cre - $op_im_deb;
								}
								}
								  ?>
                                    <tr>
                                    <th colspan="3"></th>
                                    <th colspan="2">Opening Balance:</th>
                                    <th><?php
									$opening_balance = $opening_balance;
                                   	$op_bal2 = $opening_balance;
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
									foreach ($cursor3 as $collection) 
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
                                     $table_name = $collection['ledger']['table_name'];
									 $module_name = $collection['ledger']['module_name'];
									 if($table_name == "cash_bank")
									 {
									 $module_id = (int)$collection['ledger']['module_id']; 
									 }
									 if($receipt_id == 'O_B')
									 continue;
									 /*
$module_fetch2 = $this->requestAction(array('controller' => 'hms', 'action' => 'module_fetch'),array('pass'=>array($module_id)));
                                    foreach ($module_fetch2 as $collection) 
									{
									$module_name = @$collection['account_category']['ac_category'];
									$module_name2 = @$collection['account_category']['module_name'];
									}
									*/
if($table_name == "cash_bank")	
{								
$module_date_fetch2 = $this->requestAction(array('controller' => 'hms', 'action' => 'module_main_fetch5'),array('pass'=>array($table_name,$receipt_id,$module_id)));									
}
else
{
									$module_date_fetch2 = $this->requestAction(array('controller' => 'hms', 'action' => 'module_main_fetch'),array('pass'=>array($table_name,$receipt_id)));
}
									foreach ($module_date_fetch2 as $collection) 
									{
									$date = @$collection[$table_name]['transaction_date'];
									if(empty($date))
									{
									$date = @$collection[$table_name]['posting_date'];	
									}
									if(empty($date))
									{
									$date = @$collection[$table_name]['purchase_date'];	
									}
									if(empty($date))
									{
									$date = @$collection[$table_name]['date'];	
									}
									$narration = @$collection[$table_name]['narration'];
									if(empty($narration))
									{
									$narration = @$collection[$table_name]['remark'];
									}
									if(empty($narration))
									{
									$narration = @$collection[$table_name]['description'];	
									}
									$remark = @$collection[$table_name]['remark'];
									}

if($amount_category_id == 1)
{
$amount_category = "Debit";	
}
else if($amount_category_id == 2)
{
$amount_category = "Credit";		
}
/*									
$amount_category_fetch2 = $this->requestAction(array('controller' => 'hms', 'action' => 'amount_category'),array('pass'=>array($amount_category_id)));
foreach ($amount_category_fetch2 as $collection) 
{
$amount_category = @$collection['amount_category']['amount_category'];
}
*/
									
									if($sub_account_id == $sub_id)
									     {
										if(@$date >= $m_from && @$date <= $m_to)
								         {
											 if($account_type == 1)
											 {
											
											 $date = date('d-m-Y',$date->sec);	
      								?>
									 <tr>
											<td><?php echo $date; ?></td>
                                            <td><?php echo $narration; ?></td>
											<td><?php echo $module_name; ?></td>
											<td><?php echo $receipt_id; ?></td>
											
											<td><?php if($amount_category_id == 1) { $balance = $balance - $amount;   
											$amount = number_format($amount);
											echo $amount; } else { echo "-"; } ?></td>
										    <td><?php if($amount_category_id == 2) { $balance = $balance + $amount;  
											 $amount = number_format($amount);
											 echo $amount; } else { echo "-"; } ?></td>
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
										$closing_balance = $op_bal2 - $total_debit + $total_credit + ($close);
										?>
										
										<?php }}}} ?>
										<tr>
										<th colspan="4" style="text-align:right;"><b> Total </b></th>

										<th><?php 
										$total_debit = number_format($total_debit);
										echo $total_debit; ?>  <?php //echo "    dr"; ?></th>
										<th><?php 
										$total_credit = number_format($total_credit);
										echo $total_credit; ?> <?php //echo "    cr"; ?></th>
										
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
										$opening_balance = number_format($opening_balance);
										echo $opening_balance; ?></th>
										<th colspan="" style="text-align:center;"><?php 
										$total_debit = number_format($total_debit);
										echo $total_debit ?></th>
									
										<th style="text-align:center;"><?php 
										$total_credit = number_format($total_credit);
										echo $total_credit; ?></th>
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
										$closing_balance = number_format($closing_balance);
										echo $closing_balance; ?></th>
										</tr>

									
										</table>
										</center>
<?php 
}
else
{
?>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>

 <table class="table table-bordered" style="width:100%; background-color:#FDFDEE;">
                                    
									<?php
                                    
$ledger_account_fetch = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_amount'),array('pass'=>array($main_id)));
								    foreach ($ledger_account_fetch as $collection) 
									{
									$group_id = (int)$collection['ledger_account']['group_id'];
								    $user_name = $collection['ledger_account']['ledger_name'];	
									}

$accounts_group = $this->requestAction(array('controller' => 'hms', 'action' => 'accounts_group'),array('pass'=>array($group_id)));
                                    foreach ($accounts_group as $collection) 
									{
								    $ledger_type_name = $collection['accounts_group']['group_name'];	
									}
									
									
									?>

                                 
								<tr>
								<th colspan = "6" style="text-align:center;">
							    <?php echo $society_name; ?>
								</th>
								</tr>



								 <tr>
								  <th colspan = "6" style="text-align:center;">
								  Transaction for The Period <?php echo $date111; ?> to <?php echo $date222; ?>
								  </th>
					              </tr>








                                    <tr>
                                     <th><?php echo @$user_name; ?>  A/c</th>
                                     <th>Grouping : <?php echo @$ledger_type_name; ?></th>
                                    <th colspan="4"></th>
                                    </tr>


<?php 
 									//$op_im_deb = 0;
									//$op_im_cre = 0;
									$close = 0;
									$opening_balance = 0;
									foreach ($cursor3 as $collection) 
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
                                    $op_date = @$collection['ledger']['op_date'];
                                    $table_name = @$collection['ledger']['table_name'];
									$module_name = @$collection['ledger']['module_name'];
									if($table_name == "cash_bank")
									{
									$module_id = $collection['ledger']['module_id'];
									}
									
									$op_im_deb = 0;
                                    $op_im_cre = 0;
									if($receipt_id == 'O_B')
									{
									if($sub_account_id == $main_id)
	                                {
                                    if($account_type == 2)
									{
									if($amount_category_id == 1)
									{
									$op_im_deb = $amount_o; 
									}
									else
									{
									$op_im_cre =  $amount_o; 	 
									}
									 }}
									}







/*
$account_category_fetch = $this->requestAction(array('controller' => 'hms', 'action' => 'module_fetch'),array('pass'=>array($module_id)));										
foreach ($account_category_fetch as $collection) 
{
$module_name = @$collection['account_category']['ac_category'];
}
*/
if($table_name == "cash_bank")
{
$module_date_fetch3 = $this->requestAction(array('controller' => 'hms', 'action' => 'module_main_fetch5'),array('pass'=>array($table_name,$receipt_id,$module_id)));	
}
else
{
	
$module_date_fetch3 = $this->requestAction(array('controller' => 'hms', 'action' => 'module_main_fetch'),array('pass'=>array($table_name,$receipt_id)));   
}
	
	
									foreach ($module_date_fetch3 as $collection) 
									{
									$date1 = @$collection[$table_name]['transaction_date'];
									if(empty($date1))
									{
									$date1 = @$collection[$table_name]['posting_date'];	
									}
									if(empty($date1))
									{
									$date1 = @$collection[$table_name]['purchase_date'];	
									}
									if(empty($date1))
									{
									$date1 = @$collection[$table_name]['date'];	
									}
									$narration = @$collection[$table_name]['narration'];
									$remark = @$collection[$table_name]['remark'];
									}

if($amount_category_id == 1)
{
$amount_category = "Debit";	
}
else if($amount_category_id == 1)
{
$amount_category = "Credit";		
}
/*
$amount_category_fetch3 = $this->requestAction(array('controller' => 'hms', 'action' => 'amount_category'),array('pass'=>array($amount_category_id)));
									foreach ($amount_category_fetch3 as $collection) 
									{
									$amount_category = @$collection['amount_category']['amount_category'];
									} 
*/
									
									if($sub_account_id == $main_id)
	                                {
									if(@$date1 < $m_from)
									{
								    if($account_type == 2)
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
									}
									
									if($op_date < $m_from)
									{
									$opening_balance = $opening_balance + $op_im_cre - $op_im_deb;
									}
									else
									{
									$close = $close + $op_im_cre - $op_im_deb;
									}
       								} 


 ?>
                                    <tr>
                                    <th colspan="3"></th>
                                    <th colspan="2">Opening Balance:</th>
                                    <th><?php 
									$opening_balance = $opening_balance;
									$op_bal2 = $opening_balance;
									if($opening_balance > 0)
									{
									$opening_balance = $opening_balance.'&nbsp;&nbsp;Cr';
									}
									else if($opening_balance < 0)
									{
									$opening_balance = abs($opening_balance);
									$opening_balance = $opening_balance.'&nbsp;&nbsp;Dr';
									}
									$opening_balance = number_format($opening_balance);
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
									foreach ($cursor3 as $collection) 
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
                                     $table_name = @$collection['ledger']['table_name'];                                     
									 $module_name = @$collection['ledger']['module_name'];
									 if($table_name == "cash_bank")
									 {
									 $module_id = $collection['ledger']['module_id'];	 
									 }
									 
									 if($receipt_id == 'O_B')
									 continue;
									 /*
$account_category_fetch2 = $this->requestAction(array('controller' => 'hms', 'action' => 'module_fetch'),array('pass'=>array($module_id)));										
									foreach ($account_category_fetch2 as $collection) 
									{
									$module_name = @$collection['account_category']['ac_category'];
									$module_name2 = @$collection['account_category']['module_name'];
									}
									*/
									
if($table_name == "cash_bank")
{
$module_date_fetch4 = $this->requestAction(array('controller' => 'hms', 'action' => 'module_main_fetch5'),array('pass'=>array($table_name,$receipt_id,$module_id)));	
}
else
{
$module_date_fetch4 = $this->requestAction(array('controller' => 'hms', 'action' => 'module_main_fetch'),array('pass'=>array($table_name,$receipt_id)));   
}
									
									foreach ($module_date_fetch4 as $collection) 
									{
									$date = @$collection[$table_name]['transaction_date'];
									if(empty($date))
									{
									$date = @$collection[$table_name]['posting_date'];	
									}
									if(empty($date))
									{
									$date = @$collection[$table_name]['purchase_date'];	
									}
									if(empty($date))
									{
									$date = @$collection[$table_name]['date'];	
									}
									$narration = @$collection[$table_name]['narration'];
									if(empty($narration))
									{
									$narration = @$collection[$table_name]['remark'];
									}
									if(empty($narration))
									{
									$narration = @$collection[$table_name]['description'];	
									}
									$remark = @$collection[$table_name]['remark'];
									}
									
	if($amount_category_id == 1)
	{
	$amount_category = "Debit";	
	}
	else if($amount_category_id == 2)
	{
	$amount_category = "Credit";	
	}
									/*
									$amount_category_fetch4 = $this->requestAction(array('controller' => 'hms', 'action' => 'amount_category'),array('pass'=>array($amount_category_id)));
									foreach ($amount_category_fetch4 as $collection) 
									{
									$amount_category = @$collection['amount_category']['amount_category'];
									}  
									*/
									
									if($sub_account_id == $main_id)
									{
										if(@$date >= $m_from && @$date <= $m_to)
								         {
											if($account_type == 2)
											{
										
											 $date = date('d-m-Y',$date->sec);	
                                         
 										    
									 	?>
										
										<tr>
											<td><?php echo $date; ?></td>
                                            <td><?php echo $narration; ?></td>
											<td><?php echo $module_name; ?></td>
											<td><?php echo $receipt_id; ?></td>
											
											<td><?php if($amount_category_id == 1) { $balance = $balance - $amount;   
											$amount = number_format($amount);
											echo $amount; } else { echo "-"; } ?></td>
										    <td><?php if($amount_category_id == 2) { $balance = $balance + $amount;   
											 $amount = number_format($amount);
											 echo $amount; } else { echo "-"; } ?></td>
										    
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
                                        $closing_balance = $op_bal2 - $total_debit + $total_credit + ($close);
										?>
										
										 <?php }}}} ?>
							   
							   <tr>
                               <th colspan="4" style="text-align:right;"><b> Total </b></th>
                               <th><?php 
							   $total_debit = number_format($total_debit);
							   echo $total_debit; ?>  <?php //echo "    dr"; ?></th>
                               <th><?php 
							    $total_credit = number_format($total_credit);
							   echo $total_credit; ?> <?php //echo "    cr"; ?></th>
                               
                                </tr>
								
								 <tr>
                                <th style="text-align:center;">Opening Balance:</th>
                                <th style="text-align:center;">Total Debits
								
								
							</th>
								<th style="text-align:center;">Total Credits</th>
								<th colspan="3" style="text-align:center;">
								Closing balance
								
								
								</th>
                                </tr> 
								   
								<tr>
                                <th style="text-align:center;">
								<?php 
								if($opening_balance > 0)
								{
								$opening_balance = $opening_balance;
								}
								else if($opening_balance < 0)
								{
								$opening_balance = abs($opening_balance);
								$opening_balance = $opening_balance;
								}
								$opening_balance = number_format($opening_balance);
								echo $opening_balance; ?>
								</th>
                                <th colspan="" style="text-align:center;"><?php 
								$total_debit = number_format($total_debit);
								echo $total_debit ?></th>
                                <th style="text-align:center;"><?php 
								$total_credit = number_format($total_credit);
								echo $total_credit; ?></th>
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
								$closing_balance = number_format($closing_balance);
								echo $closing_balance;
								?></th>
                                </tr>
                                
                                
								 </table>	
	<?php } ?>		

<?php } 
else if($nnn == 1)
{
?>

<!----alert-------------->
		<div class="modal-backdrop fade in"></div>
        <div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
			<div class="modal-body" style="font-size:16px;">
            No Transaction Found In Selected Period
             </div> 
			<div class="modal-footer">
			<a href="ledger"   class="btn green">OK</a>
			</div>
		</div>
      <!----alert-------------->










<?php } ?>	