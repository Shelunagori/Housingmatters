


<?php //pr($table); 
$count=0;
foreach($table as $data)
{
$count++;
$posting_date=$data[0];
$date_of_invoice=$data[1];
$due_date=$data[2];
$party_head=$data[3];
$invoice_reference=$data[4];
$expense_head=$data[5];
$amount=$data[6];
$description=$data[7];

/* ?>

<tr class="content_<?php echo $count; ?>" id="tr<?php echo $count; ?>">
<td width="8%"><input type="text" class="date-picker m-wrap span12"  data-date-format="dd-mm-yyyy" name="posting_date" id="pd" value="<?php echo $posting_date; ?>">
</td>
<td width="8%"> <input type="text" class="date-picker m-wrap span12"   data-date-format="dd-mm-yyyy" name="date_of_invoice" id="due" value="<?php echo $date_of_invoice; ?>">
</td>
<td width="8%"> <input type="text" class="date-picker m-wrap span12"  data-date-format="dd-mm-yyyy" name="p_due_date" id="due" value="<?php echo $due_date; ?>"></td>
<td style="" >
<select name="party_head" class="m-wrap span12 chosen " id="">
<option value="">Select</option>

<?php 
foreach($result_ledger_sub_account as $data){
	
	$auto_id=$data['ledger_sub_account']['auto_id'];
	$name=$data['ledger_sub_account']['name'];
	
?>
<option value="<?php echo $auto_id; ?>" <?php if($auto_id==$party_head){ ?> selected <?php } ?> ><?php echo $name; ?></option>

<?php }	?>

</select>
</td>

<td style="text-align:center;">
<input type="text" class="m-wrap span12" name="invoice_reference" style="text-align:right;" id="ref" value="<?php echo $invoice_reference ;?>">
</td>


<td style="" width="15%">
<select name="ex_head" class="m-wrap span12 chosen " id="">
<option value=""> Select </option>
<?php
foreach($result_account_group as $data){
	$accounts_id=$data['accounts_group']['accounts_id'];
	$auto_id=(int)$data['accounts_group']['auto_id'];
	$result_ledger_account= $this->requestAction(array('controller' => 'hms', 'action' => 'expense_tracker_fetch2'),array('pass'=>array($auto_id)));
	foreach($result_ledger_account as $data){
		$led_auto_id=$data['ledger_account']['auto_id'];
		$ledger_name = $data['ledger_account']['ledger_name'];
	
?>
	
<option value="<?php echo $led_auto_id; ?>" <?php if($led_auto_id==$expense_head){?> selected <?php } ?>><?php echo $ledger_name; ?> </option>	
	
<?php } } ?>
</select>
</td>

<td style="text-align:center;">
<input type="text" class="m-wrap span12 amt<?php echo $count; ?>" style="text-align:right;" maxlength="7" name="invoice_amount" id="ia" value="<?php echo $amount ; ?>">
</td>
<td style="text-align:center;" width="25%">
<input type="text" class="m-wrap span12" name="description" id="" value="<?php echo $description ; ?>" maxlength="100">
</td>
<td style="text-align:center;">
		<!--<div class="control-group">
		<div class="controls">
		<div class="fileupload fileupload-new" data-provides="fileupload"><input type="hidden" value="" name="">
		<span class="btn btn-file">
		<span class="fileupload-new">file</span>
		<span class="fileupload-exists">Change</span>
		<input type="file" class="default" name="file<?php echo $count; ?>">
		</span>
		<span class="fileupload-preview"></span>
		<a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none"></a>
		</div>
		</div>
		</div>-->
</td>

<?php if($count!=1){ ?>
<td style="text-align:center;">
<a href="#" role="button" id='<?php echo $count; ?>' class="btn black mini delete"><i class="icon-remove-sign"></i></a>
</td> <?php } ?>
</tr>
<?php } ?>
</table>
*/ ?>

<tr class="content_<?php echo $count; ?>" id="tr<?php echo $count; ?>">
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
                    <input type="text" class="date-picker m-wrap span12" data-date-format="dd-mm-yyyy" value="<?php echo date("d-m-Y"); ?>" style="background-color:white !important;"
					value="<?php echo $posting_date; ?>">
                    </td>
                    
                    
                    <td>
                    <input type="text" class="date-picker m-wrap span12" data-date-format="dd-mm-yyyy" style="background-color:white !important;" value="<?php echo $date_of_invoice; ?>">
                    </td>
                    
                    
                    <td>
                    <input type="text" class="date-picker m-wrap span12" data-date-format="dd-mm-yyyy"  style="background-color:white !important;" value="<?php echo $due_date; ?>">
                    </td>
                    
                    
                    <td>
                                <select class="m-wrap span12 chosen">
                                <option value="">Select</option>
                                <?php 
                                foreach($result_ledger_sub_account as $data){
                                
                                $auto_id=$data['ledger_sub_account']['auto_id'];
                                $name=$data['ledger_sub_account']['name'];
                                
                                ?>
                                <option value="<?php echo $auto_id; ?>" <?php if($auto_id==$party_head){ ?> selected="selected" <?php } ?>><?php echo $name; ?></option>
                                
                                <?php }	?>
                                </select>
                    </td>
                    
                    
                    <td>
                    <input type="text" class="m-wrap span12" style="text-align:right; background-color:white !important;" value="<?php echo $invoice_reference ;?>">
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
                                
                                <option value="<?php echo $led_auto_id; ?>" <?php if($led_auto_id==$expense_head){?> selected="selected" <?php } ?>><?php echo $ledger_name; ?> </option>	
                                
                                <?php } } ?>
                                
                                </select>
                     </td>
                     
                     
                     <td>
                     <input type="text" class="m-wrap span12 amt<?php echo $count; ?>" style="text-align:right; background-color:white !important;" onkeyup="amt_val(this.value,<?php echo $count; ?>)" maxlength="7" id="ammmttt<?php echo $count; ?>" value="<?php echo $amount ; ?>">
                     </td>
                     
                     
                     <td>
                               
                                
                                
                            <!--    <div class="fileupload fileupload-new" data-provides="fileupload"><input type="hidden" value="" name="">
                                <span class="btn btn-file">
                                <span class="fileupload-new"> file</span>
                                <span class="fileupload-exists">Change</span>
                                <input type="file" class="default" name="file1">
                                </span>
                                <span class="fileupload-preview"></span>
                                <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none"></a>
                                </div> -->
                               
                               
                     </td>
                     
                     
                     <td colspan="2">
                     <input type="text" class="m-wrap span12" maxlength="100" style="background-color:white !important;" value="<?php echo $description ; ?>">
                     </td>
                     </tr>
                    
                    </table>

</td>
<td style="border:solid 1px blue;">
<a href="#" role="button" id='<?php echo $count; ?>' class="btn black mini delete"><i class="icon-remove-sign"></i></a>
</td>
</tr>
<?php } ?>