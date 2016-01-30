<?php 
foreach($result_expense_tracker as $data)
{
	
	
	
}
?>
<form method="post" id="form2">
<div id="main_url">
<div class="portlet box blue">
<div class="portlet-title">
<h4 class="block">Create New Expense Tracker Vouchers</h4>
</div>
<div class="portlet-body form">
<div id="output"></div>                    
<table class="table table-hover" style="background-color:#CDE9FE;" id="main_table">
<tbody id="show_import_data">
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
                      <th>Attachment</th>
                      <th colspan="2">Description</th>
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
                     
                     
                     <td>
                               
                                
                                
                                <div class="fileupload fileupload-new" data-provides="fileupload"><input type="hidden" value="" name="">
                                <span class="btn btn-file">
                                <span class="fileupload-new"> file</span>
                                <span class="fileupload-exists">Change</span>
                                <input type="file" class="default" name="file1">
                                </span>
                                <span class="fileupload-preview"></span>
                                <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none"></a>
                                </div>
                               
                               
                     </td>
                     
                     
                     <td colspan="2">
                     <input type="text" class="m-wrap span12" maxlength="100" style="background-color:white !important;">
                     </td>
                     </tr>
                    
                    </table>

</td>
<td style="border:solid 1px blue;">
<a class="btn green mini adrww" onclick="add_rowwwww()"><i class="icon-plus"></i></a><br>
</td>
</tr>
</tbody>
</table>
       
                          
<div class="form-actions">
<button type="submit" class="btn blue">Save</button>
<button type="button" class="btn">Cancel</button>
</div>
</div>
</div>
</div>
</form>