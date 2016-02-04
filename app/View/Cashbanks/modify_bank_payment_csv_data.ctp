<div style="background-color: #FFF;">
<table style="backgroud-color:white; width:100%;">
<?php
foreach($result_bank_receipt_converted as $data)
{
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




<tr>
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
			  <td><input type="text" class="date-picker m-wrap span12" data-date-format="dd-mm-yyyy" 
			  value="<?php echo $transaction_date; ?>" 
			  style="background-color:white !important; margin-top:2.5px;" id="dattt1"></td>
			  
			  
					<td>
					<select class="m-wrap span12 chosen">
					<option value="">--SELECT--</option>
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
					</select>
					</td>

  
			  <td><input type="text" class="m-wrap span12" 
			  style="background-color:white !important; margin-top:2.5px;" id="inv_ref1"
			  value="<?php echo $invoice_ref; ?>">
			  </td>
			  
			  
			  <td><input type="text" class="m-wrap span12" id="amttt1" 
			  style="text-align:right; background-color:white !important; margin-top:2.5px;" maxlength="10" value="<?php echo $amount; ?>" 
			  onchange="tdssssamt2(this.value,1)">
			  </td>
			  
			  
				<td><select class="m-wrap chosen span12" onchange="tdssssamt(this.value,1)">
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
				</select>
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
				  readonly="readonly" style="background-color:white !important; margin-top:2.5px;" id="net_amtt1">
				  </td>
				  
				<td>
				<select class="m-wrap span12 chosen">
				<option value="">Select</option>
				<option value="Cheque" <?php if($mode == "Cheque") { ?>selected="selected" <?php } ?>>Cheque</option>
				<option value="NEFT" <?php if($mode == "NEFT") { ?>selected="selected" <?php } ?>>NEFT</option>
				<option value="PG" <?php if($mode == "PG") { ?>selected="selected" <?php } ?>>PG</option>
				</select>
				</td>


			  <td><input type="text"  class="m-wrap span12" 
			  style="text-align:right; background-color:white !important; margin-top:2.5px;" id="instru1" value="<?php echo $instrument; ?>">
              </td>
			  
			  
					<td>
					<select onchange="get_value(this.value)" class="m-wrap chosen span12">
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
					</td>


				  <td><input type="text" class="m-wrap span12" 
				  style="background-color:white !important; margin-top:2.5px;" id="desc1"
				  value="<?php echo $narration; ?>">
				  </td>
			  
              </tr>	
			  </table>
			  </td>
			  <td valign="top">
			<a href="#" class="btn mini black delete_row" record_id="<?php echo $auto_id; ?>" role="button"><i class="icon-trash"></i></a>
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

<a class="btn purple big" role="button" id="final_import">IMPORT VOUCHERS <i class="m-icon-big-swapright m-icon-white"></i></a>									
<div id="check_validation_result"></div>		  
			  
<script>			  
$(document).ready(function() {
$( "#final_import" ).click(function() {
$("#check_validation_result").html('<img src="<?php echo $webroot_path; ?>as/loding.gif" /><span style="padding-left: 10px; font-weight: bold; color: rgb(0, 106, 0);">Importing Receipts.</span>');

$.ajax({
url: "<?php echo $webroot_path; ?>Cashbanks/allow_import_bank_receipt",
}).done(function(response){
if(response=="F"){
$("#check_validation_result").html("");
alert("Your Data Is Not Validate.");
}else{
change_page_automatically("<?php echo $webroot_path; ?>Cashbanks/bank_payment_import_csv");
}
});
});	
});	  
</script>			  
			  
			  
			  
			  
			  
			  