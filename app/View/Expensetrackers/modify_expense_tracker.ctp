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
                    <input type="text" class="date-picker m-wrap span12" data-date-format="dd-mm-yyyy" value="<?php echo $posting_date; ?>" style="background-color:white !important;" field="posting" record_id="<?php echo $csv_auto_id; ?>">
                    </td>
                    
                    
                    <td>
                    <input type="text" class="date-picker m-wrap span12" data-date-format="dd-mm-yyyy" style="background-color:white !important;" value="<?php echo $invoice_date; ?>" field="invoice" record_id="<?php echo $csv_auto_id; ?>">
                    </td>
                    
                    
                    <td>
                    <input type="text" class="date-picker m-wrap span12" data-date-format="dd-mm-yyyy"  style="background-color:white !important;" value="<?php echo $due_date; ?>" field="due" record_id="<?php echo $csv_auto_id; ?>">
                    </td>
                    
                    
                    <td>
                                <select class="m-wrap span12 chosen" field="party" record_id="<?php echo $csv_auto_id; ?>">
                                <option value="" style="display:none;">Select</option>
                                <?php 
                                foreach($result_ledger_sub_account as $data){
                                
                                $auto_id=$data['ledger_sub_account']['auto_id'];
                                $name=$data['ledger_sub_account']['name'];
                                
                                ?>
                                <option value="<?php echo $auto_id; ?>" <?php if($party_ac_id == $auto_id) { ?> selected="selected" <?php } ?>><?php echo $name; ?></option>
                                
                                <?php }	?>
                                </select>
                    </td>
                    
                    
                    <td>
                    <input type="text" class="m-wrap span12" style="text-align:right; background-color:white !important;" value="<?php echo $invoice_ref; ?>" field="reference" record_id="<?php echo $csv_auto_id; ?>">
                    </td>
                        
                    </tr>
                    
                    <tr style="background-color:#E8EAE8;">
                      <th>Expense Head</th>
                      <th>Amount of Invoice</th>
                      <th colspan="3">Description</th>
                    </tr>
             
                     <tr style="background-color:#E8F3FF;">
                     
                     <td>
                                <select class="m-wrap span12 chosen" field="expense" record_id="<?php echo $csv_auto_id; ?>">
                                <option value="" style="display:none;">Select</option>
                                <?php
                                foreach($result_account_group as $data){
                                $accounts_id=$data['accounts_group']['accounts_id'];
                                $auto_id=$data['accounts_group']['auto_id'];
                                $result_ledger_account= $this->requestAction(array('controller' => 'hms', 'action' => 'expense_tracker_fetch2'),array('pass'=>array($auto_id)));
                                foreach($result_ledger_account as $data){
                                $led_auto_id=$data['ledger_account']['auto_id'];
                                $ledger_name = $data['ledger_account']['ledger_name'];
                                
                                ?>
                                
                                <option value="<?php echo $led_auto_id; ?>" <?php if($expense_head_id == $led_auto_id) { ?>selected="selected" <?php } ?>><?php echo $ledger_name; ?> </option>	
                                
                                <?php } } ?>
                                
                                </select>
                     </td>
                     
                     
                     <td>
                     <input type="text" class="m-wrap span12 amt1" style="text-align:right; background-color:white !important;" maxlength="7" value="<?php echo $amount; ?>" field="amt" record_id="<?php echo $csv_auto_id; ?>">
                     </td>
                     
                     
                     <td colspan="3">
                               
                                
                                
                               
                     <input type="text" class="m-wrap span12" maxlength="100" style="background-color:white !important;" value="<?php echo $description; ?>" field="desc" record_id="<?php echo $csv_auto_id; ?>">
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

<?php if(empty($page)){ $page=1;} ?>
<div >
	<span>Showing page:</span><span> <?php echo $page; ?></span> <br/>
	<span>Total entries: <?php echo ($count_bank_receipt_converted); ?></span>
</div>
<div class="pagination pagination-large ">
<ul>
<?php 
$loop=(int)($count_bank_receipt_converted/20);
if($count_bank_receipt_converted%20>0){
	$loop++;
}
for($ii=1;$ii<=$loop;$ii++){ ?>
	<li><a href="<?php echo $webroot_path; ?>Expensetrackers/modify_expense_tracker/<?php echo $ii; ?>" rel='tab' role="button" ><?php echo $ii; ?></a></li>
<?php } ?>
</ul>
</div>
<br/>
<a href="<?php echo $webroot_path; ?>Expensetrackers/expense_tracker_import?fff=55" class="btn purple big" rel="tab"><i class="m-icon-big-swapleft m-icon-white"></i> BACK</a>
<a class="btn purple big" role="button" id="final_import">IMPORT VOUCHERS <i class="m-icon-big-swapright m-icon-white"></i></a>									
<div id="check_validation_result"></div>		  


<script>
$( document ).ready(function() {
	$( 'input[type="text"]' ).blur(function() {
		
		var record_id=$(this).attr("record_id");
		var field=$(this).attr("field");
		var value=$(this).val();
		
		$.ajax({
			url: "<?php echo $webroot_path; ?>Expensetrackers/auto_save_expense_tracker/"+record_id+"/"+field+"/"+value,
		}).done(function(response){
			
			if(response=="F"){
				$("#main_table tr#"+record_id+" td").each(function(){
					$(this).find('input[field="'+field+'"]').parent("div").css("border", "solid 1px red");
				});
			}else{
				$("#main_table tr#"+record_id+" td").each(function(){
					$(this).find('input[field="'+field+'"]').parent("div").css("border", "");
				});
			}
		});
	});
	
	$( 'select' ).change(function() {
		var record_id=$(this).attr("record_id");
		var field=$(this).attr("field");
		var value=$("option:selected",this).val();
		
		$.ajax({
			url: "<?php echo $webroot_path; ?>Expensetrackers/auto_save_expense_tracker/"+record_id+"/"+field+"/"+value,
		}).done(function(response){
			
			if(response=="F"){
				$("#main_table tr#"+record_id+" td").each(function(){
					$(this).find('select[field="'+field+'"]').parent("div").css("border", "solid 1px red");
				});
			}else{
				$("#main_table tr#"+record_id+" td").each(function(){
					$(this).find('select[field="'+field+'"]').parent("div").css("border", "");
				});
			}
		});
	});
});

</script>

			  
<script>			  
$(document).ready(function() {
$( "#final_import" ).click(function() {
$("#check_validation_result").html('<img src="<?php echo $webroot_path; ?>as/loding.gif" /><span style="padding-left: 10px; font-weight: bold; color: rgb(0, 106, 0);">Importing Receipts.</span>');

$.ajax({
url: "<?php echo $webroot_path; ?>Expensetrackers/allow_import_expense_tracker",
}).done(function(response){
	
	response = response.replace(/\s+/g,' ').trim();
	
if(response=="F"){
$("#check_validation_result").html("");
alert("Your Data Is Not Valid.");
}else{
	
change_page_automatically("<?php echo $webroot_path; ?>Expensetrackers/expense_tracker_import");
}
});
});	
});	  
</script>			  

<script>			  
	function change_page_automatically(pageurl){
	$("#loading").show();

	$.ajax({
		url: pageurl,
		}).done(function(response) {
		
		//$("#loading_ajax").html('');
		
		$(".page-content").html(response);
		$("#loading").hide();
		$("html, body").animate({
			scrollTop:0
		},"slow");
		 $('#submit_success').hide();
		});
	
	window.history.pushState({path:pageurl},'',pageurl);
}		  
</script>			  


