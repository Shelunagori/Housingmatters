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
<a href="help_desk_r_all_ticket" rel='tab' class="btn blue"><i class="icon-globe"></i> All Tickets</a>
<a href="help_desk_r_draft_ticket" rel='tab' class="btn red"><i class="icon-briefcase"></i> Draft Ticket</a>
</div>
<!-- BEGIN EXAMPLE TABLE PORTLET-->
	<div class="portlet box">
							
							<div class="portlet-body">
								<table class="table table-striped table-bordered" id="sample_2" >
									<thead>
    									<tr>
											<th style="width:5%;">Sr No</th>
                                        	<th>Date</th>
                                            <th >Time</th>
											<th >Category</th>
                                            <!--<th style="width:10%;">View</th>-->
                                            <th >Action</th>
										</tr>
									</thead>
									<tbody>
   <?php
   $z=0;
	
	foreach ($result_help_desk_draft as $collection) 
	{
		$z++;
		$help_desk_id=$collection['help_desk']['help_desk_id'];
		$date=$collection['help_desk']['help_desk_date'];
	    $time=$collection['help_desk']['help_desk_time'];
		$complain_type_id=(int)$collection['help_desk']['help_desk_complain_type_id'];
		$d_user_id=(int)$collection['help_desk']['user_id'];
		$help_desk_category_name = $this->requestAction(array('controller' => 'hms', 'action' => 'help_desk_category_name'),array('pass'=>array($complain_type_id)));
		?>
<tr class="odd gradeX">
		<td><?php echo $z; ?></td>
		<td><?php echo $date; ?></td>
		<td><?php echo $time; ?></td>
		<td><?php echo $help_desk_category_name; ?></td>
			<td> 
			<!---- action popup ----->

			<div class="btn-group">
			<a class="btn mini blue " href="#" data-toggle="dropdown"> Action</a>
			<ul class="dropdown-menu">
			<li><a href="help_desk_send_to_sm?id=<?php echo $help_desk_id; ?>"><i class="icon-pencil"></i> Edit</a></li>
			<li><a href="##<?php echo $z; ?>"  data-toggle="modal"><i class="icon-trash"></i> Delete</a></li>
			</ul>
			</div>
			<!----- end action popup ------->
			</td>

			<!--popup start -->
			<div id="<?php echo $z; ?>" class="modal hide " tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true" style="display: none;">
			<div class="modal-header" >
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
			<h3 id="myModalLabel3"><b>Confirm Box</b></h3>
			</div>
			<div class="modal-body">
			<b style="font-size:16px;font-family:'Times New Roman', Times, serif;">Are you sure to Delete</b>
			</div>
			<div class="modal-footer">

			<a href="help_desk_draft_delete?con=<?php echo $help_desk_id; ?>" role="btn"  class="btn blue" >Yes</a>
			<button class="btn" data-dismiss="modal" aria-hidden="true">No</button>
			</div>
			</div>
			<!--popup end -->	
											
                                           	
</tr>
  <?php } ?>

	</tbody>
	</table>
	</div>
	</div>
	<!-- END EXAMPLE TABLE PORTLET-->
	<!-- END PAGE CONTENT-->
	</div>
	<!-- END PAGE CONTAINER-->	
	</div>
	<!-- END PAGE -->	 	
	</div>