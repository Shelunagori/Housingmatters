
<center>
<h3><b>Master Opening balance</b></h3>
</center>
<a href="master_opening_balance" class="btn purple">Opening Balance Entry</a>
<a href="opening_balance_report" class="btn yellow">Opening Balance Report</a>
<br /><br />
<center>
		<div class="portlet box grey" style="width:60%; margin-left:1%; margin-right:1%;">
		<div class="portlet-title">
		<h4><i class="icon-reorder"></i>Master Opening Balance</h4>
		</div>
		<div class="portlet-body form" style="background-color:rgb(245, 245, 209);">
         <form method="post" >
		 <table border="0">
        <tr>
        <td>
		<input type="text" name="year" class="m-wrap medium" style="background-color:white !important;" placeholder="Year">
		</td>
		</tr>
        <tr>
		<td>
		<select name="le_ac" class="m-wrap medium chosen" id="go">
		<option value="">Select Ledger Account</option>
		<?php
		foreach($cursor1 as $collection)
		{
		$auto_id = (int)$collection['ledger_account']['auto_id'];
		$ac_name = $collection['ledger_account']['ledger_name'];
		?>
		<option value="<?php echo $auto_id; ?>"><?php echo $ac_name; ?></option>
		<?php } ?>
		</select>
		</td>
		</tr>
        <tr>
		<td id="result">
		<select class="m-wrap medium">
		<option value="">Select Subledger</option>
		</select>
		</td>
		</tr>
        <tr>
		<td>
		<input type="text" name="balance" class="m-wrap medium" style="background-color:white !important;" placeholder="Opening Balance">
		</td>
		</tr>

        </table>
		
		
		
		
		
		
	<br><br>	
		
<div class="form-actions" style="background-color:#CCC;">
<button type="submit" class="btn green" name="sub">Submit</button>
</div>
		
</form>		
		
		
		</div>
		</div>
		</center>





	<script>
		$(document).ready(function() {
		$("#go").live('change',function(){

		var value1 = document.getElementById('go').value;
		//var date2=document.getElementById('date2').value;


		$("#result").load("opening_balance_ajax?value1=" +value1 + "");


		});

		

		});
		</script>	  







