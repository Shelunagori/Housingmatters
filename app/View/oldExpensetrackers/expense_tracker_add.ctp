<?php
$todat_posting = date('d-m-Y');
?>
<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>				   
<script>
$(document).ready(function() {
$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>
<input type="hidden" id="fi" value="<?php echo $datef1; ?>" />
<input type="hidden" id="ti" value="<?php echo $datet1; ?>" />
<input type="hidden" id="cn" value="<?php echo $count; ?>" />
<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<?php
$e=0;
foreach ($cursor1 as $collection)
{
$c_id =  (int)$collection['accounts_group']['auto_id'];
//$c_name = $collection['accounts_group']['category_name'];
$result = $this->requestAction(array('controller' => 'hms', 'action' => 'expense_tracker_fetch2'),array('pass'=>array($c_id)));
foreach ($result as $db)
{
$e++;
$g_id =  (int)$db['ledger_account']['auto_id'];
$name = $db['ledger_account']['ledger_name'];
$g_id_arr[]=$g_id;
$name_arr[]=$name;
}}
$g_id_arr2 = implode(',',$g_id_arr);
$name_arr2 = implode(',',$name_arr);

$w=0;
foreach ($cursor2 as $collection)
{
$w++;	
$id = $collection['ledger_sub_account']['auto_id'];
$name = $collection['ledger_sub_account']['name']; 
$id_arr[]=$id; 
$naam2_arr[]=$name;
}
if(!empty($id_arr))
{
@$id_arr2 = implode(',',@$id_arr);
}

if(!empty($naam2_arr))
{
@$naam2_arr2 = implode(',',@$naam2_arr);
}
?>
<input type="hidden" id="count1" value="<?php echo $w; ?>" />
<input type="hidden" id="count2" value="<?php echo $e; ?>" />


<input type="hidden" id="g_id" value="<?php echo $g_id_arr2; ?>" />
<input type="hidden" id="name1" value="<?php echo $name_arr2; ?>" />
<input type="hidden" id="id1" value="<?php echo @$id_arr2; ?>" />
<input type="hidden" id="name2" value="<?php echo @$naam2_arr2; ?>" />

<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>

<div style="background-color:#fff;padding:5px;width:96%;margin:auto; overflow:auto;" class="form_div">
<h4 style="color: #00F;font-weight: 500;border-bottom: solid 1px #DAD9D9;padding-bottom: 10px;"><i class="icon-money"></i> Post Expense</h4>
<?php
if($zz == 0)
{
?>
<div style="background-color:#FCEBF8;">
<center>
<p style="color:#A99185;">No Previous Voucher</p>
</center>
</div> 
<?php
}
else
{
?>
<div style="background-color:#FCEBF8;">
<center>
<p style="color:#A99185;">The Last Expense Voucher is : <?php echo $zz; ?></p>
</center>
</div> 
<?php } ?>
<br />
<div id="vvv" style="background-color:white;"></div>
<form method="post" enctype="multipart/form-data" id="qqq">

<div class="row-fluid">

<div class="span6">


<label style="font-size:14px;">Posting Date<span style="color:red;">*</span></label>
<div class="controls">
<input type="text" class="date-picker m-wrap span7" data-date-format="dd-mm-yyyy" name="posting_date" id="pd" value="<?php echo $todat_posting; ?>">
<label report="pos_dat" class="remove_report"></label>
<div id="result11"></div>
</div>
<br />

<label style="font-size:14px;">Payment Due Date<span style="color:red;">*</span> <i class=" icon-info-sign tooltips" data-placement="right" data-original-title="Please select due date for payment"> </i></label>
<div class="controls">	
<input type="text" class="date-picker m-wrap span7" data-date-format="dd-mm-yyyy" name="due_date" id="due">
<label report="du_dat" class="remove_report"></label>
</div>
<br />

<label style="font-size:14px;">Date of Invoice<span style="color:red;">*</span> <i class=" icon-info-sign tooltips" data-placement="right" data-original-title="Please select invoice date"> </i></label>
<div class="controls">							
<input type="text" class="date-picker m-wrap span7" data-date-format="dd-mm-yyyy" name="invoice_date" id="date">
<label report="inv_dat" class="remove_report"></label>
</div>	
<br />
</div>

<div class="span6">
<label style="font-size:14px;">Description</label>
<div class="controls">
<textarea  rows="4" name="description" class="m-wrap span9" style="resize:none;" id="des"></textarea>
</div>



<label style="font-size:14px;">Attachment</label>
<div class="controls">
<div class="fileupload fileupload-new" data-provides="fileupload"><input type="hidden" value="" name="">
<span class="btn btn-file">
<span class="fileupload-new">Select file</span>
<span class="fileupload-exists">Change</span>
<input type="file" class="default" name="file" id="upl">
</span>
<span class="fileupload-preview"></span>
<a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none"></a>
</div>
</div>
</div>
<?php /////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<br />

<table class="table table-bordered" style="background-color:white;" id="tbb">
<thead>
<tr>
<th style="text-align:center; width:24%;">Expense Head</th>
<th style="text-align:center; width:24%;">Invoice Reference</th>
<th style="text-align:center; width:24%;">Party Account Head &nbsp;&nbsp; <a class="btn purple mini" onclick="show()"><span class="icon-plus"></span></a></th>
<th style="text-align:center; width:24%;">Amount of Invoice</th>
<th style="text-align:center; width:4%;">Delete</th>
</tr>
</thead>
<tbody id="bdd">
<tr>
<td style="text-align:center;">
<select name="ex_head" class="m-wrap span12" id="ex">
<option value="">Select</option>
<?php
foreach ($cursor1 as $collection)
{
$c_id =  (int)$collection['accounts_group']['auto_id'];
$c_name = $collection['accounts_group']['category_name'];
$result = $this->requestAction(array('controller' => 'hms', 'action' => 'expense_tracker_fetch2'),array('pass'=>array($c_id)));
foreach ($result as $db)
{
$g_id =  (int)$db['ledger_account']['auto_id'];
$name = $db['ledger_account']['ledger_name'];
?>
<option value="<?php echo $g_id; ?>"><?php echo $name; ?></option>
<?php }} ?>
</select>
</td>
<td style="text-align:center;">
<input type="text" class="m-wrap span9" name="invoice_reference" id="ref">
</td>
<td style="text-align:center;">
<select name="party_head" class="m-wrap span9" id="ph">
<option value="">Select</option>
<?php
foreach ($cursor2 as $collection)
{
$id = $collection['ledger_sub_account']['auto_id'];
$name = $collection['ledger_sub_account']['name']; 
?>                             
<option value="<?php echo $id; ?>"><?php echo $name; ?></option>
<?php } ?>
</select>
</td>
<td style="text-align:center;">
<input type="text" class="m-wrap span9 amt1"   name="invoice_amount" id="ia" onkeyup="amt_val()">
</td>
<td style="text-align:center;"></td>
</tr>
</tbody>
</table>
<div id="www"></div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
</div>
<hr/>
<button type="submit" class="btn form_post" style="background-color: #00F; color:#fff;" name="ext_add" value="xyz" id="vali">Submit</button>
<a href="<?php echo $webroot_path; ?>Expensetrackers/expense_tracker_add" style="background-color:#D3D1CF; color:#fff;" class="btn" rel='tab'>Reset</a>
<button type="button" class="btn green" id="add">Add Row</button>

<div style="display:none;" id='wait'><img src="<?php echo $webroot_path; ?>as/fb_loading.gif" />Please Wait...</div>
<br /><br />
</form>
</div>
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<script>
function amt_val()
{
var cc = $("#bdd tr").length;
for(var i=1; i<=cc; i++)
{
var amt = $(".amt"+ i).val();
if(isNaN(amt))
{
$("#www").html('<p style="color:red;">Please Fill Numeric Amount</p>');	
}
else
{
$("#www").html('');	
}
}
}
</script> 
<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<script>
$(document).ready(function(){
$("#add").bind('click',function(){

var count = $("#bdd tr").length;
count++;

$.ajax({
url: 'expense_tracker_add_row?con=' + count,
}).done(function(response) {
$('tbody#bdd').append(response);

});
});


$(".delete").live('click',function(){	
var id = $(this).attr("id");
$('.content_'+id).remove();
});

});
</script> 
<?php /////////////////////////////////////////////////////////////////////////////////////////////////////// ?>

<script>
$(document).ready(function() { 
	$('#qqq').submit( function(ev){
	ev.preventDefault();

var m_data = new FormData();
m_data.append( 'file', $('input[name=file]')[0].files[0]);
m_data.append( 'post', $('input[name=posting_date]').val());
m_data.append( 'due', $('input[name=due_date]').val());
m_data.append( 'inv_dat', $('input[name=invoice_date]').val());
m_data.append( 'desc', $('textarea[name=description]').val());
	
var ar=[];

var count = $("#bdd tr").length;
for(var i=1; i<=count; i++)
{
var ex_head=$("#bdd tr:nth-child("+i+") td:nth-child(1) select").val();
var invoice_ref=$("#bdd tr:nth-child("+i+") td:nth-child(2) input").val();
var party_ac=$("#bdd tr:nth-child("+i+") td:nth-child(3) select").val();
var amt_inv=$("#bdd tr:nth-child("+i+") td:nth-child(4)  input").val();
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
	$("#vvv").html(response);
if(response.report_type=='error')
{
$("#vvv").html('<b><p style="font-size:16px; color:red;">'+response.text+'</p></b>');
}
if(response.report_type=='publish'){
$("#shwd").show()
$(".success_report").show().html(response.report);	
}

$("html, body").animate({
scrollTop:0
},"slow");
$(".form_post").removeClass("disabled");
$("#wait").hide();
});


});
});
</script>



<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>

<div id="shwd" class="hide">
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-header">
<center>
<h3 id="myModalLabel3" style="color:#999;"><b>Expense Tracker</b></h3>
</center>
</div>
<div class="modal-body">
<center>
<h5><b class="success_report"></b></h5>
</center>
</div>
<div class="modal-footer">
<a href="<?php echo $webroot_path; ?>Expensetrackers/expense_tracker_view" class="btn blue" rel='tab'>OK</a>
</div>
</div>
</div>

<script>
		$(document).ready(function() {
		$("#vali").live('click',function(){
        
		var fi = document.getElementById("fi").value;
		var ti = document.getElementById("ti").value;
		var cn = document.getElementById("cn").value;
		var fe = fi.split(",");
		var te = ti.split(",");
		var date1 = document.getElementById("pd").value;
		
		var date = date1.split("-").reverse().join("-");
				
		var nnn = 55;
		for(var i=0; i<cn; i++)
		{
		var fd = fe[i];
		var td = te[i]
		
		    if(date == "")
			{
				nnn = 555;
			break;	
			}
			else if(Date.parse(fd) <= Date.parse(date))
		     {
			 if(Date.parse(td) >= Date.parse(date))
			 {
				 nnn = 5;
				 break;
			 }
			 else
			 {
				 
			 }
        	 } 
			 }
			 
		
		if(nnn == 55)
		{
		$("#result11").load("cash_bank_vali?ss=" + 2 + "");
        return false;	
		}
		else if(nnn == 555)
		{
			
		}
		else
		{
		$("#result11").load("cash_bank_vali?ss=" + 12 + "");		
		}
	
		});
		});
		</script>	
<script>
function show()
{

$("#hhhh").show();

}
</script>



<div id="hhhh" class="hide">
<div class="modal-backdrop fade in"></div>
<form method="post" id="contact-form">
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-header">
<center>
<h3>Add Party Head</h3>
</center>
</div>
<div class="modal-body">
<input type="text" name="cat_name" placeholder="Name" class="m-wrap large" style="background-color:white !important;" id="cat">
<label id="cat"></label>
</div>
<div class="modal-footer">
<a href="<?php echo $webroot_path; ?>Expensetrackers/expense_tracker_add" class="btn blue" rel='tab'>No</a>
<button type="submit" class="btn blue" name="kkk">Submit</button>
</div>
</div>
</form>	
</div>
</div>

<!--
<div id="shwd" class="hide">
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-header">
<center>
<h3 id="myModalLabel3" style="color:#999;"><b>Rate Card</b></h3>
</center>
</div>
<div class="modal-body">
<center>
<h5><b class="success_report"></b></h5>
</center>
</div>
<div class="modal-footer">
<a href="<?php //echo $webroot_path; ?>Incometrackers/master_rate_card" class="btn blue" rel='tab'>No</a>
<button type="submit" class="btn blue form_post" submit_type="con" onclick="mssg()">Yes</button>
</div>
</div>
</div>
-->

<script>
$(document).ready(function(){
	
	 jQuery.validator.addMethod("notEqual", function(value, element, param) {
  return this.optional(element) || value !== param;
}, "Please choose Other value!");
	
		$.validator.setDefaults({ ignore: ":hidden:not(select)" });
		
		$('#contact-form').validate({
	
		errorElement: "label",
                    //place all errors in a <div id="errors"> element
                    errorPlacement: function(error, element) {
                        //error.appendTo("label#errors");
						error.appendTo('label#' + element.attr('id'));
                    },
					
	    rules: {
	      cat_name: {
	        required: true
	      },
		  
		 		
				
		      },
			highlight: function(element) {
				$(element).closest('.control-group').removeClass('success').addClass('error');
			},
			success: function(element) {
				element
				.text('OK!').addClass('valid')
				.closest('.control-group').removeClass('error').addClass('success');
			}
	  });

}); 
</script>







