<style>
.erred{
	border:solid 1px red !important;
}
</style>
<div class="portlet-body" style="background-color:#FFF;">
	<table class="table table-bordered ">
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
			$auto_id=$data["user_info_csv_converted"]["auto_id"];
			$user_id=$data["user_info_csv_converted"]["user_id"];
			$email=$data["user_info_csv_converted"]["email"];
			$mobile=$data["user_info_csv_converted"]["mobile"];
			$emailErr=$data["user_info_csv_converted"]["emailErr"];
			$mobileErr=$data["user_info_csv_converted"]["mobileErr"];
			if($emailErr==0){ $err="erred"; }else{ $err=""; }
			if($mobileErr==0){ $mrr="erred"; }else{ $mrr=""; }
			if(!empty($user_id)){
			$result_user_info=$this->requestAction(array('controller' => 'Hms', 'action' => 'profile_picture'),array('pass'=>array($user_id)));
				foreach($result_user_info as $user_info){
					$user_name=$user_info["user"]["user_name"];
					$wing=$user_info["user"]["wing"];
					$flat=$user_info["user"]["flat"];
				}
				$wing_flat=$this->requestAction(array('controller' => 'Hms', 'action' => 'wing_flat'),array('pass'=>array($wing,$flat)));
			
			 ?>
			<tr id="<?php echo $auto_id; ?>">
				<td><?php echo $user_name; ?></td>
				<td><?php echo $wing_flat; ?></td>
				<td><input class="span9 m-wrap editthis <?php echo $err; ?>" field="email" type="text" value="<?php echo $email; ?>"></td>
				<td><input class="span6 m-wrap editthis <?php echo $mrr; ?>" field="mobile" type="text" value="<?php echo $mobile; ?>"></td>
			</tr>
		<?php } } ?>
		</tbody>
	</table>
</div>

<div class="pagination pagination-large ">
<ul>
<?php 
$loop=(int)($count_user_info_csv_converted/10);
if($count_user_info_csv_converted%10>0){
	$loop++;
}
for($ii=1;$ii<=$loop;$ii++){ ?>
	<li><a href="<?php echo $webroot_path; ?>Hms/modify_user_info_csv_data/<?php echo $ii; ?>" rel='tab' role="button" ><?php echo $ii; ?></a></li>
<?php } ?>
</ul>
</div>
<br/>

<button type="button" id="submit" class="btn blue">UPDATE</button>

<script>
$( document ).ready(function() {
	$( '.editthis' ).blur(function() {
		var id=$(this).closest('tr').attr("id");
		var field=$(this).attr("field");
		var val=$(this).val();
		$.ajax({
			url: "<?php echo $webroot_path; ?>Hms/check_user_info_csv_validation/"+id+"/"+field+"/"+val,
		}).done(function(response){
			if(response=="true"){
				if(field=="email"){
					 $("#"+id+ " td:eq(2) input").removeClass('erred')
				}
				if(field=="mobile"){
					 $("#"+id+ " td:eq(3) input").removeClass('erred')
				}
			}
			else{
				if(field=="email"){
					 $("#"+id+ " td:eq(2) input").addClass('erred')
				}
				if(field=="mobile"){
					 $("#"+id+ " td:eq(3) input").addClass('erred')
				}
			}
		});
	});
	
	$('#submit').click(function(){
		$.ajax({
			url: "<?php echo $webroot_path; ?>Hms/check_user_info_before_submit",
		}).done(function(response){
			if(response=="true"){
				window.location.replace("<?php echo $webroot_path; ?>Hms/email_mobile_update");
			}else{
				alert("There is error.");
			}
		});
	});
});
</script>

