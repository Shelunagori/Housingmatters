
<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>

<div align="center">
<a href="events" class="btn red" rel='tab'>Table View</a>
<a href="events_calendar" class="btn blue" rel='tab'>Calendar View</a></div>

<div style="width:80%; margin-left:10%;margin-top:4px;">
<!-- BEGIN BORDERED TABLE PORTLET-->
<div class="portlet box" style="background-color:#44b6ae;">
	<div class="portlet-title">
		<h4><i class="icon-calendar" style="font-size:18px;"></i> All Events</h4>
	</div>
	<div class="portlet-body">
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th>Events Name</th>
					<th>Time</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
			<?php
			foreach($result_event as $data)
			{
			$event_id=$data["event"]["event_id"];
			$e_name=$data["event"]["e_name"];
			$e_name_cut=(strlen($e_name) > 47) ? substr($e_name,0,44).'...' : $e_name;
			$day_type=$data["event"]["day_type"];
			
			$date_from=$data["event"]["date_from"];
			$date_from = date('d-m-Y',$date_from->sec);
			
			$date_to=$data["event"]["date_to"];
			$date_to = date('d-m-Y',$date_to->sec);
			
			if($day_type==1) { $date_string="on ".$date_from; }
			if($day_type==2) { $date_string="from ".$date_from." to ".$date_to; }
			
			$location=$data["event"]["location"];
			$description=$data["event"]["description"];
			$description_cut=(strlen($description) > 100) ? substr($description,0,95).'.....' : $description;
			?>
				<tr>
					<td width="60%"><a href="#" role='button' class="hover_show"><?php echo $e_name_cut; ?></a></td>
					<td width="30%"><?php echo $date_string; ?></td>
					<td width="10%"><a href="event_info?e=<?php echo $event_id; ?>" rel='tab' class="btn mini" style="background-color:#44b6ae; color:#fff;">View</a></td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>
</div>
<!-- END BORDERED TABLE PORTLET-->
</div>

