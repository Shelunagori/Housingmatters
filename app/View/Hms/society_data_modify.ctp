

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
				<th>user_id</th>
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

		if(!empty($multiple_flat)){
				foreach($multiple_flat as $data4){
				
					$wing=$data4[0];
					$flat=$data4[1];
				//user info via flat_id//
					$result_user_info=$this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_user_info_via_flat_id'),array('pass'=>array($wing,$flat)));
					foreach($result_user_info as $user_info){
						$user_id=(int)$user_info["user"]["user_id"];
						$user_name=$user_info["user"]["user_name"];
					} 
				
				$wing_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'),array('pass'=>array($wing,$flat)));
				if($tenant==1){ $color="#13D17E"; }else{ $color="#C709F0"; }
				$role_name=array();
				if(sizeof($role_ids)>0){
					foreach($role_ids as $role_id){
					$role_name[] = $this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_rolename_via_roleid'),array('pass'=>array($role_id)));
					}
				}
				$role_name_des=implode(",",$role_name);
				unset($role_name);
?>
				
						<tr id="tr<?php echo $user_id; ?>">
						<td>
						<?php echo $user_name; ?>
						<?php if($profile_status!=2) { ?>  
						<span style="color:red; font-size:10px;"> <i class=' icon-star'></i> </span> 
						<?php } ?> 
						</td>
						<td><?php echo $wing_flat; ?></td>
						<td><?php echo $role_name_des; ?></td>
						<td><?php echo $mobile; ?></td>
						<td><?php echo $email; ?></td>
						
						<td><?php echo $date; ?></td>
						<td><?php echo $user_id; ?></td>
						</tr>
				
				<?php
			}
			
	}else{

					$wing_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'),array('pass'=>array($wing,$flat)));
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
									<td><?php echo $user_id; ?></td>
						</tr>	
							
  <?php } ?>
			
<?php } ?>	
		</tbody>
	</table>
	
</div>

