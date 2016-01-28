<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>				   
<script>
$(document).ready(function() {
$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>

<style>
#tbb th{
	font-size: 10px !important;background-color:#C8EFCE;padding:2px;border:solid 1px #55965F;white-space: nowrap !important; 
}
#tbb td{
	padding:2px;
	font-size: 12px;border:solid 1px #55965F;background-color:#FFF;white-space: nowrap !important; 
}
.text_bx{
	width: 50px;
	height: 15px !important;
	margin-bottom: 0px !important;
	font-size: 12px;
}
.text_rdoff{
	width: 50px;
	height: 15px !important;
	border: none !important;
	margin-bottom: 0px !important;
	font-size: 12px;
}
</style>





<!----- import functioality start --------->

<a href="#" class="btn purple" role="button" id="import">Import</a>
<div id="myModal3" class="modal hide fade in" style="display: none;">
<div class="modal-backdrop fade in"></div>
	<form id="form1" method="post">
	<div class="modal">
		<div class="modal-header">
			<h4 id="myModalLabel1">Import csv</h4>
		</div>
		<div class="modal-body">
			<input type="file" name="file" class="default"  id="image-file">
			  <label id="vali"></label>	
			<strong><a href="expense_tracker_export">Click here for sample format</a></strong>
			<br/>
			 <h4>Instruction set to import expense tracker</h4>
			 
				<ol>
				<li>Posting date & date of invoice field are compulsory.</li>
				<li>Party account head & expense head field are compulsory.</li>
				<li>Amount field should be numeric.</li>
				<li>Attachment,Description field are not compulsory </li>
				<li>Date format should be (d-m-Y). </li>
				</ol>
			 
		</div>
		<div class="modal-footer">
			<button type="button" class="btn" id="close_div">Close</button>
			<button type="submit" class="btn blue import_btn">Import</button>
		</div>
	</div>
	</form>
</div>






<!----- end  import functionality ---------->
<!--

<div style="border:solid 2px #4cae4c; width:100%; margin:auto;" class="portal">
<div style="border-bottom:solid 2px #4cae4c; color:white; background-color: #5cb85c; padding:4px; font-size:20px;"><i class="icon-money"></i> Record Expense Transaction</div>



<div style="padding:10px;background-color:#FFF;">
<form method="post" id="contact-form" name="myform" enctype="multipart/form-data">
<div id="output"></div>
-->

<!----------Add row functionality ---------------->
<!--
<table class="" style="" id="tbb">
<thead>
<tr>
<th >Posting date</th>
<th >Date of Invoice</th>
<th >Due Date</th>
<th >Party Account Head <a href="#" role="button" class="btn mini blue tooltips" data-original-title="Add new Party Account Head" data-placement="top" id="new_party_acc"><i class="icon-plus"></i></a></th>
<th >Invoice Reference</th>
<th >Expense Head</th>
<th >Amount of Invoice</th>
<th >Description</th>
<th >Attachment</th>
<th >Delete</th>
</tr>
</thead>
<tbody id="count_row">
<tr>
<td width="8%"><input type="text" class="date-picker m-wrap span12" data-date-format="dd-mm-yyyy" name="posting_date" id="pd" value="<?php echo date("d-m-Y"); ?>">
</td>
<td width="8%"> <input type="text" class="date-picker m-wrap span12" data-date-format="dd-mm-yyyy" name="p_due_date" id="due"></td>
<td width="8%"> <input type="text" class="date-picker m-wrap span12" data-date-format="dd-mm-yyyy" name="date_of_invoice" id="due">
</td>
<td style="">
<select name="party_head" class="m-wrap span12 chosen" id="">
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
<input type="text" class="m-wrap span12" name="invoice_reference" id="ref" style="text-align:right;">
</td>


<td width="15%">
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
<input type="text" class="m-wrap span12 amt1" style="text-align:right;"  name="invoice_amount" id="ammmttt1" onkeyup="amt_val(this.value,1)" maxlength="7">
</td>
<td style="text-align:center;" width="25%"><input type="text" class="m-wrap span12" name="description" maxlength="100" id=""></td>
<td style="text-align:center;">

<div class="control-group">
                              
                    <div class="controls">
                       <div class="fileupload fileupload-new" data-provides="fileupload"><input type="hidden" value="" name="">
                                    <span class="btn btn-file">
                                    <span class="fileupload-new"> file</span>
                                    <span class="fileupload-exists">Change</span>
                                    <input type="file" class="default" name="file1">
                                    </span>
                                    <span class="fileupload-preview"></span>
                                    <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none"></a>
                                 </div>
                      </div>
       </div>
</td>
</tr>
</tbody>
</table>

<!---------- End add row functioality ---------------->

<!--
<br/>
<button type="submit" name="send" class="btn blue " value="1"> Submit</button>
<button type="button" name="draft" class="btn " value="2" id="add"> Add Row</button>
</form>

</div>
</div>

<div class="alert alert-block alert-success fade in" style="display:none;">
	<h4 class="alert-heading">Success!</h4>
</div>




<div id="party_acc_popup" class="modal fade in" style="display:none;">
<div class="modal-backdrop fade in"></div>
	<form  class="form-horizontal">
		<div class="modal" id="party_acc_head_body">
			<div class="modal-header">
				<h4 id="myModalLabel1">Add New Party Account Head</h4>
			</div>
			<div class="modal-body" >
				<div class="control-group">
				   <label class="control-label">Party Account Head</label>
				   <div class="controls">
					  <input placeholder="Party Account Head" id="party_acc_head" class="m-wrap " type="text">
				   </div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn" id="close_div">Close</button>
				<button type="button" class="btn blue submit_btn">Add</button>
			</div>
		</div>
	</form>
</div>

-->

<!-------------------------------- Start New Expense Tracker Form ------------------------------------->
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
<!------------------------------ End New Expense Tracker Form ----------------------------------------->

<script>
function amt_val(vv,dd)
{
if($.isNumeric(vv))
{
$("#output").html('');	
}
else
{
$("#output").html('<div class="alert alert-error" style="color:red; font-weight:600; font-size:13px;">Amount Should be Numeric Value in row '+ dd +'</div>');
$("#ammmttt"+ dd).val("");
return false;		
}
}
</script>

<script>

function add_rowwwww()
{
$(".adrww").hide();	
var count = $("#main_table")[0].rows.length;
count++;
$.ajax({
url: 'expense_tracker_add_row?con=' + count,
}).done(function(response) {
$('#main_table').append(response);
$(".adrww").show();
});
}
function delete_row(ttt)
{
$('.content_'+ttt).remove();	
}
</script>




<script>
$(document).ready(function(){
	
	
$("#new_party_acc").live('click',function(){	
	$('#party_acc_popup').show();
});	

$("#close_div").live('click',function(){	
	$('#party_acc_popup').hide();
});	

$(".submit_btn").bind('click',function(){	
	var party_acc_head=encodeURI($('#party_acc_head').val());
	$.ajax({
		url: "<?php echo $webroot_path; ?>Expensetrackers/add_new_party_account_head/"+party_acc_head,
		}).done(function(response) {
			if(response=="OK"){
				$('#party_acc_head_body').html('<br/><div class="alert alert-block alert-success fade in"><p>New party account head added.</p><p><a class="btn green" role="button" rel="tab" href="<?php echo $webroot_path; ?>Expensetrackers/expense_tracker_add">OK</a></p></div>');
			}
		});	
});	
	
	
	


$(".delete").live('click',function(){	
var id = $(this).attr("id");
$('.content_'+id).remove();
});

$("#import").bind('click',function(){
	$("#myModal3").show();
 });
	 
$("#close_div").bind('click',function(){
	$("#myModal3").hide();
});

$('form#form1').submit( function(ev){ 
ev.preventDefault();
im_name=$("#image-file").val();

    if(im_name==""){
	$("#vali").html("<span style='color:red;'>Please Select a Csv File</span>");	
	return false;
    }

var ext = $('#image-file').val().split('.').pop().toLowerCase();
if($.inArray(ext, ['csv']) == -1) {
	$("#vali").html("<span style='color:red;'>Please Select a Csv File</span>");
	return false;
}
$(".import_btn").text("Importing...");
var m_data = new FormData();
m_data.append( 'file', $('input[name=file]')[0].files[0]);

		$.ajax({
		url: "<?php echo $this->webroot;?>Expensetrackers/import_expense_tracker_ajax",
		data: m_data,
		processData: false,
		contentType: false,
		type: 'POST',
		}).done(function(response) {
			
		$("#myModal3").hide();
		$('#show_import_data').html(response);

});
});




$('form#form2').submit( function(ev){ 
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
//m_data.append( 'file'+i, $('input[name=file'+i+']')[0].files[0]);
ar.push([posting_date,date_of_invoice,due_date,ex_head,invoice_ref,party_ac,amt_inv,description]);
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
				
				$("#output").html(response);
			if(response.report_type=='error'){
			
					$("#output").html('<div class="alert alert-error" style="color:red; font-weight:600; font-size:13px;">'+response.text+'</div>');
					 //setInterval(function(){ $("#output").html(''); }, 10000);
					//$("#output").html('');
			}
			if(response.report_type=='submit'){
				$(".portal").remove();
				$("#shwd").show();
				$(".swwtxx").html(response.text);
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

<div id="shwd" class="hide">
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body">
<h4><b>Thank You!</b></h4>
<p class="swwtxx"></p>
</div>
<div class="modal-footer">
<a href="<?php echo $webroot_path; ?>Expensetrackers/expense_tracker_view" class="btn red" rel='tab'>OK</a>
</div>
</div>
</div> 