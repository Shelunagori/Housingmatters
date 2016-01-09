<h3>Re-Send email to users for login to HousingMatters.</h3>
<table class="table table-striped table-bordered dataTable" id="sample_1">
	<thead>
		<tr>
			<th>#</th>
			<th>Username</th>
			<th>Flat</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$i=0;
	
	foreach($result_not_login as $collection)
	{
	$user_id=$collection['user']["user_id"];
	$username=$collection['user']["user_name"];
	
	$result_user = $this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'),array('pass'=>array($user_id)));
	foreach ($result_user as $collection) 
	{
		$name=$collection['user']['user_name'];
		$wing=$collection['user']['wing'];
		$flat=$collection['user']['flat'];
	}
	
	$flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'),array('pass'=>array($wing,$flat)));
	$i++;
	?>
		<tr id="row<?php echo $user_id; ?>">
			<td><?php echo $i; ?></td>
			<td><?php echo $username; ?></td>
			<td><?php echo $flat; ?></td>
			<td><a href="#" class="btn green mini resend" id="<?php echo $user_id; ?>">Re-Send Email</a></td>
		</tr>
		<?php } ?>
	</tbody>
</table>




<script>
$(document).ready(function() { 
	 $(".resend").live('click',function(){
		var id=$(this).attr('id');
		$( "#row"+id).html('<td colspan="4">Sending Email...</td>').load( 'resident_approve_resend_mail?con=' + id, function() {
		});
	 });
	 
});
</script>
