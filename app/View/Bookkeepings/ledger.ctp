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
		
<!-------------------------------Start Ledger Form ------------------------------------------------->
<?php  
$default_date_from = date('1-m-Y'); 
$default_date_to = date('d-m-Y')
?> 
<center>
<form method="post" onSubmit="return valid()">
<div  class="hide_at_print">
        <table style="width:60%;">
        <tr>
        
				<td>
						<select class="medium m-wrap chosen" id="ledger_account">
						<option value="" style="display:none;">Select Ledger A/c</option>
						<?php
							 foreach ($cursor1 as $collection) 
							 {
							   $auto_id = (int)$collection['ledger_account']['auto_id'];
							   $name = $collection['ledger_account']['ledger_name'];
						?>
						<option value="<?php echo $auto_id; ?>"><?php echo $name; ?></option>
						<?php } ?>
						</select>
				</td>
		
		
				<td id="sub_ledger_ajax_view">
						<select class="medium m-wrap" tabindex="1" name="user_name" id="sub_id" style="margin-top:7px;">
						<option value="0">Select Sub Ledger A/c</option>
						</select>
				</td>

				<td>
					<input type="text" placeholder="From Date" id="date1" class="date-picker medium m-wrap" data-date-format="dd-mm-yyyy" name="from" style="background-color:white !important; margin-top:7px;" value="<?php echo $default_date_from; ?>">
				</td>

				<td>
				<input type="text" placeholder="To Date" id="date2" class="date-picker medium m-wrap" data-date-format="dd-mm-yyyy" name="to" style="background-color:white !important; margin-top:7px;" value="<?php echo $default_date_to; ?>">
				</td>
		
				<td valign="top">
				<button type="button" id="go" name="sub" class="btn yellow" style="margin-top:7px;">Search</button>
				</td>
		</tr>
</table>
</div>
</form>
</center>
		
<div id="ledger_view" style="width:100%;">
</div>
<!-----------------------------------End Ledger Form ------------------------------------------>
 		
<!------------------------------------ Start Java Script --------------------------------->
<script>
$(document).ready(function(){
	
	    $("#ledger_account").bind('change',function(){
		  var ledger_account_id = $('#ledger_account').val();
		  $("#sub_ledger_ajax_view").html('loading...');
		  $("#sub_ledger_ajax_view").load("ledger_ajax?ledger_account_id=" +ledger_account_id+ "");
	    });
	
});
</script>			
		
<script>
$(document).ready(function() {
	
	    $("#go").bind('click',function(){
			var ledger_account_id = $('#ledger_account').val();
		
		if(ledger_account_id==15 ||  ledger_account_id==33 || ledger_account_id==35 || ledger_account_id == 112){
			var sub_ledger_id = $("#sub_id").val();
		    }else if(ledger_account_id==34){
		    var sub_ledger_id = $('.resident_drop_down').val();
			}else{
			var sub_ledger_id = null;
		    }
			
		var date1=$('#date1').val();
		var date2=$('#date2').val();
		$("#ledger_view").html('<div align="center" style="padding:10px;"><img src="<?php echo $webroot_path; ?>as/loding.gif" />Loading....</div>').load("ledger_show_ajax?date1=" +date1+ "&date2=" +date2+ "&ledger_id=" +ledger_account_id+ "&subledger_id=" +sub_ledger_id+"");
	});
});
</script>			

<!------------------------------------End Java Script Code------------------------------------->