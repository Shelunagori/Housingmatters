<a class="btn purple" id="back"><i class="icon-chevron-left"></i> All Events</a>

<?php
foreach($result_event_detail as $data)
{
$event_id=$data["event"]["event_id"];
$e_name=$data["event"]["e_name"];
$date_from=$data["event"]["date_from"];
$date_to=$data["event"]["date_to"];
$time_from=$data["event"]["time_from"];
$time_to=$data["event"]["time_to"];
$location=$data["event"]["location"];
$description=$data["event"]["description"];
}
?>

<div class="fadeleftsome" style="border:solid 2px #269abc;overflow: auto; width:90%; margin-left:5%;margin-top:5px;" >
	<div style="border-bottom:solid 2px #269abc; color:white; background-color: #39b3d7; padding:4px; font-size:20px;" >
	<?php echo $e_name; ?>
	</div>
	
	<div style="padding:3px;">
		<div class="pull-right">
		<span><b><?php echo $date_from; ?>&nbsp;&nbsp;-&nbsp;&nbsp;<?php echo $date_to; ?></b></span><br/>
		<span><b><?php echo $time_from; ?>&nbsp;&nbsp;-&nbsp;&nbsp;<?php echo $time_to; ?></b></span>
		</div>
		
		<div>
		<b>Location:</b><br/>
		<?php echo $location; ?>
		</div>
		<br/>
		<div >
		<b>Description:</b><br/>
		<?php echo $description; ?>
		</div>
		
		<div align="right">
		
		</div>
		
	</div>
	
	</div>