<div style="float:right;">
<a class="btn blue hide_at_print"  onclick="window.print();" >Print </a>
</div>
<br/>
<br/>

<div style="background-color:#EFEFEF; border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6; padding:10px; box-shadow:5px; font-size:16px; color:#006;"><i class="icon-sitemap"></i>
             Complaint Open Reports 
</div>


<div class="tab-content">

<div class="tab-pane active" id="tab_1_2">


<div class="portlet box ">

<div class="portlet-body">
<table class="table table-striped table-bordered" id="">
<thead>
<tr>
<th>Sr No.</th>
<th>Date</th>
<th>Time</th>
<th>Ticket No.</th>
<th>Priority</th>
<th>Raised by</th>
<th>Flat</th>
<th>Category</th>

</tr>
</thead>
<tbody>

<?php
$i=0;
foreach($result_help_desk as $collection)
{
$i++;

$help_desk_id=$collection['help_desk']['help_desk_id'];
		$date=$collection['help_desk']['help_desk_date'];
	    $time=$collection['help_desk']['help_desk_time'];
		$ticket_id=$collection['help_desk']['ticket_id'];
		$complain_type_id=(int)$collection['help_desk']['help_desk_complain_type_id'];
		$d_user_id=(int)$collection['help_desk']['user_id'];
		$help_desk_status=(int)$collection['help_desk']['help_desk_status'];
		$ticket_priority=(int)$collection['help_desk']['ticket_priority'];
		if($ticket_priority==1)
		{
			$ticket_priority="Urgent";
		}
		else
		{
			$ticket_priority="Normal";
		}
	$result_user = $this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'),array('pass'=>array($d_user_id)));
	foreach ($result_user as $collection) 
	{
		$name=$collection['user']['user_name'];
		$wing=$collection['user']['wing'];
		$flat=$collection['user']['flat'];
}
$flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'),array('pass'=>array($wing,$flat)));

$help_desk_category_name = $this->requestAction(array('controller' => 'hms', 'action' => 'help_desk_category_name'),array('pass'=>array($complain_type_id)));
	
 
?>
<tr class="odd gradeX" >
				<td><?php echo $i; ?></td>
				<td><?php echo $date; ?></td>
				<td><?php echo $time; ?></td>
				<td><?php echo $ticket_id; ?></td>
				<td><?php echo $ticket_priority; ?></td>
				<td><?php echo $name; ?></td>
				<td><?php echo $flat ?></td>
				<td><?php echo $help_desk_category_name; ?></td>

</tr>
<?php } ?>
</tbody>
</table>
</div>
</div>
</div>
</div>