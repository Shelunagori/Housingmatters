<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>


<?php if(!empty($error_addgroup)) { ?>
<div class="alert alert-error">
	<strong>Error!</strong> <?php echo @$error_addgroup; ?>
</div>
<?php } ?>



<div style="width:80%;margin:auto;">
<div class="span" >
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
							<td>
							<a href="groupview/<?php echo $group_id; ?>" rel="tab" class="btn mini yellow" >View</a>
							
							<a  role="button" class="btn red mini delete_group" group="<?php echo $group_id; ?>" ><i class=" icon-remove-sign"></i></a>
							</td>
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
</div>
<div id="show_div"> </div>
<script>
$(document).ready(function(){
	
$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
	$(".delete_group").bind('click', function(){
		var id=$(this).attr('group');
					
					$('#show_div').show().html('<div class="modal-backdrop fade in"></div><div class="modal" id="poll_edit_content"><div class="modal-body"><span style="font-size:16px;"><i class="icon-warning-sign" style="color:#d84a38;"></i>  Are you sure you want to delete group ? </span></div><div class="modal-footer"><a href="group_delete?con='+id+'" class="btn red tooltips"  role=""> Yes</a><button class="btn" id="close_div">No</button></div></div>');
	
	});
	$("#close_div").die().live('click', function(){
		$('#show_div').hide();
		
	});
});
</script>