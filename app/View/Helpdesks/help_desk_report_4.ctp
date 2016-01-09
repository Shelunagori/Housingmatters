<?php 
function check_in_range($d1, $d2, $help_desk_date)
	{
	  // Convert to timestamp
	  $d1 = strtotime($d1);
	  $d2 = strtotime($d2);
	  $help_desk_date = strtotime($help_desk_date);

	  // Check that user date is between start & end
	  return (($help_desk_date >= $d1) && ($help_desk_date <= $d2));
	}
	
foreach ($result_help_desk_report1 as $collection) 
{
$help_desk_date=$collection['help_desk']['help_desk_date'];
$help_desk_date=date("Y-m-d",strtotime(date("d-m-y",strtotime($help_desk_date))));
	
	if(check_in_range($d1, $d2, $help_desk_date)==1)
	{
	$help_desk_result[]=$collection['help_desk'];
	}
}


$open=0;
$open_and_assigned=0;
$closed=0;
if(sizeof($help_desk_result)==0){$help_desk_result=array();};
foreach ($help_desk_result as $data) 
{
if($data['help_desk_status']==0 && $data['help_desk_service_provider_id']==0) { $open++;}
if($data['help_desk_status']==0 && $data['help_desk_service_provider_id']!=0) { $open_and_assigned++;}
if($data['help_desk_status']==1) { $closed++;}
}

@$open_per=($open*100)/sizeof($help_desk_result);
@$open_and_assigned_per=($open_and_assigned*100)/sizeof($help_desk_result);
@$closed_per=($closed*100)/sizeof($help_desk_result);
?>

<div style="background-color:#fff;padding:20px; width: 62%;">
<div id="canvas-holder">
			<canvas id="chart-area" width="200" height="200"/>
</div>
<!--<div class="pull-right" style="margin-top: -100px;margin-right: 100px;">
<span class="label" style="background-color:#d43f3a"><?php echo $open; ?></span> Open Tickets<br/>
<span class="label" style="background-color:#eea236"><?php echo $open_and_assigned; ?></span> Open and assigned Tickets<br/>
<span class="label" style="background-color:#4cae4c"><?php echo $closed; ?></span> Closed Tickets<br/>
</div>-->
</div>

<script src="<?php echo $this->webroot ; ?>/as/charts/Chart.js"></script>
<script>
	var pieData = [
			{
				value: <?php echo $open; ?>,
				color:"#d43f3a",
				highlight: "#d43f3a",
				label: "Open Tickets"
			},
			{
				value: <?php echo $open_and_assigned; ?>,
				color: "#eea236",
				highlight: "#eea236",
				label: "Open & assigned Tickets"
			},
			{
				value:<?php echo $closed; ?>,
				color: "#4cae4c",
				highlight: "#4cae4c",
				label: "Closed Tickets"
			}

		];

		
			var ctx = document.getElementById("chart-area").getContext("2d");
			window.myPie = new Chart(ctx).Pie(pieData);
		
</script>