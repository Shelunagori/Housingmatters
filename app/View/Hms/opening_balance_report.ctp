<center>
<h3><b>Opening balance Report</b></h3>
</center>
<a href="master_opening_balance" class="btn yellow">Opening Balance Entry</a>
<a href="opening_balance_report" class="btn purple">Opening Balance Report</a>
<br /><br />

<table border="0">
<tr>
<td>
<select name="year" class="m-wrap medium chosen" id="yr">
<option value="">Select Year</option>
<option value="2011-2012">2011-2012</option>
<option value="2012-2013">2012-2013</option>
<option value="2013-2014">2013-2014</option>
<option value="2014-2015">2014-2015</option>
</select>
</td>
<td>
<select name="le_ac" class="m-wrap medium chosen" id="le_ac">
<option value="">Select Ledger Account</option>
<?php 
foreach($cursor1 as $collection)
{
$auto_id1 = (int)$collection['ledger_account']['auto_id'];
$ledger_ac_name = $collection['ledger_account']['ledger_name'];	
?>
<option value="<?php echo $auto_id1; ?>"><?php echo $ledger_ac_name; ?></option>
<?php } ?>	 
</select>
</td>
<td id="result">

</td>
<td>
<button name="sub" class="btn yellow" id="go" style="margin-bottom:2px;">Search</button>
</td>
</tr>
</table>

<br><Br><br>
<center>
<div id="result2" style="width:60%;">


</div>
</center>
<script>
$(document).ready(function() {
	$("#le_ac").live('change',function(){
		
	var value1 = document.getElementById('le_ac').value;
	if(value1 == 15 || value1 == 33 || value1 == 34 || value1 == 35)
	{
	
	$("#result").html('Loding...').load("opening_balance_report_ajax?ff=" + value1 + "");
	
	}
	});
	
});
</script>



<script>
$(document).ready(function() {
	$("#go").live('click',function(){
		
var year = document.getElementById('yr').value;
var le_ac = document.getElementById('le_ac').value;	
if(le_ac == 15 || le_ac == 33 || le_ac == 34 || le_ac == 35)
{
var ls_ac = document.getElementById('subl').value;	
$("#result2").html('Loding...').load("opening_balance_show_ajax?year=" + year + "&ls_ac=" + ls_ac + "&le_ac=" + le_ac + "");
}
else
{
$("#result2").html('Loding...').load("opening_balance_show_ajax?year=" + year + "&le_ac=" + le_ac + "");
}

	
	
	
});
	
});
</script>






