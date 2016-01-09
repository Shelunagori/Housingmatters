<div class="hide_at_print">
<center>
<h3><b>My Flat</b></h3>
</center>

<a href="my_flat" class="btn purple">Flat Ledger</a>
<a href="my_flat_bill" class="btn yellow">Bill Detail</a>
<a href="my_flat_receipt" class="btn yellow">Bank Receipt</a>
</div>
<center>
<div id="validate_result"></div>
<div class="hide_at_print"> 
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
<button type="button" id="go" name="sub" class="btn yellow" style="margin-bottom:15%;">Search</button>
</td>
</tr>
</table>
<br />
</div>
</center>





<?php ///////////////////////////////////////////////////////////////////////////////////////////// ?>
<br /><br /><br />
<center>
<div id="result" style="width:96%;">
</div>
</center>  

<?php ///////////////////////////////////////////////////////////////////////////////////////////////  ?>


<script>
$(document).ready(function() {
	$("#go").live('click',function(){
		var date1=document.getElementById('date1').value;
		var date2=document.getElementById('date2').value;
		
		if((date1=='')) { alert('Please Input Date-from'); }
		if((date2=='')) { alert('Please Input Date-to'); }
		else
		{
		$("#result").html('<div align="center" style="padding:10px;"><img src="as/loding.gif" />Loading....</div>').load("my_flat_ajax?date1=" +date1+ "&date2=" +date2+ "");
		}
		
	});
	
});

</script>	



