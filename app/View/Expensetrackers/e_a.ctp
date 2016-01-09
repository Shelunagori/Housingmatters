<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>				   
<script>
$(document).ready(function() {
$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>



<div style="border:solid 2px #4cae4c; width:90%; margin:auto;" class="portal">
<div style="border-bottom:solid 2px #4cae4c; color:white; background-color: #5cb85c; padding:4px; font-size:20px;"><i class="icon-money"></i> Expense</div>
<div style="padding:10px;background-color:#FFF;">
<form method="post" id="contact-form" name="myform" enctype="multipart/form-data">
<div id="output"></div>

<div class="row-fluid">

<div class="span4 responsive">
 <label style="font-size:14px;">Posting Date <span style="color:red;">*</span></label>
<div class="controls">
<input type="text" class="date-picker m-wrap span10" data-date-format="dd-mm-yyyy" name="posting_date" id="pd" value="">
<label report="pos_dat" class="remove_report"></label>
</div>
</div>

<div class="span4 responsive">
 <label style="font-size:14px; ">Payment Due Date <span style="color:red;">*</span></label>
<div class="controls">
 <input type="text" class="date-picker m-wrap span10" data-date-format="dd-mm-yyyy" name="p_due_date" id="due">
<label report="du_dat" class="remove_report"></label>
</div>
</div>


<div class="span4 responsive">
 <label style="font-size:14px; ">Date of Invoice <span style="color:red;">*</span></label>
<div class="controls">
 <input type="text" class="date-picker m-wrap span10" data-date-format="dd-mm-yyyy" name="date_of_invoice" id="due">
<label report="du_dat" class="remove_report"></label>
</div>
</div>



</div>

<!-------------------------->

<table class="table table-bordered" style="background-color:white;" id="tbb">
<thead>
<tr>

<th style="text-align:center; width:24%;">Expense Head</th>
<th style="text-align:center; width:24%;">Invoice Reference</th>
<th style="text-align:center; width:24%;">Party Account Head </th>
<th style="text-align:center; width:24%;">Amount of Invoice</th>
<th style="text-align:center; width:4%;">Delete</th>
</tr>
</thead>
<tbody id="count_row">
<tr>
<td style="">
<select name="ex_head" class="m-wrap span12 chosen" id="">
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

<td style="text-align:center;">
<input type="text" class="m-wrap span9" name="invoice_reference" id="ref">
</td>
<td style="">
<select name="party_head" class="m-wrap span9 chosen" id="">
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
<td style="text-align:center;">
<input type="text" class="m-wrap span9 amt1"   name="invoice_amount" id="ia" onkeyup="amt_val()">
</td>
<td style="text-align:center;"></td>
</tr>
</tbody>
</table>

<!-------------------------->
<div class="row-fluid">

<div class="span6 responsive">
<div class="controls">
<label style="font-size:14px; "> Description </label>
 <textarea class="m-wrap span12" name="description" id=""></textarea>
<label report="" class="remove_report"></label>
</div>
</div>


<div class="span6 responsive">
<div class="control-group">
  <label class="control-label">Attachment  </label>
  <div class="controls">
	 <div class="fileupload fileupload-new" data-provides="fileupload"><input type="hidden" value="" name="">
		<div class="input-append">
		   <div class="uneditable-input">
			  <i class="icon-file fileupload-exists"></i> 
			  <span class="fileupload-preview"></span>
		   </div>
		   <span class="btn btn-file">
		   <span class="fileupload-new">Select file</span>
		   <span class="fileupload-exists">Change</span>
		   <input type="file" name="file" id="file" class="default" >
		   </span>
		   <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
		</div>
	 </div>
  </div>
</div>
</div>
</div>
<button type="submit" name="send" class="btn blue " value="1"> Submit</button>
<button type="button" name="draft" class="btn " value="2" id="add"> Add Row</button>
</form>

</div>
</div>
<div class="alert alert-block alert-success fade in" style="display:none;">
	<h4 class="alert-heading">Success!</h4>
</div>

<script>
$(document).ready(function(){
$("#add").bind('click',function(){
var count = $("#count_row tr").length;
count++;
$.ajax({
url: 'expense_tracker_add_row?con=' + count,
}).done(function(response) {
$('tbody#count_row').append(response);

});
});
$(".delete").live('click',function(){	
var id = $(this).attr("id");
$('.content_'+id).remove();
});
$('form#contact-form').submit( function(ev){
	ev.preventDefault();	
	var m_data = new FormData(); 
	var posting_date=$('input[name=posting_date]').val();
	var payment_due_date=$('input[name=p_due_date]').val();
	var date_of_invoice=$('input[name=date_of_invoice]').val();
	var description=$('textarea[name=description]').val();
	m_data.append('posting_date',posting_date);
	m_data.append('payment_due_date',payment_due_date);
	m_data.append('date_of_invoice',date_of_invoice);
	m_data.append('description',description);
	m_data.append( 'file', $('input[name=file]')[0].files[0]);
	
	
	var count = $("#count_row tr").length;
	var ar=[];
	for(var i=1; i<=count; i++)
	{
	var ex_head=$("#count_row tr:nth-child("+i+") td:nth-child(1) select").val();
	var invoice_ref=$("#count_row tr:nth-child("+i+") td:nth-child(2) input").val();
	var party_ac=$("#count_row tr:nth-child("+i+") td:nth-child(3) select").val();
	var amt_inv=$("#count_row tr:nth-child("+i+") td:nth-child(4)  input").val();
	ar.push([ex_head,invoice_ref,party_ac,amt_inv]);
	}
	var myJsonString = JSON.stringify(ar);
	m_data.append('myJsonString',myJsonString);
	$.ajax({
			url: "expense_tracker_json",
			data: m_data,
			processData: false,
			contentType: false,
			type: 'POST',
			dataType:'json',
			}).done(function(response) { 
			if(response.report_type=='error')
			{
				
			
					$("#output").html('<div class="alert alert-error">'+response.text+'</div>');
					 //setInterval(function(){ $("#output").html(''); }, 10000);
			  //$("#output").html('');
			}
			if(response.report_type=='submit')
			{
				$(".portal").remove();
				$(".alert-success").show().append("<p>"+response.text+"</p><p><a class='btn green' href='<?php echo $webroot_path; ?>Expensetrackers/expense_tracker_view' rel='tab' >ok</a></p>");
				$("#output").remove();
			}
			$("html, body").animate({
			scrollTop:0
			},"slow");
			//$("#output").html(response);
			
	});
	
});



});
</script> 

