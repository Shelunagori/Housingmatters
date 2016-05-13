<?php $default_date = date('d-m-Y'); ?>
<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>				   
<script>
	$(document).ready(function(){
	$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
	$("#fix<?php echo $id_current_page; ?>").addClass("red");
	});
</script>

	<center>
	<a href="<?php echo $webroot_path; ?>Cashbanks/bank_payment" class="btn yellow" rel='tab'>Create</a>
	<a href="<?php echo $webroot_path; ?>Cashbanks/bank_payment_view" class="btn" rel='tab'>View</a>
	<a href="<?php echo $webroot_path; ?>Cashbanks/bank_payment_import_csv" class="btn purple" style="float:right; margin-right:8px;">Import csv</a>
	</center>

<!------------------------- Start Bank Payment Form ----------------------------------->
<div id="url_main">
	<form method="post" id="form2">
<div class="portlet box blue">
<div class="portlet-title">
<h4 class="block">Post Bank Payment</h4>
</div>
<div class="portlet-body form">
<div id="validdn"></div>
<table class="table table-hover" style="background-color:#CDE9FE;" id="main_table">
<tr>
<td style="border:solid 1px blue;">

             <table class="table table-bordered" id="sub_table2">
              
			  <tr style="background-color:#E8EAE8;">
			  <th style="width:20%;">Transaction Date</th>
			  <th style="width:20%;">Ledger A/c</th>
			  <th style="width:20%;">Invoice Reference</th>
			  <th style="width:20%;">Amount</th>
			  <th style="width:20%;">TDS Amount</th>
			  </tr>


			  
			  <tr style="background-color:#E8F3FF;">
			  <td><input type="text" class="date-picker m-wrap span12" data-date-format="dd-mm-yyyy" 
			  value="<?php echo $default_date; ?>" 
			  style="background-color:white !important; margin-top:2.5px;" id="dattt1"></td>
			  
			  
					<td>
					<select class="m-wrap span12 chosen" id="ledger_account1">
					<option value="">--SELECT--</option>
					<?php
					foreach($cursor11 as $collection)
					{
					$auto_id = $collection['ledger_sub_account']['auto_id'];
					$name = $collection['ledger_sub_account']['name'];
					?>
					<option value="<?php echo $auto_id; ?>,1" ><?php echo $name; ?></option>
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
					<option value="<?php echo $auto_id; ?>,2" ><?php echo $name; ?></option>
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
					<option value="<?php echo $auto_id; ?>,2" ><?php echo $name; ?></option>
					<?php }} ?>
					<option value="32,2">Cash-in-hand</option>
					</select>
					</td>

  
			  <td><input type="text" class="m-wrap span12" 
			  style="background-color:white !important; margin-top:2.5px;" id="inv_ref1">
			  </td>
			  
			  
			  <td><input type="text" class="m-wrap span12" id="amttt1" 
			  style="text-align:right; background-color:white !important; margin-top:2.5px;" maxlength="10" 
			  onkeyup="numeric_vali(this.value,1)" onchange="tds_calculation1(this.value,1)">
			  </td>
			  
			  
			<td>
			<input type="text" id="tds_tax1" class="m-wrap span12" style="text-align:right; background-color:white !important; margin-top:2.5px;" onchange="tds_calculation2(this.value,1)">
			</td>
			  </tr>

              <tr style="background-color:#E8EAE8;">
			  <th>Net Amount</th>
			  <th>Mode of Payment</th>
			  <th>Instrument/UTR</th>
			  <th>Bank Account</th> 
			  <th>Narration</th>
			  </tr>
		
			  <tr style="background-color:#E8F3FF;">
				  
				  <td id="tds_show1"><input type="text"  class="m-wrap span12" 
				  readonly="readonly" style="background-color:white !important; margin-top:2.5px;" id="net_amtt1">
				  </td>
				  
				<td>
				<select class="m-wrap span12 chosen" id="moddd1">
				<option value="">Select</option>
				<option value="Cheque">Cheque</option>
				<option value="NEFT">NEFT</option>
				<option value="PG">PG</option>
				</select>
				</td>


			  <td><input type="text"  class="m-wrap span12" 
			  style="text-align:right; background-color:white !important; margin-top:2.5px;" id="instru1">
              </td>
			  
			  
					<td>
					<select onchange="get_value(this.value)" class="m-wrap chosen span12" id="bankk1">
					<option value="" style="display:none;">Select</option>    
					<?php
					foreach ($cursor2 as $db) 
					{
					$sub_account_id =(int)$db['ledger_sub_account']['auto_id'];
					$sub_account_name =$db['ledger_sub_account']['name'];
					$ac_number = $db['ledger_sub_account']['bank_account']; 
					$bank_acccc = substr($ac_number,-4);  
					?>
					<option value="<?php echo $sub_account_id; ?>"><?php echo $sub_account_name; ?>&nbsp;&nbsp;<?php echo $bank_acccc; ?></option>
					<?php } ?>
					</select>
					</td>


				  <td><input type="text" class="m-wrap span12" 
				  style="background-color:white !important; margin-top:2.5px;" id="desc1">
				  </td>
			  
              </tr>	
</table>			  

</td>
<td style="border:solid 1px blue;">
<a class="btn green mini adrww" onclick="add_rowwwww()"><i class="icon-plus"></i></a><br>
</td>
</tr>
</table>
<div class="form-actions">
<button type="submit" class="btn green">Submit</button>
</div>
</div>
</div>
</form>
</div>
<!----------------------------------- End Bank Payment Form ----------------------------------->	

<script>
	function numeric_vali(vv,dd)
	{
		if($.isNumeric(vv)){
		$("#validdn").html('');	
		}else{
		$("#validdn").html('<div class="alert alert-error" style="color:red; font-weight:600; font-size:13px;">Amount Should be Numeric in row '+ dd +'</div>');
		$("#amttt"+ dd).val("");
		return false;		
		}
	}
</script>

<script>
	function add_rowwwww()
	{
		var count = $("#main_table")[0].rows.length;
		$(".adrww").hide();   
		count++;
     	$.ajax({
		url: 'bank_payment_add_row?con=' + count,
		}).done(function(response) {
		$('#main_table').append(response)		
		$(".adrww").show();  
		});
	} 
	
	function delete_row(ttt)
	{
		$('.content_'+ttt).remove();	
	}
</script>
	
<script>
	function tds_calculation2(vv,cc)
	{
		var amt = $("#amttt" + cc).val();
		$("#tds_show" + cc).load('bank_payment_tds_ajax?tds='+vv+'&amount='+amt+'');
	}
	
	function tds_calculation1(vvv,ccc)
	{
		var tdsss = $("#tds_tax" + ccc).val();
		$("#tds_show" + ccc).load('bank_payment_tds_ajax?tds='+tdsss+'&amount='+vvv+'');	
	}
</script>
	

<script>
	$(document).ready(function() { 
		$('form#form2').submit( function(ev){
			ev.preventDefault();
			var count = $("#main_table")[0].rows.length;
			var ar = [];
			for(var i=1;i<=count;i++){
			var transaction_date = $("#main_table tr:nth-child("+i+") td:nth-child(1) #sub_table2 tr:nth-child(2) td:nth-child(1) input").val();
			var ledger_account = $("#main_table tr:nth-child("+i+") td:nth-child(1) #sub_table2 tr:nth-child(2) td:nth-child(2) select").val();
			var invoice = $("#main_table tr:nth-child("+i+") td:nth-child(1) #sub_table2 tr:nth-child(2) td:nth-child(3) input").val();
			var amount = $("#main_table tr:nth-child("+i+") td:nth-child(1) #sub_table2 tr:nth-child(2) td:nth-child(4) input").val();
			var tds_id = $("#main_table tr:nth-child("+i+") td:nth-child(1) #sub_table2 tr:nth-child(2) td:nth-child(5) select").val();
			var net_amt = $("#main_table tr:nth-child("+i+") td:nth-child(1) #sub_table2 tr:nth-child(4) td:nth-child(1) input").val();
			var mode = $("#main_table tr:nth-child("+i+") td:nth-child(1) #sub_table2 tr:nth-child(4) td:nth-child(2) select").val();
			var instrument = $("#main_table tr:nth-child("+i+") td:nth-child(1) #sub_table2 tr:nth-child(4) td:nth-child(3) input").val();
			var bank_acc = $("#main_table tr:nth-child("+i+") td:nth-child(1) #sub_table2 tr:nth-child(4) td:nth-child(4) select").val();
			var narration = $("#main_table tr:nth-child("+i+") td:nth-child(1) #sub_table2 tr:nth-child(4) td:nth-child(5) input").val();
			ar.push([transaction_date,ledger_account,amount,tds_id,net_amt,mode,instrument,bank_acc,invoice,narration]);
			}
			var myJsonString = JSON.stringify(ar);
			$.ajax({
			url: "bank_payment_json?q="+myJsonString,
			dataType:'json',
			}).done(function(response){
				if(response.type == 'error'){
				$("#validdn").html('<div class="alert alert-error" style="color:red; font-weight:600; font-size:13px;">'+response.text+'</div>');
				$("html, body").animate({
					 scrollTop:0
					 },"slow");
				}
		    if(response.type == 'success'){
			  $("#shwd").show();
			  $(".shwwtxtt").html(response.text);
			}
			});			
		});
	});
</script>		
   
    
<div id="shwd" class="hide">
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body">
<h4><b>Thank You</b></h4>
<p class="shwwtxtt"></p>
</div>
<div class="modal-footer">
<a href="<?php echo $webroot_path; ?>Cashbanks/bank_payment_view" class="btn red" rel='tab'>OK</a>
</div>
</div>
</div> 
    
  
    
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 


    
    
    
    
    