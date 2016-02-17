<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>
<script>
$(document).ready(function() {

$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>
<div class="portlet-body" style="padding:10px;";>
									<!--BEGIN TABS-->
									<div class="tabbable tabbable-custom">
										<ul class="nav nav-tabs">
											
										</ul>
										<div class="tab-content" style="min-height:500px;">
											<div class="tab-pane active" id="tab_1_1">


<div style="text-align:center; font-size:24px">
<img src="<?php echo $this->webroot ; ?>/as/hm/hm-logo.png" alt="logo" /> </div>
<span class="label label-info pull-right" style="padding:10px; font-size:20px">Total Society : <?php echo $n=sizeof($result_society); ?></span>
<br><br>
<div><h5><b><span style="float:left;margin-left:20px;"> Society Name </span><div style="float:right; padding:5px; "><span style="margin-right: 33px;width: 50px;">Creation date</span> <span style="float:right;"> &nbsp  Member</span></div></b></h5></div>





	
							<div class="portlet-body">
								<div class="accordion in collapse" id="accordion1" style="height: auto;">
									<div class="accordion-group">
									
									<?php
									$r=0; $j=0;

									foreach ($result_society as $collection) 
									{ 
									$j++;
									$designation_id=$collection['society']['society_id'];
									$designation_name=$collection['society']['society_name'];
									foreach ($result_user as $collection) 
									{ 
									$role_id=$collection['user']['society_id'];
									$da_user_id=$collection['user']['user_id'];
									$user_name=$collection['user']['user_name']; 
									@$date=$collection['user']['date'];
									
									if(($designation_id==$role_id))
									{
										 $result_count_member = $this->requestAction(array('controller' => 'hms', 'action' => 'count_society_member'),array('pass'=>array($role_id)));
									$r++;
									$u_name[]=$user_name; 
									$dad_user_id[]=$da_user_id;
									$u_date[]=$date;
									}
									}
									
									?>
									
										<div class="accordion-heading">
										
										<div style="float:right; padding:5px; "><span style="float:left;width: 155px;">10-12-2016</span><span class="label label-info pull" style=" float:right;font-size:14px;width: 20px;"><?php echo $result_count_member; ?></span> </div>
											<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapse_1<?php echo $j ; ?>" style="text-decoration:none;">
											
											<b><?php echo $designation_name; ?> </b>
											</a>
										</div>
										
										
										
										
										
										<div id="collapse_1<?php echo $j ; ?>" class="accordion-body collapse" style="height: 0px;">
											<div class="accordion-inner">
<table class="table">
<tr>
<td><b>Name</b></td>
<td><b>Unit</b></td>
<td><b>Mobile</b></td>
<td><b>Email</b></td>
<td><b>Validation Pending</b></td>
<td><b>Portal joining date</b></td>
</tr>						
						
<?php 
for($ii=0;$ii<sizeof(@$u_name);$ii++)
{
  $user= $dad_user_id[$ii];
  $d_date=$u_date[$ii];
  $result_user1 = $this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'),array('pass'=>array($user)));
	 foreach ($result_user1 as $collection) 
		{	
		$society_id=$collection['user']['society_id'];
		 $wing=$collection['user']['wing'];
		 $email=$collection['user']['email'];
		  $user_id_da=$collection['user']['user_id'];
		 $mobile=$collection['user']['mobile'];
		 $flat=$collection['user']['flat'];
		 $tenant=$collection['user']['tenant'];
		 @$profile_status=$collection['user']['profile_status'];
		}
//$wing_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'),array('pass'=>array($wing,$flat)));

$result_user_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_user_flat_active'),array('pass'=>array($user_id_da)));
			foreach($result_user_flat as $data){
				
				
				$user_flat_id=$data['user_flat']['user_flat_id'];
				$flat_id=$data['user_flat']['flat_id'];
				
			
				$result_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_wing_id_via_flat_id_hm'),array('pass'=>array($flat_id,$society_id)));
				
				foreach($result_flat as $data2){
					
					$wing_id=$data2['flat']['wing_id'];
				}
				$wing_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'),array('pass'=>array($wing_id,$flat_id)));
		
	if($tenant==1){ $color="#13D17E"; }else{ $color="#C709F0"; }	
?>
	
<tr style="color:<?php echo $color; ?>">
<td>
<?php echo $u_name[$ii]; ?>  
<?php if($profile_status!=2) { ?>  
<span style="color:red; font-size:10px;"> <i class=' icon-star'></i> </span> 
<?php } ?>
</td>
<td>
 <?php echo $wing_flat; if(empty($wing_flat)){ echo" -- "; }?>
</td>
<td>
 <?php echo $mobile; if(empty($mobile)){ echo" -- "; } ?>
</td>
<td>
 <?php echo $email; if(empty($email)){ echo" -- "; } ?>
</td>
<td>
<?php if($profile_status!=2) { ?>  
<?php if(!empty($email)) { ?> 
<a href="#" role='button' class="btn red mini resend" id="<?php echo $user; ?>" element_id='<?php echo $society_id ; ?>'><i class=" icon-exclamation-sign"></i> Send Reminder</a> <?php } elseif(!empty($mobile)) { ?>
<a href="#" role='button' class="btn red mini resend_sms" id="<?php echo $user; ?>" element_id='<?php echo $society_id ; ?>'><i class=" icon-exclamation-sign"></i> Send Reminder</a> <?php } ?>
<?php } else {?>  <span> <a class="btn green mini"><i class=" icon-ok"></i> done</a></span>   <?php } ?> 
</td>
<td>
<span> <?php echo $d_date; ?></span>
</td>
</tr>	
		
<?php 
} 

}

unset($u_name);
unset($dad_user_id);
unset($u_date);

?>
</table>	
<br>
			<br>
		<div style="float:left;"> <a class="btn mini green"></a> <span>Owner &nbsp; 
		</span> <a class="btn mini purple"></a> <span> &nbsp; Tenant &nbsp; 
		 &nbsp; 
		<span style="color:red; font-size:14px;"> <i class=' icon-star'></i> </span> 
		<span> Awaiting User Validation  </span>
		<hr>
		</div>
	
						
											
											</div>
										</div>
										
										<?php $r=0; } ?>
										
									</div>
									
									
									
								</div>
							</div>
						
						
						
						
						
		</div>
</div>
</div>
</div>		
				

<script>
$(document).ready(function() { 
	 $(".resend").live('click',function(){
		var id=$(this).attr('id');
		var so=$(this).attr('element_id');
		$(this).html('Sending Email...').load( 'hm_resident_approve_resend_mail?con=' + id + '&con2=' + so , function() {
		$(this).removeClass( "resend green" ).addClass( "red" );
		});
	 });
	 
});
</script>	

<script>
$(document).ready(function() { 
	 $(".resend_sms").live('click',function(){
		var id=$(this).attr('id');
		var so=$(this).attr('element_id');
		$(this).html('Sending Sms...').load( 'hm_resident_approve_resend_sms?con=' + id + '&con2=' + so, function() {
		$(this).removeClass( "resend_sms green" ).addClass( "red" );
		});
	 });
	 
});
</script>	



			