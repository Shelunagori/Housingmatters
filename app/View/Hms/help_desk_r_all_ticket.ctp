<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>				   
<script>
$(document).ready(function() {
$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>
<div align="center">
<a href="help_desk_r_open_ticket" rel='tab' class="btn blue"><i class="icon-folder-open"></i> Open Tickets</a>
<a href="help_desk_r_close_ticket" rel='tab' class="btn blue"><i class="icon-folder-close"></i> Closed Tickets</a>
<a href="help_desk_r_all_ticket" rel='tab' class="btn red"><i class="icon-globe"></i> All Tickets</a>
<a href="help_desk_r_draft_ticket" rel='tab' class="btn blue"><i class="icon-briefcase"></i>  Draft Ticket</a>
</div>
<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box">
<!--<div class="portlet-title">

</div>-->
<div class="portlet-body">
<table class="table table-striped table-bordered" id="sample_2">
	<thead>
		<tr>
			<th style="width:5%;">Sr No</th>
			<th>Date</th>
			<th>Time</th>
			<th>Ticket No.</th>
			 <th>Ticket Priority</th>
			<th>Category</th>
			<th>Status</th>
			<th style="width:10%;">View</th>
		</tr>
	</thead>
	<tbody>
<?php
$z=0;

foreach ($result_help_desk as $collection) 
{
$z++;
$help_desk_id=$collection['help_desk']['help_desk_id'];
$date=$collection['help_desk']['help_desk_date'];
$time=$collection['help_desk']['help_desk_time'];
$ticket_id=$collection['help_desk']['ticket_id'];
$complain_type_id=(int)$collection['help_desk']['help_desk_complain_type_id'];
$d_user_id=(int)$collection['help_desk']['user_id'];
$help_desk_status=(int)$collection['help_desk']['help_desk_status'];
$ticket_priority=$collection['help_desk']['ticket_priority'];
if($ticket_priority==1)
{
$ticket_priority="Urgent";
}
else
{
$ticket_priority="Normal";
}


$help_desk_category_name = $this->requestAction(array('controller' => 'hms', 'action' => 'help_desk_category_name'),array('pass'=>array($complain_type_id)));



?>
		<tr class="odd gradeX">
			<td><?php echo $z; ?></td>
			<td><?php echo $date; ?></td>
			<td><?php echo $time; ?></td>
			<td><?php echo $ticket_id; ?></td>
			  <td><?php echo $ticket_priority; ?></td>
			<td><?php echo $help_desk_category_name; ?></td>
			<td>
			<?php if($help_desk_status==0){ ?> <span class="label" style="background-color: #d84a38;">Open</span><?php  }?>
		<?php if($help_desk_status==1){ ?> <span class="label label-success">Close</span><?php  }?>
			</td>
			<td><a href="help_desk_r_view?id=<?php echo $help_desk_id; ?>&status=<?php echo $help_desk_status; ?>" rel='tab' class="btn yellow mini green">View</a></td>
			
		</tr>
<?php } ?>

	</tbody>
</table>
</div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->
<!-- END PAGE CONTENT-->
</div>





<!--------REPLY------------>
<link href="<?php echo $this->webroot ; ?>/as/reply.css" rel="stylesheet" />
<?php $a=1; ?>
<script>
	

$(document).ready(function() {
	$("#reply").live('click',function(){
	
			var r=$("#msg_reply").val();
			var a=$("#hd_id").val();
			
			if(r!="")
			{
			
			r=encodeURIComponent(r);
			$("#reply_post").load('save_reply_resident?reply=' + r + '&id=' + a);
			$("#msg_reply").val('');
			}
			
				
	});
});

</script>

