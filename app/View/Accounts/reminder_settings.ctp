<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>				   
<script>
$(document).ready(function() {
$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script> 
 

<form method="post" id="contact-form">
<div class="portlet box blue">
<div class="portlet-title">
<h4 class="block"><i class="icon-reorder"></i>Fixed Deposite Set Reminder</h4>
<div class="tools">
<a href="javascript:;" class="collapse"></a>
<a href="#portlet-config" data-toggle="modal" class="config"></a>
<a href="javascript:;" class="reload"></a>
<a href="javascript:;" class="remove"></a>
</div>
</div>
<div class="portlet-body form">

<div style="background-color:#FFF; width:48%; float:left;">
<label style="font-size:14px; margin-left:2%;">Reminder For</label>
<div class="controls" style="margin-left:2%;">
<select class="m-wrap span8 chosen" style="margin-left:2%;" name="ffrr" id="gg">
<option value="" style="display:none;">Select</option>
<option value="1">Income Tracker</option>
<option value="2">Fixed Deposit</option>
<option value="3">Helpdesk</option>
</select>
<label id="gg"></label>
</div>
<br />


<label style="font-size:14px; margin-left:2%;">Reminder Days</label>
<div class="controls" style="margin-left:2%;">
<input type="text" name="days" class="m-wrap span8" id="hh"/>
<label id="hh"></label>
</div>
<br />






</div>
<?php 

foreach($cursor2 as $dataa)
{
$arrr = @$dataa['society']['reminder'];

for($i=0; $i<sizeof($arrr); $i++)
{
$sub_arr = $arrr[$i];	
$iddd = (int)$sub_arr[0];
	if($iddd == 1)
	{
	 $idays1 = $sub_arr[1];	
	}
	if($iddd == 2)
	{
	 $fdays2 = $sub_arr[1];		
	}
	if($iddd == 3)
	{
	 $fdays3 = $sub_arr[1];		
	}
}




}


?>
<div style="background-color:#FFF; width:50%; float:right;">
<table class="table table-bordered">
<tr>
<th>Module Name</th>
<th>Number of Days</th>
</tr>
<tr>
<td>Income Tracker</td>
<td><?php echo @$idays1; ?></td>
</tr>
<tr>
<td>Fixed Deposit</td>
<td><?php echo @$fdays2; ?></td>
</tr>

<tr>
<td>Helpdesk</td>
<td><?php echo @$fdays3; ?></td>
</tr>
</table>



</div>

<br /><br>

<div class="form-actions" style="overflow:auto; width:100%;">
<button type="submit" name="sub" class="btn green" style="margin-left:2%;">Submit</button>                             
</div>


</div>
</div>
</form>


<script>
$(document).ready(function() {
<?php	
$status5=(int)$this->Session->read('remindrrr');
if($status5==1)
{
?>
$.gritter.add({
title: 'Reminder',
text: '<p>Thank you.</p><p>Reminder added successfully.</p>',
sticky: false,
time: '10000',
});
<?php
$this->requestAction(array('controller' => 'hms', 'action' => 'griter_notification'), array('pass' => array(3103)));
} ?>
});
</script> 

<script>
$(document).ready(function(){
	
	 jQuery.validator.addMethod("notEqual", function(value, element, param) {
  return this.optional(element) || value !== param;
}, "Please choose Other value!");
	
//$.validator.setDefaults({ ignore: ":hidden:not()" });

$('#contact-form').validate({
ignore: ".ignore",

errorElement: "label",
//place all errors in a <div id="errors"> element
errorPlacement: function(error, element) {
//error.appendTo("label#errors");
error.appendTo('label#' + element.attr('id'));
},
					
	    rules: {
			
			ffrr:{
				required: true
			},
		  
				
			days : {
			required: true,
			number: true,
			notEqual: "0"
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