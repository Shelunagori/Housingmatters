<div class="portlet-body">
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th>Name</th>
				<th>Unit</th>
				<th>Email</th>
				<th>Mobile</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($result_user_info_csv_converted as $data){
			$name=$data["user_info_csv_converted"]["name"];
			$wing_id=$data["user_info_csv_converted"]["wing_id"];
			$flat_id=$data["user_info_csv_converted"]["flat_id"];
			
			$wing_flat=$this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'), array('pass' => array($wing_id,$flat_id))); ?>
			<tr>
				<td><?php echo $name; ?></td>
				<td><?php echo $wing_flat; ?></td>
				<td>Otto</td>
				<td>Otto</td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
</div>