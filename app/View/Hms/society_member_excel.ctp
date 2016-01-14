

<?php 
foreach ($result_society as $collection){ 
	$society_name=$collection['society']['society_name'];
}
?>


<div class="portlet-body" style="background-color:#fff;">
	<table border="1">
		<thead>
			<tr>
				<th>Name</th>
				<th>Unit</th>
				<th>Role</th>
				<th>Mobile</th>
				<th>Email</th>
				<th>Portal Enrollment date</th>
			</tr>
		</thead>
		<tbody>
		<?php
		foreach ($result_user as $collection) { 
			$user_id=$collection['user']['user_id'];
			$user_name=$collection['user']['user_name'];
			$role_ids=$collection['user']['role_id'];
			$wing=$collection['user']['wing'];
			$email=$collection['user']['email'];
			$mobile=$collection['user']['mobile'];
			$multiple_flat=@$collection['user']['multiple_flat'];
			$flat=$collection['user']['flat'];
			$tenant=$collection['user']['tenant'];
			$date=$collection['user']['date'];
			@$profile_status=$collection['user']['profile_status'];

			$result_user_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_user_flat_active'),array('pass'=>array($user_id)));
			foreach($result_user_flat as $data){
				
				
				$user_flat_id=$data['user_flat']['user_flat_id'];
				$flat_id=$data['user_flat']['flat_id'];
				
			
				$result_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($flat_id)));
				foreach($result_flat as $data2){
					
					$wing_id=$data2['flat']['wing_id'];
				}

					$wing_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'),array('pass'=>array($wing_id,$flat_id)));
					if($tenant==1){ $color="#13D17E"; }else{ $color="#C709F0"; }

					$role_name=array();
					if(sizeof($role_ids)>0){
						foreach($role_ids as $role_id){
							$role_name[] = $this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_rolename_via_roleid'),array('pass'=>array($role_id)));
						}
					}

					$role_name_des=implode(",",$role_name);
					unset($role_name);?>
					
						<tr id="tr<?php echo $user_id; ?>">
									<td>
										<?php echo $user_name; ?>
									</td>
									<td><?php echo $wing_flat; ?></td>
									<td><?php echo $role_name_des; ?></td>
									<td><?php echo $mobile; ?></td>
									<td><?php echo $email; ?></td>
									
									<td><?php echo $date; ?></td>
									
						</tr>	
							
  <?php } ?>
			
<?php } ?>	
		</tbody>
	</table>
	
</div>

