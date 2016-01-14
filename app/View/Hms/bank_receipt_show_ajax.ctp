<script>
$(document).ready(function(){
jQuery('.tooltips').tooltip();
});
</script> 
<?php
$m_from = date("Y-m-d", strtotime($from));
$m_from = new MongoDate(strtotime($m_from));

$m_to = date("Y-m-d", strtotime($to));
$m_to = new MongoDate(strtotime($m_to));

?>
<div style="width:100%; overflow:auto;" class="hide_at_print">
<span style="float:right;">
<a href="bank_receipt_excel?f=<?php echo $from; ?>&t=<?php echo $to; ?>" class="btn blue" target="_blank">Export in Excel</a></span>
<span style="float:right; margin-right:1%;"><button type="button" class=" printt btn green" onclick="window.print()"><i class="icon-print"></i> Print</button></span>
</div>	
<br />			
			
			
			 <table class="table table-bordered" width="100%" style=" background-color:#FDFDEE;">


					 
					 <tr>
					 <th colspan="10" style="text-align:center;">
					 <p style="font-size:16px;">
                     Bank Receipt Report  (<?php echo $society_name; ?>)
					 </p>
					 </th>
					 </tr>
					 
					 
                     <tr>
                     <th>From : <?php echo $from; ?></th>
                     <th>To : <?php echo $to; ?></th>
                     <th colspan="8"></th>
                     </tr>
                     
                     
                     <tr>
                     <th>Receipt#</th>
		             <th>Transaction Date </th>
                     <th>Party Name</th>
				     <th>Bill Reference</th>
                     <th>Payment Mode</th>
                     <th>Instrument/UTR</th>
                     <th>Deposit Bank</th>
                     <th>Narration</th>
                     <th>Amount</th>
                     <th class="hide_at_print">Action</th> 
                     </tr>
					 
					 
					 <?php
			$total_credit = 0;
			$total_debit = 0;
			foreach ($cursor2 as $collection) 
			{
			$receipt_no = $collection['cash_bank']['receipt_id'];
			$transaction_id = (int)$collection['cash_bank']['transaction_id'];	
			$date = $collection['cash_bank']['transaction_date'];
			$prepaired_by_id = (int)$collection['cash_bank']['prepaired_by'];
			$member = (int)$collection['cash_bank']['member'];
			$narration = $collection['cash_bank']['narration'];
			$receipt_mode = $collection['cash_bank']['receipt_mode'];
			$receipt_instruction = $collection['cash_bank']['receipt_instruction'];
			$account_id = (int)$collection['cash_bank']['account_head'];
			$amount = $collection['cash_bank']['amount'];
			$amount_category_id = (int)$collection['cash_bank']['amount_category_id'];
			$current_date = $collection['cash_bank']['current_date'];
					 
			if($member == 1)
			{
			
			$received_from_id = (int)$collection['cash_bank']['user_id'];
			$ref = $collection['cash_bank']['bill_reference'];
			$ref = "Bill No:".$ref;
			}
			
			if($member == 2)
			{
			$ref = $collection['cash_bank']['bill_reference'];
            $receiver_name = @$collection['cash_bank']['receiver_name'];
            }

			$creation_date = date('d-m-Y',$current_date->sec);		
			
			$result_prb = $this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'),array('pass'=>array($prepaired_by_id)));
			foreach ($result_prb as $collection) 
			{
			$prepaired_by_name = $collection['user']['user_name'];
			}	

if($member == 2)
{
$user_name = $receiver_name;
$wing_flat = "";
	
}						
else
{			
$result_lsa = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($received_from_id)));			
			foreach ($result_lsa as $collection) 
			{
			$user_id = (int)$collection['ledger_sub_account']['user_id'];	
			}						

									
			$result = $this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'),array('pass'=>array($user_id)));
			foreach ($result as $collection) 
			{
			$user_name = $collection['user']['user_name'];
			$wing_id = $collection['user']['wing'];  
			$flat_id = (int)$collection['user']['flat'];
			$tenant = (int)$collection['user']['tenant'];
			}	
			$wing_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'),array('pass'=>array($wing_id,$flat_id)));	
			
}			
			
$result_amt = $this->requestAction(array('controller' => 'hms', 'action' => 'amount_category'),array('pass'=>array($amount_category_id)));
									foreach ($result_amt as $collection) 
									{
									$amount_category = $collection['amount_category']['amount_category'];  
									}			
			
	$result_lsa2 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($account_id)));									
									foreach ($result_lsa2 as $collection) 
									{
									$account_no = $collection['ledger_sub_account']['name'];  
									}		
			
			
 
									  
										   if($date >= $m_from && $date <= $m_to)
										   {
										   if(@$user_id == @$s_user_id)
											   {
											   $date = date('d-m-Y',$date->sec);	
									
									
									 $total_debit =  $total_debit + $amount; 
									 $amount = number_format($amount);
									?>
									
									
									    <tr>
                                            <td><?php echo $receipt_no; ?> </td>
											<td><?php echo $date; ?> </td>
                                            <td width="15%"><?php echo $narration; ?> </td>
                                            <td><?php echo $user_name; ?> &nbsp&nbsp&nbsp&nbsp<?php echo $wing_flat; ?></td>
                                            <td><?php echo $ref; ?> </td>
                                            <td><?php echo $receipt_mode; ?> </td>
                                            <td><?php echo $receipt_instruction; ?> </td>
                                            <td><?php echo $account_no; ?> </td>
                                            <td><?php echo $amount; ?></td>
                                            
                                            <td class="hide_at_print"> <!--<a href="#" class="btn mini blue">Reverse</a> -->
                                            <a href="bank_receipt_pdf?c=<?php echo $transaction_id; ?>" class="btn mini purple  tooltips" target="_blank" data-placement="bottom" data-original-title="Download Pdf">Pdf</a>
                                             <a href="" class="btn mini black tooltips" data-placement="bottom" data-original-title="Created By:<?php echo $prepaired_by_name; ?>
										     Creation Date : <?php echo $creation_date; ?>">!</a>
											  <!-- <a href="bank_receipt_edit.php?a=<?php //echo $receipt_no; ?>" class="btn mini purple">Edit</a> -->
                                           
                                            </td>
										</tr>			
			 <?php
											}
											else if($s_role_id == 3)
											{
                                            $date = date('d-m-Y',$date->sec);
											$total_debit =  $total_debit + $amount; 
											$amount = number_format($amount);
											
                                            ?>
											<tr>
                                            <td><?php echo $receipt_no; ?> </td>
											<td><?php echo $date; ?> </td>
                                           
                                            <td><?php echo $user_name; ?> &nbsp&nbsp&nbsp&nbsp<?php echo $wing_flat; ?> </td>
                                            <td><?php echo $ref; ?> </td>
                                            <td><?php echo $receipt_mode; ?> </td>
                                            <td><?php echo $receipt_instruction; ?> </td>
                                            <td><?php echo $account_no; ?> </td>
                                             <td width="15%"><?php echo $narration; ?> </td>
                                            <td><?php echo $amount; ?></td>
                                            <td class="hide_at_print">
                                           <!-- <td><a href="#" class="btn mini blue">Reverse</a> -->
                                           <a href="bank_receipt_pdf?c=<?php echo $transaction_id; ?>" target="_blank" class="btn mini purple tooltips" data-placement="bottom" data-original-title="Download Pdf">Pdf</a>
                                             <a href="" class="btn mini black tooltips" data-placement="bottom" data-original-title="Created By:<?php echo $prepaired_by_name; ?>
										     Creation Date : <?php echo $creation_date; ?>">!</a>
                                            </td>
										</tr>
			
			
			
			
		<?php	}		 
				}} ?>
					<?php	
                                         
									   
										 ?> 

<tr>
                                        <th colspan="8"> Total</th>
                                        <th><?php 
										$total_debit = number_format($total_debit);
										echo $total_debit; ?> <?php //echo "  dr"; ?></th>
                                        <th class="hide_at_print"></th>
                                        </tr>										 
					</table> 
					 
					 
					 
					 
					 
					 
					 
					 
					 
					 
					 
					 
					 
					 
					 