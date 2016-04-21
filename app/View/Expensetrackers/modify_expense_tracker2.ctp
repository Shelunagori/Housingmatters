<div style="background-color: #FFF;">
<table class="table table-hover" style="background-color:#CDE9FE;" id="main_table">
<?php
foreach($result_bank_receipt_converted as $data)
{
$csv_auto_id = (int)$data['expense_tracker_csv_converted']['auto_id'];
$posting_date = $data['expense_tracker_csv_converted']['posting_date'];	
$invoice_date = $data['expense_tracker_csv_converted']['invoice_date'];	
$due_date = $data['expense_tracker_csv_converted']['due_date'];
$party_ac_id = (int)$data['expense_tracker_csv_converted']['party_ac_id'];		
$invoice_ref = $data['expense_tracker_csv_converted']['invoice_ref'];	
$expense_head_id = (int)$data['expense_tracker_csv_converted']['expense_head_id'];	
$amount = $data['expense_tracker_csv_converted']['amount'];	
$description = $data['expense_tracker_csv_converted']['description']; 	
?>
<tr>
<td style="border:solid 1px blue;">
                    
              <table class="table table-bordered" id="sub_table2">
                    
                    <tr style="background-color:#E8EAE8;">
                            <th style="width:20%;">Posting date</th>
                            <th style="width:20%;">Date of Invoice</th>
                            <th style="width:20%;">Due Date</th>
                            <th style="width:20%;">Party Account Head</th>
                            <th style="width:20%;">Invoice Reference</th>
		    </tr>
                    
                    <tr style="background-color:#E8F3FF;">
                    
                    <td>
                    <input type="text" class="date-picker m-wrap span12" data-date-format="dd-mm-yyyy" value="<?php echo date("d-m-Y"); ?>" style="background-color:white !important;">
                    </td>
                    
                    
                    <td>
                    <input type="text" class="date-picker m-wrap span12" data-date-format="dd-mm-yyyy" style="background-color:white !important;">
                    </td>
                    
                    
                    <td>
                    <input type="text" class="date-picker m-wrap span12" data-date-format="dd-mm-yyyy"  style="background-color:white !important;">
                    </td>
                    
                    
                    <td>
                                <select class="m-wrap span12 chosen">
                                <option value="">Select</option>
                                <?php 
                                foreach($result_ledger_sub_account as $data){
                                
                                $auto_id=$data['ledger_sub_account']['auto_id'];
                                $name=$data['ledger_sub_account']['name'];
                                
                                ?>
                                <option value="<?php echo $auto_id; ?>"><?php echo $name; ?></option>
                                
                                <?php }	?>
                                </select>
                    </td>
                    
                    
                    <td>
                    <input type="text" class="m-wrap span12" style="text-align:right; background-color:white !important;">
                    </td>
                        
                    </tr>
                    
                    <tr style="background-color:#E8EAE8;">
                      <th>Expense Head</th>
                      <th>Amount of Invoice</th>
                      <th colspan="3">Description</th>
                    </tr>
             
                     <tr style="background-color:#E8F3FF;">
                     
                     <td>
                                <select class="m-wrap span12 chosen">
                                <option value="">Select</option>
                                <?php
                                foreach($result_account_group as $data){
                                $accounts_id=$data['accounts_group']['accounts_id'];
                                $auto_id=$data['accounts_group']['auto_id'];
                                $result_ledger_account= $this->requestAction(array('controller' => 'hms', 'action' => 'expense_tracker_fetch2'),array('pass'=>array($auto_id)));
                                foreach($result_ledger_account as $data){
                                $led_auto_id=$data['ledger_account']['auto_id'];
                                $ledger_name = $data['ledger_account']['ledger_name'];
                                
                                ?>
                                
                                <option value="<?php echo $led_auto_id; ?>"><?php echo $ledger_name; ?> </option>	
                                
                                <?php } } ?>
                                
                                </select>
                     </td>
                     
                     
                     <td>
                     <input type="text" class="m-wrap span12 amt1" style="text-align:right; background-color:white !important;" onkeyup="amt_val(this.value,1)" maxlength="7" id="ammmttt1">
                     </td>
                     
                     
                     <td colspan="3">
                               
                                
                                
                               
                     <input type="text" class="m-wrap span12" maxlength="100" style="background-color:white !important;">
                     </td>
                     </tr>
                    
                    </table>

</td>
<td style="border:solid 1px blue;">
</td>
</tr>
<?php } ?>
</table>
</div>



