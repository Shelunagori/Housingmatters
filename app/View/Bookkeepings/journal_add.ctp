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
#main_table th{
	font-size: 10px !important;background-color:#C8EFCE;padding:2px;border:solid 1px #55965F;white-space: nowrap !important; 
}
#main_table td{
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


<input type="hidden" id="fi" value="<?php echo $datef1; ?>" />
<input type="hidden" id="ti" value="<?php echo $datet1; ?>" />
<input type="hidden" id="cn" value="<?php echo $count; ?>" />
<?php
$default_date = date('d-m-Y');

?>
<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<center>
<a href="<?php echo $webroot_path; ?>Bookkeepings/journal_add" class="btn yellow" rel='tab'>Create</a>
<a href="<?php echo $webroot_path; ?>Bookkeepings/journal_view" class="btn" rel='tab'>View</a>
<br><br>              
</center>      

<div id="submiting_div" style="display:none;">
	<div class="modal-backdrop fade in"></div>
	<div class="modal" id="poll_edit_content">
		<div class="modal-body">
		<div align="center">
		<img src="<?php echo $webroot_path; ?>as/fb_loading.gif" style="height: 15px;" />
		<h4>Please Wait</h4>
		<h5>Your data is under processing, kindly wait.</h5>
		</div>
        </div>
	</div>
</div>
      					
<div id="succ">
<div class="portlet box green" style="width:100%;">
<div class="portlet-title">
<h4><i class="icon-reorder"></i>Journal</h4>
</div>
<div class="portlet-body form">

<form  method="POST" onSubmit="return balance()" >	
<input type="text" id="date"  name="date" class="all_validate  m-wrap m-ctrl-medium date-picker"  data-date-format="dd-mm-yyyy" style="background-color:#FFF !important;" placeholder="Transaction Date" value="<?php echo $default_date; ?>">
<br><br>


<div id="error_msg"></div>
<div id="result11"></div>

<input type="hidden" id="t_box" name="xyz" value="2">

<div id="add_div" >
<table width="100%" id="main_table" >
<thead>
<tr class="table table-bordered table-hover" style="font-size:16px;" >
<th>Ledger A/c</th>
<th>Debits</th>
<th>Credits</th>
<th></th>
</tr>
</thead>
<tbody>
<tr class="table table-bordered table-hover" id="tr1">
<td style="padding-left:5px; padding-right:5px; padding-top:5px; padding-bottom:0px; ">
<select class="large m-wrap chosen">
						<option value="" style="display:none;">Select Ledger A/c</option>
						<?php
							 foreach ($cursor1 as $collection) 
							 {
							   $auto_id = (int)$collection['ledger_account']['auto_id'];
							   $name = $collection['ledger_account']['ledger_name'];
						if($auto_id != 34 && $auto_id != 33 && $auto_id != 35 && $auto_id != 15 && $auto_id != 112)
						{
						?>
						<option value="<?php echo $auto_id; ?>,2"><?php echo $name; ?></option>
							 <?php }}
                             foreach ($cursor2 as $collection) 
							 {
							$account_number = "";
							$wing_flat = "";
							 $auto_id2 = (int)$collection['ledger_sub_account']['auto_id'];
							 $name2 = $collection['ledger_sub_account']['name']; 
                             $ledger_id = (int)$collection['ledger_sub_account']['ledger_id'];
						
						if($ledger_id == 34)
						{							
$flat_id = @$collection['ledger_sub_account']['flat_id'];
$wing_detailll = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($flat_id)));
foreach($wing_detailll as $wing_dataaa)
{
$wing_idddd = (int)$wing_dataaa['flat']['wing_id'];	
}
$wing_flat= $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat_new'),array('pass'=>array($wing_idddd,$flat_id)));
						}
						if($ledger_id == 33){
$account_number = $collection['ledger_sub_account']['bank_account'];  	
							
						}
							 ?>
                          
					<option value="<?php echo $auto_id2; ?>,1"><?php echo $name2; ?> &nbsp;&nbsp; <?php echo @$wing_flat; ?><?php echo @$account_number; ?></option>
						  
						  <?php } ?>
						</select>
</td>	
				
<td style="padding-left:5px; padding-right:5px; padding-top:5px; padding-bottom:0px;">
<div class="control-group">
<div class="controls">
<input type="text" class="all_validate span12 m-wrap" style="background-color:#FFF !important;text-align:right;" onblur="total_am('1')" name="debit1" placeholder="" id="debit1" maxlength="10" onkeyup="amtvalidat1(this.value,1)">
</div>
</div>
</td>					
					
<td style="padding-left:5px; padding-right:5px; padding-top:5px; padding-bottom:0px; ">
<div class="control-group">
<div class="controls">
<input type="text" class="all_validate span12 m-wrap" style="background-color:#FFF !important;text-align:right;" name="credit1" onblur="total_amc('1')" placeholder="" id="credit1" maxlength="10" onkeyup="amtvalidat2(this.value,1)">
</div>
</div>
</td>


<td width="2%"></td>
</tr>
<tr class="table table-bordered table-hover" id="tr2">

<td style="padding-left:5px; padding-right:5px; padding-top:5px; padding-bottom:0px; ">

<select class="large m-wrap chosen">
						<option value="" style="display:none;">Select Ledger A/c</option>
						<?php
							 foreach ($cursor1 as $collection) 
							 {
							   $auto_id = (int)$collection['ledger_account']['auto_id'];
							   $name = $collection['ledger_account']['ledger_name'];
						if($auto_id != 34 && $auto_id != 33 && $auto_id != 35 && $auto_id != 15 && $auto_id != 112)
						{
						?>
						<option value="<?php echo $auto_id; ?>,2"><?php echo $name; ?></option>
							 <?php }}
                             foreach ($cursor2 as $collection) 
							 {
							$account_number = "";
							$wing_flat = "";
							 $auto_id2 = (int)$collection['ledger_sub_account']['auto_id'];
							 $name2 = $collection['ledger_sub_account']['name']; 
                             $ledger_id = (int)$collection['ledger_sub_account']['ledger_id'];
						
						if($ledger_id == 34)
						{							
$flat_id = @$collection['ledger_sub_account']['flat_id'];
$wing_detailll = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($flat_id)));
foreach($wing_detailll as $wing_dataaa)
{
$wing_idddd = (int)$wing_dataaa['flat']['wing_id'];	
}
$wing_flat= $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat_new'),array('pass'=>array($wing_idddd,$flat_id)));
						}
						if($ledger_id == 33){
$account_number = $collection['ledger_sub_account']['bank_account'];  	
							
						}
							 ?>
                          
					<option value="<?php echo $auto_id2; ?>,1"><?php echo $name2; ?> &nbsp;&nbsp; <?php echo @$wing_flat; ?><?php echo @$account_number; ?></option>
						  
						  <?php } ?>
						</select>

</td>

<td style="padding-left:5px; padding-right:5px; padding-top:5px; padding-bottom:0px; width:20%;">
<div class="control-group">
<div class="controls">
<input type="text" class="all_validate span12 m-wrap" style="background-color:#FFF !important;text-align:right;" onblur="total_am('2')" name="debit2" placeholder="" id="debit2" maxlength="10" onkeyup="amtvalidat1(this.value,2)">
</div>
</div>
</td>

<td style="padding-left:5px; padding-right:5px; padding-top:5px; padding-bottom:0px; width:18%;">
<div class="control-group">
<div class="controls">
<input type="text" class="all_validate span12 m-wrap" style="background-color:#FFF !important;text-align:right;"  name="credit2" onblur="total_amc('2')" placeholder="" id="credit2" maxlength="10" onkeyup="amtvalidat2(this.value,2)">
</div>
</div>
</td>


<td width="2%"><a href="#" role="button" class="btn mini black delete_row" id="2"><i class="icon-remove"></i></a></td>
</tr>	



</tbody>
<tfoot>
<tr class="table table-bordered table-hover">

<td style="padding-left:5px; padding-right:5px; padding-top:5px; padding-bottom:0px; text-align:right;">
<div align="left">
<input type="text"  name="remark1" class="all_validate span10 m-wrap m-ctrl-medium"  style="background-color:#FFF !important;"placeholder="Narration" id="desc1">
<span style="float:right;"> <b> Total </b> </span>
</div>

</td>
<td style="padding-left:5px; padding-right:5px; padding-top:5px; padding-bottom:0px;">
<div class="control-group">
<div class="controls">
<input type="text" class="all_validate span12 m-wrap" style="background-color:#FFF !important; border:none !important; text-align:right;" id="total" style="border:none !important;">
</div>
</div>
</td>
<td style="padding-left:5px; padding-right:5px; padding-top:5px; padding-bottom:0px;">
<div class="control-group">
<div class="controls">
<input type="text" class="all_validate span12 m-wrap" style="background-color:#FFF !important; border:none !important; text-align:right;" id="total_c" style="border:none !important;text-align:right;">
</div>
</div>
</td>

<td style="padding-left:5px; padding-right:5px; padding-top:5px; padding-bottom:0px; "></td>
</tr>

</tfoot>
</table>
</div>

<br><br>
<div class="form-actions" style="background-color:#fff">
<button type="submit" class="btn blue" name="journal_add" id="submit">Submit</button>
<button type="button" id="button_add" class="btn blue"> <i class="icon-plus"></i> Add Row</button>
<a href="journal_add" class="btn">Reset</a>
</div>


</form>
</div>
</div>
</div>
<div id="test"></div>
<script>
function amtvalidat1(vvv,ddd)
{
if($.isNumeric(vvv))
{
$("#error_msg").html('');	
}
else
{
$("#error_msg").html('<div class="alert alert-error" style="color:red; font-weight:600; font-size:13px;">Amount Should be Numeric Value in row '+ ddd +'</div>');
$("#debit"+ ddd).val("");
return false;		
}
}


function amtvalidat2(vvv,ddd)
{
if($.isNumeric(vvv))
{
$("#error_msg").html('');	
}
else
{
$("#error_msg").html('<div class="alert alert-error" style="color:red; font-weight:600; font-size:13px;">Amount Should be Numeric Value in row '+ ddd +'</div>');
$("#credit"+ ddd).val("");
return false;		
}

}










</script>

<script>
$(document).ready(function() {
$("#button_add").bind('click',function(){
var c=$("#main_table tbody tr").length;

c++;
$.ajax({
url: 'journal_add_row?con=' + c,
}).done(function(response) {
$('table#main_table tbody').append(response);
});
});

$(".delete_row").live('click',function(){
var id=$(this).attr("id");
$('#tr'+id).remove();
});
});
</script>	

<script>
function show_ledger_type(c1,t)
{
$(document).ready(function() {
$("#show_ledger_type" + t).load("show_ledger_type?c1=" +c1+ "&t=" +t+ "");
});
}
</script>
<script>
function total_amc(l)
{
var t_c = 0;
var count = $("#main_table tbody tr").length;
for(var k = 1; k<=count; k++)
{
var credit = document.getElementById('credit' + k).value;
if(credit == "")
{
credit = 0;
}
else
{
credit = eval(credit);
}
t_c = eval(t_c + credit);
}
document.getElementById('total_c').value = t_c;
}
</script>

<script>
function total_am(x)
{
var t_d = 0;
var count = $("#main_table tbody tr").length;
for(var j = 1; j<=count; j++)
{
var debit = document.getElementById('debit' + j).value;
if(debit == "")
{
debit = 0;
}
else
{
debit = eval(debit);
}
if(debit!=0)
{
t_d = eval(t_d + debit);
}
}
document.getElementById('total').value = t_d;
}
</script>

<script>
$(document).ready(function() {
	$('form').submit( function(ev){
		
	ev.preventDefault();
	$("#submit").addClass("disabled").text("submiting...");
		
		var hidden=$("#main_table tbody tr").length;
		
		var date = $("#date").val();
		
		var ar = [];
		for(var i=1;i<=hidden;i++)
		{
		var ledger = $("#main_table tbody tr:nth-child("+i+") td:nth-child(1) select").val();
		var debit = $("#main_table tbody tr:nth-child("+i+") td:nth-child(2) input").val();
		var credit = $("#main_table tbody tr:nth-child("+i+") td:nth-child(3) input").val();
		var desc = $("#desc1").val();
		
		ar.push([ledger,debit,credit,desc]);
		
		var myJsonString = JSON.stringify(ar);
		var date2 = JSON.stringify(date)
		}
		$('#test').show().html('<div id="submiting_div" style="position: absolute;top: 100;z-index: 99999;left: 45%;background-color: #FFE2E2;padding: 10px;"><div class="modal-backdrop fade in"></div><div class="modal" id="poll_edit_content"><div class="modal-body"><div align="center"><img src="<?php echo $webroot_path; ?>as/fb_loading.gif" style="height: 15px;" /><h4>Please Wait</h4></div></div></div></div>');
			$.ajax({
			url: "journal_validation?q="+myJsonString+"&b="+date2,
			dataType:'json',
			}).done(function(response) {
			
				$("#output").html(response);
				
				if(response.type == 'error'){  
				$('#test').hide();
					output = '<div class="alert alert-error" style="color:red; font-weight:600; font-size:13px;">'+response.text+'</div>';
					$("#submit").removeClass("disabled").text("submit");
					$("html, body").animate({
					 scrollTop:0
					 },"slow");
				     }
					
				if(response.type=='succ'){
				$('#test').hide();
				$('#succes_show').show();
				//$("#succ").html('<div class="alert alert-block alert-success fade in"><h4 class="alert-heading">Success!</h4><p>'+response.text+'</p><p><a class="btn green" href="<?php echo $webroot_path; ?>Bookkeepings/journal_view" rel="tab">OK</a></p></div>');
				$("html, body").animate({
					 scrollTop:0
					 },"slow");
			}
				
				$("#error_msg").html(output);
});
});
});
</script>



<div id="succes_show" class="hide">
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body">
<h4><b>Thank You!</b></h4>
The Journal Vouchers Genarated Successfully
</div>
<div class="modal-footer">
<a class="btn red" href="<?php echo $webroot_path; ?>Bookkeepings/journal_view" rel="tab">OK</a>
</div>
</div>
</div>


