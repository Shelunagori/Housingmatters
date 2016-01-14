<a class="btn purple" id="back"><i class="icon-chevron-left"></i> All Events</a>
<div class="row-fluid">


<!-------------PIE------------------------->
<div class="span6">
	<!-- BEGIN PORTLET-->
	<div class="portlet solid bordered" style="background-color:#fff;overflow: auto;">
		<!-------HEADER----------->
		<div style="border-bottom: 1px solid #eee;">
			<div style="margin-bottom: 10px;margin-top: 10px;">
			<span style="color:#4884b8;font-size: 16px;font-weight: bold;"><i class=" icon-tags"></i> HELP-DESK TICKETS ANALYSIS</span>
			</div>
		</div>
		<!-------HEADER END----------->
		<div class="portlet-body">
		<!-------CONTENT--------->
		<div >
		
		<div id="canvas-holder">
			<canvas id="chart-area" width="300" height="200" />
		</div>
		<div class="pull-right">
		<span class="badge" style="background-color:#d9534f;width:20px;">300</span> Open Tickets (even not assigned)<br/>
		<span class="badge" style="background-color:#f0ad4e;width:20px;">120</span> Open and Assigned Tickets<br/>
		<span class="badge" style="background-color:#5cb85c;width:20px;">80</span> Closed Tickets<br/>
		<span style="color:#46b8da;font-size:16px;">Total tickets : 500</span>
		</div>
		</div>
		<!-------CONTENT END--------->
		</div>
	</div>
	<!-- END PORTLET-->
</div>
<!-------------EVENTS PIE------------------------->
</div>




<script src="<?php echo $this->webroot ; ?>/as/charts/Chart.js"></script>
<script>
var pieData = [
				{
					value: 300,
					color: "#d9534f",
					highlight: "#d43f3a",
					label: "Open Tickets (even not assigned)"
				},
				{
					value: 120,
					color: "#f0ad4e",
					highlight: "#eea236",
					label: "Open and Assigned Tickets"
				},
				{
					value: 80,
					color:"#5cb85c",
					highlight: "#4cae4c",
					label: "Closed Tickets"
				}

			];

var ctx2 = document.getElementById("chart-area").getContext("2d");
				window.myPie = new Chart(ctx2).Pie(pieData);



</script>