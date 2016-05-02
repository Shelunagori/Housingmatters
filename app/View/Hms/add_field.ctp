<table border="1" class="table">
	<tr>
		<td> user id</td>
		<td> user name</td>
		<td> login user name</td>
		<td> login user mobile</td>
		<td> password</td>
	</tr>
	
	<?php 
	
		foreach($result_user as $data){
		
		$user_id=$data['user_id'];
		$user_name=$data['user_name'];
		$login_user_name=$data['login_user_name'];
		$login_mobile=$data['login_mobile'];
		$login_password=$data['login_password'];
	?>
		<tr>
		<td><?php echo $user_id; ?></td>
		<td> <?php echo $user_name; ?></td>
		<td> <?php echo $login_user_name; ?></td>
		<td><?php echo $login_mobile; ?></td>
		<td><?php echo $login_password; ?></td>
		
		</tr>
		<?php } ?>
</table>