<?php 
function substrwords($text, $maxchar, $end='...') {
    if (strlen($text) > $maxchar || $text == '') {
        $words = preg_split('/\s/', $text);      
        $output = '';
        $i      = 0;
        while (1) {
            @$length = strlen($output)+strlen($words[$i]);
            if ($length > $maxchar) {
                break;
            } 
            else {
                @$output .= " " . $words[$i];
                ++$i;
            }
        }
        $output .= $end;
    } 
    else {
        $output = $text;
    }
    return $output;
}
?>

<div id="back" class="btn blue" >Back</div>
<br>
<div align="center">

 <?php
			foreach ($result_user1 as $collection)            
			{  
				$c_user_id = (int)$collection['user']['user_id'];          
				$c_wing_id = $collection['user']['wing'];
				$d_role_id = $collection['user']['role_id'];
				$tenant = $collection['user']['tenant'];
				$c_flat_id = $collection['user']['flat'];
				$c_email = $collection['user']['email'];
				$c_mobile = $collection['user']['mobile'];
				$c_name = $collection['user']['user_name'];
				$private_field = @$collection['user']['private'];
				$da_dob=@$collection['user']['dob'];
				$per_address=@$collection['user']['per_address'];
				$com_address=@$collection['user']['comm_address'];
				$hobbies=@$collection['user']['hobbies'];
				@$profile_pic = $collection['user']['profile_pic'];
				
				$f_profile_pic = @$collection['user']['f_profile_pic'];
				$g_profile_pic = @$collection['user']['g_profile_pic'];
				
				$medical_pro = @$collection['user']['medical_pro'];
				if(!empty($hobbies)){
					
				foreach($hobbies as $data){
				$hobbies_name[] = $this->requestAction(array('controller' => 'hms', 'action' => 'hobbies_category_fetch'),array('pass'=>array((int)$data)));		
				
				}
				$hobbies=implode(', ',$hobbies_name);
				}				
				if($medical_pro==1)
				{
					$medical="Yes";
				
				}
				if($medical_pro==2)
				{
					$medical="No";
				}
				if(@in_array(1,@$d_role_id))
				{
				$commitee='Yes';
				}
				else
				{
				$commitee='No';
				}
				
				if($tenant==1)
				{
				$owner='Yes';
				}
				else
				{
				$owner='No';
				}
				if($da_dob==1)
				{
				$age_group="18-24";
				}

				if($da_dob==2)
				{
				$age_group="25-34";
				}


				if($da_dob==3)
				{
				$age_group="35-44";
				}

				if($da_dob==4)
				{
				$age_group="45-54";
				}
				if($da_dob==5)
				{
				$age_group="55-64";
				}

				if($da_dob==6)
				{
				$age_group="65+";
				}

				$result_user_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_user_flat_active'),array('pass'=>array($c_user_id)));
				foreach($result_user_flat as $data){
				
				
				$user_flat_id=$data['user_flat']['user_flat_id'];
				$flat_id=$data['user_flat']['flat_id'];
				if($user_flat_id==$user_flat){
			
				$result_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($flat_id)));
				foreach($result_flat as $data2){
					
					$wing_id=$data2['flat']['wing_id'];
				}
								
				$wing_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'),array('pass'=>array(@$wing_id,$flat_id)));		
				}
				}



				
				$result_society = $this->requestAction(array('controller' => 'hms', 'action' => 'society_name'),array('pass'=>array($s_society_id)));			  
				foreach($result_society as $data)
				{
					$society_name=$data['society']['society_name'];
				}				
					
					
					if(@in_array('mobile',$private_field) && $role_id!=3 )
					{
			
						if($user_id==$c_user_id)
						{
						$c_mobile;
						}
						else
						{
						$c_mobile="*";
						
						}
					
					}	
					if(@in_array('email',$private_field) && $role_id!=3)
					{
					
						if($user_id==$c_user_id)
						{
						$c_email;
						}
						else
						{
						$c_email="*";
						}

					}	
					if(@in_array('date',$private_field) && $role_id!=3)
					{
						if($user_id==$c_user_id)
						{
						$age_group;
						}
						else
						{
						$age_group="*";
						}
					
					}	
					if(@in_array('per_address',$private_field) && $role_id!=3)
					{
						if($user_id==$c_user_id)
						{
						$per_address;
						}
						else
						{
						$per_address="*";
						}
					}
					if(@in_array('com_address',$private_field) && $role_id!=3)
					{
						if($user_id==$c_user_id)
						{
						$com_address;
						}
						else
						{
						$com_address="*";
						}
						
					}					
					if(@in_array('hobi',$private_field) && $role_id!=3)
					{
						if($user_id==$c_user_id)
						{
						$hobbies;
						}
						else
						{
						$hobbies="*";
						}
						
					}
				/*if(empty($profile_pic))
				{
				$profile_pic="blank.jpg"; 
				}*/
?>

 <div class="portlet-body" style="width:65%;">
								<table class="table table-striped table-bordered table-advance table-hover">
									<thead>
										
									</thead>
									<tbody>
										<tr>
											<td rowspan="4" width="30%"  valign="top">
                                            
                                   
<?php if(!empty($profile_pic) and $profile_pic!="blank.jpg"){ ?>
<img src="<?php echo $webroot_path ; ?>/profile/<?php echo $profile_pic; ?>" style="width:100%; height:160px;">
<?php } elseif(!empty($f_profile_pic)){ ?>
<img src="<?php echo $f_profile_pic ; ?>" style="width:100%; height:160px;">
	
<?php } elseif(!empty($g_profile_pic)){ ?>
<img src="<?php echo $g_profile_pic ; ?>" style="width:100%; height:160px;">
<?php } elseif(empty($g_profile_pic) and empty($f_profile_pic)){ if(empty($profile_pic)){ $profile_pic="blank.jpg"; } ?>
<img src="<?php echo $webroot_path ; ?>/profile/<?php echo $profile_pic; ?>" style="width:100%; height:160px;"> <?php } ?>         
                                             
                                            </td>
											<td><label>Name</label></td>
											<td class="hidden-phone">&nbsp&nbsp<?php echo $c_name; ?></td>
											
											
										</tr>
										<tr>
											<td><label>Unit</label></td>
											<td class="hidden-phone">&nbsp&nbsp<?php echo $wing_flat ; ?></td>
											
										</tr>
										
										<tr>
											<td><label>Mobile</label></td>
											<td class="hidden-phone">&nbsp&nbsp<?php echo  $c_mobile; ?></td>
											
										</tr>
										
										<tr>
											<td><label>Email</label></td>
											<td class="hidden-phone">&nbsp&nbsp<?php echo $c_email; ?> </td>
											
										</tr>
										
									</tbody>
								</table>
                                
                                <br>
                                <div>
                                <p style="font-size:18px; color:#666;">Other Information</p>
                                </div>
                                
                                <table class="table table-striped table-bordered table-advance table-hover">
									<thead>
										
									</thead>
									<tbody>
										<tr>
                                        <td width="20%">
                                        </td>
										<td width="30%">
										<p style=" font-size:14px; color:#666;">Commitee Member</p>	
                                        </td>
										<td width="20%">
                                        </td>
                                        <td class="hidden-phone" width="30%">
										<?php echo $commitee ; ?>
                                        </td>
											
											
										</tr>
										<tr>
                                        <td width="20%">
                                        </td>
										<td width="30%">
										<p style=" font-size:14px; color:#666;">Owner</p>	
                                        </td>
										<td width="20%">
                                        </td>
                                        <td class="hidden-phone" width="30%">
										<?php echo $owner ; ?>
                                        </td>
											
											
										</tr>
										
										<tr>
                                        <td width="20%">
                                        </td>
										<td width="30%">
										<p style=" font-size:14px; color:#666;">Society</p>	
                                        </td>
										<td width="20%">
                                        </td>
                                        <td class="hidden-phone" width="30%">
										<?php echo $society_name ; ?>
                                        </td>
											
											
										</tr>
										
										<tr>
                                        <td width="20%">
                                        </td>
										<td width="30%">
										<p style=" font-size:14px; color:#666;">Age Group</p>	
                                        </td>
										<td width="20%">
                                        </td>
                                        <td class="hidden-phone" width="30%">
										<?php echo @$age_group ; ?>
                                        </td>
											
											
										</tr>
										
										<?php if($role_id==3) { ?>
										<tr>
                                        <td width="20%">
                                        </td>
                                        <td width="30%">
										<p style=" font-size:14px; color:#666;">Permanent address:	</p>
										</td>
										<td width="20%">
                                        </td>	
									    <td class="hidden-phone" width="30%">
										<?php echo $per_address; ?>
                                        </td>
											
										</tr> 
										
										
										<tr>
										<td width="20%">
                                        </td>	
                                        <td>
										<p style=" font-size:14px; color:#666;">Communication address:</p>
										</td>
										<td width="20%">
                                        </td>
                                        <td class="hidden-phone" width="30%">
										<?php echo $com_address; ?>
                                        </td>
											
										</tr> <?php } ?>
										
										
										<tr>
										<td width="20%">
                                        </td>	
                                        <td>
										<p style=" font-size:14px; color:#666;">Hobbies:</p>
										</td>
										<td width="20%">
                                        </td>
                                        <td class="hidden-phone" width="30%">
										<?php echo $hobbies; ?>
                                        </td>
											
										</tr>
										
										<?php if(@$medical_pro==1){ ?><tr>
										<td width="20%">
                                        </td>	
                                        <td>
										<p style=" font-size:14px; color:#666;">Medical Profession</p>
										
										</td>
										<td width="20%">
                                        </td>
                                        <td class="hidden-phone" width="30%">
										<?php echo @$medical; ?>
                                        </td>
											
										</tr>
										<?php } ?>
										
									</tbody>
								</table>
							</div>

<?php 
}
?>
</div>