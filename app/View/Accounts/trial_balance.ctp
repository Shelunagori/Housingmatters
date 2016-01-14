<?php
$default_from = date('1-m-Y');
$default_to = date('d-m-Y');
?>


<div class="hide_at_print">	
<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>				   
<script>
$(document).ready(function() {
$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>
</div>

<div align="center">
	<select class="m-wrap chosen" id="wise"> 
		<option value="" style="display:none;">Select Option</option>
		<option value="1">Sundry Creditors Control A/c</option>
		<option value="2">Members Control Accounts</option>
		<option value="3">Bank Accounts</option>
		<option value="4">Detailed trial balance (w/o subledgers)</option>
		<option value="5">Detailed trial balance (with subledger)</option>
		<option value="6">Sundry Debtors Control A/c</option>
	</select> 
	<input type="text" id="from" class="date-picker m-wrap medium" data-date-format="dd-mm-yyyy" name="from" placeholder="From"  value="<?php echo $default_from; ?>" style="background-color:#FFF !important;">
	<input type="text" id="to" class="date-picker m-wrap medium" data-date-format="dd-mm-yyyy" name="to" placeholder="To"  value="<?php echo $default_to; ?>" style="background-color:#FFF !important;">
	<a href="#" style="margin-bottom: 35px;" role="button" class="btn blue icn-only" id="go"><i class="m-icon-swapright m-icon-white"></i></a>
</div>


<div id="result"></div>



<script>
$(document).ready(function() {
	$("#go").bind('click',function(){
		var wise=document.getElementById('wise').value;
		var from=document.getElementById('from').value;
		var to=document.getElementById('to').value;
		if(wise==4){
		$("#result").html('<div align="center" style="padding:10px;"><img src="<?php echo $webroot_path; ?>as/loding.gif" />Loading....</div>').load("trial_balance_ajax_show/"+from+"/"+to+"/"+wise);
		}
		else if(wise==5){
		$("#result").html('<div align="center" style="padding:10px;"><img src="<?php echo $webroot_path; ?>as/loding.gif" />Loading....</div>').load("trial_balance_ajax_show_with_sub_ledger/"+from+"/"+to+"/"+wise);	
			
		}
		else{
			$("#result").html('<div align="center" style="padding:10px;"><img src="<?php echo $webroot_path; ?>as/loding.gif" />Loading....</div>').load("trial_balance_ajax_show_sub_ledger/"+from+"/"+to+"/"+wise);
		}
	});
});
</script>	