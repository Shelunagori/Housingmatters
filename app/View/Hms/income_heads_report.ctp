<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>		
<div class="hide_at_print">
		<table width="100%" border="1" bordercolor="#FFFFFF" cellpadding="0">
		<tr>
		<td style="width:25%">
		<a href="it_regular_bill" class="btn blue btn-block"   style="font-size:16px;"> Regular Bill</a>
		</td>
		<td style="width:25%">
		<a href="it_supplimentry_bill" class="btn blue btn-block"  style="font-size:16px;">Supplementary Bill</a>
		</td>
		<td style="width:25%">
		<a href="in_head_report" class="btn red btn-block"  style="font-size:16px;">Reports</a>
		</td>
		<td style="width:25%">
		<a href="select_income_heads" class="btn blue btn-block"  style="font-size:16px;">Accounting Setup</a>
		</td>
		</tr>
		</table>
</div>
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>		

<div style="text-align:center;" class="hide_at_print">
<a href="in_head_report" class="btn">bill Report</a>
<a href="it_reports_regular" class="btn">Regular</a>
<a href="it_reports_supplimentry" class="btn">Supplementary</a>
<a href="income_heads_report" class="btn yellow">Income head report</a>
</div>

<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>

<div style=" margin-top:5px;" align="center" class="hide_at_print">
<table  >
<tr>
<td><input type="text" class="span12 m-wrap date-picker" style="background-color:#FFF !important;" placeholder="From" id="date1" data-date-format="dd-mm-yyyy"></td>
<td><input type="text" class="span12 m-wrap date-picker" style="background-color:#FFF !important;" placeholder="To" id="date2" data-date-format="dd-mm-yyyy"></td>
<td valign="top"><button type="button" class="btn yellow" id="go">Go</button></td>
</tr>
</table>
</div>      
	
<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>	
		<center>
		<div id="result">
		</div>
        </center>   								
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>

<script>
$(document).ready(function() {
	$("#go").live('click',function(){
		var date1=document.getElementById('date1').value;
		var date2=document.getElementById('date2').value;
		
		if((date1=='')) { alert('Please Input Date-from'); }
		if((date2=='')) { alert('Please Input Date-to'); }
		else
		{
		$("#result").html('<div align="center" style="padding:10px;"><img src="as/loding.gif" />Loding....</div>').load("income_heads_report_ajax?date1=" +date1+ "&date2=" +date2+ "");
		}
		
	});
	
});
</script>								
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									