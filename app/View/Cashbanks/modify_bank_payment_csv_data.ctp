<div style="background-color: #FFF;">
<table style="backgroud-color:white; width:100%;" id="main_table">
<?php
foreach($result_bank_receipt_converted as $data)
{
$csv_auto_id = (int)$data['payment_csv_converted']['auto_id'];
$transaction_date = $data['payment_csv_converted']['trajection_date'];	
$ledger_account_id = (int)$data['payment_csv_converted']['ledger_ac'];	
$type = (int)$data['payment_csv_converted']['type'];
$amount = $data['payment_csv_converted']['amount'];		
$tds = $data['payment_csv_converted']['tds'];	
$mode = $data['payment_csv_converted']['mode'];	
$instrument = $data['payment_csv_converted']['instrument'];	
$bank_id = $data['payment_csv_converted']['bank'];	
$invoice_ref = $data['payment_csv_converted']['invoice_ref'];
$narration = $data['payment_csv_converted']['narration'];
?>
<tr id="<?php echo $csv_auto_id; ?>">
<td style="border:solid 1px blue;">

             <table id="sub_table2" class="table table-bordered table-striped">
              
			  <tr>
			  <th style="width:20%;">Transaction Date</th>
			  <th style="width:20%;">Ledger A/c</th>
			  <th style="width:20%;">Invoice Reference</th>
			  <th style="width:20%;">Amount</th>
			  <th style="width:20%;">TDS%</th>
			  </tr>


			  
			  <tr>
			  <td><div class="one"><input type="text" class="date-picker m-wrap span12" data-date-format="dd-mm-yyyy" 
			  value="<?php echo $transaction_date; ?>" 
			  style="background-color:white !important; margin-top:2.5px;" field="transaction_date" record_id="<?php echo $csv_auto_id; ?>"></div></td>
			  
			  
					<td>
					<div class="two">
					<select class="m-wrap span12 chosen" field="ledger_data" record_id="<?php echo $csv_auto_id; ?>">
					<option value="" style="display:none;">--SELECT--</option>
					<?php
					foreach($cursor11 as $collection)
					{
					$auto_id = $collection['ledger_sub_account']['auto_id'];
					$name = $collection['ledger_sub_account']['name'];
					?>
					<option value="<?php echo $auto_id; ?>,1" <?php if($ledger_account_id == $auto_id && $type == 1) { ?> selected="selected" <?php } ?> ><?php echo $name; ?></option>
					<?php } ?>
					<?php
					foreach($cursor12 as $collection)
					{
					$auto_id_a = (int)$collection['accounts_group']['auto_id'];
					$result33 = $this->requestAction(array('controller' => 'hms', 'action' => 'expense_tracker_fetch2'),array('pass'=>array($auto_id_a)));
					foreach($result33 as $collection)
					{
					$auto_id = (int)$collection['ledger_account']['auto_id'];
					$name = $collection['ledger_account']['ledger_name'];
					if($auto_id == 15)
					continue;
					?>
					<option value="<?php echo $auto_id; ?>,2" <?php if($ledger_account_id == $auto_id && $type == 2) { ?> selected="selected" <?php } ?>><?php echo $name; ?></option>
					<?php }} ?>
					<?php
					foreach($cursor13 as $collection)
					{
					$auto_id_b = (int)$collection['accounts_group']['auto_id'];

					$result33 = $this->requestAction(array('controller' => 'hms', 'action' => 'expense_tracker_fetch2'),array('pass'=>array($auto_id_b)));
					foreach($result33 as $collection)
					{
					$auto_id = (int)$collection['ledger_account']['auto_id'];
					$name = $collection['ledger_account']['ledger_name'];
					?>
					<option value="<?php echo $auto_id; ?>,2" <?php if($ledger_account_id == $auto_id && $type == 2) { ?> selected="selected" <?php } ?> ><?php echo $name; ?></option>
					<?php }} ?>
					</select></div>
					</td>

  
			  <td><div><input type="text" class="m-wrap span12" 
			  style="background-color:white !important; margin-top:2.5px;" id="inv_ref1"
			  value="<?php echo $invoice_ref; ?>" field="invoice" record_id="<?php echo $csv_auto_id; ?>"></div>
			  </td>
			  
			  
			  <td><div class="three"><input type="text" class="m-wrap span12" id="amttt1" 
			  style="text-align:right; background-color:white !important; margin-top:2.5px;" maxlength="10" value="<?php echo $amount; ?>" 
			   field="amt" record_id="<?php echo $csv_auto_id; ?>"></div>
			  </td>
			  
			  
				<td><div><select class="m-wrap chosen span12" field="tdss" record_id="<?php echo $csv_auto_id; ?>">
				<option value="" style="display:none;">Select</option>
				<?php
				for($k=0; $k<sizeof($tds_arr); $k++)
				{
				$tds_sub_arr = $tds_arr[$k];	
				$tds_id = (int)$tds_sub_arr[1];
				$tds_tax = $tds_sub_arr[0];	
				?>
				<option value= "<?php echo $tds_id; ?>" <?php if($tds_tax==$tds) { ?> selected="selected" <?php } ?>><?php echo $tds_tax; ?></option>
				<?php } ?>                           
				</select></div>
				</td>
			  </tr>

              <tr>
			  <th>Net Amount</th>
			  <th>Mode of Payment</th>
			  <th>Instrument/UTR</th>
			  <th>Bank Account</th> 
			  <th>Narration</th>
			  </tr>
		
			  <tr>
				  
				  <td id="tds_show1"><input type="text"  class="m-wrap span12" 
				  readonly="readonly" style="background-color:white !important; margin-top:2.5px;">
				  </td>
				  
				<td><div class="four">
				<select class="m-wrap span12 chosen" field="mode" record_id="<?php echo $csv_auto_id; ?>">
				<option value="" style="display:none;">Select</option>
				<option value="Cheque" <?php if($mode == "Cheque") { ?>selected="selected" <?php } ?>>Cheque</option>
				<option value="NEFT" <?php if($mode == "NEFT") { ?>selected="selected" <?php } ?>>NEFT</option>
				<option value="PG" <?php if($mode == "PG") { ?>selected="selected" <?php } ?>>PG</option>
				</select></div>
				</td>


			  <td><div class="five"><input type="text"  class="m-wrap span12" 
			  style="text-align:right; background-color:white !important; margin-top:2.5px;" id="instru1" value="<?php echo $instrument; ?>" field="inst" record_id="<?php echo $csv_auto_id; ?>"></div>
              </td>
			 
					<td><div class="six">
					<select onchange="get_value(this.value)" class="m-wrap chosen span12" field="bankk" record_id="<?php echo $csv_auto_id; ?>">
					<option value="" style="display:none;">Select</option>    
					<?php
					foreach ($cursor2 as $db) 
					{
					$sub_account_id =(int)$db['ledger_sub_account']['auto_id'];
					$sub_account_name =$db['ledger_sub_account']['name'];
					$ac_number = $db['ledger_sub_account']['bank_account']; 
					$bank_acccc = substr($ac_number,-4);  
					?>
					<option value="<?php echo $sub_account_id; ?>" <?php if($sub_account_id == $bank_id) { ?> selected="selected" <?php } ?>><?php echo $sub_account_name; ?>&nbsp;&nbsp;<?php echo $bank_acccc; ?></option>
					<?php } ?>
					</select>
					</div>
					</td>


				  <td><div><input type="text" class="m-wrap span12" 
				  style="background-color:white !important; margin-top:2.5px;" 
				  value="<?php echo $narration; ?>" field="desc" record_id="<?php echo $csv_auto_id; ?>"></div>
				  </td>
			  
			  
			  
			  
			  
			  
              </tr>	
			  </table>
			  </td>
			  <td valign="top">
			<a href="#" class="btn mini black delete_row" record_id="<?php echo $csv_auto_id; ?>" role="button"><i class="icon-trash"></i></a>
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
	<li><a href="<?php echo $webroot_path; ?>Cashbanks/modify_bank_payment_csv_data/<?php echo $ii; ?>" rel='tab' role="button" ><?php echo $ii; ?></a></li>
<?php } ?>
</ul>
</div>
<br/>
<a href="<?php echo $webroot_path; ?>Cashbanks/bank_payment_import_csv?vvv=5" class="btn purple big"><i class="m-icon-big-swapleft m-icon-white"></i> BACK</a>
<a class="btn purple big" role="button" id="final_import">IMPORT VOUCHERS <i class="m-icon-big-swapright m-icon-white"></i></a>									
<div id="check_validation_result"></div>		  



<script>
$( document ).ready(function() {
	$( 'input[type="text"]' ).blur(function() {
		
		var record_id=$(this).attr("record_id");
		var field=$(this).attr("field");
		var value=$(this).val();
		
		$.ajax({
			url: "<?php echo $webroot_path; ?>Cashbanks/auto_save_bank_payment/"+record_id+"/"+field+"/"+value,
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
			url: "<?php echo $webroot_path; ?>Cashbanks/auto_save_bank_payment/"+record_id+"/"+field+"/"+value,
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
url: "<?php echo $webroot_path; ?>Cashbanks/allow_import_bank_payment",
}).done(function(response){
	
	response = response.replace(/\s+/g,' ').trim();
	
if(response=="F"){
$("#check_validation_result").html("");
alert("Your Data Is Not Valid.");
}else{
	
change_page_automatically("<?php echo $webroot_path; ?>Cashbanks/bank_payment_import_csv");
}
});
});	
});	  
</script>			  
<script>			  
	$( document ).ready(function() {
    $.ajax({
		url: "<?php echo $webroot_path; ?>Cashbanks/check_bank_receipt_csv_validation/<?php echo $page; ?>",
		dataType: 'json'
	}).done(function(response){
		
		response.forEach(function(item) {
			
			if(item[0]==1){ $("#main_table tr#"+item[6]+" td:nth-child(1) #sub_table2 tr:nth-child(2) td:nth-child(1) .one").css("border", "solid 1px red","!important"); }
			if(item[1]==1){ $("#main_table tr#"+item[6]+" td:nth-child(1) #sub_table2 tr:nth-child(2) td:nth-child(2) .two").css("border", "solid 1px red","!important"); }
			if(item[2]==1){ $("#main_table tr#"+item[6]+" td:nth-child(1) #sub_table2 tr:nth-child(2) td:nth-child(4) .three").css("border", "solid 1px red","!important"); }
			if(item[3]==1){ $("#main_table tr#"+item[6]+" td:nth-child(1) #sub_table2 tr:nth-child(4) td:nth-child(2) .four").css("border", "solid 1px red","!important"); }
			if(item[4]==1){ $("#main_table tr#"+item[6]+" td:nth-child(1) #sub_table2 tr:nth-child(2) td:nth-child(3) .five").css("border", "solid 1px red","!important"); }
			if(item[5]==1){ $("#main_table tr#"+item[6]+" td:nth-child(1) #sub_table2 tr:nth-child(2) td:nth-child(4) .six").css("border", "solid 1px red","!important"); }
			
			
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


<script>
$( document ).ready(function() {
	$( '.delete_row' ).click(function() {
		var record_id=$(this).attr("record_id");
		$.ajax({
			url: "<?php echo $webroot_path; ?>Cashbanks/delete_bank_payment_row/"+record_id,
		}).done(function(response){
			response = response.replace(/\s+/g,' ').trim();
			if(response=="1"){
				$( '#'+record_id ).addClass('animated zoomOut')
				setTimeout(function() {
					$( '#'+record_id ).remove();
				}, 1000);
			}
		});
	});
});
</script>













		  
			  