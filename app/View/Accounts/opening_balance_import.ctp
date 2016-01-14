<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>				   
<script>
$(document).ready(function() {
$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>
<div id="done" style="overflow:auto;">
<form  id="form1" method="post" >	
<div class="show_record" style="width:100%; overflow:auto;">
<div class="portlet box green">
<div class="portlet-title">
<h4><i class="icon-cogs"></i> Csv Import</h4>
</div>
<div class="portlet-body">

<div class="control-group">
<label class="control-label">Attach csv file
  <i class=" icon-info-sign tooltips" data-placement="right" data-original-title="Please choose csv file"> </i>
</label> 

<div class="controls">
<input type="file" name="file" id="image-file">
 
<button type="submit" class="btn blue import_btn">Import</button>
<label id="vali"></label>
</div>
</div>

<strong><a href="open_excel" download="" target="_blank">Download sample format</a></strong>
<br>
<h4>Instruction set to import users</h4>
<ol>
<li>All the field are compulsory.</li>
<li>Opening Balance Amount should be Numeric</li>
<li>Amount Type should be 'Debit' or 'Credit'</li>
<li>Total Debit should be same to total Credit</li>
</ol>
</div>
</div>

</form>	
</div>
</div>


<?php //////////////////////////////////////////////////////////////////////////////////// ?>

<script>
$(document).ready(function(){

$(".delete").live('click',function(){
var id = $(this).attr("del");
$('#tr'+id).remove();
});

$('form#form1').submit( function(ev){
		ev.preventDefault();
		
		 im_name=$("#image-file").val();
		var insert = 1;
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
		url: "opening_balance_import_ajax",
		data: m_data,
		processData: false,
		contentType: false,
		type: 'POST',
		}).done(function(response) {
			
		$(".show_record").html(response);
var insert = 1;
var count = $("#open_bal tr").length;
count--;
var ar = [];

$("#open_bal2 tr:nth-child(1) span.report").remove();
var date = $("#date").val();

for(var i=2;i<=count;i++)
{
$("#open_bal tr:nth-child("+i+") span.report").remove();
$("#open_bal tr:nth-child("+i+") span.report").css("background-color", "white");
var group = $("#open_bal tr:nth-child("+i+") td:nth-child(1) select").val();
var ac=$("#open_bal tr:nth-child("+i+") td:nth-child(2) input").val();
var type=$("#open_bal tr:nth-child("+i+") td:nth-child(3) input").val();
var amt=$("#open_bal tr:nth-child("+i+") td:nth-child(4) input").val();
var pen =$("#open_bal tr:nth-child("+i+") td:nth-child(1) input").val();
ar.push([group,ac,type,amt,insert,date]);
}

var myJsonString = JSON.stringify(ar);
myJsonString=encodeURIComponent(myJsonString);

$.ajax({
url: "save_open_bal?q="+myJsonString,
type: 'POST',
dataType:'json',
}).done(function(response) {
	
if(response.report_type=='error'){
jQuery.each(response.report, function(i, val) {
	
$("#open_bal tr:nth-child("+val.tr+") td:nth-child("+val.td+")").append('<span class="report" style="color:red;">'+val.text+'</span>');

$("#open_bal tr:nth-child("+val.tr+") td:nth-child("+val.td+")").css("background-color", "#f2dede");

$("#open_bal tr:nth-child("+val.tr+") td:nth-child("+val.td+")").css("background-color", "#f2dede");

$("#open_bal tr:nth-child("+val.tr+") td:nth-child("+val.td+")").css("background-color", "#f2dede");
});
}
});

$(".import_op").bind('click',function(){

var insert = 2;
	
var count = $("#open_bal tr").length;
count--;
var ar = [];

var date = $("#date").val();

for(var i=2;i<=count;i++)
{
$("#open_bal tr:nth-child("+i+") span.report").remove();
$("#open_bal tr:nth-child("+i+") span.report").css("background-color", "white");
var group = $("#open_bal tr:nth-child("+i+") td:nth-child(1) select").val();
var ac=$("#open_bal tr:nth-child("+i+") td:nth-child(2) input").val();
var type=$("#open_bal tr:nth-child("+i+") td:nth-child(3) input").val();
var amt=$("#open_bal tr:nth-child("+i+") td:nth-child(4) input").val();
var pen_amt=$("#open_bal tr:nth-child("+i+") td:nth-child(5) input").val();
var flat=$("#open_bal tr:nth-child("+i+") td:nth-child(1) input").val();
ar.push([group,ac,type,amt,insert,date,pen_amt,flat]);
}
var myJsonString = JSON.stringify(ar);
myJsonString=encodeURIComponent(myJsonString);	
		
$.ajax({
url: "save_open_bal?q="+myJsonString,
type: 'POST',
dataType:'json',
}).done(function(response) {
if(response.report_type=='error'){	
jQuery.each(response.report, function(i, val) {
$("#open_bal tr:nth-child("+val.tr+") td:nth-child("+val.td+")").append('<span class="report" style="color:red;">'+val.text+'</span>');

$("#open_bal tr:nth-child("+val.tr+") td:nth-child("+val.td+")").css("background-color", "#f2dede");

$("#open_bal tr:nth-child("+val.tr+") td:nth-child("+val.td+")").css("background-color", "#f2dede");

$("#open_bal tr:nth-child("+val.tr+") td:nth-child("+val.td+")").css("background-color", "#f2dede");
});
}
if(response.report_type=='fina')
{
$("#vali").html('<b style="color:red;">'+response.text+'</b>');
$("#deb").html(response.deb);
$("#cre").html(response.cre);
	
}
if(response.report_type=='done')
{
$("#hide_div").show();
}

});	
});
});
});
});
</script>
<div id="hide_div" class="hide">
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body">
<h4><b>Thank You!</b></h4>
The Opening Balances Imported Successfully
</div>
<div class="modal-footer">
<a class="btn red" href="<?php echo $webroot_path; ?>Accounts/opening_balance_import" rel="tab">OK</a>
</div>
</div>
</div>




<script>
$(document).ready(function() {
<?php	
$status5=(int)$this->Session->read('opnn_bll');
if($status5==1)
{
?>
$.gritter.add({
title: 'Opening Balance Import',
text: '<p>Thank you.</p><p>The Opening Balance Imported Successfully.</p>',
sticky: false,
time: '10000',
});
<?php
$this->requestAction(array('controller' => 'hms', 'action' => 'griter_notification'), array('pass' => array(5513)));
} ?>
});
</script>















