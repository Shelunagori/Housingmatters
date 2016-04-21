<?php 
foreach($result_expense_tracker as $data)
{
$posting_date = $data['expense_tracker']['posting_date'];
$invoice_date = $data['expense_tracker']['due_date'];
$due_date = $data['expense_tracker']['date_of_invoice'];
$party_account_head = (int)$data['expense_tracker']['party_ac_head'];
$invoice_reference = $data['expense_tracker']['invoice_reference'];
$expense_head = (int)$data['expense_tracker']['expense_head'];
$amount = $data['expense_tracker']['ammount_of_invoice'];
$description = $data['expense_tracker']['description'];
$posting_date2 = date('d-m-Y',($posting_date));
$invoice_date2 = date('d-m-Y',($invoice_date));
$due_date2 = date('d-m-Y',($due_date));
}
?>
<form method="post" id="form3">
<div id="main_url">
<div class="portlet box blue">
<div class="portlet-title">
<h4 class="block">Update Expense Tracker Vouchers</h4>
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
                    <input type="text" class="date-picker m-wrap span12" data-date-format="dd-mm-yyyy" value="<?php echo $posting_date2; ?>" style="background-color:white !important;">
                    </td>
                    
                    
                    <td>
                    <input type="text" class="date-picker m-wrap span12" data-date-format="dd-mm-yyyy" style="background-color:white !important;" value="<?php echo $invoice_date2; ?>">
                    </td>
                    
                    
                    <td>
                    <input type="text" class="date-picker m-wrap span12" data-date-format="dd-mm-yyyy"  style="background-color:white !important;" value="<?php echo $due_date2; ?>">
                    </td>
                    
                    
                    <td>
                                <select class="m-wrap span12 chosen">
                                <option value="">Select</option>
                                <?php 
                                foreach($result_ledger_sub_account as $data){
                                
                                $auto_id=$data['ledger_sub_account']['auto_id'];
                                $name=$data['ledger_sub_account']['name'];
                                
                                ?>
                                <option value="<?php echo $auto_id; ?>" <?php if($party_account_head == $auto_id) { ?>selected="selected"<?php } ?>><?php echo $name; ?></option>
                                
                                <?php }	?>
                                </select>
                    </td>
                    
                    
                    <td>
                    <input type="text" class="m-wrap span12" style="text-align:right; background-color:white !important;" value="<?php echo $invoice_reference; ?>">
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
                                
                                <option value="<?php echo $led_auto_id; ?>" <?php if($expense_head ==$led_auto_id) { ?> selected="selected" <?php } ?>><?php echo $ledger_name; ?> </option>	
                                
                                <?php } } ?>
                                
                                </select>
                     </td>
                     
                     
                     <td>
                     <input type="text" class="m-wrap span12 amt1" style="text-align:right; background-color:white !important;" onkeyup="amt_val(this.value,1)" maxlength="7" id="ammmttt1" value="<?php echo $amount; ?>">
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
                     <input type="text" class="m-wrap span12" maxlength="100" style="background-color:white !important;" value="<?php echo @$description; ?>">
                     </td>
                     </tr>
                    
                    </table>

</td>
</tr>
</tbody>
</table>
       
                          
<div class="form-actions">
<a href="<?php echo $webroot_path; ?>Expensetrackers/expense_tracker_view" class="btn green" rel="tab"><i class="icon-arrow-left"></i> Back</a>
<button type="submit" class="btn blue">Save</button>
<button type="button" class="btn">Cancel</button>
</div>
</div>
</div>
</div>
<input type="hidden" value="<?php echo $auto_iddddd; ?>" id="autt_idd">
</form>





<script>
$(document).ready(function(){
$('form#form3').submit( function(ev){ 

	ev.preventDefault();	
	var m_data = new FormData(); 
	var count = $("#main_table")[0].rows.length;
	
	var ar=[];
	
	for(var i=1; i<=count; i++){
var posting_date=$("#main_table tr:nth-child("+i+") td:nth-child(1) #sub_table2 tr:nth-child(2) td:nth-child(1) input").val();

var date_of_invoice=$("#main_table tr:nth-child("+i+") td:nth-child(1) #sub_table2 tr:nth-child(2) td:nth-child(2) input").val();

var due_date=$("#main_table tr:nth-child("+i+") td:nth-child(1) #sub_table2 tr:nth-child(2) td:nth-child(3) input").val();

var ex_head=$("#main_table tr:nth-child("+i+") td:nth-child(1) #sub_table2 tr:nth-child(2) td:nth-child(4) select").val();

var invoice_ref=$("#main_table tr:nth-child("+i+") td:nth-child(1) #sub_table2 tr:nth-child(2) td:nth-child(5) input").val();

var party_ac=$("#main_table tr:nth-child("+i+") td:nth-child(1) #sub_table2 tr:nth-child(4) td:nth-child(1) select").val();

var amt_inv=$("#main_table tr:nth-child("+i+") td:nth-child(1) #sub_table2 tr:nth-child(4) td:nth-child(2) input").val();

var description=$("#main_table tr:nth-child("+i+") td:nth-child(1) #sub_table2 tr:nth-child(4) td:nth-child(4) input").val();
var autt_idd = $("#autt_idd").val();

//m_data.append( 'file'+i, $('input[name=file'+i+']')[0].files[0]);
ar.push([posting_date,date_of_invoice,due_date,ex_head,invoice_ref,party_ac,amt_inv,description,autt_idd]);
			}
	var myJsonString = JSON.stringify(ar);
	m_data.append('myJsonString',myJsonString);
	$.ajax({
			url: "<?php echo $webroot_path; ?>Expensetrackers/expense_tracker_update_json",
			data: m_data,
			processData: false,
			contentType: false,
			type: 'POST',
			dataType:'json',
			}).done(function(response) {
				
				if(response.report_type=='error'){
			
					$("#output").html('<div class="alert alert-error" style="color:red; font-weight:600; font-size:13px;">'+response.text+'</div>');
					 
			}
			if(response.report_type=='submit'){
				$(".portal").remove();
				$("#shwd").show();
				
				$("#output").remove();
			}
			
			
	});
	
});
});
</script>

<div id="shwd" class="hide">
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body">
<h4><b>Thank You!</b></h4>
<p>The Record is Updated Successfully</p>
</div>
<div class="modal-footer">
<a href="<?php echo $webroot_path; ?>Expensetrackers/expense_tracker_view" class="btn red" rel='tab'>OK</a>
</div>
</div>
</div> 
