<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<center>
<h3><b>Expense Tracker</b></h3>
</center>

<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<br>

	<center>
	<a href="expense_tracker_add" class="btn blue">Add</a>
	<!-- <a href="expense_tracker_edit" class="btn blue">Edit</a> -->
	<a href="expense_tracker_view" class="btn red">View</a>
	</center>
	<div align="right">
	<a href="report_excel_expense_tracker?c=<?php echo $vendor_id; ?>" class="btn " target="_new" style="margin-right:5%"> <img src="<?php echo $this->webroot ; ?>/Images/Download-icon.png"></a>
	</div>	   

<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>

         <center>
         <table class="table table-bordered" style="width:94%; background-color:#FDFDEE;">
					
					
					<tr>
					<th>Vendor</th>
					<th colspan="9"><?php echo $vendor_name; ?> </th>
					</tr>  
					
					  
                                      
					<tr>
					<th>Approver</th>
					<th>Expense Head</th>
					<th>Invoice Reference</th>
					<th>Invoice Date</th>
					<th>Due Date</th>
					<th>Posting Date</th>
					<th>Description</th>
					<th>Debit</th>
					
					<th></th>
					</tr>
					
<?php
         $total_debit = 0;
		 $total_credit = 0;
		 foreach($cursor2 as $collection)
         {		 
			
			$auto_id = (int)$collection['expense_tracker']['auto_id'];	
			$approver = (int)$collection['expense_tracker']['approver'];
			$expense_head = (int)$collection['expense_tracker']['expense_head'];
			$invoice_date = $collection['expense_tracker']['invoice_date'];
			$due_date = $collection['expense_tracker']['due_date'];
			$posting_date = $collection['expense_tracker']['posting_date'];
			$description = $collection['expense_tracker']['description'];
			$amount = $collection['expense_tracker']['amount'];
			$amount_category_id = (int)$collection['expense_tracker']['amount_category_id'];
			$invoice_reference = $collection['expense_tracker']['invoice_reference'];		
$approver = $this->requestAction(array('controller' => 'hms', 'action' => 'approver'),array('pass'=>array($approver)));
            foreach($approver as $collection)
			{
			$approver_name = $collection['user']['user_name'];
			}

					
$expense_head = $this->requestAction(array('controller' => 'hms', 'action' => 'expense_head'),array('pass'=>array($expense_head)));					
			foreach($expense_head as $collection)
			{
			$expense_head_name = $collection['ledger_account']['ledger_name'];
			}
			
				$invoice_date = date('d-m-Y',$invoice_date->sec);
				$due_date = date('d-m-Y',$due_date->sec);
				$posting_date = date('d-m-Y',$posting_date->sec);
			
			
				if($amount_category_id == 1) 
				{ 
				$total_debit = $total_debit + $amount;
				} 
				else if($amount_category_id == 2) 
				{ 
				$total_credit = $total_credit + $amount;
				} 
				if($amount_category_id==1)
				{
			?>
			<tr>
											<td><?php echo $approver_name;  ?></td>
											<td><?php echo $expense_head_name; ?></td>
											<td><?php echo $invoice_reference;  ?></td>
                                            <td><?php echo $invoice_date;  ?></td>
											<td><?php echo $due_date;  ?></td>
											<td><?php echo $posting_date;  ?></td>
                                            <td><?php echo $description;  ?></td>
                                            <td><?php  echo $amount; ?></td>
                                            
										    <td><a href="expense_history_pdf?a=<?php echo $auto_id; ?>" class="btn mini purple"  target="_blank">Pdf</a></td>  
                                        </tr>
			
			
			<?php }} ?>			
					
<tr>
                                        <th colspan = "7" style="text-align:center;"> Total </th>
                                        <th><?php echo $total_debit; ?></th>
                                       
                                        <th></th>
										</tr>
								</table>
							
							</center>						
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					