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
<div style="width:100%;" class="hide_at_print">
<span style="margin-left:80%;">
<a href="my_flat_receipt_excel?f=<?php echo $from; ?>&t=<?php echo $to; ?>" class="btn blue">Export in Excel</a>
<button type="button" class=" printt btn green" onclick="window.print()"><i class="icon-print"></i> Print</button></span>
</div>	
<br /> 
 
 <table class="table table-bordered" width="100%" style=" background-color:#FDFDEE;">


					 
					 <tr>
					 <th colspan="10" style="text-align:center;">
					 <p style="font-size:16px;">
                     Bank Receipt Report (<?php echo $society_name; ?>)
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
			foreach ($cursor1 as $collection) 
			{
			$receipt_no = $collection['bank_receipt']['receipt_id'];
			$transaction_id = (int)$collection['bank_receipt']['transaction_id'];	
			$date = $collection['bank_receipt']['transaction_date'];
			$prepaired_by_id = (int)$collection['bank_receipt']['prepaired_by'];
			$member = (int)$collection['bank_receipt']['member'];
			$narration = $collection['bank_receipt']['narration'];
			$receipt_mode = $collection['bank_receipt']['receipt_mode'];
			$receipt_instruction = $collection['bank_receipt']['receipt_instruction'];
			$account_id = (int)$collection['bank_receipt']['sub_account_id'];
			$amount = $collection['bank_receipt']['amount'];
			$amount_category_id = (int)$collection['bank_receipt']['amount_category_id'];
			$current_date = $collection['bank_receipt']['current_date'];  
                     
                     
             if($member == 1)
			{
			$received_from_id = (int)$collection['bank_receipt']['user_id'];
			$ref = $collection['bank_receipt']['bill_reference'];
			$ref = "Bill No:".$ref;
			}        
                     
            $creation_date = date('d-m-Y',$current_date->sec);	         
            	$result_prb = $this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'),array('pass'=>array($prepaired_by_id)));
			foreach ($result_prb as $collection) 
			{
			$prepaired_by_name = $collection['user']['user_name'];
			}	         
   	$result = $this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'),array('pass'=>array($user_id)));
			foreach ($result as $collection) 
			{
			//$user_name = $collection['user']['user_name'];
			$wing_id = (int)$collection['user']['wing'];  
			$flat_id = (int)$collection['user']['flat'];
			$tenant = (int)$collection['user']['tenant'];
			}	
			$wing_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'),array('pass'=>array($wing_id,$flat_id)));	                  
                     
      $result_lsa2 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($account_id)));									
									foreach ($result_lsa2 as $collection) 
									{
									$account_no = $collection['ledger_sub_account']['name'];  
									}		
									
							 if($date >= $m_from && $date <= $m_to)
							 {
							 $tr_date = date('d-M-Y',$date->sec);
							 $total_debit = $total_debit + $amount		
							 
								?>	
							 <tr>
                                            <td><?php echo $receipt_no; ?> </td>
											<td><?php echo $tr_date; ?> </td>
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
			                 }
								?>	
							<tr>
                                        <th colspan="8"> Total</th>
                                        <th><?php echo $total_debit; ?> <?php //echo "  dr"; ?></th>
                                        <th class="hide_at_print"></th>
                                        </tr>										 
					</table> 		
									
									               
                     