
<?php
foreach($cursor1 as $data){
$receipt_id=$data["new_cash_bank"]["receipt_id"];
$transaction_date=$data["new_cash_bank"]["receipt_date"];
$transaction_date=date("d-m-Y",($transaction_date));
$receipt_mode=$data["new_cash_bank"]["receipt_mode"];
if($receipt_mode == "Cheque")
{
$cheque_number=@$data["new_cash_bank"]["cheque_number"];
$which_bank=@$data["new_cash_bank"]["drawn_on_which_bank"];
$receipt_date1 = @$data["new_cash_bank"]["cheque_date"];
}
else
{
$refrence_utr = @$data["new_cash_bank"]["reference_utr"];
$receipt_date2 = @$data["new_cash_bank"]["cheque_date"];	
}

$member_type = (int)@$data["new_cash_bank"]["member_type"];
if($member_type == 1)
{
$receipt_type = @$data["new_cash_bank"]["receipt_type"];	
$party_name_flat_id = @$data["new_cash_bank"]["flat_id"];	

$ledger_sub_dettt = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_subLedger_detail_via_flat_id'),array('pass'=>array((int)$party_name_flat_id)));

foreach ($ledger_sub_dettt as $sub_leddg_dataa) 
{
$resident_name = $sub_leddg_dataa['ledger_sub_account']['name'];
}	

$flat_detail = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($party_name_flat_id)));
foreach ($flat_detail as $flat_dataa) 
{
$wing_id = (int)$flat_dataa['flat']['wing_id'];
}	

$wing_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat_new'),array('pass'=>array($wing_id,$party_name_flat_id)));

}
else
{
$party_name = @$data["new_cash_bank"]["party_name_id"];	
$bill_reference = @$data["new_cash_bank"]["bill_reference"];		
}
$amount = @$data["new_cash_bank"]["amount"];
$deposited_bank_id = @$data["new_cash_bank"]["deposited_bank_id"];
$narration = @$data["new_cash_bank"]["narration"];
}
	
?>

<form method="post">
<div class="portlet box blue">
	<div class="portlet-title">
	<h4 class="block"><i class="icon-reorder"></i>Edit Receipt - <?php echo $receipt_id; ?></h4>
	</div>
	<div class="portlet-body form">



<div class="row-fluid">

	
	
	
	
<div class="span6">
<label style="font-size:14px;">Transaction date<span style="color:red;">*</span></label>
<div class="controls">
<input type="text" class="date-picker m-wrap span7" data-date-format="dd-mm-yyyy" name="transaction_date" placeholder="Transaction Date" style="background-color:white !important;" id="date" value="<?php echo $transaction_date; ?>">
</div>
<br />   


<label style="font-size:14px;">Deposited In<span style="color:red;">*</span></label>
<div class="controls">
<select name="deposited_bank_id" class="span9 m-wrap chosen" id="bank">
<option value="" style="display:none;">which bank?</option>    
<?php
foreach ($cursor3 as $db) 
{
$bank_id = (int)$db['ledger_sub_account']["auto_id"];
$bank_ac = $db['ledger_sub_account']["name"];
$bank_account_number = $db['ledger_sub_account']["bank_account"];
?>
<option value="<?php echo $bank_id; ?>" <?php if($deposited_bank_id == $bank_id) { ?> selected="selected" <?php } ?>><?php echo $bank_ac; ?> &nbsp;&nbsp; <?php echo $bank_account_number; ?></option>
<?php } ?>
</select>
</div>
<br />
	   
	   
<label  style="font-size:14px;">Receipt Mode<span style="color:red;">*</span></label>
<div class="controls">
<label class="radio">
<div class="radio" id="uniform-undefined"><span><input type="radio" name="receipt_mode" value="Cheque" style="opacity: 0;" id="mode" class="chn" onclick="cheque_view()" <?php if($receipt_mode == "Cheque") { ?> checked="checked" <?php } ?>></span></div>
Cheque
</label>
<label class="radio">
<div class="radio" id="uniform-undefined"><span><input type="radio" name="receipt_mode" value="NEFT" style="opacity: 0;" id="mode" class="neft" onclick="neft_text_view()" <?php if($receipt_mode == "NEFT") { ?> checked="checked" <?php } ?>></span></div>
NEFT
</label>
<label class="radio">
<div class="radio" id="uniform-undefined"><span><input type="radio" name="receipt_mode" value="PG" style="opacity: 0;" id="mode" class="pg" onclick="pg_show()" <?php if($receipt_mode == "PG") { ?> checked="checked" <?php } ?>></span></div>
PG
</label> 
<label id="mode"></label>
</div>
<br />
		
		 
<div id="cheque_show_by_query" <?php if($receipt_mode != "Cheque") { ?> class="hide"  <?php } ?> >
<label style="font-size:14px;">Cheque No.<span style="color:red;">*</span><span style="margin-left:12%;">Cheque Date<span style="color:red;">*</span></span></label>
<div class="controls">
<input type="text"  name="cheque_number" class="m-wrap span3 chhh1 ignore" placeholder="Cheque No." style="background-color:white !important;" id="ins" value="<?php echo @$cheque_number; ?>">
<input type="text"  class="date-picker m-wrap span4 chhh2 ignore" name="cheque_date1" data-date-format="dd-mm-yyyy" placeholder="Date" id="chh" value="<?php echo @$receipt_date1; ?>"/>
<table border="0" width="65%"><tr><td style="width:44%;"><label id="ins"></label></td><td> <label id="chh"></label></td></tr></table>
</div>
<br />


<label style="font-size:14px;">Drawn on which bank?<span style="color:red;">*</span> </label>
<div class="controls">
<input type="text"  name="drawn_on_which_bank" class="m-wrap span9 chhh3 ignore" placeholder="Drawn on which bank?" style="background-color:white !important;" id="ins" data-provide="typeahead" data-source="[<?php if(!empty($kendo_implode)) { echo $kendo_implode; } ?>]" value="<?php echo @$which_bank; ?>">
<label id="ins"></label>
</div>
<br />
</div>

<div <?php if($receipt_mode == "Cheque") { ?> class="hide"  <?php } ?> id="neft_show">
<label style="font-size:14px;">Reference/UTR #<span style="color:red;">*</span><span style="margin-left:15%;">Date<span style="color:red;">*</span></span></label>
<div class="controls">
<input type="text"  name="reference_number" class="m-wrap span4 nefftt1 ignore" placeholder="Reference/UTR #" style="background-color:white !important;" id="reff" value="<?php echo @$refrence_utr; ?>">&nbsp;&nbsp;
<input type="text"  name="neft_date" class="m-wrap span3 date-picker nefftt2 ignore" placeholder="Date" data-date-format="dd-mm-yyyy" style="background-color:white !important;" id="dtt" value="<?php echo @$receipt_date2; ?>">
<table border="0" width="80%"><tr><td style="width:44%;"><label id="reff"></label></td><td> <label id="dtt"></label></td></tr></table>
</div>
<br />
</div>
</div>
<div class="span6">		
<?php if($member_type == 1) { ?>		
<h5><b>Receipt For : Residential</b></h5>	
<input type="hidden" name="member_type" value="1" />	

<?php if($receipt_type == 1) { ?>
<h5><b>Receipt type: Maintanance</b></h5>	
<input type="hidden" name="receipt_type" value="1" />
<?php } else { ?>
<h5><b>Receipt type: Other</b></h5>	
<input type="hidden" name="receipt_type" value="2" />
	
<?php }  ?>
<h5><b>Resident Name: <?php echo $resident_name; ?>   <?php echo $wing_flat; ?></b></h5>	
<input type="hidden" name="resident_flat_id" value="<?php echo $party_name_flat_id; ?>" />	
<br />
<?php
} else { ?>
<h5><b>Receipt For : Non-Residential</b></h5>
<input type="hidden" name="member_type" value="2" />
<br />

<label style="font-size:14px;">Party Name<span style="color:red;">*</span></label>
<div class="controls">
<input type="text" class="m-wrap span9 nonrr1 ignore" name="party_name" id="party" value="<?php echo $party_name; ?>"/>
</div>
<br />

<label style="font-size:14px;">Bill Reference<span style="color:red;">*</span></label>
<div class="controls">
<input type="text" class="m-wrap span9 nonrr2 ignore" name="bill_reference" id="bill_ref" value="<?php echo $bill_reference; ?>"/>
</div>
<br />

<?php } ?>	

<label style="font-size:14px;">Amount Applied<span style="color:red;">*</span></label>
<div class="controls">
<input type="text" name="amount" id="amtttt" class="m-wrap span5" value="<?php echo $amount; ?>"/>
<label id="amtttt"></label>
</div>
<br />


<label style="font-size:14px;">Narration</label>
<div class="controls">
<textarea   rows="4" name="description" class="span9 m-wrap" placeholder="Narration" style="background-color:white !important;resize:none;" id="nar" ><?php echo $narration; ?></textarea>
</div>
<br />
	
 
</div> 
</div>

		<div class="confirm_div" style="display: none;">
			<div class="modal-backdrop fade in"></div>
			<div class="modal" id="poll_edit_content">
			<div class="modal-body">
				Are you sure to edit this bill?				   			   
			</div>
			<div class="modal-footer">
				<button type="button" class="btn" role="button" id="close_button">CLOSE</button>
				<button type="submit" class="btn red" name="bank_receipt_update">UPDATE RECEIPT</button>
			</div>
			</div>
		</div>
		
<div class="form-actions">
<a href="<?php echo $webroot_path; ?>Cashbanks/bank_receipt_view" role="button" rel="tab" class="btn green"><i class="icon-arrow-left"></i> Back</a>
<a href="#" role="button" class="btn green submit_button">UPDATE RECEIPT</a>
</div>
</div>
</div>
</form>

<script>
$(document).ready(function() {
	$('.submit_button').live('click',function(){
		$('.confirm_div').show();
	});
	$('#close_button').live('click',function(){
		$('.confirm_div').hide();
	});
});
</script>
<script>
function cheque_view()
{

$("#cheque_show_by_query").show();
$("#neft_show").hide();
}
function neft_text_view()
{	
$("#cheque_show_by_query").hide();
$("#neft_show").show();

}
function pg_show()
{
$("#cheque_show_by_query").hide();
$("#neft_show").show();
}
</script>