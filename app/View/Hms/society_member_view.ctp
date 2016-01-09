<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>
<script>
$(document).ready(function() {

$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>
<style>
table th{ font-size:12px !important; }

</style>
<?php 
foreach ($result_society as $collection){ 
	$society_name=$collection['society']['society_name'];
}
?>
<div align="center">
	<h3 class="page-title"><?php echo $society_name; ?></h3>
	<div class="pull-right">
	<a href='society_member_excel'class='blue mini btn' download='download'  ><i class=" icon-download-alt"></i> </a>
		<a href="<?php echo $webroot_path; ?>Hms/society_member_view" class="btn yellow" rel="tab">All Active Users</a>
		<a href="<?php echo $webroot_path; ?>Hms/user_deactive" class="btn" rel="tab">All De-active Users</a>
	</div>
	<div class="pull-left"> 
		<a class="btn mini green"><?php echo $result_user_owner; ?></a> <span>Owner &nbsp; 
		</span> <a class="btn mini purple"><?php echo $result_user_tenant; ?></a> <span> &nbsp; Tenant &nbsp; 
		&nbsp; 
		<span style="color:red; font-size:14px;"> <i class=' icon-star'></i> </span> 
		<span> Awaiting User Validation  </span>
	</div>
</div>

<div class="portlet-body" style="background-color:#fff;">
	<table class="table table-bordered table-hover" id="sample_1">
		<thead>
			<tr>
			   <th>Sr.no</th>
				<th>Name</th>
				<th>Unit</th>
				<th>Role</th>
				<th>Mobile</th>
				<th>Email</th>
				<th style="width:110px !important;">Validation Status</th>
				<th>Portal Enrollment date</th>
				<th>Deactivate?</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$i=0;
		foreach ($result_user as $collection) {
				
			$user_id=$collection['user']['user_id'];
			$user_name=$collection['user']['user_name'];
			$role_ids=$collection['user']['role_id'];
			//$wing=$collection['user']['wing'];
			$email=$collection['user']['email'];
			$mobile=$collection['user']['mobile'];
			//$multiple_flat=@$collection['user']['multiple_flat'];
			//$flat=$collection['user']['flat'];
			$tenant=$collection['user']['tenant'];
			$date=$collection['user']['date'];
			@$profile_status=$collection['user']['profile_status'];
			$result_user_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_user_flat_active'),array('pass'=>array($user_id)));
			foreach($result_user_flat as $data){
				$i++;
				
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
					
						<tr id="tr<?php echo $user_flat_id; ?>">
						<td><?php echo $i; ?></td>
									<td style="color:<?php echo $color; ?>">
									
										<?php echo $user_name; ?>
										<?php if($profile_status!=2) { ?>  
										<span style="color:red; font-size:10px;"> <i class=' icon-star'></i> </span> 
										<?php } ?> 
									</td>
									<td><?php echo $wing_flat; ?></td>
									<td><?php echo $role_name_des; ?></td>
									<td><?php echo $mobile; ?></td>
									<td><?php echo $email; ?></td>
									<td>
										<?php if($profile_status!=2) { ?>  
										<?php if(!empty($email)) { ?> 
										<a href="#" role='button' class="btn red  mini resend" id="<?php echo $user_id; ?>"><i class=" icon-exclamation-sign"></i>  Send Reminder</a> <?php } elseif(!empty($mobile)) { ?>
										<a href="#" role='button' class="btn red  mini resend_sms" id="<?php echo $user_id; ?>"><i class=" icon-exclamation-sign"></i> Send Reminder</a> <?php } ?>
										<?php }
											else
											{ ?>
											<span> <a class="btn green mini"><i class=" icon-ok"></i>  done</a></span>
											
											<?php 
											}


										?>
									</td>
									<td><?php echo $date; ?></td>
									<td>
									<a href="#" class="btn red mini deactive_conferm tooltips" id="<?php echo $user_id; ?>"  user_flat="<?php echo $user_flat_id; ?>" data-placement="bottom" data-original-title="Deactivate?" role="button"><i class=" icon-remove-sign"></i></a>
									</td>
						</tr>	
							
 
			
			<?php } } ?>	
		</tbody>
	</table>
	
</div>
<div class="edit_div" style=""></div>
<script>
$(document).ready(function() {
	$(".deactive").live('click', function(e){
		$(".edit_div").hide();
		$(this).text("Wait...");
		var id=$(this).attr("id");
		//alert(id);
		var user_flat=$(this).attr("user_flat");
		$.ajax({
			url: "<?php echo $webroot_path; ?>/Hms/user_deactive_ajax?t="+id+"&d=0"+"&user_flat_id="+user_flat,
			}).done(function(response) {
				$("tr#tr"+user_flat).html('<td colspan="8"><div style="margin-bottom: 0px;" class="alert alert-success"><strong>Success!</strong> User de-activated successfully.</div></td>');
				setTimeout(function() {
					$("tr#tr"+user_flat).remove();
				}, 2000);
			}); 
	});
	$(".deactive_conferm").off().on('click', function(e){
		var id=$(this).attr("id");
		var user_flat=$(this).attr("user_flat");
		 $.ajax({
			url: "<?php echo $webroot_path; ?>/Hms/check_due_payment?user_flat="+user_flat,
			type: 'POST',
			dataType:'json',
			}).done(function(response) {
			
			
				if(response.report_type=='done'){					
					$('.edit_div').show();
					$('.edit_div').html('<div class="modal-backdrop fade in"></div><div class="modal" id="poll_edit_content"><div class="modal-body"><span style="font-size:16px;"> <i class="icon-warning-sign" style="color:#d84a38;"></i>  Are you sure you want to deactivate user ? </span></div><div class="modal-footer"><a href="#" class="btn red deactive tooltips" id='+id+' user_flat='+user_flat+' data-placement="bottom" data-original-title="Deactivate?" role="button"> Yes</a><button class="btn" id="close_edit">No</button></div></div>');
					
				}
				if(response.report_type=='due'){
					//alert(response.report_type);
					$('.edit_div').show();
					$('.edit_div').html('<div class="modal-backdrop fade in"></div><div class="modal" id="poll_edit_content"><div class="modal-body"><span style="font-size:16px;"> <i class="icon-warning-sign" style="color:#d84a38;"></i> '+response.text+' </span><br/><span style="font-size:16px;"></span></div><div class="modal-footer"><a href="<?php echo $webroot_path; ?>Cashbanks/new_bank_receipt" class="btn red " > Ok</a><button class="btn" id="close_edit">No</button></div></div>');
				}
			});
		
		return false;
	});
	$("#close_edit").live('click', function(e){
		$('.edit_div').hide();
	});
});
</script>
<script>
$(document).ready(function() {
	 $(".resend").bind('click',function(){
		var id=$(this).attr('id');
		
		$(this).html('Sending Email...').load( 'resident_approve_resend_mail?con=' + id, function() {
		$(this).removeClass( "resend green" ).addClass( "red" );
		});
	 });
	 
});
</script>
