<div class="hide_at_print">
<center>
<h3><b>Bill Detail</b></h3>
</center>
<!-- <a href="my_flat" class="btn yellow">Flat Ledger</a> -->
<a href="my_flat_bill" class="btn yellow">Bill Detail</a>
<a href="my_flat_receipt" class="btn purple">Bank Receipt</a>
</div>
<!--<div class="hide_at_print">
<span style="margin-left:80%;">
<button type="button" class=" printt btn green" onclick="window.print()"><i class="icon-print"></i> Print</button>
</span>
</div>-->
<center>
<br />

<table border="0">
<tr>
<td>
 <input type="text" placeholder="From Date" id="date1" style="height:77%; background-color:white !important;" class="date-picker m-wrap medium" data-date-format="dd-mm-yyyy" name="from">
</td>
<td>
<input type="text" placeholder="To Date" id="date2" style="height:77%; background-color:white !important;" class="date-picker m-wrap medium" data-date-format="dd-mm-yyyy" name="to">
</td>
<td>
<button type="button" id="go" name="sub" class="btn yellow" style="margin-bottom:10px;">Go</button>
</td>
</tr>
</table>
</center>
<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<center>
<div style="width:94%;" id="result">

</div>
</center>
<?php ///////////////////////////////////////////////////////////////////////////////////////////////////// ?>

<script>
$(document).ready(function() {
	$("#go").live('click',function(){
		var date1=document.getElementById('date1').value;
		var date2=document.getElementById('date2').value;
		
		if((date1=='')) { alert('Please Input Date-from'); }
		if((date2=='')) { alert('Please Input Date-to'); }
		else
		{
		$("#result").html('<div align="center" style="padding:10px;"><img src="as/loding.gif" />Loading....</div>').load("my_flat_receipt_show?date1=" +date1+ "&date2=" +date2+ "");
		}
		
	});
	
});

</script>	