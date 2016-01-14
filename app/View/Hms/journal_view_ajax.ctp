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
<a href="journal_excel?f=<?php echo $from; ?>&t=<?php echo $to; ?>" class="btn blue">Export In Excel</a>
<button type="button" class=" printt btn green" onclick="window.print()"><i class="icon-print"></i> Print</button></span>
</div>
<br />
<table width="100%" style="background-color:#FDFDEE;" class="table table-bordered">
<tr>
<th colspan="7" style="text-align:center;">
<p style="font-size:16px;">
Journal Report  (<?php echo $society_name; ?>)
</p>
</th>
</tr>

<tr>
<th>From : <?php echo $from; ?></th>
<th>To : <?php echo $to; ?></th>
<th colspan="5"></th>
</tr>

                                        <tr>
                                            <th>Journal #</th>
											<th>Transaction Date</th>
                                            <th>Ledger A/c</th>
                                            <th>Remarks</th>
                                            <th>Debit</th>
                                            <th>Credit</th>
											<th class="hide_at_print">Action</th>
                                        </tr>
										
										
										   <?php
									$total_debit = 0;
									$total_credit = 0;
				
				foreach ($cursor1 as $collection) 
				{
			    $auto_id = (int)$collection['journal']['auto_id'];
				$receipt_no = $collection['journal']['receipt_id']; 
				$user_id = (int)$collection['journal']['user_id'];
				$date = $collection['journal']['transaction_date'];
				$amount = $collection['journal']['amount'];
				$amount_category_id = (int)$collection['journal']['amount_category_id'];
				$remark = $collection['journal']['remark'];                                     
				$account_type = (int)$collection['journal']['account_type']; 
				$ledger_type_id = (int)$collection['journal']['ledger_type_id'];
                $approver = (int)$collection['journal']['approver'];
				$current_date = $collection['journal']['current_date'];
				
				$creation_date = date('d-m-Y',$current_date->sec);

$resultacc = $this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'),array('pass'=>array($approver)));
foreach($resultacc as $collection)
{
$prepaired_by_name = $collection['user']['user_name'];
}
				
if($account_type == 1)
{ 
$result_lsa = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($user_id)));
foreach ($result_lsa as $collection) 
{
$user_name = $collection['ledger_sub_account']['name']; 
}								 
}	
				  
if($account_type == 2)
{
$result_la = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_amount'),array('pass'=>array($ledger_type_id)));
foreach ($result_la as $collection) 
{
$user_name = $collection['ledger_account']['ledger_name']; 
}
}																		
									  
if($date >= $m_from && $date <= $m_to)
{
$date2 = date('d-m-Y',$date->sec);  
     if($amount_category_id == 1)
     {
     $total_debit = $total_debit + $amount;
     }
     else if($amount_category_id == 2)
     {
     $total_credit = $total_credit + $amount;  
     }
     $amount = number_format($amount);
	 ?>								  
		<tr>
		<td><?php echo $receipt_no; ?> </td>
		<td><?php echo $date2; ?> </td>
		<td><?php echo $user_name; ?></td>
		<td><?php echo $remark; ?> </td>
		<td>
		<?php if($amount_category_id == 1) {
		echo $amount; } else { echo"-";} ?> </td>

		<td><?php if($amount_category_id == 2) {
		echo $amount; } else { echo"-"; } ?></td>
		<td class="hide_at_print">
		 <a href="journal_pdf?c=<?php echo $auto_id; ?>" class="btn mini purple tooltips"  data-placement="bottom" data-original-title="Download Pdf" target="_blank">Pdf</a>
		<a href="" class="btn mini black tooltips" data-placement="bottom" data-original-title="Created By:<?php echo $prepaired_by_name; ?>
										     Creation Date : <?php echo $creation_date; ?>" >!</a>
		</td>
		
		
		</tr>

		<?php
		}}
		?>  									  
			
			<tr>
			<th colspan="4">Total</th>
			<th><?php 
			$total_debit = number_format($total_debit);
			echo $total_debit; ?></th>
			<th><?php
			$total_credit = number_format($total_credit);
			echo $total_credit; ?></th>
<th class="hide_at_print"></th>			
			</tr>
			</table>							

									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  
									  