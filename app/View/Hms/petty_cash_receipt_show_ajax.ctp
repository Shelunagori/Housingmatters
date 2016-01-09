                                        
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
<span style="float:right;"><a href="petty_cash_receipt_excel?f=<?php echo $from; ?>&t=<?php echo $to; ?>" class="btn blue">Export in Excel</a></span>
<span style="float:right; margin-right:1%;"><button type="button" class=" printt btn green" onclick="window.print()"><i class="icon-print"></i> Print</button></span>
</div>
<br /><br />



<table class="table table-bordered" width="100%" style="background-color:#FDFDEE;">

<tr>
<th colspan="6" style="text-align:center;">
<p style="font-size:16px;">
Petty Cash Receipt Report  (<?php echo $society_name; ?>) </p>
</th>
</tr>


<tr>
<th>From : <?php echo $from; ?></th>
<th>To : <?php echo $to; ?></th>
<th colspan="4"></th>
</tr>
			
			
			<tr>
			<th>PC Receipt#</th>
			<th>Transaction Date</th>
			<th>Narration</th>
			<th>Received From</th>
			<th>Amount</th>
			<th class="hide_at_print">Action</th>
			</tr>
			

			<?php
			
			$n=1;
			$total_credit = 0;
			$total_debit = 0;
			foreach ($cursor1 as $collection) 
			{

			$receipt_no = @$collection['cash_bank']['receipt_id'];
			$transaction_id = (int)$collection['cash_bank']['transaction_id'];	
			$account_type = (int)$collection['cash_bank']['account_type'];    									  
			$d_user_id = (int)$collection['cash_bank']['user_id'];
			$date = $collection['cash_bank']['transaction_date'];
			$prepaired_by = (int)$collection['cash_bank']['prepaired_by'];   
			$narration = $collection['cash_bank']['narration'];
			$account_head = $collection['cash_bank']['account_head'];
			$amount = $collection['cash_bank']['amount'];
			$amount_category_id = (int)$collection['cash_bank']['amount_category_id'];
			$prepaired_by = (int)$collection['cash_bank']['prepaired_by'];   
			$current_date = $collection['cash_bank']['current_date'];
	
	$creation_date = date('d-m-Y',$current_date->sec);
	
	$result_gh = $this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'),array('pass'=>array($prepaired_by)));
				foreach ($result_gh as $collection) 
				{
				$prepaired_by_name = (int)$collection['user']['user_name'];
				}			



			if($account_type == 1)
				{
				
$user_id1 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($d_user_id)));
				foreach ($user_id1 as $collection)
				{
				$user_id = $collection['ledger_sub_account']['user_id'];
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
			

				if($account_type == 2)
				{
$user_name1 = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_amount'),array('pass'=>array($d_user_id)));
				foreach ($user_name1 as $collection)
				{
				$user_name = $collection['ledger_account']['ledger_name'];
				$wing_flat = "";
				}
				}
			
			
			$result2 = $this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'),array('pass'=>array($prepaired_by)));
				foreach ($result2 as $collection) 
				{
				$prepaired_by_name = $collection['user']['user_name'];   
				$society_id = $collection['user']['society_id'];  	
				}	
			
	$amount_cat1 = $this->requestAction(array('controller' => 'hms', 'action' => 'amount_category'),array('pass'=>array($amount_category_id)));
				foreach ($amount_cat1 as $collection) 
				{
				$amount_category_name = $collection['amount_category']['amount_category'];	
				}			
			
			
			
				if($date >= $m_from && $date <= $m_to)
				{
				if($s_user_id == $d_user_id)  
				{
				$date = date('d-m-Y',$date->sec);
				$total_debit = $total_debit + $amount;
			    $amount = number_format($amount);
			   
			    ?>
                                        <tr>
											
                                            <td><?php echo $receipt_no; ?> </td>
											<td><?php echo $date; ?> </td>
                                            <td><?php echo $narration; ?> </td>
                                            <td><?php echo $user_name; ?>  &nbsp&nbsp&nbsp&nbsp<?php echo @$wing_flat; ?> </td>
                                            <td><?php echo $amount; ?></td>
     <td class="hide_at_print"><a href="petty_cash_receipt_pdf?c=<?php echo $transaction_id; ?>" class="btn mini purple tooltips" data-placement="bottom" 
	 data-original-title="Download Pdf" target="_blank">Pdf</a>
	 <a class="btn mini black tooltips" data-placement="bottom"   data-original-title="Created By:<?php echo $prepaired_by_name; ?>
										   Creation Date : <?php echo $creation_date; ?>">!</a>
	 
	 
	 
                                          </td>
										    </tr>
									  <?php
                                        }
									   else
									   if($s_role_id == 3)
									   {
										   
										  $date = date('d-m-Y',$date->sec);  
										 $total_debit = $total_debit + $amount;
										 $amount = number_format($amount);
										 ?>
										   <tr>
											
                                            <td><?php echo $receipt_no; ?> </td>
											<td><?php echo $date; ?> </td>
                                            <td><?php echo $narration; ?> </td>
                                            <td><?php echo $user_name; ?>  &nbsp&nbsp&nbsp&nbsp<?php echo @$wing_flat; ?> </td>
                                            <td><?php echo $amount; ?></td>
                                            
                                            <td class="hide_at_print">
                                            <a href="petty_cash_receipt_pdf?c=<?php echo $transaction_id; ?>" class="btn mini purple tooltips"  data-placement="bottom" data-original-title="Download Pdf" target="_blank">Pdf</a>
                                            <a class="btn mini black tooltips" data-placement="bottom"   data-original-title="Created By:<?php echo $prepaired_by_name; ?>
										   Creation Date : <?php echo $creation_date; ?>">!</a>
										   
										   </td>
                                         
										
                                        </tr>
									  <?php   
									  }}}
									  ?> 
                                      <tr>
                                      <th colspan="4">Total</th>
                                      <th><?php 
									  $total_debit = number_format($total_debit);
									  echo $total_debit; ?></th>  
                                      <th class="hide_at_print"></th>
                                      </tr>
                                      </table>  
                                        
                             
                                        
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
	