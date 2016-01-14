
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
table th {font-size: 12px !important; }
</style>
<form id="form" method="post" enctype="multipart/form-data">
<div class="portlet-body" style="background-color:#fff;">
<div style="padding: 10px;">
<span class="label label-important">NOTE</span><span> No need to save this form. The system will automatically save updated data. </span>
</div>
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th >Tenant Name</th>
				<th>Permanent address</th>
				<th>Tenancy start date</th>
				<th>Tenancy end date</th>
				<th>Verification</th>
				<th>Tenancy agreement</th>
				<th>Police verification</th>
				<th>file</th>
			</tr>
		</thead>
		<tbody>
		<?php 
		foreach($result_user as $collection){
					$user_tenant_id=(int)$collection['user']['user_id'];
					$wing_id=$collection['user']['wing'];
					$flat_id=$collection['user']['flat'];
					$user_name=$collection['user']['user_name'];
					$wing_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'),array('pass'=>array($wing_id,$flat_id)));

                $result_tenat = $this->requestAction(array('controller' => 'hms', 'action' => 'new_tenant_data_fetch'),array('pass'=>array($user_tenant_id)));
				$t_address=''; $t_agreement=''; $t_police='';$verification='';$t_start_date='';$t_end_date='';$t_file='';
				foreach($result_tenat as $data){
					$t_address=@$data['tenant']['t_address'];
					$t_agreement=@$data['tenant']['t_agreement'];
					$t_police=@$data['tenant']['t_police'];
					$verification=@$data['tenant']['verification'];
					$t_start_date=@$data['tenant']['t_start_date'];
					$t_end_date=@$data['tenant']['t_end_date'];
					$t_file=@$data['tenant']['t_file'];

				}
		
		?>
			<tr>
			<td> <?php echo $user_name ; ?>  <?php echo $wing_flat; ?></td>
			<td> 
				<input type="text" class="span12 m-wrap per_add" permanet_address="permanet_address" tenant_id="<?php echo $user_tenant_id;?>" value="<?php echo @$t_address; ?>">
			</td>
			<td> 
				<input type="text" class="span8 m-wrap  date-picker ten_start" tenancy_start="tenancy_start"  data-date-format="dd-mm-yyyy" tenant_id="<?php echo $user_tenant_id;?>" value="<?php echo @$t_start_date; ?>">
			</td>
			<td> 
				<input type="text" class="span8 m-wrap  date-picker ten_end" tenancy_end="tenancy_end" data-date-format="dd-mm-yyyy" tenant_id="<?php echo $user_tenant_id;?>" value="<?php echo @$t_end_date; ?>">
			</td>
			<td>
				<input type="text" class="span12 m-wrap ten_ver" verification="verification" tenant_id="<?php echo $user_tenant_id;?>" value="<?php echo @$verification; ?>" >
			</td>
			<td> 
			<label class="">
                <input type="checkbox" value="1" name="ten_agr" class="ten_agr" tenancy_agreement="tenancy_agreement" tenant_id="<?php echo $user_tenant_id;?>"<?php if(@$t_agreement==1){?> checked <?php } ?>> 
             </label>
			 </td>
			<td> 
			<label class="">
                  <input type="checkbox" value="1" name="pol_ver" class="pol_ver" police_verification="police_verification" tenant_id="<?php echo $user_tenant_id;?>" <?php if(@$t_police==1){?> checked <?php } ?> >
             </label>
			</td>
			
			<td>
						<div class="control-group">
										  
								<div class="controls">
								   <div class="fileupload fileupload-new" data-provides="fileupload"><input type="hidden" value="" name="">
												<span class="btn btn-file">
												<span class="fileupload-new"> <i class="icon-upload-alt"></i></span>
												<span class="fileupload-exists">Change</span>
												<input type="file" class="default change_file" name="file1" tenant_id="<?php echo $user_tenant_id;?>" file_upload="file_upload">
												</span>
												<br/><span class="fileupload-preview"><?php echo @$t_file; ?></span>
												<a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none"></a>
											 </div>
								  </div>
					  </div>
			</td>
			</tr>			
		<?php }  ?>		
		</tbody>
	</table>
	
</div>
</form>

<script>
$(document).ready(function(){
$( ".change_file" ).change(function() {
var m_data = new FormData(); 	
var t_id=$(this).attr('tenant_id');
var permanet_address=$(this).attr('file_upload');
m_data.append( 'file', $(this)[0].files[0]);
m_data.append( 'tenant_id', $(this).attr('tenant_id'));
m_data.append( 'file_upload', $(this).attr('file_upload'));
$.ajax({
		url: "<?php echo $this->webroot;?>hms/new_tenant_file_upload",
		data: m_data,
		processData: false,
		contentType: false,
		type: 'POST',
		}).done(function(response) {
	
});
});	
	$(".per_add").bind('keyup',function(){
		var p = $(this).val();
		var t_id=$(this).attr('tenant_id');
		var permanet_address=$(this).attr('permanet_address');
		
		$.ajax({
			url: "<?php echo $webroot_path; ?>/Hms/new_tenant_enrollment_ajax1?con="+t_id+"&con2="+p+"&con3="+permanet_address,
			}).done(function(response) {

		});		
	});
	
	
	$(".ten_start").bind('blur',function(){
		var t_s = $(this).val();
		var t_id=$(this).attr('tenant_id');
		var ten_st=$(this).attr('tenancy_start');
		$.ajax({
			url: "<?php echo $webroot_path; ?>/Hms/new_tenant_enrollment_ajax1?con="+t_id+"&con2="+t_s+"&con3="+ten_st,
			}).done(function(response) {
			
		});	
	});
	
	$(".ten_end").bind('blur',function(){
		var t_s = $(this).val();
		var t_id=$(this).attr('tenant_id');
		var ten_st=$(this).attr('tenancy_end');
		$.ajax({
			url: "<?php echo $webroot_path; ?>/Hms/new_tenant_enrollment_ajax1?con="+t_id+"&con2="+t_s+"&con3="+ten_st,
			}).done(function(response) {
			
		});	
	});
	
	$(".ten_ver").bind('keyup',function(){
		var p = $(this).val();
		var t_id=$(this).attr('tenant_id');
		var permanet_address=$(this).attr('verification');
		
		$.ajax({
			url: "<?php echo $webroot_path; ?>/Hms/new_tenant_enrollment_ajax1?con="+t_id+"&con2="+p+"&con3="+permanet_address,
			}).done(function(response) {

		});		
	});
	
	$(".ten_agr").bind('click',function(){
		
		var t_id=$(this).attr('tenant_id');
		var permanet_address=$(this).attr('tenancy_agreement');
		value = +$(this).is( ':checked' );
		if(value==0){
			var p = 0;
			$.ajax({
			url: "<?php echo $webroot_path; ?>/Hms/new_tenant_enrollment_ajax1?con="+t_id+"&con2="+p+"&con3="+permanet_address,
			}).done(function(response) {

		});	
		}else{
			var p = 1;
			$.ajax({
			url: "<?php echo $webroot_path; ?>/Hms/new_tenant_enrollment_ajax1?con="+t_id+"&con2="+p+"&con3="+permanet_address,
			}).done(function(response) {

		});
		}
		
	});
	
	
	$(".pol_ver").bind('click',function(){
		
		var permanet_address=$(this).attr('police_verification');
		var t_id=$(this).attr('tenant_id');
		value = +$(this).is( ':checked' );
		if(value==0){
			var p = 0;
			$.ajax({
			url: "<?php echo $webroot_path; ?>/Hms/new_tenant_enrollment_ajax1?con="+t_id+"&con2="+p+"&con3="+permanet_address,
			}).done(function(response) {
		});	
		}else{
			var p = 1;
			$.ajax({
			url: "<?php echo $webroot_path; ?>/Hms/new_tenant_enrollment_ajax1?con="+t_id+"&con2="+p+"&con3="+permanet_address,
			}).done(function(response) {
		});
		}

	});

});
</script>