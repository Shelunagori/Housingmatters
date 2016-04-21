<input type="text" class="date-picker m-wrap span4" data-date-format="dd-mm-yyyy" 
value="<?php echo $tra_date; ?>" 
style="background-color:white !important; margin-top:2.5px;" field="transaction_date" record_id="1" placeholder="Date">
 
 
<div style="background-color: #FFF;"> 
<table class="table table-bordered table-striped" style="width:100%; background-color:white;" id="open_bal">
<tr>
<th>Account Group</th>
<th>Account Name</th>
<th>Debit</th>
<th>Credit</th>
<th>Penalty</th>
<th>Delete</th>
</tr>
<?php $j=0;
$tt_debit = 0;
$tt_credit = 0; ?>
			
<?php foreach($result_bank_receipt_converted as $data)
{ 
 $csv_id = (int)$data['opening_balance_csv_converted']['auto_id']; 
 $group_id2 = (int)$data['opening_balance_csv_converted']['group_id'];
 $ledger_id = (int)$data['opening_balance_csv_converted']['ledger_id'];
 $ledger_type = (int)$data['opening_balance_csv_converted']['ledger_type'];
 $wing_id = (int)$data['opening_balance_csv_converted']['wing_id'];
 $flat_id = (int)$data['opening_balance_csv_converted']['flat_id'];
 $type = $data['opening_balance_csv_converted']['type'];
 $amount = $data['opening_balance_csv_converted']['amount'];
 $penalty = $data['opening_balance_csv_converted']['penalty'];
	
?>
<tr id="<?php echo $csv_id; ?>">

<td>
<select class="m-wrap medium" disabled="disabled">
<option value="">Select Group Account</option>
<?php
foreach($cursor3 as $collection)
{
$group_id5 = (int)$collection['accounts_group']['auto_id'];
$group_name1= $collection['accounts_group']['group_name'];

?>
<option value="<?php echo $group_id5; ?>" <?php if($group_id2 == $group_id5) { ?> selected="selected" <?php } ?>><?php echo $group_name1; ?></option>
<?php } ?>
<option value="15" <?php if($group_id2 == 15) { ?> selected="selected" <?php } ?>>Sundry Creditors Control A/c</option>
<option value="112" <?php if($group_id2 == 112) { ?> selected="selected" <?php } ?>>Sundry Debtors Control A/c </option>
<option value="33" <?php if($group_id2 == 33) { ?> selected="selected" <?php } ?>>Bank Accounts</option>
<option value="35" <?php if($group_id2 == 35) { ?> selected="selected" <?php } ?>>Tax deducted at source (TDS receivable)</option>
<option value="34" <?php if($group_id2 == 34) { ?> selected="selected" <?php } ?>>Members Control Account</option>


</select>
</td>
            
            
<td>
<?php
if($ledger_type == 1)
{
?>	
<select class="m-wrap medium" disabled="disabled">
<option value="" style="display:none;">Select</option>
<?php foreach($cursor1 as $dataa)
{
$auto_id = (int)$dataa['ledger_sub_account']['auto_id'];
$name = $dataa['ledger_sub_account']['name'];
?>
<option value="<?php echo $auto_id; ?>" <?php if($auto_id == $ledger_id) { ?> selected="selected" <?php } ?>><?php echo $name; ?></option>
<?php	
}
?>
</select>
<?php	
}
else{
?>	
<select class="m-wrap medium" disabled="disabled">
<option value="" style="display:none;">Select</option>
<?php foreach($cursor2 as $dataa)
{
$auto_id = (int)$dataa['ledger_account']['auto_id'];
$name = $dataa['ledger_account']['ledger_name'];
?>
<option value="<?php echo $auto_id; ?>" <?php if($auto_id == $ledger_id) { ?> selected="selected" <?php } ?>><?php echo $name; ?></option>
<?php	
}
?>
</select>
<?php	
}
?>
</td>

<td>
<input type="text" class="m-wrap span10" style="background-color:white !important;"
<?php if($type == 1){ ?> value="<?php echo $amount; ?>"  <?php } ?> field="debit" record_id="<?php echo $csv_id; ?>" readonly="readonly"/>
</td>

<td>
<input type="text" class="m-wrap span10" style="background-color:white !important;"
<?php if($type == 2){ ?> value="<?php echo $amount; ?>"  <?php } ?> field="credit" record_id="<?php echo $csv_id; ?>" readonly="readonly"/>
</td>

<td>
<input type="text" class="m-wrap span10" style="background-color:white !important;"
<?php if($type == 2 && !empty($penalty)){ ?> value="<?php echo $penalty; ?>"  <?php } ?> field="penalty" record_id="<?php echo $csv_id; ?>" readonly="readonly"/>                       
</td>                      

<td>
<a href="#" role="button" class="btn mini red delete" del="<?php echo $j; ?>"><i class="icon-remove icon-white"></i></a>
</td>

	
</tr>
<?php } ?>
<tr>
<th colspan="2" style="text-align:right;">Total</th>
<th></th>
<th></th>
<th></th>
<th></th>
</tr>
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
	<li><a href="<?php echo $webroot_path; ?>Accounts/modify_opening_balance/<?php echo $ii; ?>" rel='tab' role="button" ><?php echo $ii; ?></a></li>
<?php } ?>
</ul>
</div>
<br/>
<a href="<?php echo $webroot_path; ?>Accounts/opening_balance_import?bbb=55" rel="tab" class="btn purple big"><i class="m-icon-big-swapleft m-icon-white"></i> Back</a>
<a class="btn purple big" role="button" id="final_import">IMPORT OPENING BALANCE <i class="m-icon-big-swapright m-icon-white"></i></a>									
<div id="check_validation_result"></div>		  



<script>/*
$( document ).ready(function() {
	$( 'input[type="text"]' ).keyup(function() {
		
		var record_id=$(this).attr("record_id");
		var field=$(this).attr("field");
		var value=$(this).val();
		
		$.ajax({
			url: "<?php echo $webroot_path; ?>Accounts/auto_save_opening_balance/"+record_id+"/"+field+"/"+value,
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


	
}); */
</script> 

<script>/*
$( document ).ready(function() {
	$( 'input[type="text"]' ).keydown(function() {
		
		var record_id=$(this).attr("record_id");
		var field=$(this).attr("field");
		var value=$(this).val();
		
		$.ajax({
			url: "<?php echo $webroot_path; ?>Accounts/auto_save_opening_balance/"+record_id+"/"+field+"/"+value,
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


	
}); */
</script>


<script>
$( document ).ready(function() {
	$( 'input[type="text"]' ).blur(function() {
		
		var record_id=$(this).attr("record_id");
		var field=$(this).attr("field");
		var value=$(this).val();
		
		$.ajax({
			url: "<?php echo $webroot_path; ?>Accounts/auto_save_opening_balance_date/"+record_id+"/"+field+"/"+value,
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


	
});
</script>

<script>			  
$(document).ready(function() {
$( "#final_import" ).click(function() {
$("#check_validation_result").html('<img src="<?php echo $webroot_path; ?>as/loding.gif" /><span style="padding-left: 10px; font-weight: bold; color: rgb(0, 106, 0);">Importing Receipts.</span>');

$.ajax({
url: "<?php echo $webroot_path; ?>Accounts/allow_import_opening_balance",
}).done(function(response){
	
response = response.replace(/\s+/g,' ').trim();
	
if(response=="F"){
$("#check_validation_result").html("");
alert("Your Data Is Not Valid.");
}else{
	
change_page_automatically("<?php echo $webroot_path; ?>Accounts/opening_balance_import");
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
