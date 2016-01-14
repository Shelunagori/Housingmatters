<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<center>
<h3><b>Trial Balance</b></h3>
</center>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////// //?>

<div class="hide_at_print">
<div id="validate_result"></div>
<center>
		<select class="medium m-wrap" tabindex="1" id="wise">
		<option value="">--SELECT--</option>
		<option value="1">Sundry Creditors Control A/c</option>
		<option value="2">Sundry Debtors Control A/c</option>
		<option value="4">Bank Accounts</option>
		<option value="3">All</option>
		</select>
</center>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>

<?php
$c_date = date('d-m-Y');
$b_date = date('1-m-Y');
?> 



		<center>
		<div>
		<form method="post">
		<br>
		<table>
		<tbody><tr>
		<td><input type="text" id="date1" class="date-picker m-wrap medium" data-date-format="dd-mm-yyyy" name="from" placeholder="From" style="background-color:white !important;" value="<?php echo $b_date; ?>"></td>
		<td><input type="text" id="date2" class="date-picker m-wrap medium" data-date-format="dd-mm-yyyy" name="to" placeholder="To" style="background-color:white !important;" value="<?php echo $c_date; ?>"></td>
		<td valign="top"><button type="button" name="sub" class="btn yellow" id="go">Go</button></td>
		</tr>
		</tbody></table>
		<br>
		</form>
		</div>
        </div>
		</center>

<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
    <center>
    <div id="result" style="width:94%;">
    </div>
    </center>
<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>

<script>
$(document).ready(function() {
	$("#go").live('click',function(){
		var date1=document.getElementById('date1').value;
		var date2=document.getElementById('date2').value;
		var wise=document.getElementById('wise').value;
		if(wise=== '') { $('#validate_result').html('<div style="background-color:#f2dede; color:#b94a48; padding:5px;">Please Select an Option</div>'); return false; }
		
		
		
		if((date1=='')) { alert('Please Input Date-from'); }
		if((date2=='')) { alert('Please Input Date-to'); }
		else
		{
		$("#result").html('<div align="center" style="padding:10px;"><img src="as/loding.gif" />Loading....</div>').load("trial_balance_ajax_show?date1=" +date1+ "&date2=" +date2+ "&wise=" +wise+ "");
		}
		
	});
	
});
</script>	





































