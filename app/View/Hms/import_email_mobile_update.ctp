<form method="post" id="form_email_update">
<table class="table table-bordered" >
<thead style="background-color:#FFC;">
<tr>
<th> Name</th>
<th> Email</th>
<th> Mobile</th>
</tr>
</thead>
<tbody id="url_main">
	<?php
	$i=0;
	
	foreach($table as $child){
	$i++;
	?>
	<tr id="tr<?php echo $i; ?>">
		<td width="15%">
		<select class="span12 m-wrap wing" id="wing2" name="name" inc_id="<?php echo $i; ?>">
		<option value="">-User name-</option>
		<?php 
		foreach($result_user as $data) { 
		$user_id=$data["user"]["user_id"];
		$user_name=$data["user"]["user_name"];
		?>
		<option value="<?php echo $user_id; ?>" <?php if($user_id==$child[0]){ echo 'selected';} ?> ><?php echo $user_name; ?></option>
		<?php } ?>

		</select>
		</td>
		<td width="20%"><input type="text" class="span12 m-wrap textbox" name="email" id="email1" style="font-size:16px;  background-color: white !important;" placeholder="Email" value="<?php echo $child[1]; ?>"></td>
		<td width="15%"><input type="text" class="span12 m-wrap textbox" name="mobile" id="mobile1" style="font-size:16px;  background-color: white !important;" placeholder="Mobile" value="<?php echo $child[2]; ?>"></td>
	</tr>	
<?php } ?>
</tbody>
</table>
<button type="button" id="submit" class="btn blue">Update</button>
</form>