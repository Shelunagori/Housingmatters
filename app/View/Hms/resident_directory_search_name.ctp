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

 <?php
 
if(!empty($search_value))
{
		if(!empty($result_usser_flat))
		{
		  foreach($result_usser_flat as $d_user_flat)
		  {
			$result_user22 = $this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'),array('pass'=>array($d_user_flat)));

			foreach ($result_user22 as $collection)            
			{  
				$c_user_id = (int)$collection['user']['user_id'];          
				$c_wing_id = $collection['user']['wing'];
				$c_flat_id = $collection['user']['flat'];
				$c_name = $collection['user']['user_name'];
				$medical_pro = @$collection['user']['medical_pro'];
				$c_name=substrwords($c_name,20,'...');
				@$profile_pic = $collection['user']['profile_pic'];
				
				$f_profile_pic = @$collection['user']['f_profile_pic'];
				$g_profile_pic = @$collection['user']['g_profile_pic'];
						
				$result_user_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_user_flat_active'),array('pass'=>array($c_user_id)));
				foreach($result_user_flat as $data){
				
				
				$user_flat_id=$data['user_flat']['user_flat_id'];
				$flat_id=$data['user_flat']['flat_id'];
				
				if($flat_id==$flat_search){
				$result_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($flat_id)));
				foreach($result_flat as $data2){
					
					$wing_id=$data2['flat']['wing_id'];
				}
								
				$wing_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'),array('pass'=>array($wing_id,$flat_id)));			  
				/*if(empty($profile_pic))
				{
				$profile_pic="blank.jpg"; 
				} */
				?>

				<div class="r_d fadeleftsome" onclick="view_ticket(<?php echo $c_user_id;?>,<?php echo $user_flat_id; ?>)">
				<div class="hv_b" style="overflow: auto;padding: 5px;cursor: pointer;" title="">
				
				
				<?php if(!empty($profile_pic) and $profile_pic!="blank.jpg"){ ?>
				<img src="<?php echo $webroot_path ; ?>/profile/<?php echo $profile_pic; ?>" style="float:left;width:25%;height:80px;"/>
				<?php } elseif(!empty($f_profile_pic)){ ?>
				<img src="<?php echo $f_profile_pic; ?>" style="float:left;width:25%;height:80px;"/>

				<?php } elseif(!empty($g_profile_pic)){ ?>
				<img src="<?php echo $g_profile_pic; ?>" style="float:left;width:25%;height:80px;"/>
				<?php }elseif(empty($g_profile_pic) and empty($f_profile_pic)){ if(empty($profile_pic)){ $profile_pic="blank.jpg"; } ?>  

				<img src="<?php echo $webroot_path ; ?>/profile/<?php echo $profile_pic; ?>" style="float:left;width:25%;height:80px;"/>
				<?php  } ?>
				
				<div style="float:left;margin-left:3%;">
				<span style="font-size:22px;"><?php echo $c_name; ?></span><?php if(@$medical_pro==1){ ?> <span style="float:right;color:red; font-size:18px;"> <i class="icon-plus-sign"></i> </span> <?php } ?> <br/>
				<span style="font-size:16px;"><?php echo $wing_flat ; ?></span>
				</div>
				</div>
				</div>


			  <?php


				} }
			}
			
}			
			
			
			
			
		}
else{

		foreach ($result_user as $collection)            
			{  
				$c_user_id = (int)$collection['user']['user_id'];          
				$c_wing_id = $collection['user']['wing'];
				$c_flat_id = $collection['user']['flat'];
				$c_name = $collection['user']['user_name'];
				$medical_pro = @$collection['user']['medical_pro'];
				$c_name=substrwords($c_name,20,'...');
				@$profile_pic = $collection['user']['profile_pic'];
				
				$f_profile_pic = @$collection['user']['f_profile_pic'];
				$g_profile_pic = @$collection['user']['g_profile_pic'];
				
				
				$result_user_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_user_flat_active'),array('pass'=>array($c_user_id)));
				foreach($result_user_flat as $data){
				
				
				$user_flat_id=$data['user_flat']['user_flat_id'];
				$flat_id=$data['user_flat']['flat_id'];
				
			
				$result_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($flat_id)));
				foreach($result_flat as $data2){
					
					$wing_id=$data2['flat']['wing_id'];
				}
								
				$wing_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'),array('pass'=>array($wing_id,$flat_id)));			  		  
				/*if(empty($profile_pic))
				{
				$profile_pic="blank.jpg"; 
				} */
?>

				<div class="r_d fadeleftsome" onclick="view_ticket(<?php echo $c_user_id;?>,<?php echo $user_flat_id; ?>)">
				<div class="hv_b" style="overflow: auto;padding: 5px;cursor: pointer;" title="">
				
									
				<?php if(!empty($profile_pic) and $profile_pic!="blank.jpg"){ ?>
				<img src="<?php echo $webroot_path ; ?>/profile/<?php echo $profile_pic; ?>" style="float:left;width:25%;height:80px;"/>
				<?php } elseif(!empty($f_profile_pic)){ ?>
				<img src="<?php echo $f_profile_pic; ?>" style="float:left;width:25%;height:80px;"/>

				<?php } elseif(!empty($g_profile_pic)){ ?>
				<img src="<?php echo $g_profile_pic; ?>" style="float:left;width:25%;height:80px;"/>
				<?php }elseif(empty($g_profile_pic) and empty($f_profile_pic)){ if(empty($profile_pic)){ $profile_pic="blank.jpg"; } ?>  

				<img src="<?php echo $webroot_path ; ?>/profile/<?php echo $profile_pic; ?>" style="float:left;width:25%;height:80px;"/>
				<?php  } ?>
				<div style="float:left;margin-left:3%;">
				<span style="font-size:22px;"><?php echo $c_name; ?></span><?php if(@$medical_pro==1){ ?> <span style="float:right;color:red; font-size:18px;"> <i class="icon-plus-sign"></i> </span> <?php } ?> <br/>
				<span style="font-size:16px;"><?php echo $wing_flat ; ?></span>
				</div>
				</div>
				</div>
				 

				<?php

		 
} }
		 if($count_user2 == 0)
						{ ?>
						<center><h4 style="color:#9F2D9F;"><b>No Record Found</b></h4></center>
					<?php	}

	}
}
?>


 <?php
if(empty($search_value))
			{		
		foreach ($result_user3 as $collection)            
			{  
				$c_user_id = (int)$collection['user']['user_id'];          
				$c_wing_id = $collection['user']['wing'];
				$c_flat_id = $collection['user']['flat'];
				$c_name = $collection['user']['user_name'];
				$medical_pro = @$collection['user']['medical_pro'];
				$c_name=substrwords($c_name,20,'...');
				@$profile_pic = $collection['user']['profile_pic'];
				
				$f_profile_pic = @$collection['user']['f_profile_pic'];
				$g_profile_pic = @$collection['user']['g_profile_pic'];
				
				$result_user_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_user_flat_active'),array('pass'=>array($c_user_id)));
				foreach($result_user_flat as $data){
				
				
				$user_flat_id=$data['user_flat']['user_flat_id'];
				$flat_id=$data['user_flat']['flat_id'];
				
			
				$result_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($flat_id)));
				foreach($result_flat as $data2){
					
					$wing_id=$data2['flat']['wing_id'];
				}
								
				$wing_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'),array('pass'=>array($wing_id,$flat_id)));
				
						  
				/*if(empty($profile_pic))
				{
				$profile_pic="blank.jpg"; 
				}*/
?>

<div class="r_d fadeleftsome" onclick="view_ticket(<?php echo $c_user_id;?>,<?php echo $user_flat_id; ?>)">
<div class="hv_b" style="overflow: auto;padding: 5px;cursor: pointer;" title="">

				<?php if(!empty($profile_pic) and $profile_pic!="blank.jpg"){ ?>
				<img src="<?php echo $webroot_path ; ?>/profile/<?php echo $profile_pic; ?>" style="float:left;width:25%;height:80px;"/>
				<?php } elseif(!empty($f_profile_pic)){ ?>
				<img src="<?php echo $f_profile_pic; ?>" style="float:left;width:25%;height:80px;"/>

				<?php } elseif(!empty($g_profile_pic)){ ?>
				<img src="<?php echo $g_profile_pic; ?>" style="float:left;width:25%;height:80px;"/>
				<?php }elseif(empty($g_profile_pic) and empty($f_profile_pic)){ if(empty($profile_pic)){ $profile_pic="blank.jpg"; } ?>  

				<img src="<?php echo $webroot_path ; ?>/profile/<?php echo $profile_pic; ?>" style="float:left;width:25%;height:80px;"/>
				<?php  } ?>
				
<div style="float:left;margin-left:3%;">
<span style="font-size:22px;"><?php echo $c_name; ?></span><?php if(@$medical_pro==1){ ?> <span style="float:right;color:red; font-size:18px;"> <i class="icon-plus-sign"></i> </span> <?php } ?> <br/>
<span style="font-size:16px;"><?php echo $wing_flat ; ?></span>
</div>
</div>
</div>


<?php 
			} } }
?>


