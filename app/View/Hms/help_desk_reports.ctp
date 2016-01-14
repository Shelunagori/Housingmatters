<style><link href="<?php echo $webroot_path; ?>as/bootstrap.icon-large.css" rel="stylesheet" />
<link href="<?php echo $webroot_path; ?>as/bootstrap.icon-large.min.css" rel="stylesheet" /></style>

<table width="100%" >
<tr >
<td width="30%" valign="top" >
<b><i class="icon-headphones" style=''></i> Help-Desk Reports</b>

<div> <a href="#" role='button' id="report1">Tickets received in time period.</a></div>
<div> <a href="#" role='button' id="report2">Average duration of ticket resolution.</a></div>
<div> <a href="#" role='button' id="report3">Maximum and minimum Tickets received from which members.</a></div>
<b>  <i class="icon-bar-chart"></i>  Monthwise Graph </b>
<div> <a href="#" role='button' id="report4">Graphical representation of ticket.</a></div>

<b><i class="icon-sitemap"></i>  Type of Complaints </b>
<div>  <a href="complaint_closed_report" target="_blank">All Closed Complaints </a> </div>
<div><a href="complaint_open_report" target="_blank"> All Open Complaints </a> </div>
<b><i class="icon-cloud"></i>  Vendor Performance </b>

<div><a href="sp_performance_report" target="_blank">Vendor Performance Report</a></div>
<b> <i class="icon-group"></i> Contact Reports </b>
<div>  <a href="contact_report" target="_blank"> Contact Report </a> </div>
</div>

<div style="padding:2px;">


<b> <i class="icon-user-md"></i> Login Reports </b>
<div>  <a href="login_report_user" target="_blank">Login reports for users </a> </div>
<b> <i class="icon-user-md"></i> Profile Reports </b>
<div>  <a href="profile_report" target="_blank">Profile reports for users </a> </div>
</div>

<!--<strong>Help-Desk Graphical Reports</strong>-->


<td>
<td width="65%" valign="top">
<div id="report_div1" style="display:none;">
<h4>How many Tickets received in particular period.</h4>
	<table>
		<tbody><tr>
		<td><input type="text" class="date-picker m-wrap medium" id="from_date_1" data-date-format="dd-mm-yyyy" name="from" placeholder="From" style="background-color:white !important;" value=""></td>
		<td><input type="text" class="date-picker m-wrap medium" id="to_date_1" data-date-format="dd-mm-yyyy" name="to" placeholder="To" style="background-color:white !important;" value=""></td>
		<td valign="top"><button type="button" name="sub" class="btn yellow" onclick="get_report1()">Go</button></td>
		</tr>
		</tbody>
	</table>
	<div id="result_report_1"></div>
</div>
<div id="report_div2" style="display:none;">
<h4>Average duration of complaint resolution.</h4>
	<table>
		<tbody><tr>
		<td><input type="text" class="date-picker m-wrap medium" id="from_date_2" data-date-format="dd-mm-yyyy" name="from" placeholder="From" style="background-color:white !important;" value=""></td>
		<td><input type="text" class="date-picker m-wrap medium" id="to_date_2" data-date-format="dd-mm-yyyy" name="to" placeholder="To" style="background-color:white !important;" value=""></td>
		<td valign="top"><button type="button" name="sub" class="btn yellow" onclick="get_report2()">Go</button></td>
		</tr>
		</tbody>
	</table>
	<div id="result_report_2"></div>
</div>
<div id="report_div3" style="display:none;">
<h4>Maximum and minimum Tickets received from which members.</h4>
	<table>
		<tbody><tr>
		<td><input type="text" class="date-picker m-wrap medium" id="from_date_3" data-date-format="dd-mm-yyyy" name="from" placeholder="From" style="background-color:white !important;" value=""></td>
		<td><input type="text" class="date-picker m-wrap medium" id="to_date_3" data-date-format="dd-mm-yyyy" name="to" placeholder="To" style="background-color:white !important;" value=""></td>
		<td valign="top"><button type="button" name="sub" class="btn yellow" onclick="get_report3()">Go</button></td>
		</tr>
		</tbody>
	</table>
	<div id="result_report_3"></div>
</div>
<div id="report_div4" style="display:none;">
<h4></h4>
	<table>
		<tbody><tr>
		<td><input type="text" class="date-picker m-wrap medium" id="from_date_4" data-date-format="dd-mm-yyyy" name="from" placeholder="From" style="background-color:white !important;" value=""></td>
		<td><input type="text" class="date-picker m-wrap medium" id="to_date_4" data-date-format="dd-mm-yyyy" name="to" placeholder="To" style="background-color:white !important;" value=""></td>
		<td valign="top"><button type="button" name="sub" class="btn yellow" onclick="get_report4()">Go</button></td>
		</tr>
		</tbody>
	</table>
	<div id="result_report_4"></div>
</div>
</td>
</table>


<div>
<div>
<br/>

<!--<div style="padding:2px;">
<br/>
<b>Complaints Reports </b>
<div> 1. <a href="complaint_closed_report" style="text-decoration:none;">All Closed Complaints </a> </div>
<div> 2. <a href="complaint_open_report" style="text-decoration:none;"> All Open Complaints </a> </div>

</div>-->


<!--<div style="padding:2px;">
<br/>
<b>Service Provider Performance Report  </b>
<div> 1. <a href="sp_performance_report" style="text-decoration:none;">Service Provider Performance </a></div>
</div>-->

</div>
</div>


<script>
$(document).ready(function() { 
	 $("#report1").live('click',function(){
		$("#report_div1").show();
		$("#report_div2").hide();
		$("#report_div3").hide();
		$("#report_div4").hide();
	 });
	 
	 $("#report2").live('click',function(){
		$("#report_div1").hide();
		$("#report_div2").show();
		$("#report_div3").hide();
		$("#report_div4").hide();
	 });
	 
	 $("#report3").live('click',function(){
		$("#report_div1").hide();
		$("#report_div2").hide();
		$("#report_div3").show();
		$("#report_div4").hide();
	 });
	 
	 $("#report4").live('click',function(){
		$("#report_div1").hide();
		$("#report_div2").hide();
		$("#report_div3").hide();
		$("#report_div4").show();
	 });
});

function get_report1()
{
$(document).ready(function() { 
	var d1=encodeURIComponent($("#from_date_1").val());
	var d2=encodeURIComponent($("#to_date_1").val());
	
	$("#result_report_1").html('Loading...').load('help_desk_report_1?d1='+d1+'&d2='+d2);
});
}

function get_report2()
{
$(document).ready(function() { 
	var d1=encodeURIComponent($("#from_date_2").val());
	var d2=encodeURIComponent($("#to_date_2").val());
	
	$("#result_report_2").html('Loading...').load('help_desk_report_2?d1='+d1+'&d2='+d2);
});
}

function get_report3()
{
$(document).ready(function() { 
	var d1=encodeURIComponent($("#from_date_3").val());
	var d2=encodeURIComponent($("#to_date_3").val());
	
	$("#result_report_3").html('Loading...').load('help_desk_report_3?d1='+d1+'&d2='+d2);
});
}

function get_report4()
{
$(document).ready(function() { 
	var d1=encodeURIComponent($("#from_date_4").val());
	var d2=encodeURIComponent($("#to_date_4").val());
	
	$("#result_report_4").html('Loading...').load('help_desk_report_4?d1='+d1+'&d2='+d2);
});
}
</script>




