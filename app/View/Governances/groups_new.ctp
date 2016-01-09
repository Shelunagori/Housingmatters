<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>
<script>
$(document).ready(function() {
$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>

<?php if(!empty($error_addgroup)) { ?>
<div class="alert alert-error">
	<strong>Error!</strong> <?php echo @$error_addgroup; ?>
</div>
<?php } ?>




<div class="span9" style="margin: inherit;">
	<!-- BEGIN BORDERED TABLE PORTLET-->
	<div class="portlet box green">
		<div class="portlet-title">
			<h4>All Groups</h4>
		</div>
		<div class="portlet-body">
			<table class="table table-bordered ">
				<thead>
					<tr>
						<th width="10%">Sr. No.</th>
						<th>Group Name</th>
						<th>Members</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i=0;
					foreach($result_group as $data)
					{
					$i++;
					$group_id=$data["group"]["group_id"];
					$group_name=$data["group"]["group_name"];
					$users_d=@$data["group"]["users"];
					?>
						<tr>
							<td><?php echo $i; ?></td>
							<td><?php echo $group_name; ?></td>
							<td><span class="label label-info"><?php echo sizeof($users_d); ?></span></td>
							<td><a href="groupview/<?php echo $group_id; ?>" rel="tab" class="btn mini yellow" >View</a></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
			
			
			
			<div>Add new group</div>
			<div class="input-append">
				<form id="contact-form" method="POST">
			   <input class="m-wrap" type="text" name="group_name" id="group_name_error" style="background-color: #fff !important;"><button class="btn green" type="submit" name="add"><i class="icon-plus"></i> Add new group</button>
			   </form>
			   <label id="group_name_error"></label>
			</div>


		</div>
	</div>
	<!-- END BORDERED TABLE PORTLET-->
</div>

