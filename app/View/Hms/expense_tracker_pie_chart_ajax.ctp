<?php
$m_from = date("Y-m-d", strtotime($date1));
$m_from = new MongoDate(strtotime($m_from));

$m_to = date("Y-m-d", strtotime($date2));
$m_to = new MongoDate(strtotime($m_to));


$administrative_expenses = 0;
$repairs_maintenance = 0;
$tax_utilities = 0;
foreach($cursor1 as $collection)
{
$posting_date = $collection['expense_tracker']['posting_date'];
$amount = $collection['expense_tracker']['amount'];
$ac_id = (int)$collection['expense_tracker']['expense_head'];
if($posting_date >= $m_from && $posting_date <= $m_to)
{
$result = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_account_fetch2'),array('pass'=>array($ac_id)));
foreach($result as $collection)
{
$group_id = (int)$collection['ledger_account']['group_id'];	
}
if($group_id == 9)
{
$tax_utilities = $tax_utilities + $amount;
}
else if($group_id == 10)
{
$repairs_maintenance = $repairs_maintenance + $amount;	
}
else if($group_id == 11)
{
$administrative_expenses = $administrative_expenses + $amount;	 	
}
}
}

?>
<div style="width:80%; border:solid 1px; overflow:auto;">
<div id="canvas-holder" style="float:left; margin-left:10%;">
			<canvas id="chart-area" width="300" height="300"/>
</div>
<div style="float:right; border:solid; background-color:#CCC; margin-top:10%; margin-right:10%;">
<table class="table">
<tr>
<td>
<span class="label" style="background-color:#d43f3a;"><?php echo $administrative_expenses; ?></span>
</td>
<td>
Administrative Expenses
</td>
</tr>
<tr>
<td>
<span class="label" style="background-color:#eea236;"><?php echo $repairs_maintenance; ?></span>
</td>
<td>
Repairs & Maintenance
</td>
</tr>
<tr>
<td>
<span class="label" style="background-color:#4cae4c;"><?php echo $tax_utilities; ?></span>
</td>
<td>
Tax & Utilities
</td>
</tr>
</table>
</div>
</div>


<script src="<?php echo $this->webroot ; ?>/as/charts/Chart.js"></script>
<script>
	var pieData = [
			{
				value: <?php echo $administrative_expenses; ?>,
				color:"#d43f3a",
				highlight: "#d43f3a",
				label: "Administrative Expenses"
			},
			{
				value: <?php echo $repairs_maintenance; ?>,
				color: "#eea236",
				highlight: "#eea236",
				label: "Repairs & Maintenance"
			},
			{
				value: <?php echo $tax_utilities; ?>,
				color: "#4cae4c",
				highlight: "#4cae4c",
				label: "Tax & Utilities"
			}

		];

		
			var ctx = document.getElementById("chart-area").getContext("2d");
			window.myPie = new Chart(ctx).Pie(pieData);
		
</script>











