<?php ///////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<center>
<h3><b>Expense Tracker Pie Charts</b>
</center>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////?>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////?>

<center>
<a href="expense_tracker_add" class="btn blue">Add</a>
<!-- <a href="expense_tracker_edit" class="btn blue">Edit</a> -->
<a href="expense_tracker_view" class="btn blue">View</a>
<a href="expense_tracker_pie_chart" class="btn red">Pie Chart</a>
</center>	
<?php ///////////////////////////////////////////////////////////////////////////////////////////////////// ?>

 <center>
            <div style="width:50%; background-color:#FAE7F4;" class="hide_at_print">
            <form method="post" id="contact-form">
            <br>
            <table>
            <tbody><tr>
           
            <td><input type="text" id="date1" class="date-picker m-wrap medium" data-date-format="dd-mm-yyyy" name="from" placeholder="From" style="background-color:white !important;"></td>
           
            <td><input type="text" id="date2" class="date-picker m-wrap medium" data-date-format="dd-mm-yyyy" name="to" placeholder="To" style="background-color:white !important;"></td>
            <td valign="top"><button type="button" name="sub" class="btn yellow" id="go">Go</button></td>
            </tr>
            </tbody></table>
            </br>
            </form>
            </div>
</center>

<?php ///////////////////////////////////////////////////////////////////////////////////////////////////// ?>

<center>
<div id="result" style="width:96%;">
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
		$("#result").html('<div align="center" style="padding:10px;"><img src="as/loding.gif" />Loading....</div>').load("expense_tracker_pie_chart_ajax?date1=" +date1+ "&date2=" +date2+ "");
		}
		
	});
	
});
</script>	




