<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>
<script>
$(document).ready(function() {

$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>

<?php 
foreach ($result_society as $collection){ 
	$society_name=$collection['society']['society_name'];
}
?>
<div align="center">
	<h3 class="page-title"><?php echo $society_name; ?></h3>
	<div class="pull-right">
		<a href="<?php echo $webroot_path; ?>Hms/society_member_view" class="btn" rel="tab">All Active Users</a>
		<a href="<?php echo $webroot_path; ?>Hms/user_deactive" class="btn yellow" rel="tab">All De-active Users</a>
	</div>
</div>

<div class="portlet-body" style="background-color:#fff;">
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th>Name</th>
				<th>Unit</th>
				<th>Owner/Tenant</th>
				<th>Mobile</th>
				<th>Email</th>
				<th>Activate?</th>
			</tr>
		</thead>
		<tbody>
		<?php
		foreach ($result_user_deactive as $collection) { 
			$user_id=$collection['user']['user_id'];
			$user_name=$collection['user']['user_name'];
			$wing=$collection['user']['wing'];
			$email=$collection['user']['email'];
			$mobile=$collection['user']['mobile'];
			//$multiple_flat=@$collection['user']['multiple_flat'];
			$flat=$collection['user']['flat'];
			$tenant=$collection['user']['tenant'];
			$date=$collection['user']['date'];
			@$profile_status=$collection['user']['profile_status'];
			$result_user_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_user_flat_deactive'),array('pass'=>array($user_id)));
			foreach($result_user_flat as $data){
				
				
				$user_flat_id=$data['user_flat']['user_flat_id'];
				$flat_id=$data['user_flat']['flat_id'];
				
			
				$result_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($flat_id)));
				foreach($result_flat as $data2){
					
					$wing_id=@$data2['flat']['wing_id'];
				}
				$wing_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'),array('pass'=>array(@$wing_id,$flat_id)));
				if($tenant==1){ $status="Owner"; }else{ $status="Tenant"; } ?>
					<tr id="tr<?php echo $user_flat_id; ?>">
					<td>
						<?php echo $user_name; ?>
					</td>
					<td><?php echo $wing_flat; ?></td>
					<td><?php echo $status; ?></td>
					<td><?php echo $mobile; ?></td>
					<td><?php echo $email; ?></td>
					<td>
					<a href="#" class="btn green mini deactive_conferm tooltips" data-placement="bottom" data-original-title="Activate?" user_flat="<?php echo $user_flat_id; ?>" id="<?php echo $user_id; ?>" role="button"><i class=" icon-ok-sign"></i></a></td>
					</tr>
			<?php } }?>
	
		</tbody>
	</table>
</div>
<div class="edit_div" style=""></div>
<script>
$(document).ready(function() {
	
	$(".deactive12").die().live('click', function(e){
		$(".edit_div").hide();
		$(this).text("Wait...");
		var id=$(this).attr("id");
		var user_flat=$(this).attr("user_flat");
		$.ajax({
			url: "<?php echo $webroot_path; ?>/Hms/user_deactive_ajax?t="+id+"&d=1"+"&user_flat_id="+user_flat,
			type: 'POST',
			dataType:'json',
			}).done(function(response) {
				
			if(response.report_type=='done'){	
				$("tr#tr"+user_flat).html('<td colspan="8"><div style="margin-bottom: 0px;" class="alert alert-success"><strong>Success!</strong> User Activated successfully.</div></td>');
				
				setTimeout(function() {
					$("tr#tr"+user_flat).remove();
				}, 2000);
			}
			if(response.report_type=='exits'){
				
					$('.edit_div').show();
					$('.edit_div').html('<div class="modal-backdrop fade in"></div><div class="modal" id="poll_edit_content"><div class="modal-body"><span style="font-size:16px;"><i class=" icon-ok-sign" style="color:green;"></i> Flat is Already Exist. </div><div class="modal-footer"><button class="btn green" id="close_edit">OK</button></div></div>');

			}
			});
		return false;
	});
	
	$(".deactive_conferm").off().on('click', function(e){
		var id=$(this).attr("id");
		var user_flat=$(this).attr("user_flat");
		$('.edit_div').show();
		$('.edit_div').html('<div class="modal-backdrop fade in"></div><div class="modal" id="poll_edit_content"><div class="modal-body"><span style="font-size:16px;"><i class=" icon-ok-sign" style="color:green;"></i> Are you sure you want to activate user ? </div><div class="modal-footer"><a href="#" class="btn green  deactive12 tooltips" data-placement="bottom" data-original-title="Activate?" id='+id+' user_flat='+user_flat+' role="button">Yes</a><button class="btn" id="close_edit">No</button></div></div>');
		return false;
	});
	$("#close_edit").live('click', function(e){
		$('.edit_div').hide();
	});
});
</script>